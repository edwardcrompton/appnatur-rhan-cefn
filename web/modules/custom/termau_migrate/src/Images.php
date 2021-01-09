<?php

namespace Drupal\termau_migrate;

/**
 * An image collection from an API response.
 */
class Images {

  /**
   * @var array
   *   An associative array of article data from an API response.
   */
  protected array $images;

  /**
   * @param array $article
   *   An array containing the API response data for the article.
   */
  public function __construct($images) {
    $this->article = $images;
  }

  /**
   * @return string
   *   The introduction text from the article.
   */
  public function getMainImage() {
    return $this->article['thumbnail']['source'];
  }


}
