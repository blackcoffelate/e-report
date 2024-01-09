<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Mitra extends Model
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $table = 'mitras';

    protected $fillable = [
      'type',
      'marketing',
      'tanggal',
      'bulan',
      'tahun',
      'mitra',
      'telepon',
      'alamat',
    ];

    public $incrementing = true;
}
