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
        'jenis',
        'kategori_jk',
        'harga_bulanan',
        'max_orang',
    ];

    public function kosanImage()
    {
        return $this->hasMany(KosanImage::class, 'kosan_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'kosan_facilities', 'kosan_id', 'facility_id');
    }
}
