<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Sucursal.php';

class DbSucursal {

    function agregarSucursal($sucursal,$telefonos,$correos){
        $db = new DB();
        $sql = "INSERT INTO sucursalbarberia (FkIdCantonSucursalBarberia  ,FkIdBarberiaSucursalBarberia,Descripcion,DetalleDireccion,Estado) VALUES ("
                .$sucursal->idCanton.","
                .$sucursal->idBarberia.",'"
                .$sucursal->descripcion."', '"
                .$sucursal->detalleDireccion. "',"
                .$sucursal->estado. ")";
            $id = $db->agregar($sql);
            if ($id >0){
                foreach($telefonos as $tel){
                    $sql = "INSERT INTO telefonosucursal (FkIdSucursalBarberiaTelefono ,Telefono, Estado) VALUES ("
                    .$id.",'"
                    .$tel->telefono."',".$tel->estado.")";
                    $idTel = $db->agregar($sql);
                    $sucursal->AgregarTelefono($tel);
                }
                if ($idTel >0){
                    foreach ($correos as $email){
                        $sql = "INSERT INTO emailsucursal (FkIdSucursalBarberiaEmail ,Email, Estado) VALUES ("
                        .$id.",'"
                        .$email->correo."',".$email->estado.")";
                         $db->agregar($sql);
                         $sucursal->AgregarCorreo($email);
                    }     
                } 
            }
        $sucursal->id = $id;
        return $sucursal;
    }
    
    
    function actualizarSucursal($sucursal,$telefonos,$correos){
        $db = new DB();
        $sql = "UPDATE sucursalbarberia SET "
                . "FkIdCantonSucursalBarberia =".$sucursal->idCanton.", "
                . "FkIdBarberiaSucursalBarberia=".$sucursal->idBarberia.","
                . "Descripcion='".$sucursal->descripcion."',"
                . "DetalleDireccion ='".$sucursal->detalleDireccion."', "               
                . "Estado=".$sucursal->estado
                . " WHERE PkIdSucursalBarberia=".$sucursal->id;
            if($db->actualizar($sql)) {
                $sqlClean = "DELETE FROM telefonosucursal WHERE FkIdSucursalBarberiaTelefono=".$sucursal->id;
                $db->actualizar($sqlClean);
                foreach ($telefonos  as $tel){
//                    echo $tel->telefono;
                    $sql = "INSERT INTO telefonosucursal (FkIdSucursalBarberiaTelefono ,Telefono, Estado) VALUES ("
                        .$sucursal->id.",'"
                        .$tel->telefono."',".$tel->estado.")";
                    $idTel = $db->agregar($sql);
                    $tel->id = $idTel;
                }
                $sqlClean = "DELETE FROM emailsucursal WHERE FkIdSucursalBarberiaEmail=".$sucursal->id;
                $db->actualizar($sqlClean);
                foreach ($correos  as $email){
                    $sql = "INSERT INTO emailsucursal (FkIdSucursalBarberiaEmail ,Email, Estado) VALUES ("
                        .$sucursal->id.",'"
                        .$email->correo."',".$email->estado.")";
                    $idCorreo = $db->agregar($sql);
                    $email->idCorreo = $idCorreo;
                }
            }
        
        return $sucursal;
    }
   
        
       
    function eliminar($id){
        $db = new DB();
        $sql = "UPDATE sucursalbarberia SET Estado=0 WHERE PkIdSucursalBarberia=".$id;
        $db->actualizar($sql);   
    }   
 
    function obtenerSucursal($busqueda, $opcion){
        $sql = "SELECT s.PkIdSucursalBarberia,s.FkIdCantonSucursalBarberia ,s.FkIdBarberiaSucursalBarberia,s.Descripcion,s.DetalleDireccion,s.Estado, b.Nombre AS NombreBarberia FROM sucursalbarberia s 
       LEFT JOIN barberia b ON s.FkIdBarberiaSucursalBarberia = b.PkIdBarberia WHERE s.Estado=1";
        if($opcion == 1){
            $sql.= " AND PkIdSucursalBarberia=".$busqueda;
         } elseif ($opcion == 2) {
            $sql.= " AND FkIdBarberiaSucursalBarberia=".$busqueda;
         } elseif ($opcion == 3) {
            $sql.= " AND FkIdCantonSucursalBarberia =".$busqueda;
        } elseif ($opcion == 4) {
            $sql.= " AND s.Descripcion = '".$busqueda."'";
        }
        $db = new DB(); 
        
        if( $opcion!=1){
            $row = $db->listar($sql);
        }else{
            $row = $db->obtenerUno($sql);            
        }    
        $sucursal = Array();
        if(count($row) > 0 && $opcion!=1){            
             $sucursal = $this->parseDataList($row);
        } elseif (count($row) > 0 && $opcion==1) {
             $sucursal =  $this->parseDataOneSucursal($row);              
        }
        return $sucursal;
    }
       
    function obtenerTelefono($id){
        $sql = "SELECT PkIdTelefonoSucursal , Telefono, Estado FROM telefonosucursal WHERE FkIdSucursalBarberiaTelefono =".$id;
        $db = new DB();
        $row = $db->listar($sql);
        return $row;
    }
    
    function obtenerCorreo($id){
        $sql = "SELECT PkIdEmailSucursal , Email, Estado FROM emailsucursal WHERE FkIdSucursalBarberiaEmail =".$id;
        $db = new DB();
        $row = $db->listar($sql);
        return $row;
    }
    
    function listarSucursal(){
        $sql = "SELECT s.PkIdSucursalBarberia,s.FkIdCantonSucursalBarberia ,s.FkIdBarberiaSucursalBarberia,s.Descripcion,s.DetalleDireccion,s.Estado, B.Nombre AS NombreBarberia FROM sucursalbarberia s 
        LEFT JOIN barberia b ON s.FkIdBarberiaSucursalBarberia = b.PkIdBarberia ";
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioList = $this->parseRowAUsuarioList($rowList);
        return $usuarioList;
    }
    
    function parseRowTelefono($telefonos) {
//        $tel = new Telefono();
        $arrayTelefonos= array();
        foreach ($telefonos as $row) {
            $tel = new Telefono();
            if(isset($row['PkIdTelefonoSucursal'])){
                $tel->id = $row['PkIdTelefonoSucursal'];
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
        
        $arrayCorreos= array();
        foreach ($email as $row) {
            $correo = new Correo();
            if(isset($row['PkIdEmailSucursal'])){
                $correo->idCorreo = $row['PkIdEmailSucursal'];
            }
            if(isset($row['Email'])){
                $correo->correo = $row['Email'];
            }
              if(isset($row['Estado'])){
                $correo->estado = $row['Estado'];
            }
            array_push($arrayCorreos, $correo);
        }
       return $arrayCorreos;
    }
    
    function parseRowSucursal($row, $rowTelefono,$rowCorreo) {
        $sucursal = new Sucursal();
        if(isset($row['PkIdSucursalBarberia'])){
            $sucursal->id = $row['PkIdSucursalBarberia'];
        }
        if(isset($row['FkIdBarberiaSucursalBarberia'])){
            $sucursal->idBarberia = $row['FkIdBarberiaSucursalBarberia'];
        }
        if(isset($row['FkIdCantonSucursalBarberia'])){
            $sucursal->idCanton = $row['FkIdCantonSucursalBarberia'];
        }
        if(isset($row['Descripcion'])){
            $sucursal->descripcion = $row['Descripcion'];
        }
        if(isset($row['DetalleDireccion'])){
            $sucursal->detalleDireccion = $row['DetalleDireccion'];
        }
        if(isset($row['Estado'])){
            $sucursal->estado = $row['Estado'];
        }  
        if(isset($row['NombreBarberia'])){
            $sucursal->nombreBarberia = $row['NombreBarberia'];
        }   
        $sucursal->telefono = $this->parseRowTelefono($rowTelefono);
        $sucursal->correo = $this->parseRowCorreo($rowCorreo);
        return $sucursal;
    }
     
    function parseDataList($rowList) {
        $parseDatos = array();
        foreach ($rowList as $row) {
            $telefono= $this->obtenerTelefono($row["PkIdSucursalBarberia"]);
            $correo= $this->obtenerCorreo($row["PkIdSucursalBarberia"]);
            array_push($parseDatos, $this->parseRowSucursal($row, $telefono,$correo));
        }
        return $parseDatos;
    }
        
    function parseDataOneSucursal($row) {
        $parseDatos = array();
        $telefono= $this->obtenerTelefono($row["PkIdSucursalBarberia"]);
        $correo= $this->obtenerCorreo($row["PkIdSucursalBarberia"]);
        array_push($parseDatos, $this->parseRowSucursal($row, $telefono,$correo));
        return $parseDatos;
    }
    
     function agregarTelefono($telefonos){
        $db = new DB();
        $sql = "INSERT INTO telefonosucursal (FkIdSucursalBarberiaTelefono  ,Telefono, Estado) VALUES ("
        .$telefonos->idUsuario."," .$telefonos->telefono.",".$telefonos->estado.")";
        $idTel = $db->agregar($sql);        
        $telefonos->id=$idTel;
        return $telefonos;
    }
    
    function eliminarTelefono($id){
        $db = new DB();
        $sql = "UPDATE telefonosucursal SET Estado=0 WHERE PkIdTelefonoSucursal=".$id;
        $db->actualizar($sql);      
    }
    
    function agregarCorreo($correos){
        $db = new DB();
        $sql = "INSERT INTO emailsucursal (FkIdSucursalBarberiaEmail  ,Email, Estado) VALUES ("
        .$correos->idUsuario."," .$correos->correo.",".$correos->estado.")";
        $idCorreo = $db->agregar($sql);
        $correos->id=$idCorreo;
        return $correos;
    }
    
    function eliminarCorreo($id){
        $db = new DB();
        $sql = "UPDATE emailsucursal SET Estado=0 WHERE PkIdEmailSucursal=".$id;
        $db->actualizar($sql);      
    }

    
}
