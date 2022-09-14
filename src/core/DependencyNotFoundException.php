<?php

namespace kikimarik\di\core;

use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;
use Throwable;

final class DependencyNotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
