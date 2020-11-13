<?php

namespace Drupal\termau_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Perform custom value transformations.
 *
 * @MigrateProcessPlugin(
 *   id = "translate_name"
 * )
 *
 * To do custom name translations use the following:
 *
 * @code
 * field_text:
 *   plugin: translate_name
 *   source: text
 * @endcode
 *
 */
class TranslateName extends ProcessPluginBase {

  /**
   * {inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, PorthTermauInterface $termauApi) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    // We need to write a composer package for PorthTermau and then import it.
    // Then we'll work out how to inject it here.
    $this->$termauApi = $termauApi;
  }

  /**
   * @{inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // This will call a method from PorthTermau, e.g,
    // $this->termauApi->translate($term, language);
    return $value;
  }
}
