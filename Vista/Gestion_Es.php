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
    <title>Gestion Estudiantes</title>
<!-- Estilos de tabla de consulta -->
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
<!-- FORMULARIO  -->
            <i class="fa-solid fa-graduation-cap" id="Icono"></i>
            <i class="fa-regular fa-pen-to-square" id="Icono-2"></i>
            <p id="head">Registrar Estudiantes</p>
            
        </header>

    <form action="" method="post" id="formEs">

        <br>

    <!-- Primer Nombre  -->
    
        <div class="camposEs">
            <i class="fa-solid fa-user"  ></i>
            <input type="text"  placeholder="Primer Nombre"  id="user" id="i2" name="Nombre_estudiante"autocomplete="off">
        </div>


    <!-- Segundo Nombre  -->
    
    <div class="camposEs">
            <i class="fa-solid fa-user"  ></i>
            <input type="text"  placeholder="Segundo Nombre"  id="user" id="i2" name="Nombre_estudiante_segundo" autocomplete="off">
        </div>
<br><br>

    <!-- Primer Apellido -->

    <div class="camposEs">
            <i class="fa-solid fa-user" ></i>
            <input type="text"  placeholder="Primer Apellido"  id="user" id="i2" name="Apellido_estudiante" autocomplete="off">
    </div>

    <!-- Segundo Apellido -->

    <div class="camposEs">
            <i class="fa-solid fa-user" ></i>
            <input type="text"  placeholder="Segundo Apellido"  id="user" id="i2" name="Apellido_estudiante_segundo" autocomplete="off">
    </div>
<br> <br>

    <!-- DI -->

    <div class="camposEs">
    <i class="fa-solid fa-address-card"></i>
        <input type="text"  placeholder="Documento"  id="user" id="i2" name="Documento_estudiante" required oninput="validarNumeroInputDocumento(this)" autocomplete="off">
    </div>   

    <!-- Contraseña -->

    <div class="camposEs">
    <i class="fa-solid fa-key"></i>
        <input type="text"  placeholder="Contraseña"  id="user" id="i2" name="contrasena">
    </div>   

<!-- Curso -->

    <div class="select">
    <select  id='format' name="Numero_curso_pertenece">
        <?php
        $consulta= "SELECT * FROM cursos ORDER BY Numero_Curso ASC;";
        $result= $conex->query($consulta);
        echo "<option selected disabled>Curso</option>";
        while ($row = $result->fetch_assoc()){
            echo '<option value="' . $row['Numero_Curso'] . '" >' . $row['Numero_Curso'] . '</option>';
        }
        ?>
    </select>
    </div>
    
        <br>

        <div id="cont-Boton-grande">
            <i class="fa-solid fa-user-plus" ></i> 
            <input type="submit" value="Agregar Estudiante" id="open" name="regis-est">
        </div>

    </form>

<!-- Php de registro de los estudiantes -->

<?php
if(isset($_POST["regis-est"])){
                
    $doc=isset($_REQUEST['Documento_estudiante'])?$_REQUEST['Documento_estudiante']:null;
    $sql="SELECT * FROM estudiantes WHERE Documento_Estudiante='$doc'";
    $doble =  mysqli_query($conex,$sql); // Valida si el documento ingresado es igual a otro que ya este en la base de datos , de ser asi no podra ser registrado
    
    if(!$doble->num_rows>0){

    $nombre=isset($_REQUEST['Nombre_estudiante'])?$_REQUEST['Nombre_estudiante']:null;
    $nombre_2=isset($_REQUEST['Nombre_estudiante_segundo'])?$_REQUEST['Nombre_estudiante_segundo']:null;
    $apellido=isset($_REQUEST['Apellido_estudiante'])?$_REQUEST['Apellido_estudiante']:null;
    $apellido_2=isset($_REQUEST['Apellido_estudiante_segundo'])? $_REQUEST['Apellido_estudiante_segundo']:null;
    $pass=isset($_REQUEST['contrasena'])? $_REQUEST['contrasena']:null;
    $curso_per=isset($_REQUEST['Numero_curso_pertenece'])? $_REQUEST['Numero_curso_pertenece']:null;

    $miInsert= $miPDO->prepare('INSERT INTO estudiantes(Nombre_Estudiante,Nombre_Estudiante_2,Apellido_Estudiante,Apellido_Estudiante_2,Documento_Estudiante,contraseña, Numero_Curso_pertenece,Activo) VALUES (:Nombre_estudiante,:Nombre_estudiante_segundo,:Apellido_estudiante,:Apellido_estudiante_segundo,:Documento_estudiante,:contrasena,:Numero_curso_pertenece,:Activo)');

    $miInsert->execute(
        array(
                'Nombre_estudiante'=> $nombre,
                'Nombre_estudiante_segundo'=> $nombre_2,
                'Apellido_estudiante' => $apellido,
                'Apellido_estudiante_segundo' => $apellido_2,
                'Documento_estudiante' => $doc,
                'contrasena'=>password_hash($pass,PASSWORD_BCRYPT),
                'Numero_curso_pertenece' => $curso_per,
                'Activo'=> 1
            )
    );
    if($miInsert){
        ?>
        <h4 class="ok">Estudiante registrado correctamente</h4>
        <?php
    }
}else{
        ?>
        <h4 class="F">Ya hay un estudiante registrado con ese Documento</h4>
        <?php
    }
}
?>
</section>

<!-- CONSULTAR ESTUDIANTES -->

<section id="sectionC">
    <header>
        <i class="fa-solid fa-graduation-cap" id="Icono"></i>
        <i class="fa-solid fa-magnifying-glass" id="Icono-2"></i>
        <p id="head">Consultar Estudiantes</p>
    </header>


<form action="" method="post" id="formEs" onsubmit="redirigirATabla()">
    
    <br>

    <!-- Primer Nombre  -->
    
    <div class="camposEs">
            <i class="fa-solid fa-user"  ></i>
            <input type="text"  placeholder="Primer Nombre"  id="user" id="i2" name="Nombre_estudiante" >
        </div>


    <!-- Segundo Nombre  -->
    
    <div class="camposEs">
            <i class="fa-solid fa-user"  ></i>
            <input type="text"  placeholder="Segundo Nombre"  id="user" id="i2" name="Nombre_estudiante_segundo">
        </div>
<br><br>

    <!-- Primer Apellido -->

    <div class="camposEs">
            <i class="fa-solid fa-user" ></i>
            <input type="text"  placeholder="Primer Apellido"  id="user" id="i2" name="Apellido_estudiante" >
    </div>

    <!-- Segundo Apellido -->

    <div class="camposEs">
            <i class="fa-solid fa-user" ></i>
            <input type="text"  placeholder="Segundo Apellido"  id="user" id="i2" name="Apellido_estudiante_segundo">
    </div>
<br> <br>

    <!-- DI -->

    <div class="camposEs">
    <i class="fa-solid fa-address-card"></i>
        <input type="text"  placeholder="Documento"  id="user" id="i2" name="Documento_estudiante" oninput="validarNumeroInputDocumento(this)">
    </div>

<!-- Curso -->

    <div class="select">
    <select  id='format' name="Numero_curso_pertenece">
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
    <br>
    <div id="cont-Boton-grande">        
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="submit" value="Consultar Estudiante" id="DiferenteT" name="consul-est">
    </div>

</form>

<br> <br> 

<!-- Tabla de consulta -->

<table id="tablaResultados">
                            <tr>
                                
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Documento</th>
                                <th>Curso</th>
                                <th>Modificar<i class="fa-solid fa-pen"></i></th>
                                <th>Hab<i class="fa-solid fa-user-large"></i>/Inh<i class="fa-solid fa-user-large-slash"></i></th>
                            </tr>


<!--Php de las consultas-->

<?php
if(isset($_POST["consul-est"])){
    if(strlen($_POST["Nombre_estudiante"])>=1){
        $nombre=isset($_REQUEST['Nombre_estudiante'])?$_REQUEST['Nombre_estudiante']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM estudiantes WHERE Nombre_estudiante='$nombre'");
        $miConsulta->execute();

        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Estudiante no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                
                <td> <?= $valor ['Nombre_Estudiante']?> <?= $valor ['Nombre_Estudiante_2']?> </td>
                <td> <?= $valor ['Apellido_Estudiante']?> <?= $valor ['Apellido_Estudiante_2']?> </td>
                <td> <?= $valor ['Documento_Estudiante'] ?> </td>
                <td> <?= $valor ['Numero_Curso_pertenece'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Es.php?Id_estudiantes=<?=$valor['Id_estudiantes']?>">Modificar <i class="fa-solid fa-pen"></i></a></td>

                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button"  id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button"  id="button-habilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>

            </tr>
                <?php
                endforeach;}
    }elseif(strlen($_POST["Nombre_estudiante_segundo"])>=1){
        $nombre_2=isset($_REQUEST['Nombre_estudiante_segundo'])?$_REQUEST['Nombre_estudiante_segundo']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM estudiantes WHERE Nombre_estudiante_2='$nombre_2'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Estudiante no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                
                <td> <?= $valor ['Nombre_Estudiante']?> <?= $valor ['Nombre_Estudiante_2']?> </td>
                <td> <?= $valor ['Apellido_Estudiante']?> <?= $valor ['Apellido_Estudiante_2']?> </td>
                <td> <?= $valor ['Documento_Estudiante'] ?> </td>
                <td> <?= $valor ['Numero_Curso_pertenece'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Es.php?Id_estudiantes=<?=$valor['Id_estudiantes']?>">Modificar <i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button"   id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
                <?php
                endforeach;}
    }elseif(strlen($_POST["Apellido_estudiante"])>=1){
        $apellido=isset($_REQUEST['Apellido_estudiante'])?$_REQUEST['Apellido_estudiante']:null;

        $miConsulta=$miPDO->prepare("SELECT * FROM estudiantes WHERE Apellido_estudiante='$apellido'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Estudiante no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                
                <td> <?= $valor ['Nombre_Estudiante']?> <?= $valor ['Nombre_Estudiante_2']?> </td>
                <td> <?= $valor ['Apellido_Estudiante']?> <?= $valor ['Apellido_Estudiante_2']?> </td>
                <td> <?= $valor ['Documento_Estudiante'] ?> </td>
                <td> <?= $valor ['Numero_Curso_pertenece'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Es.php?Id_estudiantes=<?=$valor['Id_estudiantes']?>">Modificar <i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button"  id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
                <?php
                endforeach;}
    }elseif(strlen($_POST["Apellido_estudiante_segundo"])>=1){
        $apellido_2=isset($_REQUEST['Apellido_estudiante_segundo'])? $_REQUEST['Apellido_estudiante_segundo']:null;

        $miConsulta=$miPDO->prepare("SELECT * FROM estudiantes WHERE Apellido_estudiante_2='$apellido_2'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Estudiante no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                
                <td> <?= $valor ['Nombre_Estudiante']?> <?= $valor ['Nombre_Estudiante_2']?> </td>
                <td> <?= $valor ['Apellido_Estudiante']?> <?= $valor ['Apellido_Estudiante_2']?> </td>
                <td> <?= $valor ['Documento_Estudiante'] ?> </td>
                <td> <?= $valor ['Numero_Curso_pertenece'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Es.php?Id_estudiantes=<?=$valor['Id_estudiantes']?>">Modificar <i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>

            </tr>
                <?php
                endforeach;}
    }elseif(strlen($_POST["Documento_estudiante"])>=1){
        $doc=isset($_REQUEST['Documento_estudiante'])?$_REQUEST['Documento_estudiante']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM estudiantes WHERE Documento_estudiante='$doc'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Estudiante no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                
                <td> <?= $valor ['Nombre_Estudiante']?> <?= $valor ['Nombre_Estudiante_2']?> </td>
                <td> <?= $valor ['Apellido_Estudiante']?> <?= $valor ['Apellido_Estudiante_2']?> </td>
                <td> <?= $valor ['Documento_Estudiante'] ?> </td>
                <td> <?= $valor ['Numero_Curso_pertenece'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Es.php?Id_estudiantes=<?=$valor['Id_estudiantes']?>">Modificar <i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button"  id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>

            </tr>
                <?php
                endforeach;}
    }elseif(strlen($_POST["Numero_curso_pertenece"])>=1){
        $curso_per=isset($_REQUEST['Numero_curso_pertenece'])? $_REQUEST['Numero_curso_pertenece']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM estudiantes WHERE Numero_curso_pertenece='$curso_per'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Estudiante no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 
                
                ?>
                
            <tr>
                
                <td> <?= $valor ['Nombre_Estudiante']?> <?= $valor ['Nombre_Estudiante_2']?> </td>
                <td> <?= $valor ['Apellido_Estudiante']?> <?= $valor ['Apellido_Estudiante_2']?> </td>
                <td> <?= $valor ['Documento_Estudiante'] ?> </td>
                <td> <?= $valor ['Numero_Curso_pertenece'] ?> </td>

                <td> <a  class="button" href="../Modelo/Modificar_Es.php?Id_estudiantes=<?=$valor['Id_estudiantes']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button" id="button-habilitar" href="../Modelo/Borrar.php?Id_estudiantes=<?= $valor['Id_estudiantes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
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

    <script src="JS/script.js"></script>    
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