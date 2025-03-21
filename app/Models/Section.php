<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'title',
        'sub',
        'desc',
        'key',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * Auto-generate slug from name before saving
         */
        static::creating(function ($section) {
            if (!$section->slug) {
                $section->slug = Str::slug($section->name);
            }
        });

        static::updating(function ($section) {
            if ($section->isDirty('name') && !$section->isDirty('slug')) {
                $section->slug = Str::slug($section->name);
            }
        });
    }
    
    /**
     * Get the section parts for the section.
     */
    public function sectionParts(): HasMany
    {
        return $this->hasMany(SectionPart::class);
    }
}
