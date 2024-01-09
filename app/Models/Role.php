<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Role extends Model
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
      'role',
      'guard_name',
      'author',
    ];
}
