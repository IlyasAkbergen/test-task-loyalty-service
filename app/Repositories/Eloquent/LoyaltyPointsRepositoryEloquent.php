<?php

namespace App\Repositories\Eloquent;

use App\DTO\LoyaltyPointsTransactionDTO;
use App\Models\LoyaltyAccount;
use App\Models\LoyaltyPointsRule;
use App\Models\LoyaltyPointsTransaction;
use App\Notifications\LoyaltyPointsReceived;
use App\Repositories\LoyaltyPointsRepository;
use Illuminate\Support\Facades\Auth;

class LoyaltyPointsRepositoryEloquent implements LoyaltyPointsRepository
{
    public function deposit(LoyaltyPointsTransactionDTO $dto, LoyaltyAccount $account)
    {
        $pointsRule = LoyaltyPointsRule::findOrFail($dto->loyalty_points_rule_id);
        $points_amount = $this->calculatePoints($pointsRule, $dto->payment_amount);

        $transaction = LoyaltyPointsTransaction::create(
            array_merge($dto->toArray(), [
                'user_id'       => Auth::id(),
                'account_id'    => $account->id,
                'points_amount' => $points_amount,
            ])
        );

        $account->notify(new LoyaltyPointsReceived($transaction));

        return $transaction;
    }

    public function cancel(int $transaction_id, string $reason = null)
    {
        return LoyaltyPointsTransaction
            ::whereKey($transaction_id)
            ->update([
                'canceled' => true,
                'cancellation_reason' => $reason,
            ]);
    }

    public function withdraw()
    {
        // TODO: Implement withdraw() method.
    }

    private function calculatePoints($pointsRule, float $payment_amount): float
    {
        return match ($pointsRule->accrual_type) {
            LoyaltyPointsRule::ACCRUAL_TYPE_RELATIVE_RATE => ($payment_amount / 100) * $pointsRule->accrual_value,
            LoyaltyPointsRule::ACCRUAL_TYPE_ABSOLUTE_POINTS_AMOUNT => (float) $pointsRule->accrual_value
        };
    }
}
