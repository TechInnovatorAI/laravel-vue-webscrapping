<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolRound extends Model
{
    use HasFactory;

    /**
     * Get the pool that owns the PoolRound
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    /**
     * Get all of the pool_round_matches for the PoolRound
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pool_round_matches()
    {
        return $this->hasMany(PoolRoundMatch::class);
    }

    /**
     * Get all of the pool_round_records for the PoolRound
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pool_round_records()
    {
        return $this->hasMany(PoolRoundRecord::class);
    }

}
