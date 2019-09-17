<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'coordinates',
        'title',
        'description',
        'price',
        'board_id',
        'created_at',
        'updated_at',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

}
