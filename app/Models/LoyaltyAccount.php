<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property bool $active
 * @property string $email
 * @property string $phone
 * @property string $card
*/
class LoyaltyAccount extends Model
{
    use Notifiable;

    protected $table = 'loyalty_account';

    protected $fillable = [
        'phone',
        'card',
        'email',
        'email_notification',
        'phone_notification',
        'active',
    ];

    protected $attributes = [
        'email_notification' => true,
        'phone_notification' => true,
        'active' => true,
    ];

    // todo refactor using hasMany relationship
    public function getBalance(): float
    {
        return LoyaltyPointsTransaction
            ::where('canceled', 0)
            ->where('account_id', $this->id)
            ->sum('points_amount');
    }
}
