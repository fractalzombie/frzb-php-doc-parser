<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Helper;

use JetBrains\PhpStorm\Immutable;

/**
 * @internal
 */
#[Immutable]
final class TypeHelper
{
    public const PRIMITIVE_TYPES = [
        'bool' => 'bool',
        'boolean' => 'bool',
        'string' => 'string',
        'int' => 'int',
        'integer' => 'int',
        'float' => 'float',
        'double' => 'float',
        'array' => 'array',
        'object' => 'object',
        'callable' => 'callable',
        'resource' => 'resource',
        'mixed' => 'mixed',
        'iterable' => 'iterable',
    ];

    private function __construct()
    {
    }

    public static function isTypeExists(string $typeName): bool
    {
        return \array_key_exists($typeName, self::PRIMITIVE_TYPES);
    }

    public static function getType(string $typeName): ?string
    {
        return self::PRIMITIVE_TYPES[$typeName] ?? null;
    }
}
