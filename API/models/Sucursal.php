<?php


//require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Telefono.php';

class Sucursal {
     
   
    public $id = 1;
    public $idCanton = 0;
    public $idBarberia = 0;
    public $descripcion = '';
    public $detalleDireccion = '';
    public $estado = '';
    public $nombreBarberia = '';
    public $telefono = array();
    public $correo = array();
        
    
    function getId() {
        return $this->id;
    }

    function getIdCanton() {
        return $this->idCanton;
    }

    function getIdBarberia() {
        return $this->idBarberia;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getDetalleDireccion() {
        return $this->detalleDireccion;
    }

    function getEstado() {
        return $this->estado;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getNombreBarberia() {
        return $this->nombreBarberia;
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setIdCanton($idCanton) {
        $this->idCanton = $idCanton;
    }

    function setIdBarberia($idBarberia) {
        $this->idBarberia = $idBarberia;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setDetalleDireccion($detalleDireccion) {
        $this->detalleDireccion = $detalleDireccion;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }
    function setNombreBarberia($nombreBarberia) {
        $this->nombreBarberia = $nombreBarberia;
    }
        
    function parseDto($sucursal) {
        if(isset($sucursal->idCanton)){
            $this->idCanton = $sucursal->idCanton;
        }
        if(isset($sucursal->id)){
            $this->id = $sucursal->id;
        }
        if(isset($sucursal->estado)){
            $this->estado = $sucursal->estado;
        }
        if(isset($sucursal->idBarberia)){
            $this->idBarberia = $sucursal->idBarberia;
        }
        
        if(isset($sucursal->descripcion)){
            $this->descripcion = $sucursal->descripcion;
        }
        if(isset($sucursal->detalleDireccion)){
            $this->detalleDireccion = $sucursal->detalleDireccion;
        }
    }
    
    function AgregarTelefono($tel){
        array_push($this->telefono, $tel);
    }
    
     function AgregarCorreo($email){
        array_push($this->correo, $email);
    }
     function toJson() {
        $data = array(
        'sucursal' => array(
            'idCanton' => $this->idCanton,
            'id'=>$this->id,
            'idBarberia'=> $this->idBarberia,
            'descripcion'=> $this->descripcion,
            'detalleDireccion'=> $this->detalleDireccion,
            'estado'=> $this->estado,
            'telefono'=>$this->telefono,
            'correo'=>$this->correo
            )
        );
        return json_encode($data);
    }
}
