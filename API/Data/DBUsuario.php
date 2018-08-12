<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Telefono.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Correo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBServicio.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DBHorarioBarbero.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Servicios/email.php';

class DbUsuario {

    function agregarUsuario($usuario,$telefonos,$correos){
        $db = new DB();
        $sql = "INSERT INTO usuarios (FkIdSucursalBarberiaUsuario,Nombre, PrimerApellido, SegundoApellido,Usuario,Contrasenna,Tipo,Estado,Rol,TiempoBarbero) VALUES ("
                .$usuario->idSucursal.",'"
                .$usuario->nombre."', '"
                .$usuario->apellido1. "', '"
                .$usuario->apellido2. "', '"
                .$usuario->usuario. "','"
                .$usuario->contrasenna. "','"
                .$usuario->tipo. "',"
                .$usuario->estado.",'"
                .$usuario->rol. "',"
                .$usuario->tiempoBarbero. ")";
//            echo $sql;
            $id = $db->agregar($sql);
            if ($id >0){
                foreach($telefonos as $tel){
                    $sql = "INSERT INTO telefonousuario (FkIdUsuarioTelefono  ,Telefono, Estado) VALUES ("
                    .$id."," .$tel->telefono.",".$tel->estado.")";
                    $idTel = $db->agregar($sql);
                }
                if ($idTel >0){
                    foreach ($correos as $email){
                        $sql = "INSERT INTO emailusuario (FkIdUsuarioEmail, Email, Estado) VALUES ("
                        .$id.",'".$email->correo."',".$email->estado.")";
                         $db->agregar($sql);
                    }     
                } 
            }
        $usuario->id = $id;
        $email = new EmailServicios();
        $email->EnvioEmailNuevoUsuario($usuario,$correos[0]);
         return $usuario;
    }
    
    function actualizarUsuario($usuario,$telefonos,$correos){
        $db = new DB();
        $sql = "UPDATE usuarios SET "
                . "FkIdSucursalBarberiaUsuario=".$usuario->idSucursal.", "
                . "Nombre='".$usuario->nombre."', "
                . "PrimerApellido='".$usuario->apellido1."', "
                . "SegundoApellido ='".$usuario->apellido2."', "
                . "Tipo= '".$usuario->tipo."', "
                . "Usuario='".$usuario->usuario."', "
                . "Contrasenna='".$usuario->contrasenna."',"
                . "Estado=".$usuario->estado.","
                . "Rol='".$usuario->rol."',"
                . "TiempoBarbero='".$usuario->tiempoBarbero."' "
                . "WHERE PkIdUsuario=".$usuario->id;
            if($db->actualizar($sql)) {
                $sqlClean = "DELETE FROM telefonousuario WHERE FkIdUsuarioTelefono=".$usuario->id;
                $db->actualizar($sqlClean);
                foreach ($telefonos  as $tel){
                    $sql = "INSERT INTO telefonousuario (FkIdUsuarioTelefono  ,Telefono, Estado) VALUES ("
                    .$usuario->id."," .$tel->telefono.",".$tel->estado.")";
                    $idTel = $db->agregar($sql);
                    $tel->id = $idTel;
                }
                $sqlClean = "DELETE FROM emailusuario WHERE FkIdUsuarioEmail=".$usuario->id;
                $db->actualizar($sqlClean);
                foreach ($correos  as $correo){
                    $sql = "INSERT INTO emailusuario (FkIdUsuarioEmail, Email, Estado) VALUES ("
                        .$usuario->id.",'".$correo->correo."',".$correo->estado.")";
                    $idCorreo = $db->agregar($sql);
                    $correo->idCorreo = $idCorreo;
                }
            }
        
        return $usuario;
    }     
       
    function eliminar($id){
        $db = new DB();
        $sql = "UPDATE usuarios SET Estado=0 WHERE PkIdUsuario=".$id;
        $db->actualizar($sql);   
    }
       
    function obtenerUsuario($busqueda, $opcion){
        
        $sql = "SELECT PkIdUsuario,FkIdSucursalBarberiaUsuario,Nombre,PrimerApellido, SegundoApellido,Usuario,Contrasenna,Tipo,Estado, Rol,TiempoBarbero FROM usuarios ";
        if($opcion == 1){
            $sql.= " WHERE Estado = 1 AND PkIdUsuario=".$busqueda;
         } elseif ($opcion == 2) {
            $sql .= " WHERE Estado = 1 AND Usuario='".$busqueda."'";
        }elseif ($opcion == 3) {
            $sql .= " WHERE Estado = 1 AND FkIdSucursalBarberiaUsuario=".$busqueda." AND (Rol='BS' OR Rol='B')";
        }
        else{
            $sql .= "WHERE Estado = 1";
        }
        $db = new DB();     
        if($opcion == 0 || $opcion == 3){
            $row = $db->listar($sql);
        }elseif($opcion == 1 || $opcion == 2){
            $row = $db->obtenerUno($sql);
        }
        if(count($row) > 0 && ($opcion==0 || $opcion == 3)){
             $usuario = $this->parseDataList($row);
        }elseif (count($row) > 0 && ($opcion==1 || $opcion==2)) {
             $usuario = $this->parseDataOne($row);
        }
        if(isset($usuario)){
            return $usuario;
        }
        return array();
    }
    
    function obtenerDatosEmail($idUsuario, $idSucursal){
        $sql = "SELECT group_concat(Email) AS correo, (SELECT Descripcion from sucursalbarberia WHERE PkIdSucursalBarberia=".$idSucursal.") AS barberia FROM emailusuario WHERE  FkIdUsuarioEmail= ".$idUsuario." and Estado=1 GROUP BY FkIdUsuarioEmail";
        $db = new DB();
        $row = $db->obtenerUno($sql);
        return $row;
    }
            
    function agregarTelefono($telefonos){
        $db = new DB();
        $sql = "INSERT INTO telefonousuario (FkIdUsuarioTelefono  ,Telefono, Estado) VALUES ("
        .$telefonos->idUsuario."," .$telefonos->telefono.",".$telefonos->estado.")";
        $idTel = $db->agregar($sql);      
        $telefonos->id=$idTel;
        return $telefonos;
    }
    
    function eliminarTelefono($id){
        $db = new DB();
        $sql = "UPDATE telefonousuario SET Estado=0 WHERE PkIdTelefonoUsuario=".$id;
        $db->actualizar($sql);      
    }
    
    function agregarCorreo($correos){
        $db = new DB();
        $sql = "INSERT INTO emailusuario (FkIdUsuarioEmail  ,Email, Estado) VALUES ("
        .$correos->idUsuario.",'" .$correos->correo."',".$correos->estado.")";
        $idCorreo = $db->agregar($sql);        
        $correos->id=$idCorreo;
        return $correos;
    }
    
    function eliminarCorreo($id){
        $db = new DB();
        $sql = "UPDATE emailusuario SET Estado=0 WHERE PkIdEmailUsuario=".$id;
        $db->actualizar($sql);      
    }
        
    function obtenerTelefono($id){
        $sql = "SELECT PkIdTelefonoUsuario, Telefono, Estado FROM telefonousuario WHERE Estado = 1 AND FkIdUsuarioTelefono=".$id;
        $db = new DB();
        $row = $db->listar($sql);
        return $row;
    }
    
    function obtenerCorreo($id){
        $sql = "SELECT PkIdEmailUsuario , Email, Estado FROM emailusuario WHERE Estado = 1 AND FkIdUsuarioEmail =".$id;
        $db = new DB();
        $row = $db->listar($sql);
        return $row;
    }
    
    function listarUsuarios(){
        $sql = "SELECT SELECT PkIdUsuario,FkIdSucursalBarberiaUsuario,Nombre, PrimerApellido, SegundoApellido,Usuario,Contrasenna,Tipo,Estado,Rol,TiempoBarbero FROM usuarios";
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioList = $this->parseRowAUsuarioList($rowList);
        return $usuarioList;
    }
    
    function parseRowTelefono($telefonos) {
        $arrayTelefonos =  array();
        foreach ($telefonos as $row) {
            $tel = new Telefono();
            if(isset($row['PkIdTelefonoUsuario'])){
                $tel->id = $row['PkIdTelefonoUsuario'];
            }
            if(isset($row['Telefono'])){
                $tel->telefono = $row['Telefono'];
            }
            if(isset($row['Estado'])){
                $tel->estado = $row['Estado'];
            }
            array_push($arrayTelefonos, $tel);
        }
       return $arrayTelefonos;
    }
           
    function parseRowCorreo($email) {
        $arrayCorreo = array();
        foreach ($email as $row) {
            $correos = new Correo();
            if(isset($row['PkIdEmailUsuario'])){
                $correos->idCorreo = $row['PkIdEmailUsuario'];
            }
            if(isset($row['Email'])){
                $correos->correo = $row['Email'];
            }
              if(isset($row['Estado'])){
                $correos->estado = $row['Estado'];
            }
            array_push($arrayCorreo, $correos);
        }
       return $arrayCorreo;
    }
    
    function parseRowUsuario($row,$rowTelefono,$rowCorreo,$rowServicios,$rowHorarios) {
        $user = new Usuario();
        if(isset($row['Nombre'])){
            $user->nombre = $row['Nombre'];
        }
        if(isset($row['PkIdUsuario'])){
            $user->id = $row['PkIdUsuario'];
        }
        if(isset($row['PrimerApellido'])){
            $user->apellido1 = $row['PrimerApellido'];
        }
        if(isset($row['SegundoApellido'])){
            $user->apellido2 = $row['SegundoApellido'];
        }
        if(isset($row['FkIdSucursalBarberiaUsuario'])){
            $user->idSucursal = $row['FkIdSucursalBarberiaUsuario'];
        }
        if(isset($row['Usuario'])){
            $user->usuario = $row['Usuario'];
        }
        if(isset($row['Contrasenna'])){
            $user->contrasenna = $row['Contrasenna'];
        }
        if(isset($row['Tipo'])){
            $user->tipo = $row['Tipo'];
        }
        if(isset($row['Estado'])){
            $user->estado = $row['Estado'];
        }  
        if(isset($row['Rol'])){
            $user->rol = $row['Rol'];
        }  
        if(isset($row['TiempoBarbero'])){
            $user->tiempoBarbero = $row['TiempoBarbero'];
        }  
        
        $user->telefono = $this->parseRowTelefono($rowTelefono);
        $user->correo = $this->parseRowCorreo($rowCorreo);
        $user->servicios = $rowServicios;
        $user->horarios = $rowHorarios;
        return $user;
    }
    
     function parseDataList($rowList) {
        $objServicio = new DBServicio ();
        $objHorario = new DBHorarioBarbero();
        $parseDatos = array();
        foreach ($rowList as $row) {
            $telefono= $this->obtenerTelefono($row["PkIdUsuario"]);
            $correo= $this->obtenerCorreo($row["PkIdUsuario"]);
            $servicios= $objServicio->obtenerServicio($row["PkIdUsuario"], 2);     
            $horarios= $objHorario->obtenerHorario($row["PkIdUsuario"], 2); 
            array_push($parseDatos, $this->parseRowUsuario($row, $telefono,$correo,$servicios,$horarios));
        }
        return $parseDatos;
    }
    
     function parseDataOne($row) {
        $objServicio = new DBServicio ();
        $objHorario = new DBHorarioBarbero();
        $telefono= $this->obtenerTelefono($row["PkIdUsuario"]);
        $correo= $this->obtenerCorreo($row["PkIdUsuario"]);
        $servicios= $objServicio->obtenerServicio($row["PkIdUsuario"], 2);     
        $horarios= $objHorario->obtenerHorario($row["PkIdUsuario"], 2); 
        return $this->parseRowUsuario($row, $telefono,$correo,$servicios,$horarios); 
    }
    
} 
