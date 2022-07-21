<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Resolver;

use FRZB\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(ResolverService::class)]
interface ResolverServiceInterface
{
    public function getFullyQualifiedTypeName(string $typeName, \ReflectionClass $rClass, \Reflector $rMember): ?string;

    public function getFullyQualifiedTypeNameFromTraits(string $typeName, \ReflectionClass $rClass, \Reflector $rMember): ?string;
}
