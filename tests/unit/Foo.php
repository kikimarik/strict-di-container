<?php

namespace kikimarik\di\tests\unit;

final class Foo implements FooBar
{
    private string $foo;

    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }


    public function jsonSerialize(): mixed
    {
        return [
            "foo" => $this->foo,
        ];
    }
}
