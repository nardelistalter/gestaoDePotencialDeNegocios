<?php
    session_start();
    include '../persistence/ConnectionDB.php';
    include '../dao/MunicipioDAO.php';
    include '../model/MunicipioModel.php';
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
            if ((!empty($_POST['descricao'])) && (!empty($_POST['microrregiao'])) ) {
                $erros = array();

                //Limpando os espaços nas extremidades (Trim) e 
                //verificando se o campo descrição não está vazio (strlen)
                if (strlen(trim($_POST['descricao'])) == 0) {
                    $erros[] = 'O nome da microrregião não pode estar em branco!';
                }

                //Limpando os espaços nas extremidades (Trim) e 
                //verificando se o campo Microrregiao não está vazio (strlen)
                if (strlen(trim($_POST['microrregiao'])) == 0) {
                    $erros[] = 'A Microrregião não pode estar em branco!';
                }

                //Verifica se a sigla ou nome do municipio já está cadastrado com outro 'id' no Banco de Dados
                $municipioDAO = new MunicipioDAO();
                    
                //Função pra verificar se existe Município com este nome e na mesma Microrregião
                if ($municipioDAO->searchMunicipioDuplicidade($_POST['descricao'], $_POST['microrregiao']) != null) {
                    $erros[] = 'Esse nome de Município já está sendo usado com esta Microrregião!';
                } 
                
                //Verifica se não erros e persiste no Banco de Dados
                if (count($erros) == 0) {
                    try {
                        $municipio = new MunicipioModel();
                        $municipio->descricao = $_POST['descricao'];
                        $municipio->id_microrregiao = $_POST['microrregiao'];
            
                        $municipioDAO = new MunicipioDAO();
                        $municipioDAO->insertMunicipio($municipio);
            
                        $_SESSION['municipio'] = $municipio->descricao;
                        $_SESSION['id_microrregiao'] = $municipio->id_microrregiao;
                        
                        echo "<script language='javascript' type='text/javascript'>
                            alert('Município cadastrado com sucesso');
                            window.location.href='../view/municipios/cad_municipios.php';
                        </script>";

                    
                    //Caso ocorra algum erro no Banco de Dados
                    } catch (\Throwable $th) {
                        $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                        $erros_serializados = serialize($erros);
                        $_SESSION['erros'] = $erros_serializados;
                        header('location: ../view/municipios/view_erros.php');
                    }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/municipios/view_erros.php');
                }            
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/municipios/cad_municipios.php';
                </script>";
            }
            break;

            //Executa a pesquisa
            case 'pesquisar':
                $municipioDAO = new MunicipioDAO;
                $array = array();
                $array = $municipioDAO->searchMunicipio();

                $_SESSION['municipio']= serialize($array);

                header("location:../view/municipios/cad_municipios.php");
            break;
        
            //Executa a alteração
            case 'alterar':
                if ((!empty($_POST['id-edit'])) && (!empty($_POST['descricao-edit'])) && (!empty($_POST['microrregiao-edit'])) ) {
                    $erros = array();

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo descrição não está vazio (strlen)
                    if (strlen(trim($_POST['descricao-edit'])) == 0) {
                        $erros[] = 'O nome de Microrregião não pode estar em branco!';
                    }

                    //Limpando os espaços nas extremidades (Trim) e 
                    //verificando se o campo Microrregião não está vazio (strlen)
                    if (strlen(trim($_POST['microrregiao-edit'])) == 0) {
                        $erros[] = 'A microrregiao não pode estar em branco!';
                    }
                    
                    //Verifica se o Município com o esta Microrregião já estão cadastrados com outro 'id' no Banco de Dados
                    $municipioDAO = new MunicipioDAO();
                    
                    if ($municipioDAO->searchMunicipioDuplicidade($_POST['descricao-edit'], $_POST['microrregiao-edit'], $_POST['id-edit']) != null) {
                        $erros[] = 'Este nome de Município com esta Microrregião já está sendo usado em outro cadastro!';
                    }

                    //Verifica se não há erros e persiste no Banco de Dados
                    if (count($erros) == 0) {
                        try {
                            $municipio = new MunicipioModel();
                            $municipio->id = $_POST['id-edit'];
                            $municipio->descricao = $_POST['descricao-edit'];
                            $municipio->id_microrregiao = $_POST['microrregiao-edit'];

                            $municipioDAO = new MunicipioDAO;
                            $municipioDAO->updateMunicipio($municipio);

                            $_SESSION['id'] = $municipio->id;
                            $_SESSION['municipio']= $municipio->descricao;
                            $_SESSION['id_microrregiao'] = $municipio->id_microrregiao;

                            echo "<script language='javascript' type='text/javascript'>
                                alert('Microrregiao alterada com sucesso!');
                                window.location.href='../view/municipios/cad_municipios.php';
                            </script>";
                        break;

                        //Caso ocorra algum erro no Banco de Dados
                        } catch (\Throwable $th) {
                            $erros[] = 'Erro Interno. Verifique com o Administrador do Banco de Dados!';
                            $erros_serializados = serialize($erros);
                            $_SESSION['erros'] = $erros_serializados;
                            header('location: ../view/municipios/view_erros.php');
                        }                        
                
                //Caso existam erros, eles são serializados e enviadas para a página de erros
                } else {
                    $erros_serializados = serialize($erros);
                    $_SESSION['erros'] = $erros_serializados;
                    header('location: ../view/municipios/view_erros.php');
                }
            
            //Alerta de campos não preenchidos
            } else {
                echo "<script language='javascript' type='text/javascript'>
                    alert('Preencha todos os campos!');
                    window.location.href='../view/municipios/cad_municipios.php';
                </script>";
            }
            break;

            //Executa a exclusão
            case 'excluir':
                $municipioDAO = new MunicipioDAO;
                $array = array();
                $array = $municipioDAO->deleteMunicipio($_GET['id']);

                $_SESSION['municipio']= serialize($array);
                
                echo "<script language='javascript' type='text/javascript'>
                    alert('Município excluído com sucesso!');
                    window.location.href='../view/municipios/cad_municipios.php';
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