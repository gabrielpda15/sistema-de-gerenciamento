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
        <?php include "shared/head.php"; ?>
    </head>
    <body>
        <?php $title = "Home"; include "shared/nav-bar.php"; ?>
        <div class="d-flex w-100 h-100 pt-5 px-4 pb-4">
            <div class="d-flex w-100 h-100 mt-2 pt-4 px-5">
                <div class="d-flex flex-column w-100 h-100">
                    <h1 class="mx-auto mt-5">Sistema de Gerenciamento</h1>
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
                                    
                                    $sql = "SELECT COUNT(P.id_produtos) AS 'n_vendas', SUM(I.quantidade) AS quantidade, P.nome_produto FROM venda V
                                        INNER JOIN item_venda I ON I.venda_id_venda = V.id_venda
                                        INNER JOIN produtos P ON I.produtos_id_produtos = P.id_produtos
                                        WHERE V.data_venda >= '$date'
                                        GROUP BY P.id_produtos
                                        ORDER BY n_vendas DESC
                                        LIMIT 5";
                                
                                    $res = $conn->query($sql);
                                    $qtd = $res->num_rows;
                                    if ($qtd > 0) {
                                        print "<div class=\"d-flex w-100 mb-2\">
                                            <p class=\"col-4 mb-0\">N° vendas</p>
                                            <p class=\"col-4 mb-0\">Quantidade</p>
                                            <p class=\"col-4 mb-0\">Produto</p>
                                        </div>";
                                        while($row = $res->fetch_object()) {
                                            print "<div class=\"d-flex w-100 alt-col px-3 py-1\">
                                                <p class=\"col-4 mb-0\">" . $row->n_vendas . "</p>
                                                <p class=\"col-4 mb-0\">" . $row->quantidade . "</p>
                                                <p class=\"col-4 mb-0\">" . $row->nome_produto . "</p>
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
        <?php
            if (isset($_SESSION['acesso_negado']) && strlen($_SESSION['acesso_negado']) > 0) {
                print "<script>alert('" . $_SESSION['acesso_negado'] . "');</script>";
                unset($_SESSION['acesso_negado']);
            }

            include "shared/scripts.php";
        ?>
    </body>
</html>