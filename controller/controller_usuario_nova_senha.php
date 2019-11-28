<?php
	session_start();
	//Acionado após o usuário clicar no link enviado pelo e-mail
	include '../persistence/ConnectionDB.php';
	include '../model/UsuariosModel.php';
	include '../dao/UsuariosDAO.php';

	$email = $_GET['email'];
	$hash = $_GET['hash']; 
	$new_pass = sha1(md5($_POST['pass']));

	if ($email == "" || $email == null || $hash == "" || $hash == null) {
		//Finaliza a sessão e redireciona para a página de recuperação de senha
		unset($_SESSION['recovery']);
		echo "<script language='javascript' type='text/javascript'>
				alert('Essa chave de alteração é inválida ou expirou. Tente novamente!');
				window.location.href='../view/usuarios/recuperar_senha.php';
			</script>";
		die();
	} else {
		$usuariosDAO = new UsuariosDAO();
		if ($usuariosDAO->searchHash($hash) != NULL) {
			try {
				//Atualiza os valores da senha e do hash_recovery
				$user = new UsuariosModel();

				$user->email = $email;
				$user->senha = $new_pass;
				$user->hash_recovery = NULL;

				$usuariosDAO->updateUsuariosC($user);

				$_SESSION['email'] = $user->email;
				$_SESSION['pass'] = $user->senha;
				$_SESSION['hash_recovery'] = $user->hash_recovery;

				//Finaliza a sessão e redireciona para a página de login
				unset($_SESSION['recovery']);
				echo "<script language='javascript' type='text/javascript'>
						alert('Senha alterada com sucesso');
						window.location.href='../index.php';
					</script>";
				die();							
			} catch (\Throwable $th) {
				echo "<script language='javascript' type='text/javascript'>
					alert('Erro Interno. Verifique com o Administrador do Banco de Dados!');
					window.location.href='../index.php';
				</script>";
			}

		} else {
			//Finaliza a sessão e redireciona para a página de recuperação de senha
			unset($_SESSION['recovery']);
			echo "<script language='javascript' type='text/javascript'>
				alert('Essa chave de alteração é inválida ou expirou. Tente novamente!');
				window.location.href='../view/usuarios/recuperar_senha.php';
			</script>";
			exit;	
		}
	}
?>