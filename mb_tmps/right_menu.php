<ul class="menu nav-menus">
  <?php
    // Get the language in use
    $language = $lang->get_language();

    // Read all menu items for that language
    $menu_items = $dbcon->get_right_menu_items($language);

    // Print the menu
    foreach($menu_items as $item) {

      $menu_link = $item["link"];
      $menu_text = $item["text"];

      // If the item being printed is the current page, underline and don't make a link
      if($item[1] == $page->get_current_page_name()) {
        echo "<li class=\"menu-active listylenone\">$menu_text</li>";
      } else {
        echo "<li class=\"listylenone\"><a href=\"?l=$language&p=$menu_link\">$menu_text</a></li>";
      }
    }
  ?>
</ul>
