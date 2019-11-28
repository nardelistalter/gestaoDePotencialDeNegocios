<?php
    session_start();
    //Acionado após o usuário clicar no link enviado pelo e-mail
    include '../persistence/ConnectionDB.php';
    include '../dao/UsuariosDAO.php';

    $hash = $_GET['hash'];

    if (($hash == "") || ($hash == NULL)) {
        echo "<script language='javascript' type='text/javascript'>
            alert('Essa chave de alteração é inválida ou expirou. Tente enviar novamente!');
            window.location.href='../view/usuarios/recuperar_senha.php';
        </script>";
    } else {
        
        //Verifica se a hash_recovery existe e retorna o e-mail do mesmo
		$usuariosDAO = new UsuariosDAO();
		if ($usuariosDAO->searchHash($hash) != NULL) {                        
			try {     
                $usuario = $usuariosDAO->searchEmail($hash);

                $_SESSION['recovery'] = true;
                $_SESSION['email'] = $usuario->email;
                $_SESSION['hash'] = $hash;

                header('location: ../view/usuarios/recuperar_senha_alteracao.php');
                exit;

			} catch (\Throwable $th) {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Erro Interno. Verifique com o Administrador do Banco de Dados!');
                    window.location.href='../index.php';
                </script>";
			} 
		} else {
            echo "<script language='javascript' type='text/javascript'>
                alert('Essa chave de alteração é inválida ou expirou. Tente enviar novamente!');
                window.location.href='../view/usuarios/recuperar_senha.php';
            </script>";
        }
    }
?>