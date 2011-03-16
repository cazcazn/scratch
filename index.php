<?php

  // Set up database
  require('mb_incs/mb_dbcon.php');
  $dbcon = new Database();

  require('mb_incs/mb_lang.php');
  require('mb_incs/mb_page.php');

  // Set the language variable
  if(isset($_GET['l'])) {
    $lang = new Language($dbcon, $_GET['l']);
  } else {
    $lang = new Language($dbcon);
  }

  // Determine the page being requested
  if(isset($_GET['p'])) {
    $page = new Page($dbcon, $lang->get_language(), $_GET['p']);
  } else {
    $page = new Page($dbcon, $lang->get_language());
  }

  // Include the current page
  include($page->get_current_page_path());

  // Set the page variables
  $page_language = $lang->get_language();

  // Print the template
  require_once('mb_tmps/tmp.php');

?>
