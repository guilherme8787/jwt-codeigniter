**Bem vindo**

O repositório acima é um projeto usando CodeIgniter na versão 3.1, para testar basta entrar no diretório do projeto via linha de comando e executar
php -S localhost:80

Iniciando

Crie o helper jwt usando raw disponivel em 

    framework\application\helpers\jwt_helper.php


Adicione o helper ao config/autoload
$autoload['helper'] = array('jwt_helper');

Crie um arquivo em config chamado jwt.php com o conteúdo:

    <?php
    /**
    * JSON Web Token configuration params
    *
    * @param  string $config['jwt_secret'] Chave secreta para geração de token
    * @param  string $config['jwt_expiration_time'] tempo em segundos que o token tem de vida
    * @param  string $config['jwt_start_time'] tempo em segundos que o token começa a valer a partir da hora em que foi gerado
    *
    */
    
    $config['jwt_secret'] =  "OakleyTiffAtripFlackLowOuFlackJack";
    $config['jwt_expiration_time'] =  3600;
    $config['jwt_start_time'] =  3;

**Exemplos do uso do helper no seu controller extends CI_Controller:**

    public  function  token(){
    	$this->config->load('jwt');
    	$jwt  =  new  JWT;
    	$JwtSecretKey  =  $this->config->item('jwt_secret');
    	$data  =  Array(
    	"loginInfo" => Array(
    			"id" => 1,
    			"email" => "user@user.com",
    			"tipo" => "admin"
    		),
    		"iat" => time(),
    		"exp" => time() +  $this->config->item('jwt_expiration_time'),
    		"nbf" => time() +  $this->config->item('jwt_start_time'),
    	);
    	$token  =  $jwt->encode($data, 'HS256');
    	echo  $token;
    }

**Layout:**
O layout acima no Array segue o padrão rfc7519:
https://datatracker.ietf.org/doc/html/rfc7519
"iat": 1629307681, -> hora  em  que  o  token  foi  gerado 
"exp": 1629336481, -> expiration  time 
"nbf": 1629307681, -> é  valido a  partir  de
O conteúdo da mensagem *loginInfo* corresponde aos dados de login do usuário inseridos na mensagem do token

**Exemplo de decode:**

    public  function  decode_token(){
    	$token  =  'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiZW1haWwiOiJ1c2VyQHVzZXIuY29tIiwidGlwbyI6ImFkbWluIn0.YHoMsgq3s9Ex9S3p3ucPpZJOqMnxD3c14datJ9bVAZk'; $jwt  =  new  JWT;
    	$JwtSecretKey  =  "OakleyTiffAtripFlackLowOuFlackJack";
    	$decoded_token  =  $jwt->decode($token, $JwtSecretKey, 'HS256');
    	echo  json_encode($decoded_token,  JSON_PRETTY_PRINT,  200);
    }


Referencias:
https://www.youtube.com/watch?v=Nd1vyvegvXo
https://github.com/rpiambulance/website/blob/master/jwt_helper.php
