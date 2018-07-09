<?php

<<<<<<< HEAD:web/core/modules/image/src/Tests/ImageFieldDefaultImagesTest.php
namespace Drupal\image\Tests;
<<<<<<< HEAD
=======
=======
namespace Drupal\Tests\image\Functional;
>>>>>>> updating open social:web/core/modules/image/tests/src/Functional/ImageFieldDefaultImagesTest.php

>>>>>>> revert Open Social update
use Drupal\Component\Utility\Unicode;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\field\Entity\FieldConfig;
use Drupal\file\Entity\File;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\Tests\EntityViewTrait;
use Drupal\Tests\TestFileCreationTrait;

/**
<<<<<<< HEAD
 * Tests setting up default images both to the field and field field.
=======
 * Tests setting up default images both to the field and field storage.
>>>>>>> revert Open Social update
 *
 * @group image
 */
class ImageFieldDefaultImagesTest extends ImageFieldTestBase {

  use TestFileCreationTrait {
    getTestFiles as drupalGetTestFiles;
    compareFiles as drupalCompareFiles;
  }
  use EntityViewTrait {
    buildEntityView as drupalBuildEntityView;
  }

  /**
   * Modules to enable.
   *
   * @var array
   */
<<<<<<< HEAD
  public static $modules = array('field_ui');

  /**
   * Tests CRUD for fields and fields fields with default images.
=======
  public static $modules = ['field_ui'];

  /**
   * Tests CRUD for fields and field storages with default images.
>>>>>>> revert Open Social update
   */
  public function testDefaultImages() {
    $node_storage = $this->container->get('entity.manager')->getStorage('node');
    // Create files to use as the default images.
    $files = $this->drupalGetTestFiles('image');
    // Create 10 files so the default image fids are not a single value.
    for ($i = 1; $i <= 10; $i++) {
      $filename = $this->randomMachineName() . "$i";
      $desired_filepath = 'public://' . $filename;
      file_unmanaged_copy($files[0]->uri, $desired_filepath, FILE_EXISTS_ERROR);
      $file = File::create(['uri' => $desired_filepath, 'filename' => $filename, 'name' => $filename]);
      $file->save();
    }
<<<<<<< HEAD
    $default_images = array();
    foreach (array('field', 'field', 'field2', 'field_new', 'field_new') as $image_target) {
=======
    $default_images = [];
    foreach (['field_storage', 'field', 'field2', 'field_storage_new', 'field_new', 'field_storage_private', 'field_private'] as $image_target) {
>>>>>>> revert Open Social update
      $file = File::create((array) array_pop($files));
      $file->save();
      $default_images[$image_target] = $file;
    }

<<<<<<< HEAD
    // Create an image field and add an field to the article content type.
    $field_name = strtolower($this->randomMachineName());
    $storage_settings['default_image'] = array(
      'uuid' => $default_images['field']->uuid(),
=======
    // Create an image field storage and add a field to the article content
    // type.
    $field_name = strtolower($this->randomMachineName());
    $storage_settings['default_image'] = [
      'uuid' => $default_images['field_storage']->uuid(),
>>>>>>> revert Open Social update
      'alt' => '',
      'title' => '',
      'width' => 0,
      'height' => 0,
<<<<<<< HEAD
    );
    $field_settings['default_image'] = array(
=======
    ];
    $field_settings['default_image'] = [
>>>>>>> revert Open Social update
      'uuid' => $default_images['field']->uuid(),
      'alt' => '',
      'title' => '',
      'width' => 0,
      'height' => 0,
<<<<<<< HEAD
    );
    $widget_settings = array(
      'preview_image_style' => 'medium',
    );
=======
    ];
    $widget_settings = [
      'preview_image_style' => 'medium',
    ];
>>>>>>> revert Open Social update
    $field = $this->createImageField($field_name, 'article', $storage_settings, $field_settings, $widget_settings);

    // The field default image id should be 2.
    $this->assertEqual($field->getSetting('default_image')['uuid'], $default_images['field']->uuid());

    // Also test \Drupal\field\Entity\FieldConfig::getSettings().
    $this->assertEqual($field->getSettings()['default_image']['uuid'], $default_images['field']->uuid());

    $field_storage = $field->getFieldStorageDefinition();

<<<<<<< HEAD
    // The field default image id should be 1.
    $this->assertEqual($field_storage->getSetting('default_image')['uuid'], $default_images['field']->uuid());

    // Also test \Drupal\field\Entity\FieldStorageConfig::getSettings().
    $this->assertEqual($field_storage->getSettings()['default_image']['uuid'], $default_images['field']->uuid());
=======
    // The field storage default image id should be 1.
    $this->assertEqual($field_storage->getSetting('default_image')['uuid'], $default_images['field_storage']->uuid());

    // Also test \Drupal\field\Entity\FieldStorageConfig::getSettings().
    $this->assertEqual($field_storage->getSettings()['default_image']['uuid'], $default_images['field_storage']->uuid());
>>>>>>> revert Open Social update

    // Add another field with another default image to the page content type.
    $field2 = FieldConfig::create([
      'field_storage' => $field_storage,
      'bundle' => 'page',
      'label' => $field->label(),
      'required' => $field->isRequired(),
<<<<<<< HEAD
      'settings' => array(
        'default_image' => array(
=======
      'settings' => [
        'default_image' => [
>>>>>>> revert Open Social update
          'uuid' => $default_images['field2']->uuid(),
          'alt' => '',
          'title' => '',
          'width' => 0,
          'height' => 0,
<<<<<<< HEAD
        ),
      ),
=======
        ],
      ],
>>>>>>> revert Open Social update
    ]);
    $field2->save();

    $widget_settings = entity_get_form_display('node', $field->getTargetBundle(), 'default')->getComponent($field_name);
    entity_get_form_display('node', 'page', 'default')
      ->setComponent($field_name, $widget_settings)
      ->save();
    entity_get_display('node', 'page', 'default')
      ->setComponent($field_name)
      ->save();

<<<<<<< HEAD
    // Confirm the defaults are present on the article field settings form.
=======
    // Confirm the defaults are present on the article field storage settings
    // form.
>>>>>>> revert Open Social update
    $field_id = $field->id();
    $this->drupalGet("admin/structure/types/manage/article/fields/$field_id/storage");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
<<<<<<< HEAD
      $default_images['field']->id(),
      format_string(
        'Article image field default equals expected file ID of @fid.',
        array('@fid' => $default_images['field']->id())
=======
      $default_images['field_storage']->id(),
      format_string(
        'Article image field storage default equals expected file ID of @fid.',
        ['@fid' => $default_images['field_storage']->id()]
>>>>>>> revert Open Social update
      )
    );
    // Confirm the defaults are present on the article field edit form.
    $this->drupalGet("admin/structure/types/manage/article/fields/$field_id");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
      $default_images['field']->id(),
      format_string(
<<<<<<< HEAD
        'Article image field field default equals expected file ID of @fid.',
        array('@fid' => $default_images['field']->id())
      )
    );

    // Confirm the defaults are present on the page field settings form.
    $this->drupalGet("admin/structure/types/manage/page/fields/$field_id/storage");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
      $default_images['field']->id(),
      format_string(
        'Page image field default equals expected file ID of @fid.',
        array('@fid' => $default_images['field']->id())
=======
        'Article image field default equals expected file ID of @fid.',
        ['@fid' => $default_images['field']->id()]
      )
    );

    // Confirm the defaults are present on the page field storage settings form.
    $this->drupalGet("admin/structure/types/manage/page/fields/$field_id/storage");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
      $default_images['field_storage']->id(),
      format_string(
        'Page image field storage default equals expected file ID of @fid.',
        ['@fid' => $default_images['field_storage']->id()]
>>>>>>> revert Open Social update
      )
    );
    // Confirm the defaults are present on the page field edit form.
    $field2_id = $field2->id();
    $this->drupalGet("admin/structure/types/manage/page/fields/$field2_id");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
      $default_images['field2']->id(),
      format_string(
<<<<<<< HEAD
        'Page image field field default equals expected file ID of @fid.',
        array('@fid' => $default_images['field2']->id())
=======
        'Page image field default equals expected file ID of @fid.',
        ['@fid' => $default_images['field2']->id()]
>>>>>>> revert Open Social update
      )
    );

    // Confirm that the image default is shown for a new article node.
<<<<<<< HEAD
    $article = $this->drupalCreateNode(array('type' => 'article'));
=======
    $article = $this->drupalCreateNode(['type' => 'article']);
>>>>>>> revert Open Social update
    $article_built = $this->drupalBuildEntityView($article);
    $this->assertEqual(
      $article_built[$field_name][0]['#item']->target_id,
      $default_images['field']->id(),
      format_string(
        'A new article node without an image has the expected default image file ID of @fid.',
<<<<<<< HEAD
        array('@fid' => $default_images['field']->id())
=======
        ['@fid' => $default_images['field']->id()]
>>>>>>> revert Open Social update
      )
    );

    // Also check that the field renders without warnings when the label is
    // hidden.
    EntityViewDisplay::load('node.article.default')
<<<<<<< HEAD
      ->setComponent($field_name, array('label' => 'hidden', 'type' => 'image'))
=======
      ->setComponent($field_name, ['label' => 'hidden', 'type' => 'image'])
>>>>>>> revert Open Social update
      ->save();
    $this->drupalGet('node/' . $article->id());

    // Confirm that the image default is shown for a new page node.
<<<<<<< HEAD
    $page = $this->drupalCreateNode(array('type' => 'page'));
=======
    $page = $this->drupalCreateNode(['type' => 'page']);
>>>>>>> revert Open Social update
    $page_built = $this->drupalBuildEntityView($page);
    $this->assertEqual(
      $page_built[$field_name][0]['#item']->target_id,
      $default_images['field2']->id(),
      format_string(
        'A new page node without an image has the expected default image file ID of @fid.',
<<<<<<< HEAD
        array('@fid' => $default_images['field2']->id())
=======
        ['@fid' => $default_images['field2']->id()]
>>>>>>> revert Open Social update
      )
    );

    // Upload a new default for the field storage.
    $default_image_settings = $field_storage->getSetting('default_image');
<<<<<<< HEAD
    $default_image_settings['uuid'] = $default_images['field_new']->uuid();
    $field_storage->setSetting('default_image', $default_image_settings);
    $field_storage->save();

    // Confirm that the new default is used on the article field settings form.
    $this->drupalGet("admin/structure/types/manage/article/fields/$field_id/storage");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
      $default_images['field_new']->id(),
      format_string(
        'Updated image field default equals expected file ID of @fid.',
        array('@fid' => $default_images['field_new']->id())
      )
    );

    // Reload the nodes and confirm the field field defaults are used.
    $node_storage->resetCache(array($article->id(), $page->id()));
=======
    $default_image_settings['uuid'] = $default_images['field_storage_new']->uuid();
    $field_storage->setSetting('default_image', $default_image_settings);
    $field_storage->save();

    // Confirm that the new default is used on the article field storage
    // settings form.
    $this->drupalGet("admin/structure/types/manage/article/fields/$field_id/storage");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
      $default_images['field_storage_new']->id(),
      format_string(
        'Updated image field storage default equals expected file ID of @fid.',
        ['@fid' => $default_images['field_storage_new']->id()]
      )
    );

    // Reload the nodes and confirm the field defaults are used.
    $node_storage->resetCache([$article->id(), $page->id()]);
>>>>>>> revert Open Social update
    $article_built = $this->drupalBuildEntityView($article = $node_storage->load($article->id()));
    $page_built = $this->drupalBuildEntityView($page = $node_storage->load($page->id()));
    $this->assertEqual(
      $article_built[$field_name][0]['#item']->target_id,
      $default_images['field']->id(),
      format_string(
        'An existing article node without an image has the expected default image file ID of @fid.',
<<<<<<< HEAD
        array('@fid' => $default_images['field']->id())
=======
        ['@fid' => $default_images['field']->id()]
>>>>>>> revert Open Social update
      )
    );
    $this->assertEqual(
      $page_built[$field_name][0]['#item']->target_id,
      $default_images['field2']->id(),
      format_string(
        'An existing page node without an image has the expected default image file ID of @fid.',
<<<<<<< HEAD
        array('@fid' => $default_images['field2']->id())
      )
    );

    // Upload a new default for the article's field field.
=======
        ['@fid' => $default_images['field2']->id()]
      )
    );

    // Upload a new default for the article's field.
>>>>>>> revert Open Social update
    $default_image_settings = $field->getSetting('default_image');
    $default_image_settings['uuid'] = $default_images['field_new']->uuid();
    $field->setSetting('default_image', $default_image_settings);
    $field->save();

<<<<<<< HEAD
    // Confirm the new field field default is used on the article field
    // admin form.
=======
    // Confirm the new field default is used on the article field admin form.
>>>>>>> revert Open Social update
    $this->drupalGet("admin/structure/types/manage/article/fields/$field_id");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
      $default_images['field_new']->id(),
      format_string(
<<<<<<< HEAD
        'Updated article image field field default equals expected file ID of @fid.',
        array('@fid' => $default_images['field_new']->id())
=======
        'Updated article image field default equals expected file ID of @fid.',
        ['@fid' => $default_images['field_new']->id()]
>>>>>>> revert Open Social update
      )
    );

    // Reload the nodes.
<<<<<<< HEAD
    $node_storage->resetCache(array($article->id(), $page->id()));
=======
    $node_storage->resetCache([$article->id(), $page->id()]);
>>>>>>> revert Open Social update
    $article_built = $this->drupalBuildEntityView($article = $node_storage->load($article->id()));
    $page_built = $this->drupalBuildEntityView($page = $node_storage->load($page->id()));

    // Confirm the article uses the new default.
    $this->assertEqual(
      $article_built[$field_name][0]['#item']->target_id,
      $default_images['field_new']->id(),
      format_string(
        'An existing article node without an image has the expected default image file ID of @fid.',
<<<<<<< HEAD
        array('@fid' => $default_images['field_new']->id())
=======
        ['@fid' => $default_images['field_new']->id()]
>>>>>>> revert Open Social update
      )
    );
    // Confirm the page remains unchanged.
    $this->assertEqual(
      $page_built[$field_name][0]['#item']->target_id,
      $default_images['field2']->id(),
      format_string(
        'An existing page node without an image has the expected default image file ID of @fid.',
<<<<<<< HEAD
        array('@fid' => $default_images['field2']->id())
=======
        ['@fid' => $default_images['field2']->id()]
>>>>>>> revert Open Social update
      )
    );

    // Confirm the default image is shown on the node form.
    $file = File::load($default_images['field_new']->id());
    $this->drupalGet('node/add/article');
    $this->assertRaw($file->getFilename());

<<<<<<< HEAD
    // Remove the instance default from articles.
=======
    // Remove the field default from articles.
>>>>>>> revert Open Social update
    $default_image_settings = $field->getSetting('default_image');
    $default_image_settings['uuid'] = 0;
    $field->setSetting('default_image', $default_image_settings);
    $field->save();

<<<<<<< HEAD
    // Confirm the article field field default has been removed.
=======
    // Confirm the article field default has been removed.
>>>>>>> revert Open Social update
    $this->drupalGet("admin/structure/types/manage/article/fields/$field_id");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
      '',
<<<<<<< HEAD
      'Updated article image field field default has been successfully removed.'
    );

    // Reload the nodes.
    $node_storage->resetCache(array($article->id(), $page->id()));
    $article_built = $this->drupalBuildEntityView($article = $node_storage->load($article->id()));
    $page_built = $this->drupalBuildEntityView($page = $node_storage->load($page->id()));
    // Confirm the article uses the new field (not field) default.
    $this->assertEqual(
      $article_built[$field_name][0]['#item']->target_id,
      $default_images['field_new']->id(),
      format_string(
        'An existing article node without an image has the expected default image file ID of @fid.',
        array('@fid' => $default_images['field_new']->id())
=======
      'Updated article image field default has been successfully removed.'
    );

    // Reload the nodes.
    $node_storage->resetCache([$article->id(), $page->id()]);
    $article_built = $this->drupalBuildEntityView($article = $node_storage->load($article->id()));
    $page_built = $this->drupalBuildEntityView($page = $node_storage->load($page->id()));
    // Confirm the article uses the new field storage (not field) default.
    $this->assertEqual(
      $article_built[$field_name][0]['#item']->target_id,
      $default_images['field_storage_new']->id(),
      format_string(
        'An existing article node without an image has the expected default image file ID of @fid.',
        ['@fid' => $default_images['field_storage_new']->id()]
>>>>>>> revert Open Social update
      )
    );
    // Confirm the page remains unchanged.
    $this->assertEqual(
      $page_built[$field_name][0]['#item']->target_id,
      $default_images['field2']->id(),
      format_string(
        'An existing page node without an image has the expected default image file ID of @fid.',
<<<<<<< HEAD
        array('@fid' => $default_images['field2']->id())
=======
        ['@fid' => $default_images['field2']->id()]
>>>>>>> revert Open Social update
      )
    );

    $non_image = $this->drupalGetTestFiles('text');
<<<<<<< HEAD
    $this->drupalPostForm(NULL, array('files[settings_default_image_uuid]' => drupal_realpath($non_image[0]->uri)), t("Upload"));
=======
    $this->drupalPostForm(NULL, ['files[settings_default_image_uuid]' => \Drupal::service('file_system')->realpath($non_image[0]->uri)], t("Upload"));
>>>>>>> revert Open Social update
    $this->assertText('The specified file text-0.txt could not be uploaded.');
    $this->assertText('Only files with the following extensions are allowed: png gif jpg jpeg.');

    // Confirm the default image is shown on the node form.
<<<<<<< HEAD
    $file = File::load($default_images['field_new']->id());
    $this->drupalGet('node/add/article');
    $this->assertRaw($file->getFilename());
  }

  /**
   * Tests image field and field having an invalid default image.
   */
  public function testInvalidDefaultImage() {
    $field_storage = FieldStorageConfig::create(array(
      'field_name' => Unicode::strtolower($this->randomMachineName()),
      'entity_type' => 'node',
      'type' => 'image',
      'settings' => array(
        'default_image' => array(
          'uuid' => 100000,
        )
      ),
    ));
=======
    $file = File::load($default_images['field_storage_new']->id());
    $this->drupalGet('node/add/article');
    $this->assertRaw($file->getFilename());

    // Change the default image for the field storage and also change the upload
    // destination to the private filesystem at the same time.
    $default_image_settings = $field_storage->getSetting('default_image');
    $default_image_settings['uuid'] = $default_images['field_storage_private']->uuid();
    $field_storage->setSetting('default_image', $default_image_settings);
    $field_storage->setSetting('uri_scheme', 'private');
    $field_storage->save();

    // Confirm that the new default is used on the article field storage
    // settings form.
    $this->drupalGet("admin/structure/types/manage/article/fields/$field_id/storage");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
      $default_images['field_storage_private']->id(),
      format_string(
        'Updated image field storage default equals expected file ID of @fid.',
        ['@fid' => $default_images['field_storage_private']->id()]
      )
    );

    // Upload a new default for the article's field after setting the field
    // storage upload destination to 'private'.
    $default_image_settings = $field->getSetting('default_image');
    $default_image_settings['uuid'] = $default_images['field_private']->uuid();
    $field->setSetting('default_image', $default_image_settings);
    $field->save();

    // Confirm the new field field default is used on the article field
    // admin form.
    $this->drupalGet("admin/structure/types/manage/article/fields/$field_id");
    $this->assertFieldByXpath(
      '//input[@name="settings[default_image][uuid][fids]"]',
      $default_images['field_private']->id(),
      format_string(
        'Updated article image field default equals expected file ID of @fid.',
        ['@fid' => $default_images['field_private']->id()]
      )
    );
  }

  /**
   * Tests image field and field storage having an invalid default image.
   */
  public function testInvalidDefaultImage() {
    $field_storage = FieldStorageConfig::create([
      'field_name' => Unicode::strtolower($this->randomMachineName()),
      'entity_type' => 'node',
      'type' => 'image',
      'settings' => [
        'default_image' => [
          'uuid' => 100000,
        ]
      ],
    ]);
>>>>>>> revert Open Social update
    $field_storage->save();
    $settings = $field_storage->getSettings();
    // The non-existent default image should not be saved.
    $this->assertNull($settings['default_image']['uuid']);

    $field = FieldConfig::create([
      'field_storage' => $field_storage,
      'bundle' => 'page',
      'label' => $this->randomMachineName(),
<<<<<<< HEAD
      'settings' => array(
        'default_image' => array(
          'uuid' => 100000,
        )
      ),
=======
      'settings' => [
        'default_image' => [
          'uuid' => 100000,
        ]
      ],
>>>>>>> revert Open Social update
    ]);
    $field->save();
    $settings = $field->getSettings();
    // The non-existent default image should not be saved.
    $this->assertNull($settings['default_image']['uuid']);
  }

}