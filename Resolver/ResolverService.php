<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Resolver;

use Doctrine\Common\Annotations\PhpParser;
use Fp\Collections\ArrayList;
use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\PhpDocReader\Helper\ClassHelper;

#[AsService]
class ResolverService implements ResolverServiceInterface
{
    public function __construct(
        private readonly PhpParser $parser = new PhpParser(),
    ) {
    }

    /** Get the Fully Qualified Name of the provided type based on the reflection class and reflection member context */
    public function getFullyQualifiedTypeName(string $typeName, \ReflectionClass $rClass, \Reflector $rMember): ?string
    {
        $alias = ($pos = strpos($typeName, '\\')) === false ? $typeName : substr($typeName, 0, $pos);
        $loweredAlias = strtolower($alias);
        $uses = $this->parser->parseUseStatements($rClass);

        return match (true) {
            \array_key_exists($loweredAlias, $uses) => match (true) {
                false !== $pos => $uses[$loweredAlias].substr($typeName, $pos),
                default => $uses[$loweredAlias],
            },
            ClassHelper::isTypeExists($rClass->getNamespaceName().'\\'.$typeName) => $rClass->getNamespaceName().'\\'.$typeName,
            \array_key_exists('__NAMESPACE__', $uses) && ClassHelper::isTypeExists($uses['__NAMESPACE__'].'\\'.$typeName) => $uses['__NAMESPACE__'].'\\'.$typeName,
            ClassHelper::isTypeExists($typeName) => $typeName,
            default => null,
        };
    }

    /** Get the Fully Qualified Name of the provided type based on the reflection class and reflection member context, specifically searching through the traits that are used by the provided reflection class */
    public function getFullyQualifiedTypeNameFromTraits(string $typeName, \ReflectionClass $rClass, \Reflector $rMember): ?string
    {
        $traits = [];

        while (null !== $rClass) {
            $traits = [...$traits, ...$rClass?->getTraits()];
            $rClass = $rClass->getParentClass() ?: null;
        }

        return ArrayList::collect($traits)
            ->filter(static fn (\ReflectionClass $trait) => match (true) {
                $rMember instanceof \ReflectionProperty && !$trait->hasProperty($rMember->getName()) => null,
                $rMember instanceof \ReflectionMethod && !$trait->hasMethod($rMember->getName()) => null,
                $rMember instanceof \ReflectionParameter && !$trait->hasMethod($rMember->getDeclaringFunction()->getName()) => null,
                default => $trait,
            })
            ->filter(static fn (?\ReflectionClass $trait) => null !== $trait)
            ->map(fn (\ReflectionClass $trait) => $this->getFullyQualifiedTypeName($typeName, $trait, $rMember))
            ->firstElement()
            ->get()
        ;
    }
}
