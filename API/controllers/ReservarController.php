<?php


    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Reserva.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBReserva.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Servicios/email.php';

  

$app->get('/reserva/', function() use ($app) {
//    $auth = new Auth();
//    $authToken = $app->request->headers->get('Authorization');
//    if($auth->isAuth($authToken)){
        $dbReserva = new DBReserva(); 
        $idSucursal = $app->request->params('idSucursal');
        $fecha = $app->request->params('fecha');
        $fechaInicial = $app->request->params('fechaInicial');
        $fechaFinal = $app->request->params('fechaFinal');
        $idUsuario = $app->request->params('idUsuarioReserva');
        $idUsuarioBarbero = $app->request->params('idUsuarioBarbero');
        $idServicio = $app->request->params('idServicio');       
         if (!empty($idSucursal)) {
            $reserva = array('reserva' => $dbReserva->obtenerReserva($idSucursal,2));
        }  else  if (!empty($idUsuario)) {
            $reserva = array('reserva' => $dbReserva->obtenerReserva($idUsuario,3));
        }  else  if (!empty($idServicio)) {
            $reserva = array('reserva' => $dbReserva->obtenerReserva($idServicio,4));
        }  else  if (!empty($idUsuarioBarbero) && !empty($fecha)) {
            $reserva = array('reserva' => $dbReserva->obtenerReservaFecha($idUsuarioBarbero,$fecha));
        }  else  if (!empty($fechaFinal) && !empty($fechaInicial) && !empty($idUsuarioBarbero)) {
            $reserva = array('reserva' => $dbReserva->obtenerReservaFechaRango($idUsuarioBarbero,$fechaInicial,$fechaFinal));
        }  else{
            $reserva = array('reserva' => $dbReserva->obtenerReserva("",0));
        }
        $jsonArray = json_encode($reserva);
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


$app->post('/reserva/', function() use ($app) {
    $auth = new Auth();
    $email = new EmailServicios();
    $authToken = $app->request->headers->get('Authorization');
    $method = $app->request->params('method');
    if($auth->isAuth($authToken)){
        $reserva = new Reserva(); 
        $dbReserva = new DBReserva(); 
        $body = $app->request->getBody();
        $postedReserva= json_decode($body);
        $reserva->parseDto($postedReserva->reserva);
        if(is_null($method)){   
            $resultReserva = $dbReserva->agregarReserva($reserva);
            $email->EnvioEmailReserva($reserva->idUsuarioReserva, $reserva->idSucursal,$resultReserva->id);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($resultReserva->toJson());
        }else{
            $resultReserva = $dbReserva->actualizarReserva($reserva);            
            $app->response->headers->set('Content-Type', 'application/json');
            $app->response->setStatus(200);
            $app->response->setBody($resultReserva->toJson());
        }
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/reserva/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $reserva = new Reserva(); 
        $dbReserva = new DBReserva(); 
        $body = $app->request->getBody();
        $postedReserva = json_decode($body);
        $reserva->parseDto($postedReserva->reserva);
        $resultReserva = $dbReserva->actualizarReserva($reserva);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultReserva->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->get('/reserva/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbReserva = new DBReserva(); 
        $resultSucursal =  array('reserva' => $dbReserva->obtenerReserva($id,1));
        $jsonArray = json_encode($resultSucursal);
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



$app->delete('/reserva/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbReserva = new DBReserva(); 
        $dbReserva->eliminar($id);
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
