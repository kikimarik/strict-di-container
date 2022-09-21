<?php

namespace kikimarik\di\tests\unit\identity;

use Codeception\Test\Unit;
use kikimarik\di\core\InvalidClassIdentityException;
use kikimarik\di\identity\StdClassIdentity;
use kikimarik\di\tests\unit\FooBar;

final class StdClassIdentityTest extends Unit
{
    public function testKeygen(): void
    {
        $stdClassIdentity = new StdClassIdentity(FooBar::class);
        $result = $stdClassIdentity->keygen();
        $this->assertEquals(FooBar::class, $result);
    }

    public function testKeygenNegative(): void
    {
        $notClass = "Not a class";
        $this->expectException(InvalidClassIdentityException::class);
        $stdClassIdentity = new StdClassIdentity($notClass);
        $stdClassIdentity->keygen();
    }
}
