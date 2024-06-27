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
    $Id=isset($_REQUEST['Id_estudiantes'])?$_REQUEST['Id_estudiantes']:null;
    $nombre=isset($_REQUEST['Nombre_estudiante'])?$_REQUEST['Nombre_estudiante']:null;
    $nombre_2=isset($_REQUEST['Nombre_estudiante_segundo'])?$_REQUEST['Nombre_estudiante_segundo']:null;
    $apellido=isset($_REQUEST['Apellido_estudiante'])?$_REQUEST['Apellido_estudiante']:null;
    $apellido_2=isset($_REQUEST['Apellido_estudiante_segundo'])? $_REQUEST['Apellido_estudiante_segundo']:null;
    $doc=isset($_REQUEST['Documento_estudiante'])?$_REQUEST['Documento_estudiante']:null;
    $curso_per=isset($_REQUEST['Numero_curso_pertenece'])? $_REQUEST['Numero_curso_pertenece']:null;
    $hostPDO="mysql:host=$hostDB;dbname=$nombreDB;";
    $miPDO= new PDO($hostPDO,$usuarioDB,$contrasenaDB);

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $miupdate=$miPDO->prepare('UPDATE estudiantes SET Nombre_Estudiante=:Nombre_estudiante, Nombre_Estudiante_2=:Nombre_estudiante_segundo, Apellido_Estudiante=:Apellido_estudiante, Apellido_Estudiante_2=:Apellido_estudiante_segundo, Documento_Estudiante=:Documento_estudiante, Numero_Curso_pertenece=:Numero_curso_pertenece WHERE Id_estudiantes=:Id_estudiantes');
        $miupdate->execute(
            [
                'Id_estudiantes'=>$Id,
                'Nombre_estudiante'=> $nombre,
                'Nombre_estudiante_segundo'=> $nombre_2,
                'Apellido_estudiante' => $apellido,
                'Apellido_estudiante_segundo' => $apellido_2,
                'Documento_estudiante' => $doc,
                'Numero_curso_pertenece' => $curso_per
            ]
            );
            if($miupdate){

            // Después de actualizar los datos con éxito
            $_SESSION['actualizacion_exitosa'] = true;
            header('location:../Vista/Gestion_Es.php?modificacion_exitosa=1');
            die();
            }
    }else{

        $miConsulta=$miPDO->prepare('SELECT * FROM estudiantes WHERE Id_estudiantes=:Id_estudiantes;');
        $miConsulta->execute(
            [
                'Id_estudiantes'=>$Id
            ]
            );
    }
    $estudiantes=$miConsulta->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Vista/Estilo/General.css">
    <script src="https://kit.fontawesome.com/5038b205c4.js" crossorigin="anonymous"></script>
    <link rel="shorcut icon" href="../Vista/IMG/escudo.png">
    <title>Modificar</title>
</head>
<body>
<section id="sectionEs">

<header>

    <i class="fa-solid fa-graduation-cap" id="Icono"></i>
    <i class="fa-regular fa-pen-to-square" id="Icono-2"></i>
    <p id="head">Modificar Estudiante</p>
    
</header>

<form action="" method="post" id="formEs">

<br>

<!-- Primer Nombre  -->

<div class="camposEs">
    <i class="fa-solid fa-user"  ></i>
    <input type="text"  placeholder="Primer Nombre" id="user" id="i2" name="Nombre_estudiante" value="<?=$estudiantes['Nombre_Estudiante']?>" autocomplete="off">
</div>


<!-- Segundo Nombre  -->

<div class="camposEs">
    <i class="fa-solid fa-user"  ></i>
    <input type="text"  placeholder="Segundo Nombre" id="user" id="i2" name="Nombre_estudiante_segundo" value="<?=$estudiantes['Nombre_Estudiante_2']?>" autocomplete="off">
</div> 
<br><br>

<!-- Primer Apellido -->

<div class="camposEs">
    <i class="fa-solid fa-user" ></i>
    <input type="text"  placeholder="Primer Apellido" id="user" id="i2" name="Apellido_estudiante" value="<?=$estudiantes['Apellido_Estudiante']?>" autocomplete="off">
</div>

<!-- Segundo Apellido -->

<div class="camposEs">
    <i class="fa-solid fa-user" ></i>
    <input type="text" placeholder="Segundo Apellido"  id="user" id="i2" name="Apellido_estudiante_segundo" value="<?=$estudiantes['Apellido_Estudiante_2']?>" autocomplete="off">
</div>
<br> <br>

<!-- DI -->

<div class="camposEs">
<i class="fa-solid fa-user"  ></i>
<input type="text" placeholder="Documento" id="user" id="i2" name="Documento_estudiante" value="<?=$estudiantes['Documento_Estudiante']?>" oninput="validarNumeroInputDocumento(this)" autocomplete="off">
</div>   

<!-- Curso -->

<div class="select">
<select  id='format' name="Numero_curso_pertenece">
<?php
include("conec_BD.php");
$consulta= "SELECT * FROM cursos ORDER BY Numero_Curso ASC;";
$result= $conex->query($consulta);
//echo "<option selected disabled>Curso</option>";
echo '<option value="' . $estudiantes['Numero_Curso_pertenece'] . '" >' . $estudiantes['Numero_Curso_pertenece'] . '</option>';
while ($row = $result->fetch_assoc()){
    echo '<option value="' . $row['Numero_Curso'] . '" >' . $row['Numero_Curso'] . '</option>';
}
?>
</select>
</div>

<br>

<div id="cont-Boton">
    <i class="fa-solid fa-user-plus" ></i>
    <input type="hidden" name="Id_estudiantes" value="<?=$Id?>"> 
    <input type="submit" value="Modificar" id="open">
</div>

</form>

<button class="boton-animated" onclick="window.location.href='../Vista/Gestion_Es.php'">
        <i class="fas fa-arrow-right"></i> Regresar
</button>
</section>
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