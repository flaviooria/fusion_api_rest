<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class User extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        //Load database
        $this->load->database();
        //Load model
        $this->load->model('UserModel');

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE,OPTIONS");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
    }

    public function user_post()
    {
        //load library form validation
        $this->load->library('form_validation');
        $this->form_validation;

        //Receive data of post
        $data = $this->post();

        if (empty($data)) $data = array('err' => true);

        // Le digo al form validation, que datos debe validar
        $this->form_validation->set_data($data);

        //Aplicate the rules
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('api_key', 'key', 'required');

        //If the form validation is correct
        if ($this->form_validation->run()) {
            $user = $this->UserModel->clean_data($data);

            $res = $user->insert_user($user);


            if ($res['err']) {
                $this->response($res, self::HTTP_INTERNAL_SERVER_ERROR);

                return $res;
            }

            $this->response($res, self::HTTP_OK);
            return $res;
        } else {
            // Validación fallida
            $res = array(
                'err' => TRUE,
                'msg' => 'email and key is required',
                'user' => null
            );

            $this->response($res, self::HTTP_BAD_REQUEST);
        }
    }

    public function user_put()
    {
        //load library form validation
        $this->load->library('form_validation');
        $this->form_validation;

        $data = $this -> put();

        if (empty($data)) $data = array('err' => true);

        // Le digo al form validation, que datos debe validar
        $this->form_validation->set_data($data);

        //Aplicate the rules
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('api_key', 'key', 'required');

        //If the form validation is correct
        if ($this->form_validation->run()) {
            $user = $this->UserModel->clean_data($data);

            $res = $user->update_user();


            if ($res['err']) {
                $this->response($res, self::HTTP_INTERNAL_SERVER_ERROR);

                return $res;
            }

            $this->response($res, self::HTTP_OK);
            return $res;
        } else {
            // Validación fallida
            $res = array(
                'err' => TRUE,
                'msg' => 'email and key is required',
                'user' => null
            );

            $this->response($res, self::HTTP_BAD_REQUEST);
        }
    }

    public function getuser_post()
    {
        //load library form validation
        $this->load->library('form_validation');
        $this->form_validation;

        //Receive data of post
        $data = $this->post();

        if (empty($data)) $data = array('email' => '','api_key' => '');

        // Le digo al form validation, que datos debe validar
        $this->form_validation->set_data($data);

        //Aplicate the rules
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('api_key', 'key', 'required');

        if ($this->form_validation->run()) {
            $user = $this->UserModel->clean_data($data);
            $res = $user->get_user($user);

            if (!isset($res)) {
                $this->response($res, self::HTTP_INTERNAL_SERVER_ERROR);
                return $res;
            }

            $this->response($res, self::HTTP_OK);
            return $res;

        } else {
            // Validación fallida
            $res = array(
                'err' => TRUE,
                'msg' => 'email and key is required',
                'user' => null
            );

            $this->response($res, self::HTTP_BAD_REQUEST);
        }
    }
}
