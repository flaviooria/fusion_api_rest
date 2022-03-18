<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Products extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        //load database
        $this->load->database();
        //load model
        $this->load->model('ProductsModel');
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE,OPTIONS");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
    }

    public function all_get()
    {
        $products = $this->ProductsModel->get_products();

        //If not exists data in products
        if (!isset($products)) {
            $res = array(
                'err' => true,
                'products' => null
            );

            $this->response($res, self::HTTP_INTERNAL_SERVER_ERROR);

            return $res;
        } else {
            $res = array(
                'err' => false,
                'products' => $products
            );

            $this->response($res, self::HTTP_OK);

            return $res;
        }
    }

    public function products_categories_get($id_category)
    {
        $products = $this->ProductsModel->get_products_by_categorie($id_category);

        //If not exists data in products
        if (!isset($products)) {
            $res = array(
                'err' => true,
                'products' => null
            );

            $this->response($res, self::HTTP_INTERNAL_SERVER_ERROR);

            return $res;
        } else {
            $res = array(
                'err' => false,
                'products' => $products
            );

            $this->response($res, self::HTTP_OK);

            return $res;
        }
    }

    public function pagination_get()
    {
        $page = $this->uri->segment(3);
        $per_page = $this->uri->segment(4);

        if (!isset($page)) {
            $page = 1;
        }

        if (!isset($per_page)) {
            $per_page = 5;
        }

        $total_products = $this->db->count_all('fr_products');
        $total_page = ceil($total_products / $per_page);

        //If page not exists,return tha last page
        if ($page > $total_page) {
            $page = $total_page;
        }

        $page -= 1;
        $from = $page * $per_page;

        //Calculation the page prev
        if ($page >= $total_page - 1) {
            $next_page = 1;
        } else {
            $next_page = $page + 2;
        }

        //Calculate prev page
        if ($page < 1) {
            $prev_page = $total_page;
        } else {
            $prev_page = $page;
        }

        //Generate query
        $products = $this->ProductsModel->get_products_pagination($per_page, $from);

        $res = array(
            'err' => false,
            'total products' => $total_products,
            'total pages' => $total_page,
            'actual page' => $page + 1,
            'next page' => $next_page == 1 ? null : $next_page,
            'prev page' => $prev_page == $total_page ? null : $prev_page,
            'products' => $products
        );

        $this->response($res, self::HTTP_OK);
    }

    public function offers_get()
    {
        $products = $this->ProductsModel->get_products_onSale();

        //If not exists data in products
        if (!isset($products)) {
            $res = array(
                'err' => true,
                'products' => null
            );

            $this->response($res, self::HTTP_INTERNAL_SERVER_ERROR);

            return $res;
        } else {
            $res = array(
                'err' => false,
                'products' => $products
            );

            $this->response($res, self::HTTP_OK);

            return $res;
        }
    }

    public function byname_get($query = '')
    {
        if (empty($query)) {
            $res = array(
                'err' => true,
                'products' => null
            );

            $this->response($res, self::HTTP_BAD_REQUEST);

            return $res;
        }

        $products = $this->ProductsModel->get_products_by_name($query);

        //If not exists data in products
        if (!isset($products)) {
            $res = array(
                'err' => true,
                'products' => null
            );

            $this->response($res, self::HTTP_INTERNAL_SERVER_ERROR);

            return $res;
        } else {
            $res = array(
                'err' => false,
                'products' => $products
            );

            $this->response($res, self::HTTP_OK);

            return $res;
        }
    }
}
