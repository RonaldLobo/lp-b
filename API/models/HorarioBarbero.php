<?php


class HorarioBarbero {
    public $id;
    public $idUsuario;
    public $dia;
    public $horaInicial;
    public $horaFinal;
    public $estado;
    
    function getIdHorario() {
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

    function getHoraFinal() {
        return $this->horaFinal;
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

    function setHoraFinal($horaFinal) {
        $this->horaFinal = $horaFinal;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

function parseDto($horarioBarbero) {
        if(isset($horarioBarbero->idUsuario)){
            $this->idUsuario = $horarioBarbero->idUsuario;
        }
        if(isset($horarioBarbero->id)){
            $this->id = $horarioBarbero->id;
        }
        if(isset($horarioBarbero->estado)){
            $this->estado = $horarioBarbero->estado;
        }
        if(isset($horarioBarbero->dia)){
            $this->dia = $horarioBarbero->dia;
        }
        if(isset($horarioBarbero->horaInicial)){
            $this->horaInicial = $horarioBarbero->horaInicial;
        }
        if(isset($horarioBarbero->horaFinal)){
            $this->horaFinal = $horarioBarbero->horaFinal;
        }
    }
  
     function toJson() {
        $data = array(
        'horarioBarbero' => array(
            'idUsuario' => $this->idUsuario,
            'id'=>$this->id,
            'dia'=> $this->dia,
            'horaInicial'=> $this->horaInicial,
            'estado'=> $this->estado,
            'horaFinal'=> $this->horaFinal
            )
        );
        return json_encode($data);
    }
    
}
