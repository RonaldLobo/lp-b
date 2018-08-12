<?php


class Canton {

    public $canton ='';    
    public $id =0;
    public $estado=0;
    
    function getCanton() {
        return $this->canton;
    }

    function getId() {
        return $this->id;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCanton($canton) {
        $this->canton = $canton;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }


    function parseDto($canton) {
        if(isset($canton->id)){
            $this->id = $canton->id;
        }
        if(isset($canton->estado)){
            $this->estado = $canton->estado;
        }
        if(isset($canton->canton)){
            $this->canton = $canton->canton;
        }
    }
}
