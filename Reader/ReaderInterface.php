<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Reader;

use FRZB\Component\DependencyInjection\Attribute\AsAlias;
use FRZB\Component\PhpDocReader\Exception\ReaderException;

#[AsAlias(ReaderService::class)]
interface ReaderInterface
{
    /** @throws ReaderException */
    public function getPropertyType(\ReflectionProperty $property): ?string;

    /** @throws ReaderException */
    public function getPropertyClass(\ReflectionProperty $property): ?string;

    /** @throws ReaderException */
    public function getParameterType(\ReflectionParameter $parameter): ?string;

    /** @throws ReaderException */
    public function getParameterClass(\ReflectionParameter $parameter): ?string;
}
