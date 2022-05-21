<?php
include 'classes/login.php';
include 'bearer-token.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

$headers = getBearerToken();


$token = openssl_random_pseudo_bytes(64);
$token = bin2hex($token);
 

$login = new Login();
$login->token = $token;
$login->method = $method;
$login->bearer = $headers;

http_response_code(201);
echo json_encode($login);

?>