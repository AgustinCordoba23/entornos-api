<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class BusinessException extends Exception
{
    private array $errors;

    public function __construct($message = "", array $errors = [], $code = 422, Throwable $previous = null) {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    public function render() {
        return response()->json([
            'name' => basename(str_replace('\\', '/',static::class)),
            'message' => $this->getMessage(),
            'errors' => $this->errors
        ], $this->getCode());
    }
}
