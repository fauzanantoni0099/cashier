<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name','description'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
