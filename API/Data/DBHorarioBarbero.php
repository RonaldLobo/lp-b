<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/HorarioBarbero.php';

class DBHorarioBarbero {
   
    
      function agregarHorario($horarioBarbero){
        $db = new DB();
        $sql = "INSERT INTO horariobarbero (FkIdUsuarioHorarioBarbero,Dia,HoraInicial,HoraFinal,Estado) VALUES ("
                .$horarioBarbero->idUsuario.",'"
                .$horarioBarbero->dia."','"
                .$horarioBarbero->horaInicial. "', '"
                .$horarioBarbero->horaFinal. "', "
                .$horarioBarbero->estado. ")";
        $id = $db->agregar($sql);
        $horarioBarbero->id = $id;
        return $horarioBarbero;
    }
    
    
    function actualizarHorario($horarioBarbero){
        $db = new DB();
        $sql = "UPDATE horariobarbero SET "
                . "FkIdUsuarioHorarioBarbero=".$horarioBarbero->idUsuario.", "
                . "Dia='".$horarioBarbero->dia."',"
                . "HoraInicial='".$horarioBarbero->horaInicial."',"
                . "HoraFinal='".$horarioBarbero->horaFinal."', "
                . "Estado=".$horarioBarbero->estado." "
                . "WHERE PkIdHorarioBarbero=".$horarioBarbero->id;
        $db->actualizar($sql);
        return $horarioBarbero;
    }
    
    
    function eliminar($id){
        $db = new DB();
        $sql = "UPDATE horariobarbero SET Estado=0 WHERE PkIdHorarioBarbero=".$id;
        $db->actualizar($sql);   
    } 
    
    function obtenerHorario($busqueda, $opcion){
        $sql = "SELECT PkIdHorarioBarbero,FkIdUsuarioHorarioBarbero,Dia, HoraInicial,HoraFinal,Estado FROM horariobarbero WHERE Estado=1";
        if($opcion == 1){
            $sql.= " AND PkIdHorarioBarbero=".$busqueda;
         } elseif ($opcion == 2) {
            $sql.= " AND FkIdUsuarioHorarioBarbero=".$busqueda;
        }
        $db = new DB();
        if( $opcion!=1){
            $row = $db->listar($sql);
        }else{
            $row = $db->obtenerUno($sql);            
        }    
        $horarioBarbero = array();
        if(count($row) > 0 && $opcion!=1){            
             $horarioBarbero = $this->parseDataList($row);
        } elseif (count($row) > 0 && $opcion==1) {
             $horarioBarbero =  $this->parseRowHorario($row);              
        }
        return $horarioBarbero;
    }


    
    function parseRowHorario($row) {
        $horario = new HorarioBarbero();
        if(isset($row['PkIdHorarioBarbero'])){
            $horario->id = $row['PkIdHorarioBarbero'];
        }
        if(isset($row['FkIdUsuarioHorarioBarbero'])){
            $horario->idUsuario = $row['FkIdUsuarioHorarioBarbero'];
        }
        if(isset($row['Dia'])){
            $horario->dia = $row['Dia'];
        }
        if(isset($row['HoraInicial'])){
            $horario->horaInicial = $row['HoraInicial'];
        }
        if(isset($row['HoraFinal'])){
            $horario->horaFinal = $row['HoraFinal'];
        }
        if(isset($row['Estado'])){
            $horario->estado = $row['Estado'];
        }
        return $horario;
    }
    
 
    function parseDataList($rowList) {
        $parseDatos = array();
        foreach ($rowList as $row) {
            array_push($parseDatos, $this->parseRowHorario($row));
        }
        return $parseDatos;
    }
    
    

    
}
