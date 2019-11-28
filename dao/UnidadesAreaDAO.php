<?php

class UnidadesAreaDAO {
    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    //Função para inserir nova unidadesArea na tabela de UnidadesArea
    public function insertUnidadesArea($unidadesArea) {
        try {
            $status = $this->connection->prepare("INSERT INTO unidadesarea(id, descricao, id_municipio, id_segmentocultura, unidade_medida, qtd_area, mkt_desejado) VALUES (null, ?, ?, ?, ?, ?, ?)");
            
            $status->bindValue(1, $unidadesArea->descricao);
            $status->bindValue(2, $unidadesArea->id_municipio);
            $status->bindValue(3, $unidadesArea->id_segmentocultura);
            $status->bindValue(4, $unidadesArea->unidade_medida);
            $status->bindValue(5, $unidadesArea->qtd_area);
            $status->bindValue(6, $unidadesArea->mkt_desejado);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao inserir nova UnidadesArea!";
        }
    }

    //Função para pesquisar e retornar todos os dados das UnidadesArea no cadastro de UnidadesArea
    public function searchUnidadesArea() {
        try {
            $status = $this->connection->query("SELECT * FROM unidadesarea ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar UnidadesArea' . $e;
        }	
    }

    //Função para pesquisar se existe o id_municipio e o id_segmentocultura da unidadesArea já cadastrados em UnidadesArea
    public function searchUnidadesAreaVarreduraDescricao($unidadesArea) {
        try {
            $status = $this->connection->query("SELECT * FROM unidadesarea WHERE descricao LIKE '%$unidadesArea%'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o unidadesArea' . $e;
        }	
    }

    //Função para pesquisar se existe o id_municipio e o id_segmentocultura da unidadesArea já cadastrados em UnidadesArea
    public function searchUnidadesAreaVarredura($municipio, $segmentoCultura) {
        try {
            $status = $this->connection->query("SELECT * FROM unidadesarea WHERE id_municipio = '$municipio' AND id_segmentocultura = '$segmentoCultura'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o unidadesArea' . $e;
        }	
    }

    //Função para pesquisar se existe o id_municipio e o id_segmentocultura da unidadesArea já cadastrados com outro 'id' em UnidadesArea
    public function searchUnidadesAreaVarreduraIdDiferente($id, $municipio, $segmentoCultura) {
        try {
            $status = $this->connection->query("SELECT * FROM unidadesarea WHERE id_municipio = '$municipio' AND id_segmentocultura = '$segmentoCultura' AND id != '$id'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o unidadesArea' . $e;
        }	
    }

    //Função para pesquisar se o nome da unidadesArea existe no cadastro de UnidadesArea
    public function searchUnidadesAreaDuplicidade($unidadesArea) {
        try {
            $status = $this->connection->query("SELECT * FROM unidadesarea WHERE descricao = '$unidadesArea'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar a unidadesArea' . $e;
        }	
    }

    //Função para pesquisar se o nome da unidadesArea existe no cadastro de UnidadesArea em outro 'id'
    public function searchUnidadesAreaDescricaoIgualIdDiferente($id, $unidadesArea) {
        try {
            $status = $this->connection->query("SELECT * FROM unidadesarea WHERE descricao = '$unidadesArea' AND id != '$id'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar a unidadesArea' . $e;
        }	
    }

    //Função para alterar/atualizar os dados de uma unidadesArea cadastrada
    public function updateUnidadesArea($unidadesArea) {
        try {
            $status = $this->connection->prepare("UPDATE unidadesarea SET descricao = ?, id_municipio = ?, id_segmentocultura = ?, unidade_medida = ?, qtd_area = ?, mkt_desejado = ? WHERE id = ?");
            
            $status->bindValue(1, $unidadesArea->descricao);
            $status->bindValue(2, $unidadesArea->id_municipio);
            $status->bindValue(3, $unidadesArea->id_segmentocultura);
            $status->bindValue(4, $unidadesArea->unidade_medida);
            $status->bindValue(5, $unidadesArea->qtd_area);
            $status->bindValue(6, $unidadesArea->mkt_desejado);
            $status->bindValue(7, $unidadesArea->id);

            $status->execute();

            //Encerra a conexão com o BD
            //$this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar unidadesArea!";
        }
    }

    //Função para remover unidadesArea cadastrada no Banco de Dados
    public function deleteUnidadesArea($id) {
        try {
            $status = $this->connection->prepare("DELETE FROM unidadesarea WHERE id = ?");
            $status->bindValue(1, $id);
            $status->execute();
    
            //Encerra a conexão com o BD
            $this->connection = null;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao deletar o unidadesArea' . $e;
        }
    }

    //Função para encerrar conexão com o Banco de Dados
    public function close() {
        $this->connection = null;
    }
}