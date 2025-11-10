<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactTag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['name'];
    public function contacts() {
        return $this->belongsToMany(Contact::class, 'contact_contact_tag');
    }
}
