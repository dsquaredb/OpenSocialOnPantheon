<?php

namespace Drupal\field\Plugin\migrate\source\d7;

use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Drupal 7 field instances source from database.
 *
 * @MigrateSource(
 *   id = "d7_field_instance",
 *   source_provider = "field"
 * )
 */
class FieldInstance extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('field_config_instance', 'fci')
      ->fields('fci')
<<<<<<< HEAD
<<<<<<< HEAD
      ->condition('fci.deleted', 0)
=======
      ->fields('fc', ['type', 'translatable'])
>>>>>>> Update Open Social to 8.x-2.1
=======
      ->fields('fc', ['type'])
>>>>>>> revert Open Social update
      ->condition('fc.active', 1)
      ->condition('fc.deleted', 0)
      ->condition('fc.storage_active', 1)
      ->fields('fc', array('type'));

    $query->innerJoin('field_config', 'fc', 'fci.field_id = fc.id');

    // Optionally filter by entity type and bundle.
    if (isset($this->configuration['entity_type'])) {
      $query->condition('fci.entity_type', $this->configuration['entity_type']);

      if (isset($this->configuration['bundle'])) {
        $query->condition('fci.bundle', $this->configuration['bundle']);
      }
    }

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return array(
      'field_name' => $this->t('The machine name of field.'),
      'entity_type' => $this->t('The entity type.'),
      'bundle' => $this->t('The entity bundle.'),
      'default_value' => $this->t('Default value'),
      'instance_settings' => $this->t('Field instance settings.'),
      'widget_settings' => $this->t('Widget settings.'),
      'display_settings' => $this->t('Display settings.'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $data = unserialize($row->getSourceProperty('data'));

<<<<<<< HEAD
    $row->setSourceProperty('label', $data['label']);
    $row->setSourceProperty('description', $data['description']);
    $row->setSourceProperty('required', $data['required']);

    $default_value = !empty($data['default_value']) ? $data['default_value'] : array();
    if ($data['widget']['type'] == 'email_textfield' && $default_value) {
      $default_value[0]['value'] = $default_value[0]['email'];
      unset($default_value[0]['email']);
=======
    $field_definition = $this->select('field_config', 'fc')
      ->fields('fc')
      ->condition('id', $row->getSourceProperty('field_id'))
      ->execute()
      ->fetch();
    $row->setSourceProperty('field_definition', $field_definition);

    $translatable = FALSE;
    if ($row->getSourceProperty('entity_type') == 'node') {
      // language_content_type_[bundle] may be
      //   - 0: no language support
      //   - 1: language assignment support
      //   - 2: node translation support
      //   - 4: entity translation support
      if ($this->variableGet('language_content_type_' . $row->getSourceProperty('bundle'), 0) == 2) {
        $translatable = TRUE;
      }
    }
    else {
      // This is not a node entity. Get the translatable value from the source
      // field_config table.
      $field_data = unserialize($field_definition['data']);
      $translatable = $field_data['translatable'];
>>>>>>> Update Open Social to 8.x-2.1
    }
    $row->setSourceProperty('default_value', $default_value);

    // Settings.
    $row->setSourceProperty('instance_settings', $data['settings']);
    $row->setSourceProperty('widget_settings', $data['widget']);
    $row->setSourceProperty('display_settings', $data['display']);

    // This is for parity with the d6_field_instance plugin.
    $row->setSourceProperty('widget_type', $data['widget']['type']);

    return parent::prepareRow($row);
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return array(
      'entity_type' => array(
        'type' => 'string',
        'alias' => 'fci',
      ),
      'bundle' => array(
        'type' => 'string',
        'alias' => 'fci',
      ),
      'field_name' => array(
        'type' => 'string',
        'alias' => 'fci',
      ),
    );
  }

}
