<?php

use Drupal\DrupalExtension\Context\DrupalContext;
use Behat\Mink\Element\Element;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

use Behat\Gherkin\Node\TableNode;

/**
 * Provides pre-built step definitions for interacting with Open Social.
 */
class SocialDrupalContext extends DrupalContext {


  /**
   * @beforeScenario @api
   */
  public function bootstrapWithAdminUser(BeforeScenarioScope $scope) {
    $admin_user = user_load('1');
    $current_user = \Drupal::getContainer()->get('current_user');
    $current_user->setAccount($admin_user);
  }

  /**
   * Creates content of the given type for the current user,
   * provided in the form:
   * | title     | My node        |
   * | Field One | My field value |
   * | status    | 1              |
   * | ...       | ...            |
   *
   * @Given I am viewing my :type( content):
   */
  public function assertViewingMyNode($type, TableNode $fields) {

    $user_manager = $this->getUserManager();
    $user = $user_manager->getCurrentUser();
    if (!$user) {
      throw new \Exception(sprintf('There is no current logged in user to create a node for.'));
    }

    $node = (object) array(
      'type' => $type,
    );
    foreach ($fields->getRowsHash() as $field => $value) {
      if (strpos($field, 'date') !== FALSE) {
        $value =  date('Y-m-d H:i:s', strtotime($value));
      }
      $node->{$field} = $value;
    }

    $node->uid = $user->uid;

    $saved = $this->nodeCreate($node);

    // Set internal browser on the node.
    $this->getSession()->visit($this->locatePath('/node/' . $saved->nid));
  }

  /**
   * @override DrupalContext:assertViewingNode().
   *
   * To support relative dates.
   */
  public function assertViewingNode($type, TableNode $fields) {
    $node = (object) array(
      'type' => $type,
    );
    foreach ($fields->getRowsHash() as $field => $value) {
      if (strpos($field, 'date') !== FALSE) {
        $value = date('Y-m-d H:i:s', strtotime($value));
      }
      $node->{$field} = $value;
    }

    $saved = $this->nodeCreate($node);

    // Set internal browser on the node.
    $this->getSession()->visit($this->locatePath('/node/' . $saved->nid));
  }
  /**
   * @override DrupalContext:createNodes().
   *
   * To support relative dates.
   */
  public function createNodes($type, TableNode $nodesTable) {
    foreach ($nodesTable->getHash() as $nodeHash) {
      $node = (object) $nodeHash;
      $node->type = $type;
      if (isset($node->field_event_date)) {
        $node->field_event_date = date('Y-m-d H:i:s', strtotime($node->field_event_date));
      }
      $this->nodeCreate($node);
    }
  }

  /**
   * @When I wait for the queue to be empty
   */
  public function iWaitForTheQueueToBeEmpty()
  {
    $workerManager = \Drupal::service('plugin.manager.queue_worker');
    /** @var Drupal\Core\Queue\QueueFactory; $queue */
    $queue = \Drupal::service('queue');

    for ($i = 0; $i < 20; $i++) {
      foreach ($workerManager->getDefinitions() as $name => $info) {
        /** @var Drupal\Core\Queue\QueueInterface $worker */
        $worker = $queue->get($name);

        /** @var \Drupal\Core\Queue\QueueWorkerInterface $queue_worker */
        $queue_worker = $workerManager->createInstance($name);

        if ($worker->numberOfItems() > 0) {
          while ($item = $worker->claimItem()) {
            $queue_worker->processItem($item->data);
            $worker->deleteItem($item);
          }
        }
      }
    }
  }

  /**
   * I wait for (seconds) seconds.
   *
   * @When /^(?:|I )wait for "([^"]*)" seconds$/
   */
  public function iWaitForSeconds($seconds, $condition = "") {
    $milliseconds = (int) ($seconds * 1000);
    $this->getSession()->wait($milliseconds, $condition);
  }

  /**
   * I enable the module :module_name.
   *
   * @When /^(?:|I )enable the module "([^"]*)"/
   */
  public function iEnableTheModule($module_name) {
    $modules = [$module_name];
    \Drupal::service('module_installer')->install($modules);
  }
}
