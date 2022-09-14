<?php

namespace kikimarik\di\identity;

use kikimarik\di\core\ClassIdentity;
use kikimarik\di\core\ClassIdentityFactory;
use kikimarik\di\core\RuntimeContainerException;

final class DefaultClassIdentityFactory implements ClassIdentityFactory
{
    private string $classname;
    private array $options;

    public function __construct(string $classname, array $options)
    {
        $this->classname = $classname;
        $this->options = $options;
    }

    public function create(string $id): ClassIdentity
    {
        return match ($this->classname) {
            StdClassIdentity::class => new StdClassIdentity($id),
            HashClassIdentity::class => new HashClassIdentity($id, $this->options["algo"] ?? "md5"),
            default => throw new RuntimeContainerException("Unexpected identity class {$this->classname}.")
        };
    }
}
