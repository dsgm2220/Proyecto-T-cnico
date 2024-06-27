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
    <title>Gestion de Directivos</title>
<!--Estilos de la tabla de consultas-->
<style>
        table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        margin-bottom:2.5%;
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
            #button-habilitar{
                background-color:rgb(72, 188, 107);
            }
            #button-habilitar:hover{
                background-color: rgb(0, 57, 91);
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
<section id="sectionEs">
        <header>
            <i class="fa-solid fa-user-tie" id="Icono"></i>
            <i class="fa-regular fa-pen-to-square" id="Icono-2"></i>
            <p id="head">Registrar Directivos</p>
            
        </header>

        <form action="" method="post" id="formEs">

<br>

<!-- Primer Nombre  -->

<div class="camposEs">
    <i class="fa-solid fa-user"  ></i>
    <input type="text"  placeholder="Primer Nombre"  id="user" id="i2" name="Nombre_Directivo" autocomplete="off">
</div>


<!-- Segundo Nombre  -->

<div class="camposEs">
    <i class="fa-solid fa-user"  ></i>
    <input type="text"  placeholder="Segundo Nombre"  id="user" id="i2" name="Nombre_Directivo_segundo" autocomplete="off">
</div>
<br><br>

<!-- Primer Apellido -->

<div class="camposEs">
    <i class="fa-solid fa-user" ></i>
    <input type="text"  placeholder="Primer Apellido"  id="user" id="i2" name="Apellido_Directivo" autocomplete="off">
</div>

<!-- Segundo Apellido -->

<div class="camposEs">
    <i class="fa-solid fa-user" ></i>
    <input type="text"  placeholder="Segundo Apellido"  id="user" id="i2" name="Apellido_Directivo_segundo" autocomplete="off">
</div>
<br> <br>

<!-- DI -->

<div class="camposEs">
<i class="fa-solid fa-address-card"></i>
<input type="text"  placeholder="Documento"  id="user" id="i2" name="Documento_Direc" required oninput="validarNumeroInputDocumento(this)" autocomplete="off">
</div>   

<!-- Contraseña -->

<div class="camposEs">
<i class="fa-solid fa-key"></i>
    <input type="text"  placeholder="Contraseña"  id="user" id="i2" name="contrasena" autocomplete="off">
</div>   


<!-- Cargo -->
<?php
if($Cargo == "Rector(a)" && $usuario == "Administrador Servidor"){
?>
<div class="select">
        <select  id="format" name="Cargo">
            <option selected disabled>Cargo</option>
            <option value="Rector(a)">Rector(a)</option>
            <option value="Coordinador(a)">Coordinador(a)</option>
        </select>
</div> 
<?php
}else{
?>
<div class="select">
        <select  id="format" name="Cargo">
            <option selected disabled>Cargo</option>
            <option value="Coordinador(a)">Coordinador(a)</option>
        </select>
</div> 
<?php
}?>

<br>

<div id="cont-Boton-grande">
    <i class="fa-solid fa-user-plus" ></i> 
    <input type="submit" value="Agregar Directivo" id="open" name="regis-direc">
</div>

</form>

<?php

            if(isset($_POST["regis-direc"])){
                $doc=isset($_REQUEST['Documento_Direc'])?$_REQUEST['Documento_Direc']:null;
                $sql="SELECT * FROM directivos WHERE Documento_Direc='$doc'";
                $doble = mysqli_query($conex,$sql);// Valida si el documento ingresado es igual a otro que ya este en la base de datos , de ser asi no podra ser registrado

                if(!$doble->num_rows>0){
                    $nombre=isset($_REQUEST['Nombre_Directivo'])?$_REQUEST['Nombre_Directivo']:null;
                    $nombre_2=isset($_REQUEST['Nombre_Directivo_segundo'])?$_REQUEST['Nombre_Directivo_segundo']:null;
                    $apellido=isset($_REQUEST['Apellido_Directivo'])?$_REQUEST['Apellido_Directivo']:null;
                    $apellido_2=isset($_REQUEST['Apellido_Directivo_segundo'])? $_REQUEST['Apellido_Directivo_segundo']:null;
                    $pass=isset($_REQUEST['contrasena'])? $_REQUEST['contrasena']:null;
                    $Cargo=isset($_REQUEST['Cargo'])? $_REQUEST['Cargo']:null;

                    $miInsert= $miPDO->prepare('INSERT INTO directivos(Nombre_Directivo,Nombre_Directivo_segundo,Apellido_Directivo,Apellido_Directivo_segundo,Documento_Direc,contraseña, Cargo,Activo) VALUES (:Nombre_Directivo,:Nombre_Directivo_segundo,:Apellido_Directivo,:Apellido_Directivo_segundo,:Documento_Direc,:contrasena,:Cargo,:Activo)');

                    $miInsert->execute(
                        array(
                            'Nombre_Directivo'=> $nombre,
                            'Nombre_Directivo_segundo'=> $nombre_2,
                            'Apellido_Directivo' => $apellido,
                            'Apellido_Directivo_segundo' => $apellido_2,
                            'Documento_Direc' => $doc,
                            'contrasena'=>password_hash($pass,PASSWORD_BCRYPT),
                            'Cargo' => $Cargo,
                            'Activo'=>1
                            )
                    );
                    if($miInsert){
                        ?>
                        <h4 class="ok">Directivo registrado correctamente</h4>
                        <?php
                    }
                }else{
                    ?>
                    <h4 class="F">Ya hay un Directivo registrado con ese Documento</h4>
                    <?php
                }
            }
?>

</section>


<!-- CONSULTAR DIRECTIVO -->

<section id="sectionC">
    <header>
        <i class="fa-solid fa-user-tie" id="Icono"></i>
        <i class="fa-solid fa-magnifying-glass" id="Icono-2"></i>
        <p id="head">Consultar Directivos</p>
    </header>

<form action="" method="post" id="formEs" onsubmit="redirigirATabla()">
    <br>
<!-- Primer Nombre  -->

<div class="camposEs">
    <i class="fa-solid fa-user"  ></i>
    <input type="text"  placeholder="Primer Nombre"  id="user" id="i2" name="Nombre_Directivo">
</div>


<!-- Segundo Nombre  -->

<div class="camposEs">
    <i class="fa-solid fa-user"  ></i>
    <input type="text"  placeholder="Segundo Nombre"  id="user" id="i2" name="Nombre_Directivo_segundo">
</div>
<br><br>

<!-- Primer Apellido -->

<div class="camposEs">
    <i class="fa-solid fa-user" ></i>
    <input type="text"  placeholder="Primer Apellido"  id="user" id="i2" name="Apellido_Directivo">
</div>

<!-- Segundo Apellido -->

<div class="camposEs">
    <i class="fa-solid fa-user" ></i>
    <input type="text"  placeholder="Segundo Apellido"  id="user" id="i2" name="Apellido_Directivo_segundo">
</div>
<br> <br>

<!-- DI -->

<div class="camposEs">
<i class="fa-solid fa-address-card"></i>
<input type="text"  placeholder="Documento"  id="user" id="i2" name="Documento_Direc" oninput="validarNumeroInputDocumento(this)">
</div>   


<!-- Cargo -->
<div class="select">
        <select  id="format" name="Cargo">
            <option selected disabled>Cargo</option>
            <option value="Rector(a)">Rector(a)</option>
            <option value="Coordinador(a)">Coordinador(a)</option>
        </select>
</div>    
 

    <br>
    <div id="cont-Boton-grande">        
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="submit" value="Consultar Directivo" id="DiferenteT" name="consul-dir">
    </div>

</form>

<br> <br> 

<!-- Tabla de consulta -->
<table id="tablaResultados">
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Documento</th>
                                <th>Cargo</th>
                                <th>Modificar<i class="fa-solid fa-pen"></i></th>
                                <th>Hab<i class="fa-solid fa-user-large"></i>/Inh<i class="fa-solid fa-user-large-slash"></i></th>
                            </tr>

<!--Php de las consultas-->
<?php

if(isset($_POST["consul-dir"])){
    if(strlen($_POST["Nombre_Directivo"])>=1){
        $nombre=isset($_REQUEST['Nombre_Directivo'])?$_REQUEST['Nombre_Directivo']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM directivos WHERE Nombre_Directivo='$nombre'");
        $miConsulta->execute();

        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Directivo no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                <td> <?= $valor ['Nombre_Directivo']?> <?= $valor ['Nombre_Directivo_segundo']?> </td>
                <td> <?= $valor ['Apellido_Directivo']?> <?= $valor ['Apellido_Directivo_segundo']?> </td>
                <td> <?= $valor ['Documento_Direc'] ?> </td>
                <td> <?= $valor ['Cargo'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Dir.php?Id_directivo=<?=$valor['Id_directivo']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>

            </tr>
                <?php
                endforeach;}
    }elseif(strlen($_POST["Nombre_Directivo_segundo"])>=1){
        $nombre_2=isset($_REQUEST['Nombre_Directivo_segundo'])?$_REQUEST['Nombre_Directivo_segundo']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM directivos WHERE Nombre_Directivo_segundo='$nombre_2'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Directivo no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                <td> <?= $valor ['Nombre_Directivo']?> <?= $valor ['Nombre_Directivo_segundo']?> </td>
                <td> <?= $valor ['Apellido_Directivo']?> <?= $valor ['Apellido_Directivo_segundo']?> </td>
                <td> <?= $valor ['Documento_Direc'] ?> </td>
                <td> <?= $valor ['Cargo'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Dir.php?Id_directivo=<?=$valor['Id_directivo']?>">Modificar <i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
                <?php
                endforeach;}
    }elseif(strlen($_POST["Apellido_Directivo"])>=1){
        $apellido=isset($_REQUEST['Apellido_Directivo'])?$_REQUEST['Apellido_Directivo']:null;

        $miConsulta=$miPDO->prepare("SELECT * FROM directivos WHERE Apellido_Directivos='$apellido'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Directivo no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                <td> <?= $valor ['Nombre_Directivo']?> <?= $valor ['Nombre_Directivo_segundo']?> </td>
                <td> <?= $valor ['Apellido_Directivo']?> <?= $valor ['Apellido_Directivo_segundo']?> </td>
                <td> <?= $valor ['Documento_Direc'] ?> </td>
                <td> <?= $valor ['Cargo'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Dir.php?Id_directivo=<?=$valor['Id_directivo']?>">Modificar <i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
                <?php
                endforeach;}
    }elseif(strlen($_POST["Apellido_Directivo_segundo"])>=1){
        $apellido_2=isset($_REQUEST['Apellido_Directivo_segundo'])? $_REQUEST['Apellido_Directivo_segundo']:null;

        $miConsulta=$miPDO->prepare("SELECT * FROM directivos WHERE Apellido_Directivo_segundo='$apellido_2'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Directivo no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                <td> <?= $valor ['Nombre_Directivo']?> <?= $valor ['Nombre_Directivo_segundo']?> </td>
                <td> <?= $valor ['Apellido_Directivo']?> <?= $valor ['Apellido_Directivo_segundo']?> </td>
                <td> <?= $valor ['Documento_Direc'] ?> </td>
                <td> <?= $valor ['Cargo'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Dir.php?Id_directivo=<?=$valor['Id_directivo']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>

            </tr>
                <?php
                endforeach;}
    }elseif(strlen($_POST["Documento_Direc"])>=1){
        $doc=isset($_REQUEST['Documento_Direc'])?$_REQUEST['Documento_Direc']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM directivos WHERE Documento_Direc='$doc'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Directivo no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                <td> <?= $valor ['Nombre_Directivo']?> <?= $valor ['Nombre_Directivo_segundo']?> </td>
                <td> <?= $valor ['Apellido_Directivo']?> <?= $valor ['Apellido_Directivo_segundo']?> </td>
                <td> <?= $valor ['Documento_Direc'] ?> </td>
                <td> <?= $valor ['Cargo'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Dir.php?Id_directivo=<?=$valor['Id_directivo']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>

            </tr>
                <?php
                endforeach;}
    }elseif(strlen($_POST["Cargo"])>=1){
        $Cargo=isset($_REQUEST['Cargo'])? $_REQUEST['Cargo']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM directivos WHERE Cargo='$Cargo'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Directivo no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                <td> <?= $valor ['Nombre_Directivo']?> <?= $valor ['Nombre_Directivo_segundo']?> </td>
                <td> <?= $valor ['Apellido_Directivo']?> <?= $valor ['Apellido_Directivo_segundo']?> </td>
                <td> <?= $valor ['Documento_Direc'] ?> </td>
                <td> <?= $valor ['Cargo'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Dir.php?Id_directivo=<?=$valor['Id_directivo']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_directivo=<?= $valor['Id_directivo'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>

            </tr>
                <?php
                endforeach;}
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
    <script src="JS/Login.js"></script>
    <script>
        function redirigirATabla() {
            window.location.hash = 'tablaResultados';
        }


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