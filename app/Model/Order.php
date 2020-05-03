<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = ['order_date', 'order_total', 'user_id'];
    protected $primaryKey = 'order_id';
}
