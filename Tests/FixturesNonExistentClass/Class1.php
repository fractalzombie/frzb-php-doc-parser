<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests\FixturesNonExistentClass;

class Class1
{
    /** @var Foo */
    public $prop;

    /** @param Foo $param */
    public function foo($param): void
    {
    }
}
