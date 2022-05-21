<?php
ini_set('memory_limit', '1024M');
set_time_limit(0);
date_default_timezone_set('America/Sao_Paulo');

require_once("../../filebase/autoload.php"); 
$database = new \Filebase\Database([
    'dir'            => '../../db/mydogshealth/users',
    'backupLocation' => '../../db/backup/mydogshealth/users',
    'format'         => \Filebase\Format\Json::class,
    'cache'          => false,
    'cache_expires'  => 1800,
    'pretty'         => true,
    'safe_filename'  => true,
    'read_only'      => false
]);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");
$method = $_SERVER['REQUEST_METHOD'];
$token = openssl_random_pseudo_bytes(64);
$token = bin2hex($token);


if ($method !== "POST" || !isset($_POST["token"]) ) {
    http_response_code(400);
    $data = (object) array("status"=>"error", "message"=>"Bad request");
    echo json_encode($data);
} else if ($database->where('token','==',$_POST["token"])->count() == 0) {
    http_response_code(401);
    $data = (object) array("status"=>"error", "message"=>"Token inválido.");
    echo json_encode($data);
} else {
    $item = $database->where('token','==',$_POST["token"])->first();
    $item = $database->get($item["id"]);

    $item->thumb = $_POST["thumb"];
    $item->name = $_POST["name"];
    $item->username = $_POST["username"];
    $item->specialist = $_POST["specialist"];
    $item->bio = $_POST["bio"];
    $item->contact = $_POST["contact"];
    $item->association = $_POST["association"];
    $item->city = $_POST["city"];
    $item->status = "ok";

    $item->save();
    http_response_code(201);
    
    $userdata = (object) array("user"=>$item->id, "email"=>$item->email, "token"=>$item->token, 
                               "name"=>$item->name, "username"=>$item->username, "bio"=>$item->bio,
                               "contact"=>$item->contact, "specialist"=>$item->specialist, "association"=>$item->association,
                               "city"=>$item->city,
                               "thumb"=>$item->thumb, "status"=>$item->status,
                               "dogs"=>0 );
    $data = (object) array("status"=>"success", "message"=>"Usuário ". $item->id . "registrado." , "userdata"=>$userdata);
    echo json_encode($data);
};

?>