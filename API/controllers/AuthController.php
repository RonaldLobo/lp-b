<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Error.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBUsuario.php';

$app->post('/login/', function() use ($app) {
    $auth = new Auth(); 
    $user = new Usuario(); 
    $dbUsuario = new DbUsuario(); 
    $body = $app->request->getBody();
    $user->parseDto(json_decode($body));
    $usuarioEnDb = $dbUsuario->obtenerUsuario($user->usuario->usuario,2);
    if($usuarioEnDb){
        if($usuarioEnDb->tipo == "N" && $usuarioEnDb->contrasenna == $user->usuario->contrasenna && $user->usuario->tipo=='N'){
            $auth->generateToken($usuarioEnDb);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($auth->toJson());
            return $app;
        }
        if($usuarioEnDb->tipo == "F" && $user->usuario->tipo=='F'){
            $auth->generateToken($usuarioEnDb);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($auth->toJson());
            return $app;
        }
    }
    else{
        if($user->usuario->tipo=='F'){
            $resultUsuario = $dbUsuario->agregarUsuario($user->usuario,$user->usuario->telefono,$user->usuario->correo);  
            $auth->generateToken($resultUsuario);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($auth->toJson());
            return $app;
        }else{
            $auth->generateToken($usuarioEnDb);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($auth->toJson());
            return $app;
        }
    }
    $error = new Error();
    $error->error = "Por favor seleccione otro usuario";
    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setStatus(409);
    $app->response->setBody($error->toJson());
    return $app;
});

$app->post('/signup/', function() use ($app) {
    $auth = new Auth(); 
    $usuario = new Usuario(); 
    $dbUsuario = new DbUsuario(); 
    $postedUser = json_decode($app->request->getBody());
    $usuario->parseDto($postedUser->usuario);
    $usuario->parseDto($postedUser->usuario);        
    $verificarReg = $dbUsuario->obtenerUsuario($usuario->usuario,2);
    if( count($verificarReg) == 0){
        $resultUsuario = $dbUsuario->agregarUsuario($usuario,$postedUser->usuario->telefono,$postedUser->usuario->correo);  
        $auth->generateToken($resultUsuario);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($auth->toJson());
    } else {
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody('{"error":"El usuario ya existe, seleccione otro."}');
    }
    return $app;
});
