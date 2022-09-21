<?php

namespace kikimarik\di\tests\unit\map;

use Codeception\Test\Unit;
use kikimarik\di\map\UniqueClassEntityMap;
use kikimarik\di\tests\unit\Bar;
use kikimarik\di\tests\unit\Foo;
use kikimarik\di\tests\unit\FooBar;
use kikimarik\di\tests\unit\identity\FakeClassIdentity;
use Psr\Container\NotFoundExceptionInterface;

final class UniqueClassEntityMapTest extends Unit
{
    public function testPut(): void
    {
        $this->putAndGet();
    }

    public function testGet(): void
    {
        $this->putAndGet();
    }

    public function testGetNegative(): void
    {
        $this->expectException(NotFoundExceptionInterface::class);
        $map = new UniqueClassEntityMap();
        $identity = new FakeClassIdentity(FooBar::class);
        $map->get($identity);
    }

    public function testRemove(): void
    {
        $foo = new Foo("foo");
        $map = new UniqueClassEntityMap();
        $identity = new FakeClassIdentity(FooBar::class);
        $map->put($identity, $foo);
        try {
            $map->remove($identity);
        } catch (NotFoundExceptionInterface $e) {
            $this->fail($e->getMessage());
        }
        try {
            $map->get($identity);
            $this->fail("Entity wasn`t removed.");
        } catch (NotFoundExceptionInterface $e) {
        }
    }

    public function testRemoveNegative(): void
    {
        $this->expectException(NotFoundExceptionInterface::class);
        $map = new UniqueClassEntityMap();
        $identity = new FakeClassIdentity(FooBar::class);
        $map->remove($identity);
    }

    private function putAndGet(): void
    {
        $foo = new Foo("foo");
        $bar = new Bar("bar");
        $map = new UniqueClassEntityMap();
        $identity = new FakeClassIdentity(FooBar::class);
        $map->put($identity, $foo);
        $map->put($identity, $bar);
        try {
            $result = $map->get($identity);
        } catch (NotFoundExceptionInterface $e) {
            $this->fail($e->getMessage());
        }
        $this->assertEquals($bar, $result);
    }
}
