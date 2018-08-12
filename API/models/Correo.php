<?php

class Correo {
    public $correo;
    public $estado;
    public $idCorreo;
    public $idUsuario;
    
    
    function getCorreo() {
        return $this->correo;
    }

    function getEstado() {
        return $this->estado;
    }

    function getIdCorreo() {
        return $this->idCorreo;
    }
    
    function getIdUsuario() {
        return $this->idUsuario;
    }


    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setIdCorreo($idCorreo) {
        $this->idCorreo = $idCorreo;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function parseDto($correo) {
        if(isset($correo->idCorreo)){
            $this->idCorreo = $correo->idCorreo;
        }
        if(isset($correo->estado)){
            $this->estado = $correo->estado;
        }
        if(isset($correo->correo)){
            $this->correo = $correo->correo;
        }
        if(isset($correo->idUsuario)){
            $this->idUsuario = $correo->idUsuario;
        }
    }
    
    function toJson() {
        $data = array(
        'correo' => array(
            'idUsuario' => $this->idUsuario,
            'idCorreo'=>$this->idCorreo,
            'correo'=> $this->correo,
            'estado'=> $this->estado
            )
        );
        return json_encode($data);
    }
    
}
