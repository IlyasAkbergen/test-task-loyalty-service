<?php

namespace App\Http\Requests\LoyaltyPoints;

use App\Models\LoyaltyPointsTransaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CancelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $transaction = LoyaltyPointsTransaction
            ::whereKey(request()->get('transaction_id'))
            ->where('canceled', false)
            ->first();

        return $transaction && $transaction->user_id == Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'transaction_id' => [ 'required', 'numeric' ],
            'cancellation_reason' => [ 'required', 'string' ],
        ];
    }
}
