<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    protected $fillable = [
      'service_id','service_name_id','subtotal','quantity'
    ];
    public function services()
    {
        return $this->belongsTo(Service::class);
    }
    public function serviceName()
    {
        return $this->belongsTo(ServiceName::class);
    }
}
