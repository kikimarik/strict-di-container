<?php

namespace kikimarik\di\map;

use kikimarik\di\core\ClassEntityMap;
use kikimarik\di\core\ClassIdentity;

final class UniqueClassEntityMap implements ClassEntityMap
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
        $key = $identity->keygen();
        return $this->registry[$key];
    }

    /**
     * @inheritDoc
     */
    public function remove(ClassIdentity $identity): void
    {
        $key = $identity->keygen();
        unset($this->registry[$key]);
    }
}
