<?php
    session_start();
    include('../../libs/functions.php');
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../../img/logo.ico">
    <title>GTM - Erro no Cadastro</title>
</head>
<body style="background-color: #848484">
    <header>
        <div class="barra_vertical">
            <img id="logo_system" src="../../img/logo.png" href="../../css/style.css">
            <div class="div_id" id="div_id_no_log">Erro no cadastro!</div>
            <a href="../../index.php"><img id="img_block" src="../../img/block.png"></a> 
        </div>
    </header>
    <form class="div_view_erros">
        <img id="img_error" src="../../img/error.png"><br/>
        <p id="title_error" align="center" >ERRO NO CADASTRO DE UNIDADES/AREA</p><br/>
        <div id="div_div_view_erros" >
            <?php
                if (isset($_SESSION['erros'])) {
                    $erros = array();
                    $erros = unserialize($_SESSION['erros']);

                    foreach ($erros as $e) {
                        echo '<p> Erro: ' .$e . '</p>';
                        //echo '<br/> Erro: ' .$e;
                    }
                }
            ?>
        </div>
        <br/>
        <p align="center">Para voltar à área de cadastro,<a href="cad_unidades_area.php"> clique aqui.</a></p>
    </form>
    <div id="rodape">
        <div><?php texto_rodape();?></div>
    </div>
</body>
</html>