<?php

class EstadoDAO {
    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    //Função para inserir novo Estado na tabela de Estados
    public function insertEstado($estado) {
        try {
            $status = $this->connection->prepare("INSERT INTO estado(id, descricao, sigla) VALUES (null, ?, ?)");
            
            $status->bindValue(1, $estado->descricao);
            $status->bindValue(2, $estado->sigla);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao inserir novo estado!";
        }
    }

    //Função para pesquisar e retornar todos os dados dos estados no cadastro de Estados
    public function searchEstado() {
        try {
            $status = $this->connection->query("SELECT * FROM estado ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar Estados' . $e;
        }	
    }

    //Função para pesquisar o nome o sigla do Estado no cadastro de Estados
    public function searchEstadoVarredura($estado) {
        try {
            $status = $this->connection->query("SELECT * FROM estado WHERE descricao LIKE '%$estado%' OR sigla LIKE '%$estado%'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Estado' . $e;
        }	
    }

    //Função para pesquisar se o nome ou a sigla do Estado existe outro cadastro de Estados
    public function searchEstadoDuplicidade($estado, $sigla, $id) {
        try {
            $status = $this->connection->query("SELECT * FROM estado WHERE descricao = '$estado' OR sigla = '$sigla' AND id != '$id'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_CLASS, 'EstadoModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Estado' . $e;
        }	
    }

    //Função para pesquisar os dados do Estado passando o id por parâmetro
    public function searchEstadoId($estado) {
        try {
            $status = $this->connection->query("SELECT * FROM estado WHERE id = '$estado'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //$this->connection = null; //manter comentado

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Estado' . $e;
        }	
    }

    //Função para pesquisar se o nome do Estado existe no cadastro de Estados
    public function searchEstadoPar($estado) {
        try {
            $status = $this->connection->query("SELECT * FROM estado WHERE descricao = '$estado'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_CLASS, 'EstadoModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Estado' . $e;
        }	
    }

    //Função para pesquisar se a Sigla existe no cadastro de Estados
    public function searchSiglaPar($sigla) {
        try {
            $status = $this->connection->query("SELECT * FROM estado WHERE sigla = '$sigla'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_CLASS, 'EstadoModel');

            //Encerra a conexão com o BD
            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar a Sigla' . $e;
        }	
    }

    //Função para alterar/atualizar os dados de um estado cadastrado
    public function updateEstado($estado) {
        try {
            $status = $this->connection->prepare("UPDATE estado SET descricao = ?, sigla = ? WHERE id = ?");
            
            $status->bindValue(1, $estado->descricao);
            $status->bindValue(2, $estado->sigla);
            $status->bindValue(3, $estado->id);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar estado!";
        }
    }

    //Função para remover estado cadastrado no Banco de Dados
    public function deleteEstado($id) {
        try {
            $status = $this->connection->prepare("DELETE FROM estado WHERE id = ?");
            $status->bindValue(1, $id);
            $status->execute();
    
            //Encerra a conexão com o BD
            $this->connection = null;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao deletar o Estado' . $e;
        }
    }

    //Função para encerrar conexão com o Banco de Dados
    public function close() {
        $this->connection = null;
    }
}