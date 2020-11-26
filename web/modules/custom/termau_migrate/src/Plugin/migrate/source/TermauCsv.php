<?php

namespace Drupal\termau_migrate\Plugin\migrate\source;

use Drupal\migrate_source_csv\Plugin\migrate\source\CSV;
use PorthTermau\PorthTermauWrapper;
use Drupal\migrate\Row;
use Drupal\Core\Site\Settings;
use Drupal\migrate\Plugin\MigrationInterface;

/**
 * Use a CSV file as a basis, but fetch additional data from an API.
 *
 * @MigrateSource(
 *   id = "termau_csv"
 * )
 */
class TermauCsv extends CSV {

  /**
   * @{inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);
    $this->api = $this->createDataApi();
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

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    parent::prepareRow($row);
    // Perform an API lookup and add this additional data to the source row.
    $term = $this->api->lookup($row->getSourceProperty('latin'));
    $row->setSourceProperty('term', $term);
  }
}
