<?php
include('conec_BD.php');
session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION["cargo"])) {
    header("Location: Login.php");
    exit();
}else{
    $usuario = $_SESSION['usuario'];
    $Cargo = $_SESSION['cargo'];
}

//
    $Id=isset($_REQUEST['Id_materias'])?$_REQUEST['Id_materias']:null;
    $nombre_materia=isset($_REQUEST['Nombre_Materias'])?$_REQUEST['Nombre_Materias']:null;
    $porcentaje = isset($_REQUEST['Porcentaje']) ? $_REQUEST['Porcentaje'] : null;
    

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $miupdate = $miPDO->prepare('UPDATE materias SET Nombre_Materias=:Nombre_Materias,Porcentaje=:Porcentaje WHERE Id_materias=:Id_materias');
        $miupdate->execute(
            [
                'Id_materias'=>$Id,
                'Nombre_Materias'=> $nombre_materia,
                'Porcentaje'=> $porcentaje
            ]
            );
            // Después de actualizar los datos con éxito
            $_SESSION['actualizacion_exitosa'] = true;
            header('location:../Vista/Registra_mat.php');
            die();
    }else{

        $miConsulta=$miPDO->prepare('SELECT * FROM materias WHERE Id_materias=:Id_materias;');
        $miConsulta->execute(
            [
                'Id_materias'=>$Id,
            ]
            );
    }
    $materia=$miConsulta->fetch();
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

<body>
    <!-- Caja Materias y cursos -->

<section id="sectionMat">
    <header>
        <i class="fa-solid fa-book" id="Icono"></i>
        <i class="fa-solid fa-magnifying-glass" id="Icono-2"></i>
        <p id="head">Modificar Materia</p>
    </header>

<form action="" method="post">
    <br>
<!-- Nombre  -->
    
<div class="campos">
            <i class="fa-solid fa-pencil"></i>
            <input type="text" id="user" id="i2" name="Nombre_Materias" value="<?=$materia['Nombre_Materias']?>" autocomplete="off">
        </div>
    <br>
    <div class="campos">
        <i class="fa-solid fa-percentage"></i>
        <input type="text" id="porcentaje" name="Porcentaje" value="<?=$materia['Porcentaje']?>" autocomplete="off">
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