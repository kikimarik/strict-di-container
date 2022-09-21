<?php

namespace kikimarik\di\tests\unit;

final class Bar implements FooBar
{
    private string $bar;

    public function __construct(string $bar)
    {
        $this->bar = $bar;
    }


    public function jsonSerialize(): mixed
    {
        return [
            "bar" => $this->bar
        ];
    }
}
