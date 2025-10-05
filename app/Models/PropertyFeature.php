<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyFeature extends Model
{
    protected $fillable = [
        'property_id',
        'feature_catalog_id',
        'name',
        'value',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function catalog()
    {
        return $this->belongsTo(PropertyFeatureCatalog::class, 'feature_catalog_id');
    }
}
