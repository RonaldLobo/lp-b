<?php

  
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Provincia.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Canton.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBProvinciaCanton.php';
 


$app->get('/provinciaCanton/', function() use ($app) {
    $dbProvinciaCanton = new DBProvinciaCanton(); 
    $provinciaCanton = array('ProvinciaCanton' => $dbProvinciaCanton->obtenerProvincia());        
    $jsonArray = json_encode($provinciaCanton);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(200);
    $app->response->setBody($jsonArray);
    return $app;
});

    

