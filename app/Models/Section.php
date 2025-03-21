<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
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
        'key',
    ];

    /**
     * Get the section parts for the section.
     */
    public function sectionParts(): HasMany
    {
        return $this->hasMany(SectionPart::class);
    }
}
