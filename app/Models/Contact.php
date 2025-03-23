<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location_url',
        'location_title',
        'name',
        'email',
        'subject',
        'message',
        'is_read',
        'is_replied',
        'reply_message',
        'reply_date',
        'message_type', // 'incoming' or 'outgoing'
        'status',       // 'received', 'sent', 'draft', 'trash'
        'attachments',  // JSON field to store attachment paths
        'cc',
        'bcc',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_read' => 'boolean',
        'is_replied' => 'boolean',
        'reply_date' => 'datetime',
        'attachments' => 'array',
    ];

    /**
     * Check if the contact message is incoming
     *
     * @return bool
     */
    public function isIncoming()
    {
        return $this->message_type === 'incoming';
    }

    /**
     * Check if the contact message is outgoing
     *
     * @return bool
     */
    public function isOutgoing()
    {
        return $this->message_type === 'outgoing';
    }
}
