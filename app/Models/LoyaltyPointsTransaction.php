<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed points_amount
 */
class LoyaltyPointsTransaction extends Model
{
    protected $table = 'loyalty_points_transaction';

    protected $fillable = [
        'account_id',
        'user_id',
        'points_rule',
        'points_amount',
        'description',
        'payment_id',
        'payment_amount',
        'payment_time',
    ];
}
