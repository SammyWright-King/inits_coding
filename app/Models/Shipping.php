<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = ['product', 'description', 'pickup', 'destination', 'weight', 'shipping_mode'];

    protected $table = 'shipping_details';

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function billing(){
        return $this->hasOne(Billing::class, 'shipping_id');
    }
}
