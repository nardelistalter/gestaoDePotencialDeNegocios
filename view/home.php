<?php
    session_start();
    include('../libs/functions.php');
?>
<?php /*Valida a sessão cfe login*/
    if(isset($_SESSION['logado'])):
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height-device-height, initial-scale=1, maximum-scale=1.2, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo.ico">
    <title>Home</title>
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
                    <li><span id="span_home"></span><a href="home.php" class="menu_enable">Home</a></li>
                    <li><span id="span_dashboard"></span><a href="dashboard.php" class="">Dashboard +</a>

                    </li>
                    <li><span id="span_register"></span><a href="cadastros.php" class="">Cadastro +</a>

                    </li>
                    <li><span id="span_definitions"></span><a href="definicoes.php" class="">Definições +</a>

                    </li>
                </ul>
            </nav> 
        </div>
    </header>
    <img id="logo_principal_menu" src="../img/logo_cat.png" href="../css/style.css">
    <div id="rodape">
        <div><?php texto_rodape();?></div>
    </div>
</body>
</html> 
<?php else: ?> <!-- Redireciona para a página de login em caso de tentativa acesso pelo browser sem sessão de login ativa -->
    <?php header('location: ../index.php'); ?>
<?php endif; ?>