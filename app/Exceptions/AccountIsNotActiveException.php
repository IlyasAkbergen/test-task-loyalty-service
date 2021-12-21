<?php

namespace App\Exceptions;

use Throwable;

class AccountIsNotActiveException extends \Exception
{
    public function __construct($message = null, $code = 403, Throwable $previous = null)
    {
        $message = $message ?: __('Account is not active.');
        parent::__construct($message, $code, $previous);
    }
}
