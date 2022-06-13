<?php
    session_start();
    if (!isset($_SESSION['usuario']) || strlen($_SESSION['usuario']) == 0) {
        header('Location: ../index.php');
    }
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <base href="../">
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="css/style.css" />

        <title>Sistema de Gerenciamento</title>
    </head>
    <body>
        <?php $title = "Vendas"; $show_menu = true; $selected_menu = 0; include "../shared/nav-bar.php"; ?>
        <div class="d-flex w-100 h-100 pt-5 px-4 pb-4">
            <div class="d-flex w-100 h-100 mt-2 pt-4 px-5">
                <div class="d-flex flex-column w-100 h-100">
                    <button class="btn btn-primary w-auto me-auto px-3" onclick="history.back()">Voltar</button>
                    <?php
                        include("../config.php");
                        switch (@$_REQUEST["page"]) {
                            case "novo":
                                include("novo.php");
                                break;
                            case "produtos":
                                include("produtos.php");
                                break;
                            case "cliente":
                                include("cliente.php");
                                break;
                            case "excluir":
                                include("excluir.php");
                                break;
                            case "nota":
                                include("nota.php");
                                break;
                            default:
                                include("listar.php");
                                break;
                        }
                    ?>
                </div>
            </div>
        </div>
        <script src="js/jquery.slim.min.js"></script>
        <script src="js/jquery.mask.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>