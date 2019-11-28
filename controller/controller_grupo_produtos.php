<?php
    session_start();
    include '../persistence/ConnectionDB.php';
    include '../dao/GrupoProdutosDAO.php';
    include '../model/GrupoProdutosModel.php';

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
                        $erros[] = 'O nome do Grupo de Produtos não pode estar em branco!';
                    }

                    //Criando DAO (Alimenta as 2 próximas funções)
                    $grupoProdutosDAO = new GrupoProdutosDAO();

                    //Função pra verificar se existe um Grupo de Produtos com este nome
                    if ($grupoProdutosDAO->searchGrupoProdutoPar($_POST['descricao']) != null) {
                        $erros[] = 'Esse nome do Grupo de Produtos já está sendo usado!';
                    }

                    //Verifica se não erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $grupoProdutos = new GrupoProdutosModel();
                            $grupoProdutos->descricao = $_POST['descricao'];
                
                            $grupoProdutosDAO = new GrupoProdutosDAO();
                            $grupoProdutosDAO->insertGrupoProduto($grupoProdutos);
                
                            $_SESSION['grupoProduto'] = $grupoProdutos->descricao;
                            
                            echo "<script language='javascript' type='text/javascript'>
                                alert('Grupo de Produtos cadastrado com sucesso!');
                                window.location.href='../view/grupo_produtos/cad_grupo_produtos.php';
                            </script>";
                            //header('location: ../view/grupo_produtos/cad_grupo_produtos.php');
                        
                        //Caso ocorra algum erro no Banco de Dados
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/grupo_produtos/view_erros.php');
                        }                        
                    
                    //Caso existam erros, eles são serializados e enviadas para a página de erros
                    } else {
                        $erros_serializados = serialize($erros);
                        $_SESSION['erros'] = $erros_serializados;
                        header('location: ../view/grupo_produtos/view_erros.php');
                    }
                
                //Alerta de campos não preenchidos
                } else {
                    echo "<script language='javascript' type='text/javascript'>
                        alert('Preencha todos os campos!');
                        window.location.href='../view/grupo_produtos/cad_grupo_produtos.php';
                    </script>";
                }
            break;
            
            //Executa a pesquisa
            case 'pesquisar':
                $grupoProdutosDAO = new GrupoProdutosDAO();
                $array = array();
                $array = $grupoProdutosDAO->searchGrupoProduto();

                $_SESSION['grupoProduto'] = serialize($array);
                header("location:../view/grupo_produtos/cad_grupo_produtos.php");
            break;
            
            //Executa a alteração
            case 'alterar':
                if ((!empty($_POST['id-edit'])) && (!empty($_POST['descricao-edit'])) ) {
                    $erros = array();

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo descrição não está vazio (strlen)
                    if (strlen(trim($_POST['descricao-edit'])) == 0) {
                        $erros[] = 'O nome do Grupo de Produtos não pode estar em branco!';
                    }

                    //Verifica se o nome do Grupo de Produtos já está cadastrado com outro 'id' no Banco de Dados
                    $grupoProdutosDAO = new GrupoProdutosDAO();

                    if ($grupoProdutosDAO->searchGrupoProdutoDuplicidade($_POST['descricao-edit'], $_POST['id-edit']) != null) {
                        $erros[] = 'Este nome do Grupo de Produtos já está sendo usado em outro cadastro!';
                    }

                    //Verifica se não há erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $grupoProdutos = new GrupoProdutosModel();
                            $grupoProdutos->id = $_POST['id-edit'];
                            $grupoProdutos->descricao = $_POST['descricao-edit'];

                            $grupoProdutosDAO = new GrupoProdutosDAO();
                            $grupoProdutosDAO->updateGrupoProduto($grupoProdutos);

                            $_SESSION['id'] = $grupoProdutos->id;
                            $_SESSION['grupoProduto'] = $grupoProdutos->descricao;

                            echo "<script language='javascript' type='text/javascript'>
                                alert('Grupo de Produtos alterado com sucesso!');
                                window.location.href='../view/grupo_produtos/cad_grupo_produtos.php';
                            </script>";
                            //header("location:../view/grupo_produtos/cad_grupo_produtos.php");
                        break;

                        //Caso ocorra algum erro no Banco de Dados
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/grupo_produtos/view_erros.php');
                        }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/grupo_produtos/view_erros.php');
                }
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/grupo_produtos/cad_grupo_produtos.php';
                </script>";
            }
            break;
                        
            //Executa a exclusão
            case 'excluir':
                $grupoProdutosDAO = new GrupoProdutosDAO();
                $array = array();
                $array = $grupoProdutosDAO->deleteGrupoProduto($_GET['id']);

                $_SESSION['grupoProduto'] = serialize($array);
                
                echo "<script language='javascript' type='text/javascript'>
					alert('Grupo de Produtos excluído com sucesso!');
					window.location.href='../view/grupo_produtos/cad_grupo_produtos.php';
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