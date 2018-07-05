<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Tests\Dumper;

<<<<<<< HEAD
=======
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\ChildDefinition;
>>>>>>> Update Open Social to 8.x-2.1
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Variable;
use Symfony\Component\ExpressionLanguage\Expression;

class PhpDumperTest extends \PHPUnit_Framework_TestCase
{
    protected static $fixturesPath;

    public static function setUpBeforeClass()
    {
        self::$fixturesPath = realpath(__DIR__.'/../Fixtures/');
    }

    public function testDump()
    {
        $dumper = new PhpDumper($container = new ContainerBuilder());

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services1.php', $dumper->dump(), '->dump() dumps an empty container as an empty PHP class');
        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services1-1.php', $dumper->dump(array('class' => 'Container', 'base_class' => 'AbstractContainer', 'namespace' => 'Symfony\Component\DependencyInjection\Dump')), '->dump() takes a class and a base_class options');

        $container = new ContainerBuilder();
        new PhpDumper($container);
    }

    public function testDumpOptimizationString()
    {
        $definition = new Definition();
        $definition->setClass('stdClass');
        $definition->addArgument(array(
            'only dot' => '.',
            'concatenation as value' => '.\'\'.',
            'concatenation from the start value' => '\'\'.',
            '.' => 'dot as a key',
            '.\'\'.' => 'concatenation as a key',
            '\'\'.' => 'concatenation from the start key',
            'optimize concatenation' => 'string1%some_string%string2',
            'optimize concatenation with empty string' => 'string1%empty_value%string2',
            'optimize concatenation from the start' => '%empty_value%start',
            'optimize concatenation at the end' => 'end%empty_value%',
        ));

        $container = new ContainerBuilder();
        $container->setResourceTracking(false);
        $container->setDefinition('test', $definition);
        $container->setParameter('empty_value', '');
        $container->setParameter('some_string', '-');
        $container->compile();

        $dumper = new PhpDumper($container);
        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services10.php', $dumper->dump(), '->dump() dumps an empty container as an empty PHP class');
    }

    public function testDumpRelativeDir()
    {
        $definition = new Definition();
        $definition->setClass('stdClass');
        $definition->addArgument('%foo%');
        $definition->addArgument(array('%foo%' => '%buz%/'));

        $container = new ContainerBuilder();
        $container->setDefinition('test', $definition);
        $container->setParameter('foo', 'wiz'.dirname(__DIR__));
        $container->setParameter('bar', __DIR__);
        $container->setParameter('baz', '%bar%/PhpDumperTest.php');
        $container->setParameter('buz', dirname(dirname(__DIR__)));
        $container->compile();

        $dumper = new PhpDumper($container);
        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services12.php', $dumper->dump(array('file' => __FILE__)), '->dump() dumps __DIR__ relative strings');
    }

    /**
     * @dataProvider provideInvalidParameters
     * @expectedException \InvalidArgumentException
     */
    public function testExportParameters($parameters)
    {
        $dumper = new PhpDumper(new ContainerBuilder(new ParameterBag($parameters)));
        $dumper->dump();
    }

    public function provideInvalidParameters()
    {
        return array(
            array(array('foo' => new Definition('stdClass'))),
            array(array('foo' => new Expression('service("foo").foo() ~ (container.hasParameter("foo") ? parameter("foo") : "default")'))),
            array(array('foo' => new Reference('foo'))),
            array(array('foo' => new Variable('foo'))),
        );
    }

    public function testAddParameters()
    {
        $container = include self::$fixturesPath.'/containers/container8.php';
        $dumper = new PhpDumper($container);
        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services8.php', $dumper->dump(), '->dump() dumps parameters');
    }

    public function testAddService()
    {
        // without compilation
        $container = include self::$fixturesPath.'/containers/container9.php';
        $dumper = new PhpDumper($container);
        $this->assertEquals(str_replace('%path%', str_replace('\\', '\\\\', self::$fixturesPath.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR), file_get_contents(self::$fixturesPath.'/php/services9.php')), $dumper->dump(), '->dump() dumps services');

        // with compilation
        $container = include self::$fixturesPath.'/containers/container9.php';
        $container->compile();
        $dumper = new PhpDumper($container);
        $this->assertEquals(str_replace('%path%', str_replace('\\', '\\\\', self::$fixturesPath.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR), file_get_contents(self::$fixturesPath.'/php/services9_compiled.php')), $dumper->dump(), '->dump() dumps services');

        $dumper = new PhpDumper($container = new ContainerBuilder());
        $container->register('foo', 'FooClass')->addArgument(new \stdClass());
        try {
            $dumper->dump();
            $this->fail('->dump() throws a RuntimeException if the container to be dumped has reference to objects or resources');
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Symfony\Component\DependencyInjection\Exception\RuntimeException', $e, '->dump() throws a RuntimeException if the container to be dumped has reference to objects or resources');
            $this->assertEquals('Unable to dump a service container if a parameter is an object or a resource.', $e->getMessage(), '->dump() throws a RuntimeException if the container to be dumped has reference to objects or resources');
        }
    }

    /**
     * @group legacy
     */
    public function testLegacySynchronizedServices()
    {
        $container = include self::$fixturesPath.'/containers/container20.php';
        $dumper = new PhpDumper($container);
        $this->assertEquals(str_replace('%path%', str_replace('\\', '\\\\', self::$fixturesPath.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR), file_get_contents(self::$fixturesPath.'/php/services20.php')), $dumper->dump(), '->dump() dumps services');
    }

    public function testServicesWithAnonymousFactories()
    {
        $container = include self::$fixturesPath.'/containers/container19.php';
        $dumper = new PhpDumper($container);

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services19.php', $dumper->dump(), '->dump() dumps services with anonymous factories');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Service id "bar$" cannot be converted to a valid PHP method name.
     */
    public function testAddServiceInvalidServiceId()
    {
        $container = new ContainerBuilder();
        $container->register('bar$', 'FooClass');
        $dumper = new PhpDumper($container);
        $dumper->dump();
    }

    /**
     * @dataProvider provideInvalidFactories
     * @expectedException \Symfony\Component\DependencyInjection\Exception\RuntimeException
     * @expectedExceptionMessage Cannot dump definition
     */
    public function testInvalidFactories($factory)
    {
        $container = new ContainerBuilder();
        $def = new Definition('stdClass');
        $def->setFactory($factory);
        $container->setDefinition('bar', $def);
        $dumper = new PhpDumper($container);
        $dumper->dump();
    }

    public function provideInvalidFactories()
    {
        return array(
            array(array('', 'method')),
            array(array('class', '')),
            array(array('...', 'method')),
            array(array('class', '...')),
        );
    }

    public function testAliases()
    {
        $container = include self::$fixturesPath.'/containers/container9.php';
        $container->compile();
        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Aliases')));

        $container = new \Symfony_DI_PhpDumper_Test_Aliases();
        $container->set('foo', $foo = new \stdClass());
        $this->assertSame($foo, $container->get('foo'));
        $this->assertSame($foo, $container->get('alias_for_foo'));
        $this->assertSame($foo, $container->get('alias_for_alias'));
    }

    public function testFrozenContainerWithoutAliases()
    {
        $container = new ContainerBuilder();
        $container->compile();

        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Frozen_No_Aliases')));

        $container = new \Symfony_DI_PhpDumper_Test_Frozen_No_Aliases();
        $this->assertFalse($container->has('foo'));
    }

    public function testOverrideServiceWhenUsingADumpedContainer()
    {
        require_once self::$fixturesPath.'/php/services9.php';
        require_once self::$fixturesPath.'/includes/foo.php';

        $container = new \ProjectServiceContainer();
        $container->set('bar', $bar = new \stdClass());
        $container->setParameter('foo_bar', 'foo_bar');

        $this->assertEquals($bar, $container->get('bar'), '->set() overrides an already defined service');
    }

    public function testOverrideServiceWhenUsingADumpedContainerAndServiceIsUsedFromAnotherOne()
    {
        require_once self::$fixturesPath.'/php/services9.php';
        require_once self::$fixturesPath.'/includes/foo.php';
        require_once self::$fixturesPath.'/includes/classes.php';

        $container = new \ProjectServiceContainer();
        $container->set('bar', $bar = new \stdClass());

        $this->assertSame($bar, $container->get('foo')->bar, '->set() overrides an already defined service');
    }

    /**
     * @expectedException \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     */
    public function testCircularReference()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->addArgument(new Reference('bar'));
        $container->register('bar', 'stdClass')->setPublic(false)->addMethodCall('setA', array(new Reference('baz')));
        $container->register('baz', 'stdClass')->addMethodCall('setA', array(new Reference('foo')));
        $container->compile();

        $dumper = new PhpDumper($container);
        $dumper->dump();
    }

    public function testDumpAutowireData()
    {
        $container = include self::$fixturesPath.'/containers/container24.php';
        $dumper = new PhpDumper($container);

        $this->assertEquals(file_get_contents(self::$fixturesPath.'/php/services24.php'), $dumper->dump());
    }

    public function testInlinedDefinitionReferencingServiceContainer()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->addMethodCall('add', array(new Reference('service_container')))->setPublic(false);
        $container->register('bar', 'stdClass')->addArgument(new Reference('foo'));
        $container->compile();

        $dumper = new PhpDumper($container);
        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services13.php', $dumper->dump(), '->dump() dumps inline definitions which reference service_container');
    }
<<<<<<< HEAD
=======

    public function testNonSharedLazyDefinitionReferences()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->setShared(false)->setLazy(true);
        $container->register('bar', 'stdClass')->addArgument(new Reference('foo', ContainerBuilder::EXCEPTION_ON_INVALID_REFERENCE, false));
        $container->compile();

        $dumper = new PhpDumper($container);
        $dumper->setProxyDumper(new \DummyProxyDumper());

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_non_shared_lazy.php', $dumper->dump());
    }

    public function testInitializePropertiesBeforeMethodCalls()
    {
        require_once self::$fixturesPath.'/includes/classes.php';

        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->setPublic(true);
        $container->register('bar', 'MethodCallClass')
            ->setPublic(true)
            ->setProperty('simple', 'bar')
            ->setProperty('complex', new Reference('foo'))
            ->addMethodCall('callMe');
        $container->compile();

        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Properties_Before_Method_Calls')));

        $container = new \Symfony_DI_PhpDumper_Test_Properties_Before_Method_Calls();
        $this->assertTrue($container->get('bar')->callPassed(), '->dump() initializes properties before method calls');
    }

    public function testCircularReferenceAllowanceForLazyServices()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->addArgument(new Reference('bar'))->setPublic(true);
        $container->register('bar', 'stdClass')->setLazy(true)->addArgument(new Reference('foo'))->setPublic(true);
        $container->compile();

        $dumper = new PhpDumper($container);
        $dumper->dump();

        $this->addToAssertionCount(1);
    }

    public function testCircularReferenceAllowanceForInlinedDefinitionsForLazyServices()
    {
        /*
         *   test graph:
         *              [connection] -> [event_manager] --> [entity_manager](lazy)
         *                                                           |
         *                                                           --(call)- addEventListener ("@lazy_service")
         *
         *              [lazy_service](lazy) -> [entity_manager](lazy)
         *
         */

        $container = new ContainerBuilder();

        $eventManagerDefinition = new Definition('stdClass');

        $connectionDefinition = $container->register('connection', 'stdClass')->setPublic(true);
        $connectionDefinition->addArgument($eventManagerDefinition);

        $container->register('entity_manager', 'stdClass')
            ->setPublic(true)
            ->setLazy(true)
            ->addArgument(new Reference('connection'));

        $lazyServiceDefinition = $container->register('lazy_service', 'stdClass');
        $lazyServiceDefinition->setPublic(true);
        $lazyServiceDefinition->setLazy(true);
        $lazyServiceDefinition->addArgument(new Reference('entity_manager'));

        $eventManagerDefinition->addMethodCall('addEventListener', array(new Reference('lazy_service')));

        $container->compile();

        $dumper = new PhpDumper($container);

        $dumper->setProxyDumper(new \DummyProxyDumper());
        $dumper->dump();

        $this->addToAssertionCount(1);
    }

    public function testDedupLazyProxy()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->setLazy(true)->setPublic(true);
        $container->register('bar', 'stdClass')->setLazy(true)->setPublic(true);
        $container->compile();

        $dumper = new PhpDumper($container);
        $dumper->setProxyDumper(new \DummyProxyDumper());

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_dedup_lazy_proxy.php', $dumper->dump());
    }

    public function testLazyArgumentProvideGenerator()
    {
        require_once self::$fixturesPath.'/includes/classes.php';

        $container = new ContainerBuilder();
        $container->register('lazy_referenced', 'stdClass')->setPublic(true);
        $container
            ->register('lazy_context', 'LazyContext')
            ->setPublic(true)
            ->setArguments(array(
                new IteratorArgument(array('k1' => new Reference('lazy_referenced'), 'k2' => new Reference('service_container'))),
                new IteratorArgument(array()),
            ))
        ;
        $container->compile();

        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Lazy_Argument_Provide_Generator')));

        $container = new \Symfony_DI_PhpDumper_Test_Lazy_Argument_Provide_Generator();
        $lazyContext = $container->get('lazy_context');

        $this->assertInstanceOf(RewindableGenerator::class, $lazyContext->lazyValues);
        $this->assertInstanceOf(RewindableGenerator::class, $lazyContext->lazyEmptyValues);
        $this->assertCount(2, $lazyContext->lazyValues);
        $this->assertCount(0, $lazyContext->lazyEmptyValues);

        $i = -1;
        foreach ($lazyContext->lazyValues as $k => $v) {
            switch (++$i) {
                case 0:
                    $this->assertEquals('k1', $k);
                    $this->assertInstanceOf('stdCLass', $v);
                    break;
                case 1:
                    $this->assertEquals('k2', $k);
                    $this->assertInstanceOf('Symfony_DI_PhpDumper_Test_Lazy_Argument_Provide_Generator', $v);
                    break;
            }
        }

        $this->assertEmpty(iterator_to_array($lazyContext->lazyEmptyValues));
    }

    public function testNormalizedId()
    {
        $container = include self::$fixturesPath.'/containers/container33.php';
        $container->compile();
        $dumper = new PhpDumper($container);

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services33.php', $dumper->dump());
    }

    public function testDumpContainerBuilderWithFrozenConstructorIncludingPrivateServices()
    {
        $container = new ContainerBuilder();
        $container->register('foo_service', 'stdClass')->setArguments(array(new Reference('baz_service')))->setPublic(true);
        $container->register('bar_service', 'stdClass')->setArguments(array(new Reference('baz_service')))->setPublic(true);
        $container->register('baz_service', 'stdClass')->setPublic(false);
        $container->compile();

        $dumper = new PhpDumper($container);

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_private_frozen.php', $dumper->dump());
    }

    public function testServiceLocator()
    {
        $container = new ContainerBuilder();
        $container->register('foo_service', ServiceLocator::class)
            ->setPublic(true)
            ->addArgument(array(
                'bar' => new ServiceClosureArgument(new Reference('bar_service')),
                'baz' => new ServiceClosureArgument(new TypedReference('baz_service', 'stdClass')),
                'nil' => $nil = new ServiceClosureArgument(new Reference('nil')),
            ))
        ;

        // no method calls
        $container->register('translator.loader_1', 'stdClass')->setPublic(true);
        $container->register('translator.loader_1_locator', ServiceLocator::class)
            ->setPublic(false)
            ->addArgument(array(
                'translator.loader_1' => new ServiceClosureArgument(new Reference('translator.loader_1')),
            ));
        $container->register('translator_1', StubbedTranslator::class)
            ->setPublic(true)
            ->addArgument(new Reference('translator.loader_1_locator'));

        // one method calls
        $container->register('translator.loader_2', 'stdClass')->setPublic(true);
        $container->register('translator.loader_2_locator', ServiceLocator::class)
            ->setPublic(false)
            ->addArgument(array(
                'translator.loader_2' => new ServiceClosureArgument(new Reference('translator.loader_2')),
            ));
        $container->register('translator_2', StubbedTranslator::class)
            ->setPublic(true)
            ->addArgument(new Reference('translator.loader_2_locator'))
            ->addMethodCall('addResource', array('db', new Reference('translator.loader_2'), 'nl'));

        // two method calls
        $container->register('translator.loader_3', 'stdClass')->setPublic(true);
        $container->register('translator.loader_3_locator', ServiceLocator::class)
            ->setPublic(false)
            ->addArgument(array(
                'translator.loader_3' => new ServiceClosureArgument(new Reference('translator.loader_3')),
            ));
        $container->register('translator_3', StubbedTranslator::class)
            ->setPublic(true)
            ->addArgument(new Reference('translator.loader_3_locator'))
            ->addMethodCall('addResource', array('db', new Reference('translator.loader_3'), 'nl'))
            ->addMethodCall('addResource', array('db', new Reference('translator.loader_3'), 'en'));

        $nil->setValues(array(null));
        $container->register('bar_service', 'stdClass')->setArguments(array(new Reference('baz_service')))->setPublic(true);
        $container->register('baz_service', 'stdClass')->setPublic(false);
        $container->compile();

        $dumper = new PhpDumper($container);

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_locator.php', $dumper->dump());
    }

    public function testServiceSubscriber()
    {
        $container = new ContainerBuilder();
        $container->register('foo_service', TestServiceSubscriber::class)
            ->setPublic(true)
            ->setAutowired(true)
            ->addArgument(new Reference(ContainerInterface::class))
            ->addTag('container.service_subscriber', array(
                'key' => 'bar',
                'id' => TestServiceSubscriber::class,
            ))
        ;
        $container->register(TestServiceSubscriber::class, TestServiceSubscriber::class)->setPublic(true);

        $container->register(CustomDefinition::class, CustomDefinition::class)
            ->setPublic(false);
        $container->compile();

        $dumper = new PhpDumper($container);

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_subscriber.php', $dumper->dump());
    }

    public function testPrivateWithIgnoreOnInvalidReference()
    {
        require_once self::$fixturesPath.'/includes/classes.php';

        $container = new ContainerBuilder();
        $container->register('not_invalid', 'BazClass')
            ->setPublic(false);
        $container->register('bar', 'BarClass')
            ->setPublic(true)
            ->addMethodCall('setBaz', array(new Reference('not_invalid', SymfonyContainerInterface::IGNORE_ON_INVALID_REFERENCE)));
        $container->compile();

        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Private_With_Ignore_On_Invalid_Reference')));

        $container = new \Symfony_DI_PhpDumper_Test_Private_With_Ignore_On_Invalid_Reference();
        $this->assertInstanceOf('BazClass', $container->get('bar')->getBaz());
    }

    public function testArrayParameters()
    {
        $container = new ContainerBuilder();
        $container->setParameter('array_1', array(123));
        $container->setParameter('array_2', array(__DIR__));
        $container->register('bar', 'BarClass')
            ->setPublic(true)
            ->addMethodCall('setBaz', array('%array_1%', '%array_2%', '%%array_1%%', array(123)));
        $container->compile();

        $dumper = new PhpDumper($container);

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_array_params.php', str_replace('\\\\Dumper', '/Dumper', $dumper->dump(array('file' => self::$fixturesPath.'/php/services_array_params.php'))));
    }

    public function testExpressionReferencingPrivateService()
    {
        $container = new ContainerBuilder();
        $container->register('private_bar', 'stdClass')
            ->setPublic(false);
        $container->register('private_foo', 'stdClass')
            ->setPublic(false);
        $container->register('public_foo', 'stdClass')
            ->setPublic(true)
            ->addArgument(new Expression('service("private_foo")'));

        $container->compile();
        $dumper = new PhpDumper($container);

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_private_in_expression.php', $dumper->dump());
    }

    public function testUninitializedReference()
    {
        $container = include self::$fixturesPath.'/containers/container_uninitialized_ref.php';
        $container->compile();
        $dumper = new PhpDumper($container);

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_uninitialized_ref.php', $dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Uninitialized_Reference')));

        require self::$fixturesPath.'/php/services_uninitialized_ref.php';

        $container = new \Symfony_DI_PhpDumper_Test_Uninitialized_Reference();

        $bar = $container->get('bar');

        $this->assertNull($bar->foo1);
        $this->assertNull($bar->foo2);
        $this->assertNull($bar->foo3);
        $this->assertNull($bar->closures[0]());
        $this->assertNull($bar->closures[1]());
        $this->assertNull($bar->closures[2]());
        $this->assertSame(array(), iterator_to_array($bar->iter));

        $container = new \Symfony_DI_PhpDumper_Test_Uninitialized_Reference();

        $container->get('foo1');
        $container->get('baz');

        $bar = $container->get('bar');

        $this->assertEquals(new \stdClass(), $bar->foo1);
        $this->assertNull($bar->foo2);
        $this->assertEquals(new \stdClass(), $bar->foo3);
        $this->assertEquals(new \stdClass(), $bar->closures[0]());
        $this->assertNull($bar->closures[1]());
        $this->assertEquals(new \stdClass(), $bar->closures[2]());
        $this->assertEquals(array('foo1' => new \stdClass(), 'foo3' => new \stdClass()), iterator_to_array($bar->iter));
    }

    /**
     * @dataProvider provideAlmostCircular
     */
    public function testAlmostCircular($visibility)
    {
        $container = include self::$fixturesPath.'/containers/container_almost_circular.php';
        $container->compile();
        $dumper = new PhpDumper($container);

        $container = 'Symfony_DI_PhpDumper_Test_Almost_Circular_'.ucfirst($visibility);
        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_almost_circular_'.$visibility.'.php', $dumper->dump(array('class' => $container)));

        require self::$fixturesPath.'/php/services_almost_circular_'.$visibility.'.php';

        $container = new $container();

        $foo = $container->get('foo');
        $this->assertSame($foo, $foo->bar->foobar->foo);

        $foo2 = $container->get('foo2');
        $this->assertSame($foo2, $foo2->bar->foobar->foo);

        $this->assertSame(array(), (array) $container->get('foobar4'));

        $foo5 = $container->get('foo5');
        $this->assertSame($foo5, $foo5->bar->foo);
    }

    public function provideAlmostCircular()
    {
        yield array('public');
        yield array('private');
    }

    public function testHotPathOptimizations()
    {
        $container = include self::$fixturesPath.'/containers/container_inline_requires.php';
        $container->setParameter('inline_requires', true);
        $container->compile();
        $dumper = new PhpDumper($container);

        $dump = $dumper->dump(array('hot_path_tag' => 'container.hot_path', 'inline_class_loader_parameter' => 'inline_requires', 'file' => self::$fixturesPath.'/php/services_inline_requires.php'));
        if ('\\' === DIRECTORY_SEPARATOR) {
            $dump = str_replace("'\\\\includes\\\\HotPath\\\\", "'/includes/HotPath/", $dump);
        }

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_inline_requires.php', $dump);
    }

    public function testDumpHandlesLiteralClassWithRootNamespace()
    {
        $container = new ContainerBuilder();
        $container->register('foo', '\\stdClass')->setPublic(true);
        $container->compile();

        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Literal_Class_With_Root_Namespace')));

        $container = new \Symfony_DI_PhpDumper_Test_Literal_Class_With_Root_Namespace();

        $this->assertInstanceOf('stdClass', $container->get('foo'));
    }

    public function testDumpHandlesObjectClassNames()
    {
        $container = new ContainerBuilder(new ParameterBag(array(
            'class' => 'stdClass',
        )));

        $container->setDefinition('foo', new Definition(new Parameter('class')));
        $container->setDefinition('bar', new Definition('stdClass', array(
            new Reference('foo'),
        )))->setPublic(true);

        $container->setParameter('inline_requires', true);
        $container->compile();

        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array(
            'class' => 'Symfony_DI_PhpDumper_Test_Object_Class_Name',
            'inline_class_loader_parameter' => 'inline_requires',
        )));

        $container = new \Symfony_DI_PhpDumper_Test_Object_Class_Name();

        $this->assertInstanceOf('stdClass', $container->get('bar'));
    }

    /**
     * @group legacy
     * @expectedDeprecation The "private" service is private, getting it from the container is deprecated since Symfony 3.2 and will fail in 4.0. You should either make the service public, or stop using the container directly and use dependency injection instead.
     * @expectedDeprecation The "private_alias" service is private, getting it from the container is deprecated since Symfony 3.2 and will fail in 4.0. You should either make the service public, or stop using the container directly and use dependency injection instead.
     * @expectedDeprecation The "decorated_private" service is private, getting it from the container is deprecated since Symfony 3.2 and will fail in 4.0. You should either make the service public, or stop using the container directly and use dependency injection instead.
     * @expectedDeprecation The "decorated_private_alias" service is private, getting it from the container is deprecated since Symfony 3.2 and will fail in 4.0. You should either make the service public, or stop using the container directly and use dependency injection instead.
     * @expectedDeprecation The "private_not_inlined" service is private, getting it from the container is deprecated since Symfony 3.2 and will fail in 4.0. You should either make the service public, or stop using the container directly and use dependency injection instead.
     * @expectedDeprecation The "private_not_removed" service is private, getting it from the container is deprecated since Symfony 3.2 and will fail in 4.0. You should either make the service public, or stop using the container directly and use dependency injection instead.
     * @expectedDeprecation The "private_child" service is private, getting it from the container is deprecated since Symfony 3.2 and will fail in 4.0. You should either make the service public, or stop using the container directly and use dependency injection instead.
     * @expectedDeprecation The "private_parent" service is private, getting it from the container is deprecated since Symfony 3.2 and will fail in 4.0. You should either make the service public, or stop using the container directly and use dependency injection instead.
     */
    public function testLegacyPrivateServices()
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(self::$fixturesPath.'/yaml'));
        $loader->load('services_legacy_privates.yml');

        $container->setDefinition('private_child', new ChildDefinition('foo'));
        $container->setDefinition('private_parent', new ChildDefinition('private'));

        $container->getDefinition('private')->setPrivate(true);
        $container->getDefinition('private_not_inlined')->setPrivate(true);
        $container->getDefinition('private_not_removed')->setPrivate(true);
        $container->getDefinition('decorated_private')->setPrivate(true);
        $container->getDefinition('private_child')->setPrivate(true);
        $container->getAlias('decorated_private_alias')->setPrivate(true);
        $container->getAlias('private_alias')->setPrivate(true);

        $container->compile();
        $dumper = new PhpDumper($container);

        $this->assertStringEqualsFile(self::$fixturesPath.'/php/services_legacy_privates.php', $dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Legacy_Privates', 'file' => self::$fixturesPath.'/php/services_legacy_privates.php')));

        require self::$fixturesPath.'/php/services_legacy_privates.php';

        $container = new \Symfony_DI_PhpDumper_Test_Legacy_Privates();

        $container->get('private');
        $container->get('private_alias');
        $container->get('alias_to_private');
        $container->get('decorated_private');
        $container->get('decorated_private_alias');
        $container->get('private_not_inlined');
        $container->get('private_not_removed');
        $container->get('private_child');
        $container->get('private_parent');
        $container->get('public_child');
    }

    /**
     * This test checks the trigger of a deprecation note and should not be removed in major releases.
     *
     * @group legacy
     * @expectedDeprecation The "foo" service is deprecated. You should stop using it, as it will soon be removed.
     */
    public function testPrivateServiceTriggersDeprecation()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')
            ->setPublic(false)
            ->setDeprecated(true);
        $container->register('bar', 'stdClass')
            ->setPublic(true)
            ->setProperty('foo', new Reference('foo'));

        $container->compile();

        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Private_Service_Triggers_Deprecation')));

        $container = new \Symfony_DI_PhpDumper_Test_Private_Service_Triggers_Deprecation();

        $container->get('bar');
    }

    /**
     * @group legacy
     * @expectedDeprecation Parameter names will be made case sensitive in Symfony 4.0. Using "foo" instead of "Foo" is deprecated since Symfony 3.4.
     * @expectedDeprecation Parameter names will be made case sensitive in Symfony 4.0. Using "FOO" instead of "Foo" is deprecated since Symfony 3.4.
     * @expectedDeprecation Parameter names will be made case sensitive in Symfony 4.0. Using "bar" instead of "BAR" is deprecated since Symfony 3.4.
     */
    public function testParameterWithMixedCase()
    {
        $container = new ContainerBuilder(new ParameterBag(array('Foo' => 'bar', 'BAR' => 'foo')));
        $container->compile();

        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Parameter_With_Mixed_Case')));

        $container = new \Symfony_DI_PhpDumper_Test_Parameter_With_Mixed_Case();

        $this->assertSame('bar', $container->getParameter('foo'));
        $this->assertSame('bar', $container->getParameter('FOO'));
        $this->assertSame('foo', $container->getParameter('bar'));
        $this->assertSame('foo', $container->getParameter('BAR'));
    }

    /**
     * @group legacy
     * @expectedDeprecation Parameter names will be made case sensitive in Symfony 4.0. Using "FOO" instead of "foo" is deprecated since Symfony 3.4.
     */
    public function testParameterWithLowerCase()
    {
        $container = new ContainerBuilder(new ParameterBag(array('foo' => 'bar')));
        $container->compile();

        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Parameter_With_Lower_Case')));

        $container = new \Symfony_DI_PhpDumper_Test_Parameter_With_Lower_Case();

        $this->assertSame('bar', $container->getParameter('FOO'));
    }

    /**
     * @group legacy
     * @expectedDeprecation Service identifiers will be made case sensitive in Symfony 4.0. Using "foo" instead of "Foo" is deprecated since Symfony 3.3.
     * @expectedDeprecation The "Foo" service is deprecated. You should stop using it, as it will soon be removed.
     */
    public function testReferenceWithLowerCaseId()
    {
        $container = new ContainerBuilder();
        $container->register('Bar', 'stdClass')->setProperty('foo', new Reference('foo'))->setPublic(true);
        $container->register('Foo', 'stdClass')->setDeprecated();
        $container->compile();

        $dumper = new PhpDumper($container);
        eval('?>'.$dumper->dump(array('class' => 'Symfony_DI_PhpDumper_Test_Reference_With_Lower_Case_Id')));

        $container = new \Symfony_DI_PhpDumper_Test_Reference_With_Lower_Case_Id();

        $this->assertEquals((object) array('foo' => (object) array()), $container->get('Bar'));
    }
}

class Rot13EnvVarProcessor implements EnvVarProcessorInterface
{
    public function getEnv($prefix, $name, \Closure $getEnv)
    {
        return str_rot13($getEnv($name));
    }

    public static function getProvidedTypes()
    {
        return array('rot13' => 'string');
    }
>>>>>>> Update Open Social to 8.x-2.1
}
