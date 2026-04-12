<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reversion extends Model
{
    protected $fillable = [
        'borrowing_id',
        'notes',
        'status',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
