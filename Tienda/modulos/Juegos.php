<?php
check_user("Juegos");



if(isset($cat)){
    $sc = $mysqli->query("SELECT * FROM categorias WHERE id = '$cat'");
    $rc = mysqli_fetch_array($sc);
    ?>

    <h1>Categoria Filtrada por: <?=$rc['categoria']?></h1>
    <?php
}

if(isset($agregar) && isset($cant)){

    $idp = clear($agregar);
    $cant = clear($cant);
    $id_cliente = clear($_SESSION['id_cliente']);

    $v = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'");

    if(mysqli_num_rows($v)>0){

        $q = $mysqli->query("UPDATE carro SET cant = cant + $cant WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'");

    }else{

        $q = $mysqli->query("INSERT INTO carro (id_cliente,id_producto,cant) VALUES ($id_cliente,$idp,$cant)");

    }

    alert("Se ha agregado al carro de compras",1,'Juegos');

}

if(isset($busq) && isset($cat)){
    $q = $mysqli->query("SELECT * FROM productos WHERE name LIKE '%$busq%' AND id_categoria = '$cat'");
}elseif(isset($cat) && !isset($busq)){
    $q = $mysqli->query("SELECT * FROM productos WHERE id_categoria = '$cat' ORDER BY id DESC");
}elseif(isset($busq) && !isset($cat)){
    $q = $mysqli->query("SELECT * FROM productos WHERE  name LIKE '%$busq%'");
}elseif(!isset($busq) && !isset($cat)){
    $q = $mysqli->query("SELECT * FROM productos ORDER BY id DESC");
}else{
    $q = $mysqli->query("SELECT * FROM productos ORDER BY id DESC");
}
?>

<form method="post" action="">
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <input type="text" class="form-control" name="busq" placeholder="Coloca el nombre del producto"/>
            </div>
        </div>
        <div class="col-md-5">
            <select id="categoria" name="cat" class="form-control">
                <option value="">Seleccione una categoria</option>
                <?php
                $cats = $mysqli->query("SELECT * FROM categorias ORDER BY categoria ASC");
                while($rcat = mysqli_fetch_array($cats)){
                    ?>
                    <option value="<?=$rcat['id']?>"><?=$rcat['categoria']?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary" name="buscar"><i class="fa fa-search"></i> Buscar</button>
        </div>
    </div>
</form>

<?php

while($r=mysqli_fetch_array($q)){
    $preciofinal = 0;
    if($r['oferta']>0){
        if(strlen($r['oferta'])==1){
            $desc = "0.0".$r['oferta'];
        }else{
            $desc = "0.".$r['oferta'];
        }

        $preciofinal = $r['price'] -($r['price'] * $desc);
    }else{
        $preciofinal = $r['price'];
    }
    ?>

    <div class="Juegos">
        <div class="name_Juegos"><?=$r['name']?></div>
        <div><img class="img_Juegos" src="productos/<?=$r['imagen']?>"/></div>
        <?php
        if($r['oferta']>0){
            ?>
            <del><?=$r['price']?> <?=$divisa?></del> <span class="precio"> <?=$preciofinal?> <?=$divisa?> </span>
            <?php
        }else{
            ?>
            <span class="precio"><br><?=$r['price']?> <?=$divisa?></span>
            <?php
        }

        ?>

        <button class="btn btn-dark float-right" onclick="agregar_carro('<?=$r['id']?>');"><i class="fa fa-shopping-cart"></i></button>

    </div>
    <?php
}
?>

<script type="text/javascript">

    function agregar_carro(idp){
        var cant = prompt("¿Que cantidad desea agregar?",1);

        if(cant.length>0){
            window.location="?p=Juegos&agregar="+idp+"&cant="+cant;
        }
    }

</script>