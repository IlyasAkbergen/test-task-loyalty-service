<?php

namespace App\Http\Requests\LoyaltyPoints;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // не уверен, можно ли менять нейминги полей, зависит от разных обстоятельств, так-что решил оставить
            'account_type' => [ 'required', 'in:phone,card,email' ],
            'account_id'   => [ 'required', 'string' ],
            'loyalty_points_rule_id' => [ 'required', 'numeric', 'exists:loyalty_points_rule,id' ],
            'description' => [ 'required', 'string' ],
            'payment_id' => [ 'filled', 'string' ],
            'payment_amount' => [ 'required', 'numeric' ],
            'payment_time' => [ 'filled', 'numeric' ],
        ];
    }
}
