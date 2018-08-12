<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Auth.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBServicio.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBUsuario.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Servicios.php';
   

$app->get('/servicio/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbServicio = new DBServicio(); 
        $idUsuario = $app->request->params('idUsuario');
        if (!empty($idUsuario)) {
            $servicio = array('servicio' => $dbServicio->obtenerServicio($idUsuario,2));
        }  else{
            $servicio = array('servicio' => $dbServicio->obtenerServicio("",0));
        }
        $jsonArray = json_encode($servicio);
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


$app->post('/servicio/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    $method = $app->request->params('method');
    if($auth->isAuth($authToken)){
        $servicio = new Servicios(); 
        $dbServicio = new DBServicio(); 
        $dbUsuario = new DBUsuario(); 
        $body = $app->request->getBody();
        $postedServicio= json_decode($body);
        $servicio->parseDto($postedServicio->servicio);
        $descripcion = $app->request->params('descripcion');
        $verificarReg = $dbServicio->obtenerServicio($descripcion,3);
        if(is_null($method)){   
            if( count($verificarReg) == 0){
                $resultServicio = $dbServicio->agregarServicio($servicio);
                // $usuario = $dbUsuario->obtenerUsuario($servicio->idUsuario,1);
                // // send mail
                //     function sendIcalEvent($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location)
                //     {
                //         $domain = 'lospeluqueros.com';

                //         //Create Email Headers
                //         $mime_boundary = "----Meeting Booking----".MD5(TIME());

                //         $headers = "From: ".$from_name." <".$from_address.">\n";
                //         $headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
                //         $headers .= "MIME-Version: 1.0\n";
                //         $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
                //         $headers .= "Content-class: urn:content-classes:calendarmessage\n";
                        
                //         //Create Email Body (HTML)
                //         $message = "--$mime_boundary\r\n";
                //         $message .= "Content-Type: text/html; charset=UTF-8\n";
                //         $message .= "Content-Transfer-Encoding: 8bit\n\n";
                //         $message .= "<html>\n";
                //         $message .= "<body>\n";
                //         $message .= '<p>Dear '.$to_name.',</p>';
                //         $message .= '<p>'.$description.'</p>';
                //         $message .= "</body>\n";
                //         $message .= "</html>\n";
                //         $message .= "--$mime_boundary\r\n";

                //         $ical = 'BEGIN:VCALENDAR' . "\r\n" .
                //         'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
                //         'VERSION:2.0' . "\r\n" .
                //         'METHOD:REQUEST' . "\r\n" .
                //         'BEGIN:VTIMEZONE' . "\r\n" .
                //         'TZID:Eastern Time' . "\r\n" .
                //         'BEGIN:STANDARD' . "\r\n" .
                //         'DTSTART:20091101T020000' . "\r\n" .
                //         'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
                //         'TZOFFSETFROM:-0400' . "\r\n" .
                //         'TZOFFSETTO:-0500' . "\r\n" .
                //         'TZNAME:EST' . "\r\n" .
                //         'END:STANDARD' . "\r\n" .
                //         'BEGIN:DAYLIGHT' . "\r\n" .
                //         'DTSTART:20090301T020000' . "\r\n" .
                //         'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" .
                //         'TZOFFSETFROM:-0500' . "\r\n" .
                //         'TZOFFSETTO:-0400' . "\r\n" .
                //         'TZNAME:EDST' . "\r\n" .
                //         'END:DAYLIGHT' . "\r\n" .
                //         'END:VTIMEZONE' . "\r\n" .  
                //         'BEGIN:VEVENT' . "\r\n" .
                //         'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
                //         'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
                //         'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
                //         'UID:'.date("Ymd\TGis", strtotime($startTime)).rand()."@".$domain."\r\n" .
                //         'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
                //         'DTSTART;TZID="Eastern Time":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
                //         'DTEND;TZID="Eastern Time":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
                //         'TRANSP:OPAQUE'. "\r\n" .
                //         'SEQUENCE:1'. "\r\n" .
                //         'SUMMARY:' . $subject . "\r\n" .
                //         'LOCATION:' . $location . "\r\n" .
                //         'CLASS:PUBLIC'. "\r\n" .
                //         'PRIORITY:5'. "\r\n" .
                //         'BEGIN:VALARM' . "\r\n" .
                //         'TRIGGER:-PT15M' . "\r\n" .
                //         'ACTION:DISPLAY' . "\r\n" .
                //         'DESCRIPTION:Reminder' . "\r\n" .
                //         'END:VALARM' . "\r\n" .
                //         'END:VEVENT'. "\r\n" .
                //         'END:VCALENDAR'. "\r\n";
                //         $message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
                //         $message .= "Content-Transfer-Encoding: 8bit\n\n";
                //         $message .= $ical;

                //         $mailsent = mail($to_address, $subject, $message, $headers);

                //         return ($mailsent)?(true):(false);
                //     }
                //     $from_name = "tapiasbarber";        
                //     $from_address = "tapiasbarber@lospeluqueros.com";        
                //     $to_name = $usuario->nombre;        
                //     $to_address = $usuario->email[0];        
                //     $startTime = "11/12/2013 18:00:00";        
                //     $endTime = "11/12/2013 19:00:00";        
                //     $subject = "My Test Subject";        
                //     $description = "My Awesome Description";        
                //     $location = "Joe's House";
                //     sendIcalEvent($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location);
                // //
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(200);
                $app->response->setBody($resultServicio->toJson());
             }else{
               $error = new Error();
               $error->error = 'El Servicio ya se encuentra registrado, seleccione otro';
               $app->response->headers->set('Content-Type', 'application/json');
               $app->response->setStatus(409);
               $app->response->setBody($error->toJson());
            }
        }else{
            $nomBD ='';
            if (count($verificarReg) >0){
                  $nomBD =$verificarReg->descripcion;
            }
            if((count($verificarReg) == 0 )|| $servicio->descripcion == $nomBD){
               $resultServicio = $dbServicio->actualizarServicio($servicio);
               $app->response->headers->set('Content-Type', 'application/json');
               $app->response->setStatus(200);
               $app->response->setBody($resultServicio->toJson());        
            }else{
               $error = new Error();
               $error->error = 'El Servicio ya se encuentra registrado, seleccione otro';
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

$app->put('/servicio/', function() use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $servicio = new Servicios(); 
        $dbServicio = new DBServicio(); 
        $body = $app->request->getBody();
        $postedServicio = json_decode($body);
        $servicio->parseDto($postedServicio->servicio);
        $resultServicio = $dbServicio->actualizarServicio($servicio);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(200);
        $app->response->setBody($resultServicio->toJson());
    }
    else{
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->setStatus(401);
        $app->response->setBody("");
    }
    return $app;
});

$app->get('/servicio/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbServicio = new DBServicio(); 
        $resultServicio = $dbServicio->obtenerServicio($id,1);
        $jsonArray = json_encode($resultServicio);
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


$app->delete('/servicio/:id', function($id) use ($app) {
    $auth = new Auth();
    $authToken = $app->request->headers->get('Authorization');
    if($auth->isAuth($authToken)){
        $dbServicio = new DBServicio(); 
        $dbServicio->eliminar($id);
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



