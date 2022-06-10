<div class="d-flex">
    <h1 class="mx-auto">Funcionários cadastrados</h1>
</div>
<button class="btn btn-success ms-auto mb-2"
    type="button"
    onclick="location.href='funcionario?page=novo'">
    Novo
</button>
<?php
    $sql = "SELECT * FROM funcionario";

    $res = $conn->query($sql);

    $qtd = $res->num_rows;

    if($qtd > 0){

        print "<table class='table table-hover
        table-striped table-bordered'>" ;
        print "<tr>"; 
        print "<th>ID</th>";
        print "<th>NOME</th>";
        print "<th>USUARIO</th>";
        print "<th>ADMIN</th>";
        print "<th>AÇÕES</th>";
        print "</tr>"; 
        while($row = $res->fetch_object()){
            print "<tr>"; 
            print "<td>".$row->id_funcionario."</td>";
            print "<td>".$row->nome_funcionario."</td>";
            print "<td>".$row->usuario."</td>";
            print "<td>". ($row->adm == 1 ? "Sim" : "Não") ."</td>";
            print "<td>
            <button onclick=\"location.href='funcionario?page=editar&id=".$row->id_funcionario."';\" class='btn btn-primary'>Editar</button>
            <button onclick=\"if(confirm ('Tem certeza que deseja excluir?')){location.href='funcionario?page=excluir&id=".$row->id_funcionario."';}else{false;}\" class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>"; 
        }
        print"</table>";
    }else{
        print "<p class='alert alert-danger'> Nao foi localizado nenhum resultado!</p> ";
    }
?>