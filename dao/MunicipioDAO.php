<?php

class MunicipioDAO {
    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    //Função para inserir novo Município na tabela de Municípios
    public function insertMunicipio($municipio) {
        try {
            $status = $this->connection->prepare("INSERT INTO municipio(id, descricao, id_microrregiao) VALUES (null, ?, ?)");
            
            $status->bindValue(1, $municipio->descricao);
            $status->bindValue(2, $municipio->id_microrregiao);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao inserir novo Município!";
        }
    }

    //Função para pesquisar e retornar todos os dados dos Municípios no cadastro de Municípios
    public function searchMunicipio() {
        try {
            $status = $this->connection->query("SELECT * FROM municipio ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar Municípios' . $e;
        }	
    }

    //Função para pesquisar os dados da Município passando o id por parâmetro
    public function searchMunicipioId($municipio) {
        try {
            $status = $this->connection->query("SELECT * FROM municipio WHERE id = '$municipio'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            //$this->connection = null; //Manter comentado

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Município' . $e;
        }	
    }

    //Função para pesquisar o nome e o id_microrregiao do Município no cadastro de Municípios
    public function searchMunicipioVarredura($municipio) {
        try {
            $status = $this->connection->query("SELECT * FROM municipio WHERE descricao LIKE '%$municipio%' OR id_microrregiao = '$municipio' ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o municipio' . $e;
        }	
    }

    //Função para pesquisar se o nome do Município existe no cadastro de Municípios
    public function searchMunicipioDuplicidade($municipio, $microrregiao) {
        try {
            $status = $this->connection->query("SELECT * FROM municipio WHERE descricao = '$municipio' AND id_microrregiao = '$microrregiao'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_CLASS, 'municipioModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Município' . $e;
        }	
    }

    //Função para alterar/atualizar os dados de umo Município cadastrada
    public function updateMunicipio($municipio) {
        try {
            $status = $this->connection->prepare("UPDATE municipio SET descricao = ?, id_microrregiao = ? WHERE id = ?");
            
            $status->bindValue(1, $municipio->descricao);
            $status->bindValue(2, $municipio->id_microrregiao);
            $status->bindValue(3, $municipio->id);

            $status->execute();

            //Encerra a conexão com o BD
            //$this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar municipio!";
        }
    }

    //Função para remover Município cadastrado no Banco de Dados
    public function deleteMunicipio($id) {
        try {
            $status = $this->connection->prepare("DELETE FROM municipio WHERE id = ?");
            $status->bindValue(1, $id);
            $status->execute();
    
            //Encerra a conexão com o BD
            $this->connection = null;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao deletar o municipio' . $e;
        }
    }

    //Função para encerrar conexão com o Banco de Dados
    public function close() {
        $this->connection = null;
    }
}