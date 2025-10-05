<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactCommunication extends Model
{
    protected $fillable = [
        'contact_id',
        'user_id',
        'communication',
        'channel',
        'subject',
        'provider',
        'provider_message_id',
        'status',
        'delivered_at',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'delivered_at' => 'datetime',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
