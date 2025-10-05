<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyFeatureCatalog extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'portal_key', 'description'];

    public function features(): HasMany
    {
        return $this->hasMany(PropertyFeature::class, 'feature_catalog_id');
    }
}
