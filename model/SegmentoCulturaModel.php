<?php
    class SegmentoCulturaModel {
        private $id;
        private $descricao;

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