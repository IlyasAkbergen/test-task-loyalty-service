<?php

namespace App\Http\Controllers;

use App\DTO\AccountDTO;
use App\Http\Requests\Account\CreateRequest;
use App\Models\LoyaltyAccount;
use App\Repositories\AccountRepository;

class AccountController extends Controller
{
    protected AccountRepository $repository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->repository = $accountRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function create(CreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $dto = new AccountDTO($request->all());
        return response()->json(
            $this->repository->create($dto)->toArray()
        );
    }

    public function activate($type, $id)
    {
        if (($type == 'phone' || $type == 'card' || $type == 'email') && $id != '') {
            if ($account = LoyaltyAccount::where($type, '=', $id)->first()) {
                if (!$account->active) {
                    $account->active = true;
                    $account->save();
                    $account->notify('Account restored');
                }
            } else {
                return response()->json(['message' => 'Account is not found'], 400);
            }
        } else {
            throw new \InvalidArgumentException('Wrong parameters');
        }

        return response()->json(['success' => true]);
    }

    public function deactivate($type, $id)
    {
        if (($type == 'phone' || $type == 'card' || $type == 'email') && $id != '') {
            if ($account = LoyaltyAccount::where($type, '=', $id)->first()) {
                if ($account->active) {
                    $account->active = false;
                    $account->save();
                    $account->notify('Account banned');
                }
            } else {
                return response()->json(['message' => 'Account is not found'], 400);
            }
        } else {
            throw new \InvalidArgumentException('Wrong parameters');
        }

        return response()->json(['success' => true]);
    }

    public function balance($type, $id)
    {
        if (($type == 'phone' || $type == 'card' || $type == 'email') && $id != '') {
            if ($account = LoyaltyAccount::where($type, '=', $id)->first()) {
                return response()->json(['balance' => $account->getBalance()], 400);

            } else {
                return response()->json(['message' => 'Account is not found'], 400);
            }
        } else {
            throw new \InvalidArgumentException('Wrong parameters');
        }
    }
}
