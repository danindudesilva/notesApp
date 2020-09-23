<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id'
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

