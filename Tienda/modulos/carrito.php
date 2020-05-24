<?php
check_user('carrito');


if(isset($eliminar)){
    $eliminar = clear($eliminar);
    $mysqli->query("DELETE FROM carro WHERE id = '$eliminar'");
    redir("?p=carrito");
}

if(isset($id) && isset($modificar)) {

    $id = clear($id);
    $modificar = clear($modificar);

    $mysqli->query("UPDATE carro SET cant = '$modificar' WHERE id = '$id'");
    alert("Cantidad modificada");
    redir("?p=carrito");
}

if(isset($finalizar)){


    $total = clear($total_total);
    $id_cliente = clear($_SESSION['id_cliente']);


    $q = $mysqli->query("INSERT INTO compra (id_cliente,fecha,total,estado) VALUES ('$id_cliente',NOW(),'$total',0)");


    $sc = $mysqli->query("SELECT * FROM compra WHERE id_cliente = '$id_cliente' ORDER BY id DESC LIMIT 1");
    $rc = mysqli_fetch_array($sc);

    $ultima_compra = $rc['id'];


    $q2 = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente'");
    while($r2=mysqli_fetch_array($q2)) {

        $sp = $mysqli->query("SELECT * FROM productos WHERE id = '" . $r2['id_producto'] . "'");
        $rp = mysqli_fetch_array($sp);

        $total_total = $rp['price'];

        $mysqli->query("INSERT INTO producto_compra (id_compra,id_producto,cantidad,total) VALUES ('$ultima_compra','" . $r2['id_producto'] . "','" . $r2['cant'] . "','$total_total')");
    }

    $mysqli->query("DELETE FROM carro WHERE id_cliente = '$id_cliente'");
    alert("Se ha finalizado la compra");
    redir("?p=pagar_compra");//./
}

?>

<h1><i class="fa fa-shopping-cart"></i> Carro de Compras</h1>
<br><br>

<table class="table table-striped">
    <tr>
        <th><i class="fa fa-image"></i></th>
        <th>Nombre del producto</th>
        <th>Cantidad</th>
        <th>Precio por unidad</th>
        <th>Oferta</th>
        <th>Precio Total</th>
        <th>Precio Neto</th>
        <th>Action</th>
    </tr>
<?php
    $id_cliente = clear($_SESSION['id_cliente']);
    $q = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente'");
    $total_total =0;
while($r = mysqli_fetch_array($q)){
    $q2 = $mysqli->query("SELECT * FROM productos WHERE id = '".$r['id_producto']."'");
    $r2 = mysqli_fetch_array($q2);


    $preciofinal = 0;

    if ($r2['oferta']>0) {
        if (strlen($r2['oferta']) == 1) {
            $desc = "0.0".$r2['oferta'];
        }else{
            $desc = "0." . $r2['oferta'];
        }
        $preciofinal = $r2['price'] - ($r2['price'] * $desc);
    }else{
        $preciofinal = $r2['price'];
    }

    $nombre_juego = $r2['name'];

    $cantidad = $r['cant'];

    $precio_unidad = $r2['price'];
    $precio_total =  $cantidad * $preciofinal;
    $imagen_producto = $r2['imagen'];
    $total_total = $total_total + $precio_total;


        ?>

    <tr>
        <td><img src="productos/<?=$imagen_producto?>" class="imagen_carro"/></td>
        <td><?=$nombre_juego?></td>
        <td><?=$cantidad?></td>
        <td><?=$precio_unidad?> <?=$divisa?></td>
        <td><?=$precio_total?> <?=$divisa?></td>
        //comprueba si el producto tiene oferta o no
        <td>
            <?php
                if ($r2['oferta']>0) {
                    echo $r2['oferta'] . "% de Descuento";
                }else{
                    echo "Sin descuento";
                }
            ?>
        </td>
        <td><?=$precio_total?> <?=$divisa?></td>

        <td>
            <a onclick="modificar('<?=$r['id']?>')" href="#"><i class="fa fa-edit" title="Modificar cantidad"></i></a>
            <a href="?p=carrito&eliminar=<?=$r['id']?>"><i class="fa fa-times" title="Eliminar"></i></a>
        </td>
    </tr>
    <?php
}
?>
</table>
<br>

<h2>Total a Pagar: <b class="text-green"><?=$total_total?> <?=$divisa?></b></h2>
<br><br>

<form method="post" action="">
    <input type="hidden" name="total_total" value="<?=$total_total?>">
    <button class="btn-primary" type="submit" name="finalizar"><i class="fa fa-check"></i> Finalizar Pedido </button>
</form>


<script type="text/javascript">

    function modificar(idc){
        var new_cant = prompt("¿Cual es la nueva cantidad?");

        if(new_cant>0){

            window.location="?p=carrito&id="+idc+"&modificar="+new_cant;

        }

    }

</script>