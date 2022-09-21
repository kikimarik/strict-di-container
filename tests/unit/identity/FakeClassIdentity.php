<?php

namespace kikimarik\di\tests\unit\identity;

use kikimarik\di\core\ClassIdentity;

final class FakeClassIdentity implements ClassIdentity
{
    private string $identity;

    public function __construct(string $identity)
    {
        $this->identity = $identity;
    }

    public function keygen(): string
    {
        return $this->identity;
    }
}
