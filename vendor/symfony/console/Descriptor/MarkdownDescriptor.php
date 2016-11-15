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
<<<<<<< HEAD
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
=======
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
>>>>>>> web and vendor directory from composer install

/**
 * Markdown descriptor.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 *
 * @internal
 */
class MarkdownDescriptor extends Descriptor
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function describe(OutputInterface $output, $object, array $options = array())
    {
        $decorated = $output->isDecorated();
        $output->setDecorated(false);

        parent::describe($output, $object, $options);

        $output->setDecorated($decorated);
    }

    /**
     * {@inheritdoc}
     */
    protected function write($content, $decorated = true)
    {
        parent::write($content, $decorated);
    }

    /**
     * {@inheritdoc}
     */
    protected function describeInputArgument(InputArgument $argument, array $options = array())
    {
        $this->write(
            '#### `'.($argument->getName() ?: '<none>')."`\n\n"
            .($argument->getDescription() ? preg_replace('/\s*[\r\n]\s*/', "\n", $argument->getDescription())."\n\n" : '')
            .'* Is required: '.($argument->isRequired() ? 'yes' : 'no')."\n"
            .'* Is array: '.($argument->isArray() ? 'yes' : 'no')."\n"
=======
    protected function describeInputArgument(InputArgument $argument, array $options = array())
    {
        $this->write(
            '**'.$argument->getName().':**'."\n\n"
            .'* Name: '.($argument->getName() ?: '<none>')."\n"
            .'* Is required: '.($argument->isRequired() ? 'yes' : 'no')."\n"
            .'* Is array: '.($argument->isArray() ? 'yes' : 'no')."\n"
            .'* Description: '.preg_replace('/\s*[\r\n]\s*/', "\n  ", $argument->getDescription() ?: '<none>')."\n"
>>>>>>> web and vendor directory from composer install
            .'* Default: `'.str_replace("\n", '', var_export($argument->getDefault(), true)).'`'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function describeInputOption(InputOption $option, array $options = array())
    {
<<<<<<< HEAD
        $name = '--'.$option->getName();
        if ($option->getShortcut()) {
            $name .= '|-'.str_replace('|', '|-', $option->getShortcut()).'';
        }

        $this->write(
            '#### `'.$name.'`'."\n\n"
            .($option->getDescription() ? preg_replace('/\s*[\r\n]\s*/', "\n", $option->getDescription())."\n\n" : '')
            .'* Accept value: '.($option->acceptValue() ? 'yes' : 'no')."\n"
            .'* Is value required: '.($option->isValueRequired() ? 'yes' : 'no')."\n"
            .'* Is multiple: '.($option->isArray() ? 'yes' : 'no')."\n"
=======
        $this->write(
            '**'.$option->getName().':**'."\n\n"
            .'* Name: `--'.$option->getName().'`'."\n"
            .'* Shortcut: '.($option->getShortcut() ? '`-'.implode('|-', explode('|', $option->getShortcut())).'`' : '<none>')."\n"
            .'* Accept value: '.($option->acceptValue() ? 'yes' : 'no')."\n"
            .'* Is value required: '.($option->isValueRequired() ? 'yes' : 'no')."\n"
            .'* Is multiple: '.($option->isArray() ? 'yes' : 'no')."\n"
            .'* Description: '.preg_replace('/\s*[\r\n]\s*/', "\n  ", $option->getDescription() ?: '<none>')."\n"
>>>>>>> web and vendor directory from composer install
            .'* Default: `'.str_replace("\n", '', var_export($option->getDefault(), true)).'`'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function describeInputDefinition(InputDefinition $definition, array $options = array())
    {
        if ($showArguments = count($definition->getArguments()) > 0) {
<<<<<<< HEAD
            $this->write('### Arguments');
=======
            $this->write('### Arguments:');
>>>>>>> web and vendor directory from composer install
            foreach ($definition->getArguments() as $argument) {
                $this->write("\n\n");
                $this->write($this->describeInputArgument($argument));
            }
        }

        if (count($definition->getOptions()) > 0) {
            if ($showArguments) {
                $this->write("\n\n");
            }

<<<<<<< HEAD
            $this->write('### Options');
=======
            $this->write('### Options:');
>>>>>>> web and vendor directory from composer install
            foreach ($definition->getOptions() as $option) {
                $this->write("\n\n");
                $this->write($this->describeInputOption($option));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function describeCommand(Command $command, array $options = array())
    {
        $command->getSynopsis();
        $command->mergeApplicationDefinition(false);

        $this->write(
<<<<<<< HEAD
            '`'.$command->getName()."`\n"
            .str_repeat('-', Helper::strlen($command->getName()) + 2)."\n\n"
            .($command->getDescription() ? $command->getDescription()."\n\n" : '')
            .'### Usage'."\n\n"
            .array_reduce(array_merge(array($command->getSynopsis()), $command->getAliases(), $command->getUsages()), function ($carry, $usage) {
                return $carry.'* `'.$usage.'`'."\n";
=======
            $command->getName()."\n"
            .str_repeat('-', strlen($command->getName()))."\n\n"
            .'* Description: '.($command->getDescription() ?: '<none>')."\n"
            .'* Usage:'."\n\n"
            .array_reduce(array_merge(array($command->getSynopsis()), $command->getAliases(), $command->getUsages()), function ($carry, $usage) {
                return $carry.'  * `'.$usage.'`'."\n";
>>>>>>> web and vendor directory from composer install
            })
        );

        if ($help = $command->getProcessedHelp()) {
            $this->write("\n");
            $this->write($help);
        }

        if ($command->getNativeDefinition()) {
            $this->write("\n\n");
            $this->describeInputDefinition($command->getNativeDefinition());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function describeApplication(Application $application, array $options = array())
    {
        $describedNamespace = isset($options['namespace']) ? $options['namespace'] : null;
        $description = new ApplicationDescription($application, $describedNamespace);
<<<<<<< HEAD
        $title = $this->getApplicationTitle($application);

        $this->write($title."\n".str_repeat('=', Helper::strlen($title)));
=======

        $this->write($application->getName()."\n".str_repeat('=', strlen($application->getName())));
>>>>>>> web and vendor directory from composer install

        foreach ($description->getNamespaces() as $namespace) {
            if (ApplicationDescription::GLOBAL_NAMESPACE !== $namespace['id']) {
                $this->write("\n\n");
                $this->write('**'.$namespace['id'].':**');
            }

            $this->write("\n\n");
<<<<<<< HEAD
            $this->write(implode("\n", array_map(function ($commandName) use ($description) {
                return sprintf('* [`%s`](#%s)', $commandName, str_replace(':', '', $description->getCommand($commandName)->getName()));
=======
            $this->write(implode("\n", array_map(function ($commandName) {
                return '* '.$commandName;
>>>>>>> web and vendor directory from composer install
            }, $namespace['commands'])));
        }

        foreach ($description->getCommands() as $command) {
            $this->write("\n\n");
            $this->write($this->describeCommand($command));
        }
    }
<<<<<<< HEAD

    private function getApplicationTitle(Application $application)
    {
        if ('UNKNOWN' !== $application->getName()) {
            if ('UNKNOWN' !== $application->getVersion()) {
                return sprintf('%s %s', $application->getName(), $application->getVersion());
            }

            return $application->getName();
        }

        return 'Console Tool';
    }
=======
>>>>>>> web and vendor directory from composer install
}
