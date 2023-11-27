<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name_customer','code','notes','order_date','total_amount','returned','status','pay'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details')->withPivot(['quantity']);
    }
    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
