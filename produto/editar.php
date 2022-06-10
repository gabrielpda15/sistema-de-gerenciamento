<?php
    if (isset($_POST["id"]) && $_POST["id"] > 0) {
        $row = new class{};
        $row->id_produtos = $_POST["id"];
        $row->nome_produto = $_POST["nome"];
        $row->categoria_produto = $_POST["categoria"];
        $row->preco_produto = $_POST["preco"];
        $preco = floatval(str_replace(",", ".", $_POST["preco"]));
        
        $sql = "UPDATE produtos SET 
            nome_produto='$row->nome_produto', 
            categoria_produto='$row->categoria_produto', 
            preco_produto='$preco'
            WHERE id_produtos=" . $_POST['id'];

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Editado com sucesso');</script>";
            print "<script>location.href='produto'</script>";
        } else {
            print "<script>alert('Nao foi possivel editar');</script>";
            print "<script>location.href='produto'</script>";
        }
    } else {
        $sql = "SELECT * FROM produtos WHERE id_produtos=" . $_REQUEST["id"];
        $res = $conn->query($sql);
        $row = $res->fetch_object();
        $row->preco_produto = str_replace('.', ',', number_format($row->preco_produto, 2));
    }    
?>
<div class="d-flex flex-column">
    <h1 class="mx-auto">Editar produto</h1>
    <form action="" method="POST" class="d-flex flex-column px-5 mx-auto w-50">
        <input id="id" type="hidden" name="id" value="<?php print $row->id_produtos; ?>">
        <div class="d-flex flex-column mt-5">
            <label>Nome do produto</label>
            <input id="nome" type="text" name="nome" class="form-control" value="<?php print $row->nome_produto; ?>" required />
        </div>
        <div class="d-flex flex-column mt-5">
            <label>Categoria</label>
            <input type="text" name="categoria" class="form-control" value="<?php print $row->categoria_produto; ?>" required />
        </div>
        <div class="d-flex flex-column mt-5">
            <label>Valor do Produto</label>
            <input type="text" name="preco" class="form-control money" value="<?php print $row->preco_produto; ?>" required />
        </div>
        <div class="d-flex mt-5 pt-4">
            <div class="d-flex w-100">
                <button type="submit" class="d-flex btn btn-primary ms-auto">
                    Salvar
                </button>
            </div>            
        </div>        
    </form>
</div>