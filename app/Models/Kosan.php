<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kosan extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];


    protected $fillable = [
        'no_kamar',
        'name',
        'alamat',
        'tipe',
        'gender_category',
        'category',
        'harga',
        'max_orang',
        'jumlah_kos',
        'latitude',
        'longitude',
        'description',
    ];

    public function kosanImage()
    {
        return $this->hasMany(KosanImage::class, 'kosan_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'kosan_facilities', 'kosan_id', 'facility_id');
    }

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class, 'kosan_id');
    }
}
