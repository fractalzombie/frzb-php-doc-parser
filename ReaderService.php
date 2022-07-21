<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader;

use FRZB\Component\PhpDocReader\Exception\ReaderException;
use FRZB\Component\PhpDocReader\Helper\ClassHelper;
use FRZB\Component\PhpDocReader\Helper\TypeHelper;
use FRZB\Component\PhpDocReader\Resolver\ResolverServiceInterface as Resolver;

final class ReaderService implements ReaderInterface
{
    public function __construct(
        private readonly Resolver $resolver,
    ) {
    }

    /** @throws ReaderException */
    public function getPropertyType(\ReflectionProperty $property): ?string
    {
        return $this->readPropertyType($property, true);
    }

    /** @throws ReaderException */
    public function getPropertyClass(\ReflectionProperty $property): ?string
    {
        return $this->readPropertyType($property, false);
    }

    /** @throws ReaderException */
    public function getParameterType(\ReflectionParameter $parameter): ?string
    {
        return $this->readParameterClass($parameter, true);
    }

    /** @throws ReaderException */
    public function getParameterClass(\ReflectionParameter $parameter): ?string
    {
        return $this->readParameterClass($parameter, false);
    }

    /** @throws ReaderException */
    private function readPropertyType(\ReflectionProperty $property, bool $allowPrimitiveTypes): ?string
    {
        // Get the content of the @var annotation
        $docComment = $property->getDocComment();
        $class = $property->getDeclaringClass();

        if (!$docComment) {
            return null;
        }

        if (preg_match('/@var\s+(\S+)/', $docComment, $matches)) {
            [, $type] = $matches;
        } else {
            return null;
        }

        // Ignore primitive types
        if (TypeHelper::isTypeExists($type)) {
            return $allowPrimitiveTypes ? TypeHelper::getType($type) : null;
        }

        // Ignore types containing special characters ([], <> ...)
        if (!preg_match('/^[\w+\\\\]+$/', $type)) {
            return null;
        }

        // If the class name is not fully qualified (i.e. doesn't start with a \)
        if ('\\' !== $type[0]) {
            // Remove types containing special characters ([], <> ...)
            $type = preg_replace(['/<\w+,\s?\w+>|<\w+?>/', '/[\[\]]+/'], '', $type);
            // Try to resolve the FQN using the class context
            $resolvedType = $this->resolver->getFullyQualifiedTypeName($type, $class, $property)
                ?? $this->resolver->getFullyQualifiedTypeNameFromTraits($type, $class, $property);

            if (!$resolvedType) {
                throw ReaderException::notExistForgetUseStatementInVar(
                    $class->getName(),
                    $property->getName(),
                    $type
                );
            }

            $type = $resolvedType;
        }

        if (!ClassHelper::isTypeExists($type)) {
            throw ReaderException::notExistInVar($class->getName(), $property->getName(), $type);
        }

        // Remove the leading \ (FQN shouldn't contain it)
        return \is_string($type) ? ltrim($type, '\\') : null;
    }

    /** @throws ReaderException */
    private function readParameterClass(\ReflectionParameter $parameter, bool $allowPrimitiveTypes): ?string
    {
        $parameterType = $parameter->getType();

        if ($parameterType instanceof \ReflectionNamedType && !$parameterType->isBuiltin()) {
            return $parameterType->getName();
        }

        $parameterName = $parameter->getName();
        $method = $parameter->getDeclaringFunction();
        $docComment = $method->getDocComment();
        $class = $parameter->getDeclaringClass();

        if (!$docComment) {
            return null;
        }

        if (preg_match('/@param\s+(\S+)\s+\$'.$parameterName.'/', $docComment, $matches)) {
            [, $type] = $matches;
        } else {
            return null;
        }

        // Ignore primitive types
        if (TypeHelper::isTypeExists($type)) {
            return $allowPrimitiveTypes ? TypeHelper::getType($type) : null;
        }

        // Ignore types containing special characters ([], <> ...)
        if (!preg_match('/^[\w+\\\\]+$/', $type)) {
            return null;
        }

        // If the class name is not fully qualified (i.e. doesn't start with a \)
        if ('\\' !== $type[0]) {
            // Try to resolve the FQN using the class context
            $resolvedType = $this->resolver->getFullyQualifiedTypeName($type, $class, $parameter)
                ?? $this->resolver->getFullyQualifiedTypeNameFromTraits($type, $class, $parameter);

            if (!$resolvedType) {
                throw ReaderException::notExistForgetUseStatementInParam(
                    $parameterName,
                    $class->getName(),
                    $method->getName(),
                    $type
                );
            }

            $type = $resolvedType;
        }

        if (!ClassHelper::isTypeExists($type)) {
            throw ReaderException::notExistInParam($parameterName, $class->getName(), $method->getName(), $type);
        }

        // Remove the leading \ (FQN shouldn't contain it)
        return \is_string($type) ? ltrim($type, '\\') : null;
    }
}
