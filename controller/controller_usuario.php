<?php
    session_start();
    include '../persistence/ConnectionDB.php';
    include '../include/valida_usuario.php';
    include '../dao/UsuariosDAO.php';
    include '../model/UsuariosModel.php';
    
    //Verifica o tipo de operação e a executa
    if (isset($_GET['operation'])) {
        switch ($_GET['operation']) {
            case 'cadastrar':
                if ((!empty($_POST['email'])) && (!empty($_POST['pass'])) && (!empty($_POST['pass_confirm'])) && (!empty($_POST['name'])) ) {
                    $erros = array(); 

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se os campos não estão vazios (strlen)
                    if (strlen(trim($_POST['email'])) == 0) {
                        $erros[] = 'O E-mail não pode estar em branco!';
                    }

                    if (strlen(trim($_POST['pass'])) == 0) {
                        $erros[] = 'A senha não pode estar em branco!';
                    }
                    
                    if (strlen(trim($_POST['pass_confirm'])) == 0) {
                        $erros[] = 'A confirmação de senha não pode estar em branco!';
                    }

                    if (strlen(trim($_POST['name'])) == 0) {
                        $erros[] = 'O Nome não pode estar em branco!';
                    }

                    //Para validar e-mail a e aferição das senhas
                    $validaUsuario = new UsuarioValidate();

                    //Validação do e-mail e confirmando se o mesmo já está cadastrado
                    if ($validaUsuario->testarEmail($_POST['email'])) {

                        //Verifica se e-mail já está cadastrado com outro 'id' no Banco de Dados
                        $usuariosDAO = new UsuariosDAO();

                        if ($usuariosDAO->searchEmailCadastrado($_POST['email']) != NULL) {
                            $erros[] = 'Esse email já está sendo usado. Se for seu, volte e use a opção recuperar senha!';
                        }

                    } else {
                        $erros[] = 'Formato de e-mail inválido!';
                    }

                    // Função para verificar se as senhas digitadas são iguais
                    if (!$validaUsuario->validarSenha($_POST['pass'], $_POST['pass_confirm'])) {
                        $erros[] = 'Senhas não conferem!';
                    }
                    
                    //Verifica se não erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $user = new UsuariosModel();
                            $user->email = $_POST['email'];
                            $user->senha = sha1(md5($_POST['pass']));
                            $user->nome = $_POST['name'];
                
                            $usuariosDAO = new UsuariosDAO();
                            $usuariosDAO->insertUsuario($user);
                
                            $_SESSION['email'] = $user->email;
                            $_SESSION['pass'] = $user->senha;
                            $_SESSION['nome'] = $user->nome;

                            echo "<script language='javascript' type='text/javascript'>
                                alert('Usuário cadastrado com sucesso!');
                                window.location.href='../index.php';
                            </script>";
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/usuarios/view_erros.php');
                        }                        
                
                    } else {
                        $erros_serializados = serialize($erros);
                        $_SESSION['erros'] = $erros_serializados;
                        $_SESSION['local'] = "USUÁRIOS";
                        header('location: ../view/usuarios/view_erros.php');
                    }
                    
                } else {
                    echo "<script language='javascript' type='text/javascript'>
                        alert('Preencha todos os campos!');
                        window.location.href='../view/usuarios/cad_usuarios.php';
                    </script>";
                }
                break;
            
            //Executa a pesquisa
            case 'pesquisar':
                $usuariosDAO = new UsuariosDAO;
                $array = array();
                $array = $usuariosDAO->searchUsuario();

                $_SESSION['users'] = serialize($array);
                header("location:../view/usuarios/cad_usuarios.php");
                break;

            //Executa o logout do usuário
            case 'login':
                if ((!empty($_POST['email'])) && (!empty($_POST['pass'])) ) {

                    //Verifica se e-mail está cadastrado no BD e se a senha confere
                    $usuariosDAO = new UsuariosDAO();

                    if ($usuariosDAO->searchUsuarioLogin($_POST['email'], $_POST['pass']) != NULL) {
                        
                        header('location: ../view/home.php');                        
                        $_SESSION['logado'] = true;                        
                        $_SESSION['emailLogado'] = $_POST['email'];

                        //Atribui o nome do usuário logado
                        $user = $usuariosDAO->searchNome($_POST['email']);
                        $_SESSION['nomeLogado'] = $user->nome;
                        exit;
                    } else {
                        echo "<script language='javascript' type='text/javascript'>
                            alert('Usuário e ou senha incorretos!');
                            window.location.href='../index.php';
                        </script>";
                    }
                } else {
                    echo "<script language='javascript' type='text/javascript'>
                        alert('Favor preencher todos os campos!');
                        window.location.href='../index.php';
                    </script>";
                }
                break;

            //Executa o logout do usuário
            case 'logout':
                unset($_SESSION['logado']);
                header('location: ../index.php');
                break;

            //Executa a alteração
            case 'alterar':
                if ((!empty($_POST['email-edit'])) && (!empty($_POST['atual_pass-edit'])) && (!empty($_POST['pass-edit'])) && (!empty($_POST['pass_confirm-edit'])) ) {
                    $erros = array(); 

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se os campos não estão vazios (strlen)
                    if (strlen(trim($_POST['atual_pass-edit'])) == 0) {
                        $erros[] = 'A senha não pode estar em branco!';
                    }

                    if (strlen(trim($_POST['pass-edit'])) == 0) {
                        $erros[] = 'A senha não pode estar em branco!';
                    }
                    
                    if (strlen(trim($_POST['pass_confirm-edit'])) == 0) {
                        $erros[] = 'A confirmação de senha não pode estar em branco!';
                    }

                    //Verificar se a senha atual está correta
                    $usuariosDAO = new UsuariosDAO();

                    if ($usuariosDAO->searchValidaSenhaAtual($_POST['email-edit'], sha1(md5($_POST['atual_pass-edit'])) ) == NULL) {
                        $erros[] = 'Senha atual incorreta!';
                    } else {
                        //Para validar e-mail a e aferição das senhas
                        $validaUsuario = new UsuarioValidate();

                        // Função para verificar se as senhas digitadas são iguais
                        if (!$validaUsuario->validarSenha($_POST['pass-edit'], $_POST['pass_confirm-edit'])) {
                            $erros[] = 'Senhas não conferem!';
                        }
                    }
                    
                    /*echo "Deu certo até aqui!";
                    die();*/
                    
                    //Verifica se não há erros e persiste no Banco de Dados
                    if (count($erros) == 0) {

                        //Limpando os espaços nas extremidades (Trim) e 
                        //verificando se o campo 'nome' está vazio (strlen)
                        if (strlen(trim($_POST['name-edit'])) == 0) {

                            try {
                                $user = new UsuariosModel();

                                $user->email = $_POST['email-edit'];
                                $user->senha = sha1(md5($_POST['pass-edit']));
                    
                                $usuariosDAO = new UsuariosDAO();
                                $usuariosDAO->updateUsuariosB($user);
    
                                $_SESSION['email'] = $user->email;
                                $_SESSION['pass'] = $user->senha;
    
                                echo "<script language='javascript' type='text/javascript'>
                                    alert('Usuário alterado com sucesso!');
                                    window.location.href='../view/usuarios/def_altera_dados_usuario_logado.php';
                                </script>";
    
                            } catch (\Throwable $th) {
                                $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                                $erros_serializados = serialize($erros);
                                $_SESSION['erros'] = $erros_serializados;
                                header('location: ../view/usuarios/def_altera_dados_usuario_logado.php');
                            }      
                                                        
                        } else {
                            try {
                                $user = new UsuariosModel();

                                $user->email = $_POST['email-edit'];
                                $user->senha = sha1(md5($_POST['pass-edit']));
                                $user->nome = $_POST['name-edit'];
                    
                                $usuariosDAO = new UsuariosDAO();
                                $usuariosDAO->updateUsuariosA($user);
    
                                $_SESSION['email'] = $user->email;
                                $_SESSION['pass'] = $user->senha;
                                $_SESSION['nome'] = $user->nome;
                                $_SESSION['nomeLogado'] = $_POST['name-edit'];
    
                                echo "<script language='javascript' type='text/javascript'>
                                    alert('Usuário alterado com sucesso!');
                                    window.location.href='../view/usuarios/def_altera_dados_usuario_logado.php';
                                </script>";

                            } catch (\Throwable $th) {
                                $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                                $erros_serializados = serialize($erros);
                                $_SESSION['erros'] = $erros_serializados;
                                header('location: ../view/usuarios/def_altera_dados_usuario_logado.php');
                            } 
                        }
            
                    } else {
                        $erros_serializados = serialize($erros);
                        $_SESSION['erros'] = $erros_serializados;
                        $_SESSION['local'] = "USUÁRIOS";
                        header('location: ../view/usuarios/view_erros_manutencao.php');
                    }
                    
                } else {
                    echo "<script language='javascript' type='text/javascript'>
                        alert('Preencha todos os campos!');
                        window.location.href='../view/usuarios/def_altera_dados_usuario_logado.php';
                    </script>";
                }
                break;

            //Executa a exclusão (Não permitida para Usuário)
            /*case 'excluir':
                $usuariosDAO = new UsuariosDAO;
                $array = array();
                $array = $usuariosDAO->deleteUsuario($_GET['id']);

                $_SESSION['users'] = serialize($array);
                
                echo "<script language='javascript' type='text/javascript'>
					alert('Usuário excluído com sucesso!');
					window.location.href='../view/usuarios/cad_usuarios.php';
                </script>";
            break;*/
        }
    }