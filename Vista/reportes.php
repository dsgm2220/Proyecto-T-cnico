<?php
ob_start();
include('../Modelo/conec_BD.php');


$añoActual = date('Y');
//Obtener fecha Actual
$fechaActual = date('Y-m-d');

// Luego, realiza una consulta para obtener el nombre del trimestre que abarca la fecha actual
$consultaTrimestre = $miPDO->prepare("SELECT nombre_trimestre FROM trimestres WHERE fecha_inicio <= :fechaActual AND fecha_finalizacion >= :fechaActual");
$consultaTrimestre->bindParam(':fechaActual', $fechaActual);
$consultaTrimestre->execute();

if ($consultaTrimestre->rowCount() > 0) {
    $trimestre = $consultaTrimestre->fetch();
    $nombreTrimestre = $trimestre['nombre_trimestre'];
} 

    $Id = isset($_REQUEST['Id_estudiantes']) ? $_REQUEST['Id_estudiantes'] : null;

    if ($Id) {
        // Realiza una consulta para obtener la información del estudiante
        $consultaEstudiante = $miPDO->prepare("SELECT * FROM estudiantes WHERE Id_estudiantes = :Id_estudiantes");
        $consultaEstudiante->bindParam(':Id_estudiantes', $Id);
        $consultaEstudiante->execute();
    
        if ($consultaEstudiante->rowCount() > 0) {
            $estudiante = $consultaEstudiante->fetch();
    
            // Realiza una consulta para obtener las notas del estudiante
            $consultaNotas = $miPDO->prepare("SELECT Nom_mat, Nota_Final FROM notas WHERE Id_Est = :Id_estudiantes AND trimestre =:trimestre");
            $consultaNotas->bindParam(':Id_estudiantes', $Id);
            $consultaNotas->bindParam(':trimestre', $nombreTrimestre);
            $consultaNotas->execute();
        }
    }
    // Inicializa un arreglo para almacenar las áreas y las materias
    $areasMaterias = []; // Inicializa un arreglo para almacenar las áreas y las materias

    while ($nota = $consultaNotas->fetch()) {
        $materiaNombre = $nota['Nom_mat'];
    
        // Realiza una consulta para obtener el Id del área y el porcentaje usando el nombre de la materia
        $consultaIdAreaPorcentaje = $miPDO->prepare("SELECT Id_Area, Porcentaje FROM materias WHERE Nombre_Materias = :materiaNombre");
        $consultaIdAreaPorcentaje->bindParam(':materiaNombre', $materiaNombre);
        $consultaIdAreaPorcentaje->execute();
    
        if ($consultaIdAreaPorcentaje->rowCount() > 0) {
            $areaInfo = $consultaIdAreaPorcentaje->fetch();
            $idArea = $areaInfo['Id_Area'];
            $porcentaje = $areaInfo['Porcentaje'];
    
            // Verifica si el área ya se ha agregado al arreglo de áreas y materias
            if (!isset($areasMaterias[$idArea])) {
                // Realiza una consulta para obtener el nombre del área y las materias que pertenecen a ese área
                $consultaAreaMaterias = $miPDO->prepare("SELECT Nombre_Area, Nom_mat_pertenecen FROM areas WHERE Id_Area = :idArea");
                $consultaAreaMaterias->bindParam(':idArea', $idArea);
                $consultaAreaMaterias->execute();
    
                if ($consultaAreaMaterias->rowCount() > 0) {
                    $areaInfo = $consultaAreaMaterias->fetch();
                    $nombreArea = $areaInfo['Nombre_Area'];
                    $materiasArray = json_decode($areaInfo['Nom_mat_pertenecen'], true);
    
                    // Agrega el nombre del área y las materias al arreglo de áreas y materias
                    $areasMaterias[$idArea] = [
                        'Nombre_Area' => $nombreArea,
                        'materias' => $materiasArray,
                        'Porcentajes' => [], // Inicializa un arreglo para los porcentajes
                    ];
                }
            }
    
            // Agrega el porcentaje de la materia al área correspondiente
            $areasMaterias[$idArea]['Porcentajes'][] = $porcentaje;
        }
    }

    $promedioAreaTotal = 0.0; // Variable para almacenar el promedio total del área.

    foreach ($areasMaterias as $areaData) {
        $promedioArea = 0.0; // Variable para almacenar el promedio del área actual.
        $totalPorcentaje = 0; // Variable para almacenar el total de porcentajes.
    
        foreach ($areaData['materias'] as $materiaNombre) {
            // Consulta las notas de la materia para el estudiante actual.
            $consultaNotasMateria = $miPDO->prepare("SELECT Nota_Final FROM notas WHERE Id_Est = :Id_estudiantes AND Nom_mat = :materiaNombre");
            $consultaNotasMateria->bindParam(':Id_estudiantes', $Id);
            $consultaNotasMateria->bindParam(':materiaNombre', $materiaNombre);
            $consultaNotasMateria->execute();
    
            $promedioMateria = 0.0; // Variable para el promedio de la materia.
    
            // Calcula el promedio de la materia sumando todas las notas y dividiendo por 3 (asumiendo 3 notas).
            while ($notaMateria = $consultaNotasMateria->fetch()) {
                $promedioMateria += (float)$notaMateria['Nota_Final'];
            }
    
            $promedioMateria /= 3; // Divide la suma de notas por la cantidad de notas (3).
    
            // Realiza una consulta para obtener el porcentaje de la materia.
            $consultaPorcentajeMateria = $miPDO->prepare("SELECT Porcentaje FROM materias WHERE Nombre_Materias = :materiaNombre");
            $consultaPorcentajeMateria->bindParam(':materiaNombre', $materiaNombre);
            $consultaPorcentajeMateria->execute();
    
            if ($consultaPorcentajeMateria->rowCount() > 0) {
                $porcentajeMateria = (float)$consultaPorcentajeMateria->fetch()['Porcentaje'];
    
                // Multiplica el promedio de la materia por su porcentaje y agrega al promedio del área.
                $promedioArea += ($promedioMateria * $porcentajeMateria);
                $totalPorcentaje += $porcentajeMateria; // Agrega el porcentaje al total del área.
            }
        }
    
        // Asegúrate de que el total de porcentajes sea mayor que cero para evitar la división por cero.
        if ($totalPorcentaje > 0) {
            // Divide la suma total de promedio del área por el total de porcentajes y agrega al promedio total.
            $promedioAreaTotal += ($promedioArea / $totalPorcentaje);
        }
    }

 // Comienza a generar el informe HTML

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="IMG/escudo.png">
    <title>Boletín Escolar</title>
    <style>
        /* CSS PDF */
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            padding: 4px;
            display: flex;
            border: 1px solid #ccc; /* Agrega un borde al contenedor */
        }

        .logo{
            background-color: #f0f0f0; 
            float: left;
            border: 1px solid #ccc; /* Agrega un borde al logotipo derecho */
            padding:10px;
            width: 10%;
        }

        .info {
            background-color: #f0f0f0; 
            text-align: center;
            float: left;
            border: 1px solid #ccc;
            width: 73.5%;
        }
            .info p{
                font-size:10px;
                padding:6.5px;
            }

        h3{
            margin:5px;
            font-size: 19px;
            font-weight: bold;
            color: #333;
        }
        .estudiante{
            border: 1px solid #ccc;
            padding: 6px;
            margin: 5px;
            display:inline-block;
            font-size:15px;
            background-color: #f0f0f0; 
        }
        h4 {
            background-color: #f0f0f0; 
            border: 1px solid #ccc;
            padding: 6px;
            margin: 5px;
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            color: #333;
        }
        /* Estilos para el contenedor de la sección de Área y Promedio */
        .notasContenedor {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            background-color: #f0f0f0; 
            color: #333;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

            .notasContenedor-info {
                display: inline-block;
                align-items: center;
                justify-content: space-between;
                padding: 0 6px; /* Agrega un espacio alrededor de la información */
            }
                .notasContenedor-info p {
                    font-weight: bold;
                    font-size: 16px;
                }

                .notasContenedor-info h2 {
                    font-size: 17px;
                    font-weight: bold;
                }
                hr{
                    margin:0;
                }
        /* Estilos para la tabla de notas */
                .notasContenedor-info table {
                    width: 50%;
                    border-collapse: collapse;
                    font-size:11px;
                    padding: 10px;
                }

        table td,th {
            padding: 5px;
            text-align: center;
        }

        .notasContenedor-info table th {
            background-color: #007BFF;
            color: white;
        }

        .notasContenedor-info table td {
            background-color: #E8F5FE;
        }

        /* Pie de página */
        footer {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
        }
        /* FIN PDF */
    </style>
</head>
<body>

        <div class="container">

            <div class="logo">
                <img src="IMG/escudo.png" alt="Logo Izquierdo" width="70px" height="90px">
            </div>

            <div class="info">
                <h3>Colegio Instituto Tecnico Distrital Juan del Corral IED</h3>
                <p>Resoluciones No. 13411 de 1991 y 1914 del 28 de junio de 2002 que otorgan la Licencia de Funcionamiento <br>
                    Resoluciones No. 10324 del 23 de noviembre de 2011 Especialidad en Gestion Contable y Financiera <br> 
                    10165 del 14 de noviembre de 2013 Especialidad en Desarrollo Grafico en Proyectos de Construccion <br>
                    101770 de 10 de enero 2019 Especialidad en Programacion de Software
                </p>
            </div>

            <div class="logo">
                <img src="IMG/escudo_2.png" alt="Logo Derecho" width="70px" height="90px">
            </div>

        </div>

            <br> <br> <br> <br> <br><br>

        <!-- Contenedor para la información del estudiante -->

        <section class="estudiante" style="width:46.5%;">
            <div style="text-align:center;">Estudiante: <?php echo $estudiante['Nombre_Estudiante'] . ' ' . $estudiante['Nombre_Estudiante_2'] . ' ' . $estudiante['Apellido_Estudiante'] . ' ' . $estudiante['Apellido_Estudiante_2']; ?></div>
        </section>
        <section class="estudiante">
            <div>Curso: <?php echo $estudiante ['Numero_Curso_pertenece']?></div>
        </section>
        <section class="estudiante">
            <div>Año: <?php echo $añoActual?></div>
        </section>
        <section class="estudiante">
            <div><?php echo $nombreTrimestre?></div>
        </section>
            
        <h4>INFORME DE DESEMPEÑO ACADEMICO Y CONVIVENCIAL</h4>


    <?php foreach ($areasMaterias as $areaData): ?>

    <section class="notasContenedor">

        <div class="notasContenedor-info" style="width: 66.5%;">
        <h2>Área: <?php echo $areaData['Nombre_Area']; ?></h2>
        </div>

        <div class="notasContenedor-info">
            <p><?php echo 'Promedio Area:'.number_format($promedioAreaTotal, 2); ?></p>
        </div>

        <hr>

        <?php foreach ($areaData['materias'] as $materiaNombre): ?>

            <section class="notasContenedor" style="border: none;">

                <div class="notasContenedor-info" style="width: 50%; margin: 5px;">
                    <h2>Materia: <?php echo $materiaNombre; ?></h2>
                    <?php
                    // Realiza una consulta para obtener el nombre del docente asignado a esta materia
                    $consultaDocente = $miPDO->prepare("SELECT Nombre_Docente, Nombre_Docente_2, Apellido_Docente, Apellido_Docente_2 FROM docentes WHERE Nombre_Materia_Asignada LIKE :materiaNombre");
                    $consultaDocente->bindValue(':materiaNombre', '%"'.$materiaNombre.'"%', PDO::PARAM_STR);
                    $consultaDocente->execute();

                    if ($consultaDocente->rowCount() > 0) {
                        $docenteInfo = $consultaDocente->fetch();
                        $primerNombre = $docenteInfo['Nombre_Docente'];
                        $segundoNombre = $docenteInfo['Nombre_Docente_2'];
                        $primerApellido = $docenteInfo['Apellido_Docente'];
                        $segundoApellido = $docenteInfo['Apellido_Docente_2'];

                        // Puedes usar estas variables en tu HTML para mostrar el nombre del docente asignado a esta materia
                        echo "<h5>Docente: $primerNombre $segundoNombre $primerApellido $segundoApellido</h5>";
                    }
                    ?>
                </div>
                
                <div class="notasContenedor-info" style=" margin:0 auto;">
                    <?php
                        // Realiza una consulta para obtener las notas finales por trimestre y desempeños 
                        $consultaNotas = $miPDO->prepare("SELECT trimestre, Nota_Final, desempeños FROM notas WHERE Id_Est = :Id_estudiantes AND Nom_mat = :materiaNombre");
                        $consultaNotas->bindParam(':Id_estudiantes', $Id);
                        $consultaNotas->bindParam(':materiaNombre', $materiaNombre);
                        $consultaNotas->execute();

                        $notasPorTrimestre = [];
                        $desempenoPorTrimestre = [];
                        while ($nota = $consultaNotas->fetch()) {
                            $notasPorTrimestre[$nota['trimestre']] = $nota['Nota_Final'];
                            $desempenoPorTrimestre = json_decode($nota['desempeños'], true);
                        }
                    ?>
                    <table>
                        <tr>
                            <th>Trimestre 1</th>
                            <th>Trimestre 2</th>
                            <th>Trimestre 3</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($notasPorTrimestre['Primer Trimestre']) ? $notasPorTrimestre['Primer Trimestre'] : '--'; ?></td>
                            <td><?php echo isset($notasPorTrimestre['Segundo Trimestre']) ? $notasPorTrimestre['Segundo Trimestre'] : '--'; ?></td>
                            <td><?php echo isset($notasPorTrimestre['Tercer Trimestre']) ? $notasPorTrimestre['Tercer Trimestre'] : '--'; ?></td>
                        </tr>
                    </table>
                </div>

            </section>

            <section class="notasContenedor" style="border: none; height:290px;">

                <div class="notasContenedor-info" style="width: 75%; margin:3px;">
                <?php
                    // Realiza una consulta para obtener los desempeños
                    $consultaDesempenos = $miPDO->prepare("SELECT desempeno, target FROM desempeños WHERE Nom_mat = :materiaNombre AND trimestre = :nombreTrimestre");
                    $consultaDesempenos->bindParam(':materiaNombre', $materiaNombre);
                    $consultaDesempenos->bindParam(':nombreTrimestre', $nombreTrimestre);
                    $consultaDesempenos->execute();

                    // Mostrar los desempeños
                    echo '<h5>Desempeños:</h5>';
                    echo '<div style="word-wrap: break-word;">';
                    while ($desempenoInfo = $consultaDesempenos->fetch()) {
                        $target = $desempenoInfo['target'];
                        $desempeno = $desempenoInfo['desempeno'];
                        $targetNumber = intval(substr($target, 1));
                        echo '<p style="font-size:12px;">'.$targetNumber . '.' . $desempeno.'</p>';
                    }
                    echo '</div>';
                    ?>
                </div>

                <div class="notasContenedor-info" style="width: 35%; margin:10px;">
                    <table>
                        <tr>
                            <th>Alcanzo(S)/No Alcanzo(N)</th>
                        </tr>
                        <?php
                        foreach ($desempenoPorTrimestre as $desempeno) {
                            echo '<tr><td style="font-size:10px;">'. $desempeno . '</td></tr>';
                        }
                        ?>
                    </table>
                </div>

            </section>

            <hr>
            
        <?php endforeach; ?>

    </section>

<?php endforeach; ?>
    <footer>
        <p>¡Felicidades en tu desempeño escolar!</p>
    </footer>
</body>
</html>
<?php    
$html=ob_get_clean();
//echo $html;

require_once '../libreria/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf ->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');
//$dompdf->setPaper('A4','Landscape'); Formato diferente

$dompdf->render();

$dompdf->stream("Reporte_de_Notas.pdf",array("Attachment" => true));//true = descargar
?>