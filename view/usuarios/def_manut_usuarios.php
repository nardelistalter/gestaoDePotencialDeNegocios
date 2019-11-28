<?php
    session_start();
    include '../../libs/functions.php';
    include '../../persistence/ConnectionDB.php';
    include '../../dao/UsuariosDAO.php';
    include '../../model/UsuariosModel.php';

?>
<?php
    if(isset($_SESSION['logado'])): // Valida a sessão
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <!--<meta name="viewport" content="width=device-width, height-device-height, initial-scale=1, maximum-scale=1.2, user-scalable=no">-->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../../img/logo.ico">
    <title>Manutenção de Usuários</title>
    <script type="text/javascript">	
		<?php
		    $usuariosDAO = new UsuariosDAO();
            $usuarios = array();
		   
			//Verifica se existe algum valor informado na barra de pesquisas
			if (isset($_POST['search'])) {
				//Se existe...
				$usuarios = $usuariosDAO->searchUsuarioVarredura($_POST['search']);
			} else {
				//Se não existe...
				$usuarios = $usuariosDAO->searchUsuario();                        
			}

            echo "var usuarios = ".json_encode($usuarios).";";
            
            //Imprime os usuarios no console
            //echo "console.log(usuarios);";
		?>
		
		// Método para abrir o modal de acordo com o botão clicado
		function abreModalDeEdicao(indice) {
			
			// Pegando o usuario pelo indice do botão
			let usuario = usuarios[indice];
			
            // Agora é só setar o nome e a sigla do usuario nas variaveis do modal e depois abrir o modal
            document.getElementById("id-edit").value = usuario.id;
            document.getElementById("email-edit").value = usuario.email;
            document.getElementById("nome-edit").value = usuario.nome;
			document.getElementById("ativo-edit").value = usuario.ativo;
			document.getElementById("administrador-edit").value = usuario.administrador;
            
            // Método 1 para abrir o modal... (não funcionando)
			//document.getElementById('modal-window-update').scrollIntoView();
			
			// Método 2 para abrir o modal... (funcionando)
			window.location.hash = '#modal-window-update';
		}
    </script>
</head>
<body>
    <header>

        <!--
            Barra superior horizontal
        -->
        <div class="barra_horizontal">
            <img id="logo_pagina" src="../../img/users.png" href="../../css/style.css">
            <p align="left" id="nome_pagina">Usuários</p>
            <p align="left" id="descricao_nome_pagina">Manutenção de Usuários (Acesso Restrito)</p>       
        </div>

        <!--
            Barra superior vertical
        -->
        <div class="barra_vertical">
            <img id="logo_system" src="../../img/logo.png" href="../../css/style.css">
            <div class="div_id" >
                <div id="div_id_log"><?php id_logado($_SESSION['nomeLogado']); ?></div>
                <a href="../../controller/controller_usuario.php?operation=logout"><img id="logout_icon" src="../../img/logout_icon.png"></a>
            </div> 
            <nav>
                <ul id="nav">
                    <li><span id="span_home"></span><a href="../home.php" class="">Home</a></li>
                    <li><span id="span_dashboard"></span><a href="../dashboard.php" class="">Dashboard +</a>
                        <ul>
                            <li><a href="" class="sub_menu_desable">- Painel</a></li>
                            <li><a href="" class="sub_menu_desable">- Gráficos</a></li>
                        </ul>
                    </li>
                    <li><span id="span_register"></span><a href="../cadastros.php" class="">Cadastro +</a>
                        <ul>
                            <li><a href="../estados/cad_estados.php" class="sub_menu_desable">- Estados</a></li>
                            <li><a href="../microrregioes/cad_microrregioes.php" class="sub_menu_desable">- Regiões/Coredes</a></li>
                            <li><a href="../municipios/cad_municipios.php" class="sub_menu_desable">- Municípios</a></li>
                            <li><a href="../segmentos_culturas/cad_segmentos_culturas.php" class="sub_menu_desable">- Segmento/Culturas</a></li>
                            <li><a href="../unidades_area/cad_unidades_area.php" class="sub_menu_desable">- Unidades de Área</a></li>
                            <li><a href="../grupo_produtos/cad_grupo_produtos.php" class="sub_menu_desable">- Grupos de Produtos</a></li>
                            <li><a href="../programas_negocios/cad_programas_negocios.php" class="sub_menu_desable">- Programas de Negócio</a></li>
                        </ul>
                    </li>
                    <li><span id="span_definitions"></span><a href="../definicoes.php" class="menu_enable">Definições -</a>
                        <ul>
                            <li><a href="def_altera_dados_usuario_logado.php" class="sub_menu_enable">- Alterar seus Dados</a></li>
                            <li><a href="def_manut_usuarios.php" class="sub_menu_enable" id="active">- Manutenção Usuários</a></li>
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
        <div class="crud_div"  id="crud_consultar">        
            <form action="#search-div" class="form_page_box" method="POST">
                <input type="search" id="search" name="search" placeholder="Digite para pesquisar..." aria-descriptedby="sizing-addon1" autofocus><button id="search-button" type="submit">&#128269;</button>
            </form>
        </div>
    </div>
    
    <!--
        Tabela que exibe os usuários
    -->
    <div class="div_table" id="div_table-user">
        <table class="tabela_cadastros">

            <!--
                Cabeçalho da Tabela
            -->
            <thead>
                <tr>
                    <th class="th_cadastros">Código</th>
                    <th class="th_cadastros">Nome do Usuário</th>
                    <th class="th_cadastros">E-mail</th>
                    <th class="th_cadastros">Ativo</th>
                    <th class="th_cadastros">Adm</th>
                    <th class="th_crud">Alterar</th>
                </tr>
            </thead>

            <!--
                Exibe na tabela todos os Estados cadastrados ou correspondentes a pesquisa 
            -->
            <tbody>
                <div id="search-div">
                    <?php 
                        $indice = 0;
                        foreach ($usuarios as $e) {
                            $ativo = ($e->ativo == 1) ? 'Sim' : 'Não';
                            $adm = ($e->administrador == 1) ? 'Sim' : 'Não';        
                            echo "<tr>
                                <td class='td_id'>$e->id</td>
                                <td class='td_body'>$e->email</td>
                                <td class='td_body'>$e->nome</td>
                                <td class='td_body'>$ativo</td>
                                <td class='td_body'>$adm</td>
                                <td class='td_edit'><a href='javascript:func()' onclick='abreModalDeEdicao($indice)'><img src='../../img/edit.png' class='img_table_ed_cl'></a></td>
                            </tr>";
                            $indice = $indice + 1;
                        }
                    ?>
                </div>
            </tbody>
        </table>
    </div>

    <!--
        Janela Modal para editar usuários
    -->
    <div class="modal-window" id="modal-window-update">
        <div class="modal-box-2">
            <form action="../../controller/controller_usuario.php?operation=alterar-ativo-adm" class="user-crud-box-2" name="register_form" id="register_form" class="user-crud-box-3" onsubmit="return validarSenha(this)" method="POST">
                <div>
                    <input type="hidden" name="id-edit" id="id-edit">
                </div>  
                <div>
                    <input type="hidden" name="email-edit" id="email-edit">
                </div>                 
               
                <div class="input-div" id="input-name"><br><br>
                    <input type="text" id="nome-edit" name="nome-edit" disabled value="nome-edit" maxlength="60" aria-descriptedby="sizing-addon1" required autofocus><br>
                </div>
                <div class="input-div" id="ativo-edit" name="ativo-edit">
                    <select name="select">
                        <?php
                            echo '<option value="1" selected>Ativo</option>
                                <option value="0">Inativo</option>';                     
                        ?>                       
                    </select><br>
                </div>
                <div class="input-div" id="administrador-edit" name="administrador-edit">
                    <select name="select">
                        <?php
                            echo '<option value="1" >Administrador? Sim</option>    
                                <option value="" selected>Administrador? Não</option>';                      
                        ?>                       
                    </select><br>
                </div>
                <input type="submit" class="botoes" id="botao-enviar" name="botao-enviar" value="ALTERAR">
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
    <!-- Redirecionamento em caso de tentativa de acesso sem login-->
    <?php header('location: ../../index.php'); ?> 
<?php endif; ?>