<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Barberia.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBBarberia.php';


$app->get('/barberia/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbBarberia = new DBBarberia(); 
        $nombre = $app->request->params('nombre');
        if (!empty($nombre)){ 
            $barberia = array('barberia' => $dbBarberia->obtenerBarberia($nombre,2));
        }  else{
            $barberia = array('barberia' => $dbBarberia->obtenerBarberia("",0));
        }
        $jsonArray = json_encode($barberia);
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


$app->post('/barberia/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    $method = $app->request->params('method');
    if($auth->isAuth($authToken)){
        $barberia = new Barberia(); 
        $dbBarberia = new DBBarberia(); 
        $body = $app->request->getBody();
        $postedBarberia= json_decode($body);
        $barberia->parseDto($postedBarberia->barberia);
        $verificarReg = $dbBarberia->obtenerBarberia($barberia->nombre,3);
        if(is_null($method)){      
            if( count($verificarReg) == 0){
                $resultBarberia = $dbBarberia->agregarBarberia($barberia);
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(200);
                $app->response->setBody($resultBarberia->toJson());
            }else{
               $error = new Error();
               $error->error = 'El Barbero ya se encuentra registrado, seleccione otro';
               $app->response->headers->set('Content-Type', 'application/json');
               $app->response->setStatus(409);
               $app->response->setBody($error->toJson());
            }
        }else{
            $nomBD ='';
            if (count($verificarReg) >0){
                  $nomBD =$verificarReg->nombre;
            }
            if((count($verificarReg) == 0 )|| $barberia->nombre == $nomBD){
               $resultBarberia = $dbBarberia->actualizarBarberia($barberia);
               $app->response->headers->set('Content-Type', 'application/json');
               $app->response->setStatus(200);
               $app->response->setBody($resultBarberia->toJson());        
            }else{
               $error = new Error();
               $error->error = 'El Barbero ya se encuentra registrado, seleccione otro';
               $app->response->headers->set('Content-Type', 'application/json');
               $app->response->setStatus(409);
               $app->response->setBody($error->toJson());
            }
        }       
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->put('/barberia/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $barberia = new Barberia(); 
        $dbBarberia = new DBBarberia(); 
        $body = $app->request->getBody();
        $postedBarberia = json_decode($body);
        $barberia->parseDto($postedBarberia->barberia);
        $resultBarberia = $dbBarberia->actualizarBarberia($barberia);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultBarberia->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->get('/barberia/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbBarberia = new DBBarberia(); 
        $resultBarberia = array('barberia' => $dbBarberia->obtenerBarberia($id,1));
        $jsonArray = json_encode($resultBarberia);
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


$app->delete('/barberia/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbBarberia = new DBBarberia();
        $dbBarberia->eliminar($id);
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
