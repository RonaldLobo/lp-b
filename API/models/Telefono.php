<?php

class Telefono {
    public $telefono;
    public $estado;
    public $id;
    public $idUsuario;
            
    function getTelefono() {
        return $this->telefono;
    }

    function getEstado() {
        return $this->estado;
    }

    function getId() {
        return $this->id;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    
    function parseDto($telefono) {
        if(isset($telefono->id)){
            $this->id = $telefono->id;
        }
        if(isset($telefono->estado)){
            $this->estado = $telefono->estado;
        }
        if(isset($telefono->telefono)){
            $this->telefono = $telefono->telefono;
        }
        if(isset($telefono->idUsuario)){
            $this->idUsuario = $telefono->idUsuario;
        }
    }
    
     function toJson() {
        $data = array(
        'telefono' => array(
            'idUsuario' => $this->idUsuario,
            'id'=>$this->id,
            'telefono'=> $this->telefono,
            'estado'=> $this->estado
            )
        );
        return json_encode($data);
    }
}
