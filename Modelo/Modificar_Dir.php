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
    $Id=isset($_REQUEST['Id_directivo'])?$_REQUEST['Id_directivo']:null;
    $nombre=isset($_REQUEST['Nombre_Directivo'])?$_REQUEST['Nombre_Directivo']:null;
    $nombre_2=isset($_REQUEST['Nombre_Directivo_segundo'])?$_REQUEST['Nombre_Directivo_segundo']:null;
    $apellido=isset($_REQUEST['Apellido_Directivo'])?$_REQUEST['Apellido_Directivo']:null;
    $apellido_2=isset($_REQUEST['Apellido_Directivo_segundo'])? $_REQUEST['Apellido_Directivo_segundo']:null;
    $doc=isset($_REQUEST['Documento_Direc'])?$_REQUEST['Documento_Direc']:null;
    $Cargo=isset($_REQUEST['Cargo'])? $_REQUEST['Cargo']:null;

    $hostPDO="mysql:host=$hostDB;dbname=$nombreDB;";
    $miPDO= new PDO($hostPDO,$usuarioDB,$contrasenaDB);

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $miupdate=$miPDO->prepare('UPDATE directivos SET Nombre_Directivo=:Nombre_Directivo, Nombre_Directivo_segundo=:Nombre_Directivo_segundo, Apellido_Directivo=:Apellido_Directivo, Apellido_Directivo_segundo=:Apellido_Directivo_segundo, Documento_Direc=:Documento_Direc, Cargo=:Cargo WHERE Id_directivo=:Id_directivo');
        $miupdate->execute(
            [
                'Id_directivo'=>$Id,
                'Nombre_Directivo'=> $nombre,
                'Nombre_Directivo_segundo'=> $nombre_2,
                'Apellido_Directivo' => $apellido,
                'Apellido_Directivo_segundo' => $apellido_2,
                'Documento_Direc' => $doc,
                'Cargo' => $Cargo
            ]
            );
            if($miupdate){
            // Después de actualizar los datos con éxito
            $_SESSION['actualizacion_exitosa'] = true;
            header('location:../Vista/Gestion_Direc.php');
            die();
            }
    }else{

        $miConsulta=$miPDO->prepare('SELECT * FROM directivos WHERE Id_directivo=:Id_directivo;');
        $miConsulta->execute(
            [
                'Id_directivo'=>$Id
            ]
            );
    }
    $directivos=$miConsulta->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Vista/Estilo/General.css">
    <script src="https://kit.fontawesome.com/5038b205c4.js" crossorigin="anonymous"></script>
    <link rel="shorcut icon" href="../Vista/IMG/escudo.png">
    <title>Modificar Directivo</title>
</head>
<body>
<section id="sectionEs">

        <header>
            <i class="fa-solid fa-user-tie" id="Icono"></i>
            <i class="fa-regular fa-pen-to-square" id="Icono-2"></i>
            <p id="head">Modificar Directivos</p>
            
        </header>

<form action="" method="post" id="formEs">

<br>

<!-- Primer Nombre  -->

<div class="camposEs">
    <i class="fa-solid fa-user"  ></i>
    <input type="text"   placeholder="Primer Nombre" id="user" id="i2" name="Nombre_Directivo" value="<?=$directivos['Nombre_Directivo']?>" autocomplete="off">
</div>


<!-- Segundo Nombre  -->

<div class="camposEs">
    <i class="fa-solid fa-user"  ></i>
    <input type="text"  placeholder="Segundo Nombre" id="user" id="i2" name="Nombre_Directivo_segundo" value="<?=$directivos['Nombre_Directivo_segundo']?>" autocomplete="off">
</div>
<br><br>

<!-- Primer Apellido -->

<div class="camposEs">
    <i class="fa-solid fa-user" ></i>
    <input type="text"  placeholder="Primer Apellido"  id="user" id="i2" name="Apellido_Directivo" value="<?=$directivos['Apellido_Directivo']?>" autocomplete="off">
</div>

<!-- Segundo Apellido -->

<div class="camposEs">
    <i class="fa-solid fa-user" ></i>
    <input type="text"  placeholder="Segundo Apellido" id="user" id="i2" name="Apellido_Directivo_segundo" value="<?=$directivos['Apellido_Directivo_segundo']?>" autocomplete="off">
</div>
<br> <br>

<!-- DI -->

<div class="camposEs">
<i class="fa-solid fa-address-card"></i>
<input type="text"  placeholder="Documento" id="user" id="i2" name="Documento_Direc" value="<?=$directivos['Documento_Direc']?>" oninput="validarNumeroInputDocumento(this)" autocomplete="off">
</div>   

<!-- Cargo -->
<div class="select">
        <select  id="format" name="Cargo">
            <option value="<?$directivos['Cargo']?>" selected disabled><?=$directivos['Cargo']?></option>
            <option value="Rector(a)">Rector(a)</option>
            <option value="Coordinador(a)">Coordinador(a)</option>
        </select>
    </div>    

<br>

<div id="cont-Boton-grande">
            <i class="fa-solid fa-user-plus" ></i> 
            <input type="hidden" name="Id_directivo" value="<?=$Id?>"> 
            <input type="submit" value="Modificar Directivo" id="open" name="modif-dic">
</div>

</form>
<button class="boton-animated" onclick="window.location.href='../Vista/Gestion_Direc.php'">
        <i class="fas fa-arrow-right"></i> Regresar
    </button>
</section> 
</body>
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
</html>