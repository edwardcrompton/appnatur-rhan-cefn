<?php

namespace Drupal\termau_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\termau_migrate\DataSourceApiInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
class TranslateName extends ProcessPluginBase implements ContainerFactoryPluginInterface {

  /**
   * {inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, DataSourceApiInterface $dataSourceApi) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->$dataSourceApi = $dataSourceApi;
  }

  /**
   * {inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('termau_migrate.porthtermau')
    );
  }

  /**
   * @{inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // This will call a method from PorthTermau, e.g,
    $language = 'en';
    $this->dataSourceApi->translate($value, $language);
    return $value;
  }

}
