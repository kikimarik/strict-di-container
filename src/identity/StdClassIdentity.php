<?php

namespace kikimarik\di\identity;

use kikimarik\di\core\ClassIdentity;
use kikimarik\di\core\InvalidClassIdentityException;

final class StdClassIdentity implements ClassIdentity
{
    private string $identity;

    public function __construct(string $identity)
    {
        $this->identity = $identity;
    }

    public function keygen(): string
    {
        if (!(class_exists($this->identity) || interface_exists($this->identity))) {
            throw new InvalidClassIdentityException("Invalid class {$this->identity}.");
        }
        return $this->identity;
    }
}
