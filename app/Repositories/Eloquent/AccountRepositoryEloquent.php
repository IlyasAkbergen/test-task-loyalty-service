<?php

namespace App\Repositories\Eloquent;

use App\DTO\AccountDTO;
use App\Models\LoyaltyAccount;
use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AccountRepositoryEloquent implements AccountRepository
{
    public function findWhereOrFail($field, $value, $operator = '='): LoyaltyAccount
    {
        $model = LoyaltyAccount::where($field, $operator, $value)->first();
        if (!$model) {
            throw new ModelNotFoundException(__('Account is not found'));
        }
        return $model;
    }

    /**
     * @throws UnknownProperties
     */
    public function create(AccountDTO $dto): AccountDTO
    {
        $model = LoyaltyAccount::create(
            $dto->only(
                'phone',
                'card',
                'email',
                'email_notification',
                'phone_notification'
            )
            ->toArray()
        );

        return new AccountDTO($model->toArray());
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelNotFoundException
    */
    public function activate(string $search_field, $search_value): bool
    {
        $this->validateSearchField($search_field);
        $account = $this->findWhereOrFail($search_field, $search_value);
        $this->setActiveState($account, true);
        return true;
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelNotFoundException
     */
    public function deactivate(string $search_field, $search_value): bool
    {
        $this->validateSearchField($search_field);
        $account = $this->findWhereOrFail($search_field, $search_value);
        $this->setActiveState($account, false);
        return true;
    }

    private function setActiveState(LoyaltyAccount $account, bool $active)
    {
        if ($account->active != $active) {
            $account->update([
                'active' => $active
            ]);
        }
    }

    /**
     * @throws InvalidArgumentException
     * @throws ModelNotFoundException
     */
    public function balance(string $search_field, $search_value): float
    {
        $this->validateSearchField($search_field);
        $account = $this->findWhereOrFail($search_field, $search_value);
        return $account->getBalance();
    }

    /**
     * @param $search_field
     * @throws InvalidArgumentException
     */
    private function validateSearchField($search_field)
    {
        if (!in_array($search_field, [ 'phone', 'card', 'email' ])) {
            throw new InvalidArgumentException(__('Wrong parameters'));
        }
    }
}
