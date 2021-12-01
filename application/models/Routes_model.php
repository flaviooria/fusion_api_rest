<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routes_model extends CI_Model {
    public $id;
    public $page;
    public $icon;
    public $active;
    public $title_page;

    public function get_routes()
    {
        $query = $this -> db -> get('routes');

        $result = $query -> custom_row_object(0,'Routes_model');

        if(isset($result)) {
            $result -> id = intval($result -> id);
            $result -> active = boolval($result -> active);
        }

        return $result;
    }
}