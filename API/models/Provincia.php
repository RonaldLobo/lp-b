<?php

class Provincia {

    public $provincia ='';    
    public $id =0;
    public $estado=0;
    public $cantones=array();
            
    
    function getProvincia() {
        return $this->provincia;
    }

    function getId() {
        return $this->id;
    }

    function getEstado() {
        return $this->estado;
    }

    function getCantones() {
        return $this->cantones;
    }
    function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setCantones($cantones) {
        $this->cantones = $cantones;
    }
 function parseDto($provincia) {
        if(isset($provincia->id)){
            $this->id = $provincia->id;
        }
        if(isset($provincia->estado)){
            $this->estado = $provincia->estado;
        }
        if(isset($provincia->provincia)){
            $this->provincia = $provincia->provincia;
        }
    }
    
}
