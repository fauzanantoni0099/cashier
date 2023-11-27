<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name_customer','code','order_date','phone','address','notes','returned','pay','total_amount','status'
    ];
    public function ServiceDetails()
    {
        return $this->hasMany(ServiceDetail::class);
    }
    public function serviceNames()
    {
        return $this->belongsToMany(ServiceName::class, 'service_details')->withPivot('quantity');
    }
}
