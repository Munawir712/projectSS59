<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KosanFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'kosan_id',
        'facility_id',
        'name',
        'slug',
        'desc',
    ];

    public function kosan()
    {
        return $this->belongsTo(Kosan::class, 'kosan_id');
    }

    public function facility()
    {
        return $this->belongsTo(Kosan::class, 'facility');
    }
}
