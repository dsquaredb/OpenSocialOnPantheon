<?php

namespace PhpParser\Node;

use PhpParser\Error;
use PhpParser\NodeAbstract;

class Param extends NodeAbstract
{
    /** @var null|string|Name Typehint */
    public $type;
    /** @var bool Whether parameter is passed by reference */
    public $byRef;
    /** @var bool Whether this is a variadic argument */
    public $variadic;
<<<<<<< HEAD
<<<<<<< HEAD
    /** @var string Name */
    public $name;
=======
    /** @var Expr\Variable|Expr\Error Parameter variable */
=======
    /** @var Expr\Variable Parameter variable */
>>>>>>> revert Open Social update
    public $var;
>>>>>>> Update Open Social to 8.x-2.1
    /** @var null|Expr Default value */
    public $default;

    /**
     * Constructs a parameter node.
     *
<<<<<<< HEAD
<<<<<<< HEAD
     * @param string           $name       Name
     * @param null|Expr        $default    Default value
     * @param null|string|Name $type       Typehint
     * @param bool             $byRef      Whether is passed by reference
     * @param bool             $variadic   Whether this is a variadic argument
     * @param array            $attributes Additional attributes
     */
    public function __construct($name, Expr $default = null, $type = null, $byRef = false, $variadic = false, array $attributes = array()) {
=======
     * @param Expr\Variable|Expr\Error      $var        Parameter variable
=======
     * @param Expr\Variable                 $var        Parameter variable
>>>>>>> revert Open Social update
     * @param null|Expr                     $default    Default value
     * @param null|string|Name|NullableType $type       Typehint
     * @param bool                          $byRef      Whether is passed by reference
     * @param bool                          $variadic   Whether this is a variadic argument
     * @param array                         $attributes Additional attributes
     */
    public function __construct(
        Expr\Variable $var, Expr $default = null, $type = null,
        bool $byRef = false, bool $variadic = false, array $attributes = []
    ) {
>>>>>>> Update Open Social to 8.x-2.1
        parent::__construct($attributes);
        $this->type = $type;
        $this->byRef = $byRef;
        $this->variadic = $variadic;
        $this->name = $name;
        $this->default = $default;

        if ($variadic && null !== $default) {
            throw new Error('Variadic parameter cannot have a default value', $default->getAttributes());
        }
    }

    public function getSubNodeNames() {
        return array('type', 'byRef', 'variadic', 'name', 'default');
    }
}
