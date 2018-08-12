<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBPausaHorarioBarbero.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/PausaHorarioBarbero.php';
   

$app->get('/pausaHorarioBarbero/', function() use ($app) {
//    $auth = new Auth();
//    $authToken = $app->request->headers->get('Authorization');
//    if($auth->isAuth($authToken)){
        $dbPausaHorarioBarbero = new DBPausaHorarioBarbero(); 
        $idUsuario = $app->request->params('idUsuario');
          if (!empty($idUsuario)){ 
            $pausaHorarioBarbero = array('pausaHorarioBarbero' => $dbPausaHorarioBarbero->obtenerPausaHorarioBarbero($idUsuario,2));
         }  else{
            $pausaHorarioBarbero = array('pausaHorarioBarbero' => $dbPausaHorarioBarbero->obtenerPausaHorarioBarbero("",0));
        }
        $jsonArray = json_encode($pausaHorarioBarbero);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($jsonArray);
//    }
//    else{
//        $app->response->headers->set('Content-Type', 'application/json');
//        $app->response->setStatus(401);
//        $app->response->setBody("");
//    }
    return $app;
});


$app->post('/pausaHorarioBarbero/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    $method = $app->request->params('method');
    if($auth->isAuth($authToken)){
        $pausaHorarioBarbero = new PausaHorarioBarbero(); 
        $dbPausaHorarioBarbero = new DBPausaHorarioBarbero(); 
        $body = $app->request->getBody();
        $postedPausaHorarioBarbero= json_decode($body);
        $pausaHorarioBarbero->parseDto($postedPausaHorarioBarbero->pausaHorarioBarbero);
        if(is_null($method)){  
            $resultPausaHorarioBarbero = $dbPausaHorarioBarbero->agregarPausaHorarioBarbero($pausaHorarioBarbero);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($resultPausaHorarioBarbero->toJson());
        } else {
            $resultPausaHorarioBarbero = $dbPausaHorarioBarbero->actualizarPausaHorarioBarbero($pausaHorarioBarbero);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($resultPausaHorarioBarbero->toJson());        
        }
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/pausaHorarioBarbero/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $pausaHorarioBarbero = new PausaHorarioBarbero(); 
        $dbPausaHorarioBarbero = new DBPausaHorarioBarbero(); 
        $body = $app->request->getBody();
        $postedPausaHorarioBarbero = json_decode($body);
        $pausaHorarioBarbero->parseDto($postedPausaHorarioBarbero->pausaHorarioBarbero);
        $resultPausaHorarioBarbero = $dbPausaHorarioBarbero->actualizarPausaHorarioBarbero($pausaHorarioBarbero);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultPausaHorarioBarbero->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->get('/pausaHorarioBarbero/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbPausaHorarioBarbero = new DBPausaHorarioBarbero(); 
        $resultPausa = array('pausaHorarioBarbero' => $dbPausaHorarioBarbero->obtenerPausaHorarioBarbero($id,1));
        $jsonArray = json_encode($resultPausa);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($jsonArray);
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});



$app->delete('/pausaHorarioBarbero/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbPausaHorarioBarbero = new DBPausaHorarioBarbero();
        $dbPausaHorarioBarbero->eliminar($id);
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

