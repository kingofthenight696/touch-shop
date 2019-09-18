<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = ['coordinates'];

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

    public function setCoordinatesAttribute($value)
    {
        return json_encode($value);
    }

    public function getCoordinatesAttribute($value)
    {
        return json_decode($value, true);
    }
}
