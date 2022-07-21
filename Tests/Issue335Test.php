<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests;

use FRZB\Component\PhpDocReader\ReaderService;
use FRZB\Component\PhpDocReader\Resolver\ResolverService;
use FRZB\Component\PhpDocReader\Tests\FixturesIssue335\Class3;
use FRZB\Component\PhpDocReader\Tests\FixturesIssue335\ClassX;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @see https://github.com/PHP-DI/PHP-DI/issues/335
 *
 * @internal
 */
class Issue335Test extends TestCase
{
    /**
     * This test ensures that namespaces are properly resolved for aliases that are defined in traits.
     *
     * @see https://github.com/PHP-DI/PHP-DI/issues/335
     */
    public function testNamespaceResolutionForTraits(): void
    {
        $parser = new ReaderService(new ResolverService());

        $target = new Class3();

        $class = new ReflectionClass($target);

        $this->assertEquals(ClassX::class, $parser->getPropertyClass($class->getProperty('propTrait1')));
        $this->assertEquals(ClassX::class, $parser->getPropertyClass($class->getProperty('propTrait2')));

        $params = $class->getMethod('methodTrait1')->getParameters();
        $this->assertEquals(ClassX::class, $parser->getParameterClass($params[0]));

        $params = $class->getMethod('methodTrait2')->getParameters();
        $this->assertEquals(ClassX::class, $parser->getParameterClass($params[0]));
    }
}
