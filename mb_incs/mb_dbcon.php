<?php
  class Database {

    private $dbo;

    // Define the database credentials
    private $user = "gn_usr";
    private $password = "gn_mb_pwd";
    private $host = "localhost";
    private $database = "martinb";

    // Define the names of the tables in the database
    private $t_languages = "tb_lngs";
    private $t_images = "tb_ims";
    private $t_menus = "tb_mns";
    private $t_tags = "tb_tags";

    /**
     * Check to see if a given language is in the database
     * @param language
     * @return boolean
     */
    public function language_exists($language) {

      // Define the query
      $query = "SELECT lng_id FROM $this->t_languages WHERE lng_id=:ln";

      // Assign the parameter in the arguments array
      $arguments = array(
          "ln" => "ln_" . $language
      );

      // Execute the query
      return $this->query($query, $arguments) != NULL;
    }

    /**
     * Get menu items for the top menu
     * @param string language
     * @return array results
     */
    public function get_top_menu_items($language) {
      return $this->get_menu_items($language, "top");
    }

    /**
     * Get menu items for the right menu
     * @param string language set
     * @return array results
     */
    public function get_right_menu_items($language) {
      return $this->get_menu_items($language, "rig");
    }

    /**
     * Function to get menu items so only one query has to be changed
     * @param string language in use
     * @param string place menu is
     * @return array results
     */
    private function get_menu_items($language, $place) {
      $query = "SELECT mn_text AS text, mn_link AS link FROM $this->t_menus WHERE lng_id='ln_$language' AND mn_place='$place' ORDER BY mn_place";
      return $this->query($query);
    }

    /**
     * Get languages in the database
     * @return array results
     */
    public function get_languages() {
      $query = "SELECT lng_id AS id, description AS text FROM $this->t_languages";
      return $this->query($query);
    }

    /**
     * Get thumbnail info from database
     * @return array results
     */
    public function get_thumbnail_info() {
      $query = "SELECT im_fname, im_title FROM $this->t_images";
      return $this->query($query);
    }

    /**
     * Get all images in the database and their info
     * @return array results
     */
    public function get_images() {
      $query = "SELECT im_fname, im_title, im_year, im_placetaken FROM $this->t_images";
      return $this->query($query);
    }

    /**
     * Get slideshow images in the database
     * @return array results
     */
    public function get_slideshow_images() {
      $query = "SELECT im_fname, im_title FROM $this->t_images WHERE im_slideshow=1";
      return $this->query($query);
    }

    /**
     * Get tag names in the database according to image name
     * @return array results
     */
    public function get_tags_from_filename($image_id) {
      $query = "SELECT tg_x AS x, tg_y AS y, tg_person AS name FROM $this->t_tags WHERE im_fname=:fname ORDER BY x, y";

      // Assign the parameter in the arguments array
      $arguments = array(
          "fname" => $image_id
      );

      return $this->query($query, $arguments);
    }

    /**
     * Add tag to supplied image filename
     * @param filename
     * @param tagname
     * @param x
     * @param y
     * @return array results
     */
    public function add_tag_to_image($image_id, $x, $y, $person) {
      $query = "SELECT COUNT( * ) AS count FROM $this->t_images WHERE im_fname = :fname";
      $arguments = array(
        "fname"=>$image_id
      );

      $result = $this->query($query, $arguments);

      if($result[0]["count"] > 0) {
        $query = "INSERT INTO $this->t_tags (`id`, `im_fname`, `tg_x`, `tg_y`, `tg_person`) VALUES (NULL, :fname, :x, :y, :person)";
        $arguments = array(
          "fname"=>$image_id,
          "x"=>$x,
          "y"=>$y,
          "person"=>$person
        );
        $this->query($query, $arguments);
        return true;
      }
      return false;
    }

    /**
     * Run the query using PDO defined in the sql, and assign the arguments in the arguments array
     * @params sql arguments
     * @return database results object
     */ 
    private function query($sql, $arguments = null) {

      // Try opening the database connection
      try {
        $dbo = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
      } catch(PDOException $e)
      {
        return $e->getMessage();
      }

      // Prepare and execute the sql query
      $prep = $dbo->prepare($sql);
      $prep->execute($arguments);

      // Return all the results
      return $prep->fetchAll();
    }
  }
?>
