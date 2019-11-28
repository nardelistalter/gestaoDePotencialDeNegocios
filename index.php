<?php
session_start();
include('libs/functions.php');
?>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/logo.ico">
    <title>BPM - Início</title>
</head>

<body style="background-color: #848484">

    <!--
        Barra superior vertical
    -->
    <header>
        <div class="barra_vertical">
            <img id="logo_system" src="img/logo.png">
            <div class="div_id" id="div_id_no_log">Login</div>
            <a href=""><img id="img_block" src="img/block.png"></a>
        </div>
    </header>

    <!--
        Formulário para informar os dados para login, acesso a área de cadastro ou para recuperação de senha
    -->
    <form action="controller/controller_usuario.php?operation=login" id="login-box" method="POST">
        <div class="input-div" id="input-email">
            <input type="email" id="email" name="email" placeholder="E-mail" aria-descriptedby="sizing-addon1" required autofocus><br>
        </div>
        <div class="input-div" id="input-pass">
            <input type="password" id="pass" name="pass" placeholder="Senha" required autofocus><br>
        </div>
        <input type="submit" class="botoes" id="botao-login" name="botao-login" value="LOGIN">
        <a href="view/usuarios/cad_usuarios.php">
            <div class="botoes" id="botao-cadastro">CADASTRE-SE</div>
        </a>
        <p align="center" id="label-recuperar_senha">Esqueceu sua senha?<a href="view/usuarios/recuperar_senha.php"> Clique aqui.</a></p>
    </form>

    <!--
        Função para exibir dados do rodapé
    -->
    <div id="rodape">
        <div><?php texto_rodape(); ?></div>
    </div>
</body>

</html>