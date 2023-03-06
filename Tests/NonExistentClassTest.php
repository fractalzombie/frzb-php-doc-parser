<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests;

use FRZB\Component\PhpDocReader\Exception\ReaderException;
use FRZB\Component\PhpDocReader\Reader\ReaderService;
use FRZB\Component\PhpDocReader\Resolver\ResolverService;
use FRZB\Component\PhpDocReader\Tests\FixturesNonExistentClass\Class1;
use PHPUnit\Framework\TestCase;

/**
 * Test exceptions when a class doesn't exist.
 *
 * @internal
 */
class NonExistentClassTest extends TestCase
{
    public function testProperties(): void
    {
        $parser = new ReaderService(new ResolverService());
        $class = new \ReflectionClass(Class1::class);

        $this->expectException(ReaderException::class);
        $this->expectExceptionMessage(
            'The @var annotation on FRZB\Component\PhpDocReader\Tests\FixturesNonExistentClass\Class1::prop contains a non existent class "Foo". Did you maybe forget to add a "use" statement for this annotation?'
        );

        $parser->getPropertyClass($class->getProperty('prop'));
    }

    public function testMethodParameters(): void
    {
        $parser = new ReaderService(new ResolverService());
        $parameter = new \ReflectionParameter([Class1::class, 'foo'], 'param');

        $this->expectException(ReaderException::class);
        $this->expectExceptionMessage(
            'The @param annotation for parameter "param" of FRZB\Component\PhpDocReader\Tests\FixturesNonExistentClass\Class1::foo contains a non existent class "Foo". Did you maybe forget to add a "use" statement for this annotation?'
        );

        $parser->getParameterClass($parameter);
    }
}
