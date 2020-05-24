<?php
include "configs/config.php";
include "configs/funciones.php";

if (!isset($p)){
    $p = "principal";
}else{
    $p = $p;
}
?>
<!DOCTYPE html>

<html>
<head>

    <meta charset="utf-8">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="fontawesome/js/all.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/app.js"></script>

</head>
<body>
    <div class="header">
        <img src="imagenes/logo.png" alt="logo" style="width:750px" aling="center">
    </div>

    <div class="menu">
        <a href="?p=principal">Home</a>
        <a href="?p=Juegos">Juegos</a>
        <a href="?p=ofertas">Ofertas</a>

        <?php
        if(isset($_SESSION['id_cliente'])){
            ?>

        <a href="?p=Carrito">Carrito</a>
        <a href="?p=miscompras">Mis Compras</a>

        <?php
		}else{
			?>


        <a href="?p=login">Iniciar Sesion</a>
        <a href="?p=registro">Registrate</a>
        <?php
        }
        ?>

        <?php

        if(isset($_SESSION['id_cliente'])){
            ?>

            <a class="float-right subir" href="?p=salir">Cerrar sesion</a>
            <a class="float-right subir" href="#"><?=nombre_cliente($_SESSION['id_cliente'])?></a>

            <?php
        }
        ?>
    </div>

    <div class="cuerpo">
        <?php
         if(file_exists("modulos/" .$p.".php")){
             include  "modulos/".$p.".php";
         }else {
             echo "<i> No se ha encontrado el modulo <b>" . $p . "</b> <a href=´./´>Regresar</a></i>";
         }
        ?>
    </div>


    <div class="footer">
        @Copyright Jose Manuel Rebolledo Rivera <?=date("Y")?><br><br>
        <ul>
            <li>
                <a href="https://es-es.facebook.com/" target=_bank>
                    <figure>
                        <img src="imagenes/facebook.png">
                    </figure>
                </a>
            </li>
            <li>
                <a href="https://github.com/joserivera93" target=_bank>
                    <figure>
                        <img src="imagenes/github.png">
                    </figure>
                </a>
            </li>
            <li>
                <a href="http://www.linkedin.com/in/jose-manuel-rebolledo-rivera-1564a4159" target=_bank>
                    <figure>
                        <img src="imagenes/linkedin.png">
                    </figure>
                </a>
            </li>
        </ul>
    </div>
</body>


</html>