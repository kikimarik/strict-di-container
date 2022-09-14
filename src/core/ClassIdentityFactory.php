<?php

namespace kikimarik\di\core;

interface ClassIdentityFactory
{
    public function create(string $id): ClassIdentity;
}
