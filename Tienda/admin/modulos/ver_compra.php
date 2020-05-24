<?php
check_admin();
$id = clear($id);

$s = $mysqli->query("SELECT * FROM compra WHERE id = '$id'");
$r = mysqli_fetch_array($s);

$sc = $mysqli->query("SELECT * FROM clientes WHERE id = '".$r['id_cliente']."'");
$rc = mysqli_fetch_array($sc);

$nombre = $rc['name'];

?>

<h1>Viendo compra <span style="color:#08f"><?=$nombre?></span></h1><br>


Fecha: <?=fecha($r['fecha'])?><br>
Total: <?=number_format($r['Total'])?> <?=$divisa?><br>
Estado: <?=estado($r['Estado'])?><br>
<br>


    <table class="table table-striped">
    <tr>
        <th>Nombre del producto</th>
        <th>Cantidad</th>
        <th>Total</th>
        <th>Total al Pagar</th>
    </tr>
<?php


$sp = $mysqli->query("SELECT * FROM producto_compra WHERE id_compra = '$id'");
while($rp=mysqli_fetch_array($sp)){

    $spro = $mysqli->query("SELECT * FROM productos WHERE id = '".$rp['id_producto']."'");
    $rpro = mysqli_fetch_array($spro);

    $nombre_producto = $rpro['name'];

    $totaltotal = $rp['Total'] * $rp['cantidad'];
    ?>

    <tr>
        <td><?=$nombre_producto?></td>
        <td><?=$rp['cantidad']?></td>
        <td><?=$rp['Total']?></td>
        <td><?=$totaltotal?></td>
    </tr>
    <?php
}
?>
</table>
