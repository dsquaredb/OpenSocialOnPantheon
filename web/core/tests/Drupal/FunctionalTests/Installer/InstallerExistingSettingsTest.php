<?php

namespace Drupal\FunctionalTests\Installer;

<<<<<<< HEAD
=======
use Drupal\Core\Site\Settings;
<<<<<<< HEAD:web/core/modules/system/src/Tests/Installer/InstallerExistingSettingsTest.php
>>>>>>> revert Open Social update
use Drupal\simpletest\InstallerTestBase;
=======
>>>>>>> updating open social:web/core/tests/Drupal/FunctionalTests/Installer/InstallerExistingSettingsTest.php
use Drupal\Core\Database\Database;
use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tests the installer with an existing settings file.
 *
 * @group Installer
 */
class InstallerExistingSettingsTest extends InstallerTestBase {

  /**
   * {@inheritdoc}
   *
   * Fully configures a preexisting settings.php file before invoking the
   * interactive installer.
   */
  protected function prepareEnvironment() {
    parent::prepareEnvironment();
    // Pre-configure hash salt.
    // Any string is valid, so simply use the class name of this test.
<<<<<<< HEAD
    $this->settings['settings']['hash_salt'] = (object) array(
      'value' => __CLASS__,
      'required' => TRUE,
    );

    // During interactive install we'll change this to a different profile and
    // this test will ensure that the new value is written to settings.php.
    $this->settings['settings']['install_profile'] = (object) array(
      'value' => 'minimal',
      'required' => TRUE,
    );
=======
    $this->settings['settings']['hash_salt'] = (object) [
      'value' => __CLASS__,
      'required' => TRUE,
    ];

    // During interactive install we'll change this to a different profile and
    // this test will ensure that the new value is written to settings.php.
    $this->settings['settings']['install_profile'] = (object) [
      'value' => 'minimal',
      'required' => TRUE,
    ];
>>>>>>> revert Open Social update

    // Pre-configure database credentials.
    $connection_info = Database::getConnectionInfo();
    unset($connection_info['default']['pdo']);
    unset($connection_info['default']['init_commands']);

<<<<<<< HEAD
    $this->settings['databases']['default'] = (object) array(
      'value' => $connection_info,
      'required' => TRUE,
    );
=======
    $this->settings['databases']['default'] = (object) [
      'value' => $connection_info,
      'required' => TRUE,
    ];
>>>>>>> revert Open Social update

    // Use the kernel to find the site path because the site.path service should
    // not be available at this point in the install process.
    $site_path = DrupalKernel::findSitePath(Request::createFromGlobals());
    // Pre-configure config directories.
<<<<<<< HEAD
    $this->settings['config_directories'] = array(
      CONFIG_SYNC_DIRECTORY => (object) array(
        'value' => $site_path . '/files/config_sync',
        'required' => TRUE,
      ),
    );
=======
    $this->settings['config_directories'] = [
      CONFIG_SYNC_DIRECTORY => (object) [
        'value' => $site_path . '/files/config_sync',
        'required' => TRUE,
      ],
    ];
>>>>>>> revert Open Social update
    mkdir($this->settings['config_directories'][CONFIG_SYNC_DIRECTORY]->value, 0777, TRUE);
  }

  /**
   * {@inheritdoc}
   */
  protected function setUpSettings() {
    // This step should not appear, since settings.php is fully configured
    // already.
  }

  /**
   * Verifies that installation succeeded.
   */
  public function testInstaller() {
    $this->assertUrl('user/1');
    $this->assertResponse(200);
<<<<<<< HEAD
    $this->assertEqual('testing', drupal_get_profile(), 'Profile was changed from minimal to testing during interactive install.');
=======
    $this->assertEqual('testing', \Drupal::installProfile(), 'Profile was changed from minimal to testing during interactive install.');
    $this->assertEqual('testing', Settings::get('install_profile'), 'Profile was correctly changed to testing in Settings.php');
>>>>>>> revert Open Social update
  }

}