<?php

namespace App\Repositories;

use App\DTO\LoyaltyPointsTransactionDTO;
use App\Models\LoyaltyAccount;

interface LoyaltyPointsRepository
{
    public function deposit(LoyaltyPointsTransactionDTO $dto, LoyaltyAccount $account);

    public function cancel(int $transaction_id, string $reason = null);

    public function withdraw();
}
