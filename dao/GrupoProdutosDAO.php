<?php

class GrupoProdutosDAO {
    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    //Função para inserir novo Grupo de Produtos na tabela de grupoProduto
    public function insertGrupoProduto($grupoProduto) {
        try {
            $status = $this->connection->prepare("INSERT INTO grupoproduto(id, descricao) VALUES (null, ?)");
            
            $status->bindValue(1, $grupoProduto->descricao);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao inserir novo Grupo de Produtos!";
        }
    }

    //Função para pesquisar e retornar todos os dados dos Grupos de Produtos no cadastro de grupoProduto
    public function searchGrupoProduto() {
        try {
            $status = $this->connection->query("SELECT * FROM grupoproduto ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar Grupo de Produtos!' . $e;
        }	
    }

    //Função para pesquisar e retornar todos os dados dos Grupos de Produtos no cadastro de GrupoProduto informando parâmetro
    public function searchGrupoProdutoPar($descricao) {
        try {
            $status = $this->connection->query("SELECT * FROM grupoProduto WHERE descricao = '$descricao'");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_CLASS, 'GrupoProdutosModel');

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar Grupo de Produtos' . $e;
        }	
    }

    //Função para pesquisar e retornar todos os dados dos Grupos de Produtos no cadastro de grupoProduto informando o 'id'
    public function searchGrupoProdutoId($id) {
        try {
            $status = $this->connection->query("SELECT * FROM grupoproduto WHERE id = '$id'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            //$this->connection = null; //Manter comentado. Precisa manter conexão por fazer parte de um loop

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar Grupo de Produtos' . $e;
        }	
    }

    /* Função para verificar se o nome do grupoProduto já existe com 'id' diferente 
     * no cadastro de grupoProduto, informando parâmetros.
     */
    public function searchGrupoProdutoDuplicidade($descricao, $id) {
        try {
            $status = $this->connection->query("SELECT * FROM grupoproduto WHERE descricao = '$descricao' AND id != '$id'");

            $array = array();
            $array = $status->fetch(PDO::FETCH_OBJ);

            //Encerra a conexão com o BD
            $this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar Grupo de Produtos' . $e;
        }	
    }

    //Função para pesquisar o nome (ou parte) so grupoProduto no cadastro de grupoProduto
    public function searchGrupoProdutoVarredura($grupoProduto) {
        try {
            $status = $this->connection->query("SELECT * FROM grupoproduto WHERE descricao LIKE '%$grupoProduto%' ORDER BY descricao");

            $array = array();
            $array = $status->fetchAll(PDO::FETCH_OBJ);

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Segmento/Cultura' . $e;
        }	
    }

    //Função para alterar/atualizar os dados de um Grupo de Produtos cadastrada
    public function updateGrupoProduto($grupoProduto) {
        try {
            $status = $this->connection->prepare("UPDATE grupoProduto SET descricao = ? WHERE id = ?");
            
            $status->bindValue(1, $grupoProduto->descricao);
            $status->bindValue(2, $grupoProduto->id);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar Grupo de Produtos!";
        }
    }

    //Função para remover Grupo de Produtos cadastrado no Banco de Dados
    public function deleteGrupoProduto($id) {
        try {
            $status = $this->connection->prepare("DELETE FROM grupoProduto WHERE id = ?");
            $status->bindValue(1, $id);
            
            $status->execute();
    
            //Encerra a conexão com o BD
            $this->connection = null;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao deletar o Grupo de Produtos!' . $e;
        }
    }

    //Função para encerrar conexão com o Banco de Dados
    public function close() {
        $this->connection = null;
    }
}