<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class JenisMitra extends Model
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
      'jenis_mitra',
    ];

    protected $attributes = [
      'keterangan' => 'Tidak ada keterangan',
    ];
}
