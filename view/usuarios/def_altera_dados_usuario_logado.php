<?php
    session_start();
    include('../../libs/functions.php');
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
    <script type="text/javascript" src="../../libs/functions.js"></script>
    <title>Manutenção de Usuários</title>
</head>
<body>
    <header>
        <div class="barra_horizontal">
            <img id="logo_pagina" src="../../img/users.png" href="../../css/  style.css">
            <p align="left" id="nome_pagina">Usuário Logado</p>
            <p align="left" id="descricao_nome_pagina">Alteração dos Dados do Usuário</p>       
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
                    <li><span id="span_register"></span><a href="../cadastros.php" class="">Cadastro +</a>
                        <ul>
                            <li><a href="../estados/cad_estados.php" class="sub_menu_desable">- Estados</a></li>
                            <li><a href="../microrregioes/cad_microrregioes.php" class="sub_menu_desable">- Microrregiões</a></li>
                            <li><a href="../municipios/cad_municipios.php" class="sub_menu_desable">- Municípios</a></li>
                            <li><a href="../segmentos_culturas/cad_segmentos_culturas.php" class="sub_menu_desable">- Segmento/Culturas</a></li>
                            <li><a href="../unidades_area/cad_unidades_area.php" class="sub_menu_desable">- Unidades de Área</a></li>
                            <li><a href="../grupo_produtos/cad_grupo_produtos.php" class="sub_menu_desable">- Grupos de Produtos</a></li>
                            <li><a href="../programas_negocios/cad_programas_negocios.php" class="sub_menu_desable">- Programas de Negócio</a></li>
                        </ul>
                    </li>
                    <li><span id="span_definitions"></span><a href="../definicoes.php" class="menu_enable">Definições -</a>
                        <ul>
                            <li><a href="def_altera_dados_usuario_logado.php" class="sub_menu_enable" id="active">- Alterar seus Dados</a></li>
                            <!--<li><a href="def_manut_usuarios.php" class="sub_menu_enable" id="">- Manutenção Usuários</a></li>-->
                        </ul>
                    </li>
                </ul>
            </nav> 
        </div>
    </header>

    
    <!--
        Formulário para alteração da senha e nome
    -->
    <form action="../../controller/controller_usuario.php?operation=alterar" class="register-user-box" name="register_form" id="user_update_form" onsubmit="return validarSenha(this)" method="POST">
        <div class="input-div" id="input-email"> <!-- input-email: distancia da parte superior-->
            <input type="password" id="atual_pass-edit" name="atual_pass-edit" placeholder="Informe a Senha Atual" required autofocus><br>
        </div>
        <div>
            <input type="hidden" name="email-edit" id="email-edit" value="<?php echo $_SESSION['emailLogado']; ?>">
        </div>  
        <div class="input-div" id="input-pass">
            <input type="password" id="pass-edit" name="pass-edit" placeholder="Informe a Nova Senha" required autofocus><br>
        </div>
        <div class="input-div" id="input-pass_confirm">
            <input type="password" id="pass_confirm-edit" name="pass_confirm-edit" placeholder="Confirme a Nova Senha" required autofocus><br>
        </div>
        <div class="input-div" id="input-name">
            <input type="text" id="name-edit" name="name-edit" maxlength="60" placeholder="Seu nome de Usuário (opcional)" aria-descriptedby="sizing-addon1" autofocus><br>
        </div>
        <input type="submit" class="botoes" id="botao-enviar" name="botao-enviar" value="ALTERAR">
        <input type="reset" class="botoes" id="botao-cancelar" name="botao-cancelar" value="LIMPAR">
    </form>

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