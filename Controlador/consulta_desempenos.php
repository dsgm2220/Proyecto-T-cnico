<?php
include("../Modelo/conec_BD.php");
if (isset($_GET["target"]) && isset($_GET["curso"]) && isset($_GET["materiaId"]) && isset($_GET["trimestre"])) {
    // Obtener los datos enviados por AJAX
    $target = $_GET["target"];
    $materiaId = $_GET["materiaId"];
    $curso = $_GET["curso"];
    $trimestre = $_GET["trimestre"];

    // Consulta SQL utilizando una consulta preparada con PDO
    $consultaDesempeños = $miPDO->prepare("SELECT desempeno FROM desempeños WHERE target = :target AND Nom_mat = :materiaId AND Num_cur = :curso AND trimestre = :trimestre");
    $consultaDesempeños->bindParam(':target', $target);
    $consultaDesempeños->bindParam(':materiaId', $materiaId);
    $consultaDesempeños->bindParam(':curso', $curso);
    $consultaDesempeños->bindParam(':trimestre', $trimestre);
    $consultaDesempeños->execute();
    
    if ($consultaDesempeños->rowCount() > 0) {
        // Obtener la descripción
        $row = $consultaDesempeños->fetch(PDO::FETCH_ASSOC);
        $desempeño = $row["desempeno"];
        
        // Devolver la descripción como respuesta
        echo $desempeño;
    } else {
        echo ""; // Puedes personalizar este mensaje según tus necesidades
    }
}
?>