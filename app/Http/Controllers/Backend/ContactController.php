<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use App\Services\ActivityLogService;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    /**
     * Display a listing of messages with inbox/outbox functionality.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');
        $search = $request->input('search');
        $sort = $request->input('sort', 'latest');
        
        $query = Contact::query();
        
        // Apply filter
        switch ($filter) {
            case 'incoming':
                $query->where('message_type', 'incoming');
                break;
                
            case 'outgoing':
                $query->where('message_type', 'outgoing');
                break;
                
            case 'unread':
                $query->where('is_read', false)
                      ->where('message_type', 'incoming');
                break;
                
            case 'read':
                $query->where('is_read', true)
                      ->where('message_type', 'incoming');
                break;
                
            case 'replied':
                $query->where('is_replied', true)
                      ->where('message_type', 'incoming');
                break;
                
            case 'trash':
                $query->where('status', 'trash');
                break;
                
            default: // all
                break;
        }
        
        // Apply search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
        
        // Apply sort
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
                
            case 'a-z':
                $query->orderBy('subject', 'asc');
                break;
                
            case 'z-a':
                $query->orderBy('subject', 'desc');
                break;
                
            default: // latest
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $messages = $query->paginate(15);
        
        // Count statistics
        $stats = [
            'all' => Contact::count(),
            'incoming' => Contact::where('message_type', 'incoming')->count(),
            'outgoing' => Contact::where('message_type', 'outgoing')->count(),
            'unread' => Contact::where('is_read', false)->where('message_type', 'incoming')->count(),
            'trash' => Contact::where('status', 'trash')->count()
        ];
        
        return view('backend.contacts.index', compact('messages', 'filter', 'search', 'sort', 'stats'));
    }

    /**
     * Show the form for creating/composing a new message.
     */
    public function create()
    {
        $settings = Setting::first();
        return view('backend.contacts.create', compact('settings'));
    }

    /**
     * Send a new email message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
            'cc' => 'nullable|string',
            'bcc' => 'nullable|string',
        ]);
        
        $attachments = $request->file('attachments') ?? [];
        
        $result = MailService::send(
            $validated['to'],
            $validated['subject'],
            $validated['message'],
            $attachments,
            $validated['cc'] ?? null,
            $validated['bcc'] ?? null
        );
        
        if ($result) {
            ActivityLogService::logCreated($result, "تم إرسال رسالة بريد إلكتروني جديدة");
            return redirect()->route('contacts.index')->with('success', 'تم إرسال الرسالة بنجاح');
        } else {
            return back()->withInput()->with('error', 'فشل في إرسال الرسالة، يرجى المحاولة مرة أخرى');
        }
    }

    /**
     * Display the email message details.
     */
    public function show(string $id)
    {
        $message = Contact::findOrFail($id);
        
        // Mark as read if incoming and unread
        if ($message->message_type === 'incoming' && !$message->is_read) {
            $message->is_read = true;
            $message->save();
            
            ActivityLogService::logUpdated($message, ['is_read' => false], "تم قراءة رسالة التواصل");
        }
        
        return view('backend.contacts.show', compact('message'));
    }

    /**
     * Reply to an email message.
     */
    public function reply(Request $request, string $id)
    {
        $message = Contact::findOrFail($id);
        
        $validated = $request->validate([
            'reply_message' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
            'cc' => 'nullable|string',
            'bcc' => 'nullable|string',
        ]);
        
        $attachments = $request->file('attachments') ?? [];
        
        $result = MailService::reply(
            $message,
            $validated['reply_message'],
            $attachments,
            $validated['cc'] ?? null,
            $validated['bcc'] ?? null
        );
        
        if ($result) {
            ActivityLogService::logUpdated($message, ['is_replied' => false], "تم الرد على رسالة التواصل");
            return redirect()->route('contacts.show', $message->id)->with('success', 'تم إرسال الرد بنجاح');
        } else {
            return back()->withInput()->with('error', 'فشل في إرسال الرد، يرجى المحاولة مرة أخرى');
        }
    }

    /**
     * Toggle read status for a message.
     */
    public function toggleRead(string $id)
    {
        $message = Contact::findOrFail($id);
        $message->is_read = !$message->is_read;
        $message->save();
        
        ActivityLogService::logUpdated($message, ['is_read' => !$message->is_read], "تم تغيير حالة القراءة للرسالة");
        
        return redirect()->back()->with('success', 'تم تحديث حالة الرسالة');
    }

    /**
     * Move message to trash.
     */
    public function trash(string $id)
    {
        $message = Contact::findOrFail($id);
        $message->status = 'trash';
        $message->save();
        
        ActivityLogService::logUpdated($message, ['status' => $message->status], "تم نقل الرسالة إلى سلة المهملات");
        
        return redirect()->route('contacts.index')->with('success', 'تم نقل الرسالة إلى سلة المهملات');
    }

    /**
     * Restore message from trash.
     */
    public function restore(string $id)
    {
        $message = Contact::findOrFail($id);
        
        if ($message->message_type === 'incoming') {
            $message->status = 'received';
        } else {
            $message->status = 'sent';
        }
        
        $message->save();
        
        ActivityLogService::logUpdated($message, ['status' => 'trash'], "تم استعادة الرسالة من سلة المهملات");
        
        return redirect()->route('contacts.index')->with('success', 'تم استعادة الرسالة بنجاح');
    }

    /**
     * Permanently delete the specified message.
     */
    public function destroy(string $id)
    {
        $message = Contact::findOrFail($id);
        
        // Delete attachments if any
        if (!empty($message->attachments)) {
            foreach ($message->attachments as $attachment) {
                Storage::disk('public')->delete($attachment);
            }
        }
        
        $message->delete();
        
        ActivityLogService::logDeleted($message, "تم حذف رسالة التواصل نهائيًا");
        
        return redirect()->route('contacts.index')->with('success', 'تم حذف الرسالة نهائيًا');
    }
    
    /**
     * Empty trash (delete all trash messages permanently).
     */
    public function emptyTrash()
    {
        $trashMessages = Contact::where('status', 'trash')->get();
        
        foreach ($trashMessages as $message) {
            // Delete attachments if any
            if (!empty($message->attachments)) {
                foreach ($message->attachments as $attachment) {
                    Storage::disk('public')->delete($attachment);
                }
            }
            
            $message->delete();
        }
        
        ActivityLogService::logCustom('delete', "تم إفراغ سلة المهملات");
        
        return redirect()->route('contacts.index')->with('success', 'تم إفراغ سلة المهملات بنجاح');
    }
}
