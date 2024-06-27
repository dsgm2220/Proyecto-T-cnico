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
    <title>Registrar Cursos</title>
    <style>
        table{
            border-collapse: collapse;
            width: 80%;
            margin-left:10%;
            margin-top:5%;
            margin-bottom:3%;
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
    <section>
        <header>
            <i class="fa-solid fa-book" id="Icono"></i>
            <i class="fa-regular fa-pen-to-square" id="Icono-2"></i>
            <p id="head">Registrar Cursos</p>
            
        </header>

    <form action="" method="post">
        <br>
    <!-- Numero del curso  -->
    
        <div class="campos">
            <i class="fa-solid fa-hashtag"></i>
            <input type="number"  placeholder=" Numero del curso"  id="user" id="i2" name="curso" autocomplete="off">
        </div>

    <br>

    <div id="cont-Boton">        
        <i class="fa-solid fa-book" ></i>
        <input type="submit" value="Agregar Curso" id="DiferenteT" name="regis-cur">
    </div>
    </form>

    <?php
    if(isset($_POST["regis-cur"])){
        if(strlen($_POST["curso"])>=1){
            $curso= trim($_POST["curso"]);

            $sql="SELECT * FROM cursos WHERE Numero_Curso='$curso'";
            $doble =  mysqli_query($conex,$sql);

            if(!$doble->num_rows>0){
                $Insertar = "INSERT INTO cursos(Numero_Curso) VALUES ('$curso')";
                $resultado =  mysqli_query($conex,$Insertar);
                
                if($resultado){
                    ?>       
                    <h4 class="ok">Curso registrado correctamente</h4>
                    <?php
                }
            }
        else{
                ?>
                <h4 class="F">Ya hay curso identificado con el mismo numero </h4>
                <?php
            }
        }
    }
    ?>
</section>


<!-- CONSULTAR CURSO -->

<section id="sectionC">

    <header>
        <i class="fa-solid fa-book" id="Icono"></i>
        <i class="fa-solid fa-magnifying-glass" id="Icono-2"></i>
        <p id="head">Consultar Cursos</p>
    </header>

<form action="" method="post" onsubmit="redirigirATabla()">
    <br>
<!-- Numero del curso  -->
    
<div class="campos">
    <i class="fa-solid fa-hashtag"></i>
    <input type="number"  placeholder=" Numero del curso"  id="user" id="i2" name="Numero_Curso" autocomplete="off">
</div>

    <br>
    <div id="cont-Boton-otro">        
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="submit" value="Consultar Curso" id="DiferenteT" name="consul-cur">
    </div>

</form>

<table id="tablaResultados" >
    <tr>
        <th>Curso</th>
        <th>Documento Estudiantes</th>
        <th>Modificar<i class="fa-solid fa-pen"></i></th>
        <th>Borrar<i class="fa-solid fa-trash"></i></th>
    </tr>
<?php
if(isset($_POST["consul-cur"])){
    $numero_curso_buscar = isset($_REQUEST['Numero_Curso']) ? $_REQUEST['Numero_Curso'] : '';

    // Consultar el ID del área buscada por su nombre
    $consulta_cur = $miPDO->prepare('SELECT Numero_Curso FROM cursos WHERE Numero_Curso = :Numero_Curso');
    $consulta_cur->execute(
        array(
            'Numero_Curso' => $numero_curso_buscar
        )
    );
    $curso = $consulta_cur->fetch();

    if ($curso) {
        // Obtener el ID del curso encontrado
        $curso_id_consulta = $curso['Numero_Curso'];

        // Mostrar el nombre del curso
        echo '<tr>
        <td>' . $numero_curso_buscar . '</td>';

        // Consultar los estudiantes que pertenecen a este curso
        $consulta_doc = $miPDO->prepare('SELECT Documento_Estudiante FROM estudiantes WHERE Numero_Curso_pertenece = :Numero_Curso');
        $consulta_doc->execute(
            array(
                'Numero_Curso' => $curso_id_consulta
            ) 
        );
        $cursos_doc = $consulta_doc->fetchAll(PDO::FETCH_COLUMN);

        // Mostrar los Doc de los estudiantes  en una lista
        echo '<td>';
        foreach ($cursos_doc as $nombre) {
            echo $nombre; 
            echo '<br>';
        }
        echo '</td>';
        ?>

        <td> <a  class="button"  href="../Modelo/Modificar_cur.php?Numero_Curso=<?= $curso['Numero_Curso']?>">Modificar<i class="fa-solid fa-pen"></i></a></td>
        <td> <a  class="button" id="button-Inhabilitar" href="../Modelo/Borrar.php?Numero_Curso=<?= $curso['Numero_Curso']?>">Borrar<i class="fa-solid fa-trash"></i></a></td>

        <?php
        echo '</tr>';
    } else {
        echo '<h4 class="F">Curso no encontrado</h4>';
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
    </script>
</body>
</html>