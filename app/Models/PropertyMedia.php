<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyMedia extends Model
{
    protected $fillable = [
        'property_id',
        'file_path',
        'type',
        'disk',
        'order',
        'caption',
        'is_primary',
        'conversions',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'conversions' => 'array',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
