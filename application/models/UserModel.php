<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
    protected $table = 'fr_users';

    public $id;
    public $email;
    public $api_key;

    public function insert_user($user)
    {
        $query = $this->db->get_where($this->table, array('email' => $this->email));
        $user_id = $query->row();
        // if user exist in the bd
        if (isset($user_id)) {
            $res = array(
                'err' => TRUE,
                'msg' => 'user exists in the bd',
                'user' => null,
            );

            return $res;
        }

        if (!$this->db->insert($this->table, $this)) {
            $res = array(
                'err' => true,
                'msg' => 'error to insert user',
                'user' => null
            );

            return $res;
        } else {
            
            $id = $this->db->insert_id();

            $res = array(
                'err' => false,
                'msg' => 'insert successfully',
                'user' => array('id' => $id, 'email' => $this->email, 'api_key' => $this->api_key)
            );

            return $res;
        }
    }

    public function update_user()
    {
        $query = $this->db->get_where($this->table, array('id' => (int) $this->id));

        $user_exists = $query->row();

        //If exists user
        $this->db->reset_query();
        $this->db->where('id', (int) $this->id);

        if (isset($user_exists) && $this->db->update($this->table, $this)) {
            // Update successfully
            $response = array(
                'err' => FALSE,
                'msg' => 'update user',
                'user' => $this,
            );

            return $response;
        } else {
            // No se pudo actualizar
            $response = array(
                'err' => TRUE,
                'msg' => 'user not updated',
                'user' => null,
            );

            return $response;
        }
    }

    public function get_user($user)
    {
        $this->db->reset_query();

        $query = $this->db->get_where($this->table, array('email' => $this->email, 'api_key' => $this->api_key))
            ->custom_row_object(0, 'UserModel');

        if (!isset($query)) {
            $res = array(
                'err' => true,
                'msg' => 'user not found',
                'user' => null
            );

            return $res;
        }

        if (isset($res)) { // Si tiene datos...
            // Cambio los datos del usuario a los originales
            $res->id = intval($res->id);
        }

        $res = array(
            'err' => false,
            'msg' => 'user ok',
            'user' => $query
        );

        return $res;
    }

    public function clean_data($dirty_data)
    {
        //Vamos a coger los datos que nos vengas ya sea put o post y limpiar los campos que no existan
        foreach ($dirty_data as $name_attribute => $value) {
            if (property_exists('UserModel', $name_attribute)) {
                $this->$name_attribute = $value;
            }
        }

        return $this;
    }
}
