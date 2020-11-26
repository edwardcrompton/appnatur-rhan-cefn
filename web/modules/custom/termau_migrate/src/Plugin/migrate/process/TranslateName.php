<?php

namespace Drupal\termau_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\Core\Site\Settings;
use PorthTermau\PorthTermauWrapper;

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
   * @{inheritdoc}
   */
  public function __construct() {
    $this->dataSourceApi = $this->createDataApi();
  }

  /**
   * @{inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    // This will call a method from PorthTermau, e.g,
    $language = 'en';
    //return $this->dataSourceApi->translateTerm($language, $value);
    return $value;
  }

  /**
   * Construct a new Data API instance.
   *
   * @return PortTermau
   *   A PorthTermu API wrapper.
   */
  protected function createDataApi() {
    $options = [
      'key' => Settings::get('termau_migrate_porth_termau_api_key'),
      'referer' => 'http://llennatur.cymru',
    ];
    return new PorthTermauWrapper($options);
  }

}
