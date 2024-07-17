<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    /**
     * Get the draws that owns the Record
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function draws()
    {
        return $this->hasMany(Draw::class);
    }

    
}
