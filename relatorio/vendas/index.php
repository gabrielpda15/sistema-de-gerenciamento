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
                    <div class="d-flex">
                        <h1 class="mx-auto mb-5">Relatório de Vendas</h1>
                    </div>
                    <form action="" method="POST" class="d-flex flex-column mx-auto">
                        <div class="d-flex w-100 mb-2">
                            <label class="w-50 ps-3">Inicio:</label>
                            <label class="w-50 ps-3">Fim:</label>
                        </div>
                        <div class="d-flex mx-auto">
                            <input id="start-date" name="start-date" class="form-control mx-2" type="date" required />
                            <input id="end-date" name="end-date" class="form-control mx-2" type="date" required />
                        </div>
                        <button type="submit" class="btn btn-primary mx-auto mt-4 px-4">Procurar</button>
                    </form>                    
                    <?php
                        include "../../config.php";
                        include '../../library/pdf-utils.php';   
                        use Mzur\InvoiScript\Invoice;
                        
                        if (isset($_POST['start-date']) && isset($_POST['end-date'])) {
                            $start_date = $_POST['start-date'] . " 00:00:00";
                            $end_date = $_POST['end-date'] . " 00:00:00";
                            
                            $sql = "SELECT p.nome_produto, p.preco_produto, SUM(i.quantidade) AS 'quantidade', SUM(i.valor_venda) AS 'valor', SUM(i.valor_venda / i.quantidade) / COUNT(*) AS 'media'
                                FROM item_venda i
                                INNER JOIN produtos p ON i.produtos_id_produtos = p.id_produtos
                                INNER JOIN venda v ON i.venda_id_venda = v.id_venda
                                WHERE v.data_venda >= '$start_date' AND v.data_venda <= '$end_date'
                                GROUP BY p.id_produtos;";

                            $res = $conn->query($sql);
                            $qtd = $res->num_rows;
                            if ($qtd > 0) {
                                print "<p class=\"text-success mx-auto mt-5\">Encontrado(s) $qtd registro(s)!</p>";

                                $items = [];
                                while ($row = $res->fetch_object()) {
                                    $item = [];
                                    $item['description'] = $row->nome_produto;
                                    $item['quantity'] = $row->quantidade;
                                    $preco = number_format($row->preco_produto, 2, ',', '.');
                                    $media = number_format($row->media, 2, ',', '.');
                                    $item['price'] = "$preco  /  $media";
                                    $item['total'] = $row->valor;
                                    array_push($items, $item);
                                }

                                date_default_timezone_set('America/Sao_Paulo');
                                $date = date('d/m/Y');

                                $content = [
                                    'title' => 'Relatório de vendas',
                                    'beforeInfo' => [
                                       '<b>Data:</b>',
                                       $date,
                                    ],
                                    'afterInfo' => [
                                       'Todos os preços estão em BRL.',
                                       '',
                                       'Esse é um relatório de vendas feito em <b>' . $date . '</b>.'
                                    ],
                                    'clientAddress' => [
                                        'Período de referencia:',
                                        'Inicio:   ' . date('d/m/Y', strtotime($start_date)),
                                        'Fim:     ' . date('d/m/Y', strtotime($end_date))
                                    ],
                                    'entries' => $items,
                                ];

                                $pdf = new Invoice($content);
                                $pdf->setLanguage('pt3');                        
                                $pdf_location = 'relatorio_de_vendas.pdf';
                                $pdf->generate($pdf_location);

                                print "<p class=\"mx-auto\">
                                    Clique 
                                    <a href=\"/relatorio/vendas/$pdf_location\" target=\"_blank\">aqui</a>
                                    para ver o relatório.
                                </p>";
                            } else {
                                print "<p class=\"text-danger mx-auto mt-5\">Nenhuma entrada encontrada!</p>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php include "../../shared/scripts.php"; ?>
    </body>
</html>