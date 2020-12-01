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
    $this->language = $configuration['constants']['language'];
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
    // Add the whole term object to the row in case we need it.
    $row->setSourceProperty('term', $term);
    // Break out the title from the term object and add it as a source property.
    $row->setSourceProperty('title', $term->getTitle($this->language));
    // Get the article source URL.
    $row->setSourceProperty('url', $term->getUrl());
  }
}
