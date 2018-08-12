<?php

require '../API/Vendor/Slim/Slim.php';
require '../API/Vendor/JWT/JWT.php';
require '../API/Vendor/JWT/BeforeValidException.php';
require '../API/Vendor/JWT/ExpiredException.php';
require '../API/Vendor/JWT/SignatureInvalidException.php';

\Slim\Slim::registerAutoloader();

if (isset($_SERVER['HTTP_ORIGIN'])) {
    //header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');    
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); 
}   
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
} 

date_default_timezone_set('America/Costa_Rica');

$app = new \Slim\Slim();


require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/BarberiaController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/UsuarioController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/HorarioBarberoController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/PausaHorarioBarberoController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/ProvinciaCantonController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/AuthController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/ReservarController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/ServicioController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/controllers/SucursalController.php';

$app->run();
?>
