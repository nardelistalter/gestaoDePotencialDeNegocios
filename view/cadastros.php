<?php
    session_start();
    include('../libs/functions.php');
?>
<?php
    if(isset($_SESSION['logado'])):
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height-device-height, initial-scale=1, maximum-scale=1.2, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo.ico">
    <title>Cadastros</title>
</head>
<body style="background-color: #848484">
    <header>
        <div class="barra_vertical">
            <img id="logo_system" src="../img/logo.png" href="../css/style.css">
            <div class="div_id" >
                <div id="div_id_log"><?php id_logado($_SESSION['nomeLogado']); ?></div>
                <a href="../controller/controller_usuario.php?operation=logout"><img id="logout_icon" src="../img/logout_icon.png"></a>
            </div> 
            <nav>
                <ul id="nav">
                    <li><span id="span_home"></span><a href="home.php" class="">Home</a></li>
                    <li><span id="span_dashboard"></span><a href="dashboard.php" class="">Dashboard +</a>

                    </li>
                    <li><span id="span_register"></span><a href="cadastros.php" class="menu_enable">Cadastro -</a>
                        <ul>
                            <li><a href="estados/cad_estados.php" class="sub_menu_enable">- Estados</a></li>
                            <li><a href="microrregioes/cad_microrregioes.php" class="sub_menu_enable">- Microrregiões</a></li>
                            <li><a href="municipios/cad_municipios.php" class="sub_menu_enable">- Municípios</a></li>
                            <li><a href="segmentos_culturas/cad_segmentos_culturas.php" class="sub_menu_enable">- Segmento/Culturas</a></li>
                            <li><a href="unidades_area/cad_unidades_area.php" class="sub_menu_enable">- Unidades de Área</a></li>
                            <li><a href="grupo_produtos/cad_grupo_produtos.php" class="sub_menu_enable">- Grupos de Produtos</a></li>
                            <li><a href="programas_negocios/cad_programas_negocios.php" class="sub_menu_enable">- Programas de Negócio</a></li>
                        </ul>
                    </li>
                    <li><span id="span_definitions"></span><a href="definicoes.php" class="">Definições +</a>

                    </li>
                </ul>
            </nav> 
        </div>
    </header>
    <img id="logo_principal_menu" src="../img/register_cat.png" href="../css/style.css">
    <div id="rodape">
        <div><?php texto_rodape();?></div>
    </div>
</body>
</html>  
<?php else: ?>
    <?php header('location: ../index.php'); ?>
<?php endif; ?>