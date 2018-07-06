<?php

namespace Drupal\Tests\menu_link_content\Kernel\Migrate\d6;

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\Tests\migrate_drupal\Kernel\d6\MigrateDrupal6TestBase;

/**
 * Menu link migration.
 *
 * @group migrate_drupal_6
 */
class MigrateMenuLinkTest extends MigrateDrupal6TestBase {

  /**
   * {@inheritdoc}
   */
<<<<<<< HEAD
<<<<<<< HEAD
  public static $modules = array('menu_ui', 'menu_link_content');
=======
  public static $modules = [
    'content_translation',
    'language',
    'menu_link_content',
    'menu_ui',
  ];
>>>>>>> Update Open Social to 8.x-2.1
=======
  public static $modules = ['menu_ui', 'menu_link_content'];
>>>>>>> revert Open Social update

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->installEntitySchema('menu_link_content');
<<<<<<< HEAD
<<<<<<< HEAD
    $this->executeMigrations(['menu', 'menu_links']);
=======
    $this->executeMigrations([
      'language',
      'd6_language_content_settings',
      'd6_node',
      'd6_node_translation',
      'd6_menu',
      'd6_menu_links',
      'node_translation_menu_links',
    ]);
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
   *
   * @return \Drupal\menu_link_content\MenuLinkContentInterface
   *   The menu link content.
   */
  protected function assertEntity($id, $title, $menu, $description, $enabled, $expanded, array $attributes, $uri, $weight) {
    /** @var \Drupal\menu_link_content\MenuLinkContentInterface $menu_link */
    $menu_link = MenuLinkContent::load($id);
    $this->assertInstanceOf(MenuLinkContentInterface::class, $menu_link);
    $this->assertSame($title, $menu_link->getTitle());
    $this->assertSame($menu, $menu_link->getMenuName());
    $this->assertSame($description, $menu_link->getDescription());
    $this->assertSame($enabled, $menu_link->isEnabled());
    $this->assertSame($expanded, $menu_link->isExpanded());
    $this->assertSame($attributes, $menu_link->link->options);
    $this->assertSame($uri, $menu_link->link->uri);
    $this->assertSame($weight, $menu_link->getWeight());
    return $menu_link;
>>>>>>> Update Open Social to 8.x-2.1
=======
    $this->executeMigrations(['d6_menu', 'd6_menu_links']);
>>>>>>> revert Open Social update
  }

  /**
   * Tests migration of menu links.
   */
  public function testMenuLinks() {
    $menu_link = MenuLinkContent::load(138);
    $this->assertIdentical('Test 1', $menu_link->getTitle());
    $this->assertIdentical('secondary-links', $menu_link->getMenuName());
    $this->assertIdentical('Test menu link 1', $menu_link->getDescription());
    $this->assertIdentical(TRUE, $menu_link->isEnabled());
    $this->assertIdentical(FALSE, $menu_link->isExpanded());
    $this->assertIdentical(['attributes' => ['title' => 'Test menu link 1']], $menu_link->link->options);
    $this->assertIdentical('internal:/user/login', $menu_link->link->uri);
    $this->assertIdentical(-50, $menu_link->getWeight());

    $menu_link = MenuLinkContent::load(139);
    $this->assertIdentical('Test 2', $menu_link->getTitle());
    $this->assertIdentical('secondary-links', $menu_link->getMenuName());
    $this->assertIdentical('Test menu link 2', $menu_link->getDescription());
    $this->assertIdentical(TRUE, $menu_link->isEnabled());
    $this->assertIdentical(TRUE, $menu_link->isExpanded());
    $this->assertIdentical(['query' => 'foo=bar', 'attributes' => ['title' => 'Test menu link 2']], $menu_link->link->options);
    $this->assertIdentical('internal:/admin', $menu_link->link->uri);
    $this->assertIdentical(-49, $menu_link->getWeight());

    $menu_link = MenuLinkContent::load(140);
    $this->assertIdentical('Drupal.org', $menu_link->getTitle());
    $this->assertIdentical('secondary-links', $menu_link->getMenuName());
    $this->assertIdentical(NULL, $menu_link->getDescription());
    $this->assertIdentical(TRUE, $menu_link->isEnabled());
    $this->assertIdentical(FALSE, $menu_link->isExpanded());
    $this->assertIdentical(['attributes' => ['title' => '']], $menu_link->link->options);
    $this->assertIdentical('https://www.drupal.org', $menu_link->link->uri);
    $this->assertIdentical(-50, $menu_link->getWeight());

    // assert that missing title attributes don't stop or break migration.
    $menu_link = MenuLinkContent::load(393);
    $this->assertIdentical('Test 3', $menu_link->getTitle());
    $this->assertIdentical('secondary-links', $menu_link->getMenuName());
    $this->assertIdentical(NULL, $menu_link->getDescription());
    $this->assertIdentical(TRUE, $menu_link->isEnabled());
    $this->assertIdentical(FALSE, $menu_link->isExpanded());
    $this->assertIdentical([], $menu_link->link->options);
    $this->assertIdentical('internal:/user/login', $menu_link->link->uri);
    $this->assertIdentical(-47, $menu_link->getWeight());
  }

}
