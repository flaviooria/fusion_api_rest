<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Login extends REST_Controller {

    public function __construct() {
        //Llamamos al constructor padre
        parent :: __construct();

        //Cargamos la database
        $this -> load -> database();

        //Cargamos el modelo
        $this -> load -> model('User_model');
    }

    //Esto es para obtener los resultados
    public function user_get() {
        $user_name = $this -> uri -> segment(3);
        $user_password = $this -> uri -> segment(4);

        //Validar el parámetro
        if (!isset($user_name) || !isset($user_password)) {
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'Debe indicar los dos parámetros'
            );
            $this -> response($respuesta, Rest_Controller::HTTP_BAD_REQUEST);
            return ;
        }

        $user = $this -> User_model -> get_user($user_name, $user_password);
        //Validamos el user
        if (!isset($user)) {
            $respuesta = array(
                'err' => TRUE,
                'mensaje' => 'El usuario no existe',
                'user' => null
            );
            $this -> response($respuesta, Rest_Controller::HTTP_NOT_FOUND);
            return ;
        } else {
            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'user cargado correctamente',
                'user' => $user
            );
            $this -> response($respuesta);
            return ;
        }

        $user = $this -> User_model -> get_user($user_name, $user_password);

        //Codeigniter ya tiene un metodo para dar la respuesta en JSON automatico
        $this -> response($user);
    }

}