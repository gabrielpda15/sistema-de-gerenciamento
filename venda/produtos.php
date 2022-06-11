<?php
    if (isset($_SESSION['id_venda']) && $_SESSION['id_venda'] == -1) {
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('Y-m-d H:i:s');
        $id_cliente = isset($_SESSION['cliente']) ? "'" . $_SESSION['cliente'] . "'" : 'NULL';
        $id_fun = $_SESSION['id_usuario'];
        $sql = "INSERT INTO venda (id_funcionario, id_cliente, data_venda) 
            VALUES ('$id_fun',$id_cliente,'$date')";
        $res = $conn->query($sql);
        if ($res == true) {
            $_SESSION['id_venda'] = $conn->insert_id;
        } else {
            print "<script>alert('Nao foi possivel realizar a venda');</script>";
            print "<script>location.href='venda?page=cliente'</script>";
        }
    }

    if (!isset($_SESSION['produtos'])) $_SESSION['produtos'] = [];

    if (!isset($_SESSION['id_venda_old']) || $_SESSION['id_venda_old'] == 0) {
        $_SESSION['id_venda_old'] = $_SESSION['id_venda'];
    }

    if ($_SESSION['id_venda'] != $_SESSION['id_venda_old']) {
        $_SESSION['produtos'] = [];
        $_SESSION['id_venda_old'] = $_SESSION['id_venda'];
    }

    if (isset($_POST['id_produto']) && isset($_POST['qtd_produto'])) {
        $id_produto = $_POST['id_produto'];
        $qtd_produto = $_POST['qtd_produto'];
        if ($id_produto > 0 && $qtd_produto >= 1) {
            $sql = "SELECT * FROM produtos WHERE id_produtos = $id_produto";
            $res = $conn->query($sql);
            $row = $res->fetch_object();
            if ($row) {
                $value = [];
                $value['id'] = $row->id_produtos;
                $value['nome'] = $row->nome_produto;
                $value['quantidade'] = $qtd_produto;
                $value['valor'] = $row->preco_produto * $qtd_produto;

                $produtos_repetidos = array_filter($_SESSION['produtos'], function($v, $k) { 
                    return $v['id'] == $_POST['id_produto'];
                }, ARRAY_FILTER_USE_BOTH);

                if (count($produtos_repetidos) > 0) {
                    $temp = $_SESSION['produtos'][array_keys($produtos_repetidos)[0]];
                    $temp['quantidade'] += $qtd_produto;
                    $temp['valor'] = $temp['quantidade'] * $row->preco_produto;
                    $_SESSION['produtos'][array_keys($produtos_repetidos)[0]] = $temp;
                } else {
                    array_push($_SESSION['produtos'], $value);
                }
            }
        } else {
            print "<script>alert('Entradas inválidas! Confira e tente novamente.');</script>";
        }

        unset($_POST['id_produto']);
        unset($_POST['qtd_produto']);
    }

    if (isset($_REQUEST['delete_id']) && $_REQUEST['delete_id'] > 0) {
        $_SESSION['produtos'] = array_filter($_SESSION['produtos'], function ($v, $k) {
            return $v['id'] != $_REQUEST['delete_id'];
        }, ARRAY_FILTER_USE_BOTH);
        print "<script>location.href='venda?page=produtos'</script>";
    }
?>
<div class="d-flex flex-column">
    <h1 class="mx-auto">Nova Venda</h1>
    <form action="" method="POST" class="d-flex w-100 mb-3 mt-5">
        <div class="d-flex ms-auto">
            <label for="id_produto" class="me-2 my-auto w-auto">Id do Produto:</label>
            <input id="id_produto" type="number" name="id_produto" class="form-control" min="1" required>
        </div>
        <div class="d-flex ms-3">
            <label for="qtd_produto" class="me-2 my-auto w-auto">Quantiade:</label>
            <input id="qtd_produto" type="number" name="qtd_produto" class="form-control" min="1" required>
        </div>
        <div class="d-flex me-auto">
            <div class="d-flex">
                <button type="submit" class="d-flex btn btn-primary ms-3">
                    <span class="icon plus m-auto"></span>
                </button>
            </div>            
        </div>        
    </form>
    <?php
        print "<table class=\"table table-hover table-striped table-bordered\">" ;
        print "<tr>"; 
        print "<th>ID DO PRODUTO</th>";
        print "<th>NOME</th>";
        print "<th>QUANTIDADE</th>";
        print "<th>VALOR</th>";
        print "<th>ACÕES</th>";
        print "</tr>";
        if (count($_SESSION['produtos']) == 0) {
            print "<tr>";
            print "<td class=\"text-center text-danger\" colspan=\"5\">Nenhum produto adicionado</td>";
            print "</tr>"; 
        } else {
            foreach ($_SESSION['produtos'] as $row) {
                print "<tr>"; 
                print "<form action=\"venda/?page=produtos&delete_id=" . $row['id'] . "\" method=\"POST\">";
                print "<td>" . $row['id'] . "</td>";
                print "<td>" . $row['nome'] . "</td>";
                print "<td>" . $row['quantidade'] . "</td>";
                print "<td>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>";
                print "<td>
                <button type=\"submit\" class=\"btn btn-danger\">Excluir</button>
                </td>";
                print "</form>";
                print "</tr>"; 
            }
        }
        print "</table>";
    ?>
    <form action="venda/?page=novo" method="POST" class="d-flex w-100">
        <button type="submit" class="btn btn-success ms-auto">Concluir venda</button>
    </form>
</div>