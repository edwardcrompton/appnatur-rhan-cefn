<?php

namespace Drupal\termau_migrate;

/**
 * An article object from an API response.
 */
class Article {

  /**
   * @var array
   *   An associative array of article data from an API response.
   */
  protected array $article;

  /**
   * @param array $article
   *   An array containing the API response data for the article.
   */
  public function __construct($article) {
    $this->article = $article;
  }

  /**
   * @return string
   *   The introduction text from the article.
   */
  public function getIntro() {
    return $this->article['extract'];
  }

}
