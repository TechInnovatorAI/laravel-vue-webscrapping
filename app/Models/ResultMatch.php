<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultMatch extends Model
{
    use HasFactory;

    public function result_tournament(){
        return $this->belongsTo(ResultTournament::class);
    }
}
