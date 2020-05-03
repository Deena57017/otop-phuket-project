<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class District extends Model{
  protected $fillable = ['district_name', 'province'];
  protected $primaryKey = 'district_id';
}
