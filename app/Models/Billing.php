<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = ['base_fare', 'weighted_cost', 'origin_cost', 'calculated_sum',
        'tax_per', 'total_pay', 'status'];

    public function shipping_detail(){
        $this->belongsTo(Shipping::class, "shipping_id");
    }

}
