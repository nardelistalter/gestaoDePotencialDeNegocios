<?php
    session_start();
    include '../persistence/ConnectionDB.php';
    include '../model/EstadoModel.php';
    include '../dao/EstadoDAO.php';

// Valida a sessão conforme o login
if(isset($_SESSION['logado'])):

    //Verifica o tipo de operação e a executa
    if (isset($_GET['operation'])) {
        switch ($_GET['operation']) {
            //Executa a operação de inserção no Banco de Dados
            case 'cadastrar':
                if ((!empty($_POST['descricao'])) && (!empty($_POST['sigla'])) ) {
                    $erros = array();

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo descrição não está vazio (strlen)
                    if (strlen(trim($_POST['descricao'])) == 0) {
                        $erros[] = 'O nome de estado não pode estar em branco!';
                    }

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo sigla não está vazio (strlen)
                    if (strlen(trim($_POST['sigla'])) == 0) {
                        $erros[] = 'A sigla não pode estar em branco!';
                    
                    //Se o campo sigla for preenchida, verifica se contém 2 caracteres (strlen)
                    } else if (strlen(trim($_POST['sigla'])) != 2) {
                        $erros[] = 'A sigla deve conter 2 caracteres!';
                    }

                    //Criando DAO (Alimenta as 2 próximas funções)
                    $estadoDAO = new EstadoDAO();
                    
                    //Função pra verificar se existe Estado com este nome
                    if ($estadoDAO->searchEstadoPar($_POST['descricao']) != null) {
                        $erros[] = 'Esse nome de estado já está sendo usado!';
                    }           
                    
                    //Função pra verificar se a Sigla já existe no Banco de Dados
                    if ($estadoDAO->searchSiglaPar($_POST['sigla']) != null) {
                        $erros[] = 'Essa sigla já está sendo usada!';
                    }
                    
                    //Verifica se não erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $estado = new EstadoModel();
                            $estado->descricao = $_POST['descricao'];
                            $estado->sigla = $_POST['sigla'];
                
                            $estadoDAO = new EstadoDAO();
                            $estadoDAO->insertEstado($estado);
                
                            $_SESSION['estado'] = $estado->descricao;
                            $_SESSION['sigla'] = $estado->sigla;
                            
                            echo "<script language='javascript' type='text/javascript'>
                                alert('Estado cadastrado com sucesso');
                                window.location.href='../view/estados/cad_estados.php';
                            </script>";
                            //header('location: ../view/estados/cad_estados.php');
                        
                        //Caso ocorra algum erro no Banco de Dados
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/estados/view_erros.php');
                        }                        
                    
                    //Caso existam erros, eles são serializados e enviadas para a página de erros
                    } else {
                        $erros_serializados = serialize($erros);
                        $_SESSION['erros'] = $erros_serializados;
                        header('location: ../view/estados/view_erros.php');
                    }
                
                //Alerta de campos não preenchidos
                } else {
                    echo "<script language='javascript' type='text/javascript'>
                        alert('Preencha todos os campos!');
                        window.location.href='../view/estados/cad_estados.php';
                    </script>";
                }
            break;
            
            //Executa a pesquisa
            case 'pesquisar':
                $estadoDAO = new EstadoDAO;
                $array = array();
                $array = $estadoDAO->searchEstado();

                $_SESSION['estado'] = serialize($array);
                header("location:../view/estados/cad_estados.php");
            break;
            
            //Executa a alteração
            case 'alterar':
                if ((!empty($_POST['id-edit'])) && (!empty($_POST['descricao-edit'])) && (!empty($_POST['sigla-edit'])) ) {
                    $erros = array();

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo descrição não está vazio (strlen)
                    if (strlen(trim($_POST['descricao-edit'])) == 0) {
                        $erros[] = 'O Nome de estado não pode estar em branco!';
                    }

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo sigla não está vazio (strlen)
                    if (strlen(trim($_POST['sigla-edit'])) == 0) {
                        $erros[] = 'A Sigla não pode estar em branco!';
                    
                    //Se o campo sigla for preenchida, verifica se contem 2 caracteres (strlen)
                    } else if (strlen(trim($_POST['sigla-edit'])) != 2) {
                        $erros[] = 'A sigla deve conter 2 caracteres!';
                    }
                    
                    //Verifica se a sigla ou nome do estado já está cadastrado com outro 'id' no Banco de Dados
                    $estadoDAO = new EstadoDAO();
                    
                    if ($estadoDAO->searchEstadoDuplicidade($_POST['descricao-edit'], $_POST['sigla-edit'], $_POST['id-edit']) != null) {
                        $erros[] = 'Este Nome de Estado ou Sigla já está sendo usado em outro cadastro!';
                    }

                    //Verifica se não há erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $estado = new EstadoModel();
                            $estado->id = $_POST['id-edit'];
                            $estado->descricao = $_POST['descricao-edit'];
                            $estado->sigla = $_POST['sigla-edit'];

                            $estadoDAO = new EstadoDAO;
                            $estadoDAO->updateEstado($estado);

                            $_SESSION['id'] = $estado->id;
                            $_SESSION['estado'] = $estado->descricao;
                            $_SESSION['sigla'] = $estado->sigla;

                            echo "<script language='javascript' type='text/javascript'>
                                alert('Estado alterado com sucesso!');
                                window.location.href='../view/estados/cad_estados.php';
                            </script>";
                            //header("location:../view/estados/cad_estados.php");
                        break;

                        //Caso ocorra algum erro no Banco de Dados
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/estados/view_erros.php');
                        }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/estados/view_erros.php');
                }
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/estados/cad_estados.php';
                </script>";
            }
            break;
                        
            //Executa a exclusão
            case 'excluir':
                $estadoDAO = new EstadoDAO;
                $array = array();
                $array = $estadoDAO->deleteEstado($_GET['id']);

                $_SESSION['estado'] = serialize($array);
                
                echo "<script language='javascript' type='text/javascript'>
					alert('Estado excluído com sucesso!');
					window.location.href='../view/estados/cad_estados.php';
                </script>";
            break;
        }
    }
?>
<?php else: ?>
    <!--
        Redirecionamento caso tentativa de acesso sem login
    -->
    <?php header('location: ../index.php'); ?>
<?php endif; ?>