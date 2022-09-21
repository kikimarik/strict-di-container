<?php

namespace kikimarik\di\tests\unit\identity;

use Codeception\Test\Unit;
use kikimarik\di\core\RuntimeContainerException;
use kikimarik\di\identity\DefaultClassIdentityFactory;
use kikimarik\di\identity\HashClassIdentity;
use kikimarik\di\identity\StdClassIdentity;
use kikimarik\di\tests\unit\Bar;
use kikimarik\di\tests\unit\Foo;

final class DefaultClassIdentityFactoryTest extends Unit
{
    private const ALGO = "sha1";

    public function testCreate(): void
    {
        $factory1 = new DefaultClassIdentityFactory(StdClassIdentity::class);
        $factory2 = new DefaultClassIdentityFactory(HashClassIdentity::class, ["algo" => self::ALGO]);
        $expected1 = new StdClassIdentity(Foo::class);
        $expected2 = new StdClassIdentity(Bar::class);
        $expected3 = new HashClassIdentity(Foo::class, self::ALGO);
        $expected4 = new HashClassIdentity(Bar::class, self::ALGO);
        $result1 = $factory1->create(Foo::class);
        $result2 = $factory1->create(Bar::class);
        $result3 = $factory2->create(Foo::class);
        $result4 = $factory2->create(Bar::class);
        $this->assertEquals($expected1, $result1);
        $this->assertEquals($expected2, $result2);
        $this->assertEquals($expected3, $result3);
        $this->assertEquals($expected4, $result4);
    }

    public function testCreateNegative(): void
    {
        $this->expectException(RuntimeContainerException::class);
        $factory = new DefaultClassIdentityFactory(Foo::class);
        $factory->create(Bar::class);
    }
}
