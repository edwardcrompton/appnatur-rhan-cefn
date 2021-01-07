<?php

namespace Drupal\termau_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
//use Drupal\migrate\Row;

/**
 * Use a prepopulated table as the source.
 *
 * @MigrateSource(
 *   id = "termau_table"
 * )
 */
class TermauTable extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Source data is queried from 'termau_migrate_porthtermau_data' table.
    $query = $this->select('termau_migrate_porthtermau_data', 'd')
      ->fields('d', [
          'id',
          'scientific_name',
          'name_cy',
          'name_en',
          'url',
        ]);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('id' ),
      'scientific_name' => $this->t('scientific_name'),
      'name_cy' => $this->t('name_cy'),
      'name_en' => $this->t('name_en'),
      'url' => $this->t('url'),
      'intro' => $this->getIntro(),
    ];
    return $fields;
  }

  /**
   * @return string
   *   The intro from the wikipedia article.
   */
  public function getIntro() {
    // Get the intro from wikipedia using
    Drupal::service('termau_migrate.wikiapi');
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'd',
      ],
    ];
  }
}
