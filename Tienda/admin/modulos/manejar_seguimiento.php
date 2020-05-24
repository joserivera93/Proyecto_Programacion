<?php
check_admin();



$s = $mysqli->query("SELECT * FROM compra WHERE Estado != 3");

if(isset($eliminar)){
    $eliminar = clear($eliminar);

    $mysqli->query("DELETE FROM productos_compra WHERE id_compra = '$eliminar'");

    $mysqli->query("DELETE FROM compra WHERE id = '$eliminar'");
    redir("?p=manejar_seguimiento");

}


?>


<h1>Seguimientos</h1><br><br>


<table class="table table-stripe">
    <tr>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    <?php

    while($r=mysqli_fetch_array($s)){

        $sc = $mysqli->query("SELECT * FROM clientes WHERE id = '".$r['id_cliente']."'");
        $rc = mysqli_fetch_array($sc);
        $cliente = $rc['name'];


        if($r['Estado'] == 0){
            $status = "Iniciando";
        }elseif($r['Estado']==1){
            $status = "Preparando";
        }elseif($r['Estado'] == 2){
            $status = "Entregado";
        }elseif($r['Estado'] == 3){
            $status = "Finalizado";
        }else{
            $status = "Indefinido";
        }

        $fecha = fecha($r['fecha']);


        ?>

        <tr>
            <td><?=$cliente?></td>
            <td><?=$fecha?></td>
            <td><?=$r['Total']?> <?=$divisa?></td>
            <td><?=$status?></td>
            <td>
                <a  style="color:#08f" href="?p=manejar_seguimiento&eliminar=<?=$r['id']?>">
                    <i class="fa fa-times"></i>
                </a>
                &nbsp; &nbsp;
                <a  style="color:#08f" href="?p=manejar_estado&id=<?=$r['id']?>">
                    <i class="fa fa-edit"></i>
                </a>
                &nbsp; &nbsp;
                <a  style="color:#08f" href="?p=ver_compra&id=<?=$r['id']?>">
                    <i class="fa fa-eye"></i>
                </a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>