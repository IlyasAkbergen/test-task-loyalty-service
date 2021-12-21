<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'points_rule'    => $this->points_rule,
            'points_amount'  => round($this->points_amount, 2),
            'description'    => $request->description,
            'payment_id'     => $request->payment_id,
            'payment_amount' => $request->payment_amount,
            'payment_time'   => $request->payment_time,
        ];
    }
}
