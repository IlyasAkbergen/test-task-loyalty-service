<?php

namespace App\Http\Controllers;

use App\DTO\LoyaltyPointsTransactionDTO;
use App\Exceptions\AccountIsNotActiveException;
use App\Http\Requests\LoyaltyPoints\CancelRequest;
use App\Http\Requests\LoyaltyPoints\DepositRequest;
use App\Http\Requests\LoyaltyPoints\WithdrawRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Repositories\AccountRepository;
use App\Repositories\LoyaltyPointsRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            $transaction = $this->repository->deposit(
                new LoyaltyPointsTransactionDTO($request->all()),
                $account
            );
            return TransactionResource::make($transaction);
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

    public function withdraw(WithdrawRequest $request)
    {
        $id   = $request->get('account_id');
        $type = $request->get('account_type');

        try {
            $account = $this->accountRepository->with([ 'transactions' ])->findWhereOrFail($type, $id);
            $transaction = $this->repository->withdraw(
                new LoyaltyPointsTransactionDTO($request->all()),
                $account
            );
            return TransactionResource::make($transaction);
        } catch (\InvalidArgumentException|ModelNotFoundException|AccountIsNotActiveException $e) {
            return ApiErrorResponse::make($e->getMessage());
        } catch (\Exception) {
            return ApiErrorResponse::make(__('Server error'));
        }
    }
}
