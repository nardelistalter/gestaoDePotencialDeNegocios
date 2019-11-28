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
    <title>Definições</title>
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
                    <li><span id="span_register"></span><a href="cadastros.php" class="">Cadastro +</a>

                    </li>
                    <li><span id="span_definitions"></span><a href="definicoes.php" class="menu_enable">Definições -</a>
                        <ul>
                            <li><a href="usuarios/def_altera_dados_usuario_logado.php" class="sub_menu_enable">- Alterar seus Dados</a></li>
                            <!--<li><a href="usuarios/def_manut_usuarios.php" class="sub_menu_enable">- Manutenção Usuários</a></li>-->
                        </ul>
                    </li>
                </ul>
            </nav> 
        </div>
    </header>
    <img id="logo_principal_menu" src="../img/definitions_cat.png" href="../css/style.css">
    <div id="rodape">
        <div><?php texto_rodape();?></div>
    </div>
</body>
</html> 
<?php else: ?> 
    <?php header('location: ../index.php'); ?>
<?php endif; ?>