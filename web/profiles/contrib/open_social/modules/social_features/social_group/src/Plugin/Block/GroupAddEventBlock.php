<?php

namespace Drupal\social_group\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides a 'GroupAddEventBlock' block.
 *
 * @Block(
 *  id = "group_add_event_block",
 *  admin_label = @Translation("Group add event block"),
 * )
 */
class GroupAddEventBlock extends BlockBase {

  /**
   * {@inheritdoc}
   *
   * Custom access logic to display the block.
   */
  function blockAccess(AccountInterface $account) {
    $group = _social_group_get_current_group();

<<<<<<< HEAD
    if(is_object($group)){
      if ($group->hasPermission('create event node', $account)) {
=======
    if (is_object($group)) {
      if ($group->hasPermission('create group_node:event entity', $account)) {
<<<<<<< HEAD
        if ($group->getGroupType()->id() === 'public_group') {
          $config = \Drupal::config('entity_access_by_field.settings');
          if ($config->get('disable_public_visibility') === 1 && !$account->hasPermission('override disabled public visibility')) {
            return AccessResult::forbidden();
          }
        }
>>>>>>> Update Open Social to 8.x-2.1
=======
>>>>>>> revert Open Social update
        return AccessResult::allowed();
      }
    }

    // By default, the block is not visible.
    return AccessResult::forbidden();
  }


  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $group = _social_group_get_current_group();

    if(is_object($group)){
      $url = Url::fromUserInput("/group/{$group->id()}/node/create/event");

      $link_options = array(
        'attributes' => array(
          'class' => array(
            'btn',
            'btn-primary',
            'btn-raised',
            'btn-block',
            'waves-effect',
            'waves-light',
          ),
        ),
      );
      $url->setOptions($link_options);

      $build['content'] = Link::fromTextAndUrl(t('Create Event'), $url)->toRenderable();

      // Cache
      $build['#cache']['contexts'][] = 'url.path';
      $build['#cache']['tags'][] = 'group:' . $group->id();

    }

    return $build;
  }

}
