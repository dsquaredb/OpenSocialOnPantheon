<?php

namespace Drupal\rdf_test;

/**
 * Contains methods for test data conversions.
 */
class TestDataConverter {

  /**
   * Converts data into a string for placement into a content attribute.
   *
   * @param array $data
   *   The data to be altered and placed in the content attribute.
   *
   * @return string
   *   Returns the data.
   */
<<<<<<< HEAD
  static function convertFoo($data) {
=======
  public static function convertFoo($data) {
>>>>>>> revert Open Social update
    return 'foo' . $data['value'];
  }

}