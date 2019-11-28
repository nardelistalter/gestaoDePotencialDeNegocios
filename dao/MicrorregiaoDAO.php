<?php

class MicrorregiaoDAO {
    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    //Função para inserir nova microrregiao na tabela de Microrregiões
    public function insertMicrorregiao($microrregiao) {
        try {
            $status = $this->connection->prepare("INSERT INTO microrregiao(id, descricao, id_estado) VALUES (null, ?, ?)");
            
            $status->bindValue(1, $microrregiao->descricao);
            $status->bindValue(2, $microrregiao->id_estado);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao inserir nova microrregiao!";
        }
    }

    //Função para pesquisar e retornar todos os dados dos Microrregiões no cadastro de Microrregiões
    public function searchMicrorregiao() {
        try {
            $status = $this->connection->query("SELECT * FROM microrregiao ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar Microrregiões' . $e;
        }	
    }

    //Função para pesquisar os dados da Microrregião passando o id por parâmetro
    public function searchMicrorregiaoId($microrregiao) {
        try {
            $status = $this->connection->query("SELECT * FROM microrregiao WHERE id = '$microrregiao' ORDER BY descricao");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Microrregião' . $e;
        }	
    }

    //Função para pesquisar o nome e o id_estado da microrregiao no cadastro de Microrregiões
    public function searchMicrorregiaoVarredura($microrregiao) {
        try {
            $status = $this->connection->query("SELECT * FROM microrregiao WHERE descricao LIKE '%$microrregiao%' OR id_estado = '$microrregiao' ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o microrregiao' . $e;
        }	
    }

    //Função para pesquisar se o nome da microrregiao existe no cadastro de Microrregiões
    public function searchMicrorregiaoDuplicidade($microrregiao, $estado) {
        try {
            $status = $this->connection->query("SELECT * FROM microrregiao WHERE descricao = '$microrregiao' AND id_estado = '$estado'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_CLASS, 'MicrorregiaoModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar a microrregiao' . $e;
        }	
    }

    //Função para alterar/atualizar os dados de uma microrregiao cadastrada
    public function updateMicrorregiao($microrregiao) {
        try {
            $status = $this->connection->prepare("UPDATE microrregiao SET descricao = ?, id_estado = ? WHERE id = ?");
            
            $status->bindValue(1, $microrregiao->descricao);
            $status->bindValue(2, $microrregiao->id_estado);
            $status->bindValue(3, $microrregiao->id);

            $status->execute();

            //Encerra a conexão com o BD
            //$this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar microrregiao!";
        }
    }

    //Função para remover microrregiao cadastrada no Banco de Dados
    public function deleteMicrorregiao($id) {
        try {
            $status = $this->connection->prepare("DELETE FROM microrregiao WHERE id = ?");
            $status->bindValue(1, $id);
            $status->execute();
    
            //Encerra a conexão com o BD
            $this->connection = null;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao deletar o microrregiao' . $e;
        }
    }

    //Função para encerrar conexão com o Banco de Dados
    public function close() {
        $this->connection = null;
    }
}