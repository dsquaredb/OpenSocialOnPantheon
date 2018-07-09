<?php

namespace Drupal\migrate\Plugin\migrate\destination;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\migrate\MigrateException;
use Drupal\migrate\Row;

/**
 * Provides entity revision destination plugin.
 *
 * @MigrateDestination(
 *   id = "entity_revision",
 *   deriver = "Drupal\migrate\Plugin\Derivative\MigrateEntityRevision"
 * )
 */
class EntityRevision extends EntityContentBase {

  /**
   * {@inheritdoc}
   */
  protected static function getEntityTypeId($plugin_id) {
    // Remove entity_revision:
    return substr($plugin_id, 16);
  }

  /**
   * Gets the entity.
   *
   * @param \Drupal\migrate\Row $row
   *   The row object.
   * @param array $old_destination_id_values
   *   The old destination IDs.
   *
   * @return \Drupal\Core\Entity\EntityInterface|false
   *   The entity or false if it can not be created.
   */
  protected function getEntity(Row $row, array $old_destination_id_values) {
    $revision_id = $old_destination_id_values ?
      reset($old_destination_id_values) :
      $row->getDestinationProperty($this->getKey('revision'));
    if (!empty($revision_id) && ($entity = $this->storage->loadRevision($revision_id))) {
      $entity->setNewRevision(FALSE);
    }
    else {
      $entity_id = $row->getDestinationProperty($this->getKey('id'));
      $entity = $this->storage->load($entity_id);

      // If we fail to load the original entity something is wrong and we need
      // to return immediately.
      if (!$entity) {
        return FALSE;
      }

      $entity->enforceIsNew(FALSE);
      $entity->setNewRevision(TRUE);
    }
    // We need to update the entity, so that the destination row IDs are
    // correct.
    $entity = $this->updateEntity($entity, $row);
    $entity->isDefaultRevision(FALSE);
    return $entity;
  }

  /**
   * {@inheritdoc}
   */
  protected function save(ContentEntityInterface $entity, array $old_destination_id_values = array()) {
    $entity->save();
    return array($entity->getRevisionId());
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    if ($key = $this->getKey('revision')) {
      $ids[$key]['type'] = 'integer';
      return $ids;
=======
=======
>>>>>>> updating open social
    $ids = [];

    $revision_key = $this->getKey('revision');
    if (!$revision_key) {
      throw new MigrateException(sprintf('The "%s" entity type does not support revisions.', $this->storage->getEntityTypeId()));
<<<<<<< HEAD
>>>>>>> Update Open Social to 8.x-2.1
=======
    if ($key = $this->getKey('revision')) {
      return [$key => $this->getDefinitionFromEntity($key)];
>>>>>>> revert Open Social update
=======
>>>>>>> updating open social
    }
    $ids[$revision_key] = $this->getDefinitionFromEntity($revision_key);

    if ($this->isTranslationDestination()) {
      $langcode_key = $this->getKey('langcode');
      if (!$langcode_key) {
        throw new MigrateException(sprintf('The "%s" entity type does not support translations.', $this->storage->getEntityTypeId()));
      }
      $ids[$langcode_key] = $this->getDefinitionFromEntity($langcode_key);
    }

    return $ids;
  }

}
