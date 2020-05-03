<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model {
    protected $fillable = ['user_address', 'user_district', 'user_province', 'user_country', 'user_postcode', 'user_id'];
    protected $primaryKey = 'user_detail_id';
}
