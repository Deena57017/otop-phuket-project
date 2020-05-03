<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model {
    protected $fillable = ['order_id', 'product_id', 'order_detail_quantity', 'order_detail_total'];
    protected $primaryKey = 'order_detail_id';
}
