<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests\FixturesUnknownTypes;

class Class1
{
    /** @var */
    public $empty;

    /** @var Foo[] */
    public $array;

    /** @var array<Foo> */
    public $generics;

    /** @var Bar|Foo */
    public $multiple;

    /**
     * @param            $empty
     * @param Foo[]      $array
     * @param array<Foo> $generics
     * @param Bar|Foo    $multiple
     */
    public function foo(
        $empty,
        $array,
        $generics,
        $multiple
    ): void {
    }
}
