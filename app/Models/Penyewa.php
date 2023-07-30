<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Penyewa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone_number',
        'jenis_kelamin',
        'foto_ktp',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // public function getFotoKtpAttribute()
    // {
    //     if ($this->attributes['foto_ktp'] != null) {

    //         return url('') . Storage::url($this->attributes['foto_ktp']);
    //     }
    //     return null;
    // }
}
