<?php
    if (isset($_REQUEST["id"]) && $_REQUEST["id"] > 0) {
        $sql = "DELETE FROM entrada_produtos WHERE id_entrada =" . $_REQUEST["id"];
        $res = $conn->query($sql);

        if ($res == true) {
            print "<script>alert('Excluido com sucesso');</script>";
            print "<script>location.href='/entrada?id=".$_REQUEST["id"]."'</script>";
        } else {
            print "<script>alert('Nao foi possivel excluir');</script>";
            print "<script>location.href='/entrada?id=".$_REQUEST["id"]."'</script>";
        }
    } else {
        print "<script>alert('Nao foi possivel excluir');</script>";
        print "<script>location.href='/entrada?id=".$_REQUEST["id"]."'</script>";
    }
?>