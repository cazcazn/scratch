<?php
  // Get the post data sent
  if(isset($_POST['filename']) && isset($_POST['tagname']) && isset($_POST['x']) && isset($_POST['y'])) {

    require_once('../mb_incs/mb_dbcon.php');
    $db = new Database();

    $filename = $_POST['filename'];
    $tagname = $_POST['tagname'];
    $x = $_POST['x'];
    $y = $_POST['y'];

    $filename = basename($filename, ".jpg");
    $db->add_tag_to_image($filename, $x, $y, $tagname);
    echo $db->get_tags_from_filename($filename);
  }
?>
