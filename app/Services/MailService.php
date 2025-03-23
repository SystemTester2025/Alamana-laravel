<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MailService
{
    /**
     * Send an email message using the site's email settings
     *
     * @param string $to Recipient email address
     * @param string $subject Subject of the email
     * @param string $message Message content (HTML format)
     * @param array $attachments Array of file paths or uploaded files
     * @param string|null $cc CC email addresses (comma separated)
     * @param string|null $bcc BCC email addresses (comma separated)
     * @param bool $saveToContacts Whether to save the message to contacts table
     * @return bool|Contact Returns Contact model if $saveToContacts is true, otherwise returns boolean
     */
    public static function send($to, $subject, $message, $attachments = [], $cc = null, $bcc = null, $saveToContacts = true)
    {
        // Get site settings
        $settings = Setting::first();
        $fromEmail = $settings->email ?? config('mail.from.address');
        $fromName = $settings->title ?? config('mail.from.name');
        
        // Process attachments
        $attachmentsPaths = [];
        $storedAttachments = [];
        
        foreach ($attachments as $attachment) {
            if (is_object($attachment) && method_exists($attachment, 'getClientOriginalName')) {
                // Handle uploaded file
                $filename = time() . '_' . Str::slug(pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME)) 
                    . '.' . $attachment->getClientOriginalExtension();
                
                $path = $attachment->storeAs('attachments', $filename, 'public');
                $attachmentsPaths[] = storage_path('app/public/' . $path);
                $storedAttachments[] = $path;
            } else if (is_string($attachment) && file_exists($attachment)) {
                // Handle file path
                $attachmentsPaths[] = $attachment;
                $storedAttachments[] = $attachment;
            }
        }

        try {
            // Send the email
            Mail::send([], [], function ($mail) use ($to, $subject, $message, $fromEmail, $fromName, $cc, $bcc, $attachmentsPaths) {
                $mail->to($to)
                    ->from($fromEmail, $fromName)
                    ->subject($subject)
                    ->setBody($message, 'text/html');
                
                // Add CC if provided
                if (!empty($cc)) {
                    $ccAddresses = explode(',', $cc);
                    $mail->cc($ccAddresses);
                }
                
                // Add BCC if provided
                if (!empty($bcc)) {
                    $bccAddresses = explode(',', $bcc);
                    $mail->bcc($bccAddresses);
                }
                
                // Add attachments if any
                foreach ($attachmentsPaths as $path) {
                    $mail->attach($path);
                }
            });
            
            // Save to contacts table if needed
            if ($saveToContacts) {
                $contact = new Contact();
                $contact->name = $fromName;
                $contact->email = $to;
                $contact->subject = $subject;
                $contact->message = $message;
                $contact->is_read = true;
                $contact->message_type = 'outgoing';
                $contact->status = 'sent';
                $contact->attachments = $storedAttachments;
                $contact->cc = $cc;
                $contact->bcc = $bcc;
                $contact->save();
                
                return $contact;
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Reply to a contact message
     *
     * @param Contact $contact The contact to reply to
     * @param string $message The reply message content (HTML format)
     * @param array $attachments Array of file paths or uploaded files
     * @param string|null $cc CC email addresses (comma separated)
     * @param string|null $bcc BCC email addresses (comma separated)
     * @return bool Success status
     */
    public static function reply(Contact $contact, $message, $attachments = [], $cc = null, $bcc = null)
    {
        $result = self::send(
            $contact->email,
            'Re: ' . $contact->subject,
            $message,
            $attachments,
            $cc,
            $bcc,
            true // Save to contacts
        );
        
        if ($result !== false) {
            // Update the original contact
            $contact->is_replied = true;
            $contact->reply_message = $message;
            $contact->reply_date = now();
            $contact->save();
            
            return true;
        }
        
        return false;
    }
} 