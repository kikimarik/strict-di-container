<?php

namespace kikimarik\di\tests\unit\map;

use kikimarik\di\core\ClassEntityMap;
use kikimarik\di\core\ClassIdentity;
use kikimarik\di\core\DependencyNotFoundException;

final class FakeClassEntityMap implements ClassEntityMap
{
    /** @var array<string, object> */
    private array $registry;

    public function __construct()
    {
        $this->registry = [];
    }

    public function put(ClassIdentity $identity, object $object): void
    {
        $key = $identity->keygen();
        $this->registry[$key] = $object;
    }

    /**
     * @inheritDoc
     */
    public function get(ClassIdentity $identity): object
    {
        $key = $this->generateKey($identity);
        return $this->registry[$key];
    }

    /**
     * @inheritDoc
     */
    public function remove(ClassIdentity $identity): void
    {
        $key = $this->generateKey($identity);
        unset($this->registry[$key]);
    }

    private function generateKey(ClassIdentity $identity): string
    {
        $key = $identity->keygen();
        if (!array_key_exists($key, $this->registry)) {
            throw new DependencyNotFoundException("The dependency marked as \"$key\" not found.");
        }
        return $key;
    }
}
