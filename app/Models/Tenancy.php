<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenancy extends Model
{
    protected $fillable = [
        'property_id', 'contact_id', 'start_date', 'end_date', 'rent', 'status', 'notes'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
