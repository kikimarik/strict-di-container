<?php

namespace kikimarik\di\tests\unit;

use Codeception\Test\Unit;
use kikimarik\di\core\ClassIdentityFactory;
use kikimarik\di\StrictContainer;
use kikimarik\di\tests\unit\identity\FakeClassIdentity;
use kikimarik\di\tests\unit\identity\FakeClassIdentityFactory;
use kikimarik\di\tests\unit\map\FakeClassEntityMap;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class StrictContainerTest extends Unit
{
    public function testGet(): void
    {
        $map = new FakeClassEntityMap();
        $identity = new FakeClassIdentity(Foo::class);
        $foo = new Foo("foo");
        $map->put($identity, $foo);
        $container = new StrictContainer($map, new FakeClassIdentityFactory(FakeClassIdentity::class));
        try {
            $result = $container->get(Foo::class);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            $this->fail($e->getMessage());
        }
        $this->assertEquals($foo, $result);
    }

    /**
     * @dataProvider getNegativeDataProvider
     */
    public function testGetNegative(string $exception, string $identity, ClassIdentityFactory $factory): void
    {
        $this->expectException($exception);
        $map = new FakeClassEntityMap();
        $identity = new FakeClassIdentity(Foo::class);
        $foo = new Foo("foo");
        $map->put($identity, $foo);
        $container = new StrictContainer($map, $factory);
        $container->get(Bar::class);
    }

    public function testHas(): void
    {
        $map = new FakeClassEntityMap();
        $identity = new FakeClassIdentity(Foo::class);
        $map->put($identity, new Foo("foo"));
        $container = new StrictContainer($map, new FakeClassIdentityFactory(FakeClassIdentity::class));
        $resultTrue = $container->has(Foo::class);
        $resultFalse = $container->has(Bar::class);
        $this->assertTrue($resultTrue);
        $this->assertFalse($resultFalse);
    }

    public function getNegativeDataProvider(): array
    {
        return [
            [NotFoundExceptionInterface::class, Bar::class, new FakeClassIdentityFactory(FakeClassIdentity::class)],
            [ContainerExceptionInterface::class, Foo::class, new FakeClassIdentityFactory(FooBar::class)],
            [ContainerExceptionInterface::class, Bar::class, new FakeClassIdentityFactory(FooBar::class)]
        ];
    }
}
