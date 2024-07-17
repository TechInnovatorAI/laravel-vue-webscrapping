<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolRoundRecord extends Model
{
    use HasFactory;

    /**
     * Get the pool_round that owns the PoolRoundMatch
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pool_round()
    {
        return $this->belongsTo(PoolRound::class);
    }
}
