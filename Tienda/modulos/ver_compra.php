<?php

check_user('ver_compra');
$id = clear($id);

$s = $mysqli->query("SELECT * FROM compra WHERE id = '$id' AND id_cliente = '".$_SESSION['id_cliente']."'");

if(mysqli_num_rows($s)>0){


$s = $mysqli->query("SELECT * FROM compra WHERE id = '$id'");
$r = mysqli_fetch_array($s);

$sc = $mysqli->query("SELECT * FROM clientes WHERE id = '".$r['id_cliente']."'");
$rc = mysqli_fetch_array($sc);

$nombre = $rc['name'];

?>

<h1>Viendo compra #<span style="color:#08f"><?=$r['id']?></span></h1><br>


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
        <th>Acciones</th>
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

        <td>
            <?php
            if($rpro['descargable']!=""){
                ?>
                <a href="descargable/<?=$rpro['descargable']?>" download><i class="fa fa-download"></i></a>
                <?php
            }else{
                echo "--";
            }
            ?>
        </td>
    </tr>
    <?php
}
?>
</table>

 <?php
}else{
    alert("Ha ocurrido un error");
    redir("?p=miscompras");
}
