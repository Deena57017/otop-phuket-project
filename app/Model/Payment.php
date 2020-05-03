<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    const PAYMENT_PAID = 'PAID';
    const PAYMENT_PENDING = 'PENDING PAYMENT';

    protected $fillable = ['payment_date', 'user_id', 'order_id', 'payment_status', 'payment_total', 'reference_id'];
    protected $primaryKey = 'payment_id';
}
