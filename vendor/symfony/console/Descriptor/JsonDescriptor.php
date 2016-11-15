<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Descriptor;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

/**
 * JSON descriptor.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @internal
 */
class JsonDescriptor extends Descriptor
{
    /**
     * {@inheritdoc}
     */
    protected function describeInputArgument(InputArgument $argument, array $options = array())
    {
        $this->writeData($this->getInputArgumentData($argument), $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function describeInputOption(InputOption $option, array $options = array())
    {
        $this->writeData($this->getInputOptionData($option), $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function describeInputDefinition(InputDefinition $definition, array $options = array())
    {
        $this->writeData($this->getInputDefinitionData($definition), $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function describeCommand(Command $command, array $options = array())
    {
        $this->writeData($this->getCommandData($command), $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function describeApplication(Application $application, array $options = array())
    {
        $describedNamespace = isset($options['namespace']) ? $options['namespace'] : null;
<<<<<<< HEAD
        $description = new ApplicationDescription($application, $describedNamespace, true);
=======
        $description = new ApplicationDescription($application, $describedNamespace);
>>>>>>> web and vendor directory from composer install
        $commands = array();

        foreach ($description->getCommands() as $command) {
            $commands[] = $this->getCommandData($command);
        }

<<<<<<< HEAD
        $data = array();
        if ('UNKNOWN' !== $application->getName()) {
            $data['application']['name'] = $application->getName();
            if ('UNKNOWN' !== $application->getVersion()) {
                $data['application']['version'] = $application->getVersion();
            }
        }

        $data['commands'] = $commands;

        if ($describedNamespace) {
            $data['namespace'] = $describedNamespace;
        } else {
            $data['namespaces'] = array_values($description->getNamespaces());
        }
=======
        $data = $describedNamespace
            ? array('commands' => $commands, 'namespace' => $describedNamespace)
            : array('commands' => $commands, 'namespaces' => array_values($description->getNamespaces()));
>>>>>>> web and vendor directory from composer install

        $this->writeData($data, $options);
    }

    /**
     * Writes data as json.
     *
<<<<<<< HEAD
=======
     * @param array $data
     * @param array $options
     *
>>>>>>> web and vendor directory from composer install
     * @return array|string
     */
    private function writeData(array $data, array $options)
    {
        $this->write(json_encode($data, isset($options['json_encoding']) ? $options['json_encoding'] : 0));
    }

    /**
<<<<<<< HEAD
=======
     * @param InputArgument $argument
     *
>>>>>>> web and vendor directory from composer install
     * @return array
     */
    private function getInputArgumentData(InputArgument $argument)
    {
        return array(
            'name' => $argument->getName(),
            'is_required' => $argument->isRequired(),
            'is_array' => $argument->isArray(),
            'description' => preg_replace('/\s*[\r\n]\s*/', ' ', $argument->getDescription()),
<<<<<<< HEAD
            'default' => INF === $argument->getDefault() ? 'INF' : $argument->getDefault(),
=======
            'default' => $argument->getDefault(),
>>>>>>> web and vendor directory from composer install
        );
    }

    /**
<<<<<<< HEAD
=======
     * @param InputOption $option
     *
>>>>>>> web and vendor directory from composer install
     * @return array
     */
    private function getInputOptionData(InputOption $option)
    {
        return array(
            'name' => '--'.$option->getName(),
<<<<<<< HEAD
            'shortcut' => $option->getShortcut() ? '-'.str_replace('|', '|-', $option->getShortcut()) : '',
=======
            'shortcut' => $option->getShortcut() ? '-'.implode('|-', explode('|', $option->getShortcut())) : '',
>>>>>>> web and vendor directory from composer install
            'accept_value' => $option->acceptValue(),
            'is_value_required' => $option->isValueRequired(),
            'is_multiple' => $option->isArray(),
            'description' => preg_replace('/\s*[\r\n]\s*/', ' ', $option->getDescription()),
<<<<<<< HEAD
            'default' => INF === $option->getDefault() ? 'INF' : $option->getDefault(),
=======
            'default' => $option->getDefault(),
>>>>>>> web and vendor directory from composer install
        );
    }

    /**
<<<<<<< HEAD
=======
     * @param InputDefinition $definition
     *
>>>>>>> web and vendor directory from composer install
     * @return array
     */
    private function getInputDefinitionData(InputDefinition $definition)
    {
        $inputArguments = array();
        foreach ($definition->getArguments() as $name => $argument) {
            $inputArguments[$name] = $this->getInputArgumentData($argument);
        }

        $inputOptions = array();
        foreach ($definition->getOptions() as $name => $option) {
            $inputOptions[$name] = $this->getInputOptionData($option);
        }

        return array('arguments' => $inputArguments, 'options' => $inputOptions);
    }

    /**
<<<<<<< HEAD
=======
     * @param Command $command
     *
>>>>>>> web and vendor directory from composer install
     * @return array
     */
    private function getCommandData(Command $command)
    {
        $command->getSynopsis();
        $command->mergeApplicationDefinition(false);

        return array(
            'name' => $command->getName(),
            'usage' => array_merge(array($command->getSynopsis()), $command->getUsages(), $command->getAliases()),
            'description' => $command->getDescription(),
            'help' => $command->getProcessedHelp(),
            'definition' => $this->getInputDefinitionData($command->getNativeDefinition()),
<<<<<<< HEAD
            'hidden' => $command->isHidden(),
=======
>>>>>>> web and vendor directory from composer install
        );
    }
}
