<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;

    /**
     * Get the record that owns the Pool
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function record()
    {
        return $this->belongsTo(Record::class);
    }

    /**
     * Get all of the pool_rounds for the Pool
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pool_rounds()
    {
        return $this->hasMany(PoolRound::class);
    }
}
