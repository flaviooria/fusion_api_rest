<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductsModel extends CI_Model
{
    protected $table = 'fr_products';

    public $id;
    public $name;
    public $price;
    public $photo;
    public $average;
    public $onSale;
    public $discount;
    public $ingredients;
    public $description;
    public $categorie;

    public function get_products()
    {
        $query = $this->db->get($this->table)
            ->custom_result_object('ProductsModel');

        if (isset($query)) {
            foreach ($query as $field) {
                if (isset($field)) {
                    $field->id = intval($field->id);
                    $field->price = floatval($field->price);
                    $field->average = floatval($field->average);
                    $field->onSale = boolval($field->onSale);
                    $field->discount = floatval($field->discount);
                    $field->categorie = intval($field->categorie);
                }
            }
            return $query;
        }

        return null;
    }


    /**
     * @var $id_categorie is id of categories in table database
     */
    public function get_products_by_categorie($id_categorie)
    {


        $query = $this->db->select('fp.*')
            ->from('fr_products fp')
            ->join('fr_categories_products_id fcp', 'fp.id = fcp.id_product')
            ->where('fcp.id_categorie', (int) $id_categorie)
            ->get()
            ->custom_result_object('ProductsModel');

        if (isset($query)) {
            if (empty($query)) {
                return null;
            }

            foreach ($query as $field) {
                if (isset($field)) {
                    $field->id = intval($field->id);
                    $field->price = floatval($field->price);
                    $field->average = floatval($field->average);
                    $field->onSale = boolval($field->onSale);
                    $field->discount = floatval($field->discount);
                    $field->categorie = intval($field->categorie);
                }
            }
            return $query;
        }

        return null;
    }

    /**
     * @var $per_page is the number of product to show in the response
     * @var $from is the offset in the query from database
     */
    public function get_products_pagination($per_page, $from)
    {
        //Generate query
        $query = $this->db->get($this->table, $per_page, $from)
            ->custom_result_object('ProductsModel');

        if (isset($query)) {
            if (empty($query)) {
                return null;
            }

            foreach ($query as $field) {
                if (isset($field)) {
                    $field->id = intval($field->id);
                    $field->price = floatval($field->price);
                    $field->average = floatval($field->average);
                    $field->onSale = boolval($field->onSale);
                    $field->discount = floatval($field->discount);
                    $field->categorie = intval($field->categorie);
                }
            }
            return $query;
        }

        return null;
    }

    public function get_products_onSale()
    {
        $query = $this->db->get_where($this->table, array('onSale' => 1))
            ->custom_result_object('ProductsModel');

        if (isset($query)) {
            if (empty($query)) {
                return null;
            }

            foreach ($query as $field) {
                if (isset($field)) {
                    $field->id = intval($field->id);
                    $field->price = floatval($field->price);
                    $field->average = floatval($field->average);
                    $field->onSale = boolval($field->onSale);
                    $field->discount = floatval($field->discount);
                    $field->categorie = intval($field->categorie);
                }
            }
            return $query;
        }

        return null;
    }

    public function get_products_by_name($name)
    {
        $query = $this->db->select('*')
            ->like('name', $name)
            ->get($this->table)
            ->custom_result_object('ProductsModel');

        if (isset($query)) {
            if (empty($query)) {
                return null;
            }

            foreach ($query as $field) {
                if (isset($field)) {
                    $field->id = intval($field->id);
                    $field->price = floatval($field->price);
                    $field->average = floatval($field->average);
                    $field->onSale = boolval($field->onSale);
                    $field->discount = floatval($field->discount);
                    $field->categorie = intval($field->categorie);
                }
            }
            return $query;
        }

        return null;
    }
}
