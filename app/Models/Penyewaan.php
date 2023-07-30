<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penyewa()
    {
        return $this->hasOne(Penyewa::class, 'id', 'penyewa_id');
    }

    public function kosan()
    {
        return $this->hasOne(Kosan::class, 'id', 'kosan_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
