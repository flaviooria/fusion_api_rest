<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';


class Categories extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        //load database
        $this->load->database();
        //load model
        $this->load->model('CategoriesModel');

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE,OPTIONS");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
    }

    public function all_get() 
    {
        $res = $this->CategoriesModel->get_categories();

        if(!isset($res)) {
            $res = array(
                'err' => true,
                'categories' => null
            );
            $this->response($res,self::HTTP_INTERNAL_SERVER_ERROR);
            return $res;
        } else {
            $res = array(
                'err' => false,
                'categories' => $res
            );
            $this->response($res,self::HTTP_OK);
            return $res;
        }
    }
}