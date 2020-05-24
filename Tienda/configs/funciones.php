<?php
//Incluimos el archivo config
include "config.php";

//Establecemos los datos de la basa de datos
$host_mysql = "localhost";
$user_mysql = "root";
$pass_mysql = "";
$db_mysql = "tienda";
$mysqli = mysqli_connect($host_mysql,$user_mysql,$pass_mysql,$db_mysql);


function clear($var){
    htmlspecialchars($var);

    return $var;
}

//Funcion que comprueba si el administrado existe o no
function check_admin(){
    if(!isset($_SESSION['id'])){
        redir("./");
    }
}

function redir($var){
	?>
    <script>
        window.location="<?=$var?>";
    </script>
<?php
	die();
}

function alert($var){
    ?>
    <script type="text/javascript">
        alert("<?=$var?>");
        </script>
        <?php
}

//Funcion encargada de mirar si existe el usuario
function check_user($url){

    if (!isset($_SESSION['id_cliente'])) {
        redir("?p=login&return=&url");
    } else {

    }
}

//Funcion encargada de mostrar el nombre del cliente al iniciar la sesion
function nombre_cliente($id_cliente){
    $mysqli=connect();

    $q = $mysqli->query("SELECT * FROM clientes WHERE id = '$id_cliente'");
    $r = mysqli_fetch_array($q);
    return $r['name'];
}

//Funcion encargada de conectar con nuestra base de datos
function connect(){
    $host_mysql = "localhost";
    $user_mysql = "root";
    $pass_mysql = "";
    $db_mysql = "tienda";

    $mysqli = mysqli_connect($host_mysql,$user_mysql,$pass_mysql,$db_mysql);
    return $mysqli;
}
//Funcion encargada de transformar la fecha para qie no la de en modo españa

function fecha($fecha){

    $e = explode("-",$fecha);

    $year = $e[0];
    $month = $e[1];
    $e2 = explode(" ",$e[2]);
    $day = $e2[0];
    $time = $e2[1];

    $e3 = explode(":",$time);
    $hour = $e3[0];
    $mins = $e3[1];

    return $day."/".$month."/".$year." ".$hour.":".$mins;

}

//Esta funcion verifica el estado de nuestra compra
function estado($id_estado){
    if ($id_estado == 0) {
        $status = "Iniciando";
    } elseif ($id_estado == 1) {
        $status = "Preparando";
    } elseif ($id_estado == 2) {
        $status = "Entregado";
    } elseif ($id_estado == 3) {
        $status = "Finalizado";
    } else {
        $status = "Indefinido";
    }

    return $status;
}

//Devuelve el nombre del administrador
function admin_name_connected(){
    include "config.php";
    $id = $_SESSION['id'];
    $mysqli = connect();

    $q = $mysqli->query("SELECT * FROM admins WHERE id = '$id'");
    $r = mysqli_fetch_array($q);

    return $r['name'];

}

//Con esta funcion verificamos el estado del pagp
function estado_pago($estado){

    if($estado==0){
        $estado = "Sin Verificar";
    }elseif($estado==1){
        $estado = "Verificado y Aprobado";
    }elseif($estado==2){
        $estado = "Reembolsado";
    }else{
        $estado = "Sin Verificar";
    }

    return $estado;

}
?>
