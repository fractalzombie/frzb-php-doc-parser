<?php

declare(strict_types=1);

namespace FRZB\Component\PhpDocReader\Tests\Fixtures;

use FRZB\Component\PhpDocReader\Tests\Fixtures\Class3 as ClassClass3;

class Class1
{
    public $propNone;

    /** @var \FRZB\Component\PhpDocReader\Tests\Fixtures\Class2 */
    public $propFQN;

    /** @var Class2 */
    public $propLocalName;

    /** @var ClassClass3 */
    public $propAlias;

    /**
     * @param                                                    $paramNone
     * @param                                                    $paramTypeHint
     * @param \FRZB\Component\PhpDocReader\Tests\Fixtures\Class2 $paramFQN
     * @param Class2                                             $paramLocalName
     * @param ClassClass3                                        $paramAlias
     */
    public function foo($paramNone, Class2 $paramTypeHint, $paramFQN, $paramLocalName, $paramAlias): void
    {
    }
}
