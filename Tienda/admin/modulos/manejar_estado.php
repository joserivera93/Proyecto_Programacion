<?php
check_admin();

$id = clear($id);
$s = $mysqli->query("SELECT * FROM compra WHERE id = '$id'");
$r = mysqli_fetch_array($s);


if(isset($modificar)){

    $estado = clear($estado);

    $mysqli->query("UPDATE compra SET estado = '$estado' WHERE id = '$id'");
    redir("?p=manejar_seguimiento");

}
?>

<h1>Manejar Estado</h1>
<br>
<form method="post" action="">
    <div class="form-group">
        <select class="form-control" name="estado">
            <option <?php if($r['Estado'] == 0) { echo "selected"; } ?> value="0">Iniciando</option>
            <option <?php if($r['Estado'] == 1) { echo "selected"; } ?> value="1">Preparando</option>
            <option <?php if($r['Estado'] == 2) { echo "selected"; } ?> value="2">Entregado</option>
            <option <?php if($r['Estado'] == 3) { echo "selected"; } ?> value="3">Finalizado</option>
        </select>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="Set Status" name="modificar"/>
    </div>
</form>