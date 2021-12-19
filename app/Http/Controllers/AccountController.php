<?php

namespace App\Http\Controllers;

use App\DTO\AccountDTO;
use App\Http\Requests\Account\CreateRequest;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ApiSuccessResponse;
use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function activate($search_field, $search_value): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->repository->activate($search_field, $search_value);
        } catch (\InvalidArgumentException|ModelNotFoundException $e) {
            return ApiErrorResponse::make($e->getMessage());
        } catch (\Exception) {
            return ApiErrorResponse::make(__('Server error'));
        }

        return ApiSuccessResponse::make();
    }

    public function deactivate($search_field, $search_value): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $this->repository->deactivate($search_field, $search_value);
        } catch (\InvalidArgumentException|ModelNotFoundException $e) {
            return ApiErrorResponse::make($e->getMessage());
        } catch (\Exception) {
            return ApiErrorResponse::make(__('Server error'));
        }

        return ApiSuccessResponse::make();
    }

    public function balance($search_field, $search_value): ApiSuccessResponse|ApiErrorResponse
    {
        try {
            $balance = $this->repository->balance($search_field, $search_value);
        } catch (\InvalidArgumentException|ModelNotFoundException $e) {
            return ApiErrorResponse::make($e->getMessage());
        } catch (\Exception) {
            return ApiErrorResponse::make(__('Server error'));
        }

        return ApiSuccessResponse::make([ 'balance' => round($balance, 2) ]);
    }
}
