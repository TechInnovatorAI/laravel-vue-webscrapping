<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    public function result_tournaments(){
        return $this->hasMany(ResultTournament::class);
    }
    public function tournaments(){
        return $this->belongsTo(Tournament::class, 'tournament_type');
    }
}
