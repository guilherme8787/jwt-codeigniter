<?php

/**
 * JSON Web Token configuration params
 *
 * @param string $config['jwt_secret']  Chave secreta para geração de token
 * @param string $config['jwt_expiration_time'] tempo em segundos que o token tem de vida
 * @param string $config['jwt_start_time'] tempo em segundos que o token começa a valer a partir da hora em que foi gerado
 * 
 */
$config['jwt_secret'] = "OakleyTiffAtripFlackLowOuFlackJack";
$config['jwt_expiration_time'] = 3600;
$config['jwt_start_time'] = 3;