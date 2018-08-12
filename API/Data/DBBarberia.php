<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Barberia.php';

class DBBarberia {
 
    
    function agregarBarberia($barberia){
        $db = new DB();
        $sql = "INSERT INTO barberia (Nombre,Descripcion,Estado) VALUES ('"
                .$barberia->nombre."','"
                .$barberia->descripcion."',"
                .$barberia->estado. ")";
        $id = $db->agregar($sql);
        $barberia->id = $id;
        return $barberia;
    }
    
    
    function actualizarBarberia($barberia){
        $db = new DB();
        $sql = "UPDATE barberia SET "
                . "Nombre='".$barberia->nombre."', "
                . "Descripcion='".$barberia->descripcion."',"
                . "Estado=".$barberia->estado
                . " WHERE PkIdBarberia=".$barberia->id;
        $db->actualizar($sql);
        return $barberia;
    }
   
    function eliminar($id){
        $db = new DB();
        $sql = "UPDATE barberia SET Estado=0 WHERE PkIdBarberia=".$id;
        $db->actualizar($sql);   
    }
   
    function obtenerBarberia($busqueda, $opcion){
        $sql = "SELECT PkIdBarberia,Nombre,Descripcion,Estado FROM barberia WHERE Estado=1";
        if($opcion == 1){
            $sql.= " AND PkIdBarberia=".$busqueda;
        } elseif ($opcion == 2) {
            $sql.= " AND Nombre LIKE '%".$busqueda."%'";
        } elseif ($opcion == 3) {
            $sql.= " AND Nombre = '".$busqueda."'";
        }
        $db = new DB();        
        if($opcion == 0 || $opcion==2){
            $row = $db->listar($sql);
        }else{
            $row = $db->obtenerUno($sql);            
        }
        $barberia= array();
        if(count($row) > 0 && ($opcion==0 || $opcion==2)){            
             $barberia = $this->parseDataList($row);
        } elseif (count($row) > 0 && ($opcion==1 || $opcion==3)) {
             $barberia =  $this->parseRowBarberia($row);              
        }
        return $barberia;
    }
    
    function parseRowBarberia($row) {
        $barberia = new Barberia();
        if(isset($row['PkIdBarberia'])){
            $barberia->id = $row['PkIdBarberia'];
        }
        if(isset($row['Nombre'])){
            $barberia->nombre = $row['Nombre'];
        }
        if(isset($row['Descripcion'])){
            $barberia->descripcion = $row['Descripcion'];
        }
        if(isset($row['Estado'])){
            $barberia->estado = $row['Estado'];
        }
        return $barberia;
    }
    
 
    function parseDataList($rowList) {
        $parseDatos = array();
        foreach ($rowList as $row) {
            array_push($parseDatos, $this->parseRowBarberia($row));
        }
        return $parseDatos;
    }
    
  
       
  
   
    
}
