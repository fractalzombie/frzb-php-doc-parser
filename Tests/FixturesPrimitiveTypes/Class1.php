<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests\FixturesPrimitiveTypes;

class Class1
{
    /** @var bool */
    public $bool;

    /** @var bool */
    public $boolean;

    /** @var string */
    public $string;

    /** @var int */
    public $int;

    /** @var int */
    public $integer;

    /** @var float */
    public $float;

    /** @var float */
    public $double;

    /** @var array */
    public $array;

    /** @var object */
    public $object;

    /** @var callable */
    public $callable;

    /** @var resource */
    public $resource;

    /** @var mixed */
    public $mixed;

    /** @var iterable */
    public $iterable;

    /**
     * @param bool     $bool
     * @param bool     $boolean
     * @param string   $string
     * @param int      $int
     * @param int      $integer
     * @param float    $float
     * @param float    $double
     * @param array    $array
     * @param object   $object
     * @param callable $callable
     * @param resource $resource
     * @param mixed    $mixed
     * @param iterable $iterable
     */
    public function foo(
        $bool,
        $boolean,
        $string,
        $int,
        $integer,
        $float,
        $double,
        $array,
        $object,
        $callable,
        $resource,
        $mixed,
        $iterable,
    ): void {
    }
}
