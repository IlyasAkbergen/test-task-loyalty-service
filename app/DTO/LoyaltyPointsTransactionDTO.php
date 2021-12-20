<?php

namespace App\DTO;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Attributes\MapTo;
use Spatie\DataTransferObject\DataTransferObject;

class LoyaltyPointsTransactionDTO extends DataTransferObject
{
    #[MapFrom('account_id')]
    public string $account_id;

    #[MapFrom('loyalty_points_rule_id')]
    #[MapTo('points_rule')]
    public int $loyalty_points_rule_id;

    #[MapFrom('description')]
    public string $description;

    #[MapFrom('payment_id')]
    public string $payment_id;

    #[MapFrom('payment_amount')]
    public float $payment_amount;

    #[MapFrom('payment_time')]
    public int $payment_time;

}
