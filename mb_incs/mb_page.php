<?php

class Page {

  const HOMEPAGE = "home.php";

  private $current_page_path;
  private $current_page_name;
  private $dbcon;

  public function __construct($dbcon, $language, $page_id = null) {

    // Set the database object
    $this->dbcon = $dbcon;

    // If the page id is null, just display the homepage in the language. Otherwise, show the page
    if($page_id == null) {
      $this->set_homepage($language);
    } else {
      $this->set_current_page($page_id, $language);
    }
  }

  private function set_currs($page_name, $page_path) {
    $this->current_page_name = $page_name;
    $this->current_page_path = $page_path;
  }

  /**
   * Set the page to the value passed in, after first performing error checks
   * @param $page_id
   * @return void
   */
  private function set_current_page($page_id, $language) {

    $page_path = "mb_pgs/$page_id.php";

    // Check if the file exists in the shared languages directory
    if(file_exists($page_path)) {
      $this->set_currs($page_id, $page_path);
    } else {
      // Otherwise, if there is the file in the specific languages directory
      $page_path = "mb_pgs/ln_$language/$page_id.php";

      if(file_exists($page_path)) {
        $this->set_currs($page_id, $page_path);
      }
      // Otherwise, display the error page
      else {
        $this->set_error();
      }
    }
  }

  private function set_error() {
    $this->set_currs("error", "mb_pgs/error.php");
  }

  private function set_homepage($language) {
    $this->set_currs(self::HOMEPAGE, "mb_pgs/" . self::HOMEPAGE);
  }

  public function get_current_page_path() {
    return $this->current_page_path;
  }

  public function get_current_page_name() {
    return $this->current_page_name;
  }

}

?>
