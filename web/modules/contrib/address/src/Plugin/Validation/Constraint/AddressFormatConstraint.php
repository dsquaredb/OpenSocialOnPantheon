<?php

namespace Drupal\address\Plugin\Validation\Constraint;

use CommerceGuys\Addressing\AddressFormat\AddressField;
use Symfony\Component\Validator\Constraint;

/**
 * Address format constraint.
 *
 * @Constraint(
 *   id = "AddressFormat",
 *   label = @Translation("Address Format", context = "Validation"),
 *   type = { "address" }
 * )
 */
class AddressFormatConstraint extends Constraint {

  public $fields;
  public $blankMessage = '@name field must be blank.';
  public $notBlankMessage = '@name field is required.';
  public $invalidMessage = '@name field is not in the right format.';

<<<<<<< HEAD
<<<<<<< HEAD
  /**
   * {@inheritDoc}
=======
  /**
   * {@inheritdoc}
>>>>>>> revert Open Social update
   */
  public function __construct($options = NULL) {
    parent::__construct($options);

    // Validate all fields by default.
    if (empty($this->fields)) {
      $this->fields = array_values(AddressField::getAll());
    }
  }

  /**
<<<<<<< HEAD
   * {@inheritDoc}
=======
   * {@inheritdoc}
>>>>>>> revert Open Social update
   */
  public function getTargets() {
    return self::CLASS_CONSTRAINT;
  }

<<<<<<< HEAD
=======
>>>>>>> Update Open Social to 8.x-2.1
=======
>>>>>>> revert Open Social update
}
