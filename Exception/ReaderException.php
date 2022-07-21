<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Exception;

class ReaderException extends \LogicException
{
    private const DEFAULT_VAR_MESSAGE = 'The @var annotation on %s::%s contains a non existent class "%s".';
    private const DEFAULT_VAR_MESSAGE_WITH_USE_STATEMENT = 'The @var annotation on %s::%s contains a non existent class "%s". Did you maybe forget to add a "use" statement for this annotation?';
    private const DEFAULT_PARAM_MESSAGE = 'The @param annotation for parameter "%s" of %s::%s contains a non existent class "%s".';
    private const DEFAULT_PARAM_MESSAGE_WITH_USE_STATEMENT = 'The @param annotation for parameter "%s" of %s::%s contains a non existent class "%s". Did you maybe forget to add a "use" statement for this annotation?';

    public static function notExistForgetUseStatementInVar(string $className, string $propertyName, string $phpDocType, ?\Throwable $previous = null): self
    {
        $message = sprintf(self::DEFAULT_VAR_MESSAGE_WITH_USE_STATEMENT, $className, $propertyName, $phpDocType);

        return new self($message, previous: $previous);
    }

    public static function notExistInVar(string $className, string $propertyName, string $phpDocType, ?\Throwable $previous = null): self
    {
        $message = sprintf(self::DEFAULT_VAR_MESSAGE, $className, $propertyName, $phpDocType);

        return new self($message, previous: $previous);
    }

    public static function notExistForgetUseStatementInParam(string $parameterName, string $className, string $methodName, string $phpDocType, ?\Throwable $previous = null): self
    {
        $message = sprintf(self::DEFAULT_PARAM_MESSAGE_WITH_USE_STATEMENT, $parameterName, $className, $methodName, $phpDocType);

        return new self($message, previous: $previous);
    }

    public static function notExistInParam(string $parameterName, string $className, string $methodName, string $phpDocType, ?\Throwable $previous = null): self
    {
        $message = sprintf(self::DEFAULT_PARAM_MESSAGE, $parameterName, $className, $methodName, $phpDocType);

        return new self($message, previous: $previous);
    }
}
