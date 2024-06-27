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
    $Id=isset($_REQUEST['Id_docentes'])?$_REQUEST['Id_docentes']:null;
    $nombre=isset($_REQUEST['Nombre_Docente'])?$_REQUEST['Nombre_Docente']:null;
    $nombre_2=isset($_REQUEST['Nombre_Docente_segundo'])?$_REQUEST['Nombre_Docente_segundo']:null;
    $apellido=isset($_REQUEST['Apellido_Docente'])?$_REQUEST['Apellido_Docente']:null;
    $apellido_2=isset($_REQUEST['Apellido_Docente_segundo'])? $_REQUEST['Apellido_Docente_segundo']:null;
    $doc=isset($_REQUEST['Documento_Docente'])?$_REQUEST['Documento_Docente']:null;
    $materias=isset($_REQUEST['Materias_Seleccionadas'])? $_REQUEST['Materias_Seleccionadas']:null;
    $cursos = isset($_REQUEST['Cursos_Seleccionados'])? $_REQUEST['Cursos_Seleccionados']:null;
    
    $materiasJSON = json_encode($materias,JSON_UNESCAPED_UNICODE );
    $cursosJSON = json_encode($cursos,JSON_UNESCAPED_UNICODE );

    $hostPDO="mysql:host=$hostDB;dbname=$nombreDB;";
    $miPDO= new PDO($hostPDO,$usuarioDB,$contrasenaDB);

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $miupdate=$miPDO->prepare('UPDATE docentes SET Nombre_Docente=:Nombre_Docente, Nombre_Docente_2=:Nombre_Docente_segundo, Apellido_Docente=:Apellido_Docente, Apellido_Docente_2=:Apellido_Docente_segundo, Documento_Docente=:Documento_Docente, Numero_curso_asignado=:Cursos_Seleccionados,Nombre_Materia_Asignada=:Materias_Seleccionadas WHERE Id_docentes=:Id_docentes');
        $miupdate->execute(
            [
                'Id_docentes'=>$Id,
                'Nombre_Docente'=> $nombre,
                'Nombre_Docente_segundo'=> $nombre_2,
                'Apellido_Docente' => $apellido,
                'Apellido_Docente_segundo' => $apellido_2,
                'Documento_Docente' => $doc,
                'Materias_Seleccionadas' => $materiasJSON,
                'Cursos_Seleccionados' => $cursosJSON
            ]
            );
            if($miupdate){
            // Después de actualizar los datos con éxito
            $_SESSION['actualizacion_exitosa'] = true;
            header('location:../Vista/Gestion_Doc.php');
            die();
            }
    }else{

        $miConsulta=$miPDO->prepare('SELECT * FROM docentes WHERE Id_docentes=:Id_docentes;');
        $miConsulta->execute(
            [
                'Id_docentes'=>$Id,
            ]
            );
    }
    $docentes=$miConsulta->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Vista/Estilo/General.css">
    <script src="https://kit.fontawesome.com/5038b205c4.js" crossorigin="anonymous"></script>
    <link rel="shorcut icon" href="../Vista/IMG/escudo.png">
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
    <title>Modificar Docente</title>
</head>
<body>
<!-- Caja Materias y cursos -->

    <div id="materiasAnteriores">
        <h2>Materias Actuales</h2>
            <?php
                // Obtén las materias anteriores del docente
                $materiasActuales = json_decode($docentes['Nombre_Materia_Asignada']);
        
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
                $cursosActuales=json_decode($docentes['Numero_curso_asignado']);
        
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
    

        <section id="sectionEs">
        <header>
            <i class="fa-solid fa-chalkboard-user" id="Icono"></i>
            <i class="fa-regular fa-pen-to-square" id="Icono-2"></i>
            <p id="head">Modificar Docentes</p>
            
        </header>

    <form action="" method="post" id="formEs">
        <br>
    <!-- Primer Nombre  -->
    
        <div class="camposEs">
            <i class="fa-solid fa-user"  ></i>
            <input type="text"   placeholder="Primer Nombre" id="user" id="i2" name="Nombre_Docente"  value="<?=$docentes['Nombre_Docente']?>" autocomplete="off">
        </div>


    <!-- Segundo Nombre  -->
    
    <div class="camposEs">
            <i class="fa-solid fa-user"  ></i>
            <input type="text" placeholder="Segundo Nombre" id="user" id="i2" name="Nombre_Docente_segundo"  value="<?=$docentes['Nombre_Docente_2']?>" autocomplete="off">
        </div>
<br><br>

    <!-- Primer Apellido -->

    <div class="camposEs">
            <i class="fa-solid fa-user" ></i>
            <input type="text" placeholder="Primer Apellido" id="user" id="i2" name="Apellido_Docente"   value="<?=$docentes['Apellido_Docente']?>" autocomplete="off">
    </div>

    <!-- Segundo Apellido -->

    <div class="camposEs">
            <i class="fa-solid fa-user" ></i>
            <input type="text" placeholder="Segundo Apellido" id="user" id="i2" name="Apellido_Docente_segundo"  value="<?=$docentes['Apellido_Docente_2']?>" autocomplete="off">
    </div>
<br> <br>

    <!-- DI -->

    <div class="camposEs">
    <i class="fa-solid fa-address-card"></i>
        <input type="text" placeholder="Documento" id="user" id="i2" name="Documento_Docente"  value="<?=$docentes['Documento_Docente']?>" oninput="validarNumeroInputDocumento(this)" autocomplete="off">
    </div>   

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
            $cursosActuales=json_decode($docentes['Numero_curso_asignado']);
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
            $materiasActuales = json_decode($docentes['Nombre_Materia_Asignada']);
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

        <div id="cont-Boton-grande">
            <i class="fa-solid fa-user-plus" ></i> 
            <input type="hidden" name="Id_docentes" value="<?=$Id?>"> 
            <input type="submit" value="Modificar Docente" id="open" name="modif-doc">
        </div>

    </form>


    <button class="boton-animated" onclick="window.location.href='../Vista/Gestion_Doc.php'">
        <i class="fas fa-arrow-right"></i> Regresar
    </button>
        </section> 
        <script src="../Vista/JS/script.js"></script>
        <script>
        // Esta función se ejecuta cuando se intenta ingresar datos en el campo de entrada
        function validarNumeroInputDocumento(input) {
            // Reemplaza cualquier carácter no numérico por una cadena vacía
            input.value = input.value.replace(/\D/g, '');

            // Limita la longitud del valor a 3 caracteres
            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10);
            }
        }
    </script>
</body>
</html>