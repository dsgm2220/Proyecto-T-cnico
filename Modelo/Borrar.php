<?php
include("conec_BD.php");

/*                           Para Activar e inactivar  un estudiante                        */


if (isset($_GET["Id_estudiantes"])) {

$codigoEst=isset($_REQUEST['Id_estudiantes'])?$_REQUEST['Id_estudiantes']:null;

$miUpdateEst = $miPDO->prepare('UPDATE estudiantes SET Activo = IF(Activo = 1, 0, 1) WHERE Id_estudiantes = :Id_estudiantes');
$miUpdateEst->execute([
    'Id_estudiantes' => $codigoEst
]);

if ($miUpdateEst) {
    header("location:../Vista/Gestion_Es.php");
}
}
/*                            Para Activar e inactivar un directivo                        */


if (isset($_GET["Id_directivo"])) {

    $codigoDir=isset($_REQUEST['Id_directivo'])?$_REQUEST['Id_directivo']:null;
    
    $miUpdateDir = $miPDO->prepare('UPDATE directivos SET Activo = IF(Activo = 1, 0, 1) WHERE Id_directivo = :Id_directivo');
    $miUpdateDir->execute([
        'Id_directivo' => $codigoDir
    ]);
    
    if ($miUpdateDir) {
        header("location:../Vista/Gestion_Direc.php");
    }
    }

    /*                           Para Activar e inactivar  un docente                        */


if (isset($_GET["Id_docentes"])) {

    $codigoDoc=isset($_REQUEST['Id_docentes'])?$_REQUEST['Id_docentes']:null;
    
    $miUpdateDoc = $miPDO->prepare('UPDATE docentes SET Activo = IF(Activo = 1, 0, 1) WHERE Id_docentes = :Id_docentes');
    $miUpdateDoc->execute([
        'Id_docentes' => $codigoDoc
    ]);
    
    if ($miUpdateDoc) {
        header("location:../Vista/Gestion_Doc.php");
    }
    }

/*                            Para eliminar un Area                               */


if (isset($_GET["Id_Area"])) {
    $area_id_borrar = $_GET["Id_Area"];

    try { // Interpretar manejo de excepciones 

        // Iniciar una transacción
        $miPDO->beginTransaction();//Una o mas secuencias en la base de datos 

        // Borrar el área de la tabla "areas"
        $miBorrarArea = $miPDO->prepare('DELETE FROM areas WHERE Id_Area = :Id_Area');
        $miBorrarArea->execute(
            array(
                'Id_Area' => $area_id_borrar
            ));

        // Actualizar el campo "Nombre_Area" a 0 para las materias asociadas al área en la tabla "materias"
        $miActualizarMaterias = $miPDO->prepare('UPDATE materias SET Id_Area = 0 WHERE Id_Area = :Id_Area');
        $miActualizarMaterias->execute(array('Id_Area' => $area_id_borrar));

        // Confirmar la transacción 
        $miPDO->commit();

        header('location:../Vista/Registra_mat.php');// Redirigir a la página que muestra las áreas después de borrar
        exit();
    } catch (PDOException $e) {
        // Si ocurre un error, deshacer la transacción
        $miPDO->rollBack();
        echo '<h3>Error al borrar el área y actualizar las materias</h3>';
    }
}

/*                                       Para eliminar una Materia                                      */

if (isset($_GET["Numero_Curso"])) {

    $codigo=isset($_REQUEST['Numero_Curso'])?$_REQUEST['Numero_Curso']:null;
    
    $miDelete = $miPDO->prepare('DELETE FROM cursos WHERE Numero_Curso=:Numero_Curso');
    $miDelete->execute(
        [
            'Numero_Curso' => $codigo
        ]
    );
    if($miDelete){
            header('location:../Vista/Registra_cur.php');
    }
    
    }

/*                                       Para eliminar una curso Materia                                       */

if (isset($_GET["Id_materias"])) {

$codigo=isset($_REQUEST['Id_materias'])?$_REQUEST['Id_materias']:null;

$miDelete = $miPDO->prepare('DELETE FROM materias WHERE Id_materias=:Id_materias');
$miDelete->execute(
    [
        'Id_materias' => $codigo
    ]
);
if($miDelete){
        header('location:../Vista/Registra_mat.php');
}

}

/*                                       Para eliminar una curso Materia                                       */

if (isset($_GET["Id_trimestre"])) {

    $codigo=isset($_REQUEST['Id_trimestre'])?$_REQUEST['Id_trimestre']:null;
    
    $miDelete = $miPDO->prepare('DELETE FROM trimestres WHERE Id_trimestre=:Id_trimestre');
    $miDelete->execute(
        [
            'Id_trimestre' => $codigo
        ]
    );
    if($miDelete){
            header('location:../Vista/Gestion_tiempo.php');
    }
    
    }
    

?>