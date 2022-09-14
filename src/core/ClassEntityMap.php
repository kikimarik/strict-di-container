<?php

namespace kikimarik\di\core;

interface ClassEntityMap
{
    public function put(ClassIdentity $identity, object $object): void;

    /**
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function get(ClassIdentity $identity): object;

    /**
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function remove(ClassIdentity $identity): void;
}
