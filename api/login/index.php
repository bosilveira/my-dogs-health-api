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

$database2 = new \Filebase\Database([
    'dir'            => '../../db/mydogshealth/dogs/',
    'backupLocation' => '../../db/backup/mydogshealth/dogs/',
    'format'         => \Filebase\Format\Json::class,
    'cache'          => false,
    'cache_expires'  => 1800,
    'pretty'         => true,
    'safe_filename'  => true,
    'read_only'      => false
]);


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== "POST" || !isset($_POST["email"]) || !isset($_POST["password"]) ) {
    http_response_code(400);
    $data = (object) array("status"=>"error", "message"=>"Bad request");
    echo json_encode($data);
} else if ($database->where('email','=',$_POST["email"])->count() == 0) {
    http_response_code(401);
    $data = (object) array("status"=>"error", "message"=>"Email inválido ou senha incorreta.");
    echo json_encode($data);
} else {
    $item = $database->where('email','=',$_POST["email"])->first();
    if ($item["password"] !== $_POST["password"]) {
        http_response_code(401);
        $data = (object) array("status"=>"error", "message"=>"Email inválido ou senha incorreta.");
        echo json_encode($data);
    } else {
        http_response_code(201);
        $doglist = $database2->where('owner','=',$item["id"])->count();

        $userdata = (object) array("user"=>$item["id"], "email"=>$item["email"], "token"=>$item["token"], 
        "name"=>$item["name"], "username"=>$item["username"], "bio"=>$item["bio"],
        "contact"=>$item["contact"], "specialist"=>$item["specialist"], "association"=>$item["association"],
        "city"=>$item["city"],
        "thumb"=>$item["thumb"], "status"=>$item["status"],
        "dogs"=>$doglist );

        $data = (object) array("status"=>"success", "message"=>"Login autorizado.",
            "userdata"=>$userdata);
        echo json_encode($data);
    }
};

?>