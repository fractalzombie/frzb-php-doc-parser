# PhpDocReader

[![CI](https://github.com/fractalzombie/frzb-php-doc-parser/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/fractalzombie/frzb-php-doc-parser/actions/workflows/ci.yml)

Fork the README to add your project here.

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
