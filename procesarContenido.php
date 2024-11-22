<?php
include 'conexion.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userID=intval($_POST["id"]);
    $titulo= $_POST["titulo"];
    $contenido= $_POST["contenido"];
    $evento= $_POST["evento"];

    $sqlInsert="INSERT INTO tasks (user_id,title,descripcion,fechaVencimiento) Values (?,?,?,?)";
    $stmt=$con->prepare($sqlInsert);
    $stmt->bind_param("isss",$userID ,$titulo,$contenido,$evento);
    $stmt->execute();

    if(!$stmt){
        echo "Error: al registrarse ";
    }else{
        header("Location:prueba.php");
    }
    $stmt->close();
    $con->close();

}

?>