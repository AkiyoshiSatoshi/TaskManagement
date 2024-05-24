<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected int $statusCode;

    public function __construct(string $message, int $code = 0, ?Exception $previous = null, int $statusCode = 500)
    {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
