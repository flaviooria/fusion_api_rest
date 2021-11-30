<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_model{

    public $id;
    public $name;
    public $password;
    public $isActive;
    public $isAdmin;

    public function get_user($name, $password) {
        $this -> db -> where(array('name' => $name, 'password' => $password, 'isActive' => 1));
        $query = $this -> db -> get('users');

        $result = $query -> custom_row_object(0, 'User_model');
        
        if (isset($result)) {
            $result -> id = intval($result -> id);
            $result -> isActive = boolval($result -> isActive);
            $result -> isAdmin = boolval($result -> isAdmin);
        }

        return $result;
    }

    public function insert($User){
        return 'User Insertado';
    }

    public function update($User){
        return 'User Actualizado';
    }

    public function delete($User){
        return 'User Borrado';
    }

}