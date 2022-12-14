<?php

namespace kikimarik\di\tests\unit\identity;

use kikimarik\di\core\ClassIdentity;
use kikimarik\di\core\ClassIdentityFactory;
use kikimarik\di\core\RuntimeContainerException;

final class FakeClassIdentityFactory implements ClassIdentityFactory
{
    private string $identityType;

    public function __construct(string $identityType)
    {
        $this->identityType = $identityType;
    }

    public function create(string $id): ClassIdentity
    {
        switch ($this->identityType) {
            case FakeClassIdentity::class:
                return new FakeClassIdentity($id);
            default:
                throw new RuntimeContainerException("Unexpected identity type {$this->identityType}.");
        }
    }
}
