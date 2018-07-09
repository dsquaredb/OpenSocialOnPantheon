<?php

namespace Drupal\Tests\taxonomy\Kernel\Migrate\d6;

use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Tests\migrate_drupal\Kernel\d6\MigrateDrupal6TestBase;

/**
 * Vocabulary entity form display migration.
 *
 * @group migrate_drupal_6
 */
class MigrateVocabularyEntityFormDisplayTest extends MigrateDrupal6TestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['taxonomy'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->migrateTaxonomy();
  }

  /**
   * Tests the Drupal 6 vocabulary-node type association to Drupal 8 migration.
   */
  public function testVocabularyEntityFormDisplay() {
    // Test that the field exists.
    $component = EntityFormDisplay::load('node.page.default')->getComponent('tags');
    $this->assertIdentical('options_select', $component['type']);
    $this->assertIdentical(20, $component['weight']);
    // Test the Id map.
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    $this->assertIdentical(array('node', 'article', 'default', 'tags'), $this->getMigration('d6_vocabulary_entity_form_display')->getIdMap()->lookupDestinationID(array(4, 'article')));
=======
    $this->assertSame(['node', 'article', 'default', 'field_tags'], $this->getMigration('d6_vocabulary_entity_form_display')->getIdMap()->lookupDestinationId([4, 'article']));
>>>>>>> Update Open Social to 8.x-2.1
=======
    $this->assertSame(['node', 'article', 'default', 'field_tags'], $this->getMigration('d6_vocabulary_entity_form_display')->getIdMap()->lookupDestinationID([4, 'article']));
>>>>>>> revert Open Social update
=======
    $this->assertSame(['node', 'article', 'default', 'field_tags'], $this->getMigration('d6_vocabulary_entity_form_display')->getIdMap()->lookupDestinationId([4, 'article']));
>>>>>>> updating open social

    // Test the term widget tags setting.
    $entity_form_display = EntityFormDisplay::load('node.story.default');
    $this->assertIdentical($entity_form_display->getComponent('vocabulary_1_i_0_')['type'], 'options_select');
    $this->assertIdentical($entity_form_display->getComponent('vocabulary_2_i_1_')['type'], 'entity_reference_autocomplete_tags');
  }

}
