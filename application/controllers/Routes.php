<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Routes extends REST_Controller {
    public function __construct()
    {
        parent::__construct();

        //Cargamos la database
        $this -> load -> database();

        //Cargamos el modelo
        $this -> load -> model('Routes_model');
    }

    public function routes_get()
    {
        $routes = $this -> Routes_model -> get_routes();

        if(!isset($routes)) {
            $respuesta = array(
                'err' => TRUE,
                'message' => 'rutas no encontradas',
                'routes' => null
            );
            $this -> response($respuesta, Rest_Controller::HTTP_NOT_FOUND);
            return ;
        } else {
            $respuesta = array(
                'err' => FALSE,
                'message' => 'rutas cargadas correctamente',
                'routes' => $routes
            );
            $this -> response($respuesta);
            return ;
        }

        $routes = $this -> Routes_model -> get_routes();
        $this -> response($routes);
    }
}