<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Process;

<<<<<<< HEAD
@trigger_error(sprintf('The %s class is deprecated since Symfony 3.4 and will be removed in 4.0. Use the Process class instead.', ProcessBuilder::class), E_USER_DEPRECATED);

=======
>>>>>>> web and vendor directory from composer install
use Symfony\Component\Process\Exception\InvalidArgumentException;
use Symfony\Component\Process\Exception\LogicException;

/**
<<<<<<< HEAD
 * @author Kris Wallsmith <kris@symfony.com>
 *
 * @deprecated since version 3.4, to be removed in 4.0. Use the Process class instead.
=======
 * Process builder.
 *
 * @author Kris Wallsmith <kris@symfony.com>
>>>>>>> web and vendor directory from composer install
 */
class ProcessBuilder
{
    private $arguments;
    private $cwd;
    private $env = array();
    private $input;
    private $timeout = 60;
<<<<<<< HEAD
    private $options;
=======
    private $options = array();
>>>>>>> web and vendor directory from composer install
    private $inheritEnv = true;
    private $prefix = array();
    private $outputDisabled = false;

    /**
<<<<<<< HEAD
=======
     * Constructor.
     *
>>>>>>> web and vendor directory from composer install
     * @param string[] $arguments An array of arguments
     */
    public function __construct(array $arguments = array())
    {
        $this->arguments = $arguments;
    }

    /**
     * Creates a process builder instance.
     *
     * @param string[] $arguments An array of arguments
     *
<<<<<<< HEAD
     * @return static
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public static function create(array $arguments = array())
    {
        return new static($arguments);
    }

    /**
     * Adds an unescaped argument to the command string.
     *
     * @param string $argument A command argument
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public function add($argument)
    {
        $this->arguments[] = $argument;

        return $this;
    }

    /**
     * Adds a prefix to the command string.
     *
     * The prefix is preserved when resetting arguments.
     *
     * @param string|array $prefix A command prefix or an array of command prefixes
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public function setPrefix($prefix)
    {
        $this->prefix = is_array($prefix) ? $prefix : array($prefix);

        return $this;
    }

    /**
     * Sets the arguments of the process.
     *
     * Arguments must not be escaped.
     * Previous arguments are removed.
     *
     * @param string[] $arguments
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Sets the working directory.
     *
     * @param null|string $cwd The working directory
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public function setWorkingDirectory($cwd)
    {
        $this->cwd = $cwd;

        return $this;
    }

    /**
     * Sets whether environment variables will be inherited or not.
     *
     * @param bool $inheritEnv
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public function inheritEnvironmentVariables($inheritEnv = true)
    {
        $this->inheritEnv = $inheritEnv;

        return $this;
    }

    /**
     * Sets an environment variable.
     *
     * Setting a variable overrides its previous value. Use `null` to unset a
     * defined environment variable.
     *
     * @param string      $name  The variable name
     * @param null|string $value The variable value
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public function setEnv($name, $value)
    {
        $this->env[$name] = $value;

        return $this;
    }

    /**
     * Adds a set of environment variables.
     *
     * Already existing environment variables with the same name will be
     * overridden by the new values passed to this method. Pass `null` to unset
     * a variable.
     *
     * @param array $variables The variables
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public function addEnvironmentVariables(array $variables)
    {
        $this->env = array_replace($this->env, $variables);

        return $this;
    }

    /**
     * Sets the input of the process.
     *
<<<<<<< HEAD
     * @param resource|string|int|float|bool|\Traversable|null $input The input content
     *
     * @return $this
     *
     * @throws InvalidArgumentException In case the argument is invalid
=======
     * @param mixed $input The input as a string
     *
     * @return ProcessBuilder
     *
     * @throws InvalidArgumentException In case the argument is invalid
     *
     * Passing an object as an input is deprecated since version 2.5 and will be removed in 3.0.
>>>>>>> web and vendor directory from composer install
     */
    public function setInput($input)
    {
        $this->input = ProcessUtils::validateInput(__METHOD__, $input);

        return $this;
    }

    /**
     * Sets the process timeout.
     *
     * To disable the timeout, set this value to null.
     *
     * @param float|null $timeout
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     *
     * @throws InvalidArgumentException
     */
    public function setTimeout($timeout)
    {
        if (null === $timeout) {
            $this->timeout = null;

            return $this;
        }

        $timeout = (float) $timeout;

        if ($timeout < 0) {
            throw new InvalidArgumentException('The timeout value must be a valid positive integer or float number.');
        }

        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Adds a proc_open option.
     *
     * @param string $name  The option name
     * @param string $value The option value
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * Disables fetching output and error output from the underlying process.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public function disableOutput()
    {
        $this->outputDisabled = true;

        return $this;
    }

    /**
     * Enables fetching output and error output from the underlying process.
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return ProcessBuilder
>>>>>>> web and vendor directory from composer install
     */
    public function enableOutput()
    {
        $this->outputDisabled = false;

        return $this;
    }

    /**
     * Creates a Process instance and returns it.
     *
     * @return Process
     *
     * @throws LogicException In case no arguments have been provided
     */
    public function getProcess()
    {
        if (0 === count($this->prefix) && 0 === count($this->arguments)) {
            throw new LogicException('You must add() command arguments before calling getProcess().');
        }

<<<<<<< HEAD
        $arguments = array_merge($this->prefix, $this->arguments);
        $process = new Process($arguments, $this->cwd, $this->env, $this->input, $this->timeout, $this->options);
        // to preserve the BC with symfony <3.3, we convert the array structure
        // to a string structure to avoid the prefixing with the exec command
        $process->setCommandLine($process->getCommandLine());

        if ($this->inheritEnv) {
            $process->inheritEnvironmentVariables();
        }
=======
        $options = $this->options;

        $arguments = array_merge($this->prefix, $this->arguments);
        $script = implode(' ', array_map(array(__NAMESPACE__.'\\ProcessUtils', 'escapeArgument'), $arguments));

        if ($this->inheritEnv) {
            // include $_ENV for BC purposes
            $env = array_replace($_ENV, $_SERVER, $this->env);
        } else {
            $env = $this->env;
        }

        $process = new Process($script, $this->cwd, $env, $this->input, $this->timeout, $options);

>>>>>>> web and vendor directory from composer install
        if ($this->outputDisabled) {
            $process->disableOutput();
        }

        return $process;
    }
}
