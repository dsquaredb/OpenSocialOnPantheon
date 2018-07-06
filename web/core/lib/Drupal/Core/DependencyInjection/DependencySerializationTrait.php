<?php

namespace Drupal\Core\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides dependency injection friendly methods for serialization.
 */
trait DependencySerializationTrait {

  /**
   * An array of service IDs keyed by property name used for serialization.
   *
   * @var array
   */
  protected $_serviceIds = array();

  /**
   * {@inheritdoc}
   */
  public function __sleep() {
    $this->_serviceIds = array();
    $vars = get_object_vars($this);
    foreach ($vars as $key => $value) {
      if (is_object($value) && isset($value->_serviceId)) {
        // If a class member was instantiated by the dependency injection
        // container, only store its ID so it can be used to get a fresh object
        // on unserialization.
        $this->_serviceIds[$key] = $value->_serviceId;
        unset($vars[$key]);
      }
      // Special case the container, which might not have a service ID.
      elseif ($value instanceof ContainerInterface) {
        $this->_serviceIds[$key] = 'service_container';
        unset($vars[$key]);
      }
    }

    return array_keys($vars);
  }

  /**
   * {@inheritdoc}
   */
  public function __wakeup() {
    // Tests in isolation potentially unserialize in the parent process.
    if (isset($GLOBALS['__PHPUNIT_BOOTSTRAP']) && !\Drupal::hasContainer()) {
      return;
    }
    $container = \Drupal::getContainer();
    foreach ($this->_serviceIds as $key => $service_id) {
      $this->$key = $container->get($service_id);
    }
<<<<<<< HEAD
    $this->_serviceIds = array();
=======
    $this->_serviceIds = [];
<<<<<<< HEAD

    // In rare cases, when test data is serialized in the parent process, there
    // is a service container but it doesn't contain all expected services. To
    // avoid fatal errors during the wrap-up of failing tests, we check for this
    // case, too.
    if ($this->_entityStorages && (!$phpunit_bootstrap || $container->has('entity_type.manager'))) {
      /** @var \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager */
      $entity_type_manager = $container->get('entity_type.manager');
      foreach ($this->_entityStorages as $key => $entity_type_id) {
        $this->$key = $entity_type_manager->getStorage($entity_type_id);
      }
    }
    $this->_entityStorages = [];
>>>>>>> Update Open Social to 8.x-2.1
=======
>>>>>>> revert Open Social update
  }

}
