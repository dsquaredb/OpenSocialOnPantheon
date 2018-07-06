<?php

namespace Drupal\image\Tests;

use Drupal\image\Entity\ImageStyle;
use Drupal\simpletest\WebTestBase;

/**
 * Tests that images have correct dimensions when styled.
 *
 * @group image
 */
class ImageDimensionsTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
<<<<<<< HEAD
  public static $modules = array('image', 'image_module_test');
=======
  public static $modules = ['image', 'image_module_test'];
>>>>>>> revert Open Social update

  protected $profile = 'testing';

  /**
   * Test styled image dimensions cumulatively.
   */
<<<<<<< HEAD
  function testImageDimensions() {
=======
  public function testImageDimensions() {
>>>>>>> revert Open Social update
    $image_factory = $this->container->get('image.factory');
    // Create a working copy of the file.
    $files = $this->drupalGetTestFiles('image');
    $file = reset($files);
    $original_uri = file_unmanaged_copy($file->uri, 'public://', FILE_EXISTS_RENAME);

    // Create a style.
    /** @var $style \Drupal\image\ImageStyleInterface */
<<<<<<< HEAD
    $style = ImageStyle::create(array('name' => 'test', 'label' => 'Test'));
=======
    $style = ImageStyle::create(['name' => 'test', 'label' => 'Test']);
>>>>>>> revert Open Social update
    $style->save();
    $generated_uri = 'public://styles/test/public/' . \Drupal::service('file_system')->basename($original_uri);
    $url = file_url_transform_relative($style->buildUrl($original_uri));

<<<<<<< HEAD
    $variables = array(
=======
    $variables = [
>>>>>>> revert Open Social update
      '#theme' => 'image_style',
      '#style_name' => 'test',
      '#uri' => $original_uri,
      '#width' => 40,
      '#height' => 20,
<<<<<<< HEAD
    );
=======
    ];
>>>>>>> revert Open Social update
    // Verify that the original image matches the hard-coded values.
    $image_file = $image_factory->get($original_uri);
    $this->assertEqual($image_file->getWidth(), $variables['#width']);
    $this->assertEqual($image_file->getHeight(), $variables['#height']);

    // Scale an image that is wider than it is high.
<<<<<<< HEAD
    $effect = array(
      'id' => 'image_scale',
      'data' => array(
        'width' => 120,
        'height' => 90,
        'upscale' => TRUE,
      ),
      'weight' => 0,
    );
=======
    $effect = [
      'id' => 'image_scale',
      'data' => [
        'width' => 120,
        'height' => 90,
        'upscale' => TRUE,
      ],
      'weight' => 0,
    ];
>>>>>>> revert Open Social update

    $style->addImageEffect($effect);
    $style->save();
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" width="120" height="60" alt="" class="image-style-test" />');
    $this->assertFalse(file_exists($generated_uri), 'Generated file does not exist.');
    $this->drupalGet($this->getAbsoluteUrl($url));
    $this->assertResponse(200, 'Image was generated at the URL.');
    $this->assertTrue(file_exists($generated_uri), 'Generated file does exist after we accessed it.');
    $image_file = $image_factory->get($generated_uri);
    $this->assertEqual($image_file->getWidth(), 120);
    $this->assertEqual($image_file->getHeight(), 60);

    // Rotate 90 degrees anticlockwise.
<<<<<<< HEAD
    $effect = array(
      'id' => 'image_rotate',
      'data' => array(
        'degrees' => -90,
        'random' => FALSE,
      ),
      'weight' => 1,
    );
=======
    $effect = [
      'id' => 'image_rotate',
      'data' => [
        'degrees' => -90,
        'random' => FALSE,
      ],
      'weight' => 1,
    ];
>>>>>>> revert Open Social update

    $style->addImageEffect($effect);
    $style->save();
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" width="60" height="120" alt="" class="image-style-test" />');
    $this->assertFalse(file_exists($generated_uri), 'Generated file does not exist.');
    $this->drupalGet($this->getAbsoluteUrl($url));
    $this->assertResponse(200, 'Image was generated at the URL.');
    $this->assertTrue(file_exists($generated_uri), 'Generated file does exist after we accessed it.');
    $image_file = $image_factory->get($generated_uri);
    $this->assertEqual($image_file->getWidth(), 60);
    $this->assertEqual($image_file->getHeight(), 120);

    // Scale an image that is higher than it is wide (rotated by previous effect).
<<<<<<< HEAD
    $effect = array(
      'id' => 'image_scale',
      'data' => array(
        'width' => 120,
        'height' => 90,
        'upscale' => TRUE,
      ),
      'weight' => 2,
    );
=======
    $effect = [
      'id' => 'image_scale',
      'data' => [
        'width' => 120,
        'height' => 90,
        'upscale' => TRUE,
      ],
      'weight' => 2,
    ];
>>>>>>> revert Open Social update

    $style->addImageEffect($effect);
    $style->save();
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" width="45" height="90" alt="" class="image-style-test" />');
    $this->assertFalse(file_exists($generated_uri), 'Generated file does not exist.');
    $this->drupalGet($this->getAbsoluteUrl($url));
    $this->assertResponse(200, 'Image was generated at the URL.');
    $this->assertTrue(file_exists($generated_uri), 'Generated file does exist after we accessed it.');
    $image_file = $image_factory->get($generated_uri);
    $this->assertEqual($image_file->getWidth(), 45);
    $this->assertEqual($image_file->getHeight(), 90);

    // Test upscale disabled.
<<<<<<< HEAD
    $effect = array(
      'id' => 'image_scale',
      'data' => array(
        'width' => 400,
        'height' => 200,
        'upscale' => FALSE,
      ),
      'weight' => 3,
    );
=======
    $effect = [
      'id' => 'image_scale',
      'data' => [
        'width' => 400,
        'height' => 200,
        'upscale' => FALSE,
      ],
      'weight' => 3,
    ];
>>>>>>> revert Open Social update

    $style->addImageEffect($effect);
    $style->save();
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" width="45" height="90" alt="" class="image-style-test" />');
    $this->assertFalse(file_exists($generated_uri), 'Generated file does not exist.');
    $this->drupalGet($this->getAbsoluteUrl($url));
    $this->assertResponse(200, 'Image was generated at the URL.');
    $this->assertTrue(file_exists($generated_uri), 'Generated file does exist after we accessed it.');
    $image_file = $image_factory->get($generated_uri);
    $this->assertEqual($image_file->getWidth(), 45);
    $this->assertEqual($image_file->getHeight(), 90);

    // Add a desaturate effect.
<<<<<<< HEAD
    $effect = array(
      'id' => 'image_desaturate',
      'data' => array(),
      'weight' => 4,
    );
=======
    $effect = [
      'id' => 'image_desaturate',
      'data' => [],
      'weight' => 4,
    ];
>>>>>>> revert Open Social update

    $style->addImageEffect($effect);
    $style->save();
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" width="45" height="90" alt="" class="image-style-test" />');
    $this->assertFalse(file_exists($generated_uri), 'Generated file does not exist.');
    $this->drupalGet($this->getAbsoluteUrl($url));
    $this->assertResponse(200, 'Image was generated at the URL.');
    $this->assertTrue(file_exists($generated_uri), 'Generated file does exist after we accessed it.');
    $image_file = $image_factory->get($generated_uri);
    $this->assertEqual($image_file->getWidth(), 45);
    $this->assertEqual($image_file->getHeight(), 90);

    // Add a random rotate effect.
<<<<<<< HEAD
    $effect = array(
      'id' => 'image_rotate',
      'data' => array(
        'degrees' => 180,
        'random' => TRUE,
      ),
      'weight' => 5,
    );
=======
    $effect = [
      'id' => 'image_rotate',
      'data' => [
        'degrees' => 180,
        'random' => TRUE,
      ],
      'weight' => 5,
    ];
>>>>>>> revert Open Social update

    $style->addImageEffect($effect);
    $style->save();
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" alt="" class="image-style-test" />');
    $this->assertFalse(file_exists($generated_uri), 'Generated file does not exist.');
    $this->drupalGet($this->getAbsoluteUrl($url));
    $this->assertResponse(200, 'Image was generated at the URL.');
    $this->assertTrue(file_exists($generated_uri), 'Generated file does exist after we accessed it.');

<<<<<<< HEAD

    // Add a crop effect.
    $effect = array(
      'id' => 'image_crop',
      'data' => array(
        'width' => 30,
        'height' => 30,
        'anchor' => 'center-center',
      ),
      'weight' => 6,
    );
=======
    // Add a crop effect.
    $effect = [
      'id' => 'image_crop',
      'data' => [
        'width' => 30,
        'height' => 30,
        'anchor' => 'center-center',
      ],
      'weight' => 6,
    ];
>>>>>>> revert Open Social update

    $style->addImageEffect($effect);
    $style->save();
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" width="30" height="30" alt="" class="image-style-test" />');
    $this->assertFalse(file_exists($generated_uri), 'Generated file does not exist.');
    $this->drupalGet($this->getAbsoluteUrl($url));
    $this->assertResponse(200, 'Image was generated at the URL.');
    $this->assertTrue(file_exists($generated_uri), 'Generated file does exist after we accessed it.');
    $image_file = $image_factory->get($generated_uri);
    $this->assertEqual($image_file->getWidth(), 30);
    $this->assertEqual($image_file->getHeight(), 30);

    // Rotate to a non-multiple of 90 degrees.
<<<<<<< HEAD
    $effect = array(
      'id' => 'image_rotate',
      'data' => array(
        'degrees' => 57,
        'random' => FALSE,
      ),
      'weight' => 7,
    );

    $effect_id = $style->addImageEffect($effect);
    $style->save();
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" width="41" height="41" alt="" class="image-style-test" />');
=======
    $effect = [
      'id' => 'image_rotate',
      'data' => [
        'degrees' => 57,
        'random' => FALSE,
      ],
      'weight' => 7,
    ];

    $effect_id = $style->addImageEffect($effect);
    $style->save();
    // @todo Uncomment this once
    //   https://www.drupal.org/project/drupal/issues/2670966 is resolved.
    // $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" width="41" height="41" alt="" class="image-style-test" />');
>>>>>>> revert Open Social update
    $this->assertFalse(file_exists($generated_uri), 'Generated file does not exist.');
    $this->drupalGet($this->getAbsoluteUrl($url));
    $this->assertResponse(200, 'Image was generated at the URL.');
    $this->assertTrue(file_exists($generated_uri), 'Generated file does exist after we accessed it.');
    $image_file = $image_factory->get($generated_uri);
<<<<<<< HEAD
    $this->assertEqual($image_file->getWidth(), 41);
    $this->assertEqual($image_file->getHeight(), 41);
=======
    // @todo Uncomment this once
    //   https://www.drupal.org/project/drupal/issues/2670966 is resolved.
    // $this->assertEqual($image_file->getWidth(), 41);
    // $this->assertEqual($image_file->getHeight(), 41);
>>>>>>> revert Open Social update

    $effect_plugin = $style->getEffect($effect_id);
    $style->deleteImageEffect($effect_plugin);

    // Ensure that an effect can unset dimensions.
<<<<<<< HEAD
    $effect = array(
      'id' => 'image_module_test_null',
      'data' => array(),
      'weight' => 8,
    );
=======
    $effect = [
      'id' => 'image_module_test_null',
      'data' => [],
      'weight' => 8,
    ];
>>>>>>> revert Open Social update

    $style->addImageEffect($effect);
    $style->save();
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" alt="" class="image-style-test" />');

    // Test URI dependent image effect.
    $style = ImageStyle::create(['name' => 'test_uri', 'label' => 'Test URI']);
    $effect = [
      'id' => 'image_module_test_uri_dependent',
      'data' => [],
      'weight' => 0,
    ];
    $style->addImageEffect($effect);
    $style->save();
    $variables = [
      '#theme' => 'image_style',
      '#style_name' => 'test_uri',
      '#uri' => $original_uri,
      '#width' => 40,
      '#height' => 20,
    ];
    // PNG original image. Should be resized to 100x100.
    $generated_uri = 'public://styles/test_uri/public/' . \Drupal::service('file_system')->basename($original_uri);
    $url = file_url_transform_relative($style->buildUrl($original_uri));
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" width="100" height="100" alt="" class="image-style-test-uri" />');
    $this->assertFalse(file_exists($generated_uri), 'Generated file does not exist.');
    $this->drupalGet($this->getAbsoluteUrl($url));
    $this->assertResponse(200, 'Image was generated at the URL.');
    $this->assertTrue(file_exists($generated_uri), 'Generated file does exist after we accessed it.');
    $image_file = $image_factory->get($generated_uri);
    $this->assertEqual($image_file->getWidth(), 100);
    $this->assertEqual($image_file->getHeight(), 100);
    // GIF original image. Should be resized to 50x50.
    $file = $files[1];
    $original_uri = file_unmanaged_copy($file->uri, 'public://', FILE_EXISTS_RENAME);
    $generated_uri = 'public://styles/test_uri/public/' . \Drupal::service('file_system')->basename($original_uri);
    $url = file_url_transform_relative($style->buildUrl($original_uri));
    $variables['#uri'] = $original_uri;
    $this->assertEqual($this->getImageTag($variables), '<img src="' . $url . '" width="50" height="50" alt="" class="image-style-test-uri" />');
    $this->assertFalse(file_exists($generated_uri), 'Generated file does not exist.');
    $this->drupalGet($this->getAbsoluteUrl($url));
    $this->assertResponse(200, 'Image was generated at the URL.');
    $this->assertTrue(file_exists($generated_uri), 'Generated file does exist after we accessed it.');
    $image_file = $image_factory->get($generated_uri);
    $this->assertEqual($image_file->getWidth(), 50);
    $this->assertEqual($image_file->getHeight(), 50);
  }

  /**
   * Render an image style element.
   *
   * drupal_render() alters the passed $variables array by adding a new key
   * '#printed' => TRUE. This prevents next call to re-render the element. We
   * wrap drupal_render() in a helper protected method and pass each time a
   * fresh array so that $variables won't get altered and the element is
   * re-rendered each time.
   */
  protected function getImageTag($variables) {
    return str_replace("\n", NULL, \Drupal::service('renderer')->renderRoot($variables));
  }

}
