<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model{
  protected $fillable = ['district_id', 'subdistrict_name'];
  protected $primaryKey = 'subdistrict_id';
}
