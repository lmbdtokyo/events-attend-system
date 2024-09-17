<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usersorganization extends Model
{
    use HasFactory;
    protected $table = 'usersorganization';
    protected $fillable = [
        "id",
        'name',
        "updated_at",
        "created_at",
    ]; 
}
