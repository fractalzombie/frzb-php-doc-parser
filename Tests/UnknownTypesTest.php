<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests;

use FRZB\Component\PhpDocReader\ReaderService;
use FRZB\Component\PhpDocReader\Resolver\ResolverService;
use FRZB\Component\PhpDocReader\Tests\FixturesUnknownTypes\Class1;
use PHPUnit\Framework\TestCase;

/**
 * @see https://github.com/mnapoli/PhpDocReader/issues/3
 *
 * @internal
 */
class UnknownTypesTest extends TestCase
{
    /** @dataProvider typeProvider */
    public function testProperties(string $type): void
    {
        $parser = new ReaderService(new ResolverService());
        $class = new \ReflectionClass(Class1::class);

        $this->assertNull($parser->getPropertyClass($class->getProperty($type)));
    }

    /** @dataProvider typeProvider */
    public function testMethodParameters(string $type): void
    {
        $parser = new ReaderService(new ResolverService());
        $parameter = new \ReflectionParameter([Class1::class, 'foo'], $type);

        $this->assertNull($parser->getParameterClass($parameter));
    }

    public function typeProvider(): iterable
    {
        return [
            'empty' => ['empty'],
            'array' => ['array'],
            'generics' => ['generics'],
            'multiple' => ['multiple'],
        ];
    }
}
