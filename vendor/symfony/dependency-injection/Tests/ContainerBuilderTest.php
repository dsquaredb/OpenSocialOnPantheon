<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Tests;

require_once __DIR__.'/Fixtures/includes/classes.php';
require_once __DIR__.'/Fixtures/includes/ProjectExtension.php';

use Symfony\Component\Config\Resource\ResourceInterface;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Loader\ClosureLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\Scope;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\ExpressionLanguage\Expression;

class ContainerBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testDefinitions()
    {
        $builder = new ContainerBuilder();
        $definitions = array(
            'foo' => new Definition('Bar\FooClass'),
            'bar' => new Definition('BarClass'),
        );
        $builder->setDefinitions($definitions);
        $this->assertEquals($definitions, $builder->getDefinitions(), '->setDefinitions() sets the service definitions');
        $this->assertTrue($builder->hasDefinition('foo'), '->hasDefinition() returns true if a service definition exists');
        $this->assertFalse($builder->hasDefinition('foobar'), '->hasDefinition() returns false if a service definition does not exist');

        $builder->setDefinition('foobar', $foo = new Definition('FooBarClass'));
        $this->assertEquals($foo, $builder->getDefinition('foobar'), '->getDefinition() returns a service definition if defined');
        $this->assertTrue($builder->setDefinition('foobar', $foo = new Definition('FooBarClass')) === $foo, '->setDefinition() implements a fluid interface by returning the service reference');

        $builder->addDefinitions($defs = array('foobar' => new Definition('FooBarClass')));
        $this->assertEquals(array_merge($definitions, $defs), $builder->getDefinitions(), '->addDefinitions() adds the service definitions');

        try {
            $builder->getDefinition('baz');
            $this->fail('->getDefinition() throws a ServiceNotFoundException if the service definition does not exist');
        } catch (ServiceNotFoundException $e) {
            $this->assertEquals('You have requested a non-existent service "baz".', $e->getMessage(), '->getDefinition() throws a ServiceNotFoundException if the service definition does not exist');
        }
    }

    /**
     * @group legacy
     * @expectedDeprecation The "deprecated_foo" service is deprecated. You should stop using it, as it will soon be removed.
     */
    public function testCreateDeprecatedService()
    {
        $definition = new Definition('stdClass');
        $definition->setDeprecated(true);

        $builder = new ContainerBuilder();
        $builder->createService($definition, 'deprecated_foo');
    }

    public function testRegister()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo', 'Bar\FooClass');
        $this->assertTrue($builder->hasDefinition('foo'), '->register() registers a new service definition');
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\Definition', $builder->getDefinition('foo'), '->register() returns the newly created Definition instance');
    }

    public function testHas()
    {
        $builder = new ContainerBuilder();
        $this->assertFalse($builder->has('foo'), '->has() returns false if the service does not exist');
        $builder->register('foo', 'Bar\FooClass');
        $this->assertTrue($builder->has('foo'), '->has() returns true if a service definition exists');
        $builder->set('bar', new \stdClass());
        $this->assertTrue($builder->has('bar'), '->has() returns true if a service exists');
    }

    public function testGet()
    {
        $builder = new ContainerBuilder();
        try {
            $builder->get('foo');
            $this->fail('->get() throws a ServiceNotFoundException if the service does not exist');
        } catch (ServiceNotFoundException $e) {
            $this->assertEquals('You have requested a non-existent service "foo".', $e->getMessage(), '->get() throws a ServiceNotFoundException if the service does not exist');
        }

        $this->assertNull($builder->get('foo', ContainerInterface::NULL_ON_INVALID_REFERENCE), '->get() returns null if the service does not exist and NULL_ON_INVALID_REFERENCE is passed as a second argument');

        $builder->register('foo', 'stdClass');
        $this->assertInternalType('object', $builder->get('foo'), '->get() returns the service definition associated with the id');
        $builder->set('bar', $bar = new \stdClass());
        $this->assertEquals($bar, $builder->get('bar'), '->get() returns the service associated with the id');
        $builder->register('bar', 'stdClass');
        $this->assertEquals($bar, $builder->get('bar'), '->get() returns the service associated with the id even if a definition has been defined');

        $builder->register('baz', 'stdClass')->setArguments(array(new Reference('baz')));
        try {
            @$builder->get('baz');
            $this->fail('->get() throws a ServiceCircularReferenceException if the service has a circular reference to itself');
        } catch (ServiceCircularReferenceException $e) {
            $this->assertEquals('Circular reference detected for service "baz", path: "baz".', $e->getMessage(), '->get() throws a LogicException if the service has a circular reference to itself');
        }

        $this->assertTrue($builder->get('bar') === $builder->get('bar'), '->get() always returns the same instance if the service is shared');
    }

    public function testNonSharedServicesReturnsDifferentInstances()
    {
        $builder = new ContainerBuilder();
        $builder->register('bar', 'stdClass')->setShared(false);

        $this->assertNotSame($builder->get('bar'), $builder->get('bar'));
    }

    /**
     * @expectedException        \Symfony\Component\DependencyInjection\Exception\RuntimeException
     * @expectedExceptionMessage You have requested a synthetic service ("foo"). The DIC does not know how to construct this service.
     */
    public function testGetUnsetLoadingServiceWhenCreateServiceThrowsAnException()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo', 'stdClass')->setSynthetic(true);

        // we expect a RuntimeException here as foo is synthetic
        try {
            $builder->get('foo');
        } catch (RuntimeException $e) {
        }

        // we must also have the same RuntimeException here
        $builder->get('foo');
    }

    /**
     * @group legacy
     */
    public function testGetReturnsNullOnInactiveScope()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo', 'stdClass')->setScope('request');

        $this->assertNull($builder->get('foo', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    /**
     * @group legacy
     */
    public function testGetReturnsNullOnInactiveScopeWhenServiceIsCreatedByAMethod()
    {
        $builder = new ProjectContainer();

        $this->assertNull($builder->get('foobaz', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    }

    public function testGetServiceIds()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo', 'stdClass');
        $builder->bar = $bar = new \stdClass();
        $builder->register('bar', 'stdClass');
        $this->assertEquals(array('foo', 'bar', 'service_container'), $builder->getServiceIds(), '->getServiceIds() returns all defined service ids');
    }

    public function testAliases()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo', 'stdClass');
        $builder->setAlias('bar', 'foo');
        $this->assertTrue($builder->hasAlias('bar'), '->hasAlias() returns true if the alias exists');
        $this->assertFalse($builder->hasAlias('foobar'), '->hasAlias() returns false if the alias does not exist');
        $this->assertEquals('foo', (string) $builder->getAlias('bar'), '->getAlias() returns the aliased service');
        $this->assertTrue($builder->has('bar'), '->setAlias() defines a new service');
        $this->assertTrue($builder->get('bar') === $builder->get('foo'), '->setAlias() creates a service that is an alias to another one');

        try {
            $builder->setAlias('foobar', 'foobar');
            $this->fail('->setAlias() throws an InvalidArgumentException if the alias references itself');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('An alias can not reference itself, got a circular reference on "foobar".', $e->getMessage(), '->setAlias() throws an InvalidArgumentException if the alias references itself');
        }

        try {
            $builder->getAlias('foobar');
            $this->fail('->getAlias() throws an InvalidArgumentException if the alias does not exist');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('The service alias "foobar" does not exist.', $e->getMessage(), '->getAlias() throws an InvalidArgumentException if the alias does not exist');
        }
    }

    public function testGetAliases()
    {
        $builder = new ContainerBuilder();
        $builder->setAlias('bar', 'foo');
        $builder->setAlias('foobar', 'foo');
        $builder->setAlias('moo', new Alias('foo', false));

        $aliases = $builder->getAliases();
        $this->assertEquals('foo', (string) $aliases['bar']);
        $this->assertTrue($aliases['bar']->isPublic());
        $this->assertEquals('foo', (string) $aliases['foobar']);
        $this->assertEquals('foo', (string) $aliases['moo']);
        $this->assertFalse($aliases['moo']->isPublic());

        $builder->register('bar', 'stdClass');
        $this->assertFalse($builder->hasAlias('bar'));

        $builder->set('foobar', 'stdClass');
        $builder->set('moo', 'stdClass');
        $this->assertCount(0, $builder->getAliases(), '->getAliases() does not return aliased services that have been overridden');
    }

    public function testSetAliases()
    {
        $builder = new ContainerBuilder();
        $builder->setAliases(array('bar' => 'foo', 'foobar' => 'foo'));

        $aliases = $builder->getAliases();
        $this->assertTrue(isset($aliases['bar']));
        $this->assertTrue(isset($aliases['foobar']));
    }

    public function testAddAliases()
    {
        $builder = new ContainerBuilder();
        $builder->setAliases(array('bar' => 'foo'));
        $builder->addAliases(array('foobar' => 'foo'));

        $aliases = $builder->getAliases();
        $this->assertTrue(isset($aliases['bar']));
        $this->assertTrue(isset($aliases['foobar']));
    }

    public function testSetReplacesAlias()
    {
        $builder = new ContainerBuilder();
        $builder->setAlias('alias', 'aliased');
        $builder->set('aliased', new \stdClass());

        $builder->set('alias', $foo = new \stdClass());
        $this->assertSame($foo, $builder->get('alias'), '->set() replaces an existing alias');
    }

    public function testAddGetCompilerPass()
    {
        $builder = new ContainerBuilder();
        $builder->setResourceTracking(false);
        $builderCompilerPasses = $builder->getCompiler()->getPassConfig()->getPasses();
        $builder->addCompilerPass($this->getMock('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface'));

        $this->assertCount(count($builder->getCompiler()->getPassConfig()->getPasses()) - 1, $builderCompilerPasses);
    }

    public function testCreateService()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo1', 'Bar\FooClass')->setFile(__DIR__.'/Fixtures/includes/foo.php');
        $this->assertInstanceOf('\Bar\FooClass', $builder->get('foo1'), '->createService() requires the file defined by the service definition');
        $builder->register('foo2', 'Bar\FooClass')->setFile(__DIR__.'/Fixtures/includes/%file%.php');
        $builder->setParameter('file', 'foo');
        $this->assertInstanceOf('\Bar\FooClass', $builder->get('foo2'), '->createService() replaces parameters in the file provided by the service definition');
    }

    public function testCreateProxyWithRealServiceInstantiator()
    {
        $builder = new ContainerBuilder();

        $builder->register('foo1', 'Bar\FooClass')->setFile(__DIR__.'/Fixtures/includes/foo.php');
        $builder->getDefinition('foo1')->setLazy(true);

        $foo1 = $builder->get('foo1');

        $this->assertSame($foo1, $builder->get('foo1'), 'The same proxy is retrieved on multiple subsequent calls');
        $this->assertSame('Bar\FooClass', get_class($foo1));
    }

    public function testCreateServiceClass()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo1', '%class%');
        $builder->setParameter('class', 'stdClass');
        $this->assertInstanceOf('\stdClass', $builder->get('foo1'), '->createService() replaces parameters in the class provided by the service definition');
    }

    public function testCreateServiceArguments()
    {
        $builder = new ContainerBuilder();
        $builder->register('bar', 'stdClass');
        $builder->register('foo1', 'Bar\FooClass')->addArgument(array('foo' => '%value%', '%value%' => 'foo', new Reference('bar'), '%%unescape_it%%'));
        $builder->setParameter('value', 'bar');
        $this->assertEquals(array('foo' => 'bar', 'bar' => 'foo', $builder->get('bar'), '%unescape_it%'), $builder->get('foo1')->arguments, '->createService() replaces parameters and service references in the arguments provided by the service definition');
    }

    public function testCreateServiceFactory()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo', 'Bar\FooClass')->setFactory('Bar\FooClass::getInstance');
        $builder->register('qux', 'Bar\FooClass')->setFactory(array('Bar\FooClass', 'getInstance'));
        $builder->register('bar', 'Bar\FooClass')->setFactory(array(new Definition('Bar\FooClass'), 'getInstance'));
        $builder->register('baz', 'Bar\FooClass')->setFactory(array(new Reference('bar'), 'getInstance'));

        $this->assertTrue($builder->get('foo')->called, '->createService() calls the factory method to create the service instance');
        $this->assertTrue($builder->get('qux')->called, '->createService() calls the factory method to create the service instance');
        $this->assertTrue($builder->get('bar')->called, '->createService() uses anonymous service as factory');
        $this->assertTrue($builder->get('baz')->called, '->createService() uses another service as factory');
    }

    public function testLegacyCreateServiceFactory()
    {
        $builder = new ContainerBuilder();
        $builder->register('bar', 'Bar\FooClass');
        $builder
            ->register('foo1', 'Bar\FooClass')
            ->setFactoryClass('%foo_class%')
            ->setFactoryMethod('getInstance')
            ->addArgument(array('foo' => '%value%', '%value%' => 'foo', new Reference('bar')))
        ;
        $builder->setParameter('value', 'bar');
        $builder->setParameter('foo_class', 'Bar\FooClass');
        $this->assertTrue($builder->get('foo1')->called, '->createService() calls the factory method to create the service instance');
        $this->assertEquals(array('foo' => 'bar', 'bar' => 'foo', $builder->get('bar')), $builder->get('foo1')->arguments, '->createService() passes the arguments to the factory method');
    }

    public function testLegacyCreateServiceFactoryService()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo_service', 'Bar\FooClass');
        $builder
            ->register('foo', 'Bar\FooClass')
            ->setFactoryService('%foo_service%')
            ->setFactoryMethod('getInstance')
        ;
        $builder->setParameter('foo_service', 'foo_service');
        $this->assertTrue($builder->get('foo')->called, '->createService() calls the factory method to create the service instance');
    }

    public function testCreateServiceMethodCalls()
    {
        $builder = new ContainerBuilder();
        $builder->register('bar', 'stdClass');
        $builder->register('foo1', 'Bar\FooClass')->addMethodCall('setBar', array(array('%value%', new Reference('bar'))));
        $builder->setParameter('value', 'bar');
        $this->assertEquals(array('bar', $builder->get('bar')), $builder->get('foo1')->bar, '->createService() replaces the values in the method calls arguments');
    }

    public function testCreateServiceMethodCallsWithEscapedParam()
    {
        $builder = new ContainerBuilder();
        $builder->register('bar', 'stdClass');
        $builder->register('foo1', 'Bar\FooClass')->addMethodCall('setBar', array(array('%%unescape_it%%')));
        $builder->setParameter('value', 'bar');
        $this->assertEquals(array('%unescape_it%'), $builder->get('foo1')->bar, '->createService() replaces the values in the method calls arguments');
    }

    public function testCreateServiceProperties()
    {
        $builder = new ContainerBuilder();
        $builder->register('bar', 'stdClass');
        $builder->register('foo1', 'Bar\FooClass')->setProperty('bar', array('%value%', new Reference('bar'), '%%unescape_it%%'));
        $builder->setParameter('value', 'bar');
        $this->assertEquals(array('bar', $builder->get('bar'), '%unescape_it%'), $builder->get('foo1')->bar, '->createService() replaces the values in the properties');
    }

    public function testCreateServiceConfigurator()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo1', 'Bar\FooClass')->setConfigurator('sc_configure');
        $this->assertTrue($builder->get('foo1')->configured, '->createService() calls the configurator');

        $builder->register('foo2', 'Bar\FooClass')->setConfigurator(array('%class%', 'configureStatic'));
        $builder->setParameter('class', 'BazClass');
        $this->assertTrue($builder->get('foo2')->configured, '->createService() calls the configurator');

        $builder->register('baz', 'BazClass');
        $builder->register('foo3', 'Bar\FooClass')->setConfigurator(array(new Reference('baz'), 'configure'));
        $this->assertTrue($builder->get('foo3')->configured, '->createService() calls the configurator');

        $builder->register('foo4', 'Bar\FooClass')->setConfigurator(array($builder->getDefinition('baz'), 'configure'));
        $this->assertTrue($builder->get('foo4')->configured, '->createService() calls the configurator');

        $builder->register('foo5', 'Bar\FooClass')->setConfigurator('foo');
        try {
            $builder->get('foo5');
            $this->fail('->createService() throws an InvalidArgumentException if the configure callable is not a valid callable');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('The configure callable for class "Bar\FooClass" is not a callable.', $e->getMessage(), '->createService() throws an InvalidArgumentException if the configure callable is not a valid callable');
        }
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCreateSyntheticService()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo', 'Bar\FooClass')->setSynthetic(true);
        $builder->get('foo');
    }

    public function testCreateServiceWithExpression()
    {
        $builder = new ContainerBuilder();
        $builder->setParameter('bar', 'bar');
        $builder->register('bar', 'BarClass');
        $builder->register('foo', 'Bar\FooClass')->addArgument(array('foo' => new Expression('service("bar").foo ~ parameter("bar")')));
        $this->assertEquals('foobar', $builder->get('foo')->arguments['foo']);
    }

    public function testResolveServices()
    {
        $builder = new ContainerBuilder();
        $builder->register('foo', 'Bar\FooClass');
        $this->assertEquals($builder->get('foo'), $builder->resolveServices(new Reference('foo')), '->resolveServices() resolves service references to service instances');
        $this->assertEquals(array('foo' => array('foo', $builder->get('foo'))), $builder->resolveServices(array('foo' => array('foo', new Reference('foo')))), '->resolveServices() resolves service references to service instances in nested arrays');
        $this->assertEquals($builder->get('foo'), $builder->resolveServices(new Expression('service("foo")')), '->resolveServices() resolves expressions');
    }

    public function testMerge()
    {
        $container = new ContainerBuilder(new ParameterBag(array('bar' => 'foo')));
        $container->setResourceTracking(false);
        $config = new ContainerBuilder(new ParameterBag(array('foo' => 'bar')));
        $container->merge($config);
        $this->assertEquals(array('bar' => 'foo', 'foo' => 'bar'), $container->getParameterBag()->all(), '->merge() merges current parameters with the loaded ones');

        $container = new ContainerBuilder(new ParameterBag(array('bar' => 'foo')));
        $container->setResourceTracking(false);
        $config = new ContainerBuilder(new ParameterBag(array('foo' => '%bar%')));
        $container->merge($config);
        $container->compile();
        $this->assertEquals(array('bar' => 'foo', 'foo' => 'foo'), $container->getParameterBag()->all(), '->merge() evaluates the values of the parameters towards already defined ones');

        $container = new ContainerBuilder(new ParameterBag(array('bar' => 'foo')));
        $container->setResourceTracking(false);
        $config = new ContainerBuilder(new ParameterBag(array('foo' => '%bar%', 'baz' => '%foo%')));
        $container->merge($config);
        $container->compile();
        $this->assertEquals(array('bar' => 'foo', 'foo' => 'foo', 'baz' => 'foo'), $container->getParameterBag()->all(), '->merge() evaluates the values of the parameters towards already defined ones');

        $container = new ContainerBuilder();
        $container->setResourceTracking(false);
        $container->register('foo', 'Bar\FooClass');
        $container->register('bar', 'BarClass');
        $config = new ContainerBuilder();
        $config->setDefinition('baz', new Definition('BazClass'));
        $config->setAlias('alias_for_foo', 'foo');
        $container->merge($config);
        $this->assertEquals(array('foo', 'bar', 'baz'), array_keys($container->getDefinitions()), '->merge() merges definitions already defined ones');

        $aliases = $container->getAliases();
        $this->assertTrue(isset($aliases['alias_for_foo']));
        $this->assertEquals('foo', (string) $aliases['alias_for_foo']);

        $container = new ContainerBuilder();
        $container->setResourceTracking(false);
        $container->register('foo', 'Bar\FooClass');
        $config->setDefinition('foo', new Definition('BazClass'));
        $container->merge($config);
        $this->assertEquals('BazClass', $container->getDefinition('foo')->getClass(), '->merge() overrides already defined services');
<<<<<<< HEAD
=======

        $container = new ContainerBuilder();
        $bag = new EnvPlaceholderParameterBag();
        $bag->get('env(Foo)');
        $config = new ContainerBuilder($bag);
        $this->assertSame(array('%env(Bar)%'), $config->resolveEnvPlaceholders(array($bag->get('env(Bar)'))));
        $container->merge($config);
        $this->assertEquals(array('Foo' => 0, 'Bar' => 1), $container->getEnvCounters());

        $container = new ContainerBuilder();
        $config = new ContainerBuilder();
        $childDefA = $container->registerForAutoconfiguration('AInterface');
        $childDefB = $config->registerForAutoconfiguration('BInterface');
        $container->merge($config);
        $this->assertSame(array('AInterface' => $childDefA, 'BInterface' => $childDefB), $container->getAutoconfiguredInstanceof());
    }

    /**
     * @expectedException \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     * @expectedExceptionMessage "AInterface" has already been autoconfigured and merge() does not support merging autoconfiguration for the same class/interface.
     */
    public function testMergeThrowsExceptionForDuplicateAutomaticInstanceofDefinitions()
    {
        $container = new ContainerBuilder();
        $config = new ContainerBuilder();
        $container->registerForAutoconfiguration('AInterface');
        $config->registerForAutoconfiguration('AInterface');
        $container->merge($config);
    }

    public function testResolveEnvValues()
    {
        $_ENV['DUMMY_ENV_VAR'] = 'du%%y';
        $_SERVER['DUMMY_SERVER_VAR'] = 'ABC';
        $_SERVER['HTTP_DUMMY_VAR'] = 'DEF';

        $container = new ContainerBuilder();
        $container->setParameter('bar', '%% %env(DUMMY_ENV_VAR)% %env(DUMMY_SERVER_VAR)% %env(HTTP_DUMMY_VAR)%');
        $container->setParameter('env(HTTP_DUMMY_VAR)', '123');

        $this->assertSame('%% du%%%%y ABC 123', $container->resolveEnvPlaceholders('%bar%', true));

        unset($_ENV['DUMMY_ENV_VAR'], $_SERVER['DUMMY_SERVER_VAR'], $_SERVER['HTTP_DUMMY_VAR']);
    }

    public function testResolveEnvValuesWithArray()
    {
        $_ENV['ANOTHER_DUMMY_ENV_VAR'] = 'dummy';

        $dummyArray = array('1' => 'one', '2' => 'two');

        $container = new ContainerBuilder();
        $container->setParameter('dummy', '%env(ANOTHER_DUMMY_ENV_VAR)%');
        $container->setParameter('dummy2', $dummyArray);

        $container->resolveEnvPlaceholders('%dummy%', true);
        $container->resolveEnvPlaceholders('%dummy2%', true);

        $this->assertInternalType('array', $container->resolveEnvPlaceholders('%dummy2%', true));

        foreach ($dummyArray as $key => $value) {
            $this->assertArrayHasKey($key, $container->resolveEnvPlaceholders('%dummy2%', true));
        }

        unset($_ENV['ANOTHER_DUMMY_ENV_VAR']);
    }

    public function testCompileWithResolveEnv()
    {
        putenv('DUMMY_ENV_VAR=du%%y');
        $_SERVER['DUMMY_SERVER_VAR'] = 'ABC';
        $_SERVER['HTTP_DUMMY_VAR'] = 'DEF';

        $container = new ContainerBuilder();
        $container->setParameter('env(FOO)', 'Foo');
        $container->setParameter('env(DUMMY_ENV_VAR)', 'GHI');
        $container->setParameter('bar', '%% %env(DUMMY_ENV_VAR)% %env(DUMMY_SERVER_VAR)% %env(HTTP_DUMMY_VAR)%');
        $container->setParameter('foo', '%env(FOO)%');
        $container->setParameter('baz', '%foo%');
        $container->setParameter('env(HTTP_DUMMY_VAR)', '123');
        $container->register('teatime', 'stdClass')
            ->setProperty('foo', '%env(DUMMY_ENV_VAR)%')
            ->setPublic(true)
        ;
        $container->compile(true);

        $this->assertSame('% du%%y ABC 123', $container->getParameter('bar'));
        $this->assertSame('Foo', $container->getParameter('baz'));
        $this->assertSame('du%%y', $container->get('teatime')->foo);

        unset($_SERVER['DUMMY_SERVER_VAR'], $_SERVER['HTTP_DUMMY_VAR']);
        putenv('DUMMY_ENV_VAR');
    }

    /**
     * @expectedException \Symfony\Component\DependencyInjection\Exception\RuntimeException
     * @expectedExceptionMessage A string value must be composed of strings and/or numbers, but found parameter "env(ARRAY)" of type array inside string value "ABC %env(ARRAY)%".
     */
    public function testCompileWithArrayResolveEnv()
    {
        $bag = new TestingEnvPlaceholderParameterBag();
        $container = new ContainerBuilder($bag);
        $container->setParameter('foo', '%env(ARRAY)%');
        $container->setParameter('bar', 'ABC %env(ARRAY)%');
        $container->compile(true);
    }

    /**
     * @expectedException \Symfony\Component\DependencyInjection\Exception\EnvNotFoundException
     * @expectedExceptionMessage Environment variable not found: "FOO".
     */
    public function testCompileWithResolveMissingEnv()
    {
        $container = new ContainerBuilder();
        $container->setParameter('foo', '%env(FOO)%');
        $container->compile(true);
    }

    public function testDynamicEnv()
    {
        putenv('DUMMY_FOO=some%foo%');
        putenv('DUMMY_BAR=%bar%');

        $container = new ContainerBuilder();
        $container->setParameter('foo', 'Foo%env(resolve:DUMMY_BAR)%');
        $container->setParameter('bar', 'Bar');
        $container->setParameter('baz', '%env(resolve:DUMMY_FOO)%');

        $container->compile(true);
        putenv('DUMMY_FOO');
        putenv('DUMMY_BAR');

        $this->assertSame('someFooBar', $container->getParameter('baz'));
    }

    public function testCastEnv()
    {
        $container = new ContainerBuilder();
        $container->setParameter('env(FAKE)', '123');

        $container->register('foo', 'stdClass')
            ->setPublic(true)
            ->setProperties(array(
                'fake' => '%env(int:FAKE)%',
            ));

        $container->compile(true);

        $this->assertSame(123, $container->get('foo')->fake);
    }

    public function testEnvAreNullable()
    {
        $container = new ContainerBuilder();
        $container->setParameter('env(FAKE)', null);

        $container->register('foo', 'stdClass')
            ->setPublic(true)
            ->setProperties(array(
            'fake' => '%env(int:FAKE)%',
        ));

        $container->compile(true);

        $this->assertNull($container->get('foo')->fake);
    }

    public function testEnvInId()
    {
        $container = include __DIR__.'/Fixtures/containers/container_env_in_id.php';
        $container->compile(true);

        $expected = array(
            'service_container',
            'foo',
            'bar',
            'bar_%env(BAR)%',
        );
        $this->assertSame($expected, array_keys($container->getDefinitions()));

        $expected = array(
            PsrContainerInterface::class => true,
            ContainerInterface::class => true,
            'baz_%env(BAR)%' => true,
            'bar_%env(BAR)%' => true,
        );
        $this->assertSame($expected, $container->getRemovedIds());

        $this->assertSame(array('baz_bar'), array_keys($container->getDefinition('foo')->getArgument(1)));
    }

    /**
     * @expectedException \Symfony\Component\DependencyInjection\Exception\ParameterCircularReferenceException
     * @expectedExceptionMessage Circular reference detected for parameter "env(resolve:DUMMY_ENV_VAR)" ("env(resolve:DUMMY_ENV_VAR)" > "env(resolve:DUMMY_ENV_VAR)").
     */
    public function testCircularDynamicEnv()
    {
        putenv('DUMMY_ENV_VAR=some%foo%');

        $container = new ContainerBuilder();
        $container->setParameter('foo', '%bar%');
        $container->setParameter('bar', '%env(resolve:DUMMY_ENV_VAR)%');

        try {
            $container->compile(true);
        } finally {
            putenv('DUMMY_ENV_VAR');
        }
>>>>>>> Update Open Social to 8.x-2.1
    }

    /**
     * @expectedException \LogicException
     */
    public function testMergeLogicException()
    {
        $container = new ContainerBuilder();
        $container->setResourceTracking(false);
        $container->compile();
        $container->merge(new ContainerBuilder());
    }

    public function testfindTaggedServiceIds()
    {
        $builder = new ContainerBuilder();
        $builder
            ->register('foo', 'Bar\FooClass')
            ->addTag('foo', array('foo' => 'foo'))
            ->addTag('bar', array('bar' => 'bar'))
            ->addTag('foo', array('foofoo' => 'foofoo'))
        ;
        $this->assertEquals($builder->findTaggedServiceIds('foo'), array(
            'foo' => array(
                array('foo' => 'foo'),
                array('foofoo' => 'foofoo'),
            ),
        ), '->findTaggedServiceIds() returns an array of service ids and its tag attributes');
        $this->assertEquals(array(), $builder->findTaggedServiceIds('foobar'), '->findTaggedServiceIds() returns an empty array if there is annotated services');
    }

    public function testFindUnusedTags()
    {
        $builder = new ContainerBuilder();
        $builder
            ->register('foo', 'Bar\FooClass')
            ->addTag('kernel.event_listener', array('foo' => 'foo'))
            ->addTag('kenrel.event_listener', array('bar' => 'bar'))
        ;
        $builder->findTaggedServiceIds('kernel.event_listener');
        $this->assertEquals(array('kenrel.event_listener'), $builder->findUnusedTags(), '->findUnusedTags() returns an array with unused tags');
    }

    public function testFindDefinition()
    {
        $container = new ContainerBuilder();
        $container->setDefinition('foo', $definition = new Definition('Bar\FooClass'));
        $container->setAlias('bar', 'foo');
        $container->setAlias('foobar', 'bar');
        $this->assertEquals($definition, $container->findDefinition('foobar'), '->findDefinition() returns a Definition');
    }

    public function testAddObjectResource()
    {
        $container = new ContainerBuilder();

        $container->setResourceTracking(false);
        $container->addObjectResource(new \BarClass());

        $this->assertEmpty($container->getResources(), 'No resources get registered without resource tracking');

        $container->setResourceTracking(true);
        $container->addObjectResource(new \BarClass());

        $resources = $container->getResources();

        $this->assertCount(1, $resources, '1 resource was registered');

        /* @var $resource \Symfony\Component\Config\Resource\FileResource */
        $resource = end($resources);

        $this->assertInstanceOf('Symfony\Component\Config\Resource\FileResource', $resource);
        $this->assertSame(realpath(__DIR__.'/Fixtures/includes/classes.php'), realpath($resource->getResource()));
    }

    public function testAddClassResource()
    {
        $container = new ContainerBuilder();

        $container->setResourceTracking(false);
        $container->addClassResource(new \ReflectionClass('BarClass'));

        $this->assertEmpty($container->getResources(), 'No resources get registered without resource tracking');

        $container->setResourceTracking(true);
        $container->addClassResource(new \ReflectionClass('BarClass'));

        $resources = $container->getResources();

        $this->assertCount(1, $resources, '1 resource was registered');

        /* @var $resource \Symfony\Component\Config\Resource\FileResource */
        $resource = end($resources);

        $this->assertInstanceOf('Symfony\Component\Config\Resource\FileResource', $resource);
        $this->assertSame(realpath(__DIR__.'/Fixtures/includes/classes.php'), realpath($resource->getResource()));
    }

    public function testCompilesClassDefinitionsOfLazyServices()
    {
        $container = new ContainerBuilder();

        $this->assertEmpty($container->getResources(), 'No resources get registered without resource tracking');

        $container->register('foo', 'BarClass');
        $container->getDefinition('foo')->setLazy(true);

        $container->compile();

        $classesPath = realpath(__DIR__.'/Fixtures/includes/classes.php');
        $matchingResources = array_filter(
            $container->getResources(),
            function (ResourceInterface $resource) use ($classesPath) {
                return $resource instanceof FileResource && $classesPath === realpath($resource->getResource());
            }
        );

        $this->assertNotEmpty($matchingResources);
    }

    public function testResources()
    {
        $container = new ContainerBuilder();
        $container->addResource($a = new FileResource(__DIR__.'/Fixtures/xml/services1.xml'));
        $container->addResource($b = new FileResource(__DIR__.'/Fixtures/xml/services2.xml'));
        $resources = array();
        foreach ($container->getResources() as $resource) {
            if (false === strpos($resource, '.php')) {
                $resources[] = $resource;
            }
        }
        $this->assertEquals(array($a, $b), $resources, '->getResources() returns an array of resources read for the current configuration');
        $this->assertSame($container, $container->setResources(array()));
        $this->assertEquals(array(), $container->getResources());
    }

    public function testExtension()
    {
        $container = new ContainerBuilder();
        $container->setResourceTracking(false);

        $container->registerExtension($extension = new \ProjectExtension());
        $this->assertTrue($container->getExtension('project') === $extension, '->registerExtension() registers an extension');

        $this->setExpectedException('LogicException');
        $container->getExtension('no_registered');
    }

    public function testRegisteredButNotLoadedExtension()
    {
        $extension = $this->getMock('Symfony\\Component\\DependencyInjection\\Extension\\ExtensionInterface');
        $extension->expects($this->once())->method('getAlias')->will($this->returnValue('project'));
        $extension->expects($this->never())->method('load');

        $container = new ContainerBuilder();
        $container->setResourceTracking(false);
        $container->registerExtension($extension);
        $container->compile();
    }

    public function testRegisteredAndLoadedExtension()
    {
        $extension = $this->getMock('Symfony\\Component\\DependencyInjection\\Extension\\ExtensionInterface');
        $extension->expects($this->exactly(2))->method('getAlias')->will($this->returnValue('project'));
        $extension->expects($this->once())->method('load')->with(array(array('foo' => 'bar')));

        $container = new ContainerBuilder();
        $container->setResourceTracking(false);
        $container->registerExtension($extension);
        $container->loadFromExtension('project', array('foo' => 'bar'));
        $container->compile();
    }

    public function testPrivateServiceUser()
    {
        $fooDefinition = new Definition('BarClass');
        $fooUserDefinition = new Definition('BarUserClass', array(new Reference('bar')));
        $container = new ContainerBuilder();
        $container->setResourceTracking(false);

        $fooDefinition->setPublic(false);

        $container->addDefinitions(array(
            'bar' => $fooDefinition,
            'bar_user' => $fooUserDefinition,
        ));

        $container->compile();
        $this->assertInstanceOf('BarClass', $container->get('bar_user')->bar);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testThrowsExceptionWhenSetServiceOnAFrozenContainer()
    {
        $container = new ContainerBuilder();
        $container->setResourceTracking(false);
        $container->setDefinition('a', new Definition('stdClass'));
        $container->compile();
        $container->set('a', new \stdClass());
    }

    public function testThrowsExceptionWhenAddServiceOnAFrozenContainer()
    {
        $container = new ContainerBuilder();
        $container->compile();
        $container->set('a', $foo = new \stdClass());
        $this->assertSame($foo, $container->get('a'));
    }

    public function testNoExceptionWhenSetSyntheticServiceOnAFrozenContainer()
    {
        $container = new ContainerBuilder();
        $def = new Definition('stdClass');
        $def->setSynthetic(true);
        $container->setDefinition('a', $def);
        $container->compile();
        $container->set('a', $a = new \stdClass());
        $this->assertEquals($a, $container->get('a'));
    }

    /**
     * @group legacy
     */
    public function testLegacySetOnSynchronizedService()
    {
        $container = new ContainerBuilder();
        $container->register('baz', 'BazClass')
            ->setSynchronized(true)
        ;
        $container->register('bar', 'BarClass')
            ->addMethodCall('setBaz', array(new Reference('baz')))
        ;

        $container->set('baz', $baz = new \BazClass());
        $this->assertSame($baz, $container->get('bar')->getBaz());

        $container->set('baz', $baz = new \BazClass());
        $this->assertSame($baz, $container->get('bar')->getBaz());
    }

    /**
     * @group legacy
     */
    public function testLegacySynchronizedServiceWithScopes()
    {
        $container = new ContainerBuilder();
        $container->addScope(new Scope('foo'));
        $container->register('baz', 'BazClass')
            ->setSynthetic(true)
            ->setSynchronized(true)
            ->setScope('foo')
        ;
        $container->register('bar', 'BarClass')
            ->addMethodCall('setBaz', array(new Reference('baz', ContainerInterface::NULL_ON_INVALID_REFERENCE, false)))
        ;
        $container->compile();

        $container->enterScope('foo');
        $container->set('baz', $outerBaz = new \BazClass(), 'foo');
        $this->assertSame($outerBaz, $container->get('bar')->getBaz());

        $container->enterScope('foo');
        $container->set('baz', $innerBaz = new \BazClass(), 'foo');
        $this->assertSame($innerBaz, $container->get('bar')->getBaz());
        $container->leaveScope('foo');

        $this->assertNotSame($innerBaz, $container->get('bar')->getBaz());
        $this->assertSame($outerBaz, $container->get('bar')->getBaz());

        $container->leaveScope('foo');
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testThrowsExceptionWhenSetDefinitionOnAFrozenContainer()
    {
        $container = new ContainerBuilder();
        $container->setResourceTracking(false);
        $container->compile();
        $container->setDefinition('a', new Definition());
    }

    public function testExtensionConfig()
    {
        $container = new ContainerBuilder();

        $configs = $container->getExtensionConfig('foo');
        $this->assertEmpty($configs);

        $first = array('foo' => 'bar');
        $container->prependExtensionConfig('foo', $first);
        $configs = $container->getExtensionConfig('foo');
        $this->assertEquals(array($first), $configs);

        $second = array('ding' => 'dong');
        $container->prependExtensionConfig('foo', $second);
        $configs = $container->getExtensionConfig('foo');
        $this->assertEquals(array($second, $first), $configs);
    }

    public function testAbstractAlias()
    {
        $container = new ContainerBuilder();

        $abstract = new Definition('AbstractClass');
        $abstract->setAbstract(true);

        $container->setDefinition('abstract_service', $abstract);
        $container->setAlias('abstract_alias', 'abstract_service');

        $container->compile();

        $this->assertSame('abstract_service', (string) $container->getAlias('abstract_alias'));
    }

    public function testLazyLoadedService()
    {
        $loader = new ClosureLoader($container = new ContainerBuilder());
        $loader->load(function (ContainerBuilder $container) {
                $container->set('a', new \BazClass());
                $definition = new Definition('BazClass');
                $definition->setLazy(true);
                $container->setDefinition('a', $definition);
            }
        );

        $container->setResourceTracking(true);

        $container->compile();

        $class = new \BazClass();
        $reflectionClass = new \ReflectionClass($class);

        $r = new \ReflectionProperty($container, 'resources');
        $r->setAccessible(true);
        $resources = $r->getValue($container);

        $classInList = false;
        foreach ($resources as $resource) {
            if ($resource->getResource() === $reflectionClass->getFileName()) {
                $classInList = true;
                break;
            }
        }

        $this->assertTrue($classInList);
    }

    public function testAutowiring()
    {
        $container = new ContainerBuilder();

        $container->register('a', __NAMESPACE__.'\A');
        $bDefinition = $container->register('b', __NAMESPACE__.'\B');
        $bDefinition->setAutowired(true);

        $container->compile();

        $this->assertEquals('a', (string) $container->getDefinition('b')->getArgument(0));
    }
}

class FooClass
{
}

class ProjectContainer extends ContainerBuilder
{
    public function getFoobazService()
    {
        throw new InactiveScopeException('foo', 'request');
    }
}

class A
{
}
<<<<<<< HEAD

class B
{
    public function __construct(A $a)
    {
    }
}
<<<<<<< HEAD
=======
>>>>>>> Update Open Social to 8.x-2.1
=======

class TestingEnvPlaceholderParameterBag extends EnvPlaceholderParameterBag
{
    public function get($name)
    {
        return 'env(array)' === strtolower($name) ? array(123) : parent::get($name);
    }
}
>>>>>>> revert Open Social update
