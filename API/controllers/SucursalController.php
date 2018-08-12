<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Sucursal.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Telefono.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Correo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBSucursal.php';


$app->get('/sucursal/', function() use ($app) {
    $dbSucursal = new DbSucursal(); 
    $idBarberia = $app->request->params('idBarberia');
    $idCanton = $app->request->params('idCanton');
     if (!empty($idBarberia)) {
        $sucursal = array('sucursal' => $dbSucursal->obtenerSucursal($idBarberia,2));
    }  else  if (!empty($idCanton)) {
        $sucursal = array('sucursal' => $dbSucursal->obtenerSucursal($idCanton,3));
    }  else{
        $sucursal = array('sucursal' => $dbSucursal->obtenerSucursal("",0));
    }
    $jsonArray = json_encode($sucursal);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(200);
    $app->response->setBody($jsonArray);
    return $app;
});


$app->post('/sucursal/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    $method = $app->request->params('method');
    if($auth->isAuth($authToken)){
        $sucursal = new Sucursal();
        $dbSucursal = new DbSucursal(); 
        $body = $app->request->getBody();
        $postedSucursal= json_decode($body);
        $sucursal->parseDto($postedSucursal->sucursal);
        $verificarReg = $dbSucursal->obtenerSucursal($sucursal->descripcion,4);
        if(is_null($method)){
            if( count($verificarReg) == 0){
                $resultSucursal = $dbSucursal->agregarSucursal($sucursal,$postedSucursal->sucursal->telefono,$postedSucursal->sucursal->correo);
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(200);
                $app->response->setBody($resultSucursal->toJson());
            }else{
               $error = new Error();
               $error->error = 'La Sucursal ya se encuentra registrado, seleccione otro';
               $app->response->headers->set('Content-Type', 'application/json');
               $app->response->setStatus(409);
               $app->response->setBody($error->toJson());
            }
        }else{
                $resultSucursal = $dbSucursal->actualizarSucursal($sucursal,$postedSucursal->sucursal->telefono,$postedSucursal->sucursal->correo);
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(200);
                $app->response->setBody($resultSucursal->toJson());        
        }
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/sucursal/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $sucursal = new Sucursal();
        $dbSucursal = new DbSucursal(); 
        $body = $app->request->getBody();
        $postedSucursal = json_decode($body);
        $sucursal->parseDto($postedSucursal->sucursal);
        $resultSucursal = $dbSucursal->actualizarSucursal($sucursal,$postedSucursal->sucursal->telefono,$postedSucursal->sucursal->correo);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultSucursal->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->get('/sucursal/:id', function($id) use ($app) {
    $dbSucursal = new DbSucursal(); 
    $resultSucursal = $dbSucursal->obtenerSucursal($id,1);
    $jsonArray = json_encode($resultSucursal);
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(200);
    $app->response->setBody($jsonArray);
    return $app;
});


$app->delete('/sucursal/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbSucursal = new DbSucursal(); 
        $dbSucursal->eliminar($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody('');
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});


$app->post('/sucursalTelefono/', function() use ($app) { 
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){        
        $telefono = new Telefono(); 
        $dbSucursal = new DbSucursal();
        $body = $app->request->getBody();
        $postedUser = json_decode($body);
        $telefono->parseDto($postedUser->telefono);     
        $resultTelefono = $dbSucursal->agregarTelefono($telefono);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultTelefono->toJson());       
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});


$app->delete('/sucursalTelefono/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbSucursal = new DbSucursal(); 
        $dbSucursal->eliminarTelefono($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody('');
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});



$app->post('/sucursalCorreo/', function() use ($app) { 
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){        
        $correo = new Correo(); 
        $dbSucursal = new DbSucursal();
        $body = $app->request->getBody();
        $postedUser = json_decode($body);
        $correo->parseDto($postedUser->correo); 
        $resultCorreo = $dbSucursal->agregarCorreo($correo);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultCorreo->toJson());
       
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});


$app->delete('/sucursalCorreo/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbSucursal = new DbSucursal();
        $dbSucursal->eliminarCorreo($id);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody('');
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});







