<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded=[];

    const PENDING='pending';
    const PROCESSING='processing';
    const CANCEL='cancel';
    const FAILED='failed';
    const SUCCESS='success';
    const REFUNDED='refunded';
    const CONFIRM='confirm';
    const DISPATCHED='dispatched';
    const DELIVERED='delivered';
    const RETURNED='returned';
    const CANCELLED='cancelled';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function address()
    {
        return $this->belongsTo(CustomerAddress::class, 'customer_address_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function activities()
    {
        return $this->hasMany(OrderActivity::class);
    }

    public function latestActivity()
    {
        return $this->hasOne(OrderActivity::class)->latestOfMany();
    }

}
