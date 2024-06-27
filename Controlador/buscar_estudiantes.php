<?php
include('../Modelo/conec_BD.php');

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    // Limpia y divide el término de búsqueda
    $cleanedSearchTerm = trim($searchTerm);
    $keywords = explode(" ", $cleanedSearchTerm);

    // Realiza una consulta SQL para buscar estudiantes por nombre o apellido
    $sql = "SELECT * FROM estudiantes WHERE ";
    $conditions = [];

    foreach ($keywords as $keyword) {
        $conditions[] = "Nombre_Estudiante LIKE '%$keyword%' OR Nombre_Estudiante_2 LIKE '%$keyword%' OR Apellido_Estudiante LIKE '%$keyword%' OR Apellido_Estudiante_2 LIKE '%$keyword%'";
    }

    $sql .= implode(' OR ', $conditions);

    $result = $miPDO->query($sql);

    if ($result->rowCount() > 0) {
        foreach ($result as $row) {
            // Muestra los resultados como opciones
            echo '<a href="#">' . $row['Nombre_Estudiante'] . ' ' . $row['Nombre_Estudiante_2'] . ' ' . $row['Apellido_Estudiante'] . ' ' . $row['Apellido_Estudiante_2'] .'</a><br>';
        }
    } else {
        echo 'No se encontraron resultados.';
    }
}
?>