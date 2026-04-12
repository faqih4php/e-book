<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'book_id',
        'user_id',
        'borrow_date',
        'return_date',
        'notes',
        'status',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reversion()
    {
        return $this->hasOne(Reversion::class);
    }
}
