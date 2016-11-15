<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\Util\ValueExporter;
<<<<<<< HEAD
use Symfony\Component\VarDumper\Caster\CutStub;
use Symfony\Component\VarDumper\Cloner\ClonerInterface;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Cloner\Stub;
use Symfony\Component\VarDumper\Cloner\VarCloner;
=======
>>>>>>> web and vendor directory from composer install

/**
 * DataCollector.
 *
 * Children of this class must store the collected data in the data property.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Bernhard Schussek <bschussek@symfony.com>
 */
abstract class DataCollector implements DataCollectorInterface, \Serializable
{
    protected $data = array();

    /**
     * @var ValueExporter
     */
    private $valueExporter;

<<<<<<< HEAD
    /**
     * @var ClonerInterface
     */
    private $cloner;

=======
>>>>>>> web and vendor directory from composer install
    public function serialize()
    {
        return serialize($this->data);
    }

    public function unserialize($data)
    {
        $this->data = unserialize($data);
    }

    /**
<<<<<<< HEAD
     * Converts the variable into a serializable Data instance.
     *
     * This array can be displayed in the template using
     * the VarDumper component.
     *
     * @param mixed $var
     *
     * @return Data
     */
    protected function cloneVar($var)
    {
        if ($var instanceof Data) {
            return $var;
        }
        if (null === $this->cloner) {
            if (class_exists(CutStub::class)) {
                $this->cloner = new VarCloner();
                $this->cloner->setMaxItems(-1);
                $this->cloner->addCasters($this->getCasters());
            } else {
                @trigger_error(sprintf('Using the %s() method without the VarDumper component is deprecated since Symfony 3.2 and won\'t be supported in 4.0. Install symfony/var-dumper version 3.2 or above.', __METHOD__), E_USER_DEPRECATED);
                $this->cloner = false;
            }
        }
        if (false === $this->cloner) {
            if (null === $this->valueExporter) {
                $this->valueExporter = new ValueExporter();
            }

            return $this->valueExporter->exportValue($var);
        }

        return $this->cloner->cloneVar($var);
    }

    /**
=======
>>>>>>> web and vendor directory from composer install
     * Converts a PHP variable to a string.
     *
     * @param mixed $var A PHP variable
     *
     * @return string The string representation of the variable
<<<<<<< HEAD
     *
     * @deprecated since version 3.2, to be removed in 4.0. Use cloneVar() instead.
     */
    protected function varToString($var)
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.2 and will be removed in 4.0. Use cloneVar() instead.', __METHOD__), E_USER_DEPRECATED);

=======
     */
    protected function varToString($var)
    {
>>>>>>> web and vendor directory from composer install
        if (null === $this->valueExporter) {
            $this->valueExporter = new ValueExporter();
        }

        return $this->valueExporter->exportValue($var);
    }
<<<<<<< HEAD

    /**
     * @return callable[] The casters to add to the cloner
     */
    protected function getCasters()
    {
        return array(
            '*' => function ($v, array $a, Stub $s, $isNested) {
                if (!$v instanceof Stub) {
                    foreach ($a as $k => $v) {
                        if (is_object($v) && !$v instanceof \DateTimeInterface && !$v instanceof Stub) {
                            $a[$k] = new CutStub($v);
                        }
                    }
                }

                return $a;
            },
        );
    }
=======
>>>>>>> web and vendor directory from composer install
}
