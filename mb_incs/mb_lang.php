<?php

class Language {

  const DEFAULT_LN = "en";

  private $language;
  private $dbcon;

  /**
   * If the language given is null, set default. Otherwise, set to language.
   */
  public function __construct($dbcon, $language = null) {

    // Set the database object
    $this->dbcon = $dbcon;

    if($language == null) {
      $this->set_default();
    } else {
      $this->set_language($language);
    }
  }

  public function get_language() {
    return $this->language;
  }
  
  /**
   * Set the language to the value passed in, after first performing error checks
   * @param $ln_string
   * @return void
   */
  private function set_language($ln_string) {

    // If the language exists, use it. Otherwise, set default
    if($this->dbcon->language_exists($ln_string)) {
      $this->language = $ln_string;
    } else {
      $this->set_default();
    }
  }

  public function set_default() {
    $this->language = self::DEFAULT_LN;
  }

}

?>
