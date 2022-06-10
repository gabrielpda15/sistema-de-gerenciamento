<div class="d-flex">
    <h1 class="mx-auto">Vendas Realizadas</h1>
</div>
<button class="btn btn-success ms-auto mb-2"
    type="button"
    onclick="location.href='venda?page=cliente'">
    Novo
</button>

<?php
    $sql = "SELECT V.id_venda, V.data_venda, F.nome_funcionario, C.nome_cliente
    FROM venda V
    INNER JOIN 
    funcionario F
    ON V.id_funcionario = F.id_funcionario
    LEFT JOIN 
    cliente C
    ON V.id_cliente = C.id_cliente";

    $res = $conn->query($sql);

    $qtd = $res->num_rows;

    if($qtd > 0){ 

        print "<table class='table table-hover
        table-striped table-bordered'>" ;
        print "<tr>"; 
        print "<th>NÚMERO DA VENDA</th>";
        print "<th>NOME DO FUNCIONÁRIO</th>";
        print "<th>NOME DO CLIENTE</th>";
        print "<th>DATA DA VENDA</th>";
        print "<th>ACOES</th>";
        print "</tr>"; 
        while($row = $res->fetch_object()){
            print "<tr>"; 
            print "<td>".$row->id_venda."</td>";
            print "<td>".$row->nome_funcionario."</td>";
            print "<td>".($row->nome_cliente == '' ? '<i>Nenhum</i>' : $row->nome_cliente)."</td>";
            print "<td>".$row->data_venda."</td>";
            print "<td>
            <button onclick=\"if(confirm ('Tem certeza que deseja cancelar?')){location.href='venda?page=excluir&id=".$row->id_venda."';}else{false;}\" class='btn btn-danger'>Cancelar</button>
            </td>";
            print "</tr>"; 
        }
        print"</table>";
    }else{
        print "<p class='alert alert-danger'> Nao foi localizado nenhum resultado!</p> ";
    }
?>