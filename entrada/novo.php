<?php
    $id_produto = $_REQUEST["id"];

    $sql = "SELECT preco_produto FROM produtos WHERE id_produtos=" . $id_produto;
    $res = $conn->query($sql);
    $row = $res->fetch_object();
    $preco_produto = $row->preco_produto;

    if (isset($_POST["quantidade"]) && strlen($_POST["quantidade"]) > 0 &&
        isset($_POST["preco"]) && strlen($_POST["preco"]) > 0) {

        $quantidade = $_POST["quantidade"];
        $preco = floatval(str_replace(",", ".", $_POST["preco"]));
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO entrada_produtos (id_produto, quantidade_entrada, valor_entrada, data_entrada) VALUES ('{$id_produto}','{$quantidade}','{$preco}', '{$date}')";

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Cadastrado com sucesso');</script>";
            print "<script>location.href='entrada?id=".$id_produto."'</script>";
        } else {
            print "<script>alert('Nao foi possivel realizar o cadastro');</script>";
            print "<script>location.href='entrada?id=".$id_produto."'</script>";
        }

    }
?>
<div class="d-flex flex-column">
    <h1 class="mx-auto">Novo produto</h1>
    <form action="" method="POST" class="d-flex flex-column px-5 mx-auto w-50">
        <div class="d-flex flex-column mt-5">
            <label>Quantidade</label>
            <input id="quantidade" type="number" name="quantidade" class="form-control" required min="1"/>
        </div>
        <div class="d-flex flex-column mt-5">
            <label>Valor</label>
            <input id="preco" type="text" name="preco" class="form-control money" required />
        </div>
        <div class="d-flex mt-5 pt-4">
            <div class="d-flex w-100">
                <button type="submit" class="d-flex btn btn-primary ms-auto">
                    Criar
                </button>
            </div>            
        </div>        
    </form>
</div>

<?php
    print "<script>";
    print "function onQuantidadeLostFocus() {";
    print "const quantidade = document.getElementById(\"quantidade\");";
    print "const preco = document.getElementById(\"preco\");";
    print "preco.value = (quantidade.value * $preco_produto).toFixed(2).replace('.', ',')";
    print "}";
    print "document.getElementById(\"quantidade\").addEventListener(\"focusout\", onQuantidadeLostFocus);";
    print "</script>";
?>