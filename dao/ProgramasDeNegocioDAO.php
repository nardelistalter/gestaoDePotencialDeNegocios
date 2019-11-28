<?php

class ProgramasDeNegocioDAO {
    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    //Função para inserir novo programasDeNegocio na tabela de programasDeNegocio
    public function insertProgramasDeNegocio($programasDeNegocio) {
        try {
            $status = $this->connection->prepare("INSERT INTO programadenegocio(id, descricao, id_segmentocultura, id_gruposprodutos, vlrunidporarea) VALUES (null, ?, ?, ?, ?)");
            
            $status->bindValue(1, $programasDeNegocio->descricao);
            $status->bindValue(2, $programasDeNegocio->id_segmentocultura);
            $status->bindValue(3, $programasDeNegocio->id_gruposprodutos);
            $status->bindValue(4, $programasDeNegocio->vlrunidporarea);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao inserir novo ProgramasDeNegocio!";
        }
    }

    //Função para pesquisar e retornar todos os dados das programasDeNegocio no cadastro de programasDeNegocio
    public function searchProgramasDeNegocio() {
        try {
            $status = $this->connection->query("SELECT * FROM programadenegocio ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar ProgramasDeNegocio' . $e;
        }	
    }

    //Função para pesquisar se existe o id_municipio e o id_segmentocultura da unidadesArea já cadastrados em UnidadesArea
    public function searchProgramasDeNegocioDescricao($programasDeNegocio) {
        try {
            $status = $this->connection->query("SELECT * FROM programadenegocio WHERE descricao LIKE '%$programasDeNegocio%'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_CLASS, 'ProgramasDeNegocioModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o unidadesArea' . $e;
        }	
    }

    //Função para verificar se já existe o id_segmentocultura e o id_gruposprodutos no cadastro de programasDeNegocio
    public function searchProgramasDeNegocioVarredura($id_segmentocultura, $id_grupoProdutos) {
        try {
            $status = $this->connection->query("SELECT * FROM programadenegocio WHERE id_segmentocultura = '$id_segmentocultura' AND id_gruposprodutos = '$id_grupoProdutos'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o ProgramasDeNegocio' . $e;
        }	
    }

    //Função para pesquisar se existe o id_segmentocultura e o id_grupoProdutos da unidadesArea já cadastrados com outro 'id' no Programa De Negócio
    public function searchProgramasDeNegocioVarreduraIdDiferente($id, $id_segmentocultura, $id_grupoProdutos) {
        try {
            $status = $this->connection->query("SELECT * FROM programadenegocio WHERE id_segmentocultura = '$id_segmentocultura' AND id_gruposprodutos = '$id_grupoProdutos' AND id != '$id'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o unidadesArea' . $e;
        }	
    }


    //Função para pesquisar se o nome da programasDeNegocio existe no cadastro de programasDeNegocio
    public function searchProgramasDeNegocioDuplicidade($programasDeNegocio) {
        try {
            $status = $this->connection->query("SELECT * FROM programadenegocio WHERE descricao = '$programasDeNegocio'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar a ProgramasDeNegocio' . $e;
        }	
    }

    //Função para pesquisar se o nome do Programa de Negócios existe no cadastro de Programa de Negócios em outro 'id'
    public function searchProgramasDeNegocioDescricaoIgualIdDiferente($id, $programasDeNegocio) {
        try {
            $status = $this->connection->query("SELECT * FROM programadenegocio WHERE descricao = '$programasDeNegocio' AND id != '$id'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar a unidadesArea' . $e;
        }	
    }

    //Função para alterar/atualizar os dados de uma programasDeNegocio cadastrada
    public function updateProgramasDeNegocio($programasDeNegocio) {
        try {
            $status = $this->connection->prepare("UPDATE programadenegocio SET descricao = ?, id_segmentocultura = ?, id_gruposprodutos = ?, vlrunidporarea = ? WHERE id = ?");
            
            $status->bindValue(1, $programasDeNegocio->descricao);
            $status->bindValue(2, $programasDeNegocio->id_segmentocultura);
            $status->bindValue(3, $programasDeNegocio->id_gruposprodutos);
            $status->bindValue(4, $programasDeNegocio->vlrunidporarea);
            $status->bindValue(5, $programasDeNegocio->id);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar ProgramasDeNegocio!";
        }
    }

    //Função para remover programasDeNegocio cadastrada no Banco de Dados
    public function deleteProgramasDeNegocio($id) {
        try {
            $status = $this->connection->prepare("DELETE FROM programadenegocio WHERE id = ?");
            $status->bindValue(1, $id);
            $status->execute();
    
            //Encerra a conexão com o BD
            $this->connection = null;
            
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao deletar o ProgramasDeNegocio' . $e;
        }
    }

    //Função para encerrar conexão com o Banco de Dados
    public function close() {
        $this->connection = null;
    }
}