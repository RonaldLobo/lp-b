<?php


class Barberia {

    public $id=0;
    public $descripcion="";
    public $nombre="";
    public $estado=0;  
    
    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }


    function parseDto($barberia) {
            if(isset($barberia->nombre)){
                $this->nombre = $barberia->nombre;
            }
            if(isset($barberia->id)){
                $this->id = $barberia->id;
            }
            if(isset($barberia->descripcion)){
                $this->descripcion = $barberia->descripcion;
            }
            if(isset($barberia->estado)){
                $this->estado = $barberia->estado;
            }
            
    }
    
    
     function toJson() {
        $data = array(
        'barberia' => array(
            'nombre' => $this->nombre,
            'id'=>$this->id,
            'descripcion'=> $this->descripcion,           
            'estado'=> $this->estado
            )
        );
        return json_encode($data);
    }
    
}
