<?php
include('../Modelo/conec_BD.php');
session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION["cargo"])) {
    header("Location: ../Login.php");
    exit();
} else {
    $usuario = $_SESSION['usuario'];
    $Cargo = $_SESSION['cargo'];
    $documento = $_SESSION['documento'];
}

// Recupera los valores del formulario
$Id=isset($_REQUEST['Id_trimestre'])?$_REQUEST['Id_trimestre']:null;
$nuevoTrimestre =isset($_REQUEST['trimestre'])?$_REQUEST['trimestre']:null;
$nuevaFechaInicio = isset($_REQUEST['fecha_inicio'])?$_REQUEST['fecha_inicio']:null;
$nuevaFechaFinalizacion = isset($_REQUEST['fecha_finalizacion'])?$_REQUEST['fecha_finalizacion']:null;

if($_SERVER['REQUEST_METHOD']=='POST'){
    

    

    $miupdate=$miPDO->prepare('UPDATE trimestres SET  nombre_trimestre = :nombre_trimestre, fecha_inicio = :nuevaFechaInicio, fecha_finalizacion = :nuevaFechaFinalizacion WHERE Id_trimestre = :Id_trimestre');
        $miupdate->execute(
            [
                'Id_trimestre'=>$Id,
                'nombre_trimestre'=> $nuevoTrimestre,
                'nuevaFechaInicio'=> $nuevaFechaInicio,
                'nuevaFechaFinalizacion' => $nuevaFechaFinalizacion
            ]
            );
            if($miupdate){
            // Después de actualizar los datos con éxito
            $_SESSION['actualizacion_exitosa'] = true;
            header('location:../Vista/Gestion_tiempo.php');
            die();
            }
}else{

    $miConsulta=$miPDO->prepare('SELECT * FROM trimestres WHERE Id_trimestre = :Id_trimestre;');
    $miConsulta->execute(
        [
            'Id_trimestre'=>$Id
        ]
        );
}
$trimestre=$miConsulta->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Vista/Estilo/General.css">
    <script src="https://kit.fontawesome.com/5038b205c4.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="IMG/escudo.png">
    <title>Modificar Fecha Límite</title>
    <style>
        .container {
        display: flex;
        flex-direction: column;
        width:87%;
        margin-top: 4%;
        margin-left: 6%;
        margin-right: 6%;
        background-color: #f0f0f0; /* Cambia el color de fondo según tus preferencias */
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
            .boton-animated {
                width:9.5%;
                margin-top:2.5%;
                margin-left:5%;
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
<section class="container">
    <h2>Modificar Fecha Límite</h2>
    <form method="post" id="form">
        <div class="select">
            <select name="trimestre" id="trimestreSelect">
                <option value="Primer Trimestre" <?php if ($trimestre['nombre_trimestre'] === "Primer Trimestre") echo 'selected'; ?>>Primer Trimestre</option>
                <option value="Segundo Trimestre" <?php if ($trimestre['nombre_trimestre'] === "Segundo Trimestre") echo 'selected'; ?>>Segundo Trimestre</option>
                <option value="Tercer Trimestre" <?php if ($trimestre['nombre_trimestre'] === "Tercer Trimestre") echo 'selected'; ?>>Tercer Trimestre</option>
            </select>
        </div>
        <div>
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?=$trimestre['fecha_inicio']?>" autocomplete="off">
        </div>
        <div>
            <label for="fecha_finalizacion">Fecha de Finalización:</label>
            <input type="date" name="fecha_finalizacion" id="fecha_finalizacion" value="<?=$trimestre['fecha_finalizacion']?>" autocomplete="off">
        </div>
        <div>
            <div class="guardar-button">
                <input type="hidden" name="Id_trimestre" value="<?=$Id?>">
                <input type="submit" value="Guardar Cambios" class="guardarBtn" name="guardarCambios">
            </div>
        </div>
    </form>
</section>
<button class="boton-animated" onclick="window.location.href='../Vista/Gestion_tiempo.php'">
        <i class="fas fa-arrow-right"></i> Regresar
</button>
</body>
</html>