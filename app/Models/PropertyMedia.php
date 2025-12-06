<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PropertyMedia extends Model
{
    protected $fillable = [
        'property_id',
        'media_type',
        'media_url',
        'file_path',
        'type',
        'order',
        'is_featured',
    ];

    protected $attributes = [
        'media_type' => 'photo',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function getUrlAttribute(): ?string
    {
        if ($this->media_url) {
            return $this->media_url;
        }

        if (! $this->file_path) {
            return null;
        }

        return Storage::disk('public')->url($this->file_path);
    }
}
