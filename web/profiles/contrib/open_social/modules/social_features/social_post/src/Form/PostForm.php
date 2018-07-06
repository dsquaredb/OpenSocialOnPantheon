<?php

namespace Drupal\social_post\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Post edit forms.
 *
 * @ingroup social_post
 */
class PostForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'social_post_entity_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
<<<<<<< HEAD
<<<<<<< HEAD
    // Retrieve the form display before it is overwritten in the parent.
=======
    // Init form mode comparison strings.
    $this->setFormMode();

    // If we're rendered in a block and given a display mode then we store it
    // now because it's overwritten by ContentEntityForm::init().
>>>>>>> Update Open Social to 8.x-2.1
=======
    // Init form modes.
    $this->setFormMode();

>>>>>>> revert Open Social update
    $display = $this->getFormDisplay($form_state);
    $form = parent::buildForm($form, $form_state);
    $form['#attached']['library'][] = 'social_post/visibility-settings';
    $form['#attached']['library'][] = 'social_post/keycode-submit';
    // Default is create/add mode.
    $form['field_visibility']['widget'][0]['#edit_mode'] = FALSE;

<<<<<<< HEAD
<<<<<<< HEAD
    if (isset($display)) {
      $this->setFormDisplay($display, $form_state);
    }
    else {
      $visibility_value = $this->entity->get('field_visibility')->value;
      $display_id = ($visibility_value === '0') ? 'post.post.profile' : 'post.post.default';
      $display = EntityFormDisplay::load($display_id);
      // Set the custom display in the form.
      $this->setFormDisplay($display, $form_state);
    }

    if (isset($display) && ($display_id = $display->get('id'))) {
      if ($display_id === 'post.post.default') {
        // Set default value to community.
        // Remove recipient option.
        // Only needed for 'private' permissions which we do not support yet.
        unset($form['field_visibility']['widget'][0]['#options'][0]);
        $form['field_visibility']['widget'][0]['#default_value'] = "2";
      }
      else {
        // Remove public option from options.
        $form['field_visibility']['widget'][0]['#default_value'] = "0";
        unset($form['field_visibility']['widget'][0]['#options'][1]);
        unset($form['field_visibility']['widget'][0]['#options'][2]);
=======
    // If we already have a form display mode then we simply restore that.
    if (!empty($display)) {
      $this->setFormDisplay($display, $form_state);
    }
    // If we are editing a post then the default view mode is used but we have
    // to use the view mode that was originally used instead.
    elseif ($this->operation === 'edit') {
      $this->configureViewMode($form_state);
    }

    // If this post has a visibility field then we configure its allowed values.
=======
>>>>>>> revert Open Social update
    if (isset($form['field_visibility'])) {
      $form['#attached']['library'][] = 'social_post/visibility-settings';

      // Default is create/add mode.
      $form['field_visibility']['widget'][0]['#edit_mode'] = FALSE;

      if (isset($display)) {
        $this->setFormDisplay($display, $form_state);
      }
      else {
<<<<<<< HEAD
        $form['field_visibility']['widget'][0]['#default_value'] = '2';
>>>>>>> Update Open Social to 8.x-2.1
      }
    }

<<<<<<< HEAD
    // Do some alterations on this form.
    if ($this->operation == 'edit') {
      /** @var \Drupal\social_post\Entity\Post $post */
      $post = $this->entity;
      $form['#post_id'] = $post->id();

      // In edit mode we don't want people to actually change visibility setting
      // of the post.
      if ($current_value = $this->entity->get('field_visibility')->value) {
        // We set the default value.
        $form['field_visibility']['widget'][0]['#default_value'] = $current_value;
=======
      unset($form['field_visibility']['widget'][0]['#options'][3]);
    }
    // If we're not posting to the community then the visibility depends on the
    // group type (if it's a group post) or it's simply limited to the community
    // for user posts.
    else {
      $form['field_visibility']['widget'][0]['#default_value'] = "0";
      unset($form['field_visibility']['widget'][0]['#options'][2]);

      $current_group = NULL;
      if ($this->operation === 'edit' && $this->entity->hasField('field_recipient_group') && !$this->entity->get('field_recipient_group')->isEmpty()) {
        $current_group = $this->entity->get('field_recipient_group')->first()->get('entity')->getTarget()->getValue();
      }
      else {
        $current_group = _social_group_get_current_group();
      }

      // We unset the group visibility if we don't have a group.
      if (empty($current_group)) {
        unset($form['field_visibility']['widget'][0]['#options'][3]);
=======
        $visibility_value = $this->entity->get('field_visibility')->value;
        $display_id = ($visibility_value === '0') ? $this->postViewProfile : $this->postViewDefault;
        $display = EntityFormDisplay::load($display_id);
        // Set the custom display in the form.
        $this->setFormDisplay($display, $form_state);
>>>>>>> revert Open Social update
      }

      if (isset($display) && ($display_id = $display->get('id'))) {
        if ($display_id === $this->postViewDefault) {
          // Set default value to community.
          unset($form['field_visibility']['widget'][0]['#options'][0]);

          if (isset($form['field_visibility']['widget'][0]['#default_value'])) {
            $default_value = $form['field_visibility']['widget'][0]['#default_value'];

            if ((string) $default_value !== '1') {
              $form['field_visibility']['widget'][0]['#default_value'] = '2';
            }
          }
          else {
            $form['field_visibility']['widget'][0]['#default_value'] = '2';
          }

          unset($form['field_visibility']['widget'][0]['#options'][3]);
        }
        else {
          $form['field_visibility']['widget'][0]['#default_value'] = "0";
          unset($form['field_visibility']['widget'][0]['#options'][2]);

          $current_group = _social_group_get_current_group();
          if (!$current_group) {
            unset($form['field_visibility']['widget'][0]['#options'][3]);
          }
          else {
            $group_type_id = $current_group->getGroupType()->id();
            $allowed_options = social_group_get_allowed_visibility_options_per_group_type($group_type_id);
            if ($allowed_options['community'] !== TRUE) {
              unset($form['field_visibility']['widget'][0]['#options'][0]);
            }
            if ($allowed_options['public'] !== TRUE) {
              unset($form['field_visibility']['widget'][0]['#options'][1]);
            }
            else {
              $form['field_visibility']['widget'][0]['#default_value'] = "1";
            }
            if ($allowed_options['group'] !== TRUE) {
              unset($form['field_visibility']['widget'][0]['#options'][3]);
            }
            else {
              $form['field_visibility']['widget'][0]['#default_value'] = "3";
            }
          }

        }
>>>>>>> Update Open Social to 8.x-2.1
      }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    // When a post is being edited we configure the visibility to be shown as a
    // read-only value.
    if ($this->operation == 'edit') {
      /** @var \Drupal\social_post\Entity\Post $post */
      $post = $this->entity;
      $form['#post_id'] = $post->id();

      // In edit mode we don't want people to actually change visibility
      // setting of the post.
      if ($current_value = $this->entity->get('field_visibility')->value) {
        // We set the default value.
        $form['field_visibility']['widget'][0]['#default_value'] = $current_value;
      }

>>>>>>> Update Open Social to 8.x-2.1
      // Unset the other options, because we do not want to be able to change
      // it but we do want to use the button for informing the user.
      foreach ($form['field_visibility']['widget'][0]['#options'] as $key => $option) {
        if ($option['value'] != $form['field_visibility']['widget'][0]['#default_value']) {
          unset($form['field_visibility']['widget'][0]['#options'][$key]);
        }
      }
<<<<<<< HEAD

      // Set button to disabled in our template, users have no option anyway.
      $form['field_visibility']['widget'][0]['#edit_mode'] = TRUE;
    }
=======
>>>>>>> Update Open Social to 8.x-2.1
=======
      // Do some alterations on this form.
      if ($this->operation == 'edit') {
        /** @var \Drupal\social_post\Entity\Post $post */
        $post = $this->entity;
        $form['#post_id'] = $post->id();

        // In edit mode we don't want people to actually change visibility
        // setting of the post.
        if ($current_value = $this->entity->get('field_visibility')->value) {
          // We set the default value.
          $form['field_visibility']['widget'][0]['#default_value'] = $current_value;
        }

        // Unset the other options, because we do not want to be able to change
        // it but we do want to use the button for informing the user.
        foreach ($form['field_visibility']['widget'][0]['#options'] as $key => $option) {
          if ($option['value'] != $form['field_visibility']['widget'][0]['#default_value']) {
            unset($form['field_visibility']['widget'][0]['#options'][$key]);
          }
        }
>>>>>>> revert Open Social update

        // Set button to disabled in our template, users have no option anyway.
        $form['field_visibility']['widget'][0]['#edit_mode'] = TRUE;
      }
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $display = $this->getFormDisplay($form_state);

<<<<<<< HEAD
<<<<<<< HEAD
    if (isset($display) && ($display_id = $display->get('id'))) {
      if ($display_id === 'post.post.profile') {
        $account_profile = \Drupal::routeMatch()->getParameter('user');
        $this->entity->get('field_recipient_user')->setValue($account_profile);
      }
      elseif ($display_id === 'post.post.group') {
        $group = \Drupal::routeMatch()->getParameter('group');
        $this->entity->get('field_recipient_group')->setValue($group);
=======
    if ($this->entity->isNew()) {
      if (isset($display) && ($display_id = $display->get('id'))) {
        if ($display_id === $this->postViewProfile) {
          $account_profile = \Drupal::routeMatch()->getParameter('user');
          $this->entity->get('field_recipient_user')->setValue($account_profile);
        }
        elseif ($display_id === $this->postViewGroup) {
          $group = \Drupal::routeMatch()->getParameter('group');
          $this->entity->get('field_recipient_group')->setValue($group);
        }
>>>>>>> Update Open Social to 8.x-2.1
=======
    if (isset($display) && ($display_id = $display->get('id'))) {
      if ($display_id === $this->postViewProfile) {
        $account_profile = \Drupal::routeMatch()->getParameter('user');
        $this->entity->get('field_recipient_user')->setValue($account_profile);
      }
      elseif ($display_id === $this->postViewGroup) {
        $group = \Drupal::routeMatch()->getParameter('group');
        $this->entity->get('field_recipient_group')->setValue($group);
>>>>>>> revert Open Social update
      }
    }

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Your post %label has been posted.', [
          '%label' => $this->entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Your post %label has been saved.', [
          '%label' => $this->entity->label(),
        ]));
    }
  }

}
