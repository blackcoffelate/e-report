<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class FollowUp extends Model
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
      'type',
      'marketing',
      'tanggal',
      'bulan',
      'tahun',
      'customer',
      'telepon',
      'keterangan',
    ];
}
