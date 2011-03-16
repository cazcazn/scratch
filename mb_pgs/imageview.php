<?php
  $page_scripts = array("imageview.js");
  $page_stylesheets = array("imageview.css");

  // Set the size of the rectangle to appear. MUST match the css.
  $tag_facebox_width = 44;

  // If there is an image being queried, store its value. Otherwise, redirect back to gallery
  if(isset($_GET['i'])) {
    $image_id = $_GET['i'];
  } else {
//TODO
    // Redirect back to the gallery
    $page_content = "Redirecting p";
  }

  $image_path = "mb_ims/$image_id.jpg";

  // If the file doesn't exist, redirect back to the gallery
  if(!file_exists($image_path)) {
//TODO
  }

  // Prepare the html
  $page_content = "<img src=\"$image_path\" id=\"imgview\">";
  $page_content .= "<div id=\"tag_box\">";
  $page_content .= "<div id=\"tag_facebox\"></div>";
  $page_content .= "<div id=\"tag_box_input\">Type a name to tag:<br />";
  $page_content .= "<input type=\"text\" id=\"tag_textbox\"></input>";
  $page_content .= "</div></div>";

  // Read all the currently existing tags from the database and print them
  $tag_cache = array();
  $tag_names = $dbcon->get_tags_from_filename($image_id);
  $facebox_index = 0;

  // Display the names
  foreach($tag_names as $tag) {
    $tag_left = $tag['x'] - $tag_facebox_width/2 . "px";
    $tag_top = $tag['y'] - $tag_facebox_width/2 . "px";
    $tag_cache[] = $tag['name'];
    $page_content .= "<div class=\"facebox\" id=\"facebox$facebox_index\" style=\"top: $tag_top; left: $tag_left;\"></div>";
    $facebox_index++;
  }
  
  $page_content .= "<div id=\"tag_names\">";

  $name_index = 0;

  foreach($tag_cache as $name) {
    $page_content .= "<span class=\"tag_name\" id=\"tag_name$name_index\">$name</span>";
    $name_index++;
  }
?>
