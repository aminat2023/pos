<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'description',
        'brand',
        'price',
        'quantity',
        'alert_stock',
        'barcode',
        'qrcode',
        'product_image'
    ];
    public function orderdetail(){
        return $this->hasMany('App\Order_Details');
     }

     public function cart(){
        return $this->hasMany('App\Cart');
     }
}
