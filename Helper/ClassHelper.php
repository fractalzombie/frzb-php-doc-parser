<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Helper;

use JetBrains\PhpStorm\Immutable;

/**
 * @internal
 */
#[Immutable]
final class ClassHelper
{
    private function __construct()
    {
    }

    public static function isTypeExists(string $typeName): bool
    {
        return class_exists($typeName) || interface_exists($typeName);
    }
}
