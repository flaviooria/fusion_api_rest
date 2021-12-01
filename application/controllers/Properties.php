<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Properties extends REST_Controller {
    public function __construct()
    {
        parent::__construct();

        //Cargamos la database
        $this -> load -> database();

        //Cargamos el modelo
        $this -> load -> model('Properties_model');
    }

    public function properties_get()
    {
        $properties = $this -> Properties_model -> get_properties();

        if(!isset($properties)) {
            $respuesta = array(
                'err' => TRUE,
                'message' => 'propiedades no encontradas',
                'routes' => null
            );
            $this -> response($respuesta, Rest_Controller::HTTP_NOT_FOUND);
            return ;
        } else {
            $respuesta = array(
                'err' => FALSE,
                'message' => 'propiedades cargadas correctamente',
                'routes' => $properties
            );
            $this -> response($respuesta);
            return ;
        }

        $properties = $this -> Properties_model -> get_properties();
        $this -> response($properties);
    }
}