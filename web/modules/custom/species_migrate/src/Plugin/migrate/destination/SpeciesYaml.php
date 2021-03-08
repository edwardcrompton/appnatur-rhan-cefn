<?php

namespace Drupal\species_migrate\Plugin\migrate\destination;

use Drupal\migrate\Plugin\migrate\destination\DestinationBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\Event\ImportAwareInterface;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Event\MigrateImportEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\migrate\Row;

/**
 * @MigrateDestination(
 *   id = "yaml"
 * )
 */
class SpeciesYaml extends DestinationBase implements ContainerFactoryPluginInterface, ImportAwareInterface {

  /**
   * Constructs a new Yaml file.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\migrate\Plugin\MigrationInterface $migration
   *   The migration.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration) {
    var_dump($configuration);
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);

    $this->idFields = $configuration['id_fields'];
    $this->fields = isset($configuration['fields']) ? $configuration['fields'] : [];
    $this->batchSize = isset($configuration['batch_size']) ? $configuration['batch_size'] : 1;
    $this->supportsRollback = TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function import(Row $row, array $old_destination_id_values = []) {
    var_dump($row);
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    if (empty($this->idFields)) {
      throw new MigrateException('Id fields are required for a table destination');
    }
    return $this->idFields;
  }

  /**
   * {@inheritdoc}
   */
  public function fields(MigrationInterface $migration = NULL) {
    return $this->fields;
  }

    /**
   * {@inheritDoc}
   */
  public function preImport(MigrateImportEvent $event) {
  }

  /**
   * {@inheritDoc}
   */
  public function postImport(MigrateImportEvent $event) {
    // At the conclusion of a given migration, make sure batched inserts go in.
    $this->flushInserts();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration = NULL) {

  }

}
