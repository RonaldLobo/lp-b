<?php


class PausaHorarioBarbero {
    
    public $id = 1;
    public $idUsuario = 0;
    public $dia = 0;
    public $horaInicial = '';
    public $duracion = 0;
    public $fecha ='';
    public $estado = '';
    
    function getId() {
        return $this->id;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getDia() {
        return $this->dia;
    }

    function getHoraInicial() {
        return $this->horaInicial;
    }

    function getDuracion() {
        return $this->duracion;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setDia($dia) {
        $this->dia = $dia;
    }

    function setHoraInicial($horaInicial) {
        $this->horaInicial = $horaInicial;
    }

    function setDuracion($duracion) {
        $this->duracion = $duracion;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    
    function parseDto($pausaHorarioBarbero) {
        if(isset($pausaHorarioBarbero->idUsuario)){
            $this->idUsuario = $pausaHorarioBarbero->idUsuario;
        }
        if(isset($pausaHorarioBarbero->dia)){
            $this->dia = $pausaHorarioBarbero->dia;
        }
        if(isset($pausaHorarioBarbero->id)){
            $this->id = $pausaHorarioBarbero->id;
        }
        if(isset($pausaHorarioBarbero->estado)){
            $this->estado = $pausaHorarioBarbero->estado;
        }
        if(isset($pausaHorarioBarbero->horaInicial)){
            $this->horaInicial = $pausaHorarioBarbero->horaInicial;
        }        
        if(isset($pausaHorarioBarbero->duracion)){
            $this->duracion = $pausaHorarioBarbero->duracion;
        }
        if(isset($pausaHorarioBarbero->fecha)){
            $this->fecha = $pausaHorarioBarbero->fecha;
        }
    }
    
      function toJson() {
        $data = array(
        'pausaHorarioBarbero' => array(
            'id'=>$this->id,
            'horaInicial'=> $this->horaInicial,
            'idUsuario'=> $this->idUsuario,
            'dia'=> $this->dia,
            'estado'=> $this->estado,
            'duracion'=>$this->duracion,
            'fecha'=>$this->fecha
            )
        );
        return json_encode($data);
    }
 
    
}
