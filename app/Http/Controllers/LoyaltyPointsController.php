<?php

namespace App\Http\Controllers;

use App\DTO\LoyaltyPointsTransactionDTO;
use App\Exceptions\AccountIsNotActiveException;
use App\Http\Requests\LoyaltyPoints\CancelRequest;
use App\Http\Requests\LoyaltyPoints\DepositRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Models\LoyaltyAccount;
use App\Models\LoyaltyPointsTransaction;
use App\Repositories\AccountRepository;
use App\Repositories\LoyaltyPointsRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class LoyaltyPointsController extends Controller
{
    public function __construct(
        protected LoyaltyPointsRepository $repository,
        protected AccountRepository $accountRepository
    ) {}

    public function deposit(DepositRequest $request)
    {
        $id   = $request->get('account_id');
        $type = $request->get('account_type');

        try {
            $account = $this->accountRepository->findWhereOrFail($type, $id);
            if ($account->active) {
                $transaction = $this->repository->deposit(
                    new LoyaltyPointsTransactionDTO($request->all()),
                    $account
                );
                return TransactionResource::make($transaction);
            } else {
                throw new AccountIsNotActiveException();
            }
        } catch (\InvalidArgumentException|ModelNotFoundException|AccountIsNotActiveException $e) {
            return ApiErrorResponse::make($e->getMessage());
        } catch (\Exception) {
            return ApiErrorResponse::make(__('Server error'));
        }
    }

    public function cancel(CancelRequest $request)
    {
        try {
            $this->repository->cancel(
                $request->get('transaction_id'),
                $request->get('cancellation_reason')
            );
            return ApiSuccessResponse::make();
        } catch (\Exception) {
            return ApiErrorResponse::make(__('Server error'));
        }
    }

    public function withdraw()
    {
        $data = $_POST;

        Log::info('Withdraw loyalty points transaction input: ' . print_r($data, true));

        $type = $data['account_type'];
        $id = $data['account_id'];
        if (($type == 'phone' || $type == 'card' || $type == 'email') && $id != '') {
            if ($account = LoyaltyAccount::where($type, '=', $id)->first()) {
                if ($account->active) {
                    if ($data['points_amount'] <= 0) {
                        Log::info('Wrong loyalty points amount: ' . $data['points_amount']);
                        return response()->json(['message' => 'Wrong loyalty points amount'], 400);
                    }
                    if ($account->getBalance() < $data['points_amount']) {
                        Log::info('Insufficient funds: ' . $data['points_amount']);
                        return response()->json(['message' => 'Insufficient funds'], 400);
                    }

                    $transaction = LoyaltyPointsTransaction::withdrawLoyaltyPoints($account->id, $data['points_amount'], $data['description']);
                    Log::info($transaction);
                    return $transaction;
                } else {
                    Log::info('Account is not active: ' . $type . ' ' . $id);
                    return response()->json(['message' => 'Account is not active'], 400);
                }
            } else {
                Log::info('Account is not found:' . $type . ' ' . $id);
                return response()->json(['message' => 'Account is not found'], 400);
            }
        } else {
            Log::info('Wrong account parameters');
            throw new \InvalidArgumentException('Wrong account parameters');
        }
    }
}
