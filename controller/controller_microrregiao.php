<?php
    session_start();
    include '../persistence/ConnectionDB.php';
    include '../model/MicrorregiaoModel.php';
    include '../dao/MicrorregiaoDAO.php';
    include '../dao/EstadoDAO.php';

// Valida a sessão conforme o login
if(isset($_SESSION['logado'])):

    //Verifica o tipo de operação e a executa
    if (isset($_GET['operation'])) {
        switch ($_GET['operation']) {
            //Executa a operação de inserção no Banco de Dados
            case 'cadastrar':
            if ((!empty($_POST['descricao'])) && (!empty($_POST['estado'])) ) {
                $erros = array();

                //Limpando os espaços nas extremidades (Trim) e 
                //verificando se o campo descrição não está vazio (strlen)
                if (strlen(trim($_POST['descricao'])) == 0) {
                    $erros[] = 'O nome da microrregião não pode estar em branco!';
                }

                //Limpando os espaços nas extremidades (Trim) e 
                //verificando se o campo Estado não está vazio (strlen)
                if (strlen(trim($_POST['estado'])) == 0) {
                    $erros[] = 'O Estado não pode estar em branco!';
                }

                //Verifica se a sigla ou nome do estado já está cadastrado com outro 'id' no Banco de Dados
                $microrregiaoDAO = new MicrorregiaoDAO();
                    
                //Função pra verificar se existe Microrregião com este nome e no mesmo Estado
                if ($microrregiaoDAO->searchMicrorregiaoDuplicidade($_POST['descricao'], $_POST['estado']) != null) {
                    $erros[] = 'Esse nome de Microrregião já está sendo usado com este Estado!';
                } 
                
                //Verifica se não erros e persiste no Banco de Dados
                if (count($erros) == 0) {
                    try {
                        $microrregiao = new MicrorregiaoModel();
                        $microrregiao->descricao = $_POST['descricao'];
                        $microrregiao->id_estado = $_POST['estado'];
            
                        $microrregiaoDAO = new MicrorregiaoDAO();
                        $microrregiaoDAO->insertMicrorregiao($microrregiao);
            
                        $_SESSION['microrregiao'] = $microrregiao->descricao;
                        $_SESSION['id_estado'] = $microrregiao->id_estado;
                        
                        echo "<script language='javascript' type='text/javascript'>
                            alert('Microrregião cadastrada com sucesso');
                            window.location.href='../view/microrregioes/cad_microrregioes.php';
                        </script>";

                    
                    //Caso ocorra algum erro no Banco de Dados
                    } catch (\Throwable $th) {
                        $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                        $erros_serializados = serialize($erros);
                        $_SESSION['erros'] = $erros_serializados;
                        header('location: ../view/microrregioes/view_erros.php');
                    }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/microrregioes/view_erros.php');
                }            
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/microrregioes/cad_microrregioes.php';
                </script>";
            }
            break;

            //Executa a pesquisa
            case 'pesquisar':
                $microrregiaoDAO = new MicrorregiaoDAO;
                $array = array();
                $array = $microrregiaoDAO->searchMicrorregiao();

                $_SESSION['microrregiao'] = serialize($array);

                header("location:../view/microrregioes/cad_microrregioes.php");
            break;
        
            //Executa a alteração
            case 'alterar':
                if ((!empty($_POST['id-edit'])) && (!empty($_POST['descricao-edit'])) && (!empty($_POST['estado-edit'])) ) {
                    $erros = array();

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo descrição não está vazio (strlen)
                    if (strlen(trim($_POST['descricao-edit'])) == 0) {
                        $erros[] = 'O nome de Microrregião não pode estar em branco!';
                    }

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo estado não está vazio (strlen)
                    if (strlen(trim($_POST['estado-edit'])) == 0) {
                        $erros[] = 'O estado não pode estar em branco!';
                    }
                    
                    //Verifica se a Microrregião ou nome do estado já está cadastrado com outro 'id' no Banco de Dados
                    $microrregiaoDAO = new microrregiaoDAO();
                    
                    if ($microrregiaoDAO->searchMicrorregiaoDuplicidade($_POST['descricao-edit'], $_POST['estado-edit'], $_POST['id-edit']) != null) {
                        $erros[] = 'Este nome de Microrregião com Estado já está sendo usado em outro cadastro!';
                    }

                    //Verifica se não há erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $microrregiao = new microrregiaoModel();
                            $microrregiao->id = $_POST['id-edit'];
                            $microrregiao->descricao = $_POST['descricao-edit'];
                            $microrregiao->id_estado = $_POST['estado-edit'];

                            $microrregiaoDAO = new microrregiaoDAO;
                            $microrregiaoDAO->updateMicrorregiao($microrregiao);

                            $_SESSION['id'] = $microrregiao->id;
                            $_SESSION['microrregiao'] = $microrregiao->descricao;
                            $_SESSION['id_estado'] = $microrregiao->id_estado;

                            echo "<script language='javascript' type='text/javascript'>
                                alert('Microrregião alterada com sucesso!');
                                window.location.href='../view/microrregioes/cad_microrregioes.php';
                            </script>";
                        break;

                        //Caso ocorra algum erro no Banco de Dados
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/microrregioes/view_erros.php');
                        }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/microrregioes/view_erros.php');
                }
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/microrregioes/cad_microrregioes.php';
                </script>";
            }
            break;

            //Executa a exclusão
            case 'excluir':
                $microrregiaoDAO = new MicrorregiaoDAO;
                $array = array();
                $array = $microrregiaoDAO->deleteMicrorregiao($_GET['id']);

                $_SESSION['microrregiao'] = serialize($array);
                
                echo "<script language='javascript' type='text/javascript'>
                    alert('Microrregião excluída com sucesso!');
                    window.location.href='../view/microrregioes/cad_microrregioes.php';
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