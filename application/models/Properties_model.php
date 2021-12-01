<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_model extends CI_Model {
    public $id;
    public $primary_color;
    public $font_size;

    public function get_properties()
    {
        $query = $this -> db -> get('properties');

        $result = $query -> custom_row_object(0,'Properties_model');

        if(isset($result)) {
            $result -> id = intval($result -> id);
            $result -> font_size = floatval(($result -> font_size));
        }

        return $result;
    }
}