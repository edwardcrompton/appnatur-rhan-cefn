<?php

namespace Drupal\species_migrate\Plugin\migrate\source;

use Drupal\migrate_source_csv\Plugin\migrate\source\CSV;
use Drupal\migrate\Row;

/**
 * Use a CSV file containing scientific names as a migration source.
 *
 * @MigrateSource(
 *   id = "species_csv"
 * )
 */
class SpeciesCsv extends CSV {

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $row->setSourceProperty('identifier_en', 'en_wikipedia_identifier');
    $row->setSourceProperty('identifier_cy', 'cy_wikipedia_identifier');
  }
}
