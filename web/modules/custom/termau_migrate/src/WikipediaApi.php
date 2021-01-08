<?php

namespace Drupal\termau_migrate;

use Drupal\Core\Http\ClientFactory;

/**
 * Fetches data from the wiki API.
 */
class WikipediaApi {

  /**
   * The URL of the API without the language subdomain.
   */
  static $apiUrl = '.wikipedia.org/w/api.php';

  /**
   * The default API query parameters.
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
   * @param type $clientFactory
   */
  public function __construct(ClientFactory $clientFactory) {
    // Get client with default configuration.
    $this->client = $clientFactory->fromOptions();
  }

  /**
   * @param string $langCode
   *   The two letter language code to identify the language when querying wiki.
   */
  public function setLangCode(string $langCode) {
    $this->langCode = $langCode;
    $this->setBaseUri($this->langCode);
  }

  /**
   * @param string $langCode
   *   The two letter language code to use in the base Uri.
   */
  protected function setBaseUri($langCode) {
    $this->uri = 'https://' . $langCode . static::$apiUrl;
  }

  /**
   * @param string $title
   *   The title of the article to fetch from the wiki.
   *
   * @return string
   *   The introduction text from the article.
   */
  public function getIntro($title) {
    $article = $this->getArticle($title);
    return $article['extract'];
  }

  /**
   * @param string $title
   *   The title of the article to fetch from the wiki.
   *
   * @return array
   *   An array of properties of the article.
   */
  protected function getArticle(string $title) {
    $response = $this->getJsonResponse(['titles' => $title]);
    return reset($response['query']['pages']);
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
    if (empty($this->langCode)) {
      throw new \Exception('langCode property must be set with setLangCode() before making a request.');
    }

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
}
