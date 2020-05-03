<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
  protected $fillable = ['product_name','product_quantity','product_price','product_cost','subcategory_id','subdistrict_id','product_image','product_detail'];
  protected $primaryKey = 'product_id';
}
