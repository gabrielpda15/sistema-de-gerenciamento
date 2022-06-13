<?php
    session_start();
    
    if (!isset($_SESSION['usuario']) || 
        strlen($_SESSION['usuario']) == 0) {
        header('Location: ../../index.php');
    }

    if ($_SESSION['admin'] != 1) {
        $_SESSION['acesso_negado'] = "Acesso negado!\\nVocê não tem permissão para isso!";
        header('Location: ../../home.php');
    }
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <base href="../../">
        <?php include "../../shared/head.php"; ?>
    </head>
    <body>
        <?php $title = "Relatório de Vendas"; $selected_menu = 4; include "../../shared/nav-bar.php"; ?>
        <div class="d-flex w-100 h-100 pt-5 px-4 pb-4">
            <div class="d-flex w-100 h-100 mt-2 pt-4 px-5">
                <div class="d-flex flex-column w-100 h-100">
                    <button class="btn btn-primary w-auto me-auto px-3" onclick="history.back()">Voltar</button>
                    <?php
                        include "../../config.php";
                        
                    ?>
                </div>
            </div>
        </div>
        <?php include "../../shared/scripts.php"; ?>
    </body>
</html>