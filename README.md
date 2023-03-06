# PhpDocReader

[![CI](https://github.com/fractalzombie/frzb-php-doc-parser/actions/workflows/build.yml/badge.svg?branch=master)](https://github.com/fractalzombie/frzb-php-doc-parser/actions/workflows/ci.yml)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-php-doc-parser&metric=bugs)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-php-doc-parser)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-php-doc-parser&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-php-doc-parser)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-php-doc-parser&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-php-doc-parser)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-php-doc-parser&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-php-doc-parser)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-php-doc-parser&metric=ncloc)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-php-doc-parser)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-php-doc-parser&metric=coverage)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-php-doc-parser)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-php-doc-parser&metric=sqale_index)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-php-doc-parser)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-php-doc-parser&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-php-doc-parser)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-php-doc-parser&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-php-doc-parser)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-php-doc-parser&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-php-doc-parser)

## Features

PhpDocReader parses `@var` and `@param` values in PHP DocBlock:

```php

use My\Cache\Backend;

class Cache
{
    /**
     * @var Backend
     */
    protected $backend;

    /**
     * @param Backend $backend
     */
    public function __construct($backend)
    {
    }
}
```

It supports namespaced class names with the same resolution rules as PHP:

- fully qualified name (starting with `\`)
- imported class name (eg. `use My\Cache\Backend;`)
- relative class name (from the current namespace, like `SubNamespace\MyClass`)
- aliased class name  (eg. `use My\Cache\Backend as FooBar;`)

Primitive types (`@var string`) are ignored (returns null), only valid class names are returned.

## Usage

```php
$reader = new Reader();

// Read a property type (@var phpdoc)
$property = new ReflectionProperty($className, $propertyName);
$propertyClass = $reader->getPropertyClass($property);

// Read a parameter type (@param phpdoc)
$parameter = new ReflectionParameter([$className, $methodName], $parameterName);
$parameterClass = $reader->getParameterClass($parameter);
```
