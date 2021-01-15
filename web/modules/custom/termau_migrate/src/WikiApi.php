<?php

namespace Drupal\termau_migrate;

use GuzzleHttp\Client;

/**
 * Fetches data from the wiki API.
 */
class WikiApi {

  /**
   * The URL of the API without the language subdomain.
   */
  static $apiUrl = '.wikipedia.org/w/api.php';

  /**
   * The default API query parameters.
   */
  static $apiQuery = [
    'action' => 'query',
    'prop' => 'extracts|pageimages',
    'format' => 'json',
    'exintro' => '',
    'explaintext' => '',
    'redirects' => 1,
  ];

  /**
   * @param type $clientFactory
   */
  public function __construct($langCode, Client $client) {
    // Get client with default configuration.
    $this->client = $client;
    $this->setBaseUri($langCode);
  }

  /**
   * @param string $title
   *   The title of the article to fetch from the wiki.
   *
   * @return \Drupal\termau_migrate\Article
   */
  public function getArticle(string $title) {
    $response = $this->getJsonResponse(['titles' => $title]);
    return new Article(reset($response['query']['pages']));
  }

  /**
   * Queries the wiki via the API and returns a response in json format.
   *
   * @param array $query
   *   An array of query parameters that will be appended to static::$apiQuery.
   *   Any keys in $query that match keys in static::$apiQuery will overwrite
   *   static::$apiQuery.
   */
  protected function getJsonResponse(array $query) {
    $query = array_merge(static::$apiQuery, $query);
    $response = $this->client->request('GET', $this->uri, [
      'headers' => [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
      ],
      'query' => $query,
    ]);
    return json_decode($response->getBody(), TRUE);
  }

  /**
   * @param string $langCode
   *   The two letter language code to use in the base Uri.
   */
  protected function setBaseUri($langCode) {
    $this->uri = 'https://' . $langCode . static::$apiUrl;
  }

}
