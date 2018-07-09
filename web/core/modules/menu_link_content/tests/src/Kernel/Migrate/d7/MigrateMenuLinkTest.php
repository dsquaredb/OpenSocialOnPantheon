<?php

namespace Drupal\Tests\menu_link_content\Kernel\Migrate\d7;

use Drupal\Core\Database\Database;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\menu_link_content\MenuLinkContentInterface;
use Drupal\Tests\migrate_drupal\Kernel\d7\MigrateDrupal7TestBase;

/**
 * Menu link migration.
 *
 * @group menu_link_content
 */
class MigrateMenuLinkTest extends MigrateDrupal7TestBase {
  const MENU_NAME = 'menu-test-menu';

  /**
   * {@inheritdoc}
   */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
  public static $modules = array('link', 'menu_ui', 'menu_link_content');
=======
=======
>>>>>>> updating open social
  public static $modules = [
    'content_translation',
    'language',
    'link',
    'menu_ui',
    'menu_link_content',
    'node',
    'text',
  ];
<<<<<<< HEAD
>>>>>>> Update Open Social to 8.x-2.1
=======
  public static $modules = ['link', 'menu_ui', 'menu_link_content', 'node'];
>>>>>>> revert Open Social update
=======
>>>>>>> updating open social

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->installEntitySchema('menu_link_content');
<<<<<<< HEAD
    $this->executeMigration('menu');
=======
    $this->installEntitySchema('node');
    $this->installSchema('node', ['node_access']);
    $this->installConfig(static::$modules);
    $this->executeMigrations([
      'language',
      'd7_user_role',
      'd7_user',
      'd7_node_type',
      'd7_language_content_settings',
      'd7_node',
      'd7_node_translation',
      'd7_menu',
      'd7_menu_links',
      'node_translation_menu_links',
    ]);
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> Update Open Social to 8.x-2.1
=======
    $node->save();
    $this->executeMigrations(['d7_menu', 'd7_menu_links']);
>>>>>>> revert Open Social update
=======
>>>>>>> updating open social
    \Drupal::service('router.builder')->rebuild();
  }

  /**
   * Asserts various aspects of a menu link entity.
   *
   * @param string $id
   *   The link ID.
   * @param string $title
   *   The expected title of the link.
   * @param string $menu
   *   The expected ID of the menu to which the link will belong.
   * @param string $description
   *   The link's expected description.
   * @param bool $enabled
   *   Whether the link is enabled.
   * @param bool $expanded
   *   Whether the link is expanded.
   * @param array $attributes
   *   Additional attributes the link is expected to have.
   * @param string $uri
   *   The expected URI of the link.
   * @param int $weight
   *   The expected weight of the link.
   */
  protected function assertEntity($id, $title, $menu, $description, $enabled, $expanded, array $attributes, $uri, $weight) {
    /** @var \Drupal\menu_link_content\MenuLinkContentInterface $menu_link */
    $menu_link = MenuLinkContent::load($id);
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    $this->assertTrue($menu_link instanceof MenuLinkContentInterface);
    $this->assertIdentical($title, $menu_link->getTitle());
    $this->assertIdentical($menu, $menu_link->getMenuName());
    // The migration sets the description of the link to the value of the
    // 'title' attribute. Bit strange, but there you go.
    $this->assertIdentical($description, $menu_link->getDescription());
    $this->assertIdentical($enabled, $menu_link->isEnabled());
    $this->assertIdentical($expanded, $menu_link->isExpanded());
    $this->assertIdentical($attributes, $menu_link->link->options);
    $this->assertIdentical($uri, $menu_link->link->uri);
    $this->assertIdentical($weight, $menu_link->getWeight());
=======
    $this->assertInstanceOf(MenuLinkContentInterface::class, $menu_link);
=======
    $this->assertTrue($menu_link instanceof MenuLinkContentInterface);
>>>>>>> revert Open Social update
=======
    $this->assertInstanceOf(MenuLinkContentInterface::class, $menu_link);
>>>>>>> updating open social
    $this->assertSame($title, $menu_link->getTitle());
    $this->assertSame($menu, $menu_link->getMenuName());
    $this->assertSame($description, $menu_link->getDescription());
    $this->assertSame($enabled, $menu_link->isEnabled());
    $this->assertSame($expanded, $menu_link->isExpanded());
    $this->assertSame($attributes, $menu_link->link->options);
    $this->assertSame($uri, $menu_link->link->uri);
    $this->assertSame($weight, $menu_link->getWeight());
>>>>>>> Update Open Social to 8.x-2.1
    return $menu_link;
  }

  /**
   * Tests migration of menu links.
   */
  public function testMenuLinks() {
    $this->executeMigration('menu_links');
    $this->assertEntity(469, 'Bing', static::MENU_NAME, 'Bing', TRUE, FALSE, ['attributes' => ['title' => 'Bing']], 'http://bing.com', 0);
    $this->assertEntity(467, 'Google', static::MENU_NAME, 'Google', TRUE, FALSE, ['attributes' => ['title' => 'Google']], 'http://google.com', 0);
    $this->assertEntity(468, 'Yahoo', static::MENU_NAME, 'Yahoo', TRUE, FALSE, ['attributes' => ['title' => 'Yahoo']], 'http://yahoo.com', 0);
    $menu_link_tree_service = \Drupal::service('menu.link_tree');
    $parameters = new MenuTreeParameters();
    $tree = $menu_link_tree_service->load(static::MENU_NAME, $parameters);
    $this->assertEqual(2, count($tree));
    $children = 0;
    $google_found = FALSE;
    foreach ($tree as $menu_link_tree_element) {
      $children += $menu_link_tree_element->hasChildren;
      if ($menu_link_tree_element->link->getUrlObject()->toString() == 'http://bing.com') {
        $this->assertEqual(reset($menu_link_tree_element->subtree)->link->getUrlObject()->toString(), 'http://google.com');
        $google_found = TRUE;
      }
    }
    $this->assertEqual(1, $children);
    $this->assertTrue($google_found);
    // Now find the custom link under a system link.
    $parameters->root = 'system.admin_structure';
    $tree = $menu_link_tree_service->load(static::MENU_NAME, $parameters);
    $found = FALSE;
    foreach ($tree as $menu_link_tree_element) {
      $this->pass($menu_link_tree_element->link->getUrlObject()->toString());
      if ($menu_link_tree_element->link->getTitle() == 'custom link test') {
        $found = TRUE;
        break;
      }
    }
    $this->assertTrue($found);

    // Test the migration of menu links for translated nodes.
    $this->assertEntity(484, 'The thing about Deep Space 9', 'tools', NULL, TRUE, FALSE, ['attributes' => ['title' => '']], 'entity:node/2', 9);
    $this->assertEntity(485, 'is - The thing about Deep Space 9', 'tools', NULL, TRUE, FALSE, ['attributes' => ['title' => '']], 'entity:node/2', 10);
    $this->assertEntity(486, 'is - The thing about Firefly', 'tools', NULL, TRUE, FALSE, ['attributes' => ['title' => '']], 'entity:node/4', 11);
    $this->assertEntity(487, 'en - The thing about Firefly', 'tools', NULL, TRUE, FALSE, ['attributes' => ['title' => '']], 'entity:node/4', 12);
  }

  /**
   * Tests migrating a link with an undefined title attribute.
   */
  public function testUndefinedLinkTitle() {
    Database::getConnection('default', 'migrate')
      ->update('menu_links')
      ->fields(array(
        'options' => 'a:0:{}',
      ))
      ->condition('mlid', 467)
      ->execute();

    $this->executeMigration('menu_links');
    $this->assertEntity(467, 'Google', static::MENU_NAME, NULL, TRUE, FALSE, [], 'http://google.com', 0);
  }

}
