<?php
    $sql = "SELECT nome_produto FROM produtos WHERE id_produtos=" . $_REQUEST["id"];
    $res = $conn->query($sql);
    $row = $res->fetch_object();
?>
<div class="d-flex">
    <h1 class="mx-auto">Entradas cadastradas</h1>
</div>
<div class="d-flex">
    <div class="d-flex my-auto ms-3">
        <p class="me-2">Id: </p>
        <p class="me-5"><?php print $_REQUEST['id']; ?></p>
        <p class="me-2">Nome: </p>
        <p><?php print $row->nome_produto; ?></p>
    </div>
    <button class="btn btn-success ms-auto mb-2 my-auto"
        type="button"
        onclick="location.href='entrada?page=novo&id=<?php print $_REQUEST['id']; ?>'">
        Novo
    </button>
</div>

<?php
    $sql = "SELECT * FROM entrada_produtos 
        WHERE id_produto = " . $_REQUEST['id'] .
        " ORDER BY data_entrada DESC";

    $res = $conn->query($sql);

    $qtd = $res->num_rows;

    if($qtd > 0){

        print "<table class='table table-hover
        table-striped table-bordered'>" ;
        print "<tr>"; 
        print "<th>ID ENTRADA</th>";
        print "<th>QUANTIDADE</th>";
        print "<th>VALOR DE ENTRADA</th>";
        print "<th>DATA DE ENTRADA</th>";
        print "<th>AÇÕES</th>";
        print "</tr>"; 
        while($row = $res->fetch_object()){
            print "<tr>"; 
            print "<td>".$row->id_entrada."</td>";
            print "<td>".$row->quantidade_entrada."</td>";
            print "<td>R$ ".str_replace('.', ',', number_format($row->valor_entrada, 2))."</td>";
            print "<td>".$row->data_entrada."</td>";
            print "<td>
            <button onclick=\"if(confirm ('Tem certeza que deseja excluir?')){location.href='entrada?page=excluir&id=".$row->id_entrada."';}else{false;}\" class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>"; 
        }
        print"</table>";
    }else{
        print "<p class='alert alert-danger'> Nao foi localizado nenhum resultado!</p> ";
    }
?>