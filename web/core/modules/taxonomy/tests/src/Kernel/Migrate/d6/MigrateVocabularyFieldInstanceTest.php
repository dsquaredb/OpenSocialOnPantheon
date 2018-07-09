<?php

namespace Drupal\Tests\taxonomy\Kernel\Migrate\d6;

use Drupal\field\Entity\FieldConfig;
use Drupal\Tests\migrate_drupal\Kernel\d6\MigrateDrupal6TestBase;

/**
 * Vocabulary field instance migration.
 *
 * @group migrate_drupal_6
 */
class MigrateVocabularyFieldInstanceTest extends MigrateDrupal6TestBase {

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
  public function testVocabularyFieldInstance() {
    // Test that the field exists.
    $field_id = 'node.article.tags';
    $field = FieldConfig::load($field_id);
    $this->assertIdentical($field_id, $field->id(), 'Field instance exists on article bundle.');
    $this->assertIdentical('Tags', $field->label());
    $this->assertTrue($field->isRequired(), 'Field is required');

    // Test the page bundle as well.
    $field_id = 'node.page.tags';
    $field = FieldConfig::load($field_id);
    $this->assertIdentical($field_id, $field->id(), 'Field instance exists on page bundle.');
    $this->assertIdentical('Tags', $field->label());
    $this->assertTrue($field->isRequired(), 'Field is required');

    $settings = $field->getSettings();
<<<<<<< HEAD
    $this->assertIdentical('default:taxonomy_term', $settings['handler'], 'The handler plugin ID is correct.');
    $this->assertIdentical(['tags'], $settings['handler_settings']['target_bundles'], 'The target_bundles handler setting is correct.');
    $this->assertIdentical(TRUE, $settings['handler_settings']['auto_create'], 'The "auto_create" setting is correct.');

<<<<<<< HEAD
<<<<<<< HEAD
    $this->assertIdentical(array('node', 'article', 'tags'), $this->getMigration('d6_vocabulary_field_instance')->getIdMap()->lookupDestinationID(array(4, 'article')));
=======
    $this->assertSame(['node', 'article', 'field_tags'], $this->getMigration('d6_vocabulary_field_instance')->getIdMap()->lookupDestinationId([4, 'article']));
>>>>>>> Update Open Social to 8.x-2.1
=======
    $this->assertSame(['node', 'article', 'field_tags'], $this->getMigration('d6_vocabulary_field_instance')->getIdMap()->lookupDestinationID([4, 'article']));
>>>>>>> revert Open Social update
=======
    $this->assertSame('default:taxonomy_term', $settings['handler'], 'The handler plugin ID is correct.');
    $this->assertSame(['field_tags'], $settings['handler_settings']['target_bundles'], 'The target_bundles handler setting is correct.');
    $this->assertSame(TRUE, $settings['handler_settings']['auto_create'], 'The "auto_create" setting is correct.');

    $this->assertSame(['node', 'article', 'field_tags'], $this->getMigration('d6_vocabulary_field_instance')->getIdMap()->lookupDestinationId([4, 'article']));
>>>>>>> updating open social

    // Test the the field vocabulary_1_i_0_
    $field_id = 'node.story.vocabulary_1_i_0_';
    $field = FieldConfig::load($field_id);
    $this->assertFalse($field->isRequired(), 'Field is not required');
  }

}
