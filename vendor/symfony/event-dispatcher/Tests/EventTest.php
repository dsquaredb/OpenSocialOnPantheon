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

<<<<<<< HEAD
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\Event;
=======
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
>>>>>>> web and vendor directory from composer install

/**
 * Test class for Event.
 */
<<<<<<< HEAD
class EventTest extends TestCase
=======
class EventTest extends \PHPUnit_Framework_TestCase
>>>>>>> web and vendor directory from composer install
{
    /**
     * @var \Symfony\Component\EventDispatcher\Event
     */
    protected $event;

    /**
<<<<<<< HEAD
=======
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $dispatcher;

    /**
>>>>>>> web and vendor directory from composer install
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->event = new Event();
<<<<<<< HEAD
=======
        $this->dispatcher = new EventDispatcher();
>>>>>>> web and vendor directory from composer install
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->event = null;
<<<<<<< HEAD
=======
        $this->dispatcher = null;
>>>>>>> web and vendor directory from composer install
    }

    public function testIsPropagationStopped()
    {
        $this->assertFalse($this->event->isPropagationStopped());
    }

    public function testStopPropagationAndIsPropagationStopped()
    {
        $this->event->stopPropagation();
        $this->assertTrue($this->event->isPropagationStopped());
    }
<<<<<<< HEAD
=======

    /**
     * @group legacy
     */
    public function testLegacySetDispatcher()
    {
        $this->event->setDispatcher($this->dispatcher);
        $this->assertSame($this->dispatcher, $this->event->getDispatcher());
    }

    /**
     * @group legacy
     */
    public function testLegacyGetDispatcher()
    {
        $this->assertNull($this->event->getDispatcher());
    }

    /**
     * @group legacy
     */
    public function testLegacyGetName()
    {
        $this->assertNull($this->event->getName());
    }

    /**
     * @group legacy
     */
    public function testLegacySetName()
    {
        $this->event->setName('foo');
        $this->assertEquals('foo', $this->event->getName());
    }
>>>>>>> web and vendor directory from composer install
}
