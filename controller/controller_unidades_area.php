<?php
    session_start();
    include '../persistence/ConnectionDB.php';
    include '../dao/UnidadesAreaDAO.php';
    include '../model/UnidadesAreaModel.php';    
    include '../dao/MunicipioDAO.php';
    include '../dao/SegmentoCulturaDAO.php';

// Valida a sessão conforme o login
if(isset($_SESSION['logado'])):

    //Verifica o tipo de operação e a executa
    if (isset($_GET['operation'])) {
        switch ($_GET['operation']) {
            //Executa a operação de inserção no Banco de Dados
            case 'cadastrar':
            if ((!empty($_POST['descricao'])) && (!empty($_POST['municipio'])) 
                && (!empty($_POST['segmentoCultura'])) && (!empty($_POST['unidadeMedida']))
                && (!empty($_POST['qtdArea'])) && (!empty($_POST['mktShare'])) ) {

                $erros = array();

                //Limpando os espaços nas extremidades (Trim) e 
                //verificando se os campos não estão vazios (strlen)
                if (strlen(trim($_POST['descricao'])) == 0) {
                    $erros[] = 'O nome da Unidades/Área não pode estar em branco!';
                }

                if (strlen(trim($_POST['municipio'])) == 0) {
                    $erros[] = 'O Município não pode estar em branco!';
                }

                if (strlen(trim($_POST['segmentoCultura'])) == 0) {
                    $erros[] = 'O SegmentoCultura não pode estar em branco!';
                }
                
                if (strlen(trim($_POST['unidadeMedida'])) == 0) {
                    $erros[] = 'AUnidade de Medida não pode estar em branco!';
                }

                if (strlen(trim($_POST['qtdArea'])) == 0) {
                    $erros[] = 'A área não pode estar em branco!';
                }
                
                if (strlen(trim($_POST['mktShare'])) == 0) {
                    $erros[] = 'O Market Share não pode estar em branco!';
                }

                $unidadesAreaDAO = new UnidadesAreaDAO();
                    
                //Verificando se o nome da UnidadeArea já existe no BD
                if ($unidadesAreaDAO->searchUnidadesAreaDuplicidade($_POST['descricao']) != null) {
                    $erros[] = 'Esse nome de UnidadeArea já foi usado em algum cadastro!';
                }

                //Verificando se já existe algum cadastro contendo esse SegmentoCultura e Município
                if ($unidadesAreaDAO->searchUnidadesAreaVarredura($_POST['municipio'], $_POST['segmentoCultura']) != null) {
                    $erros[] = 'Esse SegmentoCultura já está cadastrado para esse Município!';
                } 
                
                //Verifica se não erros e persiste no Banco de Dados
                if (count($erros) == 0) {
                    try {
                        $unidadesArea = new UnidadesAreaModel();
                        $unidadesArea->descricao = $_POST['descricao'];
                        $unidadesArea->id_municipio = $_POST['municipio'];
                        $unidadesArea->id_segmentocultura = $_POST['segmentoCultura'];
                        $unidadesArea->unidade_medida = $_POST['unidadeMedida'];
                        $unidadesArea->qtd_area = $_POST['qtdArea'];
                        $unidadesArea->mkt_desejado = $_POST['mktShare'];
            
                        $unidadesAreaDAO = new UnidadesAreaDAO();
                        $unidadesAreaDAO->insertUnidadesArea($unidadesArea);
            
                        $_SESSION['unidade_area'] = $unidadesArea->descricao;
                        $_SESSION['id_municipio'] = $unidadesArea->id_municipio;
                        $_SESSION['id_segmentocultura'] = $unidadesArea->id_segmentocultura;
                        $_SESSION['unidade_medida'] = $unidadesArea->unidade_medida;
                        $_SESSION['qtd_area'] = $unidadesArea->qtd_area;
                        $_SESSION['mkt_desejado'] = $unidadesArea->mkt_desejado;
                        
                        echo "<script language='javascript' type='text/javascript'>
                            alert('UnidadeArea cadastrada com sucesso');
                            window.location.href='../view/unidades_area/cad_unidades_area.php';
                        </script>";

                    
                    //Caso ocorra algum erro no Banco de Dados
                    } catch (\Throwable $th) {
                        $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                        $erros_serializados = serialize($erros);
                        $_SESSION['erros'] = $erros_serializados;
                        header('location: ../view/unidades_area/view_erros.php');
                    }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/unidades_area/view_erros.php');
                }            
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/unidades_area/cad_unidades_area.php';
                </script>";
            }
            break;

            //Executa a pesquisa
            case 'pesquisar':
                $unidadesAreaDAO = new UnidadesAreaDAO();
                $array = array();
                $array = $unidadesAreaDAO->searchUnidadesArea();

                $_SESSION['unidade_area']= serialize($array);

                header("location:../view/unidades_area/cad_unidades_area.php");
            break;
        
            //Executa a alteração
            case 'alterar':

                /*echo $_POST['id-edit'] . "<br>";
                echo $_POST['descricao-edit'] . "<br>";
                echo $_POST['municipio-edit'] . "<br>";
                echo $_POST['segmentoCultura-edit'] . "<br>";
                echo $_POST['unidadeMedida-edit'] . "<br>";
                echo $_POST['qtdArea-edit'] . "<br>";
                echo $_POST['mktShare-edit'] . "<br>";
                die();*/

                if ((!empty($_POST['id-edit'])) && (!empty($_POST['descricao-edit'])) && (!empty($_POST['municipio-edit'])) 
                    && (!empty($_POST['segmentoCultura-edit'])) && (!empty($_POST['unidadeMedida-edit']))
                    && (!empty($_POST['qtdArea-edit'])) && (!empty($_POST['mktShare-edit'])) ) {

                    $erros = array();

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se os campos não estão vazios (strlen)
                    if (strlen(trim($_POST['descricao-edit'])) == 0) {
                        $erros[] = 'O nome da Unidades/Área não pode estar em branco!';
                    }

                    if (strlen(trim($_POST['municipio-edit'])) == 0) {
                        $erros[] = 'O Município não pode estar em branco!';
                    }

                    if (strlen(trim($_POST['segmentoCultura-edit'])) == 0) {
                        $erros[] = 'O SegmentoCultura não pode estar em branco!';
                    }
                    
                    if (strlen(trim($_POST['unidadeMedida-edit'])) == 0) {
                        $erros[] = 'AUnidade de Medida não pode estar em branco!';
                    }

                    if (strlen(trim($_POST['qtdArea-edit'])) == 0) {
                        $erros[] = 'A área não pode estar em branco!';
                    }
                    
                    if (strlen(trim($_POST['mktShare-edit'])) == 0) {
                        $erros[] = 'O Market Share não pode estar em branco!';
                    }

                    $unidadesAreaDAO = new UnidadesAreaDAO();
                        
                    //Verificando se o nome da UnidadeArea já existe com outro 'id'
                    if ($unidadesAreaDAO->searchUnidadesAreaDescricaoIgualIdDiferente($_POST['id-edit'], $_POST['descricao-edit']) != null) {
                        $erros[] = 'Esse nome de UnidadeArea já foi usado em algum cadastro!';
                    }

                    //Verificando se já existe algum cadastro contendo esse SegmentoCultura e Município
                    if ($unidadesAreaDAO->searchUnidadesAreaVarreduraIdDiferente($_POST['id-edit'], $_POST['municipio-edit'], $_POST['segmentoCultura-edit']) != null) {
                        $erros[] = 'Esse SegmentoCultura já está cadastrado para esse Município com outra Descrição!';
                    } 
                    
                    //Verifica se não erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $unidadesArea = new UnidadesAreaModel();
                            $unidadesArea->id = $_POST['id-edit'];
                            $unidadesArea->descricao = $_POST['descricao-edit'];
                            $unidadesArea->id_municipio = $_POST['municipio-edit'];
                            $unidadesArea->id_segmentocultura = $_POST['segmentoCultura-edit'];
                            $unidadesArea->unidade_medida = $_POST['unidadeMedida-edit'];
                            $unidadesArea->qtd_area = $_POST['qtdArea-edit'];
                            $unidadesArea->mkt_desejado = $_POST['mktShare-edit'];
                    
                            $unidadesAreaDAO = new UnidadesAreaDAO();
                            $unidadesAreaDAO->updateUnidadesArea($unidadesArea);

                            $_SESSION['id'] = $unidadesArea->id;
                            $_SESSION['unidade_area'] = $unidadesArea->descricao;
                            $_SESSION['id_municipio'] = $unidadesArea->id_municipio;
                            $_SESSION['id_segmentocultura'] = $unidadesArea->id_segmentocultura;
                            $_SESSION['unidade_medida'] = $unidadesArea->unidade_medida;
                            $_SESSION['qtd_area'] = $unidadesArea->qtd_area;
                            $_SESSION['mkt_desejado'] = $unidadesArea->mkt_desejado;
    
                            echo "<script language='javascript' type='text/javascript'>
                                alert('UnidadeArea alterada com sucesso!');
                                window.location.href='../view/unidades_area/cad_unidades_area.php';
                            </script>";
                        break;

                        //Caso ocorra algum erro no Banco de Dados
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/unidades_area/view_erros.php');
                        }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/unidades_area/view_erros.php');
                }
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/unidades_area/cad_unidades_area.php';
                </script>";
            }
            break;

            //Executa a exclusão
            case 'excluir':
                $unidadesAreaDAO = new UnidadesAreaDAO();
                $array = array();
                $array = $unidadesAreaDAO->deleteUnidadesArea($_GET['id']);

                $_SESSION['unidade_area']= serialize($array);
                
                echo "<script language='javascript' type='text/javascript'>
                    alert('UnidadeArea excluída com sucesso!');
                    window.location.href='../view/unidades_area/cad_unidades_area.php';
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