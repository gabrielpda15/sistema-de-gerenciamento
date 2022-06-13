<?php
require 'config.php';

session_start();

$erro_login = "style=\"display: none;\"";

if (isset($_SESSION['usuario']) && strlen($_SESSION['usuario']) > 0) {
    header('Location: home.php');
}

if (isset($_POST['usuario']) && isset($_POST['senha'])) {
    if (strlen($_POST['usuario']) == 0) {
        echo 'Preencha o usuário';
        return;
    }

    if (strlen($_POST['senha']) == 0) {
        echo 'Preencha a senha';
        return;
    }

    $usuario = $conn->real_escape_string($_POST['usuario']);
    $senha = $conn->real_escape_string($_POST['senha']);
    $senha_hash = md5($_POST["senha"]);

    $sql_code = "SELECT * FROM funcionario WHERE usuario= '$usuario' AND senha='$senha_hash'";
    ($sql_query = $conn->query($sql_code)) or
        die('Falha na execução no banco de dados');

    $quantidade = $sql_query->num_rows;

    if ($quantidade == 1) {
        $rusuario = $sql_query->fetch_assoc();

        $_SESSION['usuario'] = $rusuario['usuario'];
        $_SESSION['id_usuario'] = $rusuario['id_funcionario'];
        $_SESSION['admin'] = $rusuario['adm'];

        header('Location: home.php');
    } else {
        $erro_login = "style=\"display: block;\"";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <base href="/">
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="css/style.css" />

        <title>Sistema de Gerenciamento - Login</title>
    </head>
    <body>
        <div class="d-flex flex-column w-100 h-100 p-5">
            <div class="m-auto">
                <div class="d-flex mb-5">
                    <h1 class="mx-auto">Tela de Acesso</h1>
                </div>
                <div class="d-flex flex-column">
                    <form action="" method="POST">
                        <div class="form-group my-1">
                            <label for="usuario">Usuário</label>
                            <input id="usuario" type="text" class="form-control" name="usuario" required>
                        </div>
                        <div class="form-group my-1">
                            <label for="senha">Senha</label>
                            <input id="senha" type="password" class="form-control" name="senha" required>
                        </div>
                        <div class="my-4 mx-auto" <?php print $erro_login; ?>>
                            <p class="text-danger">Falha ao logar! E-mail ou senha incorretos!</p>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary d-flex ms-auto">
                                <span class="icon login my-auto me-2"></span>
                                Entrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>            
        </div>

        <script src="js/jquery.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
    </body>
</html>