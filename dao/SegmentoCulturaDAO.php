<?php

class SegmentoCulturaDAO {
    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    //Função para inserir novo Segmento/Cultura na tabela de SegmentoCultura
    public function insertSegmentoCultura($segmentoCultura) {
        try {
            $status = $this->connection->prepare("INSERT INTO segmentocultura(id, descricao) VALUES (null, ?)");
            
            $status->bindValue(1, $segmentoCultura->descricao);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao inserir novo Segmento/Cultura!";
        }
    }

    //Função para pesquisar e retornar todos os dados dos Segmento/Culturas no cadastro de SegmentoCultura
    public function searchSegmentoCultura() {
        try {
            $status = $this->connection->query("SELECT * FROM segmentocultura ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar SegmentoCultura' . $e;
        }	
    }

    //Função para pesquisar e retornar todos os dados dos Segmento/Culturas no cadastro de SegmentoCultura informando parâmetro
    public function searchSegmentoCulturaPar($descricao) {
        try {
            $status = $this->connection->query("SELECT * FROM segmentocultura WHERE descricao = '$descricao'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_CLASS, 'SegmentoCulturaModel');

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar SegmentoCultura' . $e;
        }	
    }

    //Função para pesquisar e retornar todos os dados dos Segmento/Culturas no cadastro de SegmentoCultura informando o 'id'
    public function searchSegmentoCulturaId($id) {
        try {
            $status = $this->connection->query("SELECT * FROM segmentocultura WHERE id = '$id'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            //$this->connection = null; //Manter comentado

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar SegmentoCultura' . $e;
        }	
    }

    /* Função para verificar se o nome do SegmentoCultura já existe com 'id' diferente 
     * no cadastro de SegmentoCultura, informando parâmetros.
     */
    public function searchSegmentoCulturaDuplicidade($descricao, $id) {
        try {

            $status = $this->connection->query("SELECT * FROM segmentocultura WHERE descricao = '$descricao' AND id != '$id'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar SegmentoCultura' . $e;
        }	
    }

    //Função para pesquisar o nome (ou parte) so SegmentoCultura no cadastro de SegmentoCultura
    public function searchSegmentoCulturaVarredura($segmentocultura) {
        try {
            $status = $this->connection->query("SELECT * FROM segmentocultura WHERE descricao LIKE '%$segmentocultura%' ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Segmento/Cultura' . $e;
        }	
    }

    //Função para alterar/atualizar os dados de um Segmento/Cultura cadastrada
    public function updateSegmentoCultura($segmentoCultura) {
        try {
            $status = $this->connection->prepare("UPDATE segmentocultura SET descricao = ? WHERE id = ?");
            
            $status->bindValue(1, $segmentoCultura->descricao);
            $status->bindValue(2, $segmentoCultura->id);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar SegmentoCultura!";
        }
    }

    //Função para remover Segmento/Cultura cadastrado no Banco de Dados
    public function deleteSegmentoCultura($id) {
        try {
            $status = $this->connection->prepare("DELETE FROM segmentocultura WHERE id = ?");
            $status->bindValue(1, $id);
            
            $status->execute();
    
            //Encerra a conexão com o BD
            $this->connection = null;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao deletar o SegmentoCultura' . $e;
        }
    }

    //Função para encerrar conexão com o Banco de Dados
    public function close() {
        $this->connection = null;
    }
}