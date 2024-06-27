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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilo/General.css">
    <script src="https://kit.fontawesome.com/5038b205c4.js" crossorigin="anonymous"></script>
    <link rel="shorcut icon" href="IMG/escudo.png">
    <title>Gestion de Tiempo</title>
    <style>
        .container {
        display: flex;
        flex-direction: column;
        width:92%;
        margin-top: 4%;
        margin-left: 5%;
        margin-right: 5%;
        background-color: #f0f0f0;
        padding: 20px; /* Espaciado interior */
        border: 1px solid #ccc; /* Borde alrededor de la sección */
        border-radius: 10px; /* Radio del borde para suavizar los bordes */
        min-height: 150px;
        height:auto;
        }
        #form{
        display: flex;
        align-items: center;
        width: 100%;
        margin-left: 4.5%;
        border: none;
        margin-top:none;
        }
        select{
        padding: 5px;
        margin: 5px;
        border: 2px solid #007BFF;
        border-radius: 5px;
        font-size: 16px;
        }

        .select{
            margin-left:-4%;
            margin-right:1.3%;
            margin-top:-0.3%;
        }

        /* Estilo para las etiquetas de fecha */
        label {
            font-weight: bold;
            font-size: 18px;
            color: #333; /* Cambia el color de la etiqueta según tus preferencias */
            margin-right: 10px;
            margin-left:10px;
        }

        /* Estilo para los campos de fecha */
        input[type="date"] {
            padding: 5px;
            margin: 5px;
            border: 2px solid #007BFF;
            border-radius: 5px;
            font-size: 16px;
        }

        .guardar-button {
        margin-top:-0.3%;
        display: flex;
        align-items: center;
        width:100%;
        margin-left:15%;
        }

        .guardarBtn {
        background-color: #007BFF;
        color: #fff;
        border: none;
        padding: 7px 7px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 15px;
        transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        }

            .guardarBtn:hover {
                background-color: #0056b3;
                transform: scale(1.05); /* Efecto de escala al pasar el mouse por encima */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Sombra al pasar el mouse por encima */
            }

            .guardarBtn:active {
                transform: scale(0.95); /* Efecto de escala cuando se hace clic */
            }
        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 60px;
        }

        td {
            padding: 1rem;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: rgb(0, 57, 91);
            color: #fff;
            text-align: center;
            padding: 10px;
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
        h2 {
                font-size: 24px; /* Tamaño de fuente */
                font-weight: bold; /* Texto en negrita */
                color: #333; /* Color de fuente */
                text-align: center; /* Alineación centrada */
                margin-bottom: 13px; /* Espacio en la parte inferior del elemento */
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

<section class="container">
    <h2>Establecer Fechas Límite</h2>
    <form  method="post" id="form">
        <div class="select">
            <select name="trimestre" id="trimestreSelect">
                <option value="Primer Trimestre">Primer Trimestre</option>
                <option value="Segundo Trimestre">Segundo Trimestre</option>
                <option value="Tercer Trimestre">Tercer Trimestre</option>
            </select>
        </div>
        <div>
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" autocomplete="off">
        </div>
        <div>
            <label for="fecha_finalizacion">Fecha de Finalización:</label>
            <input type="date" name="fecha_finalizacion" id="fecha_finalizacion" autocomplete="off" >
        </div>
        <div>
            <div class="guardar-button">
                <input type="submit" value="Guardar Fechas Límite" class="guardarBtn" name="guardarBtn">
            </div>
        </div>
    </form>
    <?php
    // Verificar si ya existe una fecha límite para cualquier trimestre
    $sqlVerificar = "SELECT * FROM trimestres";
    $consulta = $miPDO->prepare($sqlVerificar);
    $consulta->execute();
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST["guardarBtn"])) {
        // Recupera los valores del formulario
        $trimestre = $_POST['trimestre'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_finalizacion = $_POST['fecha_finalizacion'];
        
        // Busca si ya existe una fecha límite para el trimestre seleccionado
        $fechaLimiteExistente = null;
        foreach ($resultados as $resultado) {
            if ($resultado['nombre_trimestre'] === $trimestre) {
                $fechaLimiteExistente = $resultado;
                break;
            }
        }

        if (!empty($fechaLimiteExistente)) {
            // Ya existe una fecha límite para el trimestre, muestra un mensaje
            echo "<h4 class='F'>Ya hay una fecha límite registrada para el trimestre</h4>";
        } else {
            // Inserta los valores en la base de datos
            $sql = "INSERT INTO trimestres (nombre_trimestre, fecha_inicio, fecha_finalizacion) VALUES (:nombre_trimestre, :fecha_inicio, :fecha_finalizacion)";
            $guardarTrimestre = $miPDO->prepare($sql);
            $guardarTrimestre->bindParam(':nombre_trimestre', $trimestre, PDO::PARAM_STR);
            $guardarTrimestre->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
            $guardarTrimestre->bindParam(':fecha_finalizacion', $fecha_finalizacion, PDO::PARAM_STR);
        
            if ($guardarTrimestre->execute()) {
                echo "<h4 class='ok'>Fechas límite registradas con éxito</h4>";

                // Actualizar la lista de fechas límite
                $consulta = $miPDO->prepare($sqlVerificar);
                $consulta->execute();
                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo "<h4 class='F'>Error al registrar las fechas límite</h4>";
            }
        }
    }
    ?>
    <table>
        <tr>
            <th>Trimestre</th>
            <th>Fecha Inicio</th>
            <th>Fecha Finalizacion</th>
            <th>Modificar<i class="fa-solid fa-pen"></i></th>
            <th>Borrar<i class="fa-solid fa-trash"></i></th>
        </tr>
        <?php
        // Recorre los resultados y muestra cada trimestre con sus fechas
        foreach ($resultados as $resultado) {
            echo "<tr>";
            echo "<td>" . $resultado['nombre_trimestre'] . "</td>";
            echo "<td>" . $resultado['fecha_inicio'] . "</td>";
            echo "<td>" . $resultado['fecha_finalizacion'] . "</td>";
            ?>
            <td> <a  class="button" href="../Modelo/Modificar_Fecha_Limite.php?Id_trimestre=<?=$resultado['Id_trimestre']?>">Modificar <i class="fa-solid fa-pen"></i></a></td>
            <td> <a  class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_trimestre=<?= $resultado['Id_trimestre']?>">Borrar<i class="fa-solid fa-trash"></i></a></td>
            <?php
            echo "</tr>";
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

</body>
</html>