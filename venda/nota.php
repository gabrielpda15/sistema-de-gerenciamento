<?php
    include '../library/pdf-utils.php';   
    use Mzur\InvoiScript\Invoice;

    if (!isset($_REQUEST['id']) || $_REQUEST['id'] == 0) {
        print "<script>alert('É necessario um id para continuar!');</script>";
        print "<script>location.href='/venda'</script>";
    }

    $sql = "SELECT * FROM venda WHERE id_venda=" . $_REQUEST['id'];
    $res = $conn->query($sql);
    $row = $res->fetch_object();

    if ($row) {
        $id_cliente = $row->id_cliente;
        $cliente = [ 'Nenhum cliente vinculado.' ];

        if ($id_cliente != '') {
            $cliente = [];
            $sql = "SELECT * FROM cliente WHERE id_cliente=" . $id_cliente;
            $res = $conn->query($sql);
            $row = $res->fetch_object();
            array_push($cliente, $row->nome_cliente);
            array_push($cliente, 'CPF: ' . $row->cpf_cliente);
            array_push($cliente, 'Telefone: ' . $row->telefonecliente);
        }

        $sql = "SELECT I.quantidade, I.valor_venda, P.nome_produto, P.preco_produto
            FROM item_venda I
            INNER JOIN produtos P ON P.id_produtos = I.produtos_id_produtos
            WHERE I.venda_id_venda = " . $_REQUEST['id'];
        $res = $conn->query($sql);

        $items = [];
        while($row = $res->fetch_object()) {
            $item = [];
            $item['description'] = $row->nome_produto;
            $item['quantity'] = $row->quantidade;
            $item['price'] = $row->preco_produto;
            array_push($items, $item);
        }

        if (count($items) > 0) {
            date_default_timezone_set('America/Sao_Paulo');
            $date = date('d/m/Y');
    
            $content = [
               'title' => 'Nota Nº ' . $_REQUEST['id'],
               'beforeInfo' => [
                  '<b>Data:</b>',
                  $date,
               ],
               'afterInfo' => [
                  'Todos os preços estão em BRL.',
                  '',
                  'Essa nota é de uma compra feita em <b>' . $date . '</b>.',
               ],
               'clientAddress' => $cliente,
               'entries' => $items,
            ];
      
            $pdf = new Invoice($content);
            $pdf->setLanguage('pt');
    
            $pdf_location = 'notas_output/nota_'.$_REQUEST['id'].'.pdf';
            $pdf->generate($pdf_location);
    
            print "<div class=\"d-flex flex-column m-auto\">
                <h4 class=\"mx-auto\">Nota emitida com sucesso!</h4>
                <p class=\"mx-auto\">
                    Clique 
                    <a href=\"/venda/$pdf_location\" target=\"_blank\">aqui</a>
                    para ver a nota.
                </p>
            </div>";
        } else {
            print "<script>alert('Essa venda não possui nenhum item ainda!');</script>";
            print "<script>location.href='/venda'</script>";
        }        
    } else {
        print "<script>alert('Venda não encontrada!');</script>";
        print "<script>location.href='/venda'</script>";
    }

?>