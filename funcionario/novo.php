<?php
    if (isset($_POST["nome"]) && strlen($_POST["nome"]) > 0 &&
        isset($_POST["usuario"]) && strlen($_POST["usuario"]) > 0 &&
        isset($_POST["senha"]) && strlen($_POST["senha"]) > 0) {

        $nome = $_POST["nome"];
        $usuario = $_POST["usuario"];
        $adm = $_POST["admin"];
        $senha = md5($_POST["senha"]);

        $sql = "INSERT INTO funcionario (nome_funcionario, usuario, adm ,senha) VALUES ('{$nome}','{$usuario}', '{$adm}', '{$senha}')";

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Cadastrado com sucesso');</script>";
            print "<script>location.href='funcionario'</script>";
        } else {
            print "<script>alert('Nao foi possivel realizar o cadastro');</script>";
            print "<script>location.href='funcionario'</script>";
        }

    }
?>
<div class="d-flex flex-column">
    <h1 class="mx-auto">Novo funcionário</h1>
    <form action="" method="POST" class="d-flex flex-column px-5 mx-auto w-50">
        <div class="d-flex flex-column mt-5">
            <label>Nome do funcionário</label>
            <input id="nome" type="text" name="nome" class="form-control" required />
        </div>
        <div class="d-flex flex-column mt-3">
            <label>Usuário</label>
            <input type="text" name="usuario" class="form-control" required />
        </div>
        <div class="d-flex flex-column mt-3">
            <label>Nível de acesso no sistema</label>
            <select id="admin" class="form-select" name="admin">
                <option value="0" selected>Usuário</option>
                <option value="1">Administrador</option>
            </select>
        </div>
        <div class="d-flex flex-column mt-3">
            <label>Senha</label>
            <input type="password" name="senha" class="form-control" required>
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