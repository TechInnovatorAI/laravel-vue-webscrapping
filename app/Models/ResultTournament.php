<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultTournament extends Model
{
    use HasFactory;

    public function result(){
        return $this->belongsTo(Result::class);
    }

    public function matches(){
        return $this->hasMany(ResultMatch::class);
    }
}
