<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    public function official_ranking(){
        return $this->hasOne(OfficialRanking::class);
    }
    
    public function ranking1(){
        return $this->hasOne(Ranking1::class);
    }

    public function ranking2(){
        return $this->hasOne(Ranking2::class);
    }
}
