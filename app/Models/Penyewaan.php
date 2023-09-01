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

    public function createAtDiffForHumans()
    {
        return Carbon::createFromTimestamp($this->created_at)->locale('id')->diffForHumans();
        // return $this->createdAt;
    }

    public function tanggal_mulai_at_dMY()
    {
        return Carbon::parse($this->tanggal_mulai)->locale('id')->format('d-M-Y');
    }
    public function tanggal_selesai_at_dMY()
    {
        return Carbon::parse($this->tanggal_selesai)->locale('id')->format('d-M-Y');
    }
    public function tanggal_selesai_at_ldFY()
    {
        return Carbon::parse($this->tanggal_selesai)->locale('id')->isoFormat('dddd, D MMMM YYYY');
    }
}
