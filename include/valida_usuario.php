<?php

    class UsuarioValidate {
        public static function validarSenha($pass, $pass_confirm) {
            if ($pass == $pass_confirm) {
                return true;
            } else {
                return false;
            }            
        }
        
        public static function testarEmail($email) {
            $Sintaxe = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
            if (preg_match($Sintaxe, $email)) {
                return true;
            } else {
                return false;
            }
        }
    }    
?>