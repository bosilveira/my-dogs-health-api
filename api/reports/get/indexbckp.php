<?php
ini_set('memory_limit', '1024M');
set_time_limit(0);
date_default_timezone_set('America/Sao_Paulo');

require_once("../../../filebase/autoload.php"); 
$database = new \Filebase\Database([
    'dir'            => '../../../db/mydogshealth/users',
    'backupLocation' => '../../../db/backup/mydogshealth/users',
    'format'         => \Filebase\Format\Json::class,
    'cache'          => false,
    'cache_expires'  => 1800,
    'pretty'         => true,
    'safe_filename'  => true,
    'read_only'      => false
]);

$database3 = new \Filebase\Database([
    'dir'            => '../../../db/mydogshealth/reports',
    'backupLocation' => '../../../db/backup/mydogshealth/reports',
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

if ($method !== "POST" || !isset($_POST["token"]) ) {
    http_response_code(400);
    $data = (object) array("status"=>"error", "message"=>"Bad request");
    echo json_encode($data);
} else if ($database->where('token','==',$_POST["token"])->count() == 0) {
    http_response_code(401);
    $data = (object) array("status"=>"error", "message"=>"Token inválido.");
    echo json_encode($data);
} else {
    $user = $database->where('token','==',$_POST["token"])->first();

    $reportlist = $database3->where('owner','==',$user["id"])->results();

    http_response_code(201);

    $data = (object) array("status"=>"success", "message"=>"Lista atualizada." , "reportdata"=>$reportlist);
    echo json_encode($data);
};

?>