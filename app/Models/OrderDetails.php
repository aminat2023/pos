<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = 'order_details';
    protected $fillable = [
     'order_id',
     'product_id'
    ,'quantity' 
    ,'unit_price' 
    ,'amount'
    ,'discount'
];

// public function product(){
//     return $this->belongsTo('App\Product');
//  }

//  public function order(){
//     return $this->belongsTo('App\Order');
//  }
public function product() {
    return $this->belongsTo('App\Models\Products');
}

public function order() {
    return $this->belongsTo('App\Models\Order');
}
}
