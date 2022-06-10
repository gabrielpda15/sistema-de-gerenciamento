<?php
    if (isset($_POST["id"]) && $_POST["id"] > 0) {
        $row = new class{};
        $row->id_funcionario = $_POST["id"];
        $row->nome_funcionario = $_POST["nome"];
        $row->usuario = $_POST["usuario"];
        $row->adm = $_POST["admin"];
        $senha = md5($_POST["senha"]);
        
        $sql = "UPDATE funcionario SET 
            nome_funcionario='$row->nome_funcionario', 
            usuario='$row->usuario', 
            adm='$row->adm'" .
            (strlen($_POST["senha"]) == 0 ? " " : ",senha='$senha' ") .
            "WHERE id_funcionario=" . $_POST['id'];

        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Editado com sucesso');</script>";
            print "<script>location.href='?page=listar'</script>";
        } else {
            print "<script>alert('Nao foi possivel editar');</script>";
            print "<script>location.href='?page=listar'</script>";
        }
    } else {
        $sql = "SELECT * FROM funcionario WHERE id_funcionario=" . $_REQUEST["id"];
        $res = $conn->query($sql);
        $row = $res->fetch_object();
    }
?>
<div class="d-flex flex-column">
    <h1 class="mx-auto">Editar funcionário</h1>
    <form action="" method="POST" class="d-flex flex-column px-5 mx-auto w-50">
        <input id="id" type="hidden" name="id" value="<?php print $row->id_funcionario; ?>">
        <div class="d-flex flex-column mt-5">
            <label>Nome do funcionário</label>
            <input id="nome" type="text" name="nome" value="<?php print $row->nome_funcionario; ?>" class="form-control" required />
        </div>
        <div class="d-flex flex-column mt-5">
            <label>Usuário</label>
            <input type="text" name="usuario" value="<?php print $row->usuario; ?>" class="form-control" required />
        </div>
        <div class="d-flex flex-column mt-5">
            <label>Nível de acesso no sistema</label>
            <select id="admin" class="form-select" name="admin">
                <option value="0" <?php print ($row->adm != 1 ? 'selected' : ''); ?>>Usuário</option>
                <option value="1" <?php print ($row->adm == 1 ? 'selected' : ''); ?>>Administrador</option>
            </select>
        </div>
        <div class="d-flex flex-column mt-5">
            <label>Senha</label>
            <input type="password" name="senha" class="form-control">
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