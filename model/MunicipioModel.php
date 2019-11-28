<?php
    class MunicipioModel {
        private $id;
        private $descricao;
        private $id_microrregiao; //fk

        //Métodos mágicos para atribuir/buscar valores das propriedades
        public function __construct() {
        }

        public function __set($propriedade, $valor) {
            $this->$propriedade = $valor;
        }

        public function __get($propriedade) {
            return $this->$propriedade;
        }
    }
?>