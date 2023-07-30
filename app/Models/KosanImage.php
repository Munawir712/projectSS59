<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KosanImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'kosan_id',
        'filename',
        'image_url',
    ];

    public function kosan()
    {
        return $this->belongsTo(Kosan::class, 'kosan_id');
    }
}
