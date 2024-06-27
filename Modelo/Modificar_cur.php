<?php
include('../Modelo/conec_BD.php');
session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION["cargo"])) {
    header("Location: ../Login.php");
    exit();
}else{
    $usuario = $_SESSION['usuario'];
    $Cargo = $_SESSION['cargo'];
    $documento = $_SESSION['documento'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Vista/Estilo/General.css">
    <script src="https://kit.fontawesome.com/5038b205c4.js" crossorigin="anonymous"></script>
    <link rel="shorcut icon" href="../Vista/IMG/escudo.png">
    <title>Modificar Curso</title>
</head>
<body>
<section id="sectionCur">
        <header>
            <i class="fa-solid fa-book" id="Icono"></i>
            <i class="fa-regular fa-pen-to-square" id="Icono-2"></i>
            <p id="head">Modificar Cursos</p>
            
        </header>
        <?php
    // Función para modificar el curso en la base de datos
    function modificarCurso($conex, $curso_actual, $curso_nuevo) {
        // Modificar el curso en la tabla de cursos
        $query_modificar_curso = "UPDATE cursos SET Numero_Curso = '$curso_nuevo' WHERE Numero_Curso = '$curso_actual'";
        mysqli_query($conex, $query_modificar_curso);
    }
    if (isset($_GET['Numero_Curso'])) {
        // Obtener el número de curso de la URL
        $curso_actual = $_GET['Numero_Curso'];
    
        // Consultar los datos del curso desde la base de datos
        $query = "SELECT * FROM cursos WHERE Numero_Curso = $curso_actual";
        $resultado = mysqli_query($conex, $query);
    
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            // Si el curso existe, mostrar el formulario de edición
            $curso = mysqli_fetch_assoc($resultado);
    
            if (isset($_POST['curso_nuevo'])) {
                // Si se envió el formulario, modificar el curso
                $curso_nuevo = $_POST['curso_nuevo'];
                modificarCurso($conex, $curso_actual, $curso_nuevo);

                // Después de actualizar los datos con éxito
                $_SESSION['actualizacion_exitosa'] = true;
                // Redirigir al formulario de consulta con un mensaje de éxito
                header("Location: ../Vista/Registra_cur.php");
                die();
            }
        }
    }
            ?>
            <form action="" method="post">
        <br>
    <!-- Numero del curso  -->
    
        <div class="campos">
            <i class="fa-solid fa-hashtag"></i>
            <input type="number" id="user" id="i2" name="curso_nuevo" value="<?=$curso['Numero_Curso']?>" autocomplete="off">
        </div>

    <br>

    <div id="cont-Boton">        
        <i class="fa-solid fa-book" ></i>
        <input type="submit" value="Modificar" id="open">
    </div>

    </form>
    <button class="boton-animated" onclick="window.location.href='../Vista/Registra_cur.php'">
        <i class="fas fa-arrow-right"></i> Regresar
    </button>

</section>
</body>
</html>