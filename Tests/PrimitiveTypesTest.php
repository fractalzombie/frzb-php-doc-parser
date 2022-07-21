<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests;

use FRZB\Component\PhpDocReader\Reader\ReaderService;
use FRZB\Component\PhpDocReader\Resolver\ResolverService;
use FRZB\Component\PhpDocReader\Tests\FixturesPrimitiveTypes\Class1;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class PrimitiveTypesTest extends TestCase
{
    /** @dataProvider typeProvider */
    public function testProperties(string $type, string $expectedType): void
    {
        $parser = new ReaderService(new ResolverService());
        $class = new \ReflectionClass(Class1::class);

        $this->assertNull($parser->getPropertyClass($class->getProperty($type)));
        $this->assertEquals($expectedType, $parser->getPropertyType($class->getProperty($type)));
    }

    /** @dataProvider typeProvider */
    public function testMethodParameters(string $type, string $expectedType): void
    {
        $parser = new ReaderService(new ResolverService());
        $parameter = new \ReflectionParameter([Class1::class, 'foo'], $type);

        $this->assertNull($parser->getParameterClass($parameter));
        $this->assertEquals($expectedType, $parser->getParameterType($parameter));
    }

    public function typeProvider(): iterable
    {
        return [
            'bool' => ['bool', 'bool'],
            'boolean' => ['boolean', 'bool'],
            'string' => ['string', 'string'],
            'int' => ['int', 'int'],
            'integer' => ['integer', 'int'],
            'float' => ['float', 'float'],
            'double' => ['double', 'float'],
            'array' => ['array', 'array'],
            'object' => ['object', 'object'],
            'callable' => ['callable', 'callable'],
            'resource' => ['resource', 'resource'],
            'mixed' => ['mixed', 'mixed'],
            'iterable' => ['iterable', 'iterable'],
        ];
    }
}
