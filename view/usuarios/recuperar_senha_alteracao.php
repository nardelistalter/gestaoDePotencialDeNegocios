<?php
    session_start();
    include '../../libs/functions.php';
?>
<?php 
    if(isset($_SESSION['recovery'])):
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height-device-height, initial-scale=1, maximum-scale=1.2, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../../img/logo.ico">
    <script type="text/javascript" src="../../libs/functions.js"></script>
    <title>Recuperação de senha</title>
</head>
<body style="background-color: #848484">

    <!--
        Barra superior vertical
    -->
    <header>
        <div class="barra_vertical">
            <img id="logo_system" src="../../img/logo.png">
            <div class="div_id" id="div_id_no_log">Informe nova senha!</div>
            <a href=""><img id="img_block" src="../../img/block.png"></a> 
        </div>
    </header>

    <?php $_SESSION['email']; $_SESSION['hash']; ?>

    <!--
        Formulário para alteração da senha
    -->
    <form action="../../controller/controller_usuario_nova_senha.php?email=<?php echo $_SESSION['email']; ?>&hash=<?php echo $_SESSION['hash']; ?>" id="login-box" name="register_form" onsubmit="return validarSenha(this)" method="POST">
        <div class="input-div" id="input-email">
            <input type="password" id="pass" name="pass" placeholder="Informe a Nova Senha" required autofocus><br>
        </div>
        <div class="input-div" id="input-pass_confirm">
            <input type="password" id="pass_confirm" name="pass_confirm" placeholder="Confirme a Nova Senha" required autofocus><br>
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
    <!-- Redirecionamento em caso de tentativa de acesso sem link válido-->
    <?php header('location: ../../index.php'); ?>
<?php endif; ?>