<?php

namespace App\Repositories;

use App\DTO\LoyaltyPointsTransactionDTO;
use App\Exceptions\AccountIsNotActiveException;
use App\Exceptions\InsufficientFundsException;
use App\Models\LoyaltyAccount;

interface LoyaltyPointsRepository
{
    /**
     * @throws AccountIsNotActiveException
    */
    public function deposit(LoyaltyPointsTransactionDTO $dto, LoyaltyAccount $account);

    public function cancel(int $transaction_id, string $reason = null);

    /**
     * @throws AccountIsNotActiveException
     * @throws InsufficientFundsException
    */
    public function withdraw(LoyaltyPointsTransactionDTO $dto, LoyaltyAccount $account);
}
