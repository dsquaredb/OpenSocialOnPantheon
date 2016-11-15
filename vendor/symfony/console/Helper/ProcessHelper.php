<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Helper;

use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
<<<<<<< HEAD
=======
use Symfony\Component\Process\ProcessBuilder;
>>>>>>> web and vendor directory from composer install

/**
 * The ProcessHelper class provides helpers to run external processes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ProcessHelper extends Helper
{
    /**
     * Runs an external process.
     *
     * @param OutputInterface      $output    An OutputInterface instance
     * @param string|array|Process $cmd       An instance of Process or an array of arguments to escape and run or a command to run
     * @param string|null          $error     An error message that must be displayed if something went wrong
     * @param callable|null        $callback  A PHP callback to run whenever there is some
     *                                        output available on STDOUT or STDERR
     * @param int                  $verbosity The threshold for verbosity
     *
     * @return Process The process that ran
     */
<<<<<<< HEAD
    public function run(OutputInterface $output, $cmd, $error = null, callable $callback = null, $verbosity = OutputInterface::VERBOSITY_VERY_VERBOSE)
=======
    public function run(OutputInterface $output, $cmd, $error = null, $callback = null, $verbosity = OutputInterface::VERBOSITY_VERY_VERBOSE)
>>>>>>> web and vendor directory from composer install
    {
        if ($output instanceof ConsoleOutputInterface) {
            $output = $output->getErrorOutput();
        }

        $formatter = $this->getHelperSet()->get('debug_formatter');

<<<<<<< HEAD
        if ($cmd instanceof Process) {
=======
        if (is_array($cmd)) {
            $process = ProcessBuilder::create($cmd)->getProcess();
        } elseif ($cmd instanceof Process) {
>>>>>>> web and vendor directory from composer install
            $process = $cmd;
        } else {
            $process = new Process($cmd);
        }

        if ($verbosity <= $output->getVerbosity()) {
            $output->write($formatter->start(spl_object_hash($process), $this->escapeString($process->getCommandLine())));
        }

        if ($output->isDebug()) {
            $callback = $this->wrapCallback($output, $process, $callback);
        }

        $process->run($callback);

        if ($verbosity <= $output->getVerbosity()) {
            $message = $process->isSuccessful() ? 'Command ran successfully' : sprintf('%s Command did not run successfully', $process->getExitCode());
            $output->write($formatter->stop(spl_object_hash($process), $message, $process->isSuccessful()));
        }

        if (!$process->isSuccessful() && null !== $error) {
            $output->writeln(sprintf('<error>%s</error>', $this->escapeString($error)));
        }

        return $process;
    }

    /**
     * Runs the process.
     *
     * This is identical to run() except that an exception is thrown if the process
     * exits with a non-zero exit code.
     *
     * @param OutputInterface $output   An OutputInterface instance
     * @param string|Process  $cmd      An instance of Process or a command to run
     * @param string|null     $error    An error message that must be displayed if something went wrong
     * @param callable|null   $callback A PHP callback to run whenever there is some
     *                                  output available on STDOUT or STDERR
     *
     * @return Process The process that ran
     *
     * @throws ProcessFailedException
     *
     * @see run()
     */
<<<<<<< HEAD
    public function mustRun(OutputInterface $output, $cmd, $error = null, callable $callback = null)
=======
    public function mustRun(OutputInterface $output, $cmd, $error = null, $callback = null)
>>>>>>> web and vendor directory from composer install
    {
        $process = $this->run($output, $cmd, $error, $callback);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process;
    }

    /**
     * Wraps a Process callback to add debugging output.
     *
     * @param OutputInterface $output   An OutputInterface interface
     * @param Process         $process  The Process
     * @param callable|null   $callback A PHP callable
     *
     * @return callable
     */
<<<<<<< HEAD
    public function wrapCallback(OutputInterface $output, Process $process, callable $callback = null)
=======
    public function wrapCallback(OutputInterface $output, Process $process, $callback = null)
>>>>>>> web and vendor directory from composer install
    {
        if ($output instanceof ConsoleOutputInterface) {
            $output = $output->getErrorOutput();
        }

        $formatter = $this->getHelperSet()->get('debug_formatter');

<<<<<<< HEAD
        return function ($type, $buffer) use ($output, $process, $callback, $formatter) {
            $output->write($formatter->progress(spl_object_hash($process), $this->escapeString($buffer), Process::ERR === $type));
=======
        $that = $this;

        return function ($type, $buffer) use ($output, $process, $callback, $formatter, $that) {
            $output->write($formatter->progress(spl_object_hash($process), $that->escapeString($buffer), Process::ERR === $type));
>>>>>>> web and vendor directory from composer install

            if (null !== $callback) {
                call_user_func($callback, $type, $buffer);
            }
        };
    }

<<<<<<< HEAD
    private function escapeString($str)
=======
    /**
     * This method is public for PHP 5.3 compatibility, it should be private.
     *
     * @internal
     */
    public function escapeString($str)
>>>>>>> web and vendor directory from composer install
    {
        return str_replace('<', '\\<', $str);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'process';
    }
}
