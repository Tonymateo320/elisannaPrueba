<?php 

$con= mysqli_connect("localhost", "root", "", "proyectofinal");
mysqli_set_charset($con, 'utf8');
if ($con->connect_error) {
    die("Conexion fallida" . $con->connect_error);
}else


?>