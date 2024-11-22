<?php 
include 'conexion.php';

session_start();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name_user=$_POST["name_user"];
    $pass=$_POST["pass"];

    $sqlLogin="SELECT id, pass FROM users WHERE username=?";
    $stmtLogin=$con->prepare($sqlLogin);
    $stmtLogin->bind_param("s",$name_user);
    $stmtLogin->execute();
    $stmtLogin->store_result();//Almacena lo resultado para despues usarla

    if($stmtLogin->num_rows > 0){
        $stmtLogin->bind_result($id, $hashed_password);
        $stmtLogin->fetch();

        if(password_verify($pass, $hashed_password)){ // para comparar la contraseña si coindiden con la que esta almacenada en la base de datos
            $_SESSION["id"]=$id;

            // obtner el nonbre del usuario
            $sqlGetNombre="SELECT nombre FROM users WHERE id=?";
            $stmtGetNombre=$con->prepare($sqlGetNombre);
            $stmtGetNombre->bind_param("i",$id);
            $stmtGetNombre->execute();
            $stmtGetNombre->bind_result($nombre);
            $stmtGetNombre->fetch();

            $_SESSION["nombre"]=$nombre;
            header("Location:prueba.php");  
            exit();
        }else{ 
            echo "Cotraseña esta incorrecto";
        }

    }else{
        echo "Usuario no encontrado";
    }
    $stmtLogin->close();
    $con->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
</head>
<body>
   <h2>Inicia session</h2> 
   <form action="index.php" method="post">
     <label for="name_user">Usuario</label>
     <input type="text" name="name_user" id="name_user">

     <label for="pass">Clave</label>
     <input type="password" name="pass" id="pass">
<br>
<br>

     <input type="submit" value="Iniciar" name="btnInciar">
     <br>
     <a href="crearUsuario.html">Regitrarse aqui</a>

   </form>
</body>
</html> 