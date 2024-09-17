<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evententrymail extends Model
{
    use HasFactory;

    protected $table = 'evententrymail';

    protected $fillable = [
        'event_id',
        'bcc',
        'title',
        'text'
    ];
}
