<?php

namespace Drupal\Tests\file\Kernel\Migrate\d7;

<<<<<<< HEAD
use Drupal\Core\StreamWrapper\StreamWrapperInterface;
use Drupal\file\Entity\File;
use Drupal\file\FileInterface;
=======
>>>>>>> Update Open Social to 8.x-2.1
use Drupal\Tests\migrate_drupal\Kernel\d7\MigrateDrupal7TestBase;

/**
 * Migrates all files in the file_managed table.
 *
 * @group file
 */
class MigrateFileTest extends MigrateDrupal7TestBase {

<<<<<<< HEAD
=======
  use FileMigrationSetupTrait;

  /**
   * {@inheritdoc}
   */
>>>>>>> Update Open Social to 8.x-2.1
  public static $modules = ['file'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
<<<<<<< HEAD

    $this->installEntitySchema('file');
    $this->container->get('stream_wrapper_manager')->registerWrapper('public', 'Drupal\Core\StreamWrapper\PublicStream', StreamWrapperInterface::NORMAL);

    $fs = \Drupal::service('file_system');
    // The public file directory active during the test will serve as the
    // root of the fictional Drupal 7 site we're migrating.
    $fs->mkdir('public://sites/default/files', NULL, TRUE);
    file_put_contents('public://sites/default/files/cube.jpeg', str_repeat('*', 3620));

    /** @var \Drupal\migrate\Plugin\Migration $migration */
    $migration = $this->getMigration('d7_file');
    // Set the source plugin's source_base_path configuration value, which
    // would normally be set by the user running the migration.
    $source = $migration->getSourceConfiguration();
    $source['constants']['source_base_path'] = $fs->realpath('public://');
    $migration->set('source', $source);
    $this->executeMigration($migration);
=======
    $this->fileMigrationSetup();
>>>>>>> Update Open Social to 8.x-2.1
  }

  /**
   * {@inheritdoc}
   */
  protected function getFileMigrationInfo() {
    return [
      'path' => 'public://sites/default/files/cube.jpeg',
      'size' => '3620',
      'base_path' => 'public://',
      'plugin_id' => 'd7_file',
    ];
  }

  /**
   * Tests that all expected files are migrated.
   */
  public function testFileMigration() {
    $this->assertEntity(1, 'cube.jpeg', 'public://cube.jpeg', 'image/jpeg', '3620', '1421727515', '1421727515', '1');
  }

}
