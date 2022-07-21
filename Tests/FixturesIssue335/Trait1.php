<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests\FixturesIssue335;

use FRZB\Component\PhpDocReader\Tests\FixturesIssue335\ClassX as Foo;
use FRZB\Component\PhpDocReader\Tests\FixturesIssue335\ClassX as MethodFoo;

trait Trait1
{
    /** @var Foo */
    protected $propTrait1;

    /** @param MethodFoo $parameter */
    public function methodTrait1($parameter): void
    {
    }
}
