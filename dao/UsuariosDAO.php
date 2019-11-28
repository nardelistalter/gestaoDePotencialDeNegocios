<?php

class UsuariosDAO {
    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    //Função para inserir novo Usuário na tabela de Usuário
    public function insertUsuario($usuario) {
        try {
            $status = $this->connection->prepare("INSERT INTO usuarios(id, email, senha, nome) VALUES (null, ?, ?, ?)");
            
            $status->bindValue(1, $usuario->email);
            $status->bindValue(2, $usuario->senha);
            $status->bindValue(3, $usuario->nome);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao inserir novo usuario!";
        }
    }

    //Função para pesquisar no cadastro de Usuários
    public function searchUsuario() {
        try {
            $status = $this->connection->query("SELECT id, email, nome, ativo, administrador FROM usuarios");

            $array = array();

            $array = $status->fetchAll(PDO::FETCH_OBJ);
            //$array = $status->fetchAll(PDO::FETCH_CLASS, 'UsuariosModel');

            //$this->connection = null;

            return $array;
            
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar usuários' . $e;
        }	
    }

    //Função para buscar o nome no cadastro de Usuarios
    public function searchNome($email) {
        try {
            $status = $this->connection->query("SELECT nome FROM usuarios WHERE email = '$email'");

            $array = array();

            $array = $status->fetch(PDO::FETCH_OBJ);
            //$array = $status->fetchAll(PDO::FETCH_CLASS, 'UsuariosModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Usuario' . $e;
        }	
    }

    //Função para buscar o email no cadastro de Usuarios
    public function searchEmail($hash) {
        try {
            $status = $this->connection->query("SELECT email FROM usuarios WHERE hash_recovery = '$hash'");

            $array = array();

            $array = $status->fetch(PDO::FETCH_OBJ);
            //$array = $status->fetchAll(PDO::FETCH_CLASS, 'UsuariosModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Usuario' . $e;
        }	
    }

    //Função para verificar a existência de hash_recovery cadastrada
    public function searchHash($hash) {
        try {
            $status = $this->connection->query("SELECT * FROM usuarios WHERE hash_recovery = '$hash'");

            $array = array();

            $array = $status->fetch(PDO::FETCH_OBJ);
            //$array = $status->fetchAll(PDO::FETCH_CLASS, 'UsuariosModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Usuario' . $e;
        }	
    }

    //Função para pesquisar no cadastro de Usuários
    public function searchUsuarioLogin($email, $senha) {
        try {
            $status = $this->connection->query("SELECT nome FROM usuarios WHERE email = '$email' AND senha = sha1(md5('$senha')) AND ativo = '1'");

            $array = array();

            $array = $status->fetch(PDO::FETCH_OBJ);
            //$array = $status->fetchAll(PDO::FETCH_CLASS, 'UsuariosModel');

            //$this->connection = null;

            return $array;
            
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar usuários' . $e;
        }	
    }

    //Função para pesquisar qualquer dado no cadastro de Usuarios
    public function searchUsuarioVarredura($usuario) {
        try {

            $status = $this->connection->query("SELECT id, email, nome, ativo, administrador FROM usuarios WHERE email LIKE '%$usuario%' OR nome LIKE '%$usuario%'");

            $array = array();

            $array = $status->fetchAll(PDO::FETCH_OBJ);
            //$array = $status->fetchAll(PDO::FETCH_CLASS, 'UsuariosModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Usuario' . $e;
        }	
    }

    //Função para verificar senha de determinado usuario
    public function searchValidaSenhaAtual($email, $senha) {
        try {

            $status = $this->connection->query("SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");

            $array = array();

            $array = $status->fetch(PDO::FETCH_OBJ);
            //$array = $status->fetchAll(PDO::FETCH_CLASS, 'UsuariosModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Usuario' . $e;
        }	
    }
    
    //Função para pesquisar qualquer dado no cadastro de Usuarios
    public function searchEmailCadastrado($email) {
        try {
            $status = $this->connection->query("SELECT * FROM usuarios WHERE email = '$email'");

            $array = array();

            $array = $status->fetchAll(PDO::FETCH_OBJ);
            //$array = $status->fetchAll(PDO::FETCH_CLASS, 'UsuariosModel');

            //$this->connection = null;

            return $array;
        } catch (PDOException $e) {
            echo 'Ocorreram erros ao buscar o Usuario' . $e;
        }	
    }
   
    //Função para alterar/atualizar os dados de um usuario cadastrado (Completo)
    public function updateUsuariosA($usuario) {
        try {
            $status = $this->connection->prepare("UPDATE usuarios SET nome = ?, senha = ? WHERE email = ?");
            
            $status->bindValue(1, $usuario->nome);
            $status->bindValue(2, $usuario->senha);
            $status->bindValue(3, $usuario->email);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar usuarios!";
        }
    }

    //Função para alterar/atualizar os dados de um usuario cadastrado (Somente senha)
    public function updateUsuariosB($usuario) {
        try {
            $status = $this->connection->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
            
            $status->bindValue(1, $usuario->senha);
            $status->bindValue(2, $usuario->email);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar usuarios!";
        }
    }

    //Função para atualizar a senha recuperada através de e-mail e limpar a chave hash
    public function updateUsuariosC($usuario) {
        try {
            $status = $this->connection->prepare("UPDATE usuarios SET hash_recovery = ?, senha = ? WHERE email = ?");
            
            $status->bindValue(1, $usuario->hash_recovery);
            $status->bindValue(2, $usuario->senha);
            $status->bindValue(3, $usuario->email);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar usuarios!";
        }
    }    

    //Função para alterar/atualizar os dados de um usuario cadastrado (Completo)
    public function updateUsuariosHashRecovery($usuario) {
        try {
            $status = $this->connection->prepare("UPDATE usuarios SET hash_recovery = ? WHERE email = ?");
            
            $status->bindValue(1, $usuario->hash_recovery);
            $status->bindValue(2, $usuario->email);

            $status->execute();

            //Encerra a conexão com o BD
            $this->connection = null;

        } catch (PDOException $e) {
            echo "Ocorreram erros ao alterar usuarios!";
        }
    }

    //Função para remover Usuário cadastrado no Banco de Dados (Não utilizada no cadastro de usuários)
    /*public function deleteUsuario($id) {
        try {
            $status = $this->connection->prepare("DELETE FROM usuarios WHERE id = ?");
            $status->bindValue(1, $id);

            $status->execute();
    
            $this->connection = null;

        } catch (PDOException $e) {
            echo 'Ocorreram erros ao deletar o usuário' . $e;
        }
    }*/

    //Função para encerrar conexão com o Banco de Dados
    public function close() {
        $this->connection = null;
    }
}