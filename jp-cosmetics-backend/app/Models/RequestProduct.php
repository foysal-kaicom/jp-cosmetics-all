<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestProduct extends Model
{
    protected $table = 'product_requests';
    protected $guarded = [];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
