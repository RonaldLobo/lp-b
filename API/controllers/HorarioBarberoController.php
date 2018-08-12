<?php


    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/HorarioBarbero.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBHorarioBarbero.php';



$app->get('/horarioBarbero/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbHorarioBarbero = new DBHorarioBarbero(); 
        $idUsuario = $app->request->params('idUsuario');
        if (!empty($idUsuario)) {
            $dbHorarioBarbero = array('horarioBarbero' => $dbHorarioBarbero->obtenerHorario($idUsuario,2));
        }  else{
            $dbHorarioBarbero = array('horarioBarbero' => $dbHorarioBarbero->obtenerHorario("",0));
        }
        $jsonArray = json_encode($dbHorarioBarbero);
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


$app->post('/horarioBarbero/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    $method = $app->request->params('method');
    if($auth->isAuth($authToken)){
        $HorarioBarbero = new HorarioBarbero(); 
        $dbHorarioBarbero = new DBHorarioBarbero(); 
        $body = $app->request->getBody();
        $postedHorarioBarbero= json_decode($body);
        $HorarioBarbero->parseDto($postedHorarioBarbero->horarioBarbero);
        if(is_null($method)){   
            $resultHorarioBarbero = $dbHorarioBarbero->agregarHorario($HorarioBarbero);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($resultHorarioBarbero->toJson());
        }else{
            $resultHorarioBarbero = $dbHorarioBarbero->actualizarHorario($HorarioBarbero);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($resultHorarioBarbero->toJson());
        }
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/horarioBarbero/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $HorarioBarbero = new HorarioBarbero(); 
        $dbHorarioBarbero = new DBHorarioBarbero(); 
        $body = $app->request->getBody();
        $postedHorarioBarbero = json_decode($body);
        $HorarioBarbero->parseDto($postedHorarioBarbero->horarioBarbero);
        $resultHorarioBarbero = $dbHorarioBarbero->actualizarHorario($HorarioBarbero);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultHorarioBarbero->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->get('/horarioBarbero/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbHorarioBarbero = new DBHorarioBarbero(); 
        $resultHorarioBarbero = array('horarioBarbero' => $dbHorarioBarbero->obtenerHorario($id,1));
        $jsonArray = json_encode($resultHorarioBarbero);
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



$app->delete('/horarioBarbero/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbHorarioBarbero = new DBHorarioBarbero(); 
        $dbHorarioBarbero->eliminar($id);
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
