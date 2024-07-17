<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolRoundMatch extends Model
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

    public function player1_info(){
        return $this->belongsTo(PoolRoundRecord::class, 'player1_id');
    }
    
    public function player2_info(){
        return $this->belongsTo(PoolRoundRecord::class, 'player2_id');
    }
}
