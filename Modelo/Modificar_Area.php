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
//
    $Id=isset($_REQUEST['Id_Area'])?$_REQUEST['Id_Area']:null;

    $nombre_area=isset($_REQUEST['Nombre_Area'])?$_REQUEST['Nombre_Area']:null;
    $materias=isset($_REQUEST['Materias_Seleccionadas'])? $_REQUEST['Materias_Seleccionadas']:null;
    $cursos = isset($_REQUEST['Cursos_Seleccionados'])? $_REQUEST['Cursos_Seleccionados']:null;

    // Convierte los arrays $materias y $cursos a formato JSON y los almacena en las variables $materiasJSON y $cursosJSON

        $materiasJSON = json_encode($materias,JSON_UNESCAPED_UNICODE );
        $cursosJSON = json_encode($cursos,JSON_UNESCAPED_UNICODE );

    if($_SERVER['REQUEST_METHOD']=='POST'){

    // Obtén las materias anteriores del área antes de la actualización
    $consultaMateriasAnteriores = $miPDO->prepare('SELECT Nom_mat_pertenecen FROM areas WHERE Id_Area=:Id_Area');
    $consultaMateriasAnteriores->execute([
        'Id_Area' => $Id,
    ]);
    $resultMateriasAnteriores = $consultaMateriasAnteriores->fetch();
    $materiasAnteriores = json_decode($resultMateriasAnteriores['Nom_mat_pertenecen']);

    foreach ($materias as $nombre_materia) {
        // Consulta para obtener el ID de la materia
        $consultaMateria = $miPDO->prepare('SELECT Id_materias FROM materias WHERE Nombre_Materias=:nombre_materia');
        $consultaMateria->execute([
            'nombre_materia' => $nombre_materia
        ]);
        $result = $consultaMateria->fetch();

        if ($result) {
            $materia_id = $result['Id_materias'];

            // Actualiza el campo "Id_Area" en la materia
            $miUpdateMateria = $miPDO->prepare('UPDATE materias SET Id_Area=:Id_Area WHERE Id_materias=:Id_materias');
            $miUpdateMateria->execute([
                'Id_materias' => $materia_id,
                'Id_Area' => $Id // Usar el ID del área
            ]);

            // Remueve la materia de la lista de materias anteriores
            if (($key = array_search($nombre_materia, $materiasAnteriores)) !== false) {
                unset($materiasAnteriores[$key]);
            }
        }
    }

    // Las materias que quedan en $materiasAnteriores ya no están asociadas al área
    // Por lo tanto, debes actualizar el campo Id_Area a NULL para estas materias.
    foreach ($materiasAnteriores as $nombre_materia) {
        // Consulta para obtener el ID de la materia
        $consultaMateria = $miPDO->prepare('SELECT Id_materias FROM materias WHERE Nombre_Materias=:nombre_materia');
        $consultaMateria->execute([
            'nombre_materia' => $nombre_materia
        ]);
        $result = $consultaMateria->fetch();

        if ($result) {
            $materia_id = $result['Id_materias'];

            // Actualiza el campo Id_Area de la materia a NULL
            $miUpdateMateria = $miPDO->prepare('UPDATE materias SET Id_Area=NULL WHERE Id_materias=:Id_materias');
            $miUpdateMateria->execute([
                'Id_materias' => $materia_id,
            ]);
        }
    }

    // Actualiza el área con los nuevos datos
    $miupdate = $miPDO->prepare('UPDATE areas SET Nombre_Area=:Nombre_Area, Numero_Curso=:Cursos_Seleccionados, Nom_mat_pertenecen=:Materias_Seleccionadas WHERE Id_Area=:Id_Area');
    $miupdate->execute([
        'Id_Area' => $Id,
        'Nombre_Area' => $nombre_area,
        'Materias_Seleccionadas' => $materiasJSON,
        'Cursos_Seleccionados' => $cursosJSON
    ]);
    // Después de actualizar los datos con éxito
    $_SESSION['actualizacion_exitosa'] = true;
    header('location:../Vista/Registra_mat.php');
    die();
    }else{

        $miConsulta=$miPDO->prepare('SELECT * FROM areas WHERE Id_Area=:Id_Area;');
        $miConsulta->execute(
            [
                'Id_Area'=>$Id,
            ]
            );
    }
    $area=$miConsulta->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Vista/Estilo/General.css">
    <script src="https://kit.fontawesome.com/5038b205c4.js" crossorigin="anonymous"></script>
    <link rel="shorcut icon" href="../Vista/IMG/escudo.png">
    <title>Document</title>
</head>
<style>
    #materiasAnteriores {
        display: none;
        position: absolute; 
        z-index: 2;
        margin-top:10.5%;
        margin-left: 83%;
        padding: 15px;
        border: 1px solid rgb(0, 27, 51);
        border-radius: 10px;
        background-color: #ecf0f1;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 190px;
    }
    #materiasAnteriores h2 {
        font-size: 18px;
        margin-bottom: 10px;
        color: rgb(0, 57, 91);
    }
    #materiasAnteriores ul {
        margin-left: 10px;
        list-style: circle;
        padding: 0;
    }

    #materiasAnteriores ul li {
        margin-bottom: 5px;
        color: #555;
    }
    @keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
    }
    .show-animation {
    animation: fadeIn 1s ease-in-out;
    }
    </style>
<body>
    <!-- Caja Materias y cursos -->

    <div id="materiasAnteriores">
        <h2>Materias Actuales</h2>
            <?php
                // Obtén las materias anteriores del docente
                $materiasActuales = json_decode($area['Nom_mat_pertenecen']);
        
                // Muestra las materias anteriores
                if ($materiasActuales) {
                    echo '<ul>';
                    foreach ($materiasActuales as $materia) {
                        echo '<li>' . $materia . '</li>';
                    }
                    echo '</ul>';
                }else{
                    echo '<ul><li>
                    No se encontraron materias ya registradas</li>
                    </ul>';
                }
            ?>
        <h2>Cursos Actuales</h2>
            <?php
                // Obtén las materias anteriores del docente
                $cursosActuales=json_decode($area['Numero_Curso']);
        
                // Muestra las materias anteriores
                if ($cursosActuales) {
                    echo '<ul>';
                    foreach ($cursosActuales as $cursos) {
                        echo '<li>' . $cursos . '</li>';
                    }
                    echo '</ul>';
                }else{
                    echo '<p>No se encontraron cursos ya registrados.</p>';
                }
            ?>
    </div>

<section id="sectionMat">
    <header>
        <i class="fa-solid fa-book" id="Icono"></i>
        <i class="fa-solid fa-magnifying-glass" id="Icono-2"></i>
        <p id="head">Modificar Area</p>
    </header>

<form action="" method="post">
    <br>
<!-- Nombre  -->

    <div class="campos">
        <i class="fa-solid fa-pencil"></i>
        <input type="text"   id="user" id="i2" name="Nombre Area" value="<?=$area['Nombre_Area']?>" autocomplete="off">
    </div>
<br>

<div id="cont-chiki">

<!-- Curso -->

    <div class="container">
        <p id="Asign"><strong>Asignar Cursos :</strong></p>
        <div class="custom-combobox-container">
            <div class="custom-combobox" onclick="showOptions(this)">
                <input type="text" id="inputCheckbox" readonly>
                <img src="../Vista/IMG/arrowl.png">
            </div>
            <div class="options-container" id="divOptions" onmouseleave="hideOptions(this)">
                <?php
                $consulta= "SELECT * FROM cursos ORDER BY Numero_Curso ASC;";
                $result= $conex->query($consulta);
                $cursosActuales=json_decode($area['Numero_Curso']);
                if ($cursosActuales) {
                foreach ($cursosActuales as $cursos) { 
                echo '<label for="one"> <input type="checkbox" name="Cursos_Seleccionados[]" value="' . $cursos . '" checked > ' . $cursos . ' </label>';
                }}else{
                    echo '';
                }
                while ($row = $result->fetch_assoc()){
                        echo '<label for="one"> <input type="checkbox" name="Cursos_Seleccionados[ ]" value="' . $row['Numero_Curso'] . '"> ' . $row['Numero_Curso'] . ' </label>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Materias -->

    <div class="container2">
        <p id="Asign"><strong>Asignar Materias :</strong></p>
        <div class="custom-combobox-container">
            <div class="custom-combobox" onclick="showOptions2(this)">
                <input type="text" id="inputCheckbox2" readonly>
                <img src="../Vista/IMG/arrowl.png">
            </div>
            <div class="options-container" id="divOptions2" onmouseleave="hideOptions2(this)">
            <?php
            $consulta= "SELECT * FROM materias";
            $result= $conex->query($consulta);
            $materiasActuales = json_decode($area['Nom_mat_pertenecen']);
            if ($materiasActuales) {
            foreach ($materiasActuales as $materia) {            
            echo '<label for="a"> <input type="checkbox" name="Materias_Seleccionadas[]" value="' . $materia . '" checked > ' . $materia . ' </label>';
            }}else{
                echo '';
            }
            while ($row = $result->fetch_assoc()){
                    echo '<label for="a"> <input type="checkbox" name="Materias_Seleccionadas[]" value="' . $row['Nombre_Materias'] . '"> ' . $row['Nombre_Materias'] . ' </label>';
            }
            ?>
            </div>
        </div>
    </div>     

    <br>
    <div id="cont-Boton-otro">        
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="hidden" name="Id_Area" value="<?=$Id?>"> 
        <input type="submit" value="Modificar" id="open">
    </div>
</div>
</form>

<button class="boton-animated" onclick="window.location.href='../Vista/Registra_mat.php'">
        <i class="fas fa-arrow-right"></i> Regresar
</button>
</section>
<script src="../Vista/JS/script.js"></script>
</body>
</html>