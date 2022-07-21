<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests;

use FRZB\Component\PhpDocReader\Reader\ReaderService;
use FRZB\Component\PhpDocReader\Resolver\ResolverService;
use FRZB\Component\PhpDocReader\Tests\FixturesIssue87\Subspace\SomeDependencyFixture;
use FRZB\Component\PhpDocReader\Tests\FixturesIssue87\Subspace\SomeDependencyFixture2;
use PHPUnit\Framework\TestCase;

/**
 * @see https://github.com/mnapoli/PHP-DI/issues/87
 *
 * @internal
 */
class Issue87Test extends TestCase
{
    /**
     * This test ensures that use statements in class files take precedence in resolving type annotations.
     *
     * @see https://github.com/mnapoli/PHP-DI/issues/87
     */
    public function testGetParameterTypeUseStatementBeforeLocalNamespace(): void
    {
        $parser = new ReaderService(new ResolverService());

        $target1 = new FixturesIssue87\TargetFixture1();

        $target1ReflectionClass = new \ReflectionClass($target1);
        $target1ReflectionMethod = $target1ReflectionClass->getMethod('SomeMethod');
        $target1ReflectionParams = $target1ReflectionMethod->getParameters();

        $result = $parser->getParameterClass($target1ReflectionParams[0]);

        // Since TargetFixture1 file has a use statement to the Subspace namespace, that's the one that should be returned
        $this->assertEquals(SomeDependencyFixture::class, $result);

        $result = $parser->getParameterClass($target1ReflectionParams[1]);

        // this parameter should be unaffected by use namespace since it has a relative type path
        $this->assertEquals(SomeDependencyFixture2::class, $result);

        $target2 = new FixturesIssue87\TargetFixture2();

        $target2ReflectionClass = new \ReflectionClass($target2);
        $target2ReflectionMethod = $target2ReflectionClass->getMethod('SomeMethod');
        $target2ReflectionParams = $target2ReflectionMethod->getParameters();

        $result = $parser->getParameterClass($target2ReflectionParams[0]);

        // Since TargetFixture2 file has a use statement with an alias to the Subspace namespace, that's the one that should be returned
        $this->assertEquals(SomeDependencyFixture2::class, $result);

        $result = $parser->getParameterClass($target2ReflectionParams[1]);

        // this parameter should be unaffected by use namespace since it has a relative type path
        $this->assertEquals(SomeDependencyFixture2::class, $result);

        $target3 = new FixturesIssue87\TargetFixture3();

        $target3ReflectionClass = new \ReflectionClass($target3);
        $target3ReflectionMethod = $target3ReflectionClass->getMethod('SomeMethod');
        $target3ReflectionParams = $target3ReflectionMethod->getParameters();

        $result = $parser->getParameterClass($target3ReflectionParams[0]);

        // Since TargetFixture3 file has NO use statement, the one local to the target's namespace should be used
        $this->assertEquals(FixturesIssue87\SomeDependencyFixture::class, $result);

        $result = $parser->getParameterClass($target3ReflectionParams[1]);

        // this parameter should be unaffected by use namespace since it has a relative type path
        $this->assertEquals(SomeDependencyFixture2::class, $result);
    }

    /**
     * This test ensures that use statements in class files take precedence in resolving type annotations.
     *
     * @see https://github.com/mnapoli/PHP-DI/issues/87
     */
    public function testGetPropertyTypeUseStatementBeforeLocalNamespace(): void
    {
        $parser = new ReaderService(new ResolverService());

        $target1 = new FixturesIssue87\TargetFixture1();

        $target1ReflectionClass = new \ReflectionClass($target1);
        $target1ReflectionProperty1 = $target1ReflectionClass->getProperty('dependency1');

        $result = $parser->getPropertyClass($target1ReflectionProperty1);

        // Since TargetFixture1 file has a use statement to the Subspace namespace, that's the one that should be returned
        $this->assertEquals(SomeDependencyFixture::class, $result);

        $target1ReflectionProperty2 = $target1ReflectionClass->getProperty('dependency2');

        $result = $parser->getPropertyClass($target1ReflectionProperty2);

        // this property should be unaffected by use namespace since it has a relative type path
        $this->assertEquals(SomeDependencyFixture2::class, $result);

        $target2 = new FixturesIssue87\TargetFixture2();

        $target2ReflectionClass = new \ReflectionClass($target2);
        $target2ReflectionProperty1 = $target2ReflectionClass->getProperty('dependency1');

        $result = $parser->getPropertyClass($target2ReflectionProperty1);

        // Since TargetFixture2 file has a use statement with an alias to the Subspace namespace, that's the one that should be returned
        $this->assertEquals(SomeDependencyFixture2::class, $result);

        $target2ReflectionProperty2 = $target2ReflectionClass->getProperty('dependency2');

        $result = $parser->getPropertyClass($target2ReflectionProperty2);

        // this property should be unaffected by use namespace since it has a relative type path
        $this->assertEquals(SomeDependencyFixture2::class, $result);

        $target3 = new FixturesIssue87\TargetFixture3();

        $target3ReflectionClass = new \ReflectionClass($target3);
        $target3ReflectionProperty1 = $target3ReflectionClass->getProperty('dependency1');

        $result = $parser->getPropertyClass($target3ReflectionProperty1);

        // Since TargetFixture3 file has NO use statement, the one local to the target's namespace should be used
        $this->assertEquals(FixturesIssue87\SomeDependencyFixture::class, $result);

        $target3ReflectionProperty2 = $target3ReflectionClass->getProperty('dependency2');

        $result = $parser->getPropertyClass($target3ReflectionProperty2);

        // this property should be unaffected by use namespace since it has a relative type path
        $this->assertEquals(SomeDependencyFixture2::class, $result);
    }
}
