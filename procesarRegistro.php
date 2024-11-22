<?php 
include 'conexion.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nombre=$_POST["nombre"];
    $user_name=$_POST["name_user"];
    $pass=password_hash($_POST["pass"],PASSWORD_DEFAULT);

    //inserta user
$sql="INSERT INTO users(nombre, username, pass) VALUES (?,?,?)";
$stmt=$con->prepare($sql);
$stmt->bind_param("sss",$nombre,$user_name,$pass);
$stmt->execute();

if(!$stmt){
    echo "Error al registral los datos ";
}else{
    header("Location:index.php");
}
$stmt->close();
$con->close();

}

?>