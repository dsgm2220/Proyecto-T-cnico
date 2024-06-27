<?php
include("Modelo/conec_BD.php");
session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION["cargo"])) {
    header("Location: Login.php");
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Vista/Estilo/Pagina_principal.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/5038b205c4.js" crossorigin="anonymous"></script>
    <link rel="shorcut icon" href="Vista/IMG/escudo.png">
    <title>Pagina principal</title>
<style>
    #Bienvenida {
        display: none;
        position: absolute; 
        top: 83%;
        left:2%;
        padding: 10px 20px;
        background-color:  rgb(0, 57, 91);
        color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        font-size: 18px;
        z-index:2;
    }
    .show-animation {
    animation: Bienvenida 1s ease-in-out;
    }
    @keyframes Bienvenida {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
    }

    #desvanecer-barra {
        position: absolute;
        margin-top:6%;
        top: 0;
        left: 0;
        height: 5px; /* Altura de la barra de progreso */
        background-color: rgb(110, 179, 131); /* Color de fondo de la barra de progreso */
        z-index: 3; /* Asegura que la barra esté por encima de todo */
        animation: progressBar 8s linear; /* Duración y animación de la barra */
    }

    @keyframes progressBar {
        0% {
            width: 100%;
        }
        100% {
            width: 0;
        }
    }
    /*----------------- Estilos para el botón de agregar-----------------*/
    .agregarEventoBtn {
        background-color: #007BFF;
        color: #fff;
        border: none;
        padding: 2px 8px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 18px;
        transition: background-color 0.3s ease-in-out; /* Transición para el color de fondo del botón */
    }

    .agregarEventoBtn:hover {
        background-color: #0056b3; /* Cambia el color de fondo al pasar el mouse por encima */
    }
        .agregarDesempeñoBtn {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 2px 8px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease-in-out; /* Transición para el color de fondo del botón */
        }

        .agregarDesempeñoBtn:hover {
            background-color: #0056b3; /* Cambia el color de fondo al pasar el mouse por encima */
        }
                .agregarEventoBtnEst {
                    background-color: #007BFF;
                    color: #fff;
                    border: none;
                    padding: 2px 8px;
                    cursor: pointer;
                    border-radius: 5px;
                    font-size: 18px;
                    transition: background-color 0.3s ease-in-out; /* Transición para el color de fondo del botón */
                }

                .agregarEventoBtnEst:hover {
                    background-color: #0056b3; /* Cambia el color de fondo al pasar el mouse por encima */
                }
                .agregarDesempeñoBtnEst {
                    background-color: #007BFF;
                    color: #fff;
                    border: none;
                    padding: 2px 8px;
                    cursor: pointer;
                    border-radius: 5px;
                    font-size: 18px;
                    transition: background-color 0.3s ease-in-out; /* Transición para el color de fondo del botón */
                }

                .agregarDesempeñoBtnEst:hover {
                    background-color: #0056b3; /* Cambia el color de fondo al pasar el mouse por encima */
                }

    .custom-notification {
        background-color: #4CAF50;
        color: white;
        text-align: center;
        padding: 10px;
        position: fixed;
        top: 83%;
        left: 50%;
        transform: translateX(-50%);
        display: none;
        width: 25%;
        z-index: 9999;
        border-radius: 5px;
    }

    .custom-notification.show {
        display: block;
        animation: fadeOut 5s forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        100% { opacity: 0; display: none; }
    }
</style>
</head>
<body>
<nav>
        <ul class="menu">
            <img src="Vista/IMG/escudo.png" width="100px" height="110px">
                <li><a href="Pagina_principal.php" id="Navegador"><i class="fa-solid fa-house"></i> Inicio</a></li>
                <?php
                if($Cargo == "Rector(a)"){
                    ?>
                        <li>
                            <a href=""><i class="fa-regular fa-pen-to-square"></i> Registros</a>
                            <ul class="menu-vertical">
                                <li><a href="Vista/Registra_cur.php" ><i class="fa-regular fa-pen-to-square"></i> Registrar Curso</a></li>
                                <li><a href="Vista/Registra_mat.php" ><i class="fa-regular fa-pen-to-square"></i> Registrar Materias</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="fa-solid fa-wrench"></i> Gestiones</a>
                            <ul class="menu-vertical">
                                <li><a href="Vista/Gestion_Direc.php"><i class="fa-solid fa-wrench"></i> Gestion de Directivos</a></li>
                                <li><a href="Vista/Gestion_Es.php"><i class="fa-solid fa-wrench"></i> Gestion de Estudiantes</a></li>
                                <li><a href="Vista/Gestion_Doc.php"><i class="fa-solid fa-wrench"></i> Gestion de Docentes</a></li>
                                <li><a href="Vista/Gestion_tiempo.php"><i class="fa-solid fa-wrench"></i> Gestion de Tiempo</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="Vista/Generar_Reporte.php" onclick="GR()"><i class="fa-regular fa-clipboard"></i> Generar reporte</a>
                        </li>
                    <?php
                }elseif($Cargo == "Coordinador(a)"){
                                        ?>
                        <li>
                            <a href=""><i class="fa-regular fa-pen-to-square"></i> Registros</a>
                            <ul class="menu-vertical">
                                <li><a href="Vista/Registra_cur.php" ><i class="fa-regular fa-pen-to-square"></i> Registrar Curso</a></li>
                                <li><a href="Vista/Registra_mat.php" ><i class="fa-regular fa-pen-to-square"></i> Registrar Materias</a></li>
                            </ul>
                        </li>
                        <li >
                            <a href=""><i class="fa-solid fa-wrench"></i> Gestiones</a>
                            <ul class="menu-vertical">
                                <li><a href=""  class="subrayar-cursiva"><i class="fa-solid fa-wrench"></i> Gestion de Directivos</a></li>
                                <li><a href="Vista/Gestion_Es.php" ><i class="fa-solid fa-wrench"></i> Gestion de Estudiantes</a></li>
                                <li><a href="Vista/Gestion_Doc.php"><i class="fa-solid fa-wrench"></i> Gestion de Docentes</a></li>
                                <li><a href="Vista/Gestion_tiempo.php"><i class="fa-solid fa-wrench"></i> Gestion de Tiempo</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="Vista/Generar_Reporte.php" onclick="GR()"><i class="fa-regular fa-clipboard"></i> Generar reporte</a>
                        </li>
                    <?php
                }elseif($Cargo == "Estudiante" || $Cargo == "Docente"){
                    ?>
                    <li>
                    <a href="" class="subrayar-cursiva"><i class="fa-regular fa-pen-to-square"></i> Registros</a>
                    </li>
                    <li>
                        <a href="" class="subrayar-cursiva"><i class="fa-solid fa-wrench"></i> Gestiones</a>
                    </li>
                    <li>
                        <a href="" class="subrayar-cursiva"><i class="fa-regular fa-clipboard"></i> Generar reporte</a>
                    </li>
                
                    <?php
                }
                ?>
                <div class="profile-container">
                        <div class="user-details" >
                            <img src="Vista/IMG/perfil-del-usuario (1).png" alt="Imagen de perfil" class="profile-image">
                            <div class="profile-info">
                                <strong><?php echo $usuario; ?></strong>
                                    <p class="profile-title"><?php echo $Cargo; ?></p>
                                    <a href="Controlador/Logout.php" class="logout-link" ><i class="fa-solid fa-right-to-bracket"></i>Cerrar sesión</a>
                            </div>
                        </div>
                </div>
        </ul>
</nav>
<header>
        <div class="header-contenido">
            <h1 class="page-titulo">
                    <span class="curso-label">Curso:</span>
                    <?php
                    if(isset($_POST["buscarBtn"])){
                        $curso = isset($_POST['Numero_curso_pertenece']) ? $_POST['Numero_curso_pertenece'] : null; 
                        if (isset($curso)) {
                            echo '<span class="curso-nombre">' . $curso . '</span>';
                        } else {
                            echo ""; 
                        }
                    }
                    ?>
                    <span class="curso-label">Materia:</span>
                    <?php
                    if(isset($_POST["buscarBtn"])){
                        $materiaId = isset($_POST['materia_Registrar']) ? $_POST['materia_Registrar'] : null; 
                        if (isset($materiaId)) {
                            echo '<span class="curso-nombre">' . $materiaId . '</span>';
                        } else {
                            echo "";
                        }
                    }
                    ?>
            </h1>       
                <form method="post" class="select-contenedor">
                    <div class="select" id="trimestre_Tamaño">
                        <select id="trimestre" name="trimestre">
                            <option value="Primer Trimestre">Primer Trimestre</option>
                            <option value="Segundo Trimestre">Segundo Trimestre</option>
                            <option value="Tercer Trimestre">Tercer Trimestre</option>
                        </select>
                    </div>
                    <div class="select">
                        <select  id='cursoSelect' name="Numero_curso_pertenece">
                            <?php
                        $consulta= "SELECT * FROM cursos ORDER BY Numero_Curso ASC; ";
                            $result= $conex->query($consulta);
                            echo "<option selected disabled>Curso</option>";
                            while ($row = $result->fetch_assoc()){
                                echo '<option value="' . $row['Numero_Curso'] . '" >' . $row['Numero_Curso'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="select">
                        <select name="materia_Registrar" id="materiaSelect">
                            <?php
                            $consulta= "SELECT * FROM materias; ";
                            $result= $conex->query($consulta);
                            echo "<option selected disabled>Materia</option>";
                            while ($row = $result->fetch_assoc()){
                                echo '<option value="' . $row['Nombre_Materias'] . '" >' . $row['Nombre_Materias'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="buscar-button">
                        <button class="buscarBtn" name="buscarBtn" id="buscarBtn"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                </form>
        </div>
    </header>

    <section>
<!-- En caso de ser Estudiante o Admin Academico muestra el nombre del profesor que dicta la materia  -->
    <?php
        if($Cargo == "Estudiante" || $Cargo == "Rector(a)" || $Cargo == "Coordinador(a)"  ){
            if(isset($materiaId)){
                // Realiza una consulta para obtener el nombre del docente asignado a esta materia
                $consultaDocente = $miPDO->prepare("SELECT Nombre_Docente, Nombre_Docente_2, Apellido_Docente, Apellido_Docente_2 FROM docentes WHERE Nombre_Materia_Asignada LIKE :materiaNombre AND Numero_curso_asignado LIKE :numeroCurso");
                $consultaDocente->bindValue(':materiaNombre', '%"'.$materiaId.'"%', PDO::PARAM_STR);
                $consultaDocente->bindValue(':numeroCurso', '%"'.$curso.'"%', PDO::PARAM_STR);
                $consultaDocente->execute();

                    if ($consultaDocente->rowCount() > 0) {
                        $docenteInfo = $consultaDocente->fetch();
                        $primerNombre = $docenteInfo['Nombre_Docente'];
                        $segundoNombre = $docenteInfo['Nombre_Docente_2'];
                        $primerApellido = $docenteInfo['Apellido_Docente'];
                        $segundoApellido = $docenteInfo['Apellido_Docente_2'];

                        // Puedes usar estas variables en tu HTML para mostrar el nombre del docente asignado a esta materia
                        echo '<h4 id="nomDocente">Docente: '.$primerNombre.' '.$segundoNombre.' '.$primerApellido.' '.$segundoApellido.'</h4>';
                    }
                }
            }
    ?>      
        <form action="" method="post" id="notas">
            <br>
            <table border="collapse">
                <tr>
                    <th rowspan="3">N°</th>
                    <th rowspan="2"></th>
                    <th colspan="10">Heteroevalución</th>
                    <th rowspan="3" colspan="2" style="width:10%;">70%</th>
                    <th rowspan="3">Auto</th>
                    <th rowspan="3">5%</th>
                    <th rowspan="3">Coev</th>
                    <th rowspan="3">5%</th>
                    <th rowspan="3">Eva.T</th>
                    <th rowspan="3">20%</th>
                    <th rowspan="3">Deft</th>
                    <th colspan="5" rowspan="2">Desempeños</th>
                    
                </tr>
                <tr>
                    <th colspan="10">Descripción de Actividad</th>
                </tr>
                <tr> 
                    <th><p>Apellidos y Nombres</p></th>
                    <?php
                    if($Cargo == "Docente" || $Cargo == "Rector(a)" || $Cargo == "Coordinador(a)"){
                        ?>
                            <th><input type="button" value="1" class="agregarEventoBtn"  data-target="eventoMostrado1" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="2" class="agregarEventoBtn"  data-target="eventoMostrado2" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="3" class="agregarEventoBtn"  data-target="eventoMostrado3" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="4" class="agregarEventoBtn"  data-target="eventoMostrado4" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="5" class="agregarEventoBtn"  data-target="eventoMostrado5" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="6" class="agregarEventoBtn"  data-target="eventoMostrado6" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="7" class="agregarEventoBtn"  data-target="eventoMostrado7" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="8" class="agregarEventoBtn"  data-target="eventoMostrado8" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="9" class="agregarEventoBtn"  data-target="eventoMostrado9" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="10" class="agregarEventoBtn"  data-target="eventoMostrado10" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="1" class="agregarDesempeñoBtn" data-target="D1" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="2" class="agregarDesempeñoBtn" data-target="D2" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="3" class="agregarDesempeñoBtn" data-target="D3" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="4" class="agregarDesempeñoBtn" data-target="D4" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                            <th><input type="button" value="5" class="agregarDesempeñoBtn" data-target="D5" data-materia-id="<?php echo $materiaId; ?>" data-curso-id="<?php echo $curso; ?>"></th>
                        <?php
                    }else{
                        ?>
                            <th><input type="button" value="1" class="agregarEventoBtnEst"></th>
                            <th><input type="button" value="2" class="agregarEventoBtnEst"></th>
                            <th><input type="button" value="3" class="agregarEventoBtnEst"></th>
                            <th><input type="button" value="4" class="agregarEventoBtnEst"></th>
                            <th><input type="button" value="5" class="agregarEventoBtnEst"></th>
                            <th><input type="button" value="6" class="agregarEventoBtnEst"></th>
                            <th><input type="button" value="7" class="agregarEventoBtnEst"></th>
                            <th><input type="button" value="8" class="agregarEventoBtnEst"></th>
                            <th><input type="button" value="9" class="agregarEventoBtnEst"></th>
                            <th><input type="button" value="10" class="agregarEventoBtnEst"></th>
                            <th><input type="button" value="1" class="agregarDesempeñoBtnEst"></th>
                            <th><input type="button" value="2" class="agregarDesempeñoBtnEst"></th>
                            <th><input type="button" value="3" class="agregarDesempeñoBtnEst"></th>
                            <th><input type="button" value="4" class="agregarDesempeñoBtnEst"></th>
                            <th><input type="button" value="5" class="agregarDesempeñoBtnEst"></th>
                        <?php
                    }
                    ?>
                    
                </tr>   
<?php

// Obtén la fecha actual
$today = date("Y-m-d");

// Comprobar si el formulario ha sido enviado
if(isset($_POST["buscarBtn"])){
    // Capturar el número de curso y la materia del formulario
    $curso = isset($_POST['Numero_curso_pertenece']) ? $_POST['Numero_curso_pertenece'] : null;
    $materiaId = isset($_POST['materia_Registrar']) ? $_POST['materia_Registrar'] : null;
    $trimestre = isset($_POST['trimestre']) ? $_POST['trimestre'] : null;
    $errores=[];// Inicializar un array para almacenar errores

    // Verificar si se proporcionaron valores válidos para curso y materia
    if (isset($curso) && isset($materiaId)) {

        // Comprobar si el usuario tiene el rol "Docente" por medio de la varable de session $Cargo
        if($Cargo == "Docente"){

        // Realiza una consulta SQL para obtener las fechas del trimestre seleccionado
        $sql = "SELECT fecha_inicio, fecha_finalizacion FROM trimestres WHERE nombre_trimestre = :trimestre";
        $consulta = $miPDO->prepare($sql);
        $consulta->bindParam(':trimestre', $trimestre);
        $consulta->execute();
        $trimestreData = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($trimestreData) {
        $fechaInicio = $trimestreData['fecha_inicio'];
        $fechaFinalizacion = $trimestreData['fecha_finalizacion'];

        // Verificar si la fecha actual está dentro del rango del trimestre
        if ($today >= $fechaInicio && $today <= $fechaFinalizacion) {

        // Realizar una consulta para obtener información del docente
        $consultaAsignaciones = $miPDO->prepare("SELECT * FROM docentes WHERE Documento_Docente = :documentoDocente");
        $consultaAsignaciones->bindParam(':documentoDocente', $documento);
        $consultaAsignaciones->execute();
        $docente = $consultaAsignaciones->fetch(PDO::FETCH_ASSOC);
    
        if ($docente) {
            // Decodificar el JSON de asignaciones del docente (cursos y materias)
            $asignacionesCurso = json_decode($docente['Numero_curso_asignado'], true);
            $asignacionesMateria = json_decode($docente['Nombre_Materia_Asignada'], true);
    
            // Verificar si el docente tiene asignado el curso y la materia seleccionados
            $asignacionEncontradaCurso = false;
            foreach ($asignacionesCurso as $asignacion) {
                if ($asignacion == $curso) {
                    $asignacionEncontradaCurso = true;
                    break;
                }
            }

            $asignacionEncontradaMateria = false;
            foreach ($asignacionesMateria as $asignacion) {
                if ($asignacion == $materiaId) {
                    $asignacionEncontradaMateria = true;
                    break;
                }
            }
        }
        // Si el docente tiene asignado el curso y la materia, continuar con la operación
            if ($asignacionEncontradaCurso && $asignacionEncontradaMateria) {

                // Realizar una consulta para obtener información de los estudiantes del curso
                $miConsulta = $miPDO->prepare("SELECT * FROM estudiantes WHERE Numero_Curso_pertenece='$curso' ORDER BY Apellido_Estudiante ASC");
                $miConsulta->execute();
            
                $numeroEstudiante = 0; // Variable para llevar la cuenta del número de lista de estudiante

                // Obtener las notas y desempeños decodificadas una sola vez
                    $consultaNotas = $miPDO->prepare("SELECT Id_Est, Notas_heteroeva, Notas_autoevaluacion , Notas_coevaluacion , Notas_evaluacion ,desempeños FROM notas WHERE Nom_mat = :materia AND Num_cur =:curso AND trimestre=:trimestre");
                    $consultaNotas->bindParam(':materia', $materiaId);
                    $consultaNotas->bindParam(':curso', $curso);
                    $consultaNotas->bindParam(':trimestre', $trimestre);
                    $consultaNotas->execute();

                    // Recorrer la consulta de notas(desempeños) y decodificar las notas(desempeños)
                    foreach ($consultaNotas as $fila) {
                        $notasDecodificadas[$fila['Id_Est']] = json_decode($fila['Notas_heteroeva'], true);
                        $autoevaluaciones[$fila['Id_Est']] = json_decode($fila['Notas_autoevaluacion'], true);
                        $coevaluaciones[$fila['Id_Est']] = json_decode($fila['Notas_coevaluacion'], true);
                        $evaluaciones[$fila['Id_Est']] = json_decode($fila['Notas_evaluacion'], true);
                        $desempeñosDecodificados[$fila['Id_Est']] = json_decode($fila['desempeños'], true);
                    }

                    foreach ($miConsulta as $clave => $valor) {

                        $numeroEstudiante++; // Incrementa el número de estudiante en cada iteración
                        $activo = $valor['Activo']; // Verificar si el estudiante está inactivo
                        // Establecer la clase CSS para la fila según el estado de actividad
                        $filaClase = $activo == 0 ? 'inactivo' : '';
                        ?>
                        <tr class="<?php echo $filaClase; ?>">
                            <td><?php echo $numeroEstudiante; ?></td>
                            <td class="td-nom-ape">
                                <p class="<?php echo $filaClase; ?>">
                                    <span><?= $valor['Apellido_Estudiante'] ?> <?= $valor['Apellido_Estudiante_2'] ?>
                                        <?= $valor['Nombre_Estudiante'] ?> <?= $valor['Nombre_Estudiante_2'] ?></span>
                                </p>
                            </td>
                            <?php
                            // Verificar si existen notas y desempeños  para este estudiante
                            if (isset($notasDecodificadas[$valor['Id_estudiantes']]) && isset($desempeñosDecodificados[$valor['Id_estudiantes']]) && isset($autoevaluaciones[$valor['Id_estudiantes']]) && isset($coevaluaciones[$valor['Id_estudiantes']]) && isset($evaluaciones[$valor['Id_estudiantes']])) {
                                // Obtener las notas y desempeños del estudiante
                                $notasEstudiante = $notasDecodificadas[$valor['Id_estudiantes']];
                                $autoevaluacion = $autoevaluaciones[$valor['Id_estudiantes']];
                                $coevaluacion = $coevaluaciones[$valor['Id_estudiantes']];
                                $evaluacion = $evaluaciones[$valor['Id_estudiantes']];
                                $desempeñosEst = $desempeñosDecodificados[$valor['Id_estudiantes']];

                                        // Calcular el promedio solo entre las casillas donde haya algo escrito
                                        $notasEscritas = array_filter($notasEstudiante, function($nota) {
                                            return $nota !== '';// Filtra las notas que no sean una cadena vacía
                                        });
                                        
                                        // Verificar si hay notas escritas en el array $notasEscritas
                                        $promedio = !empty($notasEscritas) ? array_sum($notasEscritas) / count($notasEscritas) : 0.0;

                                        // Calcular el 5% solo entre las casillas de autoevaluacion donde haya algo escrito
                                        $notasEscritasAuto = array_filter($autoevaluacion, function($autoeval) {
                                            return $autoeval !== '';
                                        });

                                        $cincoPorCiento = !empty($notasEscritasAuto) ? floatval(array_sum($notasEscritasAuto) * 0.05) : 0.0;

                                        // Calcular el 5% solo entre las casillas de autoevaluacion donde haya algo escrito
                                        $notasEscritasCoe = array_filter($coevaluacion, function($coeval) {
                                            return $coeval !== '';
                                        });

                                        $cincoPorCientoCoe = !empty($notasEscritasCoe) ? floatval(array_sum($notasEscritasCoe) * 0.05) : 0.0;

                                        // Calcular el 20% solo entre las casillas de evaluacion donde haya algo escrito
                                        $notasEscritasEva = array_filter($evaluacion, function($evalua) {
                                            return $evalua !== '';
                                        });

                                        $veintePorCiento = !empty($notasEscritasEva) ? floatval(array_sum($notasEscritasEva) * 0.20) : 0.0;

                                        // Calcular la nota definitiva

                                        $notaDefinitiva = ($promedio * 0.7) + $cincoPorCiento + $cincoPorCientoCoe + $veintePorCiento;

                                    // Iterar a través de las notas y mostrarlas en las celdas
                                    foreach ($notasEstudiante as $nota) {
                                        echo '<td><input type="text" name="heteroeval[' . $valor['Id_estudiantes'] . '][]" value="' . $nota . '"  oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                    }

                                        // Mostrar el 70% de las notas si hay notas escritas
                                        if(!empty($notasEscritas)) {
                                            $setentaPorCiento = $promedio * 0.7;
                                            echo '<td>'.number_format($promedio,1).'</td>';
                                            echo '<td>' . number_format($setentaPorCiento, 1) . '</td>';
                                        }else {
                                            echo '<td></td>';
                                            echo '<td></td>';
                                        }

                                            //Mostrar la nota de autoevalucion en las celdas
                                            foreach ($autoevaluacion as $autoeval) {
                                                echo '<td><input type="text" name="autoevaluacion[' . $valor['Id_estudiantes'] . '][]" value="' . $autoeval . '" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                            }
                                            //Mostrar el 5% de la Autoevaluacion
                                            if(!empty($notasEscritasAuto)){
                                                echo '<td>'.number_format($cincoPorCiento,1).'</td>';
                                            }else {
                                                echo '<td></td>';
                                            }

                                            //Mostrar la nota de coevalucion en las celdas
                                            foreach ($coevaluacion as $coeval) {
                                                echo '<td><input type="text" name="coevaluacion[' . $valor['Id_estudiantes'] . '][]" value="' . $coeval . '" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                            }
                                            //Mostrar el 5% de la Autoevaluacion
                                            if(!empty($notasEscritasCoe)){
                                                echo '<td>'.number_format($cincoPorCientoCoe,1).'</td>';
                                            }else {
                                                echo '<td></td>';
                                            }

                                            //Mostrar la nota de evalucion en las celdas
                                            foreach ($evaluacion as $evalua) {
                                                echo '<td><input type="text" name="evaluacion[' . $valor['Id_estudiantes'] . '][]" value="' . $evalua . '" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                            }
                                            //Mostrar el 20% de la evaluacion
                                            if(!empty($notasEscritasEva)){
                                                echo '<td>'.number_format($veintePorCiento,1).'</td>';
                                            }else {
                                                echo '<td></td>';
                                            }

                                            //Mostrar la definitiva 

                                            echo '<td>' . number_format($notaDefinitiva, 1) . '</td>';

                                    // Iterar a través de los desempeños y mostrarlos en las celdas
                                    foreach ($desempeñosEst as $desempeño) {
                                        echo '<td><input type="text" name="desempeño[' . $valor['Id_estudiantes'] . '][]" value="' . $desempeño . '"  oninput="validarLetrasSN(this)" autocomplete="off"></td>';
                                    }

                                }else{
                                    // Si no hay notas para este estudiante, mostrar celdas vacías
                                    for ($i = 0; $i < 10; $i++) {
                                        echo '<td><input type="text" name="heteroeval[' . $valor['Id_estudiantes'] . '][]" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                    }
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td><input type="text" name="autoevaluacion[' . $valor['Id_estudiantes'] . '][]" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                    echo '<td></td>';
                                    echo '<td><input type="text" name="coevaluacion[' . $valor['Id_estudiantes'] . '][]" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                    echo '<td></td>';
                                    echo '<td><input type="text" name="evaluacion[' . $valor['Id_estudiantes'] . '][]" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    for ($i = 0; $i < 5; $i++) {
                                        echo '<td><input type="text" name="desempeño[' . $valor['Id_estudiantes'] . '][]" oninput="validarLetrasSN(this)" autocomplete="off"></td>';
                                    }
                                }
                                ?>
                                <input type="hidden" name="notaDefinitiva[<?php echo $valor['Id_estudiantes']; ?>]" value="<?php echo $notaDefinitiva; ?>">
                                <input type="hidden" name="materiaEstudiante[<?php echo $valor['Id_estudiantes']; ?>]" value="<?php echo $materiaId; ?>">
                                <input type="hidden" name="cursoEstudiante[<?php echo $valor['Id_estudiantes']; ?>]" value="<?php echo $curso; ?>">
                                <input type="hidden" name="trimestre[<?php echo $valor['Id_estudiantes']; ?>]" value="<?php echo $trimestre; ?>">
                            </tr>
                            <?php
                        }
                    //Si no tiene asignado ese curso o materia almacenar "No tienes permiso de registrar notas para este curso o materia" en el array errores
                    }else{
                        $errores[]="No tienes permiso de registrar notas para este curso o materia";
                    }
                }else{
                    // La fecha está fuera del rango del trimestre, muestra un mensaje de error
                    $errores[] = "La fecha límite para registrar notas en $trimestre ha pasado.";
                }   
            }
//Si su Cargo es Administrativo tendra acceso a las notas sin ninguna restriccion
        }elseif($Cargo == "Rector(a)" || $Cargo == "Coordinador(a)"){
                // Realizar una consulta para obtener información de los estudiantes del curso
                $miConsulta = $miPDO->prepare("SELECT * FROM estudiantes WHERE Numero_Curso_pertenece='$curso' ORDER BY Apellido_Estudiante ASC");
                $miConsulta->execute();
            
                $numeroEstudiante = 0; // Variable para llevar la cuenta del número de lista de estudiante

                // Obtener las notas y desempeños decodificadas una sola vez
                    $consultaNotas = $miPDO->prepare("SELECT Id_Est, Notas_heteroeva, Notas_autoevaluacion , Notas_coevaluacion , Notas_evaluacion ,desempeños FROM notas WHERE Nom_mat = :materia AND Num_cur =:curso AND trimestre=:trimestre");
                    $consultaNotas->bindParam(':materia', $materiaId);
                    $consultaNotas->bindParam(':curso', $curso);
                    $consultaNotas->bindParam(':trimestre', $trimestre);
                    $consultaNotas->execute();

                    // Recorrer la consulta de notas(desempeños) y decodificar las notas(desempeños)
                    foreach ($consultaNotas as $fila) {
                        $notasDecodificadas[$fila['Id_Est']] = json_decode($fila['Notas_heteroeva'], true);
                        $autoevaluaciones[$fila['Id_Est']] = json_decode($fila['Notas_autoevaluacion'], true);
                        $coevaluaciones[$fila['Id_Est']] = json_decode($fila['Notas_coevaluacion'], true);
                        $evaluaciones[$fila['Id_Est']] = json_decode($fila['Notas_evaluacion'], true);
                        $desempeñosDecodificados[$fila['Id_Est']] = json_decode($fila['desempeños'], true);
                    }

                    foreach ($miConsulta as $clave => $valor) {

                        $numeroEstudiante++; // Incrementa el número de estudiante en cada iteración
                        $activo = $valor['Activo']; // Verificar si el estudiante está inactivo
                        // Establecer la clase CSS para la fila según el estado de actividad
                        $filaClase = $activo == 0 ? 'inactivo' : '';
                        ?>
                        <tr class="<?php echo $filaClase; ?>">
                            <td><?php echo $numeroEstudiante; ?></td>
                            <td class="td-nom-ape">
                                <p class="<?php echo $filaClase; ?>">
                                    <span><?= $valor['Apellido_Estudiante'] ?> <?= $valor['Apellido_Estudiante_2'] ?>
                                        <?= $valor['Nombre_Estudiante'] ?> <?= $valor['Nombre_Estudiante_2'] ?></span>
                                </p>
                            </td>
                            <?php
                            // Verificar si existen notas y desempeños  para este estudiante
                            if (isset($notasDecodificadas[$valor['Id_estudiantes']]) && isset($desempeñosDecodificados[$valor['Id_estudiantes']]) && isset($autoevaluaciones[$valor['Id_estudiantes']]) && isset($coevaluaciones[$valor['Id_estudiantes']]) && isset($evaluaciones[$valor['Id_estudiantes']])) {
                                // Obtener las notas y desempeños del estudiante actual
                                $notasEstudiante = $notasDecodificadas[$valor['Id_estudiantes']];
                                $autoevaluacion = $autoevaluaciones[$valor['Id_estudiantes']];
                                $coevaluacion = $coevaluaciones[$valor['Id_estudiantes']];
                                $evaluacion = $evaluaciones[$valor['Id_estudiantes']];
                                $desempeñosEst = $desempeñosDecodificados[$valor['Id_estudiantes']];

                                        // Calcular el promedio solo entre las casillas donde haya algo escrito
                                        $notasEscritas = array_filter($notasEstudiante, function($nota) {
                                            return $nota !== '';// Filtra las notas que no sean una cadena vacía
                                        });
                                        
                                        // Verificar si hay notas escritas en el array $notasEscritas
                                        $promedio = !empty($notasEscritas) ? array_sum($notasEscritas) / count($notasEscritas) : 0.0;

                                        // Calcular el 5% solo entre las casillas de autoevaluacion donde haya algo escrito
                                        $notasEscritasAuto = array_filter($autoevaluacion, function($autoeval) {
                                            return $autoeval !== '';
                                        });

                                        $cincoPorCiento = !empty($notasEscritasAuto) ? floatval(array_sum($notasEscritasAuto) * 0.05) : 0.0;

                                        // Calcular el 5% solo entre las casillas de autoevaluacion donde haya algo escrito
                                        $notasEscritasCoe = array_filter($coevaluacion, function($coeval) {
                                            return $coeval !== '';
                                        });

                                        $cincoPorCientoCoe = !empty($notasEscritasCoe) ? floatval(array_sum($notasEscritasCoe) * 0.05) : 0.0;

                                        // Calcular el 20% solo entre las casillas de evaluacion donde haya algo escrito
                                        $notasEscritasEva = array_filter($evaluacion, function($evalua) {
                                            return $evalua !== '';
                                        });

                                        $veintePorCiento = !empty($notasEscritasEva) ? floatval(array_sum($notasEscritasEva) * 0.20) : 0.0;

                                        // Calcular la nota definitiva

                                        $notaDefinitiva = ($promedio * 0.7) + $cincoPorCiento + $cincoPorCientoCoe + $veintePorCiento;

                                    // Iterar a través de las notas y mostrarlas en las celdas
                                    foreach ($notasEstudiante as $nota) {
                                        echo '<td><input type="text" name="heteroeval[' . $valor['Id_estudiantes'] . '][]" value="' . $nota . '"  oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                    }

                                        // Mostrar el 70% de las notas si hay notas escritas
                                        if(!empty($notasEscritas)) {
                                            $setentaPorCiento = $promedio * 0.7;
                                            echo '<td>'.number_format($promedio,1).'</td>';
                                            echo '<td>' . number_format($setentaPorCiento, 1) . '</td>';
                                        }else {
                                            echo '<td></td>';
                                            echo '<td></td>';
                                        }

                                            //Mostrar la nota de autoevalucion en las celdas
                                            foreach ($autoevaluacion as $autoeval) {
                                                echo '<td><input type="text" name="autoevaluacion[' . $valor['Id_estudiantes'] . '][]" value="' . $autoeval . '" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                            }
                                            //Mostrar el 5% de la Autoevaluacion
                                            if(!empty($notasEscritasAuto)){
                                                echo '<td>'.number_format($cincoPorCiento,1).'</td>';
                                            }else {
                                                echo '<td></td>';
                                            }

                                            //Mostrar la nota de coevalucion en las celdas
                                            foreach ($coevaluacion as $coeval) {
                                                echo '<td><input type="text" name="coevaluacion[' . $valor['Id_estudiantes'] . '][]" value="' . $coeval . '" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                            }
                                            //Mostrar el 5% de la Autoevaluacion
                                            if(!empty($notasEscritasCoe)){
                                                echo '<td>'.number_format($cincoPorCientoCoe,1).'</td>';
                                            }else {
                                                echo '<td></td>';
                                            }

                                            //Mostrar la nota de evalucion en las celdas
                                            foreach ($evaluacion as $evalua) {
                                                echo '<td><input type="text" name="evaluacion[' . $valor['Id_estudiantes'] . '][]" value="' . $evalua . '" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                            }
                                            //Mostrar el 20% de la evaluacion
                                            if(!empty($notasEscritasEva)){
                                                echo '<td>'.number_format($veintePorCiento,1).'</td>';
                                            }else {
                                                echo '<td></td>';
                                            }

                                            //Mostrar la definitiva 

                                            echo '<td>' . number_format($notaDefinitiva, 1) . '</td>';

                                    // Iterar a través de los desempeños y mostrarlos en las celdas
                                    foreach ($desempeñosEst as $desempeño) {
                                        echo '<td><input type="text" name="desempeño[' . $valor['Id_estudiantes'] . '][]" value="' . $desempeño . '"  oninput="validarLetrasSN(this)" autocomplete="off"></td>';
                                    }

                                }else{
                                    // Si no hay notas para este estudiante, mostrar celdas vacías
                                    for ($i = 0; $i < 10; $i++) {
                                        echo '<td><input type="text" name="heteroeval[' . $valor['Id_estudiantes'] . '][]" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                    }
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td><input type="text" name="autoevaluacion[' . $valor['Id_estudiantes'] . '][]" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                    echo '<td></td>';
                                    echo '<td><input type="text" name="coevaluacion[' . $valor['Id_estudiantes'] . '][]" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                    echo '<td></td>';
                                    echo '<td><input type="text" name="evaluacion[' . $valor['Id_estudiantes'] . '][]" oninput="validarNumeroInput(this)" autocomplete="off"></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    for ($i = 0; $i < 5; $i++) {
                                        echo '<td><input type="text" name="desempeño[' . $valor['Id_estudiantes'] . '][]" oninput="validarLetrasSN(this)" autocomplete="off"></td>';
                                    }
                                }
                                ?>
                                <input type="hidden" name="notaDefinitiva[<?php echo $valor['Id_estudiantes']; ?>]" value="<?php echo $notaDefinitiva; ?>">
                                <input type="hidden" name="materiaEstudiante[<?php echo $valor['Id_estudiantes']; ?>]" value="<?php echo $materiaId; ?>">
                                <input type="hidden" name="cursoEstudiante[<?php echo $valor['Id_estudiantes']; ?>]" value="<?php echo $curso; ?>">
                                <input type="hidden" name="trimestre[<?php echo $valor['Id_estudiantes']; ?>]" value="<?php echo $trimestre; ?>">
                            </tr>
                            <?php
                        }
//Si su Cargo es Estudiante tendra acceso a solo ver las notas del curso al que pertenece 
            }elseif($Cargo == "Estudiante"){

                $miConsulta = $miPDO->prepare("SELECT * FROM estudiantes WHERE Documento_Estudiante='$documento'");
                $miConsulta->execute();

                foreach ($miConsulta as $clave => $valor) {
                    $perteneceCurso=$valor['Numero_Curso_pertenece'];
                }

                if($perteneceCurso == $curso){
                    // Realizar una consulta para obtener información de las notas del  estudiante del curso
                $miConsulta = $miPDO->prepare("SELECT * FROM estudiantes WHERE Numero_Curso_pertenece='$curso' AND Documento_Estudiante='$documento' ORDER BY Apellido_Estudiante ASC");
                $miConsulta->execute();
            
                $numeroEstudiante = 0; // Variable para llevar la cuenta del número de lista de estudiante

                // Obtener las notas y desempeños decodificadas una sola vez
                    $consultaNotas = $miPDO->prepare("SELECT Id_Est, Notas_heteroeva, Notas_autoevaluacion , Notas_coevaluacion , Notas_evaluacion ,desempeños FROM notas WHERE Nom_mat = :materia AND Num_cur =:curso AND trimestre=:trimestre");
                    $consultaNotas->bindParam(':materia', $materiaId);
                    $consultaNotas->bindParam(':curso', $curso);
                    $consultaNotas->bindParam(':trimestre', $trimestre);
                    $consultaNotas->execute();

                    // Recorrer la consulta de notas(desempeños) y decodificar las notas(desempeños)
                    foreach ($consultaNotas as $fila) {
                        $notasDecodificadas[$fila['Id_Est']] = json_decode($fila['Notas_heteroeva'], true);
                        $autoevaluaciones[$fila['Id_Est']] = json_decode($fila['Notas_autoevaluacion'], true);
                        $coevaluaciones[$fila['Id_Est']] = json_decode($fila['Notas_coevaluacion'], true);
                        $evaluaciones[$fila['Id_Est']] = json_decode($fila['Notas_evaluacion'], true);
                        $desempeñosDecodificados[$fila['Id_Est']] = json_decode($fila['desempeños'], true);
                    }

                    foreach ($miConsulta as $clave => $valor) {

                        $numeroEstudiante++; // Incrementa el número de estudiante en cada iteración
                        $activo = $valor['Activo']; // Verificar si el estudiante está inactivo
                        // Establecer la clase CSS para la fila según el estado de actividad
                        $filaClase = $activo == 0 ? 'inactivo' : '';
                        ?>
                        <tr class="<?php echo $filaClase; ?>">
                            <td><?php echo $numeroEstudiante; ?></td>
                            <td class="td-nom-ape">
                                <p class="<?php echo $filaClase; ?>">
                                    <span><?= $valor['Apellido_Estudiante'] ?> <?= $valor['Apellido_Estudiante_2'] ?>
                                        <?= $valor['Nombre_Estudiante'] ?> <?= $valor['Nombre_Estudiante_2'] ?></span>
                                </p>
                            </td>
                            <?php
                            // Verificar si existen notas y desempeños  para este estudiante
                            if (isset($notasDecodificadas[$valor['Id_estudiantes']]) && isset($desempeñosDecodificados[$valor['Id_estudiantes']]) && isset($autoevaluaciones[$valor['Id_estudiantes']]) && isset($coevaluaciones[$valor['Id_estudiantes']]) && isset($evaluaciones[$valor['Id_estudiantes']])) {
                                // Obtener las notas y desempeños del estudiante
                                $notasEstudiante = $notasDecodificadas[$valor['Id_estudiantes']];
                                $autoevaluacion = $autoevaluaciones[$valor['Id_estudiantes']];
                                $coevaluacion = $coevaluaciones[$valor['Id_estudiantes']];
                                $evaluacion = $evaluaciones[$valor['Id_estudiantes']];
                                $desempeñosEst = $desempeñosDecodificados[$valor['Id_estudiantes']];

                                        // Calcular el promedio solo entre las casillas donde haya algo escrito
                                        $notasEscritas = array_filter($notasEstudiante, function($nota) {
                                            return $nota !== '';// Filtra las notas que no sean una cadena vacía
                                        });
                                        
                                        // Verificar si hay notas escritas en el array $notasEscritas
                                        $promedio = !empty($notasEscritas) ? array_sum($notasEscritas) / count($notasEscritas) : 0.0;

                                        // Calcular el 5% solo entre las casillas de autoevaluacion donde haya algo escrito
                                        $notasEscritasAuto = array_filter($autoevaluacion, function($autoeval) {
                                            return $autoeval !== '';
                                        });

                                        $cincoPorCiento = !empty($notasEscritasAuto) ? floatval(array_sum($notasEscritasAuto) * 0.05) : 0.0;

                                        // Calcular el 5% solo entre las casillas de autoevaluacion donde haya algo escrito
                                        $notasEscritasCoe = array_filter($coevaluacion, function($coeval) {
                                            return $coeval !== '';
                                        });

                                        $cincoPorCientoCoe = !empty($notasEscritasCoe) ? floatval(array_sum($notasEscritasCoe) * 0.05) : 0.0;

                                        // Calcular el 20% solo entre las casillas de evaluacion donde haya algo escrito
                                        $notasEscritasEva = array_filter($evaluacion, function($evalua) {
                                            return $evalua !== '';
                                        });

                                        $veintePorCiento = !empty($notasEscritasEva) ? floatval(array_sum($notasEscritasEva) * 0.20) : 0.0;

                                        // Calcular la nota definitiva

                                        $notaDefinitiva = ($promedio * 0.7) + $cincoPorCiento + $cincoPorCientoCoe + $veintePorCiento;

                                    // Iterar a través de las notas y mostrarlas en las celdas
                                    foreach ($notasEstudiante as $nota) {
                                        echo '<td><input type="text" value="' . $nota . '" disabled></td>';
                                    }

                                        // Mostrar el 70% de las notas si hay notas escritas
                                        if(!empty($notasEscritas)) {
                                            $setentaPorCiento = $promedio * 0.7;
                                            echo '<td>'.number_format($promedio,1).'</td>';
                                            echo '<td>' . number_format($setentaPorCiento, 1) . '</td>';
                                        }else {
                                            echo '<td></td>';
                                            echo '<td></td>';
                                        }

                                            //Mostrar la nota de autoevalucion en las celdas
                                            foreach ($autoevaluacion as $autoeval) {
                                                echo '<td><input type="text"  value="' . $autoeval . '" disabled></td>';
                                            }
                                            //Mostrar el 5% de la Autoevaluacion
                                            if(!empty($notasEscritasAuto)){
                                                echo '<td>'.number_format($cincoPorCiento,1).'</td>';
                                            }else {
                                                echo '<td></td>';
                                            }

                                            //Mostrar la nota de coevalucion en las celdas
                                            foreach ($coevaluacion as $coeval) {
                                                echo '<td><input type="text"  value="' . $coeval . '" disabled></td>';
                                            }
                                            //Mostrar el 5% de la Autoevaluacion
                                            if(!empty($notasEscritasCoe)){
                                                echo '<td>'.number_format($cincoPorCientoCoe,1).'</td>';
                                            }else {
                                                echo '<td></td>';
                                            }

                                            //Mostrar la nota de evalucion en las celdas
                                            foreach ($evaluacion as $evalua) {
                                                echo '<td><input type="text"  value="' . $evalua . '" disabled></td>';
                                            }
                                            //Mostrar el 20% de la evaluacion
                                            if(!empty($notasEscritasEva)){
                                                echo '<td>'.number_format($veintePorCiento,1).'</td>';
                                            }else {
                                                echo '<td></td>';
                                            }

                                            //Mostrar la definitiva 

                                            echo '<td>' . number_format($notaDefinitiva, 1) . '</td>';

                                    // Iterar a través de los desempeños y mostrarlos en las celdas
                                    foreach ($desempeñosEst as $desempeño) {
                                        echo '<td><input type="text"  value="' . $desempeño . '" disabled></td>';
                                    }

                                }else{
                                    // Si no hay notas para este estudiante, mostrar celdas vacías
                                    for ($i = 0; $i < 10; $i++) {
                                        echo '<td><input type="text"  disabled></td>';
                                    }
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td><input type="text"  disabled></td>';
                                    echo '<td></td>';
                                    echo '<td><input type="text"  disabled></td>';
                                    echo '<td></td>';
                                    echo '<td><input type="text" disabled></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    for ($i = 0; $i < 5; $i++) {
                                        echo '<td><input type="text" disabled></td>';
                                    }
                                }
                                ?>
                            </tr>
                            <?php
                        }
                }else{
                        $errores[]="No puedes ver las notas si no perteneces a este curso";
                }
            }
//Si no recibe se proporcionaron valores válidos para curso y materia guarda "Por favor, selecciona un curso y una materia para poder registrar las notas" en el array errores
    }else{
        $errores[]="Por favor, selecciona un curso y una materia para poder registrar las notas";
    } 
}

?>
            </table>
<!--El boton de guardar no le aparece al Estudiante  -->
        <?php
        if($Cargo == "Docente" || $Cargo == "Rector(a)" || $Cargo == "Coordinador(a)" ){
            ?>
                <input type="submit" value="Guardar" id="guardarNotasBtn" name="Guardar">
            <?php
        }else{
            echo '';
        }
        ?>
        </form>
        <!-- Elemento div para mostrar los mensajes -->
        <div id="notification" class="custom-notification">Notas guardadas correctamente</div>
</section>

<!-- INSERTAR LAS NOTAS AL PRESIONAR EL BOTON GUARDAR y INSERTAR LOS EVENTOS AL RECIBIR LOS DATOS DE AJAX -->
        <?php
//-----------------Proceso php guardar las notas de heteroevaluacion, auto, coe y definitiva en base de datos-------------------//

            if (isset($_POST["Guardar"])) {
                $notasHetero = isset($_POST['heteroeval']) ? $_POST['heteroeval'] : null;
                $notasAuto = isset($_POST['autoevaluacion']) ? $_POST['autoevaluacion'] : null;
                $notasCoe = isset($_POST['coevaluacion']) ? $_POST['coevaluacion'] : null;
                $notasEva = isset($_POST['evaluacion']) ? $_POST['evaluacion'] : null;
                $notaDeft = isset($_POST['notaDefinitiva']) ? $_POST['notaDefinitiva'] : null;
                $desempeño = isset($_POST['desempeño']) ? $_POST['desempeño'] : null;

                if (!empty($notasHetero)) {
                    foreach ($notasHetero as $id_estudiante => $notas_estudiante) {
                        $materiaSeleccionada = isset($_POST['materiaEstudiante'][$id_estudiante]) ? $_POST['materiaEstudiante'][$id_estudiante] : null;
                        $cursoEstudiante = isset($_POST['cursoEstudiante'][$id_estudiante]) ? $_POST['cursoEstudiante'][$id_estudiante] : null;
                        $trimestreEstudiante = isset($_POST['trimestre'][$id_estudiante]) ? $_POST['trimestre'][$id_estudiante] : null;

                        // Verificar si ya existen notas para este estudiante en esta materia
                        $consultaExistente = $miPDO->prepare("SELECT * FROM notas WHERE Id_Est = :id_estudiante AND Nom_mat = :materia AND Num_cur = :curso AND trimestre =:trimestre");
                        $consultaExistente->bindParam(':id_estudiante', $id_estudiante);
                        $consultaExistente->bindParam(':materia', $materiaSeleccionada);
                        $consultaExistente->bindParam(':curso', $cursoEstudiante);
                        $consultaExistente->bindParam(':trimestre', $trimestreEstudiante);

                        $consultaExistente->execute();
                        $existeRegistro = $consultaExistente->fetch();

                        if ($existeRegistro) {
                            // Si existen registros, actualiza en lugar de insertar
                            $notasJSON = json_encode($notas_estudiante, JSON_UNESCAPED_UNICODE);
                            $actualizarNotas = $miPDO->prepare("UPDATE notas SET Notas_heteroeva = :heteroeval WHERE Id_Est = :id_estudiante AND Nom_mat = :materia AND Num_cur = :curso AND trimestre =:trimestre");
                            $actualizarNotas->bindParam(':id_estudiante', $id_estudiante);
                            $actualizarNotas->bindParam(':materia', $materiaSeleccionada);
                            $actualizarNotas->bindParam(':curso', $cursoEstudiante);
                            $actualizarNotas->bindParam(':trimestre', $trimestreEstudiante);
                            $actualizarNotas->bindParam(':heteroeval', $notasJSON);
                            $actualizarNotas->execute();
                        } else {
                            // Si no existen registros, inserta los nuevos
                            $notasJSON = json_encode($notas_estudiante, JSON_UNESCAPED_UNICODE);
                            $insertarNotas = $miPDO->prepare("INSERT INTO notas (Id_Est, Notas_heteroeva, Nom_mat, Num_cur , trimestre) VALUES (:id_estudiante, :heteroeval, :materia, :curso ,:trimestre)");
                            $insertarNotas->bindParam(':id_estudiante', $id_estudiante);
                            $insertarNotas->bindParam(':materia', $materiaSeleccionada);
                            $insertarNotas->bindParam(':curso', $cursoEstudiante);
                            $insertarNotas->bindParam(':trimestre', $trimestreEstudiante);
                            $insertarNotas->bindParam(':heteroeval', $notasJSON);
                            $insertarNotas->execute();
                        }

                            // Verificar si existen notas de autoevaluación,coe,evaluacion y definitiva
                            if (!empty($notasAuto) && isset($notasAuto[$id_estudiante]) && !empty($notasCoe) && isset($notasCoe[$id_estudiante]) && !empty($notasEva) && isset($notasEva[$id_estudiante]) && !empty($notaDeft) && isset($notaDeft[$id_estudiante])) {
                                
                                $autoevaluacionJSON = json_encode($notasAuto[$id_estudiante], JSON_UNESCAPED_UNICODE);
                                $evaluacionJSON = json_encode($notasEva[$id_estudiante], JSON_UNESCAPED_UNICODE);
                                $coevaluacionJSON = json_encode($notasCoe[$id_estudiante], JSON_UNESCAPED_UNICODE);
                                $notaDefinitiva = $notaDeft[$id_estudiante];

                                // Actualizar o insertar las notas de autoevaluación en la base de datos
                                $actualizarAutoevaluacion = $miPDO->prepare("UPDATE notas SET Notas_autoevaluacion = :autoevaluacion , Notas_coevaluacion = :coevaluacion , Notas_evaluacion = :evaluacion , Nota_Final = :notaDefinitiva WHERE Id_Est = :id_estudiante AND Nom_mat = :materia AND Num_cur = :curso AND trimestre =:trimestre");
                                $actualizarAutoevaluacion->bindParam(':id_estudiante', $id_estudiante);
                                $actualizarAutoevaluacion->bindParam(':materia', $materiaSeleccionada);
                                $actualizarAutoevaluacion->bindParam(':curso', $cursoEstudiante);
                                $actualizarAutoevaluacion->bindParam(':trimestre', $trimestreEstudiante);
                                $actualizarAutoevaluacion->bindParam(':autoevaluacion', $autoevaluacionJSON);
                                $actualizarAutoevaluacion->bindParam(':coevaluacion', $coevaluacionJSON);
                                $actualizarAutoevaluacion->bindParam(':evaluacion', $evaluacionJSON);
                                $actualizarAutoevaluacion->bindParam(':notaDefinitiva', $notaDefinitiva);
                                $actualizarAutoevaluacion->execute();
                            }
                    }
                    foreach ($desempeño as $id_estudiante => $desempeño_estudiante) {
                        $materiaSeleccionada = isset($_POST['materiaEstudiante'][$id_estudiante]) ? $_POST['materiaEstudiante'][$id_estudiante] : null;
                        $cursoEstudiante = isset($_POST['cursoEstudiante'][$id_estudiante]) ? $_POST['cursoEstudiante'][$id_estudiante] : null;
            
                        // Verificar si ya existen registros de desempeño para este estudiante en esta materia
                        $consultaExistente = $miPDO->prepare("SELECT * FROM notas WHERE Id_Est = :id_estudiante AND Nom_mat = :materia AND Num_cur = :curso AND trimestre =:trimestre");
                        $consultaExistente->bindParam(':id_estudiante', $id_estudiante);
                        $consultaExistente->bindParam(':materia', $materiaSeleccionada);
                        $consultaExistente->bindParam(':curso', $cursoEstudiante);
                        $consultaExistente->bindParam(':trimestre', $trimestreEstudiante);
            
                        $consultaExistente->execute();
                        $existeRegistro = $consultaExistente->fetch();
            
                        if ($existeRegistro) {
                            // Si existen registros, actualiza en lugar de insertar
                            $desempeñoJSON = json_encode($desempeño_estudiante, JSON_UNESCAPED_UNICODE);
                            $actualizarDesempeño = $miPDO->prepare("UPDATE notas SET desempeños = :desempeno WHERE Id_Est = :id_estudiante AND Nom_mat = :materia AND Num_cur = :curso AND trimestre =:trimestre");
                            $actualizarDesempeño->bindParam(':id_estudiante', $id_estudiante);
                            $actualizarDesempeño->bindParam(':materia', $materiaSeleccionada);
                            $actualizarDesempeño->bindParam(':curso', $cursoEstudiante);
                            $actualizarDesempeño->bindParam(':trimestre', $trimestreEstudiante);
                            $actualizarDesempeño->bindParam(':desempeno', $desempeñoJSON);
                            $actualizarDesempeño->execute();
                        } else {
                            // Si no existen registros, inserta los nuevos
                            $desempeñoJSON = json_encode($desempeño_estudiante, JSON_UNESCAPED_UNICODE);
                            $insertarDesempeño = $miPDO->prepare("INSERT INTO notas (Id_Est, desempeños, Nom_mat, Num_cur, trimestre) VALUES (:id_estudiante, :desempeno, :materia, :curso, :trimestre)");
                            $insertarDesempeño->bindParam(':id_estudiante', $id_estudiante);
                            $insertarDesempeño->bindParam(':materia', $materiaSeleccionada);
                            $insertarDesempeño->bindParam(':curso', $cursoEstudiante);
                            $insertarDesempeño->bindParam(':trimestre', $trimestreEstudiante);
                            $insertarDesempeño->bindParam(':desempeno', $desempeñoJSON);
                            $insertarDesempeño->execute();
                        }
                } 
                    }
                }

//----------------Proceso php insertar eventos en la base de datos--------------------------------//

            if(isset($_POST["target"]) && isset($_POST["descripcion"]) && isset($_POST["materiaId"]) && isset($_POST["trimestre"])){  

                if($Cargo == "Docente"){
                
                $miConsulta = $miPDO->prepare("SELECT Id_docentes FROM docentes WHERE Documento_Docente='$documento'");
                $miConsulta->execute();
            
                foreach ($miConsulta as $clave => $valor) {
                    $docenteId = $valor['Id_docentes'];
                }
            
                if ($miConsulta) {
                    // Recuperar los datos del evento de la solicitud AJAX
                    $target = $_POST["target"];
                    $evento = $_POST["descripcion"];
                    $materiaId = $_POST["materiaId"];
                    $curso = $_POST["curso"];
                    $trimestre = $_POST["trimestre"];
                    
                        //Consultar eventos 
                        $miConsulta = $miPDO->prepare("SELECT id_evento FROM eventos WHERE target = '$target' AND Nom_mat = '$materiaId' AND Num_cur = '$curso' AND trimestre ='$trimestre'");
                        $miConsulta->execute();
                        $existeRegistro = $miConsulta->fetch();

                        if($existeRegistro){

                            $updateSql = $miPDO->prepare("UPDATE eventos SET descripcion =:descripcion WHERE target =:target AND Nom_mat =:Nom_mat AND Num_cur =:Num_cur AND trimestre =:trimestre");
                            $updateSql->bindParam(':descripcion', $evento);
                            $updateSql->bindParam(':target', $target);
                            $updateSql->bindParam(':Nom_mat', $materiaId);
                            $updateSql->bindParam(':Num_cur', $curso);
                            $updateSql->bindParam(':trimestre', $trimestre);
                            $updateSql->execute();

                        }else{

                            // Insertar el evento en la base de datos
                            $sql = "INSERT INTO eventos (target, descripcion, id_docente, Nom_mat, Num_cur, trimestre) VALUES ('$target', '$evento', '$docenteId', '$materiaId', '$curso', '$trimestre')";
                            $conex->query($sql); 

                        }
                }
                //-----En caso de que sea necesario el docente podra registrar eventos en la planilla(curso y materia) que selecciones------//
                }elseif($Cargo == "Rector(a)" || $Cargo == "Coordinador(a)"){
                    $miConsulta = $miPDO->prepare("SELECT Id_directivo FROM directivos WHERE Documento_Direc='$documento'");
                    $miConsulta->execute();
                
                    foreach ($miConsulta as $clave => $valor) {
                        $directivoId = $valor['Id_directivo'];
                    }
                
                    if ($miConsulta) {
                        // Recuperar los datos del evento de la solicitud AJAX
                        $target = $_POST["target"];
                        $evento = $_POST["descripcion"];
                        $materiaId = $_POST["materiaId"];
                        $curso = $_POST["curso"];
                        $trimestre = $_POST["trimestre"];
                        
                            //Consultar eventos 
                            $miConsulta = $miPDO->prepare("SELECT id_evento FROM eventos WHERE target = '$target' AND Nom_mat = '$materiaId' AND Num_cur = '$curso' AND trimestre ='$trimestre'");
                            $miConsulta->execute();
                            $existeRegistro = $miConsulta->fetch();

                            if($existeRegistro){

                                $updateSql = $miPDO->prepare("UPDATE eventos SET descripcion =:descripcion WHERE target =:target AND Nom_mat =:Nom_mat AND Num_cur =:Num_cur AND trimestre =:trimestre");
                                $updateSql->bindParam(':descripcion', $evento);
                                $updateSql->bindParam(':target', $target);
                                $updateSql->bindParam(':Nom_mat', $materiaId);
                                $updateSql->bindParam(':Num_cur', $curso);
                                $updateSql->bindParam(':trimestre', $trimestre);
                                $updateSql->execute();

                            }else{

                                // Insertar el evento en la base de datos
                                $sql = "INSERT INTO eventos (target, descripcion, Id_directivo, Nom_mat, Num_cur, trimestre) VALUES ('$target', '$evento', '$directivoId', '$materiaId', '$curso', '$trimestre')";
                                $conex->query($sql); 
                            }
                    }
                }
                
        }
//----------------Proceso php insertar desempeños en la base de datos--------------------------------//

        if (isset($_POST["targetDesempeno"]) && isset($_POST["desempeño"]) && isset($_POST["materiaIdDesempeno"]) && isset($_POST["cursoDesempeno"]) ) {
            
            if($Cargo == "Docente"){
            
            $miConsulta = $miPDO->prepare("SELECT Id_docentes FROM docentes WHERE Documento_Docente='$documento'");
            $miConsulta->execute();
        
            foreach ($miConsulta as $clave => $valor) {
                $docenteId = $valor['Id_docentes'];
            }
        
            if ($miConsulta) {
                // Recuperar los datos del evento de la solicitud AJAX
                $target = $_POST["targetDesempeno"];
                $desempeno = $_POST["desempeño"];
                $materiaId = $_POST["materiaIdDesempeno"];
                $curso = $_POST["cursoDesempeno"];
                $trimestre = $_POST["trimestre"];
                
                    // Consultar si ya existe un desempeño con el mismo target, materia y curso
                    $miConsulta = $miPDO->prepare("SELECT id_desempeno FROM desempeños WHERE target = '$target' AND Nom_mat = '$materiaId' AND Num_cur = '$curso' AND trimestre ='$trimestre'");
                    $miConsulta->execute();
                    $existeRegistro = $miConsulta->fetch();

                    if ($existeRegistro) {
                        // Actualizar el desempeño existente
                        $updateSql = $miPDO->prepare("UPDATE desempeños SET desempeno = :desempeno WHERE target = :target AND Nom_mat = :Nom_mat AND Num_cur = :Num_cur AND trimestre= :trimestre");
                        $updateSql->bindParam(':desempeno', $desempeno);
                        $updateSql->bindParam(':target', $target);
                        $updateSql->bindParam(':Nom_mat', $materiaId);
                        $updateSql->bindParam(':Num_cur', $curso);
                        $updateSql->bindParam(':trimestre', $trimestre);
                        $updateSql->execute();
                    } else {
                        // Insertar el desempeño en la base de datos
                        $sql = "INSERT INTO desempeños (target, desempeno, id_directivo, Nom_mat, Num_cur, trimestre) VALUES ('$target', '$desempeno', '$directivoId', '$materiaId', '$curso','$trimestre')";
                        $conex->query($sql);
                    }
            }
            //-----En caso de que sea necesario el docente podra registrar eventos en la planilla(curso y materia) que selecciones------//
            }elseif($Cargo == "Rector(a)" || $Cargo == "Coordinador(a)"){

                $miConsulta = $miPDO->prepare("SELECT Id_directivo FROM directivos WHERE Documento_Direc='$documento'");
                $miConsulta->execute();
            
                foreach ($miConsulta as $clave => $valor) {
                    $directivoId = $valor['Id_directivo'];
                }
            
                if ($miConsulta) {
                    // Recuperar los datos del evento de la solicitud AJAX
                $target = $_POST["targetDesempeno"];
                $desempeno = $_POST["desempeño"];
                $materiaId = $_POST["materiaIdDesempeno"];
                $curso = $_POST["cursoDesempeno"];
                $trimestre = $_POST["trimestre"];
                        
                            
                    // Consultar si ya existe un desempeño con el mismo target, materia y curso
                    $miConsulta = $miPDO->prepare("SELECT id_desempeno FROM desempeños WHERE target = '$target' AND Nom_mat = '$materiaId' AND Num_cur = '$curso' AND trimestre ='$trimestre'");
                    $miConsulta->execute();
                    $existeRegistro = $miConsulta->fetch();

                    if ($existeRegistro) {
                        // Actualizar el desempeño existente
                        $updateSql = $miPDO->prepare("UPDATE desempeños SET desempeno = :desempeno WHERE target = :target AND Nom_mat = :Nom_mat AND Num_cur = :Num_cur AND trimestre= :trimestre");
                        $updateSql->bindParam(':desempeno', $desempeno);
                        $updateSql->bindParam(':target', $target);
                        $updateSql->bindParam(':Nom_mat', $materiaId);
                        $updateSql->bindParam(':Num_cur', $curso);
                        $updateSql->bindParam(':trimestre', $trimestre);
                        $updateSql->execute();
                    } else {
                        // Insertar el desempeño en la base de datos
                        $sql = "INSERT INTO desempeños (target, desempeno, id_directivo, Nom_mat, Num_cur, trimestre) VALUES ('$target', '$desempeno', '$directivoId', '$materiaId', '$curso','$trimestre')";
                        $conex->query($sql);
                    }
                }
            }
    } 
        ?>

<!-- MOSTRAR LOS EVENTOS POR CURSO Y MATERIA  AL DAR CLIC EN EL BOTON BUSCAR -->
<?php
if (isset($_POST["buscarBtn"])) {
    
    $curso = isset($_POST['Numero_curso_pertenece']) ? $_POST['Numero_curso_pertenece'] : null;
    $materiaId = isset($_POST['materia_Registrar']) ? $_POST['materia_Registrar'] : null;
    $trimestre = isset($_POST['trimestre']) ? $_POST['trimestre'] : null;

    if (isset($curso) && isset($materiaId)) {

        if($Cargo == "Docente"){

        // Realiza una consulta SQL para obtener las fechas del trimestre seleccionado
        $sql = "SELECT fecha_inicio, fecha_finalizacion FROM trimestres WHERE nombre_trimestre = :trimestre";
        $consulta = $miPDO->prepare($sql);
        $consulta->bindParam(':trimestre', $trimestre);
        $consulta->execute();
        $trimestreData = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($trimestreData) {
        $fechaInicio = $trimestreData['fecha_inicio'];
        $fechaFinalizacion = $trimestreData['fecha_finalizacion'];

        // Verificar si la fecha actual está dentro del rango del trimestre
        if ($today >= $fechaInicio && $today <= $fechaFinalizacion) {

        $consultaAsignaciones = $miPDO->prepare("SELECT * FROM docentes WHERE Documento_Docente = :documentoDocente");
        $consultaAsignaciones->bindParam(':documentoDocente', $documento);
        $consultaAsignaciones->execute();
        $docente = $consultaAsignaciones->fetch(PDO::FETCH_ASSOC);

        foreach ($consultaAsignaciones as $clave => $valor) {
            $docenteId = $valor['Id_docentes'];
        }
    
        if ($docente) {
            // Decodificar el JSON de asignaciones del docente
            $asignacionesCurso = json_decode($docente['Numero_curso_asignado'], true);
            $asignacionesMateria = json_decode($docente['Nombre_Materia_Asignada'], true);
    
            // Verificar si el docente tiene asignada la materia seleccionada
            $asignacionEncontradaCurso = false;
            foreach ($asignacionesCurso as $asignacion) {
                if ($asignacion == $curso) {
                    $asignacionEncontradaCurso = true;
                    break;
                }
            }

            $asignacionEncontradaMateria = false;
            foreach ($asignacionesMateria as $asignacion) {
                if ($asignacion == $materiaId) {
                    $asignacionEncontradaMateria = true;
                    break;
                }
            }
        }
            if ($asignacionEncontradaCurso && $asignacionEncontradaMateria) {
                
                $miConsulta = $miPDO->prepare("SELECT Id_docentes FROM docentes WHERE Documento_Docente='$documento'");
                $miConsulta->execute();
            
                foreach ($miConsulta as $clave => $valor) {
                    $docenteId = $valor['Id_docentes'];
                }

                //Mostrar el evento dependiendo de la materia o curso seleccionado
                $consultaEventos = $miPDO->prepare("SELECT target, descripcion FROM eventos WHERE Nom_mat = '$materiaId' AND Num_cur = '$curso' AND trimestre = '$trimestre'");
                $consultaEventos->execute();
                $eventos = $consultaEventos->fetchAll(PDO::FETCH_ASSOC);

                //Mostrar el desempeño dependiendo de la materia o curso seleccionado
                $consultaDesempeños = $miPDO->prepare("SELECT target, desempeno FROM desempeños WHERE Nom_mat = '$materiaId' AND Num_cur = '$curso' AND trimestre = '$trimestre'");
                $consultaDesempeños->execute();
                $desempeños = $consultaDesempeños->fetchAll(PDO::FETCH_ASSOC);

                //Actividades Recientes
                echo'<div class="contenedor-principal">
                <div class="contenedor-eventos">
            
                    <div class="reciente">Actividades registradas o actualizadas recientemente</div>
                    
                        <div class="eventos-container">
                            <div id="eventoMostrado1"></div>
                            <div id="eventoMostrado2"></div>
                            <div id="eventoMostrado3"></div>
                            <div id="eventoMostrado4"></div>
                            <div id="eventoMostrado5"></div>
                            <div id="eventoMostrado6"></div>
                            <div id="eventoMostrado7"></div>
                            <div id="eventoMostrado8"></div>
                            <div id="eventoMostrado9"></div>
                            <div id="eventoMostrado10"></div>
                        </div>
                </div>
                <div class="contenedor-desempenos">
                    <div class="reciente" >Desempeños registrados o actualizados recientemente</div>
                        <div class="eventos-container" >
            
                            <div id="D1"></div>
                            <div id="D2"></div>
                            <div id="D3"></div>
                            <div id="D4"></div>
                            <div id="D5"></div>
                        </div>
                </div>
                
            </div>';

            echo'<div class="contenedor-principal">
                    <div class="contenedor-eventos">';
                        //Boton para ocultar o mostrar las Actividades
                        echo ' <button class="boton-eventos" onclick="DA()">
                            Descripción de Actividad  <i class="fas fa-arrow-right"></i>
                        </button>';
                        // Construir el HTML para mostrar los eventos en orden
                        echo '<div class="eventos-container" id="desc-act" style="display: none;">';
                        foreach ($eventos as $evento) {
                            // Extraer el número del evento del 'target' (por ejemplo, 'eventoMostrado10' -> '10')
                            $numeroEvento = preg_replace('/\D/', '', $evento['target']);
                            echo '<div class="evento" id="' . $evento['target'] . '">' . $numeroEvento . '.' . $evento['descripcion'] . '</div>';
                        }
                        echo '</div>
                    </div>
                    <div class="contenedor-desempenos">';
                        //Boton para ocultar o mostrar las Actividades
                        echo ' <button class="boton-eventos" onclick="DD()" id="tamañoD">
                            Descripción del Desempeño  <i class="fas fa-arrow-right"></i>
                        </button>';
                        // Construir el HTML para mostrar los eventos en orden
                        echo '<div class="eventos-container" id="desc-des" style="display: none;">';
                        foreach ($desempeños as $desempeño) {
                            // Extraer el número del evento del 'target' (por ejemplo, 'eventoMostrado10' -> '10')
                            $numeroDesempeño = preg_replace('/\D/', '', $desempeño['target']);
                            echo '<div class="evento" id="' . $desempeño['target'] . '">' . $numeroDesempeño . '.' . $desempeño['desempeno'] . '</div>';
                        }
                        echo '</div>
                    </div>
                </div>';
            }
        }
    }
}elseif($Cargo == "Rector(a)" || $Cargo == "Coordinador(a)"){

            //Mostrar el evento dependiendo de la materia o curso seleccionado
            $consultaEventos = $miPDO->prepare("SELECT target, descripcion FROM eventos WHERE Nom_mat = '$materiaId' AND Num_cur = '$curso' AND trimestre = '$trimestre'");
            $consultaEventos->execute();
            $eventos = $consultaEventos->fetchAll(PDO::FETCH_ASSOC);

            //Mostrar el desempeño dependiendo de la materia o curso seleccionado
            $consultaDesempeños = $miPDO->prepare("SELECT target, desempeno FROM desempeños WHERE Nom_mat = '$materiaId' AND Num_cur = '$curso' AND trimestre = '$trimestre'");
            $consultaDesempeños->execute();
            $desempeños = $consultaDesempeños->fetchAll(PDO::FETCH_ASSOC);

            //Actividades Recientes
            echo'<div class="contenedor-principal">
            <div class="contenedor-eventos">
        
                <div class="reciente">Actividades registradas o actualizadas recientemente</div>
                
                    <div class="eventos-container">
                        <div id="eventoMostrado1"></div>
                        <div id="eventoMostrado2"></div>
                        <div id="eventoMostrado3"></div>
                        <div id="eventoMostrado4"></div>
                        <div id="eventoMostrado5"></div>
                        <div id="eventoMostrado6"></div>
                        <div id="eventoMostrado7"></div>
                        <div id="eventoMostrado8"></div>
                        <div id="eventoMostrado9"></div>
                        <div id="eventoMostrado10"></div>
                    </div>
            </div>
            <div class="contenedor-desempenos">
                <div class="reciente" >Desempeños registrados o actualizados recientemente</div>
                    <div class="eventos-container" >
        
                        <div id="D1"></div>
                        <div id="D2"></div>
                        <div id="D3"></div>
                        <div id="D4"></div>
                        <div id="D5"></div>
                    </div>
            </div>
            
            </div>';

            echo'<div class="contenedor-principal">
                    <div class="contenedor-eventos">';
                        //Boton para ocultar o mostrar las Actividades
                        echo ' <button class="boton-eventos" onclick="DA()">
                            Descripción de Actividad  <i class="fas fa-arrow-right"></i>
                        </button>';
                        // Construir el HTML para mostrar los eventos en orden
                        echo '<div class="eventos-container" id="desc-act" style="display: none;">';
                        foreach ($eventos as $evento) {
                            // Extraer el número del evento del 'target' (por ejemplo, 'eventoMostrado10' -> '10')
                            $numeroEvento = preg_replace('/\D/', '', $evento['target']);
                            echo '<div class="evento" id="' . $evento['target'] . '">' . $numeroEvento . '.' . $evento['descripcion'] . '</div>';
                        }
                        echo '</div>
                    </div>
                    <div class="contenedor-desempenos">';
                        //Boton para ocultar o mostrar las Actividades
                        echo ' <button class="boton-eventos" onclick="DD()" id="tamañoD">
                            Descripción del Desempeño  <i class="fas fa-arrow-right"></i>
                        </button>';
                        // Construir el HTML para mostrar los eventos en orden
                        echo '<div class="eventos-container" id="desc-des" style="display: none;">';
                        foreach ($desempeños as $desempeño) {
                            // Extraer el número del evento del 'target' (por ejemplo, 'eventoMostrado10' -> '10')
                            $numeroDesempeño = preg_replace('/\D/', '', $desempeño['target']);
                            echo '<div class="evento" id="' . $desempeño['target'] . '">' . $numeroDesempeño . '.' . $desempeño['desempeno'] . '</div>';
                        }
                        echo '</div>
                    </div>
                </div>';

        }elseif($Cargo == "Estudiante"){
            //Mostrar el evento dependiendo de la materia o curso seleccionado
            $consultaEventos = $miPDO->prepare("SELECT target, descripcion FROM eventos WHERE Nom_mat = '$materiaId' AND Num_cur = '$curso' AND trimestre = '$trimestre'");
            $consultaEventos->execute();
            $eventos = $consultaEventos->fetchAll(PDO::FETCH_ASSOC);

            //Mostrar el desempeño dependiendo de la materia o curso seleccionado
            $consultaDesempeños = $miPDO->prepare("SELECT target, desempeno FROM desempeños WHERE Nom_mat = '$materiaId' AND Num_cur = '$curso' AND trimestre = '$trimestre'");
            $consultaDesempeños->execute();
            $desempeños = $consultaDesempeños->fetchAll(PDO::FETCH_ASSOC);

            echo'<div class="contenedor-principal">
            <div class="contenedor-eventos">';
                //Boton para ocultar o mostrar las Actividades
                echo ' <button class="boton-eventos" onclick="DA()">
                    Descripción de Actividad  <i class="fas fa-arrow-right"></i>
                </button>';
                // Construir el HTML para mostrar los eventos en orden
                echo '<div class="eventos-container" id="desc-act" style="display: none;">';
                foreach ($eventos as $evento) {
                    // Extraer el número del evento del 'target' (por ejemplo, 'eventoMostrado10' -> '10')
                    $numeroEvento = preg_replace('/\D/', '', $evento['target']);
                    echo '<div class="evento" id="' . $evento['target'] . '">' . $numeroEvento . '.' . $evento['descripcion'] . '</div>';
                }
                echo '</div>
            </div>
            <div class="contenedor-desempenos">';
                //Boton para ocultar o mostrar las Actividades
                echo ' <button class="boton-eventos" onclick="DD()" id="tamañoD">
                    Descripción del Desempeño  <i class="fas fa-arrow-right"></i>
                </button>';
                // Construir el HTML para mostrar los eventos en orden
                echo '<div class="eventos-container" id="desc-des" style="display: none;">';
                foreach ($desempeños as $desempeño) {
                    // Extraer el número del evento del 'target' (por ejemplo, 'eventoMostrado10' -> '10')
                    $numeroDesempeño = preg_replace('/\D/', '', $desempeño['target']);
                    echo '<div class="evento" id="' . $desempeño['target'] . '">' . $numeroDesempeño . '.' . $desempeño['desempeno'] . '</div>';
                }
                echo '</div>
            </div>
        </div>';
        }
    }
}

?>
<!--MENSAJES DE ERROR RECORRIENDO EL VECTOR $errores-->
    <?php
    if(isset($errores)):
        if(count($errores) > 0):
    ?>
        <div class="errores">
            <?php foreach($errores as $error): ?>
                    <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php 
        endif; 
    endif;
    ?>
<!-- VENTANA MODAL PARA ESCRIBIR LA DESCRIPCION DE LA ACTIVIDAD -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <h2>Descripción de Actividad</h2>
            <form action="" method="post">
                <textarea id="eventoTextarea" name="eventoTextarea" rows="4" cols="50"></textarea>
                <button id="guardarEvento" name="guardarEvento">Guardar</button>
            </form>
        </div>
    </div>

<!-- VENTANA MODAL PARA ESCRIBIR LOS DESEMPEÑOS -->
    <div id="modal-2" class="modal-2">
        <div class="modal-content">
            <span class="close" id="close-modal-2">&times;</span>
            <h2>Descripción del Desempeño</h2>
            <form action="" method="post">
                <textarea id="desemTextarea" name="desemTextarea" rows="4" cols="50"></textarea>
                <button id="guardarDesem" name="guardarDesem">Guardar</button>
            </form>
        </div>
    </div>

<!-- MENSAJE DE BIENVENIDA -->
    <?php
    if (isset($_COOKIE['bienvenida_mostrada'])) {
        // El mensaje de bienvenida solo se muestra si la cookie existe
        echo '<div id="Bienvenida" class="show-animation">';
        echo '<span>¡Bienvenido <strong>'. $usuario .'</strong> al Sistema de Gestión de Planillas de Notas</span>';
        echo '<div id="desvanecer-barra"></div>';
        echo '</div>';
        
    }
    ?>

    <script src="Vista/JS/script.js"></script>
    <script>

//------------------------------LOGICA JS PARA MOSTRAR VENTANA EMERGENTE Y MANDAR DATOS POR AJAX PARA GUARDAR LOS EVENTOS-----------------------------------//
        // Obtener elementos del DOM
        var modal = document.getElementById("modal");
        var closeModalBtn = document.getElementById("close-modal");
        var guardarEventoBtn = document.getElementById("guardarEvento");

        // Mostrar el modal cuando se hace clic en "Agregar evento"
        var agregarEventoBtns = document.querySelectorAll(".agregarEventoBtn");

        // Agregar un evento click a cada botón
        agregarEventoBtns.forEach(function (btn) {
            btn.addEventListener("click", function () {

                // Obtener el identificador único del botón
                var target = btn.getAttribute("data-target");
                var materiaId = btn.getAttribute("data-materia-id"); // Obtener la materia
                var curso = btn.getAttribute("data-curso-id"); // Obtener el Curso
                var eventoTextarea = document.getElementById("eventoTextarea");

                // Obtener el contenido del evento correspondiente y mostrarlo en el textarea
                var eventosContainer = document.getElementById(target);
                if (eventosContainer) {
                    var eventoContent = eventosContainer.textContent;

                    // Eliminar los primeros 2 caracteres (número y punto)
                    eventoContent = eventoContent.substring(2);

                    eventoTextarea.value = eventoContent;
                }

                // Restablecer el atributo data-target del modal para saber dónde mostrar el evento
                modal.setAttribute("data-target", target);

                // Mostrar el modal
                modal.style.display = "block";
                
                // Establecer el atributo data-target del modal para saber dónde mostrar el evento
                modal.setAttribute("data-target", target);

                // Establecer el atributo data-materia-id del modal para enviarlo al servidor
                modal.setAttribute("data-materia-id", materiaId);
                // Establecer el atributo data-curso-id del modal para enviarlo al servidor
                modal.setAttribute("data-curso-id", curso);

            });
        });

        // Cerrar el modal cuando se hace clic en la "X" o fuera del modal
        closeModalBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });

        window.addEventListener("click", function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });

        // Guardar el evento y mostrarlo debajo del botón correspondiente

        guardarEventoBtn.addEventListener("click", function (event) {
            
        event.preventDefault(); 

        var eventoTextarea = document.getElementById("eventoTextarea");
        var eventoValue = eventoTextarea.value;

        var trimestreSelect = document.getElementById("trimestre");
        var trimestre = trimestreSelect.value; // Obtiene el valor seleccionado

        // Obtener el identificador del elemento donde mostrar el evento
        var target = modal.getAttribute("data-target");
        var materiaId = modal.getAttribute("data-materia-id"); // Obtener la materia
        var curso = modal.getAttribute("data-curso-id"); // Obtener el curso

        // Obtener el elemento donde se mostrarán los eventos
        var eventosContainer = document.getElementById(target);

        // Verificar si ya hay un evento mostrado en el contenedor
        var eventoExistente = eventosContainer.querySelector("div.evento");

        // Obtener el número del evento a partir del target
        var numeroEvento = target.replace(/\D/g, ''); // Extraer solo los dígitos del target

        // Si ya existe un evento, actualiza su contenido en lugar de crear uno nuevo
        if (eventoExistente) {
            eventoExistente.textContent = numeroEvento + ". " + eventoValue;
        } else {
                // Si no existe un evento, crea uno nuevo
                var nuevoEventoDiv = document.createElement("div");
                nuevoEventoDiv.textContent = numeroEvento + "." + eventoValue; // Agrega el número al nuevo evento
                nuevoEventoDiv.className = "evento"; // Asigna la clase "evento"

                // Agregar el nuevo evento al contenedor
                eventosContainer.appendChild(nuevoEventoDiv);
        } 

            // Hacer una solicitud AJAX para guardar el evento en PHP
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "Pagina_principal.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    modal.style.display = "none";
                }
            };

            // Enviar los datos del evento al servidor, incluyendo el ID de la materia
            var data = "target=" + target + "&descripcion=" + eventoValue + "&materiaId=" + materiaId + "&curso=" + curso + "&trimestre=" + trimestre;
            xhr.send(data);

            // Luego, cierra el modal
            modal.style.display = "none";

            // Limpia el textarea
            eventoTextarea.value = "";
        });

//------------------------------LOGICA JS PARA MOSTRAR VENTANA EMERGENTE Y MANDAR DATOS POR AJAX PARA GUARDAR LOS DESEMPEÑOS-----------------------------------//
        // Obtener elementos del DOM
        var modal_2 = document.getElementById("modal-2");
        var closeModalBtn_2 = document.getElementById("close-modal-2");
        var guardarDesemBtn = document.getElementById("guardarDesem");

        // Mostrar el modal cuando se hace clic en "Agregar evento"
        var agregarDesemBtns = document.querySelectorAll(".agregarDesempeñoBtn");

        // Agregar un evento click a cada botón
        agregarDesemBtns.forEach(function (btn) {
            btn.addEventListener("click", function () {
                // Obtener el identificador único del botón
                var target = btn.getAttribute("data-target");
                var materiaId = btn.getAttribute("data-materia-id");
                var curso = btn.getAttribute("data-curso-id");
                var desemTextarea = document.getElementById("desemTextarea");

                // Obtener el contenido del evento correspondiente y mostrarlo en el textarea
                var desemContainer = document.getElementById(target);
                if (desemContainer) {
                    var desemContent = desemContainer.textContent.trim(); // Trim para eliminar espacios en blanco

                    // Eliminar los primeros caracteres (número y punto)
                    var numeroDesem = desemContent.split('. ')[0];
                    desemContent = desemContent.substring(numeroDesem.length + 2);

                    desemTextarea.value = desemContent;
                }

                // Restablecer el atributo data-target del modal para saber dónde mostrar el evento
                modal_2.setAttribute("data-target", target);

                // Mostrar el modal
                modal_2.style.display = "block";

                // Establecer el atributo data-materia-id del modal para enviarlo al servidor
                modal_2.setAttribute("data-materia-id", materiaId);
                // Establecer el atributo data-curso-id del modal para enviarlo al servidor
                modal_2.setAttribute("data-curso-id", curso);
            });
        });

        // Cerrar el modal cuando se hace clic en la "X" o fuera del modal
        closeModalBtn_2.addEventListener("click", function () {
            modal_2.style.display = "none";
        });

        window.addEventListener("click", function (event) {
            if (event.target === modal_2) {
                modal_2.style.display = "none";
            }
        });
        // Guardar el desempeño y mostrarlo
        guardarDesemBtn.addEventListener("click", function (event) {
            event.preventDefault();

            var desemTextarea = document.getElementById("desemTextarea");
            var desemValue = desemTextarea.value;

            var trimestreSelect = document.getElementById("trimestre");
            var trimestre = trimestreSelect.value; // Obtiene el valor seleccionado

            // Obtener el identificador del elemento donde mostrar el desempeño
            var target = modal_2.getAttribute("data-target");
            var materiaId = modal_2.getAttribute("data-materia-id");
            var curso = modal_2.getAttribute("data-curso-id");

            // Obtener el elemento donde se mostrarán los eventos
            var desemContainer = document.getElementById(target);

            // Verificar si ya hay un evento mostrado en el contenedor
            var desemExistente = desemContainer.querySelector("div.evento");

            // Obtener el número del evento a partir del target
            var numeroDesem = target.replace(/\D/g, '');

            // Si ya existe un evento, actualiza su contenido en lugar de crear uno nuevo
            if (desemExistente) {
                desemExistente.textContent = numeroDesem + ". " + desemValue;
            } else {
                // Si no existe un evento, crea uno nuevo
                var nuevoDesemDiv = document.createElement("div");
                nuevoDesemDiv.textContent = numeroDesem + ". " + desemValue;
                nuevoDesemDiv.className = "evento";

                // Agregar el nuevo evento al contenedor
                desemContainer.appendChild(nuevoDesemDiv);
            }
                // Realizar una solicitud AJAX para guardar el desempeño en el servidor
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "Pagina_principal.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // La respuesta del servidor
                        modal_2.style.display = "none";
                    }
                };

                // Enviar los datos del desempeño al servidor
                var data = "targetDesempeno=" + target + "&desempeño=" + desemValue + "&materiaIdDesempeno=" + materiaId + "&cursoDesempeno=" + curso + "&trimestre=" + trimestre;
                xhr.send(data);

                // Cerrar el modal
                modal_2.style.display = "none";

                // Limpiar el textarea
                desemTextarea.value = "";
        });
//-------------------------Esta funcion permite obtener la descripcion desde la base datos por medio de una solicitud ajax----------------------//

            $(document).ready(function () {
            // Agregar un evento al hacer clic en los botones
            $(".agregarEventoBtn").click(function () {
                // Obtener los datos necesarios de los atributos de los botones
                var target = $(this).data("target");
                var materiaId = $(this).data("materia-id");
                var curso = $(this).data("curso-id");
                var trimestre = $("#trimestre").val();

                // Realizar una solicitud AJAX al servidor para obtener la descripción
                $.ajax({
                    type: "GET",
                    url: "Controlador/consulta_eventos.php", // Reemplaza con la URL de tu archivo PHP para manejar la consulta a la base de datos
                    data: {
                        target: target,
                        materiaId: materiaId,
                        curso: curso,
                        trimestre: trimestre
                    },
                    success: function (response) {
                        // Colocar la descripción en el textarea
                        $("#eventoTextarea").val(response);
                    },
                    error: function () {
                        alert("Error al obtener la descripción.");
                    }
                });
            });
        });

//-------------------------Esta funcion permite obtener la descripcion del desempeño  desde la base datos por medio de una solicitud ajax----------------------//

            $(document).ready(function () {
            // Agregar un evento al hacer clic en los botones
            $(".agregarDesempeñoBtn").click(function () {
                // Obtener los datos necesarios de los atributos de los botones
                var target = $(this).data("target");
                var materiaId = $(this).data("materia-id");
                var curso = $(this).data("curso-id");
                var trimestre = $("#trimestre").val();

                // Realizar una solicitud AJAX al servidor para obtener la descripción
                $.ajax({
                    type: "GET",
                    url: "Controlador/consulta_desempenos.php", // Reemplaza con la URL de tu archivo PHP para manejar la consulta a la base de datos
                    data: {
                        target: target,
                        materiaId: materiaId,
                        curso: curso,
                        trimestre: trimestre
                    },
                    success: function (response) {
                        // Colocar la descripción en el textarea
                        $("#desemTextarea").val(response);
                    },
                    error: function () {
                        alert("Error al obtener la descripción.");
                    }
                });
            });
        });
        
//----------------- Esta Funcion no permite registrar otros caracteres que no sean numericos y no permite poner mas de 3 caracteres en los inputs de la planilla en la parte de Hetero , auto, coe y evaluacion  ------------------------- 
            
            // Esta función se ejecuta cuando se intenta ingresar datos en el campo de entrada
            function validarNumeroInput(input) {
            // Reemplaza cualquier carácter no numérico por una cadena vacía
            input.value = input.value.replace(/\D/g, '');

            // Elimina ceros a la izquierda sin afectar el valor 0
            if (input.value.length > 1 && input.value.charAt(0) === '0') {
                input.value = input.value.slice(1);
            }

            // Convierte el valor a un número entero
            var valorNumerico = parseInt(input.value, 10);

            // Limita la longitud del valor a 3 caracteres
            if (input.value.length > 3) {
                input.value = input.value.slice(0, 3);
            }

            // Limita el valor numérico al rango de 10 a 100
            if (valorNumerico > 100) {
                input.value = '100';
            } 
            }

//----------------- Esta Funcion no permite registrar otros caracteres que no sea la S(si) y la N(no) en la sona de desempeños------------------------- 

            function validarLetrasSN(input) {
            // Reemplaza cualquier carácter no "S" o "N" por una cadena vacía
            input.value = input.value.replace(/[^SN]/g, '');

            // Limita la longitud del valor a 1 caracter
            if (input.value.length > 1) {
                input.value = input.value.slice(0, 1);
            }
            }

//------------------ Funcion que se activa al dar clic en el boton con el onclic "DA()"  ------------------------------------------------------

            function DA() {
                var masInformacion = document.getElementById('desc-act');
                
                if (masInformacion.style.display === 'none' || masInformacion.style.display === '') {
                    masInformacion.style.display = 'block';
                } else {
                    masInformacion.style.display = 'none';
                }
            }
//------------------ Funcion que se activa al dar clic en el boton con el onclic "DD()"  ------------------------------------------------------

            function DD() {
                var masInformacion = document.getElementById('desc-des');
                
                if (masInformacion.style.display === 'none' || masInformacion.style.display === '') {
                    masInformacion.style.display = 'block';
                } else {
                    masInformacion.style.display = 'none';
                }
            }
//--------------------------Funcion evitar que el usuario tenga que volver a seleccionar el curso y materia ------------------------------------------//
    $(document).ready(function() {
            // Función para establecer una cookie
            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + value + expires + "; path=/";
            }

            // Función para obtener el valor de una cookie
            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }

            // Cuando se carga la página, verifica si hay valores almacenados en cookies
            var cursoSeleccionado = getCookie("cursoSeleccionado");
            var materiaSeleccionada = getCookie("materiaSeleccionada");
            var trimestreSeleccionado = getCookie("trimestre")

            // Establece los valores en los selectores si se encuentran en las cookies
            if (cursoSeleccionado) {
                $("#cursoSelect").val(cursoSeleccionado);
            }
            if (materiaSeleccionada) {
                $("#materiaSelect").val(materiaSeleccionada);
            }
            if(trimestreSeleccionado){
                $("#trimestre").val(trimestreSeleccionado);
            }

            // Función para manejar el cambio en los selectores
            function cambioSeleccion() {
                var curso = $("#cursoSelect").val();
                var materia = $("#materiaSelect").val();
                var trimestre = $("#trimestre").val();

                setCookie("cursoSeleccionado", curso, 1);
                setCookie("materiaSeleccionada", materia, 1);
                setCookie("trimestre", trimestre, 1);
            }

            // Manejar el cambio en los selectores
            $("#cursoSelect, #materiaSelect, #trimestre").change(cambioSeleccion);

            // Función para establecer una cookie con un tiempo de expiración corto
            function setShortExpirationCookie(name, value) {
                document.cookie = name + "=" + value + "; path=/; max-age=5"; // La cookie expirará después de 5 segundos
            }

            // Cuando se carga la página, verifica si hay una cookie que indique que se debe mostrar la notificación
            var showNotificationCookie = getCookie("showNotification");

            // Si la cookie está presente, muestra el mensaje de notificación
            if (showNotificationCookie === "true") {
                $("#notification").text("Notas guardadas correctamente");
                $("#notification").addClass("show");
                // Configura la cookie para eliminarse automáticamente
                setShortExpirationCookie("showNotification", "false");
            }

            // Cuando se hace clic en el botón "Guardar"
            $("#guardarNotasBtn").click(function() {

                // Recolecta los datos del formulario
                var formData = $("#notas").serialize();
                
                // Realiza la llamada AJAX para guardar las notas
                $.ajax({
                    type: "POST",
                    url: "Pagina_principal.php", // Reemplaza con la ruta correcta a tu script PHP de guardado
                    data: formData,
                    success: function(response) {

                        // Configura la cookie para mostrar la notificación
                        setShortExpirationCookie("showNotification", "true");

                        // Si ambos campos ya tienen selecciones, simula el clic en el botón "Buscar"
                        if (cursoSeleccionado && materiaSeleccionada) {
                            $("#buscarBtn").click();
                        }
                    }
                });
                
            });
        });
    </script>
</body>
</html>