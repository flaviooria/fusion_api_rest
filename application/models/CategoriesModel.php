<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CategoriesModel extends CI_Model
{
    protected $table = 'fr_categories';

    public $id;
    public $name;


    public function get_categories()
    {
        $query = $this->db->get($this->table)
            ->custom_result_object('CategoriesModel');

        if (isset($query)) {
            foreach ($query as $field) {
                if (isset($field)) {
                    $field -> id = intval($field->id);
                }
            }

            return $query;
        }

        return null;
    }
}
