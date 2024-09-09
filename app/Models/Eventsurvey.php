<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventsurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'qa'
    ];

    protected $casts = [
        'qa' => 'json'
    ];

}
