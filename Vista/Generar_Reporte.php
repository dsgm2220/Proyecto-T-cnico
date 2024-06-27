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
    <title>Generar Reporte</title>
<style>
    .container {
        display: flex;
        flex-direction: column;
        width:75%;
        margin-top: 27px;
        margin-left: 12%;
        margin-right: 12%;
        background-color: #f0f0f0; /* Cambia el color de fondo según tus preferencias */
        padding: 20px; /* Espaciado interior */
        border: 1px solid #ccc; /* Borde alrededor de la sección */
        border-radius: 10px; /* Radio del borde para suavizar los bordes */
        height:auto;
        min-height:500px;
    }
    #search-box {
        display: flex;
        align-items: center;
        width: 100%;
        margin-left: 0%;
        border: none;
        margin-top:none;
    }

    .contenedor-input{
        width:80%;
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
        margin-right:3.5%;
        margin-top:-0.3%;
    }

    .search-input {
        width: -10%;
        border-radius: 5px;
        font-size: 16px;
        padding: 15px 15px;
    }
        /* Aplicar estilo al campo de búsqueda cuando está enfocado */
        .search-input:focus {
            border: 2px solid #007BFF; /* Cambia el estilo del borde al enfocar */
            background-color: #fff; /* Cambia el fondo al enfocar */
        }

    /* Estilo para las opciones de búsqueda */
    #search-results a {
        display: flex;
        padding: 5px;
        font-size: 16px;
        text-decoration: none;
        color: #333;
        border: 1px solid #ccc;
        background-color: #fff;
        cursor: pointer;
        width:397%;
        margin-top:-13%;
    }

        /* Estilo para la opción seleccionada con el teclado */
        #search-results a.selected {
            background-color: #007BFF;
            color: #fff;
        }

        /* Estilo para resaltar las opciones al pasar el mouse por encima */
        #search-results a:hover {
            background-color: #007BFF;
            color: #fff;
        }

    .buscar-button {
        margin-top:-0.3%;
        display: flex;
        align-items: center;
        width:13%;
    }

    .buscarBtn {
    background-color: #007BFF;
    color: #fff;
    border: none;
    padding: 7px 7px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 15px;
    transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
    }

        .buscarBtn:hover {
            background-color: #0056b3;
            transform: scale(1.05); /* Efecto de escala al pasar el mouse por encima */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Sombra al pasar el mouse por encima */
        }

        .buscarBtn:active {
            transform: scale(0.95); /* Efecto de escala cuando se hace clic */
        }

    /* Estilos para la tabla */
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

<section  class="container">
    <form action="" method="post"  id="search-box">
    <div class="contenedor-input">
    <input type="text" class="search-input" placeholder="Buscar" id="search-input" name="search-input" autocomplete="off"> 
    </div>
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
            <div class="buscar-button">
                <button class="buscarBtn" name="buscarBtn" ><i class="fas fa-search"></i> Buscar</button>
            </div>
    </form>
        <div id="search-results" style="position: absolute; z-index: 999; margin-top: 8.5%; width:14.8%;"></div>
    <table>
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Curso</th>
                <th>Reporte</th>
            </tr>
        </thead>

        <tbody>
        <?php
        if(isset($_POST["buscarBtn"])){
            if(strlen($_POST["search-input"])>=1){
                $searchTerm = isset($_POST['search-input']) ? $_POST['search-input'] : '';

        // Realiza una consulta SQL para buscar estudiantes en múltiples campos
        $sql = "SELECT * FROM estudiantes WHERE 
        (Nombre_Estudiante LIKE :searchTerm OR 
        Apellido_Estudiante LIKE :searchTerm OR 
        Nombre_Estudiante_2 LIKE :searchTerm OR 
        Apellido_Estudiante_2 LIKE :searchTerm OR 
        CONCAT(Nombre_Estudiante, ' ', Nombre_Estudiante_2) LIKE :searchTerm OR 
        CONCAT(Apellido_Estudiante, ' ', Apellido_Estudiante_2) LIKE :searchTerm OR
        CONCAT(Nombre_Estudiante, ' ', Nombre_Estudiante_2, ' ', Apellido_Estudiante, ' ', Apellido_Estudiante_2) LIKE :searchTerm)";

        $miConsulta = $miPDO->prepare($sql);
        $miConsulta->bindValue(':searchTerm', "%" . $searchTerm . "%", PDO::PARAM_STR);
        $miConsulta->execute();

                if ($miConsulta->rowCount() === 0) {
                    echo "<h4 class='F'>Estudiante no encontrado</h4>";
                } else {
                    foreach ($miConsulta as $valor):
                ?>
                            <tr>
                                <td><?= $valor['Nombre_Estudiante'] ?> <?= $valor['Nombre_Estudiante_2'] ?></td>
                                <td><?= $valor['Apellido_Estudiante'] ?> <?= $valor['Apellido_Estudiante_2'] ?></td>
                                <td style="text-align:center;"><?= $valor['Numero_Curso_pertenece'] ?></td>
                                <td><a class="button" href="reportes.php?Id_estudiantes=<?= $valor['Id_estudiantes']?>">Generar Reporte<i class="fa-regular fa-clipboard"></i></a></td>
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
                            <td style="text-align:center;"> <?= $valor ['Numero_Curso_pertenece'] ?> </td>
            
                            <td> <a  class="button" href="reportes.php?Id_estudiantes=<?= $valor['Id_estudiantes']?>">Generar Reporte<i class="fa-regular fa-clipboard"></i></a></td>
                        </tr>
                            <?php
                            endforeach;}
                }
            }
            ?>
        </tbofy>
        
    </table>
</section>
<script>
let selectedOptionIndex = -1; // Declaración de selectedOptionIndex

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value.trim();

        if (searchTerm.length === 0) {
            searchResults.innerHTML = ''; // Limpia los resultados si no hay término de búsqueda
        } else {
            // Envía una solicitud AJAX al servidor para buscar estudiantes
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../Controlador/buscar_estudiantes.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (xhr.status === 200) {
                    searchResults.innerHTML = xhr.responseText; // Muestra los resultados en el div

                    searchLinks = searchResults.querySelectorAll('a'); // Actualiza la lista de enlaces

                    // Agregar un evento de clic a las opciones de búsqueda
                    searchLinks.forEach(function (link, index) {
                        link.addEventListener('click', function (event) {
                            event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
                            const selectedValue = event.target.textContent;
                            searchInput.value = selectedValue; // Establecer el valor del campo de búsqueda
                            searchResults.innerHTML = ''; // Limpiar los resultados
                            selectedOptionIndex = -1; // Reinicia el índice seleccionado
                        });
                    });

                    searchInput.addEventListener('keydown', function (event) {
                        if (event.key === 'ArrowUp') {
                            event.preventDefault();
                            if (selectedOptionIndex > 0) {
                                selectedOptionIndex--;
                            }
                        } else if (event.key === 'ArrowDown') {
                            event.preventDefault();
                            if (selectedOptionIndex < searchLinks.length - 1) {
                                selectedOptionIndex++;
                            }
                        }
                        updateSelectedOption();
                    });
                } else {
                    console.error('Error en la solicitud AJAX');
                }
            };

            xhr.send('searchTerm=' + searchTerm);
        }
    });
    function updateSelectedOption() {
    searchLinks.forEach(function (link, index) {
        if (index === selectedOptionIndex) {
            link.classList.add('selected');
        } else {
            link.classList.remove('selected');
        }
    });
    }
});
</script>
</body>
</html>
