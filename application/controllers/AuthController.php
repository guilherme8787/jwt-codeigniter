<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

	public function index()
	{
		// $this->load->view('welcome_message');
        $this->config->load('jwt');
        echo $this->config->item('jwt_secret');

	}

    public function token(){
        $this->config->load('jwt');
        
        $jwt = new JWT;
        $JwtSecretKey = $this->config->item('jwt_secret');

        $data = Array(
            "loginInfo" => Array(
                    "id" => 1,
                    "email" => "user@user.com",
                    "tipo" => "admin"
            ),
            "iat" => time(),
            "exp" => time() + $this->config->item('jwt_expiration_time'),
            "nbf" => time() + $this->config->item('jwt_start_time'),
        );

        $token = $jwt->encode($data, 'HS256');
        echo $token;
        
    }

    public function decode_token(){
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiZW1haWwiOiJ1c2VyQHVzZXIuY29tIiwidGlwbyI6ImFkbWluIn0.YHoMsgq3s9Ex9S3p3ucPpZJOqMnxD3c14datJ9bVAZk';        $jwt = new JWT;
        
        $JwtSecretKey = "OakleyTiffAtripFlackLowOuFlackJack";
        $decoded_token = $jwt->decode($token, $JwtSecretKey, 'HS256');

        echo json_encode($decoded_token, JSON_PRETTY_PRINT, 200);

    }
}
