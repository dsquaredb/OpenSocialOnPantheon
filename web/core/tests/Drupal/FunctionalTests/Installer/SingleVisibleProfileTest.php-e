<?php

namespace Drupal\FunctionalTests\Installer;

use Drupal\Core\Serialization\Yaml;

/**
 * Tests distribution profile support.
 *
 * @group Installer
 */
class SingleVisibleProfileTest extends InstallerTestBase {

  /**
   * The installation profile to install.
   *
   * Not needed when only one is visible.
   *
   * @var string
   */
  protected $profile = NULL;

<<<<<<< HEAD:web/core/modules/system/src/Tests/Installer/SingleVisibleProfileTest.php
<<<<<<< HEAD
  /**
   * The install profile info.
   *
   * @var array
   */
  protected $info;

  protected function setUp() {
    $this->info = array(
      'type' => 'profile',
      'core' => \Drupal::CORE_COMPATIBILITY,
      'name' => 'Override standard',
      'hidden' => TRUE,
    );
    // File API functions are not available yet.
    $path = $this->siteDirectory . '/profiles/standard';
    mkdir($path, 0777, TRUE);
    file_put_contents("$path/standard.info.yml", Yaml::encode($this->info));

=======
  protected function setUp() {
=======
  /**
   * {@inheritdoc}
   */
  protected function prepareEnvironment() {
    parent::prepareEnvironment();
>>>>>>> updating open social:web/core/tests/Drupal/FunctionalTests/Installer/SingleVisibleProfileTest.php
    $profiles = ['standard', 'demo_umami'];
    foreach ($profiles as $profile) {
      $info = [
        'type' => 'profile',
        'core' => \Drupal::CORE_COMPATIBILITY,
        'name' => 'Override ' . $profile,
        'hidden' => TRUE,
      ];
      // File API functions are not available yet.
      $path = $this->siteDirectory . '/profiles/' . $profile;
      mkdir($path, 0777, TRUE);
      file_put_contents("$path/$profile.info.yml", Yaml::encode($info));
    }
<<<<<<< HEAD:web/core/modules/system/src/Tests/Installer/SingleVisibleProfileTest.php
>>>>>>> revert Open Social update
    parent::setUp();
=======
>>>>>>> updating open social:web/core/tests/Drupal/FunctionalTests/Installer/SingleVisibleProfileTest.php
  }

  /**
   * {@inheritdoc}
   */
  protected function setUpProfile() {
    // This step is skipped, because there is only one visible profile.
  }

  /**
   * Confirms that the installation succeeded.
   */
  public function testInstalled() {
    $this->assertUrl('user/1');
    $this->assertResponse(200);
    // Confirm that we are logged-in after installation.
    $this->assertText($this->rootUser->getUsername());
    // Confirm that the minimal profile was installed.
    $this->assertEqual(drupal_get_profile(), 'minimal');
  }

}
