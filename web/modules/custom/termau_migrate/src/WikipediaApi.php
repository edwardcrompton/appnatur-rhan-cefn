<?php

namespace Drupal\termau_migrate;

use Drupal\Core\Http\ClientFactory;

/**
 * Fetches data from the wiki API.
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
    'explaintext' => '',
    'redirects' => 1,
  ];

  /**
   *
   * @param type $clientFactory
   */
  public function __construct(ClientFactory $clientFactory) {
    $this->clientFactory = $clientFactory;
    // Get client with default configuration.
    $this->client = $clientFactory->fromOptions();
  }

  /**
   *
   * @param string $langCode
   *   The two letter language code to identify the language when querying wiki.
   */
  public function setLangCode(string $langCode) {
    $this->langCode = $langCode;
    $this->setBaseUri($this->langCode);
  }

  protected function setBaseUri($langCode) {
    $this->uri = 'https://' . $langCode . static::$apiUrl;
  }

  /**
   *
   */
  public function getIntro($title) {
    $query = array_merge(static::$apiQuery, ['titles' => $title]);
    $response = $this->client->request('GET', $this->uri, [
      'headers' => [
        'Content-Type' => 'application/json',
      ],
      'query' => $query,
    ]);
    return $response;
  }
}
