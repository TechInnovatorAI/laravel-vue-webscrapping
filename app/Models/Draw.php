<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    use HasFactory;

    /**
     * Get all of the draw for the Draw
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function draw()
    {
        return $this->belongsTo(Draw::class);
    }

    /**
     * Get all of the pools for the Record
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pools()
    {
        return $this->hasMany(Pool::class);
    }
}
