<?php

namespace Drupal\private_message\Ajax;

use Drupal\Core\Ajax\CommandInterface;

class PrivateMessageMembersAutocompleteResponseCommand implements CommandInterface {

  /**
   * The string that was searched
   *
   * @var string
   */
  protected $string;

  /**
   * The user information to be returned sent to the browser
   *
   * @var array $userInfo
   *   An array of user info, with each element of the array containing the following keys:
   *   - uid: The User ID of the user
   *   - username: The username of the user
   */
  protected $userInfo;

  /**
   * Construct a PrivateMessageMembersAutocompleteResponseCommand object
   *
   * @param string $string
   *   The string that was searched for
   * @param array $userInfo
   *   An array of user info, with each element of the array containing the following keys:
   *   - uid: The User ID of the user
   *   - username: The username of the user
   */
  public function __construct($string, array $userInfo) {
    $this->userInfo = $userInfo;
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    return [
      'command' => 'privateMessageMembersAutocompleteResponse',
      'string' => $this->string,
      'userInfo' => $this->userInfo,
    ];
  }
}
