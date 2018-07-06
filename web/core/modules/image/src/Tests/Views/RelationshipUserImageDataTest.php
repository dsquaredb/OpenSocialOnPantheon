<?php

namespace Drupal\image\Tests\Views;

use Drupal\field\Entity\FieldConfig;
use Drupal\file\Entity\File;
use Drupal\views\Tests\ViewTestBase;
use Drupal\views\Views;
use Drupal\views\Tests\ViewTestData;
use Drupal\field\Entity\FieldStorageConfig;

/**
 * Tests image on user relationship handler.
 *
 * @group image
 */
class RelationshipUserImageDataTest extends ViewTestBase {

  /**
   * Modules to install.
   *
   * @var array
   */
<<<<<<< HEAD
  public static $modules = array('image', 'image_test_views', 'user');
=======
  public static $modules = ['image', 'image_test_views', 'user'];
>>>>>>> revert Open Social update

  /**
   * Views used by this test.
   *
   * @var array
   */
<<<<<<< HEAD
  public static $testViews = array('test_image_user_image_data');

  protected function setUp() {
    parent::setUp();

    // Create the user profile field and instance.
    FieldStorageConfig::create(array(
=======
  public static $testViews = ['test_image_user_image_data'];

  protected function setUp($import_test_views = TRUE) {
    parent::setUp($import_test_views);

    // Create the user profile field and instance.
    FieldStorageConfig::create([
>>>>>>> revert Open Social update
      'entity_type' => 'user',
      'field_name' => 'user_picture',
      'type' => 'image',
      'translatable' => '0',
<<<<<<< HEAD
    ))->save();
=======
    ])->save();
>>>>>>> revert Open Social update
    FieldConfig::create([
      'label' => 'User Picture',
      'description' => '',
      'field_name' => 'user_picture',
      'entity_type' => 'user',
      'bundle' => 'user',
      'required' => 0,
    ])->save();

<<<<<<< HEAD
    ViewTestData::createTestViews(get_class($this), array('image_test_views'));
=======
    ViewTestData::createTestViews(get_class($this), ['image_test_views']);
>>>>>>> revert Open Social update
  }

  /**
   * Tests using the views image relationship.
   */
  public function testViewsHandlerRelationshipUserImageData() {
    $file = File::create([
      'fid' => 2,
      'uid' => 2,
      'filename' => 'image-test.jpg',
      'uri' => "public://image-test.jpg",
      'filemime' => 'image/jpeg',
      'created' => 1,
      'changed' => 1,
      'status' => FILE_STATUS_PERMANENT,
    ]);
    $file->enforceIsNew();
    file_put_contents($file->getFileUri(), file_get_contents('core/modules/simpletest/files/image-1.png'));
    $file->save();

    $account = $this->drupalCreateUser();
    $account->user_picture->target_id = 2;
    $account->save();

    $view = Views::getView('test_image_user_image_data');
    // Tests \Drupal\taxonomy\Plugin\views\relationship\NodeTermData::calculateDependencies().
    $expected = [
      'module' => [
        'file',
        'user',
      ],
    ];
    $this->assertIdentical($expected, $view->getDependencies());
    $this->executeView($view);
<<<<<<< HEAD
    $expected_result = array(
      array(
        'file_managed_user__user_picture_fid' => '2',
      ),
    );
    $column_map = array('file_managed_user__user_picture_fid' => 'file_managed_user__user_picture_fid');
=======
    $expected_result = [
      [
        'file_managed_user__user_picture_fid' => '2',
      ],
    ];
    $column_map = ['file_managed_user__user_picture_fid' => 'file_managed_user__user_picture_fid'];
>>>>>>> revert Open Social update
    $this->assertIdenticalResultset($view, $expected_result, $column_map);
  }

}
