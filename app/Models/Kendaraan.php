<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $collection = "kendaraans";

    protected $fillable = [
        'tahun_keluaran',
        'warna',
        'harga',
        'mobil',
        'motor',
    ];

    public function mobil()
    {
        return $this->hasMany(Mobil::class);
    }

    public function motor()
    {
        return $this->hasMany(Motor::class);
    }
}
