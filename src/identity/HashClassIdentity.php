<?php

namespace kikimarik\di\identity;

use kikimarik\di\core\ClassIdentity;
use kikimarik\di\core\InvalidClassIdentityException;
use kikimarik\di\core\RuntimeContainerException;
use RuntimeException;
use Throwable;

final class HashClassIdentity implements ClassIdentity
{
    private string $identity;
    private string $algo;

    public function __construct(string $identity, string $algo)
    {
        $this->identity = $identity;
        $this->algo = $algo;
    }

    public function keygen(): string
    {
        if (!(class_exists($this->identity) || interface_exists($this->identity))) {
            throw new InvalidClassIdentityException("Invalid class {$this->identity}.");
        }
        try {
            $hash = hash($this->algo, $this->identity);
            if ($hash === false) {
                throw new RuntimeException();
            }
        } catch (Throwable|\Error $e) {
            throw new RuntimeContainerException("Failed hashing with algo {$this->algo} for {$this->identity}.");
        }
        return $hash;
    }
}