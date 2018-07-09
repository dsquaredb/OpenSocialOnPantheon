<?php

namespace Drupal\Tests\menu_ui\Functional;

use Drupal\block\Entity\Block;
use Drupal\Component\Utility\Unicode;
use Drupal\Core\EventSubscriber\MainContentViewSubscriber;
use Drupal\Core\Menu\MenuLinkInterface;
use Drupal\Core\Url;
use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\system\Entity\Menu;
use Drupal\node\Entity\Node;
<<<<<<< HEAD
=======
use Drupal\node\NodeInterface;
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
>>>>>>> revert Open Social update
=======
use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\menu_ui\Traits\MenuUiTrait;
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php

/**
 * Add a custom menu, add menu links to the custom menu and Tools menu, check
 * their data, and delete them using the UI.
 *
 * @group menu_ui
 */
class MenuUiTest extends BrowserTestBase {

  use MenuUiTrait;

  /**
   * Modules to enable.
   *
   * @var array
   */
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
<<<<<<< HEAD
  public static $modules = array('node', 'block', 'contextual', 'help', 'path', 'test_page_test');
=======
  public static $modules = ['node', 'block', 'contextual', 'help', 'path', 'test_page_test'];
>>>>>>> revert Open Social update
=======
  protected static $modules = [
    'block',
    'contextual',
    'help',
    'menu_link_content',
    'menu_ui',
    'node',
    'path',
    'test_page_test',
  ];
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php

  /**
   * A user with administration rights.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * An authenticated user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $authenticatedUser;

  /**
   * Array of placed menu blocks keyed by block ID.
   *
   * @var array
   */
  protected $blockPlacements;

  /**
   * A test menu.
   *
   * @var \Drupal\system\Entity\Menu
   */
  protected $menu;

  /**
   * An array of test menu links.
   *
   * @var \Drupal\menu_link_content\MenuLinkContentInterface[]
   */
  protected $items;

  protected function setUp() {
    parent::setUp();

    $this->drupalPlaceBlock('page_title_block');

<<<<<<< HEAD
    $this->drupalCreateContentType(array('type' => 'article', 'name' => 'Article'));

    // Create users.
    $this->adminUser = $this->drupalCreateUser(array('access administration pages', 'administer blocks', 'administer menu', 'create article content'));
    $this->authenticatedUser = $this->drupalCreateUser(array());
=======
    $this->drupalCreateContentType(['type' => 'article', 'name' => 'Article']);

    // Create users.
    $this->adminUser = $this->drupalCreateUser(['access administration pages', 'administer blocks', 'administer menu', 'create article content']);
    $this->authenticatedUser = $this->drupalCreateUser([]);
>>>>>>> revert Open Social update
  }

  /**
   * Tests menu functionality using the admin and user interfaces.
   */
<<<<<<< HEAD
  function testMenu() {
    // Log in the user.
    $this->drupalLogin($this->adminUser);
    $this->items = array();
=======
  public function testMenu() {
    // Log in the user.
    $this->drupalLogin($this->adminUser);
    $this->items = [];
>>>>>>> revert Open Social update

    $this->menu = $this->addCustomMenu();
    $this->doMenuTests();
    $this->doTestMenuBlock();
    $this->addInvalidMenuLink();
    $this->addCustomMenuCRUD();

    // Verify that the menu links rebuild is idempotent and leaves the same
    // number of links in the table.
    /** @var \Drupal\Core\Menu\MenuLinkManagerInterface $menu_link_manager */
    $menu_link_manager = \Drupal::service('plugin.manager.menu.link');
    $before_count = $menu_link_manager->countMenuLinks(NULL);
    $menu_link_manager->rebuild();
    $after_count = $menu_link_manager->countMenuLinks(NULL);
    $this->assertIdentical($before_count, $after_count, 'MenuLinkManager::rebuild() does not add more links');
    // Do standard user tests.
    // Log in the user.
    $this->drupalLogin($this->authenticatedUser);
    $this->verifyAccess(403);

    foreach ($this->items as $item) {
      // Menu link URIs are stored as 'internal:/node/$nid'.
      $node = Node::load(str_replace('internal:/node/', '', $item->link->uri));
      $this->verifyMenuLink($item, $node);
    }

    // Log in the administrator.
    $this->drupalLogin($this->adminUser);

    // Verify delete link exists and reset link does not exist.
    $this->drupalGet('admin/structure/menu/manage/' . $this->menu->id());
    $this->assertLinkByHref(Url::fromRoute('entity.menu_link_content.delete_form', ['menu_link_content' => $this->items[0]->id()])->toString());
    $this->assertNoLinkByHref(Url::fromRoute('menu_ui.link_reset', ['menu_link_plugin' => $this->items[0]->getPluginId()])->toString());
    // Check delete and reset access.
    $this->drupalGet('admin/structure/menu/item/' . $this->items[0]->id() . '/delete');
    $this->assertResponse(200);
    $this->drupalGet('admin/structure/menu/link/' . $this->items[0]->getPluginId() . '/reset');
    $this->assertResponse(403);

    // Delete menu links.
    foreach ($this->items as $item) {
      $this->deleteMenuLink($item);
    }

    // Delete custom menu.
    $this->deleteCustomMenu();

    // Modify and reset a standard menu link.
    $instance = $this->getStandardMenuLink();
    $old_weight = $instance->getWeight();
    // Edit the static menu link.
<<<<<<< HEAD
    $edit = array();
=======
    $edit = [];
>>>>>>> revert Open Social update
    $edit['weight'] = 10;
    $id = $instance->getPluginId();
    $this->drupalPostForm("admin/structure/menu/link/$id/edit", $edit, t('Save'));
    $this->assertResponse(200);
    $this->assertText('The menu link has been saved.');
    $menu_link_manager->resetDefinitions();

    $instance = $menu_link_manager->createInstance($instance->getPluginId());
    $this->assertEqual($edit['weight'], $instance->getWeight(), 'Saving an existing link updates the weight.');
    $this->resetMenuLink($instance, $old_weight);
  }

  /**
   * Adds a custom menu using CRUD functions.
   */
<<<<<<< HEAD
  function addCustomMenuCRUD() {
=======
  public function addCustomMenuCRUD() {
>>>>>>> revert Open Social update
    // Add a new custom menu.
    $menu_name = substr(hash('sha256', $this->randomMachineName(16)), 0, MENU_MAX_MENU_NAME_LENGTH_UI);
    $label = $this->randomMachineName(16);

<<<<<<< HEAD
    $menu = Menu::create(array(
      'id' => $menu_name,
      'label' => $label,
      'description' => 'Description text',
    ));
=======
    $menu = Menu::create([
      'id' => $menu_name,
      'label' => $label,
      'description' => 'Description text',
    ]);
>>>>>>> revert Open Social update
    $menu->save();

    // Assert the new menu.
    $this->drupalGet('admin/structure/menu/manage/' . $menu_name);
    $this->assertRaw($label, 'Custom menu was added.');

    // Edit the menu.
    $new_label = $this->randomMachineName(16);
    $menu->set('label', $new_label);
    $menu->save();
    $this->drupalGet('admin/structure/menu/manage/' . $menu_name);
    $this->assertRaw($new_label, 'Custom menu was edited.');
  }

  /**
   * Creates a custom menu.
   *
   * @return \Drupal\system\Entity\Menu
   *   The custom menu that has been created.
   */
<<<<<<< HEAD
  function addCustomMenu() {
=======
  public function addCustomMenu() {
>>>>>>> revert Open Social update
    // Try adding a menu using a menu_name that is too long.
    $this->drupalGet('admin/structure/menu/add');
    $menu_name = substr(hash('sha256', $this->randomMachineName(16)), 0, MENU_MAX_MENU_NAME_LENGTH_UI + 1);
    $label = $this->randomMachineName(16);
<<<<<<< HEAD
    $edit = array(
      'id' => $menu_name,
      'description' => '',
      'label' => $label,
    );
=======
    $edit = [
      'id' => $menu_name,
      'description' => '',
      'label' => $label,
    ];
>>>>>>> revert Open Social update
    $this->drupalPostForm('admin/structure/menu/add', $edit, t('Save'));

    // Verify that using a menu_name that is too long results in a validation
    // message.
<<<<<<< HEAD
    $this->assertRaw(t('@name cannot be longer than %max characters but is currently %length characters long.', array(
      '@name' => t('Menu name'),
      '%max' => MENU_MAX_MENU_NAME_LENGTH_UI,
      '%length' => Unicode::strlen($menu_name),
    )));
=======
    $this->assertRaw(t('@name cannot be longer than %max characters but is currently %length characters long.', [
      '@name' => t('Menu name'),
      '%max' => MENU_MAX_MENU_NAME_LENGTH_UI,
      '%length' => Unicode::strlen($menu_name),
    ]));
>>>>>>> revert Open Social update

    // Change the menu_name so it no longer exceeds the maximum length.
    $menu_name = substr(hash('sha256', $this->randomMachineName(16)), 0, MENU_MAX_MENU_NAME_LENGTH_UI);
    $edit['id'] = $menu_name;
    $this->drupalPostForm('admin/structure/menu/add', $edit, t('Save'));

    // Verify that no validation error is given for menu_name length.
<<<<<<< HEAD
    $this->assertNoRaw(t('@name cannot be longer than %max characters but is currently %length characters long.', array(
      '@name' => t('Menu name'),
      '%max' => MENU_MAX_MENU_NAME_LENGTH_UI,
      '%length' => Unicode::strlen($menu_name),
    )));
    // Verify that the confirmation message is displayed.
    $this->assertRaw(t('Menu %label has been added.', array('%label' => $label)));
=======
    $this->assertNoRaw(t('@name cannot be longer than %max characters but is currently %length characters long.', [
      '@name' => t('Menu name'),
      '%max' => MENU_MAX_MENU_NAME_LENGTH_UI,
      '%length' => Unicode::strlen($menu_name),
    ]));
    // Verify that the confirmation message is displayed.
    $this->assertRaw(t('Menu %label has been added.', ['%label' => $label]));
>>>>>>> revert Open Social update
    $this->drupalGet('admin/structure/menu');
    $this->assertText($label, 'Menu created');

    // Confirm that the custom menu block is available.
    $this->drupalGet('admin/structure/block/list/' . $this->config('system.theme')->get('default'));
    $this->clickLink('Place block');
    $this->assertText($label);

    // Enable the block.
    $block = $this->drupalPlaceBlock('system_menu_block:' . $menu_name);
    $this->blockPlacements[$menu_name] = $block->id();
    return Menu::load($menu_name);
  }

  /**
   * Deletes the locally stored custom menu.
   *
   * This deletes the custom menu that is stored in $this->menu and performs
   * tests on the menu delete user interface.
   */
<<<<<<< HEAD
  function deleteCustomMenu() {
=======
  public function deleteCustomMenu() {
>>>>>>> revert Open Social update
    $menu_name = $this->menu->id();
    $label = $this->menu->label();

    // Delete custom menu.
<<<<<<< HEAD
    $this->drupalPostForm("admin/structure/menu/manage/$menu_name/delete", array(), t('Delete'));
    $this->assertResponse(200);
    $this->assertRaw(t('The menu %title has been deleted.', array('%title' => $label)), 'Custom menu was deleted');
    $this->assertNull(Menu::load($menu_name), 'Custom menu was deleted');
    // Test if all menu links associated with the menu were removed from
    // database.
    $result = entity_load_multiple_by_properties('menu_link_content', array('menu_name' => $menu_name));
=======
    $this->drupalPostForm("admin/structure/menu/manage/$menu_name/delete", [], t('Delete'));
    $this->assertResponse(200);
    $this->assertRaw(t('The menu %title has been deleted.', ['%title' => $label]), 'Custom menu was deleted');
    $this->assertNull(Menu::load($menu_name), 'Custom menu was deleted');
    // Test if all menu links associated with the menu were removed from
    // database.
    $result = entity_load_multiple_by_properties('menu_link_content', ['menu_name' => $menu_name]);
>>>>>>> revert Open Social update
    $this->assertFalse($result, 'All menu links associated with the custom menu were deleted.');

    // Make sure there's no delete button on system menus.
    $this->drupalGet('admin/structure/menu/manage/main');
    $this->assertNoRaw('edit-delete', 'The delete button was not found');

    // Try to delete the main menu.
    $this->drupalGet('admin/structure/menu/manage/main/delete');
    $this->assertText(t('You are not authorized to access this page.'));
  }

  /**
   * Tests menu functionality.
   */
<<<<<<< HEAD
  function doMenuTests() {
=======
  public function doMenuTests() {
>>>>>>> revert Open Social update
    $menu_name = $this->menu->id();

    // Test the 'Add link' local action.
    $this->drupalGet(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    $this->clickLink(t('Add link'));
    $link_title = $this->randomString();
<<<<<<< HEAD
    $this->drupalPostForm(NULL, array('link[0][uri]' => '/', 'title[0][value]' => $link_title), t('Save'));
=======
    $this->drupalPostForm(NULL, ['link[0][uri]' => '/', 'title[0][value]' => $link_title], t('Save'));
>>>>>>> revert Open Social update
    $this->assertUrl(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));
    // Test the 'Edit' operation.
    $this->clickLink(t('Edit'));
    $this->assertFieldByName('title[0][value]', $link_title);
    $link_title = $this->randomString();
<<<<<<< HEAD
    $this->drupalPostForm(NULL, array('title[0][value]' => $link_title), t('Save'));
    $this->assertUrl(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));
    // Test the 'Delete' operation.
    $this->clickLink(t('Delete'));
    $this->assertRaw(t('Are you sure you want to delete the custom menu link %item?', array('%item' => $link_title)));
    $this->drupalPostForm(NULL, array(), t('Delete'));
    $this->assertUrl(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    // Add nodes to use as links for menu links.
    $node1 = $this->drupalCreateNode(array('type' => 'article'));
    $node2 = $this->drupalCreateNode(array('type' => 'article'));
    $node3 = $this->drupalCreateNode(array('type' => 'article'));
    $node4 = $this->drupalCreateNode(array('type' => 'article'));
    // Create a node with an alias.
    $node5 = $this->drupalCreateNode(array(
      'type' => 'article',
      'path' => array(
        'alias' => '/node5',
      ),
    ));
=======
    $this->drupalPostForm(NULL, ['title[0][value]' => $link_title], t('Save'));
    $this->assertUrl(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));
    // Test the 'Delete' operation.
    $this->clickLink(t('Delete'));
    $this->assertRaw(t('Are you sure you want to delete the custom menu link %item?', ['%item' => $link_title]));
    $this->drupalPostForm(NULL, [], t('Delete'));
    $this->assertUrl(Url::fromRoute('entity.menu.edit_form', ['menu' => $menu_name]));

    // Add nodes to use as links for menu links.
    $node1 = $this->drupalCreateNode(['type' => 'article']);
    $node2 = $this->drupalCreateNode(['type' => 'article']);
    $node3 = $this->drupalCreateNode(['type' => 'article']);
    $node4 = $this->drupalCreateNode(['type' => 'article']);
    // Create a node with an alias.
    $node5 = $this->drupalCreateNode([
      'type' => 'article',
      'path' => [
        'alias' => '/node5',
      ],
    ]);
>>>>>>> revert Open Social update

    // Verify add link button.
    $this->drupalGet('admin/structure/menu');
    $this->assertLinkByHref('admin/structure/menu/manage/' . $menu_name . '/add', 0, "The add menu link button URL is correct");

    // Verify form defaults.
    $this->doMenuLinkFormDefaultsTest();

    // Add menu links.
    $item1 = $this->addMenuLink('', '/node/' . $node1->id(), $menu_name, TRUE);
    $item2 = $this->addMenuLink($item1->getPluginId(), '/node/' . $node2->id(), $menu_name, FALSE);
    $item3 = $this->addMenuLink($item2->getPluginId(), '/node/' . $node3->id(), $menu_name);

    // Hierarchy
    // <$menu_name>
    // - item1
    // -- item2
    // --- item3

<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
<<<<<<< HEAD
    $this->assertMenuLink($item1->getPluginId(), array(
      'children' => array($item2->getPluginId(), $item3->getPluginId()),
      'parents' => array($item1->getPluginId()),
      // We assert the language code here to make sure that the language
      // selection element degrades gracefully without the Language module.
      'langcode' => 'en',
    ));
    $this->assertMenuLink($item2->getPluginId(), array(
      'children' => array($item3->getPluginId()),
      'parents' => array($item2->getPluginId(), $item1->getPluginId()),
      // See above.
      'langcode' => 'en',
    ));
    $this->assertMenuLink($item3->getPluginId(), array(
      'children' => array(),
      'parents' => array($item3->getPluginId(), $item2->getPluginId(), $item1->getPluginId()),
      // See above.
      'langcode' => 'en',
    ));
=======
    $this->assertMenuLink($item1->getPluginId(), [
=======
    $this->assertMenuLink([
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php
      'children' => [$item2->getPluginId(), $item3->getPluginId()],
      'parents' => [$item1->getPluginId()],
      // We assert the language code here to make sure that the language
      // selection element degrades gracefully without the Language module.
      'langcode' => 'en',
    ], $item1->getPluginId());
    $this->assertMenuLink([
      'children' => [$item3->getPluginId()],
      'parents' => [$item2->getPluginId(), $item1->getPluginId()],
      // See above.
      'langcode' => 'en',
    ], $item2->getPluginId());
    $this->assertMenuLink([
      'children' => [],
      'parents' => [$item3->getPluginId(), $item2->getPluginId(), $item1->getPluginId()],
      // See above.
      'langcode' => 'en',
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
    ]);
>>>>>>> revert Open Social update
=======
    ], $item3->getPluginId());
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php

    // Verify menu links.
    $this->verifyMenuLink($item1, $node1);
    $this->verifyMenuLink($item2, $node2, $item1, $node1);
    $this->verifyMenuLink($item3, $node3, $item2, $node2);

    // Add more menu links.
    $item4 = $this->addMenuLink('', '/node/' . $node4->id(), $menu_name);
    $item5 = $this->addMenuLink($item4->getPluginId(), '/node/' . $node5->id(), $menu_name);
    // Create a menu link pointing to an alias.
    $item6 = $this->addMenuLink($item4->getPluginId(), '/node5', $menu_name, TRUE, '0');

    // Hierarchy
    // <$menu_name>
    // - item1
    // -- item2
    // --- item3
    // - item4
    // -- item5
    // -- item6

<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
<<<<<<< HEAD
    $this->assertMenuLink($item4->getPluginId(), array(
      'children' => array($item5->getPluginId(), $item6->getPluginId()),
      'parents' => array($item4->getPluginId()),
      // See above.
      'langcode' => 'en',
    ));
    $this->assertMenuLink($item5->getPluginId(), array(
      'children' => array(),
      'parents' => array($item5->getPluginId(), $item4->getPluginId()),
      'langcode' => 'en',
    ));
    $this->assertMenuLink($item6->getPluginId(), array(
      'children' => array(),
      'parents' => array($item6->getPluginId(), $item4->getPluginId()),
      'route_name' => 'entity.node.canonical',
      'route_parameters' => array('node' => $node5->id()),
      'url' => '',
      // See above.
      'langcode' => 'en',
    ));
=======
    $this->assertMenuLink($item4->getPluginId(), [
=======
    $this->assertMenuLink([
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php
      'children' => [$item5->getPluginId(), $item6->getPluginId()],
      'parents' => [$item4->getPluginId()],
      // See above.
      'langcode' => 'en',
    ], $item4->getPluginId());
    $this->assertMenuLink([
      'children' => [],
      'parents' => [$item5->getPluginId(), $item4->getPluginId()],
      'langcode' => 'en',
    ], $item5->getPluginId());
    $this->assertMenuLink([
      'children' => [],
      'parents' => [$item6->getPluginId(), $item4->getPluginId()],
      'route_name' => 'entity.node.canonical',
      'route_parameters' => ['node' => $node5->id()],
      'url' => '',
      // See above.
      'langcode' => 'en',
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
    ]);
>>>>>>> revert Open Social update
=======
    ], $item6->getPluginId());
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php

    // Modify menu links.
    $this->modifyMenuLink($item1);
    $this->modifyMenuLink($item2);

    // Toggle menu links.
    $this->toggleMenuLink($item1);
    $this->toggleMenuLink($item2);

    // Move link and verify that descendants are updated.
    $this->moveMenuLink($item2, $item5->getPluginId(), $menu_name);
    // Hierarchy
    // <$menu_name>
    // - item1
    // - item4
    // -- item5
    // --- item2
    // ---- item3
    // -- item6

<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
<<<<<<< HEAD
    $this->assertMenuLink($item1->getPluginId(), array(
      'children' => array(),
      'parents' => array($item1->getPluginId()),
      // See above.
      'langcode' => 'en',
    ));
    $this->assertMenuLink($item4->getPluginId(), array(
      'children' => array($item5->getPluginId(), $item6->getPluginId(), $item2->getPluginId(), $item3->getPluginId()),
      'parents' => array($item4->getPluginId()),
      // See above.
      'langcode' => 'en',
    ));

    $this->assertMenuLink($item5->getPluginId(), array(
      'children' => array($item2->getPluginId(), $item3->getPluginId()),
      'parents' => array($item5->getPluginId(), $item4->getPluginId()),
      // See above.
      'langcode' => 'en',
    ));
    $this->assertMenuLink($item2->getPluginId(), array(
      'children' => array($item3->getPluginId()),
      'parents' => array($item2->getPluginId(), $item5->getPluginId(), $item4->getPluginId()),
      // See above.
      'langcode' => 'en',
    ));
    $this->assertMenuLink($item3->getPluginId(), array(
      'children' => array(),
      'parents' => array($item3->getPluginId(), $item2->getPluginId(), $item5->getPluginId(), $item4->getPluginId()),
      // See above.
      'langcode' => 'en',
    ));

    // Add 102 menu links with increasing weights, then make sure the last-added
    // item's weight doesn't get changed because of the old hardcoded delta=50.
    $items = array();
    for ($i = -50; $i <= 51; $i++) {
      $items[$i] = $this->addMenuLink('', '/node/' . $node1->id(), $menu_name, TRUE, strval($i));
    }
    $this->assertMenuLink($items[51]->getPluginId(), array('weight' => '51'));

    // Disable a link and then re-enable the link via the overview form.
    $this->disableMenuLink($item1);
    $edit = array();
=======
    $this->assertMenuLink($item1->getPluginId(), [
=======
    $this->assertMenuLink([
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php
      'children' => [],
      'parents' => [$item1->getPluginId()],
      // See above.
      'langcode' => 'en',
    ], $item1->getPluginId());
    $this->assertMenuLink([
      'children' => [$item5->getPluginId(), $item6->getPluginId(), $item2->getPluginId(), $item3->getPluginId()],
      'parents' => [$item4->getPluginId()],
      // See above.
      'langcode' => 'en',
    ], $item4->getPluginId());

    $this->assertMenuLink([
      'children' => [$item2->getPluginId(), $item3->getPluginId()],
      'parents' => [$item5->getPluginId(), $item4->getPluginId()],
      // See above.
      'langcode' => 'en',
    ], $item5->getPluginId());
    $this->assertMenuLink([
      'children' => [$item3->getPluginId()],
      'parents' => [$item2->getPluginId(), $item5->getPluginId(), $item4->getPluginId()],
      // See above.
      'langcode' => 'en',
    ], $item2->getPluginId());
    $this->assertMenuLink([
      'children' => [],
      'parents' => [$item3->getPluginId(), $item2->getPluginId(), $item5->getPluginId(), $item4->getPluginId()],
      // See above.
      'langcode' => 'en',
    ], $item3->getPluginId());

    // Add 102 menu links with increasing weights, then make sure the last-added
    // item's weight doesn't get changed because of the old hardcoded delta=50.
    $items = [];
    for ($i = -50; $i <= 51; $i++) {
      $items[$i] = $this->addMenuLink('', '/node/' . $node1->id(), $menu_name, TRUE, strval($i));
    }
    $this->assertMenuLink(['weight' => '51'], $items[51]->getPluginId());

    // Disable a link and then re-enable the link via the overview form.
    $this->disableMenuLink($item1);
    $edit = [];
>>>>>>> revert Open Social update
    $edit['links[menu_plugin_id:' . $item1->getPluginId() . '][enabled]'] = TRUE;
    $this->drupalPostForm('admin/structure/menu/manage/' . $item1->getMenuName(), $edit, t('Save'));

    // Mark item2, item4 and item5 as expanded.
    // This is done in order to show them on the frontpage.
    $item2->expanded->value = 1;
    $item2->save();
    $item4->expanded->value = 1;
    $item4->save();
    $item5->expanded->value = 1;
    $item5->save();

    // Verify in the database.
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
<<<<<<< HEAD
    $this->assertMenuLink($item1->getPluginId(), array('enabled' => 1));

    // Add an external link.
    $item7 = $this->addMenuLink('', 'https://www.drupal.org', $menu_name);
    $this->assertMenuLink($item7->getPluginId(), array('url' => 'https://www.drupal.org'));

    // Add <front> menu item.
    $item8 = $this->addMenuLink('', '/', $menu_name);
    $this->assertMenuLink($item8->getPluginId(), array('route_name' => '<front>'));
=======
    $this->assertMenuLink($item1->getPluginId(), ['enabled' => 1]);
=======
    $this->assertMenuLink(['enabled' => 1], $item1->getPluginId());
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php

    // Add an external link.
    $item7 = $this->addMenuLink('', 'https://www.drupal.org', $menu_name);
    $this->assertMenuLink(['url' => 'https://www.drupal.org'], $item7->getPluginId());

    // Add <front> menu item.
    $item8 = $this->addMenuLink('', '/', $menu_name);
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
    $this->assertMenuLink($item8->getPluginId(), ['route_name' => '<front>']);
>>>>>>> revert Open Social update
=======
    $this->assertMenuLink(['route_name' => '<front>'], $item8->getPluginId());
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php
    $this->drupalGet('');
    $this->assertResponse(200);
    // Make sure we get routed correctly.
    $this->clickLink($item8->getTitle());
    $this->assertResponse(200);

    // Check invalid menu link parents.
    $this->checkInvalidParentMenuLinks();

    // Save menu links for later tests.
    $this->items[] = $item1;
    $this->items[] = $item2;
  }

  /**
   * Ensures that the proper default values are set when adding a menu link
   */
  protected function doMenuLinkFormDefaultsTest() {
    $this->drupalGet("admin/structure/menu/manage/tools/add");
    $this->assertResponse(200);

    $this->assertFieldByName('title[0][value]', '');
    $this->assertFieldByName('link[0][uri]', '');

    $this->assertNoFieldChecked('edit-expanded-value');
    $this->assertFieldChecked('edit-enabled-value');

    $this->assertFieldByName('description[0][value]', '');
    $this->assertFieldByName('weight[0][value]', 0);
  }

  /**
   * Adds and removes a menu link with a query string and fragment.
   */
<<<<<<< HEAD
  function testMenuQueryAndFragment() {
=======
  public function testMenuQueryAndFragment() {
>>>>>>> revert Open Social update
    $this->drupalLogin($this->adminUser);

    // Make a path with query and fragment on.
    $path = '/test-page?arg1=value1&arg2=value2';
    $item = $this->addMenuLink('', $path);

    $this->drupalGet('admin/structure/menu/item/' . $item->id() . '/edit');
    $this->assertFieldByName('link[0][uri]', $path, 'Path is found with both query and fragment.');

    // Now change the path to something without query and fragment.
    $path = '/test-page';
<<<<<<< HEAD
    $this->drupalPostForm('admin/structure/menu/item/' . $item->id() . '/edit', array('link[0][uri]' => $path), t('Save'));
=======
    $this->drupalPostForm('admin/structure/menu/item/' . $item->id() . '/edit', ['link[0][uri]' => $path], t('Save'));
>>>>>>> revert Open Social update
    $this->drupalGet('admin/structure/menu/item/' . $item->id() . '/edit');
    $this->assertFieldByName('link[0][uri]', $path, 'Path no longer has query or fragment.');

    // Use <front>#fragment and ensure that saving it does not lose its content.
    $path = '<front>?arg1=value#fragment';
    $item = $this->addMenuLink('', $path);

    $this->drupalGet('admin/structure/menu/item/' . $item->id() . '/edit');
    $this->assertFieldByName('link[0][uri]', $path, 'Path is found with both query and fragment.');

<<<<<<< HEAD
    $this->drupalPostForm('admin/structure/menu/item/' . $item->id() . '/edit', array(), t('Save'));
=======
    $this->drupalPostForm('admin/structure/menu/item/' . $item->id() . '/edit', [], t('Save'));
>>>>>>> revert Open Social update

    $this->drupalGet('admin/structure/menu/item/' . $item->id() . '/edit');
    $this->assertFieldByName('link[0][uri]', $path, 'Path is found with both query and fragment.');
  }

  /**
   * Tests renaming the built-in menu.
   */
<<<<<<< HEAD
  function testSystemMenuRename() {
    $this->drupalLogin($this->adminUser);
    $edit = array(
      'label' => $this->randomMachineName(16),
    );
=======
  public function testSystemMenuRename() {
    $this->drupalLogin($this->adminUser);
    $edit = [
      'label' => $this->randomMachineName(16),
    ];
>>>>>>> revert Open Social update
    $this->drupalPostForm('admin/structure/menu/manage/main', $edit, t('Save'));

    // Make sure menu shows up with new name in block addition.
    $default_theme = $this->config('system.theme')->get('default');
    $this->drupalget('admin/structure/block/list/' . $default_theme);
    $this->clickLink('Place block');
    $this->assertText($edit['label']);
  }

  /**
   * Tests that menu items pointing to unpublished nodes are editable.
   */
<<<<<<< HEAD
  function testUnpublishedNodeMenuItem() {
    $this->drupalLogin($this->drupalCreateUser(array('access administration pages', 'administer blocks', 'administer menu', 'create article content', 'bypass node access')));
    // Create an unpublished node.
    $node = $this->drupalCreateNode(array(
      'type' => 'article',
      'status' => NODE_NOT_PUBLISHED,
    ));
=======
  public function testUnpublishedNodeMenuItem() {
    $this->drupalLogin($this->drupalCreateUser(['access administration pages', 'administer blocks', 'administer menu', 'create article content', 'bypass node access']));
    // Create an unpublished node.
    $node = $this->drupalCreateNode([
      'type' => 'article',
      'status' => NodeInterface::NOT_PUBLISHED,
    ]);
>>>>>>> revert Open Social update

    $item = $this->addMenuLink('', '/node/' . $node->id());
    $this->modifyMenuLink($item);

    // Test that a user with 'administer menu' but without 'bypass node access'
    // cannot see the menu item.
    $this->drupalLogout();
    $this->drupalLogin($this->adminUser);
    $this->drupalGet('admin/structure/menu/manage/' . $item->getMenuName());
    $this->assertNoText($item->getTitle(), "Menu link pointing to unpublished node is only visible to users with 'bypass node access' permission");
    // The cache contexts associated with the (in)accessible menu links are
    // bubbled. See DefaultMenuLinkTreeManipulators::menuLinkCheckAccess().
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
    $this->assertCacheContext('user.permissions');
  }

  /**
   * Tests the contextual links on a menu block.
   */
  public function testBlockContextualLinks() {
<<<<<<< HEAD
    $this->drupalLogin($this->drupalCreateUser(array('administer menu', 'access contextual links', 'administer blocks')));
    $custom_menu = $this->addCustomMenu();
    $this->addMenuLink('', '/', $custom_menu->id());
    $block = $this->drupalPlaceBlock('system_menu_block:' . $custom_menu->id(), array('label' => 'Custom menu', 'provider' => 'system'));
=======
    $this->drupalLogin($this->drupalCreateUser(['administer menu', 'access contextual links', 'administer blocks']));
    $custom_menu = $this->addCustomMenu();
    $this->addMenuLink('', '/', $custom_menu->id());
    $block = $this->drupalPlaceBlock('system_menu_block:' . $custom_menu->id(), ['label' => 'Custom menu', 'provider' => 'system']);
>>>>>>> revert Open Social update
    $this->drupalGet('test-page');

    $id = 'block:block=' . $block->id() . ':langcode=en|menu:menu=' . $custom_menu->id() . ':langcode=en';
    // @see \Drupal\contextual\Tests\ContextualDynamicContextTest:assertContextualLinkPlaceHolder()
<<<<<<< HEAD
    $this->assertRaw('<div data-contextual-id="' . $id . '"></div>', format_string('Contextual link placeholder with id @id exists.', array('@id' => $id)));

    // Get server-rendered contextual links.
    // @see \Drupal\contextual\Tests\ContextualDynamicContextTest:renderContextualLinks()
    $post = array('ids[0]' => $id);
    $response = $this->drupalPost('contextual/render', 'application/json', $post, array('query' => array('destination' => 'test-page')));
=======
    $this->assertRaw('<div data-contextual-id="' . $id . '"></div>', format_string('Contextual link placeholder with id @id exists.', ['@id' => $id]));

    // Get server-rendered contextual links.
    // @see \Drupal\contextual\Tests\ContextualDynamicContextTest:renderContextualLinks()
    $post = ['ids[0]' => $id];
    $response = $this->drupalPost('contextual/render', 'application/json', $post, ['query' => ['destination' => 'test-page']]);
>>>>>>> revert Open Social update
    $this->assertResponse(200);
    $json = Json::decode($response);
    $this->assertIdentical($json[$id], '<ul class="contextual-links"><li class="block-configure"><a href="' . base_path() . 'admin/structure/block/manage/' . $block->id() . '">Configure block</a></li><li class="entitymenuedit-form"><a href="' . base_path() . 'admin/structure/menu/manage/' . $custom_menu->id() . '">Edit menu</a></li></ul>');
=======
    $this->assertSession()->responseHeaderContains('X-Drupal-Cache-Contexts', 'user.permissions');
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php
  }

  /**
   * Adds a menu link using the UI.
   *
   * @param string $parent
   *   Optional parent menu link id.
   * @param string $path
   *   The path to enter on the form. Defaults to the front page.
   * @param string $menu_name
   *   Menu name. Defaults to 'tools'.
   * @param bool $expanded
   *   Whether or not this menu link is expanded. Setting this to TRUE should
   *   test whether it works when we do the authenticatedUser tests. Defaults
   *   to FALSE.
   * @param string $weight
   *   Menu weight. Defaults to 0.
   *
   * @return \Drupal\menu_link_content\Entity\MenuLinkContent
   *   A menu link entity.
   */
<<<<<<< HEAD
  function addMenuLink($parent = '', $path = '/', $menu_name = 'tools', $expanded = FALSE, $weight = '0') {
=======
  public function addMenuLink($parent = '', $path = '/', $menu_name = 'tools', $expanded = FALSE, $weight = '0') {
>>>>>>> revert Open Social update
    // View add menu link page.
    $this->drupalGet("admin/structure/menu/manage/$menu_name/add");
    $this->assertResponse(200);

    $title = '!link_' . $this->randomMachineName(16);
<<<<<<< HEAD
    $edit = array(
=======
    $edit = [
>>>>>>> revert Open Social update
      'link[0][uri]' => $path,
      'title[0][value]' => $title,
      'description[0][value]' => '',
      'enabled[value]' => 1,
      'expanded[value]' => $expanded,
      'menu_parent' => $menu_name . ':' . $parent,
      'weight[0][value]' => $weight,
<<<<<<< HEAD
    );
=======
    ];
>>>>>>> revert Open Social update

    // Add menu link.
    $this->drupalPostForm(NULL, $edit, t('Save'));
    $this->assertResponse(200);
    $this->assertText('The menu link has been saved.');

<<<<<<< HEAD
    $menu_links = entity_load_multiple_by_properties('menu_link_content', array('title' => $title));

    $menu_link = reset($menu_links);
    $this->assertTrue($menu_link, 'Menu link was found in database.');
    $this->assertMenuLink($menu_link->getPluginId(), array('menu_name' => $menu_name, 'children' => array(), 'parent' => $parent));
=======
    $menu_links = entity_load_multiple_by_properties('menu_link_content', ['title' => $title]);

    $menu_link = reset($menu_links);
    $this->assertTrue($menu_link, 'Menu link was found in database.');
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
    $this->assertMenuLink($menu_link->getPluginId(), ['menu_name' => $menu_name, 'children' => [], 'parent' => $parent]);
>>>>>>> revert Open Social update
=======
    $this->assertMenuLink(['menu_name' => $menu_name, 'children' => [], 'parent' => $parent], $menu_link->getPluginId());
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php

    return $menu_link;
  }

  /**
   * Attempts to add menu link with invalid path or no access permission.
   */
<<<<<<< HEAD
  function addInvalidMenuLink() {
    foreach (array('access' => '/admin/people/permissions') as $type => $link_path) {
      $edit = array(
        'link[0][uri]' => $link_path,
        'title[0][value]' => 'title',
      );
      $this->drupalPostForm("admin/structure/menu/manage/{$this->menu->id()}/add", $edit, t('Save'));
      $this->assertRaw(t("The path '@link_path' is inaccessible.", array('@link_path' => $link_path)), 'Menu link was not created');
=======
  public function addInvalidMenuLink() {
    foreach (['access' => '/admin/people/permissions'] as $type => $link_path) {
      $edit = [
        'link[0][uri]' => $link_path,
        'title[0][value]' => 'title',
      ];
      $this->drupalPostForm("admin/structure/menu/manage/{$this->menu->id()}/add", $edit, t('Save'));
      $this->assertRaw(t("The path '@link_path' is inaccessible.", ['@link_path' => $link_path]), 'Menu link was not created');
>>>>>>> revert Open Social update
    }
  }

  /**
   * Tests that parent options are limited by depth when adding menu links.
   */
<<<<<<< HEAD
  function checkInvalidParentMenuLinks() {
    $last_link = NULL;
    $created_links = array();
=======
  public function checkInvalidParentMenuLinks() {
    $last_link = NULL;
    $created_links = [];
>>>>>>> revert Open Social update

    // Get the max depth of the tree.
    $menu_link_tree = \Drupal::service('menu.link_tree');
    $max_depth = $menu_link_tree->maxDepth();

    // Create a maximum number of menu links, each a child of the previous.
    for ($i = 0; $i <= $max_depth - 1; $i++) {
      $parent = $last_link ? 'tools:' . $last_link->getPluginId() : 'tools:';
      $title = 'title' . $i;
<<<<<<< HEAD
      $edit = array(
=======
      $edit = [
>>>>>>> revert Open Social update
        'link[0][uri]' => '/',
        'title[0][value]' => $title,
        'menu_parent' => $parent,
        'description[0][value]' => '',
        'enabled[value]' => 1,
        'expanded[value]' => FALSE,
        'weight[0][value]' => '0',
<<<<<<< HEAD
      );
      $this->drupalPostForm("admin/structure/menu/manage/{$this->menu->id()}/add", $edit, t('Save'));
      $menu_links = entity_load_multiple_by_properties('menu_link_content', array('title' => $title));
=======
      ];
      $this->drupalPostForm("admin/structure/menu/manage/{$this->menu->id()}/add", $edit, t('Save'));
      $menu_links = entity_load_multiple_by_properties('menu_link_content', ['title' => $title]);
>>>>>>> revert Open Social update
      $last_link = reset($menu_links);
      $created_links[]  = 'tools:' . $last_link->getPluginId();
    }

    // The last link cannot be a parent in the new menu link form.
    $this->drupalGet('admin/structure/menu/manage/admin/add');
    $value = 'tools:' . $last_link->getPluginId();
    $this->assertNoOption('edit-menu-parent', $value, 'The invalid option is not there.');

    // All but the last link can be parents in the new menu link form.
    array_pop($created_links);
    foreach ($created_links as $key => $link) {
      $this->assertOption('edit-menu-parent', $link, 'The valid option number ' . ($key + 1) . ' is there.');
    }
  }

  /**
   * Verifies a menu link using the UI.
   *
   * @param \Drupal\menu_link_content\Entity\MenuLinkContent $item
   *   Menu link.
   * @param object $item_node
   *   Menu link content node.
   * @param \Drupal\menu_link_content\Entity\MenuLinkContent $parent
   *   Parent menu link.
   * @param object $parent_node
   *   Parent menu link content node.
   */
<<<<<<< HEAD
  function verifyMenuLink(MenuLinkContent $item, $item_node, MenuLinkContent $parent = NULL, $parent_node = NULL) {
=======
  public function verifyMenuLink(MenuLinkContent $item, $item_node, MenuLinkContent $parent = NULL, $parent_node = NULL) {
>>>>>>> revert Open Social update
    // View home page.
    $this->drupalGet('');
    $this->assertResponse(200);

    // Verify parent menu link.
    if (isset($parent)) {
      // Verify menu link.
      $title = $parent->getTitle();
      $this->assertLink($title, 0, 'Parent menu link was displayed');

      // Verify menu link link.
      $this->clickLink($title);
      $title = $parent_node->label();
<<<<<<< HEAD
      $this->assertTitle(t("@title | Drupal", array('@title' => $title)), 'Parent menu link link target was correct');
=======
      $this->assertTitle(t("@title | Drupal", ['@title' => $title]), 'Parent menu link link target was correct');
>>>>>>> revert Open Social update
    }

    // Verify menu link.
    $title = $item->getTitle();
    $this->assertLink($title, 0, 'Menu link was displayed');

    // Verify menu link link.
    $this->clickLink($title);
    $title = $item_node->label();
<<<<<<< HEAD
    $this->assertTitle(t("@title | Drupal", array('@title' => $title)), 'Menu link link target was correct');
=======
    $this->assertTitle(t("@title | Drupal", ['@title' => $title]), 'Menu link link target was correct');
>>>>>>> revert Open Social update
  }

  /**
   * Changes the parent of a menu link using the UI.
   *
   * @param \Drupal\menu_link_content\MenuLinkContentInterface $item
   *   The menu link item to move.
   * @param int $parent
   *   The id of the new parent.
   * @param string $menu_name
   *   The menu the menu link will be moved to.
   */
<<<<<<< HEAD
  function moveMenuLink(MenuLinkContent $item, $parent, $menu_name) {
    $mlid = $item->id();

    $edit = array(
      'menu_parent' => $menu_name . ':' . $parent,
    );
=======
  public function moveMenuLink(MenuLinkContent $item, $parent, $menu_name) {
    $mlid = $item->id();

    $edit = [
      'menu_parent' => $menu_name . ':' . $parent,
    ];
>>>>>>> revert Open Social update
    $this->drupalPostForm("admin/structure/menu/item/$mlid/edit", $edit, t('Save'));
    $this->assertResponse(200);
  }

  /**
   * Modifies a menu link using the UI.
   *
   * @param \Drupal\menu_link_content\Entity\MenuLinkContent $item
   *   Menu link entity.
   */
<<<<<<< HEAD
  function modifyMenuLink(MenuLinkContent $item) {
=======
  public function modifyMenuLink(MenuLinkContent $item) {
>>>>>>> revert Open Social update
    $item->title->value = $this->randomMachineName(16);

    $mlid = $item->id();
    $title = $item->getTitle();

    // Edit menu link.
<<<<<<< HEAD
    $edit = array();
=======
    $edit = [];
>>>>>>> revert Open Social update
    $edit['title[0][value]'] = $title;
    $this->drupalPostForm("admin/structure/menu/item/$mlid/edit", $edit, t('Save'));
    $this->assertResponse(200);
    $this->assertText('The menu link has been saved.');
    // Verify menu link.
    $this->drupalGet('admin/structure/menu/manage/' . $item->getMenuName());
    $this->assertText($title, 'Menu link was edited');
  }

  /**
   * Resets a standard menu link using the UI.
   *
   * @param \Drupal\Core\Menu\MenuLinkInterface $menu_link
   *   The Menu link.
   * @param int $old_weight
   *   Original title for menu link.
   */
<<<<<<< HEAD
  function resetMenuLink(MenuLinkInterface $menu_link, $old_weight) {
    // Reset menu link.
    $this->drupalPostForm("admin/structure/menu/link/{$menu_link->getPluginId()}/reset", array(), t('Reset'));
=======
  public function resetMenuLink(MenuLinkInterface $menu_link, $old_weight) {
    // Reset menu link.
    $this->drupalPostForm("admin/structure/menu/link/{$menu_link->getPluginId()}/reset", [], t('Reset'));
>>>>>>> revert Open Social update
    $this->assertResponse(200);
    $this->assertRaw(t('The menu link was reset to its default settings.'), 'Menu link was reset');

    // Verify menu link.
    $instance = \Drupal::service('plugin.manager.menu.link')->createInstance($menu_link->getPluginId());
    $this->assertEqual($old_weight, $instance->getWeight(), 'Resets to the old weight.');
  }

  /**
   * Deletes a menu link using the UI.
   *
   * @param \Drupal\menu_link_content\Entity\MenuLinkContent $item
   *   Menu link.
   */
<<<<<<< HEAD
  function deleteMenuLink(MenuLinkContent $item) {
=======
  public function deleteMenuLink(MenuLinkContent $item) {
>>>>>>> revert Open Social update
    $mlid = $item->id();
    $title = $item->getTitle();

    // Delete menu link.
<<<<<<< HEAD
    $this->drupalPostForm("admin/structure/menu/item/$mlid/delete", array(), t('Delete'));
    $this->assertResponse(200);
    $this->assertRaw(t('The menu link %title has been deleted.', array('%title' => $title)), 'Menu link was deleted');
=======
    $this->drupalPostForm("admin/structure/menu/item/$mlid/delete", [], t('Delete'));
    $this->assertResponse(200);
    $this->assertRaw(t('The menu link %title has been deleted.', ['%title' => $title]), 'Menu link was deleted');
>>>>>>> revert Open Social update

    // Verify deletion.
    $this->drupalGet('');
    $this->assertNoText($title, 'Menu link was deleted');
  }

  /**
   * Alternately disables and enables a menu link.
   *
   * @param \Drupal\menu_link_content\Entity\MenuLinkContent $item
   *   Menu link.
   */
<<<<<<< HEAD
  function toggleMenuLink(MenuLinkContent $item) {
=======
  public function toggleMenuLink(MenuLinkContent $item) {
>>>>>>> revert Open Social update
    $this->disableMenuLink($item);

    // Verify menu link is absent.
    $this->drupalGet('');
    $this->assertNoText($item->getTitle(), 'Menu link was not displayed');
    $this->enableMenuLink($item);

    // Verify menu link is displayed.
    $this->drupalGet('');
    $this->assertText($item->getTitle(), 'Menu link was displayed');
  }

  /**
   * Disables a menu link.
   *
   * @param \Drupal\menu_link_content\Entity\MenuLinkContent $item
   *   Menu link.
   */
<<<<<<< HEAD
  function disableMenuLink(MenuLinkContent $item) {
=======
  public function disableMenuLink(MenuLinkContent $item) {
>>>>>>> revert Open Social update
    $mlid = $item->id();
    $edit['enabled[value]'] = FALSE;
    $this->drupalPostForm("admin/structure/menu/item/$mlid/edit", $edit, t('Save'));

    // Unlike most other modules, there is no confirmation message displayed.
    // Verify in the database.
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
<<<<<<< HEAD
    $this->assertMenuLink($item->getPluginId(), array('enabled' => 0));
=======
    $this->assertMenuLink($item->getPluginId(), ['enabled' => 0]);
>>>>>>> revert Open Social update
=======
    $this->assertMenuLink(['enabled' => 0], $item->getPluginId());
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php
  }

  /**
   * Enables a menu link.
   *
   * @param \Drupal\menu_link_content\Entity\MenuLinkContent $item
   *   Menu link.
   */
<<<<<<< HEAD
  function enableMenuLink(MenuLinkContent $item) {
=======
  public function enableMenuLink(MenuLinkContent $item) {
>>>>>>> revert Open Social update
    $mlid = $item->id();
    $edit['enabled[value]'] = TRUE;
    $this->drupalPostForm("admin/structure/menu/item/$mlid/edit", $edit, t('Save'));

    // Verify in the database.
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
<<<<<<< HEAD
    $this->assertMenuLink($item->getPluginId(), array('enabled' => 1));
=======
    $this->assertMenuLink($item->getPluginId(), ['enabled' => 1]);
>>>>>>> revert Open Social update
=======
    $this->assertMenuLink(['enabled' => 1], $item->getPluginId());
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php
  }

  /**
   * Tests if admin users, other than UID1, can access parents AJAX callback.
   */
  public function testMenuParentsJsAccess() {
<<<<<<< HEAD:web/core/modules/menu_ui/src/Tests/MenuTest.php
<<<<<<< HEAD
    $admin = $this->drupalCreateUser(array('administer menu'));
=======
    $admin = $this->drupalCreateUser(['administer menu']);
>>>>>>> revert Open Social update
    $this->drupalLogin($admin);
=======
    $this->drupalLogin($this->drupalCreateUser(['administer menu']));
>>>>>>> updating open social:web/core/modules/menu_ui/tests/src/Functional/MenuUiTest.php
    // Just check access to the callback overall, the POST data is irrelevant.
    $this->drupalGet('admin/structure/menu/parents', ['query' => [MainContentViewSubscriber::WRAPPER_FORMAT => 'drupal_ajax']], ['X-Requested-With: XMLHttpRequest']);
    $this->assertSession()->statusCodeEquals(200);

    // Log in as authenticated user.
    $this->drupalLogin($this->drupalCreateUser());
    // Check that a simple user is not able to access the menu.
    $this->drupalGet('admin/structure/menu/parents', ['query' => [MainContentViewSubscriber::WRAPPER_FORMAT => 'drupal_ajax']], ['X-Requested-With: XMLHttpRequest']);
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Returns standard menu link.
   *
   * @return \Drupal\Core\Menu\MenuLinkInterface
   *   A menu link plugin.
   */
  private function getStandardMenuLink() {
    // Retrieve menu link id of the Log out menu link, which will always be on
    // the front page.
    /** @var \Drupal\Core\Menu\MenuLinkManagerInterface $menu_link_manager */
    $menu_link_manager = \Drupal::service('plugin.manager.menu.link');
    $instance = $menu_link_manager->getInstance(['id' => 'user.logout']);

    $this->assertTrue((bool) $instance, 'Standard menu link was loaded');
    return $instance;
  }

  /**
   * Verifies the logged in user has the desired access to various menu pages.
   *
   * @param int $response
   *   (optional) The expected HTTP response code. Defaults to 200.
   */
  private function verifyAccess($response = 200) {
    // View menu help page.
    $this->drupalGet('admin/help/menu');
    $this->assertResponse($response);
    if ($response == 200) {
      $this->assertText(t('Menu'), 'Menu help was displayed');
    }

    // View menu build overview page.
    $this->drupalGet('admin/structure/menu');
    $this->assertResponse($response);
    if ($response == 200) {
      $this->assertText(t('Menus'), 'Menu build overview page was displayed');
    }

    // View tools menu customization page.
    $this->drupalGet('admin/structure/menu/manage/' . $this->menu->id());
    $this->assertResponse($response);
    if ($response == 200) {
      $this->assertText(t('Tools'), 'Tools menu page was displayed');
    }

    // View menu edit page for a static link.
    $item = $this->getStandardMenuLink();
    $this->drupalGet('admin/structure/menu/link/' . $item->getPluginId() . '/edit');
    $this->assertResponse($response);
    if ($response == 200) {
      $this->assertText(t('Edit menu item'), 'Menu edit page was displayed');
    }

    // View add menu page.
    $this->drupalGet('admin/structure/menu/add');
    $this->assertResponse($response);
    if ($response == 200) {
      $this->assertText(t('Menus'), 'Add menu page was displayed');
    }
  }

  /**
   * Tests menu block settings.
   */
  protected function doTestMenuBlock() {
    $menu_id = $this->menu->id();
    $block_id = $this->blockPlacements[$menu_id];
    $this->drupalGet('admin/structure/block/manage/' . $block_id);
    $this->drupalPostForm(NULL, [
      'settings[depth]' => 3,
      'settings[level]' => 2,
    ], t('Save block'));
    $block = Block::load($block_id);
    $settings = $block->getPlugin()->getConfiguration();
    $this->assertEqual($settings['depth'], 3);
    $this->assertEqual($settings['level'], 2);
    // Reset settings.
    $block->getPlugin()->setConfigurationValue('depth', 0);
    $block->getPlugin()->setConfigurationValue('level', 1);
    $block->save();
  }

}