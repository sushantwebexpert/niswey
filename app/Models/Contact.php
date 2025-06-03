<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Contact extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'contacts';

    protected $fillable = [
        'name',
        'phone',
        'user_id',  // Add user_id here
    ];

    // Optional: relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
