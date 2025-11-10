<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyTimeline extends Model
{
    protected $fillable = ['property_id', 'user_id', 'event_type', 'description', 'date'];
    public function property() {
        return $this->belongsTo(Property::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
