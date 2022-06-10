<?php
    if (!isset($_SESSION['produtos']) || count($_SESSION['produtos']) == 0) {
        print "<script>alert('Nenhum produto adicionado ainda!');</script>";
        print "<script>location.href='venda?page=produtos'</script>";
    } else {
        $result = true;
        $conn->begin_transaction();
        foreach ($_SESSION['produtos'] as $produto) {
            $produto_id = $produto['id'];
            $venda_id = $_SESSION['id_venda'];
            $quantidade = $produto['quantidade'];           
            $valor =  $produto['valor'];
            $sql = "INSERT INTO item_venda (produtos_id_produtos, venda_id_venda, quantidade, valor_venda)
                VALUES('{$produto_id}','{$venda_id}', '{$quantidade}', '{$valor}')";
            $res = $conn->query($sql);
            
            if ($res != true) {
                $result = false;
                $conn->rollback();

                print "<script>alert('Nao foi possivel realizar a venda');</script>";
                print "<script>location.href='venda?page=produtos'</script>";
            }
        }

        if ($result == true) {
            $conn->commit();

            unset($_SESSION['produtos']);
            unset($_SESSION['id_venda']);
            unset($_SESSION['id_venda_old']);

            print "<script>alert('Venda realizada com sucesso!');</script>";
            print "<script>location.href='venda'</script>";
        }
    }
?>