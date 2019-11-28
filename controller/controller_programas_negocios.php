<?php
    session_start();
    include '../persistence/ConnectionDB.php';
    include '../dao/ProgramasDeNegocioDAO.php';
    include '../model/ProgramasDeNegocioModel.php';    

// Valida a sessão conforme o login
if(isset($_SESSION['logado'])):

    //Verifica o tipo de operação e a executa
    if (isset($_GET['operation'])) {
        switch ($_GET['operation']) {
            //Executa a operação de inserção no Banco de Dados
            case 'cadastrar':
            if ((!empty($_POST['descricao'])) && (!empty($_POST['segmentoCultura'])) 
                && (!empty($_POST['grupoProdutos'])) && (!empty($_POST['valor'])) ) {

                $erros = array();

                //Limpando os espaços nas extremidades (Trim) e 
                //verificando se os campos não estão vazios (strlen)
                if (strlen(trim($_POST['descricao'])) == 0) {
                    $erros[] = 'O nome do Programa de Negócios não pode estar em branco!';
                }

                if (strlen(trim($_POST['segmentoCultura'])) == 0) {
                    $erros[] = 'O SegmentoCultura não pode estar em branco!';
                }
                
                if (strlen(trim($_POST['grupoProdutos'])) == 0) {
                    $erros[] = 'O Grupo de Produtos não pode estar em branco!';
                }

                if (strlen(trim($_POST['valor'])) == 0) {
                    $erros[] = 'A área não pode estar em branco!';
                }

                $programasDeNegocioDAO = new ProgramasDeNegocioDAO();
                    
                //Verificando se o nome do Programa de Negócios já existe no BD
                if ($programasDeNegocioDAO->searchProgramasDeNegocioDuplicidade($_POST['descricao']) != null) {
                    $erros[] = 'Esse nome do Programa de Negócios já foi usado em algum cadastro!';
                }

                
                /*echo $_POST['segmentoCultura']. '<br>';
                echo $_POST['grupoProdutos']. '<br>';
                die();*/

                //Verificando se já existe algum cadastro contendo esse SegmentoCultura e Grupo de Produtos
                if ($programasDeNegocioDAO->searchProgramasDeNegocioVarredura($_POST['segmentoCultura'], $_POST['grupoProdutos']) != null) {
                    $erros[] = 'Esse SegmentoCultura já está cadastrado com esse Grupo de Produtos!';
                } 
                
                //Verifica se não erros e persiste no Banco de Dados
                if (count($erros) == 0) {
                    try {
                        $programasDeNegocio = new ProgramasDeNegocioModel();
                        $programasDeNegocio->descricao = $_POST['descricao'];
                        $programasDeNegocio->id_segmentocultura = $_POST['segmentoCultura'];
                        $programasDeNegocio->id_gruposprodutos = $_POST['grupoProdutos'];
                        $programasDeNegocio->vlrunidporarea = $_POST['valor'];
            
                        $programasDeNegocioDAO = new ProgramasDeNegocioDAO();
                        $programasDeNegocioDAO->insertProgramasDeNegocio($programasDeNegocio);
            
                        $_SESSION['descricao'] = $programasDeNegocio->descricao;
                        $_SESSION['segmentoCultura'] = $programasDeNegocio->id_segmentocultura;
                        $_SESSION['grupoProdutos'] = $programasDeNegocio->id_gruposprodutos;
                        $_SESSION['valor'] = $programasDeNegocio->vlrunidporarea;
                        
                        echo "<script language='javascript' type='text/javascript'>
                            alert('UnidadeArea cadastrada com sucesso');
                            window.location.href='../view/programas_negocios/cad_programas_negocios.php';
                        </script>";

                    
                    //Caso ocorra algum erro no Banco de Dados
                    } catch (\Throwable $th) {
                        $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                        $erros_serializados = serialize($erros);
                        $_SESSION['erros'] = $erros_serializados;
                        header('location: ../view/programas_negocios/view_erros.php');
                    }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/programas_negocios/view_erros.php');
                }            
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/programas_negocios/cad_programas_negocios.php';
                </script>";
            }
            break;

            //Executa a pesquisa
            case 'pesquisar':
                $programasDeNegocioDAO = new ProgramasDeNegocioModel();
                $array = array();
                $array = $programasDeNegocioDAO->searchProgramasDeNegocio();

                $_SESSION['programasDeNegocio']= serialize($array);

                header("location:../view/programas_negocios/cad_programas_negocios.php");
            break;
        
            //Executa a alteração
            case 'alterar':
                if ((!empty($_POST['id-edit'])) && (!empty($_POST['descricao-edit'])) 
                    && (!empty($_POST['segmentoCultura-edit'])) && (!empty($_POST['grupoProdutos-edit']))
                    && (!empty($_POST['valor-edit'])) ) {

                    $erros = array();

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se os campos não estão vazios (strlen)
                    if (strlen(trim($_POST['descricao-edit'])) == 0) {
                        $erros[] = 'O nome do Programa de Negócios não pode estar em branco!';
                    }

                    if (strlen(trim($_POST['segmentoCultura-edit'])) == 0) {
                        $erros[] = 'O SegmentoCultura não pode estar em branco!';
                    }
                    
                    if (strlen(trim($_POST['grupoProdutos-edit'])) == 0) {
                        $erros[] = 'O Grupo de Produtos não pode estar em branco!';
                    }

                    if (strlen(trim($_POST['valor-edit'])) == 0) {
                        $erros[] = 'A área não pode estar em branco!';
                    }

                    $programasDeNegocioDAO = new ProgramasDeNegocioDAO();
                        
                    //Verificando se o nome do Programa de Negócios já existe no BD já existe com outro 'id'
                    if ($programasDeNegocioDAO->searchProgramasDeNegocioDescricaoIgualIdDiferente($_POST['id-edit'], $_POST['descricao-edit']) != null) {
                        $erros[] = 'Esse nome do Programa de Negócios já foi usado em algum cadastro!';
                    }

                    //Verificando se já existe algum cadastro contendo esse SegmentoCultura e Grupo de Produtos em outro cadastro
                    if ($programasDeNegocioDAO->searchProgramasDeNegocioVarreduraIdDiferente($_POST['id-edit'], $_POST['segmentoCultura-edit'], $_POST['grupoProdutos-edit']) != null) {
                        $erros[] = 'Esse SegmentoCultura já está cadastrado com esse Grupo de Produtos!';
                    } 
                
                    //Verifica se não erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $programasDeNegocio = new ProgramasDeNegocioModel();
                            $programasDeNegocio->id = $_POST['id-edit'];
                            $programasDeNegocio->descricao = $_POST['descricao-edit'];
                            $programasDeNegocio->id_segmentocultura = $_POST['segmentoCultura-edit'];
                            $programasDeNegocio->id_gruposprodutos = $_POST['grupoProdutos-edit'];
                            $programasDeNegocio->vlrunidporarea = $_POST['valor-edit'];
                
                            $programasDeNegocioDAO = new ProgramasDeNegocioDAO();
                            $programasDeNegocioDAO->updateProgramasDeNegocio($programasDeNegocio);
                
                            $_SESSION['id'] = $programasDeNegocio->id;
                            $_SESSION['descricao'] = $programasDeNegocio->descricao;
                            $_SESSION['segmentoCultura'] = $programasDeNegocio->id_segmentocultura;
                            $_SESSION['grupoProdutos'] = $programasDeNegocio->id_gruposprodutos;
                            $_SESSION['valor'] = $programasDeNegocio->vlrunidporarea;
        
                            echo "<script language='javascript' type='text/javascript'>
                                alert('UnidadeArea alterada com sucesso!');
                                window.location.href='../view/programas_negocios/cad_programas_negocios.php';
                            </script>";
                        break;

                        //Caso ocorra algum erro no Banco de Dados
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/programas_negocios/view_erros.php');
                        }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/programas_negocios/view_erros.php');
                }
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/programas_negocios/cad_programas_negocios.php';
                </script>";
            }
            break;

            //Executa a exclusão
            case 'excluir':
                $programasDeNegocioDAO = new ProgramasDeNegocioDAO();
                $array = array();
                $array = $programasDeNegocioDAO->deleteProgramasDeNegocio($_GET['id']);

                $_SESSION['programasDeNegocio']= serialize($array);
                
                echo "<script language='javascript' type='text/javascript'>
                    alert('UnidadeArea excluída com sucesso!');
                    window.location.href='../view/programas_negocios/cad_programas_negocios.php';
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