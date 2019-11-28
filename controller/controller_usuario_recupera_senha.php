<?php
session_start();
include '../persistence/ConnectionDB.php';
include '../dao/UsuariosDAO.php';
include '../model/UsuariosModel.php';

	$email_X = $_POST['email'];

	if ($email_X == "" || $email_X == null) {
		echo "<script language='javascript' type='text/javascript'>
				alert('Campo e-mail deve ser preenchido!');
				window.location.href='../view/usuarios/recuperar_senha.php';
			</script>";
	} else {

		//Verifica se e-mail está cadastrado no BD
		$usuariosDAO = new UsuariosDAO();
		if ($usuariosDAO->searchNome($email_X) != NULL) {                        
			try {
				$user = new UsuariosModel();

				$user->email = $email_X;
				$user->hash_recovery = substr(md5(date('Y-m-d H:i:s') . $email_X), 16, 10);
	
				$usuariosDAO = new UsuariosDAO();
				$usuariosDAO->updateUsuariosHashRecovery($user);

				$_SESSION['email'] = $user->email;
				$hash = $user->hash_recovery;

				echo "<script language='javascript' type='text/javascript'>
					alert('Chave enviada com sucesso. Abra seu e-mail e clique no link para alterar sua senha!');
					window.location.href='../view/usuarios/recuperar_senha.php';
				</script>";

			} catch (\Throwable $th) {
				$erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
				$erros_serializados = serialize($erros);
				$_SESSION['erros'] = $erros_serializados;
				header('location: ../view/usuarios/recuperar_senha.php');
			} 
		}
	}
?>
