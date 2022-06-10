<?php
    session_start();
    if (!isset($_SESSION['usuario']) || strlen($_SESSION['usuario']) == 0) {
        header('Location: index.php');
    }

    require 'config.php';
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <base href="/">
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="css/style.css" />

        <title>Sistema de Gerenciamento - Home</title>
    </head>
    <body>
        <nav class="navbar bg-primary fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php" style="color: white">Sistema de Gerenciamento | Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar" style="color:rgba(34, 123, 248, 0.8)">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header" style="background-color: blue;">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel" style="color:aliceblue">Tela de Gerenciamento
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item dropdown">
                                <a id="gerenciamento-dropdown" class="nav-link dropdown-toggle text-dark" href="#" 
                                    role="button" data-bs-toggle="dropdown" data-bs-auto-close="false">
                                    Gerenciamento
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="gerenciamento-dropdown">
                                    <li><a class="dropdown-item" href="venda">
                                        Gerenciamento de Venda
                                    </a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="cliente">
                                        Gerenciamento de Cliente
                                    </a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="funcionario">
                                        Gerenciamento de Funcionário
                                    </a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="produto">
                                        Gerenciamento de Produto
                                    </a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item dropdown">
                                <a id="relatorio-dropdown" class="nav-link dropdown-toggle text-dark" href="#" role="button"
                                    data-bs-toggle="dropdown" data-bs-auto-close="false">
                                    Relatorios
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="relatorio-dropdown">
                                    <li><a class="dropdown-item" href="#">
                                        Relatorio de Vendas
                                    </a></li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="#">
                                        Relatorio de Entradas
                                    </a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex mb-3 me-3">
                        <a href="logout.php" class="btn btn-danger d-flex ms-auto" style="width: 80px;">
                            <span class="icon logout me-2 my-auto"></span>
                            Sair
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="d-flex w-100 h-100 pt-5 px-4 pb-4">
            <div class="d-flex w-100 h-100 mt-2 pt-4 px-5">
                <div class="d-flex flex-column w-100 h-100">
                    <h1 class="mx-auto">Sistema de Gerenciamento</h1>
                    <div class="d-flex w-100 py-4">
                        <div class="d-flex flex-column col-4 border rounded px-4 py-3">
                            <p class="mx-auto mb-1">Produtos mais vendidos</p>
                            <p class="text-black-50 fst-italic mb-0 ms-auto">* Nos ultimos 30 dias.</p>
                            <hr class="my-2" />
                            <div class="d-flex flex-column pt-4">
                                <?php
                                    date_default_timezone_set('America/Sao_Paulo');
                                    $date = date_sub(date_create(date('y-m-d')), date_interval_create_from_date_string("30 days"));
                                    $date = date_format($date, 'Y-m-d H:i:s');
                                    
                                    $sql = "SELECT COUNT(P.id_produtos) AS 'quantidade', P.nome_produto FROM venda V
                                        INNER JOIN item_venda I ON I.venda_id_venda = V.id_venda
                                        INNER JOIN produtos P ON I.produtos_id_produtos = P.id_produtos
                                        WHERE V.data_venda >= '$date'
                                        GROUP BY P.id_produtos";
                                
                                    $res = $conn->query($sql);
                                    $qtd = $res->num_rows;
                                    if ($qtd > 0) {
                                        while($row = $res->fetch_object()) {
                                            print "<div class=\"d-flex w-100\">
                                            </div>";
                                        }
                                    } else {
                                        print "<div class=\"d-flex alert alert-danger\">
                                            <p class=\"my-0 mx-auto\">Nenhuma venda realizada ainda!</p>
                                        </div>";
                                    }                                    
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
    </body>
</html>