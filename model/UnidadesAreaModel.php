<?php
    class UnidadesAreaModel {
        private $id;
        private $descricao;
        private $id_municipio; //fk
        private $id_segmentocultura; //fk
        private $unidade_medida;
        private $qtd_area;
        private $mkt_desejado;

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