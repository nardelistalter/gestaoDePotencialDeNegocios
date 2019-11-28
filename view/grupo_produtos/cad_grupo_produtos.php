<?php
    session_start();
    include('../../libs/functions.php');
    include '../../persistence/ConnectionDB.php';
    include '../../dao/GrupoProdutosDAO.php';
    include '../../model/GrupoProdutosModel.php';
?>
<?php
    // Valida a sessão conforme o login
    if(isset($_SESSION['logado'])):
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height-device-height, initial-scale=1, maximum-scale=1.2, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../../img/logo.ico">
    <title>Cadastro de Grupos de Produtos</title>
    <script type="text/javascript">	
		<?php
		   $grupoProdutosDAO = new GrupoProdutosDAO;
           $grupoProdutos = array();
		   
			//Verifica se existe algum valor informado na barra de pesquisas
			if (isset($_POST['search'])) {
				//Se existe...
				$grupoProdutos = $grupoProdutosDAO->searchGrupoProdutoVarredura($_POST['search']);
			} else {
				//Se não existe...
				$grupoProdutos = $grupoProdutosDAO->searchGrupoProduto();                        
            }
			
            echo "var grupoProdutos = ".json_encode($grupoProdutos).";";
            
            //Imprime os grupoProdutos no console
            //echo "console.log(grupoProdutos);";
		?>
		
		// Método para abrir o modal de acordo com o botão clicado
		function abreModalDeEdicao(indice) {
			
			// Pegando o grupoProduto pelo indice do botão
			let grupoProduto = grupoProdutos[indice];
			
            // Agora é só setar o nome do grupoProduto nas variaveis do modal e depois abrir o modal
            document.getElementById("id-edit").value = grupoProduto.id;
			document.getElementById("descricao-edit").value = grupoProduto.descricao;
            
            // Método 1 para abrir o modal... (não funcionando)
			//document.getElementById('modal-window-update').scrollIntoView();
			
			// Método 2 para abrir o modal... (funcionando)
			window.location.hash = '#modal-window-update';
		}

        /*
         * Função JS que solicita confirmação da exclusão de um grupoProduto
         */
        function confirmaExclusao(id) {
            var resposta = confirm("Deseja remover esse registro?");        
            if (resposta == true) {
                window.location.href = "../../controller/controller_grupo_produtos.php?operation=excluir&id="+id;
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="barra_horizontal">
            <img id="logo_pagina" src="../../img/grupo_produtos.png" href="../../css/style.css">
            <p align="left" id="nome_pagina">Grupos de Produtos</p>
            <p align="left" id="descricao_nome_pagina">Cadastro de Grupos de Produtos</p>       
        </div>
        <div class="barra_vertical">
            <img id="logo_system" src="../../img/logo.png" href="../../css/style.css">
            <div class="div_id" >
                <div id="div_id_log"><?php id_logado($_SESSION['nomeLogado']); ?></div>
                <a href="../../controller/controller_usuario.php?operation=logout"><img id="logout_icon" src="../../img/logout_icon.png"></a>
            </div> 

            <!-- 
                Lista de Menus e submenus 
            -->
            <nav>
                <ul id="nav">
                    <li><span id="span_home"></span><a href="../home.php" class="">Home</a></li>
                    <li><span id="span_dashboard"></span><a href="../dashboard.php" class="">Dashboard +</a>
                        <ul>
                            <li><a href="" class="sub_menu_desable">- Painel</a></li>
                            <li><a href="" class="sub_menu_desable">- Gráficos</a></li>
                        </ul>
                    </li>
                    <li><span id="span_register"></span><a href="../cadastros.php" class="menu_enable">Cadastro -</a>
                        <ul>
                            <li><a href="../estados/cad_estados.php" class="sub_menu_enable">- Estados</a></li>
                            <li><a href="../microrregioes/cad_microrregioes.php" class="sub_menu_enable">- Microrregiões</a></li>
                            <li><a href="../municipios/cad_municipios.php" class="sub_menu_enable">- Municípios</a></li>
                            <li><a href="../segmentos_culturas/cad_segmentos_culturas.php" class="sub_menu_enable">- Segmento/Culturas</a></li>
                            <li><a href="../unidades_area/cad_unidades_area.php" class="sub_menu_enable">- Unidades de Área</a></li>
                            <li><a href="cad_grupo_produtos.php" class="sub_menu_enable" id="active">- Grupos de Produtos</a></li>
                            <li><a href="../programas_negocios/cad_programas_negocios.php" class="sub_menu_enable">- Programas de Negócio</a></li>
                        </ul>
                    </li>
                    <li><span id="span_definitions"></span><a href="../definicoes.php" class="">Definições +</a>
                        <ul>
                            <li><a href="../usuarios/def_manut_usuarios.php" id="" class="sub_menu_desable">- Manutenção Usuários</a></li>
                        </ul>
                    </li>
                </ul>
            </nav> 
        </div>
    </header>

    <!-- 
        Div com os botão de criar novo cadastro e de pesquisa 
    -->
    <div class="container">
        <div class="crud_div"  id="crud_cadastrar">        
            <form action="#modal-window-insert" class="form_page_box" method="POST">
                <input type="submit" class="botoes_crud" id="botao_crud_novo" name="botao_crud_novo" value="NOVO"></br></br>
            </form>
        </div>
        <div class="crud_div"  id="crud_consultar">        
            <form action="#search-div" class="form_page_box" method="POST">
                <input type="search" id="search" name="search" placeholder="Digite para pesquisar" aria-descriptedby="sizing-addon1" autofocus><button id="search-button" type="submit">&#128269;</button>
            </form>
        </div>
    </div>

    <!--
        Tabela que exibe os Grupo de Produtos
    -->
    <div class="div_table" id="div_table">
        <table class="tabela_cadastros">

            <!--
                Cabeçalho da Tabela
            -->
            <thead>
                <tr>
                    <th class="th_cadastros">Código</th>
                    <th class="th_cadastros">Grupo de Produtos</th>
                    <th class="th_crud" colspan="2">Alterar</th>
                </tr>
            </thead>

            <!--
                Exibe na tabela todos os Grupo de Produtos cadastrados ou correspondentes a pesquisa 
            -->
            <tbody>
                <div id="search-div">
                    <?php 
                        $indice = 0;
                        foreach ($grupoProdutos as $e) {
                            echo "<tr>
                                <td class='td_id'>$e->id</td>
                                <td class='td_body'>$e->descricao</td>
                                <td class='td_edit'><a href='javascript:func()' onclick='abreModalDeEdicao($indice)'><img src='../../img/edit.png' class='img_table_ed_cl'></a></td>
                                <td class='td_clear'><a href='javascript:func()' onclick='confirmaExclusao($e->id)'><img src='../../img/clear.png' class='img_table_ed_cl'></a></td>
                            </tr>";
                            $indice = $indice + 1;
                        }
                    ?>
                </div>
            </tbody>
        </table>
    </div>

    <!--
        Janela Modal para INSERIR Grupo de Produtos
    -->
    <div id="modal-window-insert" class="modal-window" >
        <div class="modal-box-1">
            <form action="../../controller/controller_grupo_produtos.php?operation=cadastrar" class="user-crud-box-1" name="register_form" id="register_form" method="POST">
                <div class="input-div" id="input-name"><br><br>
                    <input type="text" id="descricao" name="descricao" maxlength="60" placeholder="Descrição" aria-descriptedby="sizing-addon1" required autofocus><br>
                </div>
                <input type="submit" class="botoes" id="botao-enviar" name="botao-enviar" value="SALVAR">
                <input type="reset" class="botoes" id="botao-cancelar" name="botao-cancelar" value="LIMPAR">
            </form>
            <!--
                Link para fechar Janela Modal
            -->
            <a href="" id="close">X</a> 
        </div>
    </div>

    <!--
        Janela Modal para EDITAR Grupo de Produtos
    -->
    <div id="modal-window-update" class="modal-window" >
        <div class="modal-box-1">
            <form action="../../controller/controller_grupo_produtos.php?operation=alterar" class="user-crud-box-1" name="register_form" id="register_form" method="POST">
                <div>
                    <input type="hidden" name="id-edit" id="id-edit">
                </div>                
                <div class="input-div" id="input-name"><br><br>
                    <input type="text" id="descricao-edit" name="descricao-edit" maxlength="60" aria-descriptedby="sizing-addon1" required autofocus><br>
                </div>
                <input type="submit" class="botoes" id="botao-enviar" name="botao-enviar" value="ALTERAR">
                <a href=""><div class="botoes" id="botao-cancelar" name="botao-cancelar">CANCELAR</div></a> 
            </form>
            <!--
                Link para fechar Janela Modal
            -->
            <a href="" id="close">X</a> 
        </div>
    </div>

    <!--
        Função para exibir dados do rodapé
    -->
    <div id="rodape">
        <div><?php texto_rodape();?></div>
    </div>
</body>
</html>
<?php else: ?>
    <!--
        Redirecionamento no caso de tentativa de acesso sem login
    -->
    <?php header('location: ../../index.php'); ?>
<?php endif; ?>