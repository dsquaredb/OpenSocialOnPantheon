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
 
 
 
    $this->installSchema('database_test', array(
=======
    $this->connection = Database::getConnection();
=======
=======
    $this->connection = Database::getConnection();
    $this->installSchema('database_test', [
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
 
  function ensureSampleDataNull() {
    db_insert('test_null')
      ->fields(array('name', 'age'))
      ->values(array(
=======
  public function ensureSampleDataNull() {
    $this->connection->insert('test_null')
      ->fields(['name', 'age'])
      ->values([
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
        'name' => 'John',
        'age' => 25,
        'job' => 'Singer',
      ))
      ->execute();

 
 
 
    $george = db_insert('test')
      ->fields(array(
=======
    $george = $connection->insert('test')
=======
    $george = db_insert('test')
=======
    $george = $connection->insert('test')
      ->fields([
        'name' => 'George',
        'age' => 27,
        'job' => 'Singer',
      ))
      ->execute();

 
 
 
    db_insert('test')
      ->fields(array(
=======
    $connection->insert('test')
=======
    db_insert('test')
=======
    $connection->insert('test')
      ->fields([
        'name' => 'Ringo',
        'age' => 28,
        'job' => 'Drummer',
      ))
      ->execute();

 
 
 
    $paul = db_insert('test')
      ->fields(array(
=======
    $paul = $connection->insert('test')
=======
    $paul = db_insert('test')
=======
    $paul = $connection->insert('test')
      ->fields([
        'name' => 'Paul',
        'age' => 26,
        'job' => 'Songwriter',
      ))
      ->execute();

 
 
 
    db_insert('test_people')
      ->fields(array(
=======
    $connection->insert('test_people')
=======
    db_insert('test_people')
=======
    $connection->insert('test_people')
      ->fields([
        'name' => 'Meredith',
        'age' => 30,
        'job' => 'Speaker',
      ))
      ->execute();

 
 
 
    db_insert('test_task')
      ->fields(array('pid', 'task', 'priority'))
      ->values(array(
=======
    $connection->insert('test_task')
=======
    db_insert('test_task')
=======
    $connection->insert('test_task')
      ->fields(['pid', 'task', 'priority'])
      ->values([
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

 
 
 
    db_insert('test_special_columns')
      ->fields(array(
=======
    $connection->insert('test_special_columns')
=======
    db_insert('test_special_columns')
=======
    $connection->insert('test_special_columns')
      ->fields([
        'id' => 1,
        'offset' => 'Offset value 1',
      ))
      ->execute();
  }

}
