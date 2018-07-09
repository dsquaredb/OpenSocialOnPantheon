<?php

namespace Drupal\KernelTests\Core\Database;

use Drupal\Core\Database\Database;
use Drupal\KernelTests\KernelTestBase;

/**
 * Base class for databases database tests.
 *
 * Because all database tests share the same test data, we can centralize that
 * here.
 */
abstract class DatabaseTestBase extends KernelTestBase {

  public static $modules = array('database_test');

  /**
   * The database connection for testing.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  protected function setUp() {
    parent::setUp();
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    $this->installSchema('database_test', array(
=======
    $this->connection = Database::getConnection();
=======
>>>>>>> revert Open Social update
=======
    $this->connection = Database::getConnection();
>>>>>>> updating open social
    $this->installSchema('database_test', [
>>>>>>> Update Open Social to 8.x-2.1
      'test',
      'test_people',
      'test_people_copy',
      'test_one_blob',
      'test_two_blobs',
      'test_task',
      'test_null',
      'test_serialized',
      'test_special_columns',
      'TEST_UPPERCASE',
    ));
    self::addSampleData();
  }

  /**
   * Sets up tables for NULL handling.
   */
<<<<<<< HEAD
  function ensureSampleDataNull() {
    db_insert('test_null')
      ->fields(array('name', 'age'))
      ->values(array(
=======
  public function ensureSampleDataNull() {
    $this->connection->insert('test_null')
      ->fields(['name', 'age'])
      ->values([
>>>>>>> Update Open Social to 8.x-2.1
      'name' => 'Kermit',
      'age' => 25,
    ))
      ->values(array(
      'name' => 'Fozzie',
      'age' => NULL,
    ))
      ->values(array(
      'name' => 'Gonzo',
      'age' => 27,
    ))
      ->execute();
  }

  /**
   * Sets up our sample data.
   */
<<<<<<< HEAD
  static function addSampleData() {
    // We need the IDs, so we can't use a multi-insert here.
    $john = db_insert('test')
      ->fields(array(
=======
  public static function addSampleData() {
    $connection = Database::getConnection();

    // We need the IDs, so we can't use a multi-insert here.
    $john = $connection->insert('test')
      ->fields([
>>>>>>> Update Open Social to 8.x-2.1
        'name' => 'John',
        'age' => 25,
        'job' => 'Singer',
      ))
      ->execute();

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    $george = db_insert('test')
      ->fields(array(
=======
    $george = $connection->insert('test')
=======
    $george = db_insert('test')
>>>>>>> revert Open Social update
=======
    $george = $connection->insert('test')
>>>>>>> updating open social
      ->fields([
>>>>>>> Update Open Social to 8.x-2.1
        'name' => 'George',
        'age' => 27,
        'job' => 'Singer',
      ))
      ->execute();

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    db_insert('test')
      ->fields(array(
=======
    $connection->insert('test')
=======
    db_insert('test')
>>>>>>> revert Open Social update
=======
    $connection->insert('test')
>>>>>>> updating open social
      ->fields([
>>>>>>> Update Open Social to 8.x-2.1
        'name' => 'Ringo',
        'age' => 28,
        'job' => 'Drummer',
      ))
      ->execute();

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    $paul = db_insert('test')
      ->fields(array(
=======
    $paul = $connection->insert('test')
=======
    $paul = db_insert('test')
>>>>>>> revert Open Social update
=======
    $paul = $connection->insert('test')
>>>>>>> updating open social
      ->fields([
>>>>>>> Update Open Social to 8.x-2.1
        'name' => 'Paul',
        'age' => 26,
        'job' => 'Songwriter',
      ))
      ->execute();

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    db_insert('test_people')
      ->fields(array(
=======
    $connection->insert('test_people')
=======
    db_insert('test_people')
>>>>>>> revert Open Social update
=======
    $connection->insert('test_people')
>>>>>>> updating open social
      ->fields([
>>>>>>> Update Open Social to 8.x-2.1
        'name' => 'Meredith',
        'age' => 30,
        'job' => 'Speaker',
      ))
      ->execute();

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    db_insert('test_task')
      ->fields(array('pid', 'task', 'priority'))
      ->values(array(
=======
    $connection->insert('test_task')
=======
    db_insert('test_task')
>>>>>>> revert Open Social update
=======
    $connection->insert('test_task')
>>>>>>> updating open social
      ->fields(['pid', 'task', 'priority'])
      ->values([
>>>>>>> Update Open Social to 8.x-2.1
        'pid' => $john,
        'task' => 'eat',
        'priority' => 3,
      ))
      ->values(array(
        'pid' => $john,
        'task' => 'sleep',
        'priority' => 4,
      ))
      ->values(array(
        'pid' => $john,
        'task' => 'code',
        'priority' => 1,
      ))
      ->values(array(
        'pid' => $george,
        'task' => 'sing',
        'priority' => 2,
      ))
      ->values(array(
        'pid' => $george,
        'task' => 'sleep',
        'priority' => 2,
      ))
      ->values(array(
        'pid' => $paul,
        'task' => 'found new band',
        'priority' => 1,
      ))
      ->values(array(
        'pid' => $paul,
        'task' => 'perform at superbowl',
        'priority' => 3,
      ))
      ->execute();

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    db_insert('test_special_columns')
      ->fields(array(
=======
    $connection->insert('test_special_columns')
=======
    db_insert('test_special_columns')
>>>>>>> revert Open Social update
=======
    $connection->insert('test_special_columns')
>>>>>>> updating open social
      ->fields([
>>>>>>> Update Open Social to 8.x-2.1
        'id' => 1,
        'offset' => 'Offset value 1',
      ))
      ->execute();
  }

}
