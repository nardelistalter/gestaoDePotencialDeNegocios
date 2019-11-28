<?php
class ConnectionDB extends PDO {
    private static $instance = null;

    public function ConnectionDB($dsn, $usuario, $senha) {
        //Construtor da classe pai (parent) -> PDO
        parent::__construct($dsn, $usuario, $senha);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            try {
                //Cria uma conexão e retorna a instância dela
                
                //VPS
                //self::$instance = new ConnectionDB("mysql:dbname=crm_db;host=54.39.123.196","root", "casca123@DEVS");

                //Localhost
                self::$instance = new ConnectionDB("mysql:dbname=crm_db;host=localhost","root", "");

                //echo "Conectado ao banco de dados!";
            } catch (PDOException $e) {
                echo "Ocorreram PDO!";
                echo "$e";
                exit();
            }   
        }
        return self::$instance;
    }
}