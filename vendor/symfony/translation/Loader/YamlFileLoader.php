<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Loader;

use Symfony\Component\Translation\Exception\InvalidResourceException;
<<<<<<< HEAD
use Symfony\Component\Translation\Exception\LogicException;
=======
>>>>>>> web and vendor directory from composer install
use Symfony\Component\Yaml\Parser as YamlParser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * YamlFileLoader loads translations from Yaml files.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class YamlFileLoader extends FileLoader
{
    private $yamlParser;

    /**
     * {@inheritdoc}
     */
    protected function loadResource($resource)
    {
        if (null === $this->yamlParser) {
            if (!class_exists('Symfony\Component\Yaml\Parser')) {
<<<<<<< HEAD
                throw new LogicException('Loading translations from the YAML format requires the Symfony Yaml component.');
=======
                throw new \LogicException('Loading translations from the YAML format requires the Symfony Yaml component.');
>>>>>>> web and vendor directory from composer install
            }

            $this->yamlParser = new YamlParser();
        }

<<<<<<< HEAD
        $prevErrorHandler = set_error_handler(function ($level, $message, $script, $line) use ($resource, &$prevErrorHandler) {
            $message = E_USER_DEPRECATED === $level ? preg_replace('/ on line \d+/', ' in "'.$resource.'"$0', $message) : $message;

            return $prevErrorHandler ? $prevErrorHandler($level, $message, $script, $line) : false;
        });

        try {
            $messages = $this->yamlParser->parseFile($resource);
        } catch (ParseException $e) {
            throw new InvalidResourceException(sprintf('Error parsing YAML, invalid file "%s"', $resource), 0, $e);
        } finally {
            restore_error_handler();
=======
        try {
            $messages = $this->yamlParser->parse(file_get_contents($resource));
        } catch (ParseException $e) {
            throw new InvalidResourceException(sprintf('Error parsing YAML, invalid file "%s"', $resource), 0, $e);
>>>>>>> web and vendor directory from composer install
        }

        return $messages;
    }
}
