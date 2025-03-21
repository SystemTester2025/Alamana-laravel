<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log an activity
     *
     * @param string $action The action performed (create, update, delete, etc.)
     * @param string $description A description of the activity
     * @param Model|null $model The model that was affected
     * @param array|null $beforeDetails Data before the change
     * @param array|null $afterDetails Data after the change
     * @return ActivityLog
     */
    public static function log(
        string $action, 
        string $description, 
        ?Model $model = null, 
        ?array $beforeDetails = null, 
        ?array $afterDetails = null
    ): ActivityLog {
        $user = Auth::user();
        
        return ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'System',
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'description' => $description,
            'before_details' => $beforeDetails,
            'after_details' => $afterDetails,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent()
        ]);
    }
    
    /**
     * Log a model creation
     *
     * @param Model $model The created model
     * @param string $description A description of the creation
     * @return ActivityLog
     */
    public static function logCreated(Model $model, string $description = ''): ActivityLog
    {
        if (empty($description)) {
            $modelName = class_basename($model);
            $description = "{$modelName} created";
        }
        
        return self::log(
            'create',
            $description,
            $model,
            null,
            $model->toArray()
        );
    }
    
    /**
     * Log a model update
     *
     * @param Model $model The updated model
     * @param array $oldAttributes The attributes before update
     * @param string $description A description of the update
     * @return ActivityLog
     */
    public static function logUpdated(Model $model, array $oldAttributes, string $description = ''): ActivityLog
    {
        if (empty($description)) {
            $modelName = class_basename($model);
            $description = "{$modelName} updated";
        }
        
        return self::log(
            'update',
            $description,
            $model,
            $oldAttributes,
            $model->toArray()
        );
    }
    
    /**
     * Log a model deletion
     *
     * @param Model $model The deleted model
     * @param string $description A description of the deletion
     * @return ActivityLog
     */
    public static function logDeleted(Model $model, string $description = ''): ActivityLog
    {
        if (empty($description)) {
            $modelName = class_basename($model);
            $description = "{$modelName} deleted";
        }
        
        return self::log(
            'delete',
            $description,
            $model,
            $model->toArray(),
            null
        );
    }
    
    /**
     * Log a custom action
     *
     * @param string $action The action performed
     * @param string $description A description of the action
     * @param array|null $data Additional data to log
     * @return ActivityLog
     */
    public static function logCustom(string $action, string $description, ?array $data = null): ActivityLog
    {
        return self::log($action, $description, null, null, $data);
    }
} 