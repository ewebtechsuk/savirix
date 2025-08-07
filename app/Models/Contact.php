<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'name', 'email', 'phone', 'address', 'notes', 'first_name', 'last_name'
    ];

    public function groups()
    {
        return $this->belongsToMany(ContactGroup::class, 'contact_contact_group');
    }
    public function tags()
    {
        return $this->belongsToMany(ContactTag::class, 'contact_contact_tag');
    }
    public function properties()
    {
        // A landlord can have many properties where they are the landlord
        return $this->hasMany(Property::class, 'landlord_id');
    }
    public function notes()
    {
        return $this->hasMany(ContactNote::class);
    }
    public function communications()
    {
        return $this->hasMany(ContactCommunication::class);
    }
    public function viewings()
    {
        return $this->hasMany(ContactViewing::class);
    }
}
