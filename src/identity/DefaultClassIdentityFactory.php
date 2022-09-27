<?php

namespace kikimarik\di\identity;

use kikimarik\di\core\ClassIdentity;
use kikimarik\di\core\ClassIdentityFactory;
use kikimarik\di\core\RuntimeContainerException;

final class DefaultClassIdentityFactory implements ClassIdentityFactory
{
    private string $identityType;
    private array $options;

    public function __construct(string $identityType, array $options = [])
    {
        $this->identityType = $identityType;
        $this->options = $options;
    }

    public function create(string $id): ClassIdentity
    {
        switch ($this->identityType) {
            case StdClassIdentity::class:
                return new StdClassIdentity($id);
            case HashClassIdentity::class:
                return new HashClassIdentity($id, $this->options["algo"] ?? "md5");
            default:
                throw new RuntimeContainerException("Unexpected identity type {$this->identityType}.");
        }
    }
}
