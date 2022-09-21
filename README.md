# Strict DI container is a PSR-11 php library
## Features
***
- Object-oriented design (without static methods etc.)
- Compatible with PHP 8.0 and later, including PHP 8.1
- Compatible with PSR-11

## Why do you need it
***
The library helps you project to inject it dependencies.
It has a nice object-oriented design, and it is going to please you with its simplicity. Before testing a class that depends on that library component, it is easy to replace that dependency with a fake class.

## A Simple Example
***

```php
<?php

//Load Composer's autoloader
use kikimarik\di\identity\DefaultClassIdentityFactory;
use kikimarik\di\identity\HashClassIdentity;
use kikimarik\di\map\UniqueClassEntityMap;
use kikimarik\di\StrictContainer;
use kikimarik\di\tests\unit\Bar;
use kikimarik\di\tests\unit\Foo;
use kikimarik\di\tests\unit\FooBar;

require_once __DIR__ . "/vendor/autoload.php";

$classMap = new UniqueClassEntityMap();
$classMap->put(new HashClassIdentity(Foo::class, "md5"), new Foo("foo"));
$classMap->put(new HashClassIdentity(Bar::class, "md5"), new Bar("bar"));
$container = new StrictContainer(
    $classMap,
    new DefaultClassIdentityFactory(
        HashClassIdentity::class,
        [
            "algo" => "md5"
        ]
    )
);
if ($container->has(Foo::class)) {
    print_r($container->get(Foo::class)); // got object from container
}
if (!$container->has(FooBar::class)) {
    print_r("Container does not contain class " . FooBar::class);
}

```

## License
***
This software is distributed under the MIT license.

## Installation
***
- via composer `composer require kikimarik/strict-di-container`

## Tests
***
[Lognote tests](https://github.com/kikimarik/lognote/tree/master/tests) use the [Codeception 4.2.0](https://github.com/Codeception/Codeception/tree/4.2.0) framework.
All unit tests must be passed.

For tests running you can run the command:
`./vendor/bin/codecept run`