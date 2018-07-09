<?php

namespace Drupal\FunctionalTests\Installer;

/**
 * Tests the installer when a config_directory has already been set up.
 *
 * @group Installer
 */
class InstallerExistingConfigDirectoryTest extends InstallerTestBase {

  /**
   * The expected file perms of the folder.
   *
   * @var int
   */
  protected $expectedFilePerms;

  /**
   * {@inheritdoc}
   */
  protected function prepareEnvironment() {
    parent::prepareEnvironment();
    mkdir($this->root . DIRECTORY_SEPARATOR . $this->siteDirectory . '/config_read_only', 0444);
    $this->expectedFilePerms = fileperms($this->siteDirectory . '/config_read_only');
<<<<<<< HEAD
    $this->settings['config_directories'][CONFIG_SYNC_DIRECTORY] = (object) array(
      'value' => $this->siteDirectory . '/config_read_only',
      'required' => TRUE,
    );
=======
    $this->settings['config_directories'][CONFIG_SYNC_DIRECTORY] = (object) [
      'value' => $this->siteDirectory . '/config_read_only',
      'required' => TRUE,
    ];
<<<<<<< HEAD:web/core/modules/system/src/Tests/Installer/InstallerExistingConfigDirectoryTest.php
>>>>>>> revert Open Social update
    parent::setUp();
=======
>>>>>>> updating open social:web/core/tests/Drupal/FunctionalTests/Installer/InstallerExistingConfigDirectoryTest.php
  }

  /**
   * Verifies that installation succeeded.
   */
  public function testInstaller() {
    $this->assertUrl('user/1');
    $this->assertResponse(200);
    $this->assertEqual($this->expectedFilePerms, fileperms($this->siteDirectory . '/config_read_only'));
    $this->assertEqual([], glob($this->siteDirectory . '/config_read_only/*'), 'The sync directory is empty after install because it is read-only.');
  }

}
