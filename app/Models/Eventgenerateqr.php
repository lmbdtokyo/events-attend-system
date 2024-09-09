<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventgenerateqr extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'number',
        'pdf_path'
    ];

}
