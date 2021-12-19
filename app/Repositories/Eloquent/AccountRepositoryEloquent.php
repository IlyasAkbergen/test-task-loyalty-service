<?php

namespace App\Repositories\Eloquent;

use App\DTO\AccountDTO;
use App\Models\LoyaltyAccount;
use App\Repositories\AccountRepository;

class AccountRepositoryEloquent implements AccountRepository
{

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
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

    public function activate($type, $id)
    {
        // TODO: Implement activate() method.
    }

    public function deactivate($type, $id)
    {
        // TODO: Implement deactivate() method.
    }

    public function balance($type, $id)
    {
        // TODO: Implement balance() method.
    }
}
