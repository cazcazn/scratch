<?php
  $page_title = "Home";
  $page_stylesheets = array("home.css");
  $page_scripts = array("home.js");
  $page_content = "<div id=\"slideshow\">";

  // Get all the slideshow images from the database
  $slideshow_images = $dbcon->get_slideshow_images();

  $activeclass = "class = \"active\"";

  foreach($slideshow_images as $image) {
    $page_content .= "<div $activeclass><img src=\"mb_ims/$image[0].jpg\" />$image[1]</div>";
    $activeclass = "";
  }

  $page_content .= "</div>";

?>
