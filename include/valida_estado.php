<?php
    //session_start();
    include '../persistence/ConnectionDB.php';

    class estado_validate {

        public static function estadoJaCadastrado($estado) {            
            $query = "SELECT descricao FROM estado WHERE descricao = '$estado'";
            $result = mysqli_query($con, $query);    
            $row = mysqli_num_rows($result); //Conta o nº de linhas que combinam com a consulta

            if ($row == 1) {
                return false;
            } else {
                return true;    
            }            
        }

        public static function siglaJaCadastrada($sigla) {
            $query = "SELECT sigla FROM estado WHERE sigla = '$sigla'";
            $result = mysqli_query($con, $query);    
            $row = mysqli_num_rows($result); //Conta o nº de linhas que combinam com a consulta

            if ($row == 1) {
                return false;
            } else {
                return true;    
            }            
        }
    }    
?>