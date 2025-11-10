<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyFeature extends Model
{
    protected $fillable = ['property_id', 'name', 'value'];
    public function property() {
        return $this->belongsTo(Property::class);
    }
}
