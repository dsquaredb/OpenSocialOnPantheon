<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher\Tests\DependencyInjection;

<<<<<<< HEAD
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

class RegisterListenersPassTest extends TestCase
=======
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

class RegisterListenersPassTest extends \PHPUnit_Framework_TestCase
>>>>>>> web and vendor directory from composer install
{
    /**
     * Tests that event subscribers not implementing EventSubscriberInterface
     * trigger an exception.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testEventSubscriberWithoutInterface()
    {
<<<<<<< HEAD
        $builder = new ContainerBuilder();
        $builder->register('event_dispatcher');
        $builder->register('my_event_subscriber', 'stdClass')
            ->addTag('kernel.event_subscriber');
=======
        // one service, not implementing any interface
        $services = array(
            'my_event_subscriber' => array(0 => array()),
        );

        $definition = $this->getMock('Symfony\Component\DependencyInjection\Definition');
        $definition->expects($this->atLeastOnce())
            ->method('isPublic')
            ->will($this->returnValue(true));
        $definition->expects($this->atLeastOnce())
            ->method('getClass')
            ->will($this->returnValue('stdClass'));

        $builder = $this->getMock(
            'Symfony\Component\DependencyInjection\ContainerBuilder',
            array('hasDefinition', 'findTaggedServiceIds', 'getDefinition')
        );
        $builder->expects($this->any())
            ->method('hasDefinition')
            ->will($this->returnValue(true));

        // We don't test kernel.event_listener here
        $builder->expects($this->atLeastOnce())
            ->method('findTaggedServiceIds')
            ->will($this->onConsecutiveCalls(array(), $services));

        $builder->expects($this->atLeastOnce())
            ->method('getDefinition')
            ->will($this->returnValue($definition));
>>>>>>> web and vendor directory from composer install

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($builder);
    }

    public function testValidEventSubscriber()
    {
        $services = array(
            'my_event_subscriber' => array(0 => array()),
        );

<<<<<<< HEAD
        $builder = new ContainerBuilder();
        $eventDispatcherDefinition = $builder->register('event_dispatcher');
        $builder->register('my_event_subscriber', 'Symfony\Component\EventDispatcher\Tests\DependencyInjection\SubscriberService')
            ->addTag('kernel.event_subscriber');

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($builder);

        $expectedCalls = array(
            array(
                'addListener',
                array(
                    'event',
                    array(new ServiceClosureArgument(new Reference('my_event_subscriber')), 'onEvent'),
                    0,
                ),
            ),
        );
        $this->assertEquals($expectedCalls, $eventDispatcherDefinition->getMethodCalls());
=======
        $definition = $this->getMock('Symfony\Component\DependencyInjection\Definition');
        $definition->expects($this->atLeastOnce())
            ->method('isPublic')
            ->will($this->returnValue(true));
        $definition->expects($this->atLeastOnce())
            ->method('getClass')
            ->will($this->returnValue('Symfony\Component\EventDispatcher\Tests\DependencyInjection\SubscriberService'));

        $builder = $this->getMock(
            'Symfony\Component\DependencyInjection\ContainerBuilder',
            array('hasDefinition', 'findTaggedServiceIds', 'getDefinition', 'findDefinition')
        );
        $builder->expects($this->any())
            ->method('hasDefinition')
            ->will($this->returnValue(true));

        // We don't test kernel.event_listener here
        $builder->expects($this->atLeastOnce())
            ->method('findTaggedServiceIds')
            ->will($this->onConsecutiveCalls(array(), $services));

        $builder->expects($this->atLeastOnce())
            ->method('getDefinition')
            ->will($this->returnValue($definition));

        $builder->expects($this->atLeastOnce())
            ->method('findDefinition')
            ->will($this->returnValue($definition));

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($builder);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The service "foo" must be public as event listeners are lazy-loaded.
     */
    public function testPrivateEventListener()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->setPublic(false)->addTag('kernel.event_listener', array());
        $container->register('event_dispatcher', 'stdClass');

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($container);
>>>>>>> web and vendor directory from composer install
    }

    /**
     * @expectedException \InvalidArgumentException
<<<<<<< HEAD
     * @expectedExceptionMessage The service "foo" tagged "kernel.event_listener" must not be abstract.
=======
     * @expectedExceptionMessage The service "foo" must be public as event subscribers are lazy-loaded.
     */
    public function testPrivateEventSubscriber()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->setPublic(false)->addTag('kernel.event_subscriber', array());
        $container->register('event_dispatcher', 'stdClass');

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($container);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The service "foo" must not be abstract as event listeners are lazy-loaded.
>>>>>>> web and vendor directory from composer install
     */
    public function testAbstractEventListener()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->setAbstract(true)->addTag('kernel.event_listener', array());
        $container->register('event_dispatcher', 'stdClass');

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($container);
    }

    /**
     * @expectedException \InvalidArgumentException
<<<<<<< HEAD
     * @expectedExceptionMessage The service "foo" tagged "kernel.event_subscriber" must not be abstract.
=======
     * @expectedExceptionMessage The service "foo" must not be abstract as event subscribers are lazy-loaded.
>>>>>>> web and vendor directory from composer install
     */
    public function testAbstractEventSubscriber()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->setAbstract(true)->addTag('kernel.event_subscriber', array());
        $container->register('event_dispatcher', 'stdClass');

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($container);
    }

    public function testEventSubscriberResolvableClassName()
    {
        $container = new ContainerBuilder();

        $container->setParameter('subscriber.class', 'Symfony\Component\EventDispatcher\Tests\DependencyInjection\SubscriberService');
        $container->register('foo', '%subscriber.class%')->addTag('kernel.event_subscriber', array());
        $container->register('event_dispatcher', 'stdClass');

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($container);

        $definition = $container->getDefinition('event_dispatcher');
<<<<<<< HEAD
        $expectedCalls = array(
            array(
                'addListener',
                array(
                    'event',
                    array(new ServiceClosureArgument(new Reference('foo')), 'onEvent'),
                    0,
                ),
            ),
        );
        $this->assertEquals($expectedCalls, $definition->getMethodCalls());
    }

    public function testHotPathEvents()
    {
        $container = new ContainerBuilder();

        $container->register('foo', SubscriberService::class)->addTag('kernel.event_subscriber', array());
        $container->register('event_dispatcher', 'stdClass');

        (new RegisterListenersPass())->setHotPathEvents(array('event'))->process($container);

        $this->assertTrue($container->getDefinition('foo')->hasTag('container.hot_path'));
=======
        $expected_calls = array(
            array(
                'addSubscriberService',
                array(
                    'foo',
                    'Symfony\Component\EventDispatcher\Tests\DependencyInjection\SubscriberService',
                ),
            ),
        );
        $this->assertSame($expected_calls, $definition->getMethodCalls());
>>>>>>> web and vendor directory from composer install
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage You have requested a non-existent parameter "subscriber.class"
     */
    public function testEventSubscriberUnresolvableClassName()
    {
        $container = new ContainerBuilder();
        $container->register('foo', '%subscriber.class%')->addTag('kernel.event_subscriber', array());
        $container->register('event_dispatcher', 'stdClass');

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($container);
    }
}

class SubscriberService implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
<<<<<<< HEAD
        return array(
            'event' => 'onEvent',
        );
=======
>>>>>>> web and vendor directory from composer install
    }
}
