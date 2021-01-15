<?php

namespace Drupal\termau_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\Core\State\StateInterface;

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
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration, StateInterface $state) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration, $state);
    $this->langCode = $configuration['constants']['language'];
    $apiFactory = \Drupal::service('termau_migrate.wikiapifactory');
    $this->api = $apiFactory->create($this->langCode);
  }

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
      'intro' => $this->t('intro'),
    ];
    return $fields;
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

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    parent::prepareRow($row);
    $title = $row->getSourceProperty('name_' . $this->langCode);
    $article = $this->api->getArticle($title);
    $row->setSourceProperty('intro', $article->getIntro());
    $row->setSourceProperty('image_url', $article->getMainImage());
  }
}
