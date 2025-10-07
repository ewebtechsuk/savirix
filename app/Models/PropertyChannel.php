<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PropertyChannel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'handler', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_channel_property')
            ->withPivot(['status', 'payload', 'last_synced_at'])
            ->withTimestamps();
    }
}
