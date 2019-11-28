<?php
    function texto_rodape() {
        echo "Nardeli Miguel Stalter &copy 2019 Todos os direitos reservados";
    }
    
    //Exibe o nome do usuário logado
    function id_logado($logado) {
        echo "Olá, $logado!";
    }

    function id_erro($local) {
        echo "$local";
    }

    function id_erro2($local) {
        return "$local";
    }

?>