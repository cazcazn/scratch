<?php
  $page_title = "Gallery";
  $page_stylesheets = array("gallery.css");
  $page_language = $lang->get_language();

  // Read all the images from the database
  $images = $dbcon->get_thumbnail_info();

  // Start ul
  $page_content = "<ul>";

  foreach($images as $item) {
    $im_thumb_src = "mb_ims/thumbnails/$item[0].gif";
    $im_big_url = "?l=$page_language&p=imageview&i=$item[0]";
    $page_content .= "<div class=\"thumbnail\">" . "<li class=\"listylenone\">";
    $page_content .= "<a href=\"$im_big_url\"><center>";
    $page_content .= "<img src=\"$im_thumb_src\" /></center>" . "</a>";
    $page_content .= $item[1] . "</li>" . "</div>";
  }

  // End ul
  echo "</ul>";
?>
