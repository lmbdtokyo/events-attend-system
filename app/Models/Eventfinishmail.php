<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventfinishmail extends Model
{
    use HasFactory;

    protected $table = 'eventfinishmail';

    protected $fillable = [
        'event_id',
        'bcc',
        'title',
        'text'
    ];

}
