<ul class="menu" id="languages-menu">
  <?php
    // Read all languages in the database
    $menu_langs = $dbcon->get_languages();

    // Get the current page name
    $current_page = $page->get_current_page_name();

    // If the current page is an error, make the language links redirect to the homepage
    if($current_page == "error") {
      $current_page = "home";
    }

    // Print the menu
    foreach($menu_langs as $item) {

      $menu_text = $item["text"];
      $menu_link = $item["id"];

      // Replace the prefix
      $menu_link = str_replace("ln_", "", $menu_link);

      // If the item being printed is the current language, underline and don't make a link
      if($menu_link == $lang->get_language()) {
        echo "<li class=\"menu-active inline listylenone\">$menu_text</li>";
      } else {
        echo "<li class=\"inline listylenone\"><a href=\"?l=$menu_link&p=$current_page\">$menu_text</a></li>";
      }
    }
  ?>
</ul>

<ul class="menu nav-menus" id="top-links">
  <?php
    // Get the language and page in use
    $language = $lang->get_language();
    $current_page = $page->get_current_page_name();

    // Read all menu items for that language
    $menu_items = $dbcon->get_top_menu_items($language);

    // Print the menu
    foreach($menu_items as $item) {

      $menu_text = $item["text"];
      $menu_link = $item["link"];

      // If the item being printed is the current page, underline and don't make a link
      if($menu_link == $current_page) {
        echo "<li class=\"inline menu-active listylenone\">$menu_text</li>";
      } else {
        echo "<li class=\"inline listylenone\"><a href=\"?l=$language&p=$menu_link\">$menu_text</a></li>";
      }

    }
  ?>
</ul>
