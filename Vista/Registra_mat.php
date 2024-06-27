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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilo/General.css">
    <script src="https://kit.fontawesome.com/5038b205c4.js" crossorigin="anonymous"></script>
    <link rel="shorcut icon" href="IMG/escudo.png">
    <title>Registra Materias</title>
    <!-- Estilos de tabla de consulta -->
    <style>
        table{
            border-collapse: collapse;
            width: 80%;
            margin-left:10%;
            margin-top:10%;
            margin-bottom:3%;
        }
        th {
            background-color: rgb(0, 57, 91);
            color: #fff;
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
        }
        table td{
            border: 1px solid #ccc;
            text-align:center;
            padding:1.3rem;
            max-width: 150px; /* Ancho máximo para mantener el diseño ordenado */
            white-space: normal; /* Permite que el contenido se ajuste automáticamente */
            word-wrap: break-word; /* Rompe las palabras largas en varias líneas si es necesario */
            overflow: hidden; /* Oculta cualquier contenido que desborde el ancho máximo */
        }
        
        
        table i{
            color:white;
            font-size:14px;
            margin-left:7px;
        }
        td i{
            color:white;
            font-size:14px;
            margin-left:7px;
        }
        .button{
            border-radius:.5rem;
            color:white;
            background-color:rgb(6, 69, 125);
            padding:0.5rem;
            text-decoration:none;
            transition: all 0.3s ease-in-out; 
        }
            #button-Inhabilitar{
                background-color:rgb(139, 30, 30);
            }
            #button-Inhabilitar:hover{
                background-color: rgb(0, 57, 91);
            }
        .button:hover {
            background-color: rgb(0, 57, 91); /* Cambiar el color de fondo al pasar el cursor */
        }
    </style>
</head>
<body>
<nav>
        <ul class="menu">
            <img src="IMG/escudo.png" width="100px" height="110px">
                <li><a href="../Pagina_principal.php" id="Navegador"><i class="fa-solid fa-house"></i> Inicio</a></li>
                <li>
            <a href=""><i class="fa-regular fa-pen-to-square"></i> Registros</a>
            <ul class="menu-vertical">
                <li><a href="Registra_cur.php" ><i class="fa-regular fa-pen-to-square"></i> Registrar Curso</a></li>
                <li><a href="Registra_mat.php"><i class="fa-regular fa-pen-to-square"></i> Registrar Materias</a></li>
            </ul>
            </li>
            <li>
                <a href=""><i class="fa-solid fa-wrench"></i> Gestiones</a>
                <ul class="menu-vertical">
                    <?php
                    if($Cargo == "Coordinador(a)"){
                        ?>
                            <li><a href="" class="subrayar-cursiva"><i class="fa-solid fa-wrench"></i> Gestión de Directivos</a></li>
                        <?php
                    }else{
                        ?>
                            <li><a href="Gestion_Direc.php" ><i class="fa-solid fa-wrench"></i> Gestión de Directivos</a></li>
                        <?php
                    }
                    ?>
                    <li><a href="Gestion_Es.php"><i class="fa-solid fa-wrench"></i> Gestión de Estudiantes</a></li>
                    <li><a href="Gestion_Doc.php"><i class="fa-solid fa-wrench"></i> Gestión de Docentes</a></li>
                    <li><a href="Gestion_tiempo.php"><i class="fa-solid fa-wrench"></i> Gestión de Tiempo</a></li>
                </ul>
            </li>
            <li>
                <a href="Generar_Reporte.php" ><i class="fa-regular fa-clipboard"></i> Generar reporte</a>
            </li>
                    <div class="profile-container">
                        <div class="user-details" >
                            <img src="IMG/perfil-del-usuario (1).png" alt="Imagen de perfil" class="profile-image">
                            <div class="profile-info">
                                <strong><?php echo $usuario; ?></strong>
                                    <p class="profile-title"><?php echo $Cargo; ?></p>
                                    <a href="../Controlador/Logout.php" class="logout-link" ><i class="fa-solid fa-right-to-bracket"></i>Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
        </ul>
</nav>
<!-- REGISTRAR MATERIAS -->

<section id="sectionMat">
        <header>
            <i class="fa-solid fa-book" id="Icono"></i>
            <i class="fa-regular fa-pen-to-square" id="Icono-2"></i>
            <p id="head">Registrar Materias</p>
            
        </header>


    <form action="" method="post">
        <br>
    <!-- Nombre  -->
    
        <div class="campos">
            <i class="fa-solid fa-pencil"></i>
            <input type="text"  placeholder=" Nombre de la Materia"  id="user" id="i2" name="Nombre_Materias" require autocomplete="off">
        </div>
    <br>
    <div class="campos">
        <i class="fa-solid fa-percentage"></i>
        <input type="text" placeholder="Porcentaje" id="porcentaje" name="Porcentaje" autocomplete="off">
    </div>

        <br>
        <div id="cont-Boton-otro">
            <i class="fa-solid fa-user-plus" ></i> 
            <input type="submit" value="Agregar Materia" id="open" name="regis-mat">
        </div>
    </form>
<?php
if(isset($_POST["regis-mat"])){
    $nom_mat=isset($_REQUEST['Nombre_Materias'])?$_REQUEST['Nombre_Materias']:null;
    $porcentaje = isset($_REQUEST['Porcentaje']) ? $_REQUEST['Porcentaje'] : null;

    $sql="SELECT * FROM materias WHERE Nombre_Materias='$nom_mat'";
    $doble =  mysqli_query($conex,$sql);

    if(!$doble->num_rows>0){
    
        $miInsert = $miPDO->prepare('INSERT INTO materias(Nombre_Materias, Porcentaje) VALUES (:Nombre_Materias, :Porcentaje)');
        $miInsert->execute(
            array(
                'Nombre_Materias' => $nom_mat,
                'Porcentaje' => $porcentaje,
            )
        );
        if($miInsert){
            ?>
            <h4 class="ok">Materia registrada correctamente</h4>
            <?php
        }
    }else{
        ?>
        <h4 class="F">Ya hay una Materia registrada con el mismo nombre</h4>
        <?php
    }
}
?>
</section>

<!-- REGISTRAR AREA -->


<section id="sectionAr">
        <header>
            <i class="fa-solid fa-book" id="Icono"></i>
            <i class="fa-regular fa-pen-to-square" id="Icono-2"></i>
            <p id="head">Registrar Area</p>
            
        </header>

<form action="" method="post">

        <br>
    <!-- Nombre Area  -->
    
        <div class="campos">
            <i class="fa-solid fa-pencil"></i>
            <input type="text"  placeholder=" Nombre del Area"  id="user" id="i2" name="Nombre_Area">
        </div>
<br>

<div id="cont-chiki">


    <!-- Materia al que pertenece el area -->

    <div class="container">
        <p id="Asign"><strong>Asignar Materias :</strong></p>
        <div class="custom-combobox-container">
            <div class="custom-combobox" onclick="showOptions(this)">
                <input type="text" id="inputCheckbox" readonly>
                <img src="IMG/arrowl.png">
            </div>
            <div class="options-container" id="divOptions" onmouseleave="hideOptions(this)">

            <?php
            $consulta= "SELECT * FROM materias";
            $result= $conex->query($consulta);
            while ($row = $result->fetch_assoc()){
                    echo '<label for="one"> <input type="checkbox" name="Materias_Seleccionadas[ ]" value="' . $row['Nombre_Materias'] . '"> ' . $row['Nombre_Materias'] . ' </label>';
            }
            ?>
            </div>
        </div>
    </div> 
    
    <!-- Cursos al que pertenece el area -->

    <div class="container2">
        <p id="Asign"><strong>Asignar Cursos :</strong></p>
        <div class="custom-combobox-container">
            <div class="custom-combobox" onclick="showOptions2(this)">
                <input type="text" id="inputCheckbox2" readonly>
                <img src="IMG/arrowl.png">
            </div>
            <div class="options-container" id="divOptions2" onmouseleave="hideOptions2(this)">
            <?php
           $consulta= "SELECT * FROM cursos ORDER BY Numero_Curso ASC;";
            $result= $conex->query($consulta);
            while ($row = $result->fetch_assoc()){
                    echo '<label for="one"> <input type="checkbox" name="Cursos_Seleccionados[ ]" value="' . $row['Numero_Curso'] . '"> ' . $row['Numero_Curso'] . ' </label>';
            }
            ?>
            </div>
        </div>
    </div>

        <br>
        <div id="cont-Boton">
            <i class="fa-solid fa-user-plus" ></i> 
            <input type="submit" value="Agregar Area" id="open" name="regis-area">
        </div>
</div>
    </form>

<!--Php regisro de areas y asignacion de materias por curso-->

        <?php

if (isset($_POST["regis-area"])) {

    $nombre_area = isset($_REQUEST['Nombre_Area']) ? $_REQUEST['Nombre_Area'] : null;
    $materias=isset($_REQUEST['Materias_Seleccionadas'])? $_REQUEST['Materias_Seleccionadas']:null;
    $cursos = isset($_REQUEST['Cursos_Seleccionados'])? $_REQUEST['Cursos_Seleccionados']:null;

    // Convierte los arrays $materias y $cursos a formato JSON y los almacena en las variables $materiasJSON y $cursosJSON

        $materiasJSON = json_encode($materias,JSON_UNESCAPED_UNICODE );
        $cursosJSON = json_encode($cursos,JSON_UNESCAPED_UNICODE );
    
    // Construye una consulta SQL para verificar si ya existe un área con el mismo nombre

    $sql="SELECT * FROM areas WHERE Nombre_Area='$nombre_area'";
    $doble = mysqli_query($conex,$sql);

     // Verifica si no se encontraron áreas con el mismo nombre
    if(!$doble->num_rows>0){
    $materias_seleccionadas = isset($_REQUEST['Materias_Seleccionadas']) ? $_REQUEST['Materias_Seleccionadas'] : array();

    // Primero, insertamos el área en la tabla de áreas

    $miInsertArea = $miPDO->prepare('INSERT INTO areas(Nombre_Area,Nom_mat_pertenecen,Numero_Curso) VALUES (:Nombre_Area,:Materias_Seleccionadas,:Cursos_Seleccionados)');
    $miInsertArea->execute(
        array(
            'Nombre_Area' => $nombre_area,
            'Materias_Seleccionadas' => $materiasJSON,
            'Cursos_Seleccionados' => $cursosJSON
        )
    );

    // Luego, obtenemos el ID del área recién insertada
    $area_id = $miPDO->lastInsertId();

    // Finalmente, actualizamos el campo "Id_Area" en las materias seleccionadas

    foreach ($materias_seleccionadas as $materia_id) {
        $miUpdateMateria = $miPDO->prepare('UPDATE materias SET Id_Area=:Nombre_Area WHERE Nombre_Materias=:Nombre_Materias');
        $miUpdateMateria->execute(
            array(
                'Nombre_Area' => $area_id,
                'Nombre_Materias' => $materia_id
            )
        );
    }
    ?>
    <!-- Muestra un mensaje de éxito si el área se registró correctamente -->
    <h4 class="ok">Área registrada correctamente con sus materias</h4>
    <?php
}else{
    ?>
    <!-- Muestra un mensaje de error si ya existe un área con el mismo nombre -->
    <h4 class="F">Ya hay un Área registrada con ese nombre</h4>
    <?php
}
}
        ?>
    
</section>
<!-- CONSULTAR AREA -->

<section id="sectionC">
    <header>
        <i class="fa-solid fa-book" id="Icono"></i>
        <i class="fa-solid fa-magnifying-glass" id="Icono-2"></i>
        <p id="head">Consultar Areas</p>
    </header>

<form action="" method="post" onsubmit="redirigirATabla()">
    <br>
<!-- Nombre  -->

    <div class="campos">
        <i class="fa-solid fa-pencil"></i>
        <input type="text"  placeholder=" Nombres del Area"  id="user" id="i2" name="Nombre Area">
    </div>
<br>


    <br>
    <div id="cont-Boton-otro">        
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="submit" value="Consultar Area" id="DiferenteT" name="consul-area">
    </div>

</form>
<table id="tablaResultados">
    <tr>
        <th>Area</th>
        <th>Materias</th>
        <th>Curso</th>
        <th>Modificar<i class="fa-solid fa-pen"></i></th>
        <th>Borrar<i class="fa-solid fa-trash"></i></th>
    </tr>

<?php
    if (isset($_POST["consul-area"])) {

        $nombre_area_buscar = isset($_REQUEST['Nombre_Area']) ? $_REQUEST['Nombre_Area'] : '';
    
        // Consultar el área por su nombre
        $consulta_area = $miPDO->prepare('SELECT * FROM areas WHERE Nombre_Area = :Nombre_Area');
        $consulta_area->execute(
            array(
                'Nombre_Area' => $nombre_area_buscar
            )
        );
        $area = $consulta_area->fetch();
    
        // Verificar si se encontró el área
        if ($area) {
            // Imprimir el nombre del área
            echo '<tr>';
            echo "<td>" . $area['Nombre_Area']."</td>";
    
            // Decodificar los campos JSON Materias_Seleccionadas y Cursos_Seleccionados
            $materiasDecoded = json_decode($area['Nom_mat_pertenecen'], true);
            $cursosDecoded = json_decode($area['Numero_Curso'], true);
    
            // Verificar si la decodificación de los campos JSON fue exitosa
            if ($materiasDecoded !== null && $cursosDecoded !== null) {
                // Recorrer y mostrar los campos decodificados
                echo '<td>';
                foreach ($materiasDecoded as $materia) {
                    echo "$materia<br>";
                }
                echo '</td>';
                echo '<td>';
                foreach ($cursosDecoded as $curso) {
                    echo "$curso<br>";
                }
                echo '</td>';
                ?>
                <td> <a  class="button" href="../Modelo/Modificar_Area.php?Id_Area=<?= $area['Id_Area']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> <a  class="button"  id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_Area=<?= $area['Id_Area']?>">Borrar<i class="fa-solid fa-trash"></i></a></td>
                <?php
            echo '</tr>';
            } else {
                // Error en la decodificación JSON
                echo "<br>Error al decodificar los campos JSON.";
            }
        } else {
            // El área no se encontró en la base de datos
            ?>
            <h4 class="F">No se ha encontrado un area con ese nombre</h4>
            <?php
        }
    }



?>

</table>
</section>

<!-- CONSULTAR MATERIA-->

<section id="sectionC">
    <header>
        <i class="fa-solid fa-book" id="Icono"></i>
        <i class="fa-solid fa-magnifying-glass" id="Icono-2"></i>
        <p id="head">Consultar Materias</p>
    </header>

<form action="" method="post">
    <br>
<!-- Nombre -->

    <div class="campos">
        <i class="fa-solid fa-pencil"></i>
        <input type="text"  placeholder=" Nombre de la materia"  id="user" id="i2" name="Nombre_Materias">
    </div>
<br>


    <br>
    <div id="cont-Boton-otro">        
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="submit" value="Consultar Materia" id="DiferenteT" name="consul-mat">
    </div>

</form>
<table>
    <tr>
        <th>Materia</th>
        <th>Area que pertenece</th>
        <th>Modificar<i class="fa-solid fa-pen"></i></th>
        <th>Borrar<i class="fa-solid fa-trash"></i></th>
    </tr>

<?php
if (isset($_POST["consul-mat"])) {
    $nombre_materia_buscar = isset($_REQUEST['Nombre_Materias']) ? $_REQUEST['Nombre_Materias'] : '';

    // Consultar la materia
    $consulta_materia = $miPDO->prepare('SELECT * FROM materias WHERE Nombre_Materias = :Nombre_Materias');
    $consulta_materia->execute(array('Nombre_Materias' => $nombre_materia_buscar));
    $materia = $consulta_materia->fetch();

    // Verificar si se encontró la materia
    if ($materia) {
        // Obtener el ID del área desde el campo "Nombre_Area" de la materia
        $area_id = $materia['Id_Area'];

        // Consultar el nombre del área utilizando el ID en la tabla "áreas"
        $consulta_area = $miPDO->prepare('SELECT Nombre_Area FROM areas WHERE Id_Area = :Id_Area');
        $consulta_area->execute(array('Id_Area' => $area_id));
        $area = $consulta_area->fetch();

        if ($area) {
            $nombre_area = $area['Nombre_Area'];
        } else {
            $nombre_area = 'Área no encontrada';
        }

        // Imprimir el nombre de la materia y el nombre del área
        echo '<tr>';
        echo '<td>' . $materia['Nombre_Materias'] . '</td>';
        echo '<td>' . $nombre_area . '</td>';
        ?>
        <td> <a class="button" href="../Modelo/Modificar_Mat.php?Id_materias=<?= $materia['Id_materias']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
        <td> <a class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_materias=<?= $materia['Id_materias']?>">Borrar<i class="fa-solid fa-trash"></i></a></td>
        <?php
        echo '</tr>';
    } else {
        // La materia no se encontró en la base de datos
        ?>
        <h4 class="F">No se ha encontrado una materia con ese nombre</h4>
        <?php
    }
}

?>

</table>
</section>
<?php
// Verifica si hay un mensaje de actualización exitosa
if (isset($_SESSION['actualizacion_exitosa']) && $_SESSION['actualizacion_exitosa']) {
    // Muestra el mensaje de éxito
    echo '<div class="mensaje-exito">Datos actualizados con éxito.</div>';

    // Borra la variable de sesión
    unset($_SESSION['actualizacion_exitosa']);
}
?>
<script src="JS/script.js"></script>
<script>

    function redirigirATabla() {
        window.location.hash = 'tablaResultados';
    }

    document.addEventListener("DOMContentLoaded", function() {
    // Obtener el campo de entrada de porcentaje por su nombre
    var porcentajeInput = document.querySelector('input[name="Porcentaje"]');

    // Agregar un evento de escucha para el evento "input" en el campo de porcentaje
    porcentajeInput.addEventListener("input", function() {
        // Obtener el valor ingresado en el campo
        var porcentaje = parseFloat(porcentajeInput.value);

        // Verificar si el valor no es un número o está fuera del rango de 1 a 100
        if (isNaN(porcentaje) || porcentaje < 1 || porcentaje > 100) {
            // Limpiar el campo de entrada
            porcentajeInput.value = "";
        }
    });
});
</script>
</body>
</html>