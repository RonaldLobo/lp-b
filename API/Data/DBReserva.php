<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Reserva.php';

class DBReserva {
  
    
    function agregarReserva($reserva){
        $db = new DB();
        $sql = "INSERT INTO reserva (FkIdSucursalBarberiaReserva,FkIdUsuarioReserva,FkIdUsuarioBarbero,FkIdServicioReserva,Dia,HoraInicial,Estado) VALUES ("
                .$reserva->idSucursal.","
                .$reserva->idUsuarioReserva.","
                .$reserva->idUsuarioBarbero.","
                .$reserva->idServicio. ",'"
                .$reserva->dia. "','"
                .$reserva->horaInicial. "',"
                .$reserva->estado. ")";
        $id = $db->agregar($sql);
        $reserva->id = $id;
        return $reserva;
    }
    
    
    function actualizarReserva($reserva){
        $db = new DB();
        $sql = "UPDATE reserva SET "
                . "FkIdSucursalBarberiaReserva=".$reserva->idSucursal.", "
                . "FkIdUsuarioReserva=".$reserva->idUsuarioReserva.","
                . "FkIdServicioReserva=".$reserva->idServicio.", "
                . "Dia='".$reserva->dia."', "
                . "HoraInicial='".$reserva->horaInicial."', "
                . "FkIdUsuarioBarbero=".$reserva->idUsuarioBarbero.", "
                . "Estado=".$reserva->estado." "
                . "WHERE PkIdReserva=".$reserva->id;
        $db->actualizar($sql);
        return $reserva;
    }

    function eliminar($id){
        $db = new DB();
        $sql = "UPDATE reserva SET Estado=0 WHERE PkIdReserva=".$id;
        $db->actualizar($sql);   
    }    
    
    
  
    function obtenerReserva($busqueda, $opcion){
        $sql = "SELECT r.PkIdReserva,r.FkIdSucursalBarberiaReserva,r.FkIdUsuarioReserva,r.FkIdUsuarioBarbero, r.FkIdServicioReserva,r.Dia,r.HoraInicial,r.Estado,
                s.Descripcion AS Servicio, s.Duracion, s.Precio, u.Nombre AS NombreUserReserva, u.PrimerApellido AS PrimerApellidoUserReserva, u.SegundoApellido AS SegundoApellidoUserReserva,  ub.Nombre AS NombreBarbero, ub.PrimerApellido AS PrimerApellidoBarbero, ub.SegundoApellido AS SegundoApellidoBarbero,
                sb.Descripcion AS Sucursal
                FROM reserva r LEFT JOIN servicio s ON s.PkIdServicio= r.FkIdServicioReserva AND s.Estado =1 AND s.FkIdUsuarioServicio=r.FkIdUsuarioBarbero
                LEFT JOIN usuarios u ON u.PkIdUsuario= r.FkIdUsuarioReserva AND u.Estado=1
                LEFT JOIN usuarios ub ON ub.PkIdUsuario= r.FkIdUsuarioBarbero AND ub.Estado=1
                JOIN sucursalbarberia sb ON sb.PkIdSucursalBarberia = r.FkIdSucursalBarberiaReserva WHERE r.Estado=1";
         if($opcion == 1){
            $sql.= " AND PkIdReserva=".$busqueda;
         } elseif ($opcion == 2) {
            $sql.= " AND FkIdSucursalBarberiaReserva=".$busqueda;
         } elseif ($opcion == 3) {
            $sql.= " AND FkIdUsuarioReserva=".$busqueda;
         } elseif ($opcion == 4) {
            $sql.= " AND FkIdServicioReserva=".$busqueda;
        }
        $db = new DB();
        if( $opcion!=1){
            $row = $db->listar($sql);
        }else{
            $row = $db->obtenerUno($sql);            
        }    
        $reserva= array();
        if(count($row) > 0 && $opcion!=1){            
             $reserva = $this->parseDataList($row);
        } elseif (count($row) > 0 && $opcion==1) {
             $reserva =  $this->parseRowReserva($row);              
        }
        return $reserva;
    }
    
    function obtenerReservaFecha($busqueda, $fecha){
        $sql = "SELECT r.PkIdReserva,r.FkIdSucursalBarberiaReserva,r.FkIdUsuarioReserva,r.FkIdUsuarioBarbero, r.FkIdServicioReserva,r.Dia,r.HoraInicial,r.Estado,
                s.Descripcion AS Servicio, s.Duracion, s.Precio, u.Nombre AS NombreUserReserva, u.PrimerApellido AS PrimerApellidoUserReserva, u.SegundoApellido AS SegundoApellidoUserReserva,  ub.Nombre AS NombreBarbero, ub.PrimerApellido AS PrimerApellidoBarbero, ub.SegundoApellido AS SegundoApellidoBarbero,
                sb.Descripcion AS Sucursal
                FROM reserva r LEFT JOIN servicio s ON s.PkIdServicio= r.FkIdServicioReserva AND s.Estado =1 AND s.FkIdUsuarioServicio=r.FkIdUsuarioBarbero
                LEFT JOIN usuarios u ON u.PkIdUsuario= r.FkIdUsuarioReserva AND u.Estado=1
                LEFT JOIN usuarios ub ON ub.PkIdUsuario= r.FkIdUsuarioBarbero AND ub.Estado=1
                JOIN sucursalbarberia sb ON sb.PkIdSucursalBarberia = r.FkIdSucursalBarberiaReserva WHERE r.Estado=1";
            $sql.= " AND FkIdUsuarioBarbero=".$busqueda;
            $sql.= " AND r.dia='".$fecha."'";
//        echo $sql;
        $db = new DB();
        $row = $db->listar($sql);     
        $reserva = $this->parseDataList($row);
        return $reserva;
    }
    
    function obtenerReservaFechaRango($busqueda, $fechaInicial,$fechaFinal){
        $sql = "SELECT r.PkIdReserva,r.FkIdSucursalBarberiaReserva,r.FkIdUsuarioReserva,r.FkIdUsuarioBarbero, r.FkIdServicioReserva,r.Dia,r.HoraInicial,r.Estado,
                s.Descripcion AS Servicio, s.Duracion, s.Precio, u.Nombre AS NombreUserReserva, u.PrimerApellido AS PrimerApellidoUserReserva, u.SegundoApellido AS SegundoApellidoUserReserva,  ub.Nombre AS NombreBarbero, ub.PrimerApellido AS PrimerApellidoBarbero, ub.SegundoApellido AS SegundoApellidoBarbero,
                sb.Descripcion AS Sucursal
                FROM reserva r LEFT JOIN servicio s ON s.PkIdServicio= r.FkIdServicioReserva AND s.Estado =1 AND s.FkIdUsuarioServicio=r.FkIdUsuarioBarbero
                LEFT JOIN usuarios u ON u.PkIdUsuario= r.FkIdUsuarioReserva AND u.Estado=1
                LEFT JOIN usuarios ub ON ub.PkIdUsuario= r.FkIdUsuarioBarbero AND ub.Estado=1
                JOIN sucursalbarberia sb ON sb.PkIdSucursalBarberia = r.FkIdSucursalBarberiaReserva WHERE r.Estado=1";
            $sql.= " AND FkIdUsuarioBarbero=".$busqueda;
            $sql.= " AND r.dia>='".$fechaInicial."'";
            $sql.= " AND r.dia<='".$fechaFinal."'";
//        echo $sql;
        $db = new DB();
        $row = $db->listar($sql);     
        $reserva = $this->parseDataList($row);
        return $reserva;
    }
    
    function parseRowReserva($row) {
        $reserva = new Reserva();
        if(isset($row['PkIdReserva'])){
            $reserva->id = $row['PkIdReserva'];
        }
        if(isset($row['FkIdSucursalBarberiaReserva'])){
            $reserva->idSucursal = $row['FkIdSucursalBarberiaReserva'];
        }
        if(isset($row['FkIdUsuarioReserva'])){
            $reserva->idUsuarioReserva = $row['FkIdUsuarioReserva'];
        }        
        if(isset($row['FkIdUsuarioBarbero'])){
            $reserva->idUsuarioBarbero = $row['FkIdUsuarioBarbero'];
        }
        if(isset($row['FkIdServicioReserva'])){
            $reserva->idServicio = $row['FkIdServicioReserva'];
        }
        if(isset($row['Dia'])){
            $reserva->dia = $row['Dia'];
        }
        if(isset($row['HoraInicial'])){
            $reserva->horaInicial = $row['HoraInicial'];
        }
        if(isset($row['HoraFinal'])){
            $reserva->horaFinal = $row['HoraFinal'];
        }
        if(isset($row['Estado'])){
            $reserva->estado = $row['Estado'];
        }
        if(isset($row['Servicio'])){
            $reserva->servicio = $row['Servicio'];
        }
        if(isset($row['Sucursal'])){
            $reserva->sucursal = $row['Sucursal'];
        }
        if(isset($row['Duracion'])){
            $reserva->duracion = $row['Duracion'];
        }
        if(isset($row['Precio'])){
            $reserva->precio = $row['Precio'];
        }
        if(isset($row['NombreUserReserva'])){
            $reserva->nombreUserReserva = $row['NombreUserReserva'];
        }
        if(isset($row['PrimerApellidoUserReserva'])){
            $reserva->primerApellidoUserReserva = $row['PrimerApellidoUserReserva'];
        }
        if(isset($row['SegundoApellidoUserReserva'])){
            $reserva->segundoApellidoUserReserva = $row['SegundoApellidoUserReserva'];
        }
        if(isset($row['NombreBarbero'])){
            $reserva->nombreBarbero = $row['NombreBarbero'];
        }
        if(isset($row['PrimerApellidoBarbero'])){
            $reserva->primerApellidoBarbero = $row['PrimerApellidoBarbero'];
        }
        if(isset($row['SegundoApellidoBarbero'])){
            $reserva->segundoApellidoBarbero = $row['SegundoApellidoBarbero'];
        }
        return $reserva;
    }
    
 
    function parseDataList($rowList) {
        $parseDatos = array();
        foreach ($rowList as $row) {
            array_push($parseDatos, $this->parseRowReserva($row));
        }
        return $parseDatos;
    }
    
    
    
    
}
