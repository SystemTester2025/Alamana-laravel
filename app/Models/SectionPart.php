<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectionPart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'sub',
        'desc',
        'section_id',
        'image',
        'key',
        'value',
        'sort_order',
    ];

    /**
     * Get the section that owns the section part.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
