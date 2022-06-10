<?php
    if (isset($_POST["nome_cliente"]) && strlen($_POST["nome_cliente"]) > 0 &&
        isset($_POST["cpf_cliente"]) && strlen($_POST["cpf_cliente"]) > 0 &&
        isset($_POST["telefone_cliente"]) && strlen($_POST["telefone_cliente"]) > 0) {

        $nome = $_POST["nome_cliente"];
        $cpf = $_POST["cpf_cliente"];
        $telefone = $_POST["telefone_cliente"];

        $sql = "INSERT INTO cliente (nome_cliente, cpf_cliente, telefonecliente) VALUES ('{$nome}','{$cpf}', '{$telefone}')";

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Cadastrado com sucesso');</script>";
            print "<script>location.href='/cliente'</script>";
        } else {
            print "<script>alert('Nao foi possivel realizar o cadastro');</script>";
            print "<script>location.href='/cliente'</script>";
        }

    }
?>
<div class="d-flex flex-column">
    <h1 class="mx-auto">Novo cliente</h1>
    <form action="" method="POST" class="d-flex flex-column px-5 mx-auto w-50">
        <div class="d-flex flex-column mt-5">
            <label>Nome do Cliente</label>
            <input id="nome_cliente" type="text" name="nome_cliente" class="form-control" required>
        </div>
        <div class="d-flex flex-column mt-3">
            <label>CPF do cliente</label>
            <input id="cpf_cliente" type="text" name="cpf_cliente" class="form-control cpf" maxlength="14" required>
        </div>
        <div class="d-flex flex-column mt-3">
            <label>Telefone do cliente</label>
            <input id="telefone_cliente" type="text" name="telefone_cliente" class="form-control phone" maxlength="15" required>
        </div>
        <div class="d-flex mt-3 pt-4">
            <div class="d-flex w-100">
                <button type="submit" class="d-flex btn btn-primary ms-auto">
                    Criar
                </button>
            </div>            
        </div>        
    </form>
</div>