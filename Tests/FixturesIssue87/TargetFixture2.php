<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests\FixturesIssue87;

use FRZB\Component\PhpDocReader\Tests\FixturesIssue87\Subspace\SomeDependencyFixture2 as SomeDependencyFixture;

/**
 * Has a dependency locally aliased to a name in the local namespace of the targets.
 */
class TargetFixture2
{
    /** @var SomeDependencyFixture */
    protected $dependency1;

    /** @var Subspace\SomeDependencyFixture2 */
    protected $dependency2;

    /**
     * @param SomeDependencyFixture           $dependency1
     * @param Subspace\SomeDependencyFixture2 $dependency2
     */
    public function SomeMethod($dependency1, $dependency2): void
    {
    }
}
