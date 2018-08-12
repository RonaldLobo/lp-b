<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Canton.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Provincia.php';


class DBProvinciaCanton {

    function obtenerProvincia(){
        $sql = "SELECT PkIdProvincia,Provincia,Estado FROM provincia ";
        $db = new DB();
        $row = $db->listar($sql);        
        $cantonList = $this->parseDataList($row);
        return $cantonList;
    }
 
    function obtenerCanton($idProvincia){
        $sql = "SELECT PkIdCanton, FkIdProvinciaCanton,Canton,Estado FROM canton "
        ." WHERE FkIdProvinciaCanton=".$idProvincia;
        $db = new DB();
        $row = $db->listar($sql);        
        return $row;
    }
   
 
    function parseDataList($rowList) {
        $parseDatos = array();
        foreach ($rowList as $row) {
            $canton = $this->obtenerCanton($row["PkIdProvincia"]);
            array_push($parseDatos, $this->parseRowProvinciaCanton($row, $canton));
        }
        return $parseDatos;
    }
    
    function parseRowProvinciaCanton($row,$cantones) {
        $provincia = new Provincia();
        if(isset($row['PkIdProvincia'])){
            $provincia->id = $row['PkIdProvincia'];
        }
        if(isset($row['Provincia'])){
            $provincia->provincia = $row['Provincia'];
        }        
        if(isset($row['Estado'])){
            $provincia->estado = $row['Estado'];
        }                  
        $provincia->cantones = $this->parseRowCanton($cantones);
        return $provincia;
    }
    
     function parseRowCanton($cantones) {
        $arrayCantones =  array();
        foreach ($cantones as $row) {    
            $canton = new Canton();
            if(isset($row['PkIdCanton'])){
                $canton->id = $row['PkIdCanton'];
            }
            if(isset($row['Canton'])){
                $canton->canton = $row['Canton'];
            }
              if(isset($row['Estado'])){
                $canton->estado = $row['Estado'];
            }
            array_push($arrayCantones, $canton);
        }
       return $arrayCantones;
    }
    
  
}
