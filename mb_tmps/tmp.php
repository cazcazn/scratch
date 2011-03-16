<!DOCTYPE html>
<html lang="<?php echo $page_language ?>" dir="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <link rel="stylesheet" href="mb_sty/main.css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
  <?php
    if(isset($page_stylesheets)) {
      foreach($page_stylesheets as $stylesheet) {
        echo "<link rel=\"stylesheet\" href=\"mb_sty/$stylesheet\" />";
      }
    }
    if(isset($page_scripts)) {
      foreach($page_scripts as $script) {
        echo "<script type=\"text/javascript\" src=\"mb_scr/$script\"></script>";
      }
    }
  ?>
  <title><?php echo $page_title ?></title>
</head>

<body>
  <div id="body-wrapper" class="clearfix">
    <div id="header" role="banner" class="clearfix">
      <a href="?l=<?php echo $page_language; ?>" title="Home" rel="home" id="logo"></a>
      <div id="top-menu" class="clearfix">
        <?php require_once('top_menu.php'); ?>
      </div>
    </div>

    <div id="content-wrapper" class="clearfix">
      <div id="right-menu" class="clearfix">
        <?php require_once('right_menu.php'); ?>
      </div><!-- right-menu -->

      <div id="content" class="clearfix">
          <?php echo $page_content; ?>
      </div><!-- content -->
    </div><!-- content-wrapper -->
  </div><!-- body-wrapper -->
</body>

</html>
