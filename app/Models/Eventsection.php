<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventsection extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'section',
    ];

    protected $casts = [
        'section' => 'json',
    ];
}
