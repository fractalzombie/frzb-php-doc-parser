<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests;

use FRZB\Component\PhpDocReader\ReaderService;
use FRZB\Component\PhpDocReader\Resolver\ResolverService;
use FRZB\Component\PhpDocReader\Tests\Fixtures\Class1;
use FRZB\Component\PhpDocReader\Tests\Fixtures\Class2;
use FRZB\Component\PhpDocReader\Tests\Fixtures\Class3;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class FunctionalTest extends TestCase
{
    public function testReadPropertyType(): void
    {
        $parser = new ReaderService(new ResolverService());

        $className = Class1::class;

        $type = $parser->getPropertyClass(new \ReflectionProperty($className, 'propNone'));
        self::assertNull($type);

        $type = $parser->getPropertyClass(new \ReflectionProperty($className, 'propFQN'));
        self::assertEquals(Class2::class, $type);

        $type = $parser->getPropertyClass(new \ReflectionProperty($className, 'propLocalName'));
        self::assertEquals(Class2::class, $type);

        $type = $parser->getPropertyClass(new \ReflectionProperty($className, 'propAlias'));
        self::assertEquals(Class3::class, $type);
    }

    public function testReadParamType(): void
    {
        $parser = new ReaderService(new ResolverService());

        $method = [Class1::class, 'foo'];

        $type = $parser->getParameterClass(new \ReflectionParameter($method, 'paramNone'));
        self::assertNull($type);

        $type = $parser->getParameterClass(new \ReflectionParameter($method, 'paramTypeHint'));
        self::assertEquals(Class2::class, $type);

        $type = $parser->getParameterClass(new \ReflectionParameter($method, 'paramFQN'));
        self::assertEquals(Class2::class, $type);

        $type = $parser->getParameterClass(new \ReflectionParameter($method, 'paramLocalName'));
        self::assertEquals(Class2::class, $type);

        $type = $parser->getParameterClass(new \ReflectionParameter($method, 'paramAlias'));
        self::assertEquals(Class3::class, $type);
    }
}
