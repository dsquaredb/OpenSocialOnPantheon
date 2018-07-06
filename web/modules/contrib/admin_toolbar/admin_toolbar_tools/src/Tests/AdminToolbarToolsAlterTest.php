<?php

namespace Drupal\admin_toolbar_tools\Tests;

use Drupal\simpletest\WebTestBase;

<<<<<<< HEAD

=======
>>>>>>> revert Open Social update
/**
 * Tests for the existence of Admin Toolbar tools new links.
 *
 * @group admin_toolbar
 */
class AdminToolbarToolsAlterTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['toolbar', 'admin_toolbar', 'admin_toolbar_tools'];

  /**
   * A test user with permission to access the administrative toolbar.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
<<<<<<< HEAD

=======
>>>>>>> revert Open Social update
    // Create and log in an administrative user.
    $this->adminUser = $this->drupalCreateUser([
      'access toolbar',
      'access administration pages',
<<<<<<< HEAD
=======
      'administer site configuration',
>>>>>>> revert Open Social update
    ]);
    $this->drupalLogin($this->adminUser);
  }

  /**
<<<<<<< HEAD
   * Tests for a the hover of sub menus.
   */
  function testAdminToolbarTools() {
    // Assert that special menu items are present in the HTML.
    $this->assertRaw('class="toolbar-icon toolbar-icon-admin-toolbar-tools-flush"');
  }
=======
   * Tests for the hover of sub menus.
   */
  public function testAdminToolbarTools() {
    // Assert that special menu items are present in the HTML.
    $this->assertRaw('class="toolbar-icon toolbar-icon-admin-toolbar-tools-flush"');
  }

>>>>>>> revert Open Social update
}
