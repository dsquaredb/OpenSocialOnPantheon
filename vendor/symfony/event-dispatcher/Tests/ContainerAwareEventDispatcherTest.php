<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher\Tests;

use Symfony\Component\DependencyInjection\Container;
<<<<<<< HEAD
=======
use Symfony\Component\DependencyInjection\Scope;
>>>>>>> web and vendor directory from composer install
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

<<<<<<< HEAD
/**
 * @group legacy
 */
=======
>>>>>>> web and vendor directory from composer install
class ContainerAwareEventDispatcherTest extends AbstractEventDispatcherTest
{
    protected function createEventDispatcher()
    {
        $container = new Container();

        return new ContainerAwareEventDispatcher($container);
    }

    public function testAddAListenerService()
    {
        $event = new Event();

<<<<<<< HEAD
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
=======
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
>>>>>>> web and vendor directory from composer install

        $service
            ->expects($this->once())
            ->method('onEvent')
            ->with($event)
        ;

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

        $dispatcher->dispatch('onEvent', $event);
    }

    public function testAddASubscriberService()
    {
        $event = new Event();

<<<<<<< HEAD
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\SubscriberService')->getMock();
=======
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\SubscriberService');
>>>>>>> web and vendor directory from composer install

        $service
            ->expects($this->once())
            ->method('onEvent')
            ->with($event)
        ;

        $service
            ->expects($this->once())
            ->method('onEventWithPriority')
            ->with($event)
        ;

        $service
            ->expects($this->once())
            ->method('onEventNested')
            ->with($event)
        ;

        $container = new Container();
        $container->set('service.subscriber', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addSubscriberService('service.subscriber', 'Symfony\Component\EventDispatcher\Tests\SubscriberService');

        $dispatcher->dispatch('onEvent', $event);
        $dispatcher->dispatch('onEventWithPriority', $event);
        $dispatcher->dispatch('onEventNested', $event);
    }

    public function testPreventDuplicateListenerService()
    {
        $event = new Event();

<<<<<<< HEAD
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
=======
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
>>>>>>> web and vendor directory from composer install

        $service
            ->expects($this->once())
            ->method('onEvent')
            ->with($event)
        ;

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'), 5);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'), 10);

        $dispatcher->dispatch('onEvent', $event);
    }

<<<<<<< HEAD
=======
    /**
     * @expectedException \InvalidArgumentException
     * @group legacy
     */
    public function testTriggerAListenerServiceOutOfScope()
    {
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');

        $scope = new Scope('scope');
        $container = new Container();
        $container->addScope($scope);
        $container->enterScope('scope');

        $container->set('service.listener', $service, 'scope');

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

        $container->leaveScope('scope');
        $dispatcher->dispatch('onEvent');
    }

    /**
     * @group legacy
     */
    public function testReEnteringAScope()
    {
        $event = new Event();

        $service1 = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');

        $service1
            ->expects($this->exactly(2))
            ->method('onEvent')
            ->with($event)
        ;

        $scope = new Scope('scope');
        $container = new Container();
        $container->addScope($scope);
        $container->enterScope('scope');

        $container->set('service.listener', $service1, 'scope');

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));
        $dispatcher->dispatch('onEvent', $event);

        $service2 = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');

        $service2
            ->expects($this->once())
            ->method('onEvent')
            ->with($event)
        ;

        $container->enterScope('scope');
        $container->set('service.listener', $service2, 'scope');

        $dispatcher->dispatch('onEvent', $event);

        $container->leaveScope('scope');

        $dispatcher->dispatch('onEvent');
    }

>>>>>>> web and vendor directory from composer install
    public function testHasListenersOnLazyLoad()
    {
        $event = new Event();

<<<<<<< HEAD
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
=======
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
>>>>>>> web and vendor directory from composer install

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

<<<<<<< HEAD
=======
        $event->setDispatcher($dispatcher);
        $event->setName('onEvent');

>>>>>>> web and vendor directory from composer install
        $service
            ->expects($this->once())
            ->method('onEvent')
            ->with($event)
        ;

        $this->assertTrue($dispatcher->hasListeners());

        if ($dispatcher->hasListeners('onEvent')) {
            $dispatcher->dispatch('onEvent');
        }
    }

    public function testGetListenersOnLazyLoad()
    {
<<<<<<< HEAD
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
=======
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
>>>>>>> web and vendor directory from composer install

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

        $listeners = $dispatcher->getListeners();

<<<<<<< HEAD
        $this->assertArrayHasKey('onEvent', $listeners);
=======
        $this->assertTrue(isset($listeners['onEvent']));
>>>>>>> web and vendor directory from composer install

        $this->assertCount(1, $dispatcher->getListeners('onEvent'));
    }

    public function testRemoveAfterDispatch()
    {
<<<<<<< HEAD
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
=======
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
>>>>>>> web and vendor directory from composer install

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

        $dispatcher->dispatch('onEvent', new Event());
        $dispatcher->removeListener('onEvent', array($container->get('service.listener'), 'onEvent'));
        $this->assertFalse($dispatcher->hasListeners('onEvent'));
    }

    public function testRemoveBeforeDispatch()
    {
<<<<<<< HEAD
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
=======
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
>>>>>>> web and vendor directory from composer install

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

        $dispatcher->removeListener('onEvent', array($container->get('service.listener'), 'onEvent'));
        $this->assertFalse($dispatcher->hasListeners('onEvent'));
    }
}

class Service
{
    public function onEvent(Event $e)
    {
    }
}

class SubscriberService implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'onEvent' => 'onEvent',
            'onEventWithPriority' => array('onEventWithPriority', 10),
            'onEventNested' => array(array('onEventNested')),
        );
    }

    public function onEvent(Event $e)
    {
    }

    public function onEventWithPriority(Event $e)
    {
    }

    public function onEventNested(Event $e)
    {
    }
}
