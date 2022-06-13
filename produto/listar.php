<div class="d-flex">
    <h1 class="mx-auto">Produtos cadastrados</h1>
</div>
<button class="btn btn-success ms-auto mb-2"
    type="button"
    onclick="location.href='produto?page=novo'">
    Novo
</button>
<?php
    $sql = "SELECT * FROM produtos";

    $res = $conn->query($sql);

    $qtd = $res->num_rows;

    if($qtd > 0){

        print "<table class='table table-hover
        table-striped table-bordered'>" ;
        print "<tr>"; 
        print "<th>ID DO PRODUTO</th>";
        print "<th>NOME DO PRODUTO</th>";
        print "<th>CATEGORIA</th>";
        print "<th>PREÇO</th>";
        if ($_SESSION['admin'] == 1) {
            print "<th>AÇÕES</th>";
        }
        print "</tr>"; 
        while($row = $res->fetch_object()){
            print "<tr>"; 
            print "<td>".$row->id_produtos."</td>";
            print "<td>".$row->nome_produto."</td>";
            print "<td>".$row->categoria_produto."</td>";
            print "<td>R$ ".number_format($row->preco_produto, 2, ',', '.')."</td>";
            if ($_SESSION['admin'] == 1) {
                print "<td>";
                print "<button onclick=\"location.href='produto?page=editar&id=".$row->id_produtos."';\" class='btn btn-primary me-2'>Editar</button>";
                print "<button onclick=\"location.href='entrada?id=".$row->id_produtos."';\" class='btn btn-secondary me-2'>Estoque</button>";
                print "<button onclick=\"if(confirm ('Tem certeza que deseja excluir?')){location.href='produto?page=excluir&id=".$row->id_produtos."';}else{false;}\" class='btn btn-danger'>Excluir</button>";
                print "</td>";
            }            
            print "</tr>"; 
        }
        print"</table>";
    }else{
        print "<p class='alert alert-danger'> Nao foi localizado nenhum resultado!</p> ";
    }
?>