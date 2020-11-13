<?php

namespace Drupal\termau_migrate;

interface DataSourceApiInterface {
  public function translate(string $term, string $language);
}
