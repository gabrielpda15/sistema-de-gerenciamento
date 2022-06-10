<div class="d-flex">
    <h1 class="mx-auto">Clientes cadastrados</h1>
</div>
<button class="btn btn-success ms-auto mb-2"
    type="button"
    onclick="location.href='cliente?page=novo'">
    Novo
</button>
<?php
    $sql = "SELECT * FROM cliente";

    $res = $conn->query($sql);

    $qtd = $res->num_rows;

    if($qtd > 0){

        print "<table class='table table-hover
        table-striped table-bordered'>" ;
        print "<tr>"; 
        print "<th>ID</th>";
        print "<th>NOME</th>";
        print "<th>CPF</th>";
        print "<th>TELEFONE</th>";
        print "<th>AÇÕES</th>";
        print "</tr>"; 
        while($row = $res->fetch_object()){
            print "<tr>"; 
            print "<td>".$row->id_cliente."</td>";
            print "<td>".$row->nome_cliente."</td>";
            print "<td>".$row->cpf_cliente."</td>";
            print "<td>".$row->telefonecliente."</td>";
            print "<td>
            <button onclick=\"if(confirm ('Tem certeza que deseja excluir?')){location.href='cliente?page=excluir&id=".$row->id_cliente."';}else{false;}\" class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>"; 
        }
        print"</table>";
    }else{
        print "<p class='alert alert-danger'> Nao foi localizado nenhum resultado!</p> ";
    }
?>