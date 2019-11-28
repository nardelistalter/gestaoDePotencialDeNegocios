<?php
    class UsuariosModel {
        private $id;
        private $email;
        private $senha;
        private $nome;
        private $ativo;
        private $administrador;
        private $hash_recovery;

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