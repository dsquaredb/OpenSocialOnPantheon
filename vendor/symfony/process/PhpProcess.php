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

use Symfony\Component\Process\Exception\RuntimeException;

/**
 * PhpProcess runs a PHP script in an independent process.
 *
 * $p = new PhpProcess('<?php echo "foo"; ?>');
 * $p->run();
 * print $p->getOutput()."\n";
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class PhpProcess extends Process
{
    /**
<<<<<<< HEAD
=======
     * Constructor.
     *
>>>>>>> web and vendor directory from composer install
     * @param string      $script  The PHP script to run (as a string)
     * @param string|null $cwd     The working directory or null to use the working dir of the current PHP process
     * @param array|null  $env     The environment variables or null to use the same environment as the current PHP process
     * @param int         $timeout The timeout in seconds
     * @param array       $options An array of options for proc_open
     */
<<<<<<< HEAD
    public function __construct($script, $cwd = null, array $env = null, $timeout = 60, array $options = null)
    {
        $executableFinder = new PhpExecutableFinder();
        if (false === $php = $executableFinder->find(false)) {
            $php = null;
        } else {
            $php = array_merge(array($php), $executableFinder->findArguments());
=======
    public function __construct($script, $cwd = null, array $env = null, $timeout = 60, array $options = array())
    {
        $executableFinder = new PhpExecutableFinder();
        if (false === $php = $executableFinder->find()) {
            $php = null;
>>>>>>> web and vendor directory from composer install
        }
        if ('phpdbg' === PHP_SAPI) {
            $file = tempnam(sys_get_temp_dir(), 'dbg');
            file_put_contents($file, $script);
            register_shutdown_function('unlink', $file);
<<<<<<< HEAD
            $php[] = $file;
            $script = null;
        }
        if (null !== $options) {
            @trigger_error(sprintf('The $options parameter of the %s constructor is deprecated since Symfony 3.3 and will be removed in 4.0.', __CLASS__), E_USER_DEPRECATED);
=======
            $php .= ' '.ProcessUtils::escapeArgument($file);
            $script = null;
        }
        if ('\\' !== DIRECTORY_SEPARATOR && null !== $php) {
            // exec is mandatory to deal with sending a signal to the process
            // see https://github.com/symfony/symfony/issues/5030 about prepending
            // command with exec
            $php = 'exec '.$php;
>>>>>>> web and vendor directory from composer install
        }

        parent::__construct($php, $cwd, $env, $script, $timeout, $options);
    }

    /**
     * Sets the path to the PHP binary to use.
     */
    public function setPhpBinary($php)
    {
        $this->setCommandLine($php);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function start(callable $callback = null/*, array $env = array()*/)
=======
    public function start($callback = null)
>>>>>>> web and vendor directory from composer install
    {
        if (null === $this->getCommandLine()) {
            throw new RuntimeException('Unable to find the PHP executable.');
        }
<<<<<<< HEAD
        $env = 1 < func_num_args() ? func_get_arg(1) : null;

        parent::start($callback, $env);
=======

        parent::start($callback);
>>>>>>> web and vendor directory from composer install
    }
}
