<?php
    session_start();
    
    if (!isset($_SESSION['usuario']) || 
        strlen($_SESSION['usuario']) == 0) {
        header('Location: ../index.php');
    }

    if ($_SESSION['admin'] != 1) {
        header('Location: ../home.php');
        $_SESSION['acesso_negado'] = "Acesso negado!\\nVocê não tem permissão para isso!";
    }
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <base href="../">
        <?php include "../shared/head.php"; ?>
    </head>
    <body>
        <?php $title = "Funcionários"; $selected_menu = 2; include "../shared/nav-bar.php"; ?>
        <div class="d-flex w-100 h-100 pt-5 px-4 pb-4">
            <div class="d-flex w-100 h-100 mt-2 pt-4 px-5">
                <div class="d-flex flex-column w-100 h-100">
                    <button class="btn btn-primary w-auto me-auto px-3" onclick="history.back()">Voltar</button>
                    <?php
                        include "../config.php";
                        switch (@$_REQUEST["page"]) {
                            case "novo":
                                include "novo.php";
                                break;
                            case "editar":
                                include "editar.php";
                                break;
                            case "excluir":
                                include "excluir.php";
                                break;
                            default:
                                include "listar.php";
                                break;
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php include "../shared/scripts.php"; ?>
    </body>
</html>