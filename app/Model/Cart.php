<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model{
    protected $fillable = ['quantity', 'product_id', 'total', 'user_id'];
    protected $primaryKey = 'cart_id';
}
