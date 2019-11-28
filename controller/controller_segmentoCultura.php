<?php
    session_start();
    include '../persistence/ConnectionDB.php';
    include '../dao/SegmentoCulturaDAO.php';
    include '../model/SegmentoCulturaModel.php';

// Valida a sessão conforme o login
if(isset($_SESSION['logado'])):

    //Verifica o tipo de operação e a executa
    if (isset($_GET['operation'])) {
        switch ($_GET['operation']) {
            //Executa a operação de inserção no Banco de Dados
            case 'cadastrar':
                if ((!empty($_POST['descricao']))) {
                    $erros = array();

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo descrição não está vazio (strlen)
                    if (strlen(trim($_POST['descricao'])) == 0) {
                        $erros[] = 'O nome de SegmentoCultura não pode estar em branco!';
                    }

                    //Criando DAO (Alimenta as 2 próximas funções)
                    $segmentoCulturaDAO = new SegmentoCulturaDAO();

                    //Função pra verificar se existe SegmentoCultura com este nome
                    if ($segmentoCulturaDAO->searchSegmentoCulturaPar($_POST['descricao']) != null) {
                        $erros[] = 'Esse nome de SegmentoCultura já está sendo usado!';
                    }

                    //Verifica se não erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $segmentoCultura = new SegmentoCulturaModel();
                            $segmentoCultura->descricao = $_POST['descricao'];
                
                            $segmentoCulturaDAO = new SegmentoCulturaDAO();
                            $segmentoCulturaDAO->insertSegmentoCultura($segmentoCultura);
                
                            $_SESSION['segmentoCultura'] = $segmentoCultura->descricao;
                            
                            echo "<script language='javascript' type='text/javascript'>
                                alert('SegmentoCultura cadastrado com sucesso!');
                                window.location.href='../view/segmentos_culturas/cad_segmentos_culturas.php';
                            </script>";
                            //header('location: ../view/segmentos_culturas/cad_segmentos_culturas.php');
                        
                        //Caso ocorra algum erro no Banco de Dados
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/segmentos_culturas/view_erros.php');
                        }                        
                    
                    //Caso existam erros, eles são serializados e enviadas para a página de erros
                    } else {
                        $erros_serializados = serialize($erros);
                        $_SESSION['erros'] = $erros_serializados;
                        header('location: ../view/segmentos_culturas/view_erros.php');
                    }
                
                //Alerta de campos não preenchidos
                } else {
                    echo "<script language='javascript' type='text/javascript'>
                        alert('Preencha todos os campos!');
                        window.location.href='../view/segmentos_culturas/cad_segmentos_culturas.php';
                    </script>";
                }
            break;
            
            //Executa a pesquisa
            case 'pesquisar':
                $segmentoCulturaDAO = new SegmentoCulturaDAO;
                $array = array();
                $array = $segmentoCulturaDAO->searchSegmentoCultura();

                $_SESSION['segmentoCultura'] = serialize($array);
                header("location:../view/segmentos_culturas/cad_segmentos_culturas.php");
            break;
            
            //Executa a alteração
            case 'alterar':
                if ((!empty($_POST['id-edit'])) && (!empty($_POST['descricao-edit'])) ) {
                    $erros = array();

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo descrição não está vazio (strlen)
                    if (strlen(trim($_POST['descricao-edit'])) == 0) {
                        $erros[] = 'O nome de SegmentoCultura não pode estar em branco!';
                    }

                    //Verifica se o nome do SegmentoCultura já está cadastrado com outro 'id' no Banco de Dados
                    $segmentoCulturaDAO = new SegmentoCulturaDAO();
                    
                    if ($segmentoCulturaDAO->searchSegmentoCulturaDuplicidade($_POST['descricao-edit'], $_POST['id-edit']) != null) {
                        /*$segmentoCulturaDAO = new SegmentoCulturaDAO;
                        $segmentoCultura = array();

                        foreach ($segmentoCultura as $e) {
                            echo $e->id .'<br>';
                            echo $e->descricao . '<br>';
                        }
                        die();*/
             
                        $erros[] = 'Este nome de SegmentoCultura já está sendo usado em outro cadastro!';
                    }

                    //Verifica se não há erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $segmentoCultura = new SegmentoCulturaModel();
                            $segmentoCultura->id = $_POST['id-edit'];
                            $segmentoCultura->descricao = $_POST['descricao-edit'];

                            $segmentoCulturaDAO = new SegmentoCulturaDAO;
                            $segmentoCulturaDAO->updateSegmentoCultura($segmentoCultura);

                            $_SESSION['id'] = $segmentoCultura->id;
                            $_SESSION['segmentoCultura'] = $segmentoCultura->descricao;

                            echo "<script language='javascript' type='text/javascript'>
                                alert('SegmentoCultura alterado com sucesso!');
                                window.location.href='../view/segmentos_culturas/cad_segmentos_culturas.php';
                            </script>";
                            //header("location:../view/segmentos_culturas/cad_segmentos_culturas.php");
                        break;

                        //Caso ocorra algum erro no Banco de Dados
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/segmentos_culturas/view_erros.php');
                        }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/segmentos_culturas/view_erros.php');
                }
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/segmentos_culturas/cad_segmentos_culturas.php';
                </script>";
            }
            break;
                        
            //Executa a exclusão
            case 'excluir':
                $segmentoCulturaDAO = new SegmentoCulturaDAO;
                $array = array();
                $array = $segmentoCulturaDAO->deleteSegmentoCultura($_GET['id']);

                $_SESSION['segmentoCultura'] = serialize($array);
                
                echo "<script language='javascript' type='text/javascript'>
					alert('SegmentoCultura excluído com sucesso!');
					window.location.href='../view/segmentos_culturas/cad_segmentos_culturas.php';
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