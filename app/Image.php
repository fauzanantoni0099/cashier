<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'name_path','imageable_id','imageable_type'
    ];

    public function image()
    {
        return $this->morphTo();
    }
}
