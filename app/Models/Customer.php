<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'address', 'phone_no', 'country'];

    public function shipping_order(){
        return $this->hasOne(Shipping::class, 'customer_id');
    }
}
