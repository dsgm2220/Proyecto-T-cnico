<?php
include("../Modelo/conec_BD.php");

if (isset($_GET["target"]) && isset($_GET["curso"]) && isset($_GET["materiaId"]) && isset($_GET["trimestre"])) {
    // Obtener los datos enviados por AJAX
    $target = $_GET["target"];
    $materiaId = $_GET["materiaId"];
    $curso = $_GET["curso"];
    $trimestre = $_GET["trimestre"];

    // Consulta SQL utilizando una consulta preparada con PDO
    $consultaEventos = $miPDO->prepare("SELECT descripcion FROM eventos WHERE target = :target AND Nom_mat = :materiaId AND Num_cur = :curso AND trimestre = :trimestre"); // Agregar trimestre a la consulta
    $consultaEventos->bindParam(':target', $target);
    $consultaEventos->bindParam(':materiaId', $materiaId);
    $consultaEventos->bindParam(':curso', $curso);
    $consultaEventos->bindParam(':trimestre', $trimestre);
    $consultaEventos->execute();
    
    if ($consultaEventos->rowCount() > 0) {
        // Obtener la descripción
        $row = $consultaEventos->fetch(PDO::FETCH_ASSOC);
        $descripcion = $row["descripcion"];
        
        // Devolver la descripción como respuesta
        echo $descripcion;
    } else {
        echo "";
    }
}
?>
