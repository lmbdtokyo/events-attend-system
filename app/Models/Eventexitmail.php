<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventexitmail extends Model
{
    use HasFactory;

    protected $table = 'eventexitmail';

    protected $fillable = [
        'event_id',
        'bcc',
        'title',
        'text'
    ];
}
