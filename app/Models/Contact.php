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
    ];
}
