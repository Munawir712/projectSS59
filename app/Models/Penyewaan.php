<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penyewa() 
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function kamarkos()
    {
        return $this->hasOne(KamarKos::class, 'id', 'kamarkos_id');
    }

}
