<?php
    $_SESSION['id_venda'] = -1;
?>
<div class="d-flex flex-column">
    <h1 class="mx-auto">Nova Venda</h1>
    <form action="" method="POST" class="d-flex px-5 mx-auto">
        <div class="d-flex flex-column mt-5">
            <label for="cpf" class="ms-2">CPF</label>
            <input id="cpf" type="text" name="cpf" class="form-control cpf" maxlength="14" require>
        </div>
        <div class="d-flex mt-5 pt-4">
            <div class="d-flex">
                <button type="submit" class="d-flex btn btn-secondary ms-3">
                    <span class="icon search m-auto"></span>
                </button>
                <a class="d-flex btn btn-primary ms-2" href="venda?page=produtos">
                    <span class="icon login m-auto"></span>
                </a>
            </div>
            
        </div>        
    </form>
    <?php
        require '../config.php';
        if (isset($_POST['cpf'])) {
            $cpf = $conn->real_escape_string($_POST['cpf']);
            $sql = "SELECT * FROM cliente WHERE cpf_cliente= '$cpf'";
            ($sql_query = $conn->query($sql)) or die('Falha na execução no banco de dados');
            $quantidade = $sql_query->num_rows;
            if ($quantidade == 1) {
                $cliente = $sql_query->fetch_assoc();
                $_SESSION['cliente'] = $cliente['id_cliente'];
                echo '<p class="alert alert-success mx-auto mt-5">Cliente ' . $cliente['nome_cliente'] . ' encontrado!</p>';
            } else {
                echo '<p class="alert alert-danger mx-auto mt-5">Nenhum cliente encontrado com esse CPF!</p>';
            }
        }
    ?>
</div>