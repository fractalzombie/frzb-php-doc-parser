<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests\FixturesIssue335;

use FRZB\Component\PhpDocReader\Tests\FixturesIssue335\ClassX as Bar;
use FRZB\Component\PhpDocReader\Tests\FixturesIssue335\ClassX as MethodBar;

trait Trait2
{
    /** @var Bar */
    protected $propTrait2;

    /** @param MethodBar $parameter */
    public function methodTrait2($parameter): void
    {
    }
}
