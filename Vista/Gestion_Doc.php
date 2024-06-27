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
    <title>Gestion Docentes</title>
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
            padding:0.3rem;
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
        #sectionCDocentes{
            height: 550px; /* Establece la altura del section */
            overflow-y: auto; /* Agrega desplazamiento vertical cuando el contenido supera la altura */
            width:86.5%;
            margin-left: 6.5%;
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
            <i class="fa-solid fa-chalkboard-user" id="Icono"></i>
            <i class="fa-regular fa-pen-to-square" id="Icono-2"></i>
            <p id="head">Registrar Docentes</p>
            
        </header>

    <form action="" method="post" id="formEs">
        <br>
    <!-- Primer Nombre  -->
    
        <div class="camposEs">
            <i class="fa-solid fa-user"  ></i>
            <input type="text"  placeholder="Primer Nombre"  id="user" id="i2" name="Nombre_Docente" autocomplete="off">
        </div>


    <!-- Segundo Nombre  -->
    
    <div class="camposEs">
            <i class="fa-solid fa-user"  ></i>
            <input type="text"  placeholder="Segundo Nombre"  id="user" id="i2" name="Nombre_Docente_segundo" autocomplete="off">
        </div>
<br><br>

    <!-- Primer Apellido -->

    <div class="camposEs">
            <i class="fa-solid fa-user" ></i>
            <input type="text"  placeholder="Primer Apellido"  id="user" id="i2" name="Apellido_Docente" autocomplete="off">
    </div>

    <!-- Segundo Apellido -->

    <div class="camposEs">
            <i class="fa-solid fa-user" ></i>
            <input type="text"  placeholder="Segundo Apellido"  id="user" id="i2" name="Apellido_Docente_segundo" autocomplete="off">
    </div>
<br> <br>

    <!-- DI -->

    <div class="camposEs">
    <i class="fa-solid fa-address-card"></i>
        <input type="text"  placeholder="Documento"  id="user" id="i2" name="Documento_Docente" required oninput="validarNumeroInputDocumento(this)" autocomplete="off">
    </div>   

    <!-- Contraseña -->

    <div class="camposEs">
    <i class="fa-solid fa-key"></i>
        <input type="text"  placeholder="Contraseña"  id="user" id="i2" name="contrasena" required>
    </div>   

    <!-- Curso -->

    <div class="container">
        <p id="Asign"><strong>Asignar Cursos :</strong></p>
        <div class="custom-combobox-container">
            <div class="custom-combobox" onclick="showOptions(this)">
                <input type="text" id="inputCheckbox" readonly>
                <img src="IMG/arrowl.png">
            </div>
            <div class="options-container" id="divOptions" onmouseleave="hideOptions(this)">
            <?php
            $consulta= "SELECT * FROM cursos ORDER BY Numero_Curso ASC;";
            $result= $conex->query($consulta);
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
                <img src="IMG/arrowl.png">
            </div>
            <div class="options-container" id="divOptions2" onmouseleave="hideOptions2(this)">
            <?php
            $consulta= "SELECT * FROM materias ";
            $result= $conex->query($consulta);
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
            <input type="submit" value="Agregar Docente" id="open" name="regis-doc">
        </div>

    </form>
    <?php
if(isset($_POST["regis-doc"])){

    $doc=isset($_REQUEST['Documento_Docente'])?$_REQUEST['Documento_Docente']:null;
    $sql="SELECT * FROM docentes WHERE Documento_Docente='$doc'";
    $doble =  mysqli_query($conex,$sql); // Valida si el documento ingresado es igual a otro que ya este en la base de datos , de ser asi no podra ser registrado

    if(!$doble->num_rows>0){

        $nombre=isset($_REQUEST['Nombre_Docente'])?$_REQUEST['Nombre_Docente']:null;
        $nombre_2=isset($_REQUEST['Nombre_Docente_segundo'])?$_REQUEST['Nombre_Docente_segundo']:null;
        $apellido=isset($_REQUEST['Apellido_Docente'])?$_REQUEST['Apellido_Docente']:null;
        $apellido_2=isset($_REQUEST['Apellido_Docente_segundo'])? $_REQUEST['Apellido_Docente_segundo']:null;
        $pass=isset($_REQUEST['contrasena'])? $_REQUEST['contrasena']:null;
        $materias=isset($_REQUEST['Materias_Seleccionadas'])? $_REQUEST['Materias_Seleccionadas']:null;
        $cursos = isset($_REQUEST['Cursos_Seleccionados'])? $_REQUEST['Cursos_Seleccionados']:null;

        $materiasJSON = json_encode($materias,JSON_UNESCAPED_UNICODE );
        $cursosJSON = json_encode($cursos,JSON_UNESCAPED_UNICODE );

        $miInsert= $miPDO->prepare('INSERT INTO docentes(Nombre_Docente,Nombre_Docente_2,Apellido_Docente,Apellido_Docente_2,Documento_Docente,contraseña,Nombre_Materia_Asignada, Numero_curso_asignado,Activo ) VALUES (:Nombre_Docente,:Nombre_Docente_segundo,:Apellido_Docente,:Apellido_Docente_segundo,:Documento_Docente,:contrasena,:Materias_Seleccionadas,:Cursos_Seleccionados,:Activo)');

        $miInsert->execute(
        array(
                'Nombre_Docente'=> $nombre,
                'Nombre_Docente_segundo'=> $nombre_2,
                'Apellido_Docente' => $apellido,
                'Apellido_Docente_segundo' => $apellido_2,
                'Documento_Docente' => $doc,
                'contrasena'=>password_hash($pass,PASSWORD_BCRYPT),
                'Materias_Seleccionadas' => $materiasJSON,
                'Cursos_Seleccionados' => $cursosJSON,
                'Activo'=> 1
            )
        );
    if($miInsert){
        ?>
        <h4 class="ok">Docente registrado correctamente</h4>
        <?php
    }
}else{
    ?>
    <h4 class="F">Ya hay un Docente registrado con ese Documento</h4>
    <?php
}
}



?>
</section>


<!-- CONSULTAR DOCENTES -->

<section id="sectionCDocentes">
    <header>
        <i class="fa-solid fa-chalkboard-user" id="Icono"></i>
        <i class="fa-solid fa-magnifying-glass" id="Icono-2"></i>
        <p id="head">Consultar Docente</p>
    </header>


    <form action="" method="post" id="formEs" onsubmit="redirigirATabla()">
    <br>
    <!-- Primer Nombre  -->
    
    <div class="camposEs">
            <i class="fa-solid fa-user"  ></i>
            <input type="text"  placeholder="Primer Nombre"  id="user" id="i2" name="Nombre_Docente" autocomplete="off">
        </div>


    <!-- Segundo Nombre  -->
    
    <div class="camposEs">
            <i class="fa-solid fa-user"  ></i>
            <input type="text"  placeholder="Segundo Nombre"  id="user" id="i2" name="Nombre_Docente_segundo" autocomplete="off">
        </div>
<br><br>

    <!-- Primer Apellido -->

    <div class="camposEs">
            <i class="fa-solid fa-user" ></i>
            <input type="text"  placeholder="Primer Apellido"  id="user" id="i2" name="Apellido_Docente" autocomplete="off">
    </div>

    <!-- Segundo Apellido -->

    <div class="camposEs">
            <i class="fa-solid fa-user" ></i>
            <input type="text"  placeholder="Segundo Apellido"  id="user" id="i2" name="Apellido_Docente_segundo" autocomplete="off">
    </div>
<br> <br>

    <!-- DI -->

    <div class="camposEs">
    <i class="fa-solid fa-address-card"></i>
        <input type="text"  placeholder="Documento"  id="user" id="i2" name="Documento_Docente" oninput="validarNumeroInputDocumento(this)">
    </div>   

        <br>

    <div id="cont-Boton-grande">        
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="submit" value="Consultar Docente" id="DiferenteT" name="consul-doc">
    </div>

</form>

<br> <br>

<table id="tablaResultados">
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Documento</th>
                                <th>Materias</th>
                                <th>Cursos</th>
                                <th>Modificar<i class="fa-solid fa-pen"></i></th>
                                <th>Hab<i class="fa-solid fa-user-large"></i>/Inh<i class="fa-solid fa-user-large-slash"></i></th>
                            </tr>

<?php
if(isset($_POST["consul-doc"])){
    if(strlen($_POST["Nombre_Docente"])>=1){
        $nombre=isset($_REQUEST['Nombre_Docente'])?$_REQUEST['Nombre_Docente']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM docentes WHERE Nombre_Docente='$nombre'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Docente no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 

                    $materiasDecoded = json_decode($valor['Nombre_Materia_Asignada'], true);
                    $cursosDecoded = json_decode($valor['Numero_curso_asignado'], true);
                ?>
                
            <tr>
                
                <td> <?= $valor ['Nombre_Docente']?> <?= $valor ['Nombre_Docente_2']?> </td>
                <td> <?= $valor ['Apellido_Docente']?> <?= $valor ['Apellido_Docente_2']?> </td>
                <td> <?= $valor ['Documento_Docente'] ?> </td>
                <?php
                // Recorrer y mostrar los campos decodificados
                echo '<td>';
                foreach ($materiasDecoded as $materia) {
                    echo "$materia<br>";
                }
                echo '</td>';
                echo '<td>';
                foreach ($cursosDecoded as $curso) {
                    echo "$curso<br>";
                }
                echo '</td>';
                ?>

                <td> <a  class="button" href="../Modelo/Modificar_Doc.php?Id_docentes=<?=$valor['Id_docentes']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button"  id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_docentes=<?= $valor['Id_docentes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button"  id="button-habilitar" href="../Modelo/Borrar.php?Id_docentes=<?= $valor['Id_docentes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>

            </tr>
                <?php
                endforeach;}               
    }elseif(strlen($_POST["Nombre_Docente_segundo"])>=1){
        $nombre_2=isset($_REQUEST['Nombre_Docente_segundo'])?$_REQUEST['Nombre_Docente_segundo']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM docentes WHERE Nombre_Docente_2='$nombre_2'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Docente no encontrado</h4>";
        }else{
                foreach($miConsulta as $clave =>$valor): 

                    $materiasDecoded = json_decode($valor['Nombre_Materia_Asignada'], true);
                    $cursosDecoded = json_decode($valor['Numero_curso_asignado'], true);
                ?>
                
            <tr>
                
                <td> <?= $valor ['Nombre_Docente']?> <?= $valor ['Nombre_Docente_2']?> </td>
                <td> <?= $valor ['Apellido_Docente']?> <?= $valor ['Apellido_Docente_2']?> </td>
                <td> <?= $valor ['Documento_Docente'] ?> </td>
                <?php
                // Recorrer y mostrar los campos decodificados
                echo '<td>';
                foreach ($materiasDecoded as $materia) {
                    echo "$materia<br>";
                }
                echo '</td>';
                echo '<td>';
                foreach ($cursosDecoded as $curso) {
                    echo "$curso<br>";
                }
                echo '</td>';
                ?>

                <td > <a  class="button" href="../Modelo/Modificar_Doc.php?Id_docentes=<?=$valor['Id_docentes']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button"  id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_docentes=<?= $valor['Id_docentes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button"  id="button-habilitar" href="../Modelo/Borrar.php?Id_docentes=<?= $valor['Id_docentes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>

            </tr>
                <?php
                endforeach;}      
    }elseif(strlen($_POST["Apellido_Docente"])>=1){
        $apellido=isset($_REQUEST['Apellido_Docente'])?$_REQUEST['Apellido_Docente']:null;

        $miConsulta=$miPDO->prepare("SELECT * FROM docentes WHERE Apellido_Docente='$apellido'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Docente no encontrado</h4>";
        }else{
            foreach($miConsulta as $clave =>$valor): 

                $materiasDecoded = json_decode($valor['Nombre_Materia_Asignada'], true);
                $cursosDecoded = json_decode($valor['Numero_curso_asignado'], true);
            ?>
            
        <tr>
            
            <td> <?= $valor ['Nombre_Docente']?> <?= $valor ['Nombre_Docente_2']?> </td>
            <td> <?= $valor ['Apellido_Docente']?> <?= $valor ['Apellido_Docente_2']?> </td>
            <td> <?= $valor ['Documento_Docente'] ?> </td>
            <?php
            // Recorrer y mostrar los campos decodificados
            echo '<td>';
            foreach ($materiasDecoded as $materia) {
                echo "$materia<br>";
            }
            echo '</td>';
            echo '<td>';
            foreach ($cursosDecoded as $curso) {
                echo "$curso<br>";
            }
            echo '</td>';
            ?>

                <td > <a  class="button" href="../Modelo/Modificar_Doc.php?Id_docentes=<?=$valor['Id_docentes']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button"  id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_docentes=<?= $valor['Id_docentes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button"  id="button-habilitar" href="../Modelo/Borrar.php?Id_docentes=<?= $valor['Id_docentes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
                <?php
                endforeach;}      
    }elseif(strlen($_POST["Apellido_Docente_segundo"])>=1){
        $apellido_2=isset($_REQUEST['Apellido_Docente_segundo'])? $_REQUEST['Apellido_Docente_segundo']:null;

        $miConsulta=$miPDO->prepare("SELECT * FROM docentes WHERE Apellido_Docente_2='$apellido_2'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Docente no encontrado</h4>";
        }else{
            foreach($miConsulta as $clave =>$valor): 

                $materiasDecoded = json_decode($valor['Nombre_Materia_Asignada'], true);
                $cursosDecoded = json_decode($valor['Numero_curso_asignado'], true);
            ?>
            
        <tr>
            
            <td> <?= $valor ['Nombre_Docente']?> <?= $valor ['Nombre_Docente_2']?> </td>
            <td> <?= $valor ['Apellido_Docente']?> <?= $valor ['Apellido_Docente_2']?> </td>
            <td> <?= $valor ['Documento_Docente'] ?> </td>
            <?php
            // Recorrer y mostrar los campos decodificados
            echo '<td>';
            foreach ($materiasDecoded as $materia) {
                echo "$materia<br>";
            }
            echo '</td>';
            echo '<td>';
            foreach ($cursosDecoded as $curso) {
                echo "$curso<br>";
            }
            echo '</td>';
            ?>

                <td > <a  class="button" href="../Modelo/Modificar_Doc.php?Id_docentes=<?=$valor['Id_docentes']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button"  id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_docentes=<?= $valor['Id_docentes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button"  id="button-habilitar" href="../Modelo/Borrar.php?Id_docentes=<?= $valor['Id_docentes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
                <?php
                endforeach;}      
    }elseif(strlen($_POST["Documento_Docente"])>=1){
        $doc=isset($_REQUEST['Documento_Docente'])?$_REQUEST['Documento_Docente']:null;
        $miConsulta=$miPDO->prepare("SELECT * FROM docentes WHERE Documento_Docente='$doc'");
        $miConsulta->execute();
        if ($miConsulta->rowCount() === 0) {
            echo "<h4 class='F'>Docente no encontrado</h4>";
        }else{
            foreach($miConsulta as $clave =>$valor): 

                $materiasDecoded = json_decode($valor['Nombre_Materia_Asignada'], true);
                $cursosDecoded = json_decode($valor['Numero_curso_asignado'], true);
            ?>
            
        <tr>
            
            <td> <?= $valor ['Nombre_Docente']?> <?= $valor ['Nombre_Docente_2']?> </td>
            <td> <?= $valor ['Apellido_Docente']?> <?= $valor ['Apellido_Docente_2']?> </td>
            <td> <?= $valor ['Documento_Docente'] ?> </td>
            <?php
            // Recorrer y mostrar los campos decodificados
            echo '<td>';
            foreach ($materiasDecoded as $materia) {
                echo "$materia<br>";
            }
            echo '</td>';
            echo '<td>';
            foreach ($cursosDecoded as $curso) {
                echo "$curso<br>";
            }
            echo '</td>';
            ?>

                <td > <a  class="button" href="../Modelo/Modificar_Doc.php?Id_docentes=<?=$valor['Id_docentes']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
                <td> 
                    <?php if ($valor['Activo'] == 1): ?>
                        <a class="button"  id="button-Inhabilitar" href="../Modelo/Borrar.php?Id_docentes=<?= $valor['Id_docentes'] ?>">Inhabilitar <i class="fa-solid fa-user-large-slash"></i></a>
                    <?php else: ?>
                        <a class="button"  id="button-habilitar" href="../Modelo/Borrar.php?Id_docentes=<?= $valor['Id_docentes'] ?>">Habilitar <i class="fa-solid fa-user-large"></i></a>
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