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
    <script type="text/javascript" src="../../libs/functions.js"></script>
    <title>Cadastro de Usuário</title>
</head>
<body style="background-color: #848484">
    
    <!--
        Barra superior vertical
    -->
    <header>
        <div class="barra_vertical">
            <img id="logo_system" src="../../img/logo.png" href="../../css/style.css">
            <div class="div_id" id="div_id_no_log">Cadastre-se!</div>
            <a href="../../index.php"><img id="img_block" src="../../img/block.png"></a> 
        </div>
    </header>

    <!--
        Formulário para cadastro de usuário
    -->
    <form action="../../controller/controller_usuario.php?operation=cadastrar" class="register-user-box" name="register_form" id="register_form" onsubmit="return validarSenha(this)" method="POST">
        <div class="input-div" id="input-email">
            <input type="email" id="email" name="email" placeholder="E-mail" aria-descriptedby="sizing-addon1" required autofocus><br>
        </div>
        <div class="input-div" id="input-pass">
            <input type="password" id="pass" name="pass" placeholder="Informe a Senha" required autofocus><br>
        </div>
        <div class="input-div" id="input-pass_confirm">
            <input type="password" id="pass_confirm" name="pass_confirm" placeholder="Confirme a Senha" required autofocus><br>
        </div>
        <div class="input-div" id="input-name">
            <input type="text" id="name" name="name" maxlength="60" placeholder="Seu nome de Usuário" aria-descriptedby="sizing-addon1" required autofocus><br>
        </div>
        <input type="submit" class="botoes" id="botao-enviar" name="botao-enviar" value="CADASTRAR">
        <input type="reset" class="botoes" id="botao-cancelar" name="botao-cancelar" value="LIMPAR">
        <p align="center" id="label-recuperar_senha">Para recuperar sua senha,<a href="recuperar_senha.php"> clique aqui.</a></p>
    </form>
    
    <!--
        Função para exibir dados do rodapé
    -->
    <div id="rodape">
        <div><?php texto_rodape();?></div>
    </div>
</body>
</html>