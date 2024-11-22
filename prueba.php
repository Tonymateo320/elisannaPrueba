<?php
include 'conexion.php';
session_start();
if (isset($_SESSION["nombre"])) {
    $nombre = $_SESSION["nombre"];

    // Consulta para obtener el ID
    $sqlId = "SELECT id FROM users WHERE nombre = ?";
    $stmt = $con->prepare($sqlId);
    $stmt->bind_param("s", $nombre);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Obtener el resultado
        $resultado = $stmt->get_result();

        // Verificar si hay resultados
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $id = $fila['id'];
        } else {
            echo "No se encontró el usuario con el nombre: " . $nombre;
        }
    } else {
        echo "Error en la ejecución de la consulta: " . $stmt->error;
    }
} else {
    echo "No hay nombre de usuario en la sesión";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM5z4z5e5e5e5e5e5e5e5e5e5e5e5e5e5e5e5e" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">


    <!--Normalizacion-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" />
    <!--font awesome-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- jQuery 3.6 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6aa2fa5935.js" crossorigin="anonymous"></script>
    <!-- Popper.js 1. -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- jQuery DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- jQuery DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./estilos/contenedores.css">
</head>

<body>

    <div class="container my-3">
        <div class="row">
            <!-- donde aprareceran los menus ya sea de crear nuevos registro -->

            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 py-4">
                <section class="borde">
                    <div class="form-group">
                        <h1 style="text-align: center;">Gracias a Dios, estamos aqui</h1>
                        <h5 style="text-transform: uppercase; text-align:center ;"> Bienvenido: <?php echo htmlspecialchars($nombre); ?></h5>

                        <div class="add_task">
                            <p class="texto_item"> <a class=" texto_item cambio_item" href="#" data-toggle="modal" data-target="#agregar"> Agregar tareas <i class="fa-solid fa-plus"> </i> </a> </p>
                        </div>

                        <!-- Modal para agregar actividad -->
                        <div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="estadoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="estadoModalLabel">Detalle de actividad</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h3 style="text-align: center;"> <?php echo $nombre ?> </h3>
                                        <hr>
                                        <form id="estadoForm" action="procesarContenido.php" method="post">
                                            <div class="modal-body">


                                                <input hidden name="id" id="id" value="<?php echo $id; ?>">
                                                <div class="form-group">
                                                    <label for="titulo">Titulo</label>
                                                    <input type="text" class="form-control" name="titulo" id="titulo">
                                                </div>


                                                <div class="form-group">
                                                    <label for="contenido">Contenido</label>
                                                    <textarea class="form-control" id="contenido" name="contenido"></textarea>
                                                </div>


                                                <div class="form-group">
                                                    <label for="evento">Fecha Evento</label>
                                                    <input type="date" class="form-control" id="evento" name="evento">
                                                </div>



                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary" name="btnGuardar">Guardar</button>
                                            </div>
                                        </form>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>


            <section class="border">
                <?php
            
                if (isset($id)) {
                    $sqlDatos = "SELECT * FROM tasks WHERE user_id = ?";
                    $stmtMostrar = $con->prepare($sqlDatos);
                    $stmtMostrar->bind_param("i", $id);

                    if ($stmtMostrar->execute()) {
                        $mostrar = $stmtMostrar->get_result();

                        // Para mostrar múltiples tareas, usa un bucle
                        while ($row = $mostrar->fetch_assoc()) {
                            // $userId = $row['id'];
                            $titulo = $row['title'];
                            $evento = $row['descripcion'];
                            $estado = $row['estado'];
                            $fechaVen = $row['fechaVencimiento'];

                            // Renderiza cada tarea en una tarjeta
                ?>
                            <div class="container md-3">
                                <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                                    <div class="card-header"><?php echo htmlspecialchars($estado); ?></div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($titulo); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($evento); ?></p>
                                        <p>Fecha de Vencimiento: <?php echo htmlspecialchars($fechaVen); ?></p>
                                    </div>
                                </div>
                            </div>
                <?php
                        }

                        // Si no hay tareas
                        if ($mostrar->num_rows == 0) {
                            echo "<p>No hay tareas registradas.</p>";
                        }
                    } else {
                        echo "Error al ejecutar la consulta: " . $stmtMostrar->error;
                    }
                } else {
                    echo "ID de usuario no definido";
                }
                ?>
                </section>

    

        <!-- las taras realizadas -->

        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 py-4">
            <section class="borde">
                <div class="form-group">
                    <h1 style="text-align: center;">Gracias a Dios, estamos aqui</h1>
                    <h5 style="text-transform: uppercase; text-align:center ;"> Bienvenido: <?php echo htmlspecialchars($nombre); ?></h5>

                </div>
            </section>
        </div>

    </div>
    </div>
    <!-- Pie de pagina -->
    <footer>

    </footer>
    <!-- script para  bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>