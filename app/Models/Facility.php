<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Facility extends Model
{
    use HasFactory, Sluggable;

    protected $hidden = ['pivot'];

    protected $table = 'facilities';

    protected $fillable = [
        'name',
        'slug',
        'desc',
    ];

    public function kosan()
    {
        return $this->belongsToMany(Kos::class, 'kosan_facilities', 'facility_id', 'kosan_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
