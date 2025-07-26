<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'number', 'date', 'contact_id', 'property_id', 'amount', 'status', 'due_date', 'notes'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
