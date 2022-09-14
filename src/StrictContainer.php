<?php

namespace kikimarik\di;

use kikimarik\di\core\ClassEntityMap;
use kikimarik\di\core\ClassIdentityFactory;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class StrictContainer implements ContainerInterface
{
    private ClassEntityMap $classEntityMap;
    private ClassIdentityFactory $classIdentityFactory;

    public function __construct(ClassEntityMap $classEntityMap, ClassIdentityFactory $classIdentityFactory)
    {
        $this->classEntityMap = $classEntityMap;
        $this->classIdentityFactory = $classIdentityFactory;
    }

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        return $this->classEntityMap->get(
            $this->classIdentityFactory->create($id)
        );
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        try {
            $this->classEntityMap->get(
                $this->classIdentityFactory->create($id)
            );
            return true;
        } catch (NotFoundExceptionInterface) {
            return false;
        }
    }
}
