<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use JetBrains\PhpStorm\Pure;

class ApiResponse implements Responsable
{
    public function __construct(protected $data, protected $code = 200) {}

    public function toResponse($request): \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        return response()
            ->json(
                [
                    'data' => $this->data
                ],
                $this->code
            );
    }

    #[Pure] public static function make($data, $code = 200): static
    {
        return new static($data, $code);
    }
}
