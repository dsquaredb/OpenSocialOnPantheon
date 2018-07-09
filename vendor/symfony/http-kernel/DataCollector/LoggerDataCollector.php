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

 
use Symfony\Component\Debug\Exception\SilencedErrorContext;
=======
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

/**
 * LogDataCollector.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class LoggerDataCollector extends DataCollector implements LateDataCollectorInterface
{
 
    private $logger;
    private $containerPathPrefix;

    public function __construct($logger = null, $containerPathPrefix = null)
    {
        if (null !== $logger && $logger instanceof DebugLoggerInterface) {
            if (!method_exists($logger, 'clear')) {
                @trigger_error(sprintf('Implementing "%s" without the "clear()" method is deprecated since Symfony 3.4 and will be unsupported in 4.0 for class "%s".', DebugLoggerInterface::class, \get_class($logger)), E_USER_DEPRECATED);
            }

            $this->logger = $logger;
        }

        $this->containerPathPrefix = $containerPathPrefix;
=======
    private $errorNames = array(
        E_DEPRECATED => 'E_DEPRECATED',
        E_USER_DEPRECATED => 'E_USER_DEPRECATED',
        E_NOTICE => 'E_NOTICE',
        E_USER_NOTICE => 'E_USER_NOTICE',
        E_STRICT => 'E_STRICT',
        E_WARNING => 'E_WARNING',
        E_USER_WARNING => 'E_USER_WARNING',
        E_COMPILE_WARNING => 'E_COMPILE_WARNING',
        E_CORE_WARNING => 'E_CORE_WARNING',
        E_USER_ERROR => 'E_USER_ERROR',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_COMPILE_ERROR => 'E_COMPILE_ERROR',
        E_PARSE => 'E_PARSE',
        E_ERROR => 'E_ERROR',
        E_CORE_ERROR => 'E_CORE_ERROR',
    );

    private $logger;

    public function __construct($logger = null)
    {
        if (null !== $logger && $logger instanceof DebugLoggerInterface) {
            $this->logger = $logger;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        // everything is done as late as possible
    }

    /**
     * {@inheritdoc}
     */
 
    public function reset()
    {
        if ($this->logger && method_exists($this->logger, 'clear')) {
            $this->logger->clear();
        }
        $this->data = array();
    }

    /**
     * {@inheritdoc}
     */
    public function lateCollect()
    {
        if (null !== $this->logger) {
            $containerDeprecationLogs = $this->getContainerDeprecationLogs();
            $this->data = $this->computeErrorsCount($containerDeprecationLogs);
            $this->data['compiler_logs'] = $this->getContainerCompilerLogs();
            $this->data['logs'] = $this->sanitizeLogs(array_merge($this->logger->getLogs(), $containerDeprecationLogs));
            $this->data = $this->cloneVar($this->data);
=======
    public function lateCollect()
    {
        if (null !== $this->logger) {
            $this->data = $this->computeErrorsCount();
            $this->data['logs'] = $this->sanitizeLogs($this->logger->getLogs());
        }
    }

    /**
     * Gets the logs.
     *
     * @return array An array of logs
     */
    public function getLogs()
    {
        return isset($this->data['logs']) ? $this->data['logs'] : array();
    }

    public function getPriorities()
    {
        return isset($this->data['priorities']) ? $this->data['priorities'] : array();
    }

    public function countErrors()
    {
        return isset($this->data['error_count']) ? $this->data['error_count'] : 0;
    }

    public function countDeprecations()
    {
        return isset($this->data['deprecation_count']) ? $this->data['deprecation_count'] : 0;
    }

 
    public function countWarnings()
    {
        return isset($this->data['warning_count']) ? $this->data['warning_count'] : 0;
    }

=======
    public function countScreams()
    {
        return isset($this->data['scream_count']) ? $this->data['scream_count'] : 0;
    }

 
    public function getCompilerLogs()
    {
        return isset($this->data['compiler_logs']) ? $this->data['compiler_logs'] : array();
    }

=======
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'logger';
    }

 
    private function getContainerDeprecationLogs()
    {
        if (null === $this->containerPathPrefix || !file_exists($file = $this->containerPathPrefix.'Deprecations.log')) {
            return array();
        }

        $bootTime = filemtime($file);
        $logs = array();
        foreach (unserialize(file_get_contents($file)) as $log) {
            $log['context'] = array('exception' => new SilencedErrorContext($log['type'], $log['file'], $log['line'], $log['trace'], $log['count']));
            $log['timestamp'] = $bootTime;
            $log['priority'] = 100;
            $log['priorityName'] = 'DEBUG';
            $log['channel'] = '-';
            $log['scream'] = false;
            unset($log['type'], $log['file'], $log['line'], $log['trace'], $log['trace'], $log['count']);
            $logs[] = $log;
        }

        return $logs;
    }

    private function getContainerCompilerLogs()
    {
        if (null === $this->containerPathPrefix || !file_exists($file = $this->containerPathPrefix.'Compiler.log')) {
            return array();
        }

        $logs = array();
        foreach (file($file, FILE_IGNORE_NEW_LINES) as $log) {
            $log = explode(': ', $log, 2);
            if (!isset($log[1]) || !preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*+(?:\\\\[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*+)++$/', $log[0])) {
                $log = array('Unknown Compiler Pass', implode(': ', $log));
            }

            $logs[$log[0]][] = array('message' => $log[1]);
        }

        return $logs;
    }

    private function sanitizeLogs($logs)
    {
        $sanitizedLogs = array();
        $silencedLogs = array();

        foreach ($logs as $log) {
            if (!$this->isSilencedOrDeprecationErrorLog($log)) {
                $sanitizedLogs[] = $log;

                continue;
            }

            $message = $log['message'];
            $exception = $log['context']['exception'];

            if ($exception instanceof SilencedErrorContext) {
                if (isset($silencedLogs[$h = spl_object_hash($exception)])) {
                    continue;
                }
                $silencedLogs[$h] = true;

                if (!isset($sanitizedLogs[$message])) {
                    $sanitizedLogs[$message] = $log + array(
                        'errorCount' => 0,
                        'scream' => true,
                    );
                }
                $sanitizedLogs[$message]['errorCount'] += $exception->count;

                continue;
            }

            $errorId = md5("{$exception->getSeverity()}/{$exception->getLine()}/{$exception->getFile()}\0{$message}", true);

            if (isset($sanitizedLogs[$errorId])) {
                ++$sanitizedLogs[$errorId]['errorCount'];
            } else {
                $log += array(
                    'errorCount' => 1,
                    'scream' => false,
                );

                $sanitizedLogs[$errorId] = $log;
            }
        }

        return array_values($sanitizedLogs);
    }

    private function isSilencedOrDeprecationErrorLog(array $log)
    {
        if (!isset($log['context']['exception'])) {
            return false;
        }

        $exception = $log['context']['exception'];

        if ($exception instanceof SilencedErrorContext) {
            return true;
        }

        if ($exception instanceof \ErrorException && in_array($exception->getSeverity(), array(E_DEPRECATED, E_USER_DEPRECATED), true)) {
            return true;
        }

        return false;
    }

    private function computeErrorsCount(array $containerDeprecationLogs)
    {
        $silencedLogs = array();
        $count = array(
            'error_count' => $this->logger->countErrors(),
            'deprecation_count' => 0,
            'warning_count' => 0,
=======
    private function sanitizeLogs($logs)
    {
        $errorContextById = array();
        $sanitizedLogs = array();

        foreach ($logs as $log) {
            $context = $this->sanitizeContext($log['context']);

            if (isset($context['type'], $context['file'], $context['line'], $context['level'])) {
                $errorId = md5("{$context['type']}/{$context['line']}/{$context['file']}\x00{$log['message']}", true);
                $silenced = !($context['type'] & $context['level']);
                if (isset($this->errorNames[$context['type']])) {
                    $context = array_merge(array('name' => $this->errorNames[$context['type']]), $context);
                }

                if (isset($errorContextById[$errorId])) {
                    if (isset($errorContextById[$errorId]['errorCount'])) {
                        ++$errorContextById[$errorId]['errorCount'];
                    } else {
                        $errorContextById[$errorId]['errorCount'] = 2;
                    }

                    if (!$silenced && isset($errorContextById[$errorId]['scream'])) {
                        unset($errorContextById[$errorId]['scream']);
                        $errorContextById[$errorId]['level'] = $context['level'];
                    }

                    continue;
                }

                $errorContextById[$errorId] = &$context;
                if ($silenced) {
                    $context['scream'] = true;
                }

                $log['context'] = &$context;
                unset($context);
            } else {
                $log['context'] = $context;
            }

            $sanitizedLogs[] = $log;
        }

        return $sanitizedLogs;
    }

    private function sanitizeContext($context)
    {
        if (is_array($context)) {
            foreach ($context as $key => $value) {
                $context[$key] = $this->sanitizeContext($value);
            }

            return $context;
        }

        if (is_resource($context)) {
            return sprintf('Resource(%s)', get_resource_type($context));
        }

        if (is_object($context)) {
            if ($context instanceof \Exception) {
                return sprintf('Exception(%s): %s', get_class($context), $context->getMessage());
            }

            return sprintf('Object(%s)', get_class($context));
        }

        return $context;
    }

    private function computeErrorsCount()
    {
        $count = array(
            'error_count' => $this->logger->countErrors(),
            'deprecation_count' => 0,
            'scream_count' => 0,
            'priorities' => array(),
        );

        foreach ($this->logger->getLogs() as $log) {
            if (isset($count['priorities'][$log['priority']])) {
                ++$count['priorities'][$log['priority']]['count'];
            } else {
                $count['priorities'][$log['priority']] = array(
                    'count' => 1,
                    'name' => $log['priorityName'],
                );
            }
 
            if ('WARNING' === $log['priorityName']) {
                ++$count['warning_count'];
            }

            if ($this->isSilencedOrDeprecationErrorLog($log)) {
                $exception = $log['context']['exception'];
                if ($exception instanceof SilencedErrorContext) {
                    if (isset($silencedLogs[$h = spl_object_hash($exception)])) {
                        continue;
                    }
                    $silencedLogs[$h] = true;
                    $count['scream_count'] += $exception->count;
                } else {
                    ++$count['deprecation_count'];
=======

            if (isset($log['context']['type'], $log['context']['level'])) {
                if (E_DEPRECATED === $log['context']['type'] || E_USER_DEPRECATED === $log['context']['type']) {
                    ++$count['deprecation_count'];
                } elseif (!($log['context']['type'] & $log['context']['level'])) {
                    ++$count['scream_count'];
                }
            }
        }

 
        foreach ($containerDeprecationLogs as $deprecationLog) {
            $count['deprecation_count'] += $deprecationLog['context']['exception']->count;
        }

=======
        ksort($count['priorities']);

        return $count;
    }
}
