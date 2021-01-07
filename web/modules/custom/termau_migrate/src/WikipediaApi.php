<?php

namespace Drupal\termau_migrate;

use \Drupal\Core\Http\ClientFactory;

/**
 * Interfaces with the Wikipedia API to fetch data.
 */
class WikipediaApi {

  /**
   *
   */
  static $apiUrl = '.wikipedia.org/w/api.php';

  /**
   *
   */
  static $apiQuery = [
    'action' => 'query',
    'prop' => 'extracts',
    'format' => 'json',
    'exintro' => '',
  ];

  /**
   *
   * @param type $clientFactory
   */
  public function __construct(ClientFactory $clientFactory) {
    $this->langCode = 'en';
    // @todo: Need a way of updating the base_uri when the langcode is changed
    // here.
    try {
      $this->client = $clientFactory->fromOptions([
        'base_uri' => 'https://' . $this->langCode . static::$apiUrl,
        'headers' => [
          'Content-Type' => 'application/json',
        ],
      ]);
    }
    catch (RequestException $e) {
      watchdog_exception('termau_migrate', $e);
    }
  }

  /**
   *
   * @param string $langCode
   *   The two letter language code to identify the language when querying wiki.
   */
  public function setLangCode(string $langCode) {
    $this->langCode = $langCode;
  }


  public function getIntro() {

  }
}
