<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventrecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'applicant_id',
        'entry_exit',
        'user_id'
    ];
}
