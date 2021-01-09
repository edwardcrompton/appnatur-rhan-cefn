<?php

namespace Drupal\termau_migrate;

use Drupal\Core\Http\ClientFactory;

/**
 * Helper class to configure a Wiki API.
 */
class WikiApiFactory {

  /**
   * @param ClientFactory $clientFactory
   */
  public function __construct(ClientFactory $clientFactory) {
    $this->client = $clientFactory->fromOptions();
  }

  /**
   * @param string $langCode
   *   The two letter language code for the api.
   *
   * @return \Drupal\termau_migrate\WikiApi
   */
  public function create(string $langCode) {
    return new WikiApi($langCode, $this->client);
  }
}
