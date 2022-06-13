<?php
    if (!isset($title)) $title = "";
    if (!isset($selected_menu)) $selected_menu = -1;
    $menu_gerenciamento = $selected_menu >= 0 && $selected_menu <= 3 ? "show" : "";
    $menu_relatorio = $selected_menu >= 4 && $selected_menu <= 5 ? "show" : "";
    $menu_relatorio_admin = $_SESSION['admin'] == 1 ? "" : "style=\"display: none;\"";
?>
<nav class="navbar bg-primary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php" style="color: white">Sistema de Gerenciamento | <?php print $title; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" style="color:rgba(34, 123, 248, 0.8)">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header" style="background-color: blue;">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel" style="color:aliceblue">Tela de Gerenciamento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item dropdown">
                        <a id="gerenciamento-dropdown" class="nav-link dropdown-toggle text-dark" href="#" 
                            role="button" data-bs-toggle="dropdown" data-bs-auto-close="false">
                            Gerenciamento
                        </a>
                        <ul class="dropdown-menu <?php print $menu_gerenciamento; ?>" aria-labelledby="gerenciamento-dropdown">
                            <li><a class="dropdown-item<?php if ($selected_menu == 0) print " active"; ?>" href="venda">
                                Gerenciamento de Venda
                            </a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item<?php if ($selected_menu == 1) print " active"; ?>" href="cliente">
                                Gerenciamento de Cliente
                            </a></li>
                            <?php
                                if ($_SESSION['admin'] == 1) {
                                    print "<hr class=\"dropdown-divider\">";
                                    if ($selected_menu == 2) {
                                        print "<li><a class=\"dropdown-item active\" href=\"funcionario\">";
                                    } else {
                                        print "<li><a class=\"dropdown-item\" href=\"funcionario\">";
                                    }
                                    print "Gerenciamento de Funcionário";
                                    print "</a></li>";
                                }
                            ?>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item<?php if ($selected_menu == 3) print " active"; ?>" href="produto">
                                Gerenciamento de Produto
                            </a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" <?php print $menu_relatorio_admin ?>>
                    <li class="nav-item dropdown">
                        <a id="relatorio-dropdown" class="nav-link dropdown-toggle text-dark" href="#" role="button"
                            data-bs-toggle="dropdown" data-bs-auto-close="false">
                            Relatorios
                        </a>
                        <ul class="dropdown-menu <?php print $menu_relatorio; ?>" aria-labelledby="relatorio-dropdown">
                            <li><a class="dropdown-item <?php if ($selected_menu == 4) print " active"; ?>" href="#">
                                Relatorio de Vendas
                            </a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item <?php if ($selected_menu == 5) print " active"; ?>" href="#">
                                Relatorio de Entradas
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="d-flex mb-3 me-3">
                <a href="logout.php" class="btn btn-danger d-flex ms-auto" style="width: 80px;">
                    <span class="icon logout me-2 my-auto"></span>
                    Sair
                </a>
            </div>
        </div>
    </div>
</nav>