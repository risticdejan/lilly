<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function login($mail, $pass)
    {

        $q = $this
            ->db
            ->select('*')
            ->where('email', $mail)
            ->where('password', $pass)
            ->get('users');

        $num_rows = $q->num_rows();

        if($num_rows > 0 )
        {
            $user = $q->row();
            $this->session->set_userdata('id',$user->id);
            $this->session->set_userdata('username',$user->name);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getPassword($email)
    {
        $q = $this
            ->db
            ->select('email')
            ->where('email', $email)
            ->get('users');

        return $q->row();
    }


    public function logout()
    {
        foreach($_SESSION as $key=>$value){
            unset($_SESSION[$key]);
        }

        if(isset($_COOKIE[session_name()])):
            setcookie(session_name(), '', time()-7000000, '/');
        endif;

        session_destroy();

    }

    public function getUser($token){
        $q = $this
            ->db
            ->select('*')
            ->where('token', $token)
            ->get('users');

        return $q->row();
    }

    public function updatePassword($password, $id){
        $data = array(
            'password' => $password,
            'token' => null
        );

        $q = $this
            ->db
            ->where('id', $id)
            ->update('users', $data);
    }

    public function insertToken($token, $email) {
        $data = array(
            'token' => $token
        );

        $q = $this
            ->db
            ->where('email', $email)
            ->update('users', $data);
    }
}