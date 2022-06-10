<?php
    if (isset($_POST["nome"]) && strlen($_POST["nome"]) > 0 &&
        isset($_POST["categoria"]) && strlen($_POST["categoria"]) > 0 &&
        isset($_POST["preco"]) && strlen($_POST["preco"]) > 0) {

        $nome = $_POST["nome"];
        $categoria = $_POST["categoria"];
        $preco = floatval(str_replace(",", ".", $_POST["preco"]));

        $sql = "INSERT INTO produtos (nome_produto, categoria_produto, preco_produto) VALUES ('{$nome}','{$categoria}', '{$preco}')";

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Cadastrado com sucesso');</script>";
            print "<script>location.href='produto'</script>";
        } else {
            print "<script>alert('Nao foi possivel realizar o cadastro');</script>";
            print "<script>location.href='produto'</script>";
        }

    }
?>
<div class="d-flex flex-column">
    <h1 class="mx-auto">Novo produto</h1>
    <form action="" method="POST" class="d-flex flex-column px-5 mx-auto w-50">
        <div class="d-flex flex-column mt-5">
            <label>Nome do produto</label>
            <input id="nome" type="text" name="nome" class="form-control" required />
        </div>
        <div class="d-flex flex-column mt-5">
            <label>Categoria</label>
            <input type="text" name="categoria" class="form-control" required />
        </div>
        <div class="d-flex flex-column mt-5">
            <label>Valor do Produto</label>
            <input type="text" name="preco" class="form-control money" required />
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