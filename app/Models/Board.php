<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = [
        'image',
        'preview',
        'author_id',
        'last_editor_id',
        'created_at',
        'updated_at',
    ];

    public function author()
    {
        return $this->hasOne(User::class, 'author_id');
    }

    public function lastEditor()
    {
        return $this->hasOne(User::class, 'last_editor_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
