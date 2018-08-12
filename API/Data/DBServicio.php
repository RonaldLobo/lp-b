<?php
  
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Servicios.php';

class DBServicio {

    function agregarServicio($servicio){
        $db = new DB();
        $sql = "INSERT INTO servicio (FkIdUsuarioServicio,Descripcion,Duracion,Estado,Precio) VALUES ("
                .$servicio->idUsuario.",'"
                .$servicio->descripcion."',"
                .$servicio->duracion. ", "
                .$servicio->estado. ",'"
                .$servicio->precio. "')";
        $id = $db->agregar($sql);
        $servicio->id = $id;
        return $servicio;
    }
    
    
    function actualizarServicio($servicio){
        $db = new DB();
        $sql = "UPDATE servicio SET "
                . "FkIdUsuarioServicio=".$servicio->idUsuario.", "
                . "Descripcion='".$servicio->descripcion."',"
                . "Duracion=".$servicio->duracion.", "
                . "Estado=".$servicio->estado.","
                . "Precio='".$servicio->precio."' "
                . "WHERE PkIdServicio=".$servicio->id;
        $db->actualizar($sql);
        return $servicio;
    }
   
    function eliminar($id){
        $db = new DB();
        $sql = "UPDATE servicio SET Estado=0 WHERE PkIdServicio=".$id;
        $db->actualizar($sql);   
    }
    
    function obtenerServicio($busqueda, $opcion){
        $sql = "SELECT PkIdServicio,FkIdUsuarioServicio,Descripcion, Duracion,Estado,Precio FROM servicio WHERE Estado=1 ";
        if($opcion == 1){
            $sql.= " AND PkIdServicio=".$busqueda;
        } elseif ($opcion == 2) {
            $sql.= " AND FkIdUsuarioServicio=".$busqueda;
        } elseif ($opcion == 3) {
            $sql.= " AND Descripcion='".$busqueda."'";
        }
        $db = new DB();
       if( $opcion!=1){
            $row = $db->listar($sql);
        }else{
            $row = $db->obtenerUno($sql);            
        }    
        $servicio = array();
        if(count($row) > 0 && $opcion!=1){            
             $servicio = $this->parseDataList($row);
        } elseif (count($row) > 0 && $opcion==1) {
             $servicio =  $this->parseRowServicio($row);              
        }
        return $servicio;
    }


    
    function parseRowServicio($row) {
        $servicio = new Servicios();
        if(isset($row['PkIdServicio'])){
            $servicio->id = $row['PkIdServicio'];
        }
        if(isset($row['FkIdUsuarioServicio'])){
            $servicio->idUsuario = $row['FkIdUsuarioServicio'];
        }
        if(isset($row['Descripcion'])){
            $servicio->descripcion = $row['Descripcion'];
        }
        if(isset($row['Duracion'])){
            $servicio->duracion = $row['Duracion'];
        }
        if(isset($row['Estado'])){
            $servicio->estado = $row['Estado'];
        }
        if(isset($row['Precio'])){
            $servicio->precio = $row['Precio'];
        }
        return $servicio;
    }
    
 
    function parseDataList($rowList) {
        $parseDatos = array();
        foreach ($rowList as $row) {
            array_push($parseDatos, $this->parseRowServicio($row));
        }
        return $parseDatos;
    }
    
    

    
}
