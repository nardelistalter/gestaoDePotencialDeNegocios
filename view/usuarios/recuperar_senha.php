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
    <title>Recuperar Senha</title>
</head>
<body style="background-color: #848484">

    <!--
        Barra superior vertical
    -->
    <header>
        <div class="barra_vertical">
            <img id="logo_system" src="../../img/logo.png" href="../../css/style.css">
            <div class="div_id" id="div_id_no_log">Recupere sua senha!</div>
            <a href="../../index.php"><img id="img_block" src="../../img/block.png"></a> 
        </div>
    </header>

    <!--
        Formulário para informar o e-mail
    -->
    <form action="../../PHPMailer/enviar.php" id="recovery-box" method="POST">
        <div class="input-div" id="input-email">
            <input type="email" id="email" name="email" placeholder="Informe o e-mail cadastrado" aria-descriptedby="sizing-addon1" required autofocus><br>
        </div>
        <input type="submit" class="botoes" id="botao-enviar" value="ENVIAR DADOS PARA O E-MAIL">
        <input type="hidden" name="enviar" value="form">
    </form>

    <!--
        Função para exibir dados do rodapé
    -->
    <div id="rodape">
        <div><?php texto_rodape();?></div>
    </div>
</body>
</html>