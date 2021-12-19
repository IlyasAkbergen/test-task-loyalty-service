<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Pure;

class ApiSuccessResponse implements Responsable
{
    public function __construct(protected $data = null) {}

    public function toResponse($request): \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        return response()
            ->json(
                [
                    'success' => true,
                    'data' => $this->data,
                ],
                Response::HTTP_OK
            );
    }

    #[Pure] public static function make($data = null): static
    {
        return new static($data);
    }
}
