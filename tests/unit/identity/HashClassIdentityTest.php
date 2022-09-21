<?php

namespace kikimarik\di\tests\unit\identity;

use Codeception\Test\Unit;
use kikimarik\di\core\InvalidClassIdentityException;
use kikimarik\di\core\RuntimeContainerException;
use kikimarik\di\identity\HashClassIdentity;
use kikimarik\di\tests\unit\FooBar;

final class HashClassIdentityTest extends Unit
{
    /**
     * @dataProvider keygenDataProvider
     */
    public function testKeygen(string $algo): void
    {
        $expected = hash($algo, FooBar::class);
        $stdClassIdentity = new HashClassIdentity(FooBar::class, $algo);
        $result = $stdClassIdentity->keygen();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider keygenNegativeDataProvider
     */
    public function testKeygenNegative(string $class, string $algo, string $exception): void
    {
        $this->expectException($exception);
        $stdClassIdentity = new HashClassIdentity($class, $algo);
        $stdClassIdentity->keygen();
    }

    public function keygenDataProvider(): array
    {
        return [
            ["md5"],
            ["sha1"],
            ["sha256"],
            ["crc32b"]
        ];
    }

    public function keygenNegativeDataProvider(): array
    {
        return [
            [FooBar::class, "not a hashing algorithm", RuntimeContainerException::class],
            ["Not a class", "md5", InvalidClassIdentityException::class]
        ];
    }
}
