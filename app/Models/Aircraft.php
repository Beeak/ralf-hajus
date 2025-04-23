<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'type',
        'aircraft_type',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        return asset('storage/images/api/' . $this->image);
    }
}
