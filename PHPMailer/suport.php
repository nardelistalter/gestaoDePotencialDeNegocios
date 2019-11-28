<?php
    include '../controller/controller_usuario_recupera_senha.php';

    $email      = 'gp.recovery.mail@gmail.com';
    $password   = 'Rec_Pass_9876';
    $email_to   = $email_X;
    $system     = 'Gerenciador BPM';
    $subject    = 'Recupere sua senha de acesso BPM!';
    $url        = 'http://localhost/gestaoDePotencialDeNegocios/controller/controller_usuario_troca_senha.php?hash=';
    $corpo      = 'Para trocar sua senha, clique no link abaixo:<br/><br/>' .$url . $hash . '<br/><br/>
        Caso não tenha solicitado, verifique sua conta pois outra pessoa pode estar tentando acessá-la';
?>