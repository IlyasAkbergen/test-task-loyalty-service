<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Pure;

class ApiErrorResponse implements Responsable
{

    public function __construct(
        public string $message,
        public int $code = Response::HTTP_PRECONDITION_FAILED
    ) {}

    public function toResponse($request): \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        return response()
            ->json(
                [
                    'message' => $this->message,
                ],
                $this->code
            );
    }

    #[Pure] public static function make(string $message, int $code = null): static
    {
        return new static($message, $code);
    }
}
