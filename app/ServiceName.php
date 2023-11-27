<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceName extends Model
{
    protected $fillable = [
        'name','description','price'
    ];
}
