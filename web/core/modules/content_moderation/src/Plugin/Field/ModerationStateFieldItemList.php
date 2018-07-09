<?php

namespace Drupal\content_moderation\Plugin\Field;

use Drupal\content_moderation\Entity\ModerationState;
use Drupal\Core\Field\EntityReferenceFieldItemList;

/**
 * A computed field that provides a content entity's moderation state.
 *
 * It links content entities to a moderation state configuration entity via a
 * moderation state content entity.
 */
class ModerationStateFieldItemList extends EntityReferenceFieldItemList {

  /**
   * Gets the moderation state entity linked to a content entity revision.
   *
   * @return \Drupal\content_moderation\ModerationStateInterface|null
   *   The moderation state configuration entity linked to a content entity
   *   revision.
   */
  protected function getModerationState() {
    $entity = $this->getEntity();

    if (!\Drupal::service('content_moderation.moderation_information')->shouldModerateEntitiesOfBundle($entity->getEntityType(), $entity->bundle())) {
      return NULL;
    }

    if ($entity->id() && $entity->getRevisionId()) {
      $revisions = \Drupal::service('entity.query')->get('content_moderation_state')
        ->condition('content_entity_type_id', $entity->getEntityTypeId())
        ->condition('content_entity_id', $entity->id())
        ->condition('content_entity_revision_id', $entity->getRevisionId())
        ->allRevisions()
        ->sort('revision_id', 'DESC')
        ->execute();

      if ($revision_to_load = key($revisions)) {
        /** @var \Drupal\content_moderation\ContentModerationStateInterface $content_moderation_state */
        $content_moderation_state = \Drupal::entityTypeManager()
          ->getStorage('content_moderation_state')
          ->loadRevision($revision_to_load);

        // Return the correct translation.
        $langcode = $entity->language()->getId();
        if (!$content_moderation_state->hasTranslation($langcode)) {
          $content_moderation_state->addTranslation($langcode);
        }
        if ($content_moderation_state->language()->getId() !== $langcode) {
          $content_moderation_state = $content_moderation_state->getTranslation($langcode);
        }

        return $content_moderation_state->get('moderation_state')->entity;
      }
    }
    // It is possible that the bundle does not exist at this point. For example,
    // the node type form creates a fake Node entity to get default values.
    // @see \Drupal\node\NodeTypeForm::form()
    $bundle_entity = \Drupal::service('content_moderation.moderation_information')
      ->loadBundleEntity($entity->getEntityType()->getBundleEntityType(), $entity->bundle());
    if ($bundle_entity && ($default = $bundle_entity->getThirdPartySetting('content_moderation', 'default_moderation_state'))) {
      return ModerationState::load($default);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function get($index) {
    if ($index !== 0) {
      throw new \InvalidArgumentException('An entity can not have multiple moderation states at the same time.');
    }
 
    // Compute the value of the moderation state.
    if (!isset($this->list[$index]) || $this->list[$index]->isEmpty()) {
      $moderation_state = $this->getModerationState();
      // Do not store NULL values in the static cache.
      if ($moderation_state) {
        $this->list[$index] = $this->createItem($index, ['entity' => $moderation_state]);
=======
    return $this->traitGet($index);
  }

  /**
   * {@inheritdoc}
   */
  public function onChange($delta) {
    $this->updateModeratedEntity($this->list[$delta]->value);

    parent::onChange($delta);
  }

  /**
   * {@inheritdoc}
   */
  public function setValue($values, $notify = TRUE) {
    parent::setValue($values, $notify);

    if (isset($this->list[0])) {
      $this->valueComputed = TRUE;
    }
    // If the parent created a field item and if the parent should be notified
    // about the change (e.g. this is not initialized with the current value),
    // update the moderated entity.
    if (isset($this->list[0]) && $notify) {
      $this->updateModeratedEntity($this->list[0]->value);
    }
  }

  /**
   * Updates the default revision flag and the publishing status of the entity.
   *
   * @param string $moderation_state_id
   *   The ID of the new moderation state.
   */
  protected function updateModeratedEntity($moderation_state_id) {
    $entity = $this->getEntity();

    /** @var \Drupal\content_moderation\ModerationInformationInterface $content_moderation_info */
    $content_moderation_info = \Drupal::service('content_moderation.moderation_information');
    $workflow = $content_moderation_info->getWorkflowForEntity($entity);

    // Change the entity's default revision flag and the publishing status only
    // if the new workflow state is a valid one.
    if ($workflow && $workflow->getTypePlugin()->hasState($moderation_state_id)) {
      /** @var \Drupal\content_moderation\ContentModerationState $current_state */
      $current_state = $workflow->getTypePlugin()->getState($moderation_state_id);

      // This entity is default if it is new, the default revision state, or the
      // default revision is not published.
      $update_default_revision = $entity->isNew()
        || $current_state->isDefaultRevisionState()
        || !$content_moderation_info->isDefaultRevisionPublished($entity);

      $entity->isDefaultRevision($update_default_revision);

      // Update publishing status if it can be updated and if it needs updating.
      $published_state = $current_state->isPublishedState();
      if (($entity instanceof EntityPublishedInterface) && $entity->isPublished() !== $published_state) {
        $published_state ? $entity->setPublished() : $entity->setUnpublished();
      }
    }

    return isset($this->list[$index]) ? $this->list[$index] : NULL;
  }

}
