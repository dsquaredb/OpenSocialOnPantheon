<?php

namespace Drupal\FunctionalTests\Installer;

use Drupal\Core\Database\Database;

/**
 * Tests the installer with an existing settings file with database connection
 * info.
 *
 * @group Installer
 */
class InstallerExistingDatabaseSettingsTest extends InstallerTestBase {

  /**
   * {@inheritdoc}
   */
  protected function prepareEnvironment() {
    parent::prepareEnvironment();
    // Pre-configure database credentials in settings.php.
    $connection_info = Database::getConnectionInfo();
    unset($connection_info['default']['pdo']);
    unset($connection_info['default']['init_commands']);

 
    $this->settings['databases']['default'] = (object) array(
      'value' => $connection_info,
      'required' => TRUE,
    );
=======
    $this->settings['databases']['default'] = (object) [
      'value' => $connection_info,
      'required' => TRUE,
    ];
 :web/core/modules/system/src/Tests/Installer/InstallerExistingDatabaseSettingsTest.php
    parent::setUp();
=======
  }

  /**
   * {@inheritdoc}
   *
   * @todo The database settings form is not supposed to appear if settings.php
   *   contains a valid database connection already (but e.g. no config
   *   directories yet).
   */
  protected function setUpSettings() {
    // All database settings should be pre-configured, except password.
    $values = $this->parameters['forms']['install_settings_form'];
    $driver = $values['driver'];
 
    $edit = array();
    if (isset($values[$driver]['password']) && $values[$driver]['password'] !== '') {
      $edit = $this->translatePostValues(array(
        $driver => array(
          'password' => $values[$driver]['password'],
        ),
      ));
=======
    $edit = [];
    if (isset($values[$driver]['password']) && $values[$driver]['password'] !== '') {
      $edit = $this->translatePostValues([
        $driver => [
          'password' => $values[$driver]['password'],
        ],
      ]);
    }
    $this->drupalPostForm(NULL, $edit, $this->translations['Save and continue']);
  }

  /**
   * Verifies that installation succeeded.
   */
  public function testInstaller() {
    $this->assertUrl('user/1');
    $this->assertResponse(200);
  }

}
