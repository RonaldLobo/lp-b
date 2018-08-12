<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/PausaHorarioBarbero.php';


class DBPausaHorarioBarbero {

    function agregarPausaHorarioBarbero($pausaHorarioBarbero){
        $db = new DB();
        $sql = "INSERT INTO pausahorariobarbero (FkIdUsuarioPausaHorarioBarbero ,Dia ,HoraInicial ,Duracion ,Fecha ,Estado) VALUES ("
                .$pausaHorarioBarbero->idUsuario.",'"
                .$pausaHorarioBarbero->dia."','"
                .$pausaHorarioBarbero->horaInicial. "', "
                .$pausaHorarioBarbero->duracion. ", '"
                .$pausaHorarioBarbero->fecha. "', "
                .$pausaHorarioBarbero->estado. ")";
        $id = $db->agregar($sql);
        $pausaHorarioBarbero->id = $id;
        return $pausaHorarioBarbero;
    }
    
    
    function actualizarPausaHorarioBarbero($pausaHorarioBarbero){
        $db = new DB();
        $sql = "UPDATE pausahorariobarbero SET "
                . "FkIdUsuarioPausaHorarioBarbero=".$pausaHorarioBarbero->idUsuario.", "
                . "Dia='".$pausaHorarioBarbero->dia."',"
                . "Duracion=".$pausaHorarioBarbero->duracion.", "
                . "Estado=".$pausaHorarioBarbero->estado.","
                . "HoraInicial='".$pausaHorarioBarbero->horaInicial."', "
                . "Fecha='".$pausaHorarioBarbero->fecha."' "
                . "WHERE PkIdPausaHorarioBarbero=".$pausaHorarioBarbero->id;
        $db->actualizar($sql);
        return $pausaHorarioBarbero;
    }
   
    function eliminar($id){
        $db = new DB();
        $sql = "UPDATE pausahorariobarbero SET Estado=0 WHERE PkIdPausaHorarioBarbero=".$id;
        $db->actualizar($sql);   
    }
    
    
    function obtenerPausaHorarioBarbero($busqueda, $opcion){
        $sql = "SELECT PkIdPausaHorarioBarbero ,FkIdUsuarioPausaHorarioBarbero,Dia, Duracion,Estado,HoraInicial,Fecha FROM pausahorariobarbero ";
        if($opcion == 1){
            $sql.= " WHERE PkIdPausaHorarioBarbero=".$busqueda;
         } elseif ($opcion == 2) {
            $sql.= " WHERE FkIdUsuarioPausaHorarioBarbero=".$busqueda;
        }
        $db = new DB();
        if( $opcion!=1){
            $row = $db->listar($sql);
        }else{
            $row = $db->obtenerUno($sql);            
        } 
        $pausaHorarioBarbero=array();
        if(count($row) > 0 && $opcion!=1){            
             $pausaHorarioBarbero = $this->parseDataList($row);
        } elseif (count($row) > 0 && $opcion==1) {
             $pausaHorarioBarbero =  $this->parseRowPausaHorarioBarbero($row);              
        }
        return $pausaHorarioBarbero;
    }


    
    function parseRowPausaHorarioBarbero($row) {
        $pausaHorarioBarbero = new PausaHorarioBarbero();
        if(isset($row['PkIdPausaHorarioBarbero'])){
            $pausaHorarioBarbero->id = $row['PkIdPausaHorarioBarbero'];
        }
        if(isset($row['FkIdUsuarioPausaHorarioBarbero'])){
            $pausaHorarioBarbero->idUsuario = $row['FkIdUsuarioPausaHorarioBarbero'];
        }
        if(isset($row['Dia'])){
            $pausaHorarioBarbero->dia = $row['Dia'];
        }
        if(isset($row['Duracion'])){
            $pausaHorarioBarbero->duracion = $row['Duracion'];
        }
        if(isset($row['Estado'])){
            $pausaHorarioBarbero->estado = $row['Estado'];
        }
        if(isset($row['HoraInicial'])){
            $pausaHorarioBarbero->horaInicial = $row['HoraInicial'];
        }
        if(isset($row['Fecha'])){
            $pausaHorarioBarbero->fecha = $row['Fecha'];
        }
        return $pausaHorarioBarbero;
    }
    
 
    function parseDataList($rowList) {
        $parseDatos = array();
        foreach ($rowList as $row) {
            array_push($parseDatos, $this->parseRowPausaHorarioBarbero($row));
        }
        return $parseDatos;
    }
  
    
    
}
