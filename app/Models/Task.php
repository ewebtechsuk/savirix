<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 'description', 'due_date', 'status', 'taskable_id', 'taskable_type', 'user_id'
    ];

    public function taskable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
