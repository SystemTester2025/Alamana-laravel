<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs
     */
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        // Filter by search term
        if ($request->has('search') && $request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by model type
        if ($request->has('model_type') && $request->model_type) {
            $query->where('model_type', $request->model_type);
        }

        // Get unique action types for filter
        $actions = ActivityLog::distinct()->pluck('action')->toArray();

        // Get unique model types for filter
        $modelTypes = ActivityLog::distinct()->pluck('model_type')->filter()->toArray();

        // Get logs with pagination
        $logs = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('backend.activity_logs.index', compact('logs', 'actions', 'modelTypes'));
    }

    /**
     * Display the specified activity log
     */
    public function show(ActivityLog $activityLog)
    {
        return view('backend.activity_logs.show', compact('activityLog'));
    }

    /**
     * Clear all activity logs
     */
    public function clear()
    {
        ActivityLog::truncate();

        return redirect()->route('activity-logs.index')
            ->with('success', 'تم مسح سجل النشاطات بنجاح');
    }
} 