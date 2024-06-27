-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2023 a las 04:28:38
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemadeplanillas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `Id_Area` int(11) NOT NULL,
  `Nombre_Area` varchar(20) NOT NULL,
  `Numero_Curso` varchar(255) NOT NULL,
  `Nom_mat_pertenecen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`Id_Area`, `Nombre_Area`, `Numero_Curso`, `Nom_mat_pertenecen`) VALUES
(54, 'Humanidades', '[\"1103\",\"1104\"]', '[\"Español\", \"Lecto-Escritura\", \"Idioma Extranjero-Ingles\"]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `Id_curso` int(11) NOT NULL,
  `Numero_Curso` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`Id_curso`, `Numero_Curso`) VALUES
(34, 1103),
(35, 1104),
(36, 902);

--
-- Disparadores `cursos`
--
DELIMITER $$
CREATE TRIGGER `After_Delete_Curso` AFTER DELETE ON `cursos` FOR EACH ROW BEGIN
    DECLARE curso_numero INT;
    
    -- Obtener el número del curso eliminado
    SET curso_numero = OLD.Numero_Curso;
    
    -- Actualizar estudiantes
    UPDATE estudiantes
    SET Numero_Curso_pertenece = 0
    WHERE Numero_Curso_pertenece = curso_numero;
    
    -- Eliminar el número de curso del arreglo en la tabla areas
    UPDATE areas
    SET Numero_Curso = JSON_REMOVE(Numero_Curso, JSON_UNQUOTE(JSON_SEARCH(Numero_Curso, 'one', curso_numero)))
    WHERE JSON_SEARCH(Numero_Curso, 'one', curso_numero) IS NOT NULL;

    -- Eliminar el número de curso del arreglo en la tabla docentes
    UPDATE docentes
    SET Numero_curso_asignado = JSON_REMOVE(Numero_curso_asignado, JSON_UNQUOTE(JSON_SEARCH(Numero_curso_asignado, 'one', curso_numero)))
    WHERE JSON_SEARCH(Numero_curso_asignado, 'one', curso_numero) IS NOT NULL;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_curso` AFTER UPDATE ON `cursos` FOR EACH ROW BEGIN
    -- Actualizar estudiantes
    UPDATE estudiantes
    SET Numero_Curso_pertenece = NEW.Numero_Curso
    WHERE Numero_Curso_pertenece = OLD.Numero_Curso;

    -- Actualizar el arreglo Numero_Curso_asignado en la tabla docentes
    UPDATE docentes
    SET Numero_curso_asignado = JSON_REPLACE(Numero_curso_asignado, JSON_UNQUOTE(JSON_SEARCH(Numero_curso_asignado, 'one', OLD.Numero_Curso)), NEW.Numero_Curso)
    WHERE JSON_SEARCH(Numero_curso_asignado, 'one', OLD.Numero_Curso) IS NOT NULL;

    -- Actualizar el arreglo Numero_Curso en la tabla areas
    UPDATE areas
    SET Numero_Curso = JSON_REPLACE(Numero_Curso, JSON_UNQUOTE(JSON_SEARCH(Numero_Curso, 'one', OLD.Numero_Curso)), NEW.Numero_Curso)
    WHERE JSON_SEARCH(Numero_Curso, 'one', OLD.Numero_Curso) IS NOT NULL;

    -- Actualizar el campo Num_cur en la tabla notas
    UPDATE notas
    SET Num_cur = NEW.Numero_Curso
    WHERE Num_cur = OLD.Numero_Curso;

    -- Actualizar el campo Num_cur en la tabla eventos
    UPDATE eventos
    SET Num_cur = NEW.Numero_Curso
    WHERE Num_cur = OLD.Numero_Curso;

    -- Actualizar el campo Num_cur en la tabla desempeños
    UPDATE desempeños
    SET Num_cur = NEW.Numero_Curso
    WHERE Num_cur = OLD.Numero_Curso;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desempeños`
--

CREATE TABLE `desempeños` (
  `id_desempeno` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `id_directivo` int(11) NOT NULL,
  `Nom_mat` varchar(30) NOT NULL,
  `Num_cur` int(10) NOT NULL,
  `desempeno` text NOT NULL,
  `target` varchar(20) NOT NULL,
  `trimestre` varchar(20) NOT NULL,
  `Ano` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `desempeños`
--

INSERT INTO `desempeños` (`id_desempeno`, `id_docente`, `id_directivo`, `Nom_mat`, `Num_cur`, `desempeno`, `target`, `trimestre`, `Ano`) VALUES
(34, 0, 0, 'Idioma Extranjero-Ingles', 1103, 'Trabaja en la clase de ingles de manera correcta y participa  en cada clase obteniendo una infinidad de puntos , aprendiendo', 'D1', 'Primer Trimestre', 2023),
(35, 0, 0, 'Idioma Extranjero-Ingles', 1103, 'Trabaja en la clase de ingles de manera correcta y participa  en cada clase obteniendo una infinidad de puntos , aprendiendo', 'D2', 'Primer Trimestre', 2023),
(36, 0, 0, 'Idioma Extranjero-Ingles', 1103, 'Trabaja en la clase de ingles de manera correcta y participa  en cada clase obteniendo una infinidad de puntos , aprendiendo', 'D3', 'Primer Trimestre', 2023),
(37, 0, 0, 'Idioma Extranjero-Ingles', 1103, 'Trabaja en la clase de ingles de manera correcta y participa  en cada clase obteniendo una infinidad de puntos , aprendiendo', 'D4', 'Primer Trimestre', 2023),
(38, 0, 0, 'Idioma Extranjero-Ingles', 1103, 'Trabaja en la clase de ingles de manera correcta y participa  en cada clase obteniendo una infinidad de puntos , aprendiendo', 'D5', 'Primer Trimestre', 2023),
(39, 0, 0, 'Español', 1103, 'Trabaja en la clase de Español de manera correcta y participa  en cada clase obteniendo una infinidad de puntos , aprendiendo', 'D1', 'Primer Trimestre', 2023),
(40, 0, 0, 'Español', 1103, 'Trabaja en la clase de Español de manera correcta y participa  en cada clase obteniendo una infinidad de puntos , aprendiendo', 'D2', 'Primer Trimestre', 2023),
(41, 0, 0, 'Español', 1103, 'Trabaja en la clase de Español de manera correcta y participa  en cada clase obteniendo una infinidad de puntos , aprendiendo', 'D3', 'Primer Trimestre', 2023),
(42, 0, 0, 'Español', 1103, 'Trabaja en la clase de Español de manera correcta y participa  en cada clase obteniendo una infinidad de puntos , aprendiendo', 'D4', 'Primer Trimestre', 2023),
(43, 0, 0, 'Español', 1103, 'Trabaja en la clase de Español de manera correcta y participa  en cada clase obteniendo una infinidad de puntos , aprendiendo', 'D5', 'Primer Trimestre', 2023),
(44, 0, 0, 'Lecto-Escritura', 1103, 'Trabaja por escribir  cuentos y entender las lecturas correctamente , lee en clase y hace escritos con una muy buena ortografia', 'D1', 'Primer Trimestre', 2023),
(45, 0, 0, 'Lecto-Escritura', 1103, 'Trabaja por escribir  cuentos y entender las lecturas correctamente , lee en clase y hace escritos con una muy buena ortografia', 'D2', 'Primer Trimestre', 2023),
(46, 0, 0, 'Lecto-Escritura', 1103, 'Trabaja por escribir  cuentos y entender las lecturas correctamente , lee en clase y hace escritos con una muy buena ortografia', 'D3', 'Primer Trimestre', 2023),
(47, 0, 0, 'Lecto-Escritura', 1103, 'Trabaja por escribir  cuentos y entender las lecturas correctamente , lee en clase y hace escritos con una muy buena ortografia', 'D4', 'Primer Trimestre', 2023),
(48, 0, 0, 'Lecto-Escritura', 1103, 'Trabaja por escribir  cuentos y entender las lecturas correctamente , lee en clase y hace escritos con una muy buena ortografia', 'D5', 'Primer Trimestre', 2023);

--
-- Disparadores `desempeños`
--
DELIMITER $$
CREATE TRIGGER `before_insert_desempeños` BEFORE INSERT ON `desempeños` FOR EACH ROW BEGIN
    DECLARE trimestre_nombre VARCHAR(255);
    DECLARE trimestre_ano INT;

    -- Obtén el nombre del trimestre que se va a insertar en la tabla desempeños
    SET trimestre_nombre = NEW.trimestre;

    -- Busca el año correspondiente en la tabla trimestres
    SELECT YEAR(fecha_inicio) INTO trimestre_ano FROM trimestres WHERE nombre_trimestre = trimestre_nombre;

    -- Inserta el año en la columna correspondiente en la tabla desempeños
    SET NEW.Ano = trimestre_ano;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directivos`
--

CREATE TABLE `directivos` (
  `Id_directivo` int(11) NOT NULL,
  `Nombre_Directivo` varchar(20) NOT NULL,
  `Nombre_Directivo_segundo` varchar(20) NOT NULL,
  `Apellido_Directivo` varchar(20) NOT NULL,
  `Apellido_Directivo_segundo` varchar(20) NOT NULL,
  `Documento_Direc` int(20) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `Cargo` varchar(20) NOT NULL,
  `Activo` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `directivos`
--

INSERT INTO `directivos` (`Id_directivo`, `Nombre_Directivo`, `Nombre_Directivo_segundo`, `Apellido_Directivo`, `Apellido_Directivo_segundo`, `Documento_Direc`, `contraseña`, `Cargo`, `Activo`) VALUES
(13, 'Administrador', '', 'Servidor', '', 123, '$2y$10$PjPtLl9gviWZXE2MwYZLweqFd91WOsO38t4qq94qaFTFjzT9xZ5r.', 'Rector(a)', 1),
(16, 'Alexandra', '', 'Pulido', '', 1234567899, '$2y$10$W78BZhMgCsZWBJ9E8EfQYOsmm48nZe4Z0UnD3hcBIavjNdh/135cq', 'Coordinador(a)', 1),
(21, 'Luz', 'Mery', 'Pulido', '', 1234567889, '$2y$10$fJ9Ap88bp2k7iS3QKXUBnultgATwjD0BqdTCm5P672U0aZ8t0p07m', 'Rector(a)', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `Id_docentes` int(11) NOT NULL,
  `Nombre_Docente` varchar(20) NOT NULL,
  `Nombre_Docente_2` varchar(20) NOT NULL,
  `Apellido_Docente` varchar(20) NOT NULL,
  `Apellido_Docente_2` varchar(20) NOT NULL,
  `Documento_Docente` int(20) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `Numero_curso_asignado` varchar(200) NOT NULL,
  `Nombre_Materia_Asignada` varchar(200) NOT NULL,
  `Activo` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`Id_docentes`, `Nombre_Docente`, `Nombre_Docente_2`, `Apellido_Docente`, `Apellido_Docente_2`, `Documento_Docente`, `contraseña`, `Numero_curso_asignado`, `Nombre_Materia_Asignada`, `Activo`) VALUES
(15, 'Sergio', 'Alfonso', 'Forero', '', 1234567890, '$2y$10$PDue81qinJdYeC3b1iwXfe/wwG9qre3myrns.6vR51nEV/zoewQ3m', '[\"1103\"]', '[\"Español\", \"Lecto-Escritura\", \"Idioma Extranjero-Ingles\"]', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `Id_estudiantes` int(11) NOT NULL,
  `Nombre_Estudiante` varchar(20) NOT NULL,
  `Nombre_Estudiante_2` varchar(20) NOT NULL,
  `Apellido_Estudiante` varchar(20) NOT NULL,
  `Apellido_Estudiante_2` varchar(20) NOT NULL,
  `Documento_Estudiante` int(20) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `Numero_Curso_pertenece` int(4) NOT NULL,
  `Activo` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`Id_estudiantes`, `Nombre_Estudiante`, `Nombre_Estudiante_2`, `Apellido_Estudiante`, `Apellido_Estudiante_2`, `Documento_Estudiante`, `contraseña`, `Numero_Curso_pertenece`, `Activo`) VALUES
(49, 'Dilan', 'Samuel', 'Gutierrez', 'Munevar', 1014193574, '$2y$10$MD8A1LycQSVkVFLAn3AZwO3O/QCG3AqnayHOEjnTN4w2Gj49dIpyi', 1103, 1),
(50, 'Joahn', 'Santiago', 'Ramirez', 'Bustos', 1232355455, '$2y$10$r3vrHEHAymoNiXs0uP3l1eE7Aiopb8VovKhCY7Vo2HtG6yNLdfEg2', 1103, 1),
(51, 'Jose', 'David', 'Hernandez', 'Garcia', 1014278418, '$2y$10$vPLCWQfwtar4TxslKnobz.1VuN0FiCqtd1Idg.GvnUndpJuwFy8o2', 1103, 1),
(52, 'Nicoll', 'Valeria', 'Herrera', 'Pardo', 1940937485, '$2y$10$HXXt/W6SuMpvlsk3GlYyqOFrngAID88OlsX1LOHClw1XLeLsEVUiG', 1103, 1),
(53, 'Juan', 'Felipe', 'Herrera', 'Pardo', 1234567890, '$2y$10$zVpzxTu2/lxVnE9XK2JZf.gt4YV4eLml3Y5NTykqXf282SUSR0CYi', 902, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `id_directivo` int(11) NOT NULL,
  `Nom_mat` varchar(30) NOT NULL,
  `Num_cur` int(10) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `trimestre` varchar(20) NOT NULL,
  `Ano` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_evento`, `id_docente`, `id_directivo`, `Nom_mat`, `Num_cur`, `descripcion`, `target`, `trimestre`, `Ano`) VALUES
(168, NULL, 13, 'Español', 1103, 'Actividad 1', 'eventoMostrado1', 'Primer Trimestre', 2023),
(169, NULL, 13, 'Español', 1103, 'Actividad 2 ', 'eventoMostrado2', 'Primer Trimestre', 2023);

--
-- Disparadores `eventos`
--
DELIMITER $$
CREATE TRIGGER `before_insert_eventos` BEFORE INSERT ON `eventos` FOR EACH ROW BEGIN
    DECLARE trimestre_nombre VARCHAR(255);
    DECLARE trimestre_ano INT;

    -- Obtén el nombre del trimestre que se va a insertar en la tabla eventos
    SET trimestre_nombre = NEW.trimestre;

    -- Busca el año correspondiente en la tabla trimestres
    SELECT YEAR(fecha_inicio) INTO trimestre_ano FROM trimestres WHERE nombre_trimestre = trimestre_nombre;

    -- Inserta el año en la columna correspondiente en la tabla eventos
    SET NEW.Ano = trimestre_ano;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `Id_materias` int(11) NOT NULL,
  `Nombre_Materias` varchar(30) NOT NULL,
  `Porcentaje` float NOT NULL,
  `Id_Area` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`Id_materias`, `Nombre_Materias`, `Porcentaje`, `Id_Area`) VALUES
(41, 'Español', 40, 54),
(42, 'Lecto-Escritura', 20, 54),
(43, 'Idioma Extranjero-Ingles', 40, 54),
(44, 'Calculo', 80, 0),
(45, 'Geometría', 20, 0);

--
-- Disparadores `materias`
--
DELIMITER $$
CREATE TRIGGER `After_Delete_Materia` AFTER DELETE ON `materias` FOR EACH ROW BEGIN
    DECLARE materia_name VARCHAR(255);
    
    -- Obtener el nombre de la materia eliminada
    SET materia_name = OLD.Nombre_Materias;
    
    -- Eliminar el nombre de la materia del arreglo en la tabla areas
    UPDATE areas
    SET Nom_mat_pertenecen = JSON_REMOVE(Nom_mat_pertenecen, JSON_UNQUOTE(JSON_SEARCH(Nom_mat_pertenecen, 'one', materia_name)))
    WHERE JSON_SEARCH(Nom_mat_pertenecen, 'one', materia_name) IS NOT NULL;

    -- Eliminar el nombre de la materia del arreglo en la tabla docentes
    UPDATE docentes
    SET Nombre_Materia_Asignada = JSON_REMOVE(Nombre_Materia_Asignada, JSON_UNQUOTE(JSON_SEARCH(Nombre_Materia_Asignada, 'one', materia_name)))
    WHERE JSON_SEARCH(Nombre_Materia_Asignada, 'one', materia_name) IS NOT NULL;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_Materia` AFTER UPDATE ON `materias` FOR EACH ROW BEGIN
    -- Actualizar el arreglo Nom_mat_pertenecen en la tabla areas
    UPDATE areas
    SET Nom_mat_pertenecen = JSON_REPLACE(Nom_mat_pertenecen, JSON_UNQUOTE(JSON_SEARCH(Nom_mat_pertenecen, 'one', OLD.Nombre_Materias)), NEW.Nombre_Materias)
    WHERE JSON_SEARCH(Nom_mat_pertenecen, 'one', OLD.Nombre_Materias) IS NOT NULL;

    -- Actualizar el arreglo Nombre_Materia_Asignada en la tabla docentes
    UPDATE docentes
    SET Nombre_Materia_Asignada = JSON_REPLACE(Nombre_Materia_Asignada, JSON_UNQUOTE(JSON_SEARCH(Nombre_Materia_Asignada, 'one', OLD.Nombre_Materias)), NEW.Nombre_Materias)
    WHERE JSON_SEARCH(Nombre_Materia_Asignada, 'one', OLD.Nombre_Materias) IS NOT NULL;

    -- Actualizar el campo Curso en la tabla notas
    UPDATE notas
    SET Nom_mat = NEW.Nombre_Materias
    WHERE Nom_mat = OLD.Nombre_Materias;

    -- Actualizar el campo Curso en la tabla eventos
    UPDATE eventos
    SET Nom_mat = NEW.Nombre_Materias
    WHERE Nom_mat = OLD.Nombre_Materias;

    -- Actualizar el campo Curso en la tabla desempeños
    UPDATE desempeños
    SET Nom_mat = NEW.Nombre_Materias
    WHERE Nom_mat = OLD.Nombre_Materias;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `Id_Notas` int(11) NOT NULL,
  `Notas_heteroeva` varchar(255) NOT NULL,
  `Notas_autoevaluacion` varchar(255) NOT NULL,
  `Notas_coevaluacion` varchar(255) NOT NULL,
  `Notas_evaluacion` varchar(255) NOT NULL,
  `desempeños` varchar(255) NOT NULL,
  `Nota_Final` float NOT NULL,
  `Id_Est` int(11) NOT NULL,
  `Nom_mat` varchar(30) NOT NULL,
  `Num_cur` int(10) NOT NULL,
  `trimestre` varchar(20) NOT NULL,
  `Ano` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`Id_Notas`, `Notas_heteroeva`, `Notas_autoevaluacion`, `Notas_coevaluacion`, `Notas_evaluacion`, `desempeños`, `Nota_Final`, `Id_Est`, `Nom_mat`, `Num_cur`, `trimestre`, `Ano`) VALUES
(276, '[\"100\",\"100\",\"70\",\"100\",\"100\",\"100\",\"100\",\"20\",\"\",\"\"]', '[\"20\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 61.375, 49, 'Español', 1103, 'Primer Trimestre', 2023),
(277, '[\"100\",\"100\",\"100\",\"100\",\"100\",\"100\",\"20\",\"\",\"\",\"\"]', '[\"100\"]', '[\"20\"]', '[\"50\"]', '[\"S\",\"S\",\"S\",\"S\",\"S\"]', 78, 51, 'Español', 1103, 'Primer Trimestre', 2023),
(278, '[\"100\",\"100\",\"50\",\"100\",\"100\",\"70\",\"100\",\"\",\"100\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 62, 52, 'Español', 1103, 'Primer Trimestre', 2023),
(279, '[\"20\",\"100\",\"40\",\"100\",\"100\",\"100\",\"50\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 51, 50, 'Español', 1103, 'Primer Trimestre', 2023),
(280, '[\"100\",\"100\",\"50\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 70, 49, 'Lecto-Escritura', 1103, 'Primer Trimestre', 2023),
(281, '[\"100\",\"50\",\"20\",\"100\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"100\"]', '[\"100\"]', '[\"50\"]', '[\"S\",\"S\",\"S\",\"S\",\"S\"]', 67.25, 51, 'Lecto-Escritura', 1103, 'Primer Trimestre', 2023),
(282, '[\"100\",\"50\",\"20\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 39.6667, 52, 'Lecto-Escritura', 1103, 'Primer Trimestre', 2023),
(283, '[\"20\",\"100\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 42, 50, 'Lecto-Escritura', 1103, 'Primer Trimestre', 2023),
(284, '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 0, 49, 'Idioma Extranjero-Ingles', 1103, 'Primer Trimestre', 2023),
(285, '[\"100\",\"100\",\"100\",\"100\",\"20\",\"\",\"\",\"\",\"\",\"\"]', '[\"100\"]', '[\"20\"]', '[\"50\"]', '[\"S\",\"S\",\"S\",\"S\",\"S\"]', 74.8, 51, 'Idioma Extranjero-Ingles', 1103, 'Primer Trimestre', 2023),
(286, '[\"100\",\"20\",\"100\",\"\",\"100\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 0, 52, 'Idioma Extranjero-Ingles', 1103, 'Primer Trimestre', 2023),
(287, '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 0, 50, 'Idioma Extranjero-Ingles', 1103, 'Primer Trimestre', 2023),
(288, '[\"100\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 0, 49, 'Español', 1103, 'Segundo Trimestre', 2023),
(289, '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 0, 51, 'Español', 1103, 'Segundo Trimestre', 2023),
(290, '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 0, 52, 'Español', 1103, 'Segundo Trimestre', 2023),
(291, '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 0, 50, 'Español', 1103, 'Segundo Trimestre', 2023),
(292, '[\"100\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\",\"\",\"\",\"\",\"\"]', 0, 53, 'Español', 902, 'Primer Trimestre', 2023);

--
-- Disparadores `notas`
--
DELIMITER $$
CREATE TRIGGER `before_insert_notas` BEFORE INSERT ON `notas` FOR EACH ROW BEGIN
    DECLARE trimestre_nombre VARCHAR(255);
    DECLARE trimestre_ano INT;

    -- Obtén el nombre del trimestre que se va a insertar en la tabla notas
    SET trimestre_nombre = NEW.trimestre;

    -- Busca el año correspondiente en la tabla trimestres
    SELECT YEAR(Fecha_inicio) INTO trimestre_ano FROM trimestres WHERE nombre_trimestre = trimestre_nombre;

    -- Inserta el año en la columna correspondiente en la tabla notas
    SET NEW.Ano = trimestre_ano;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trimestres`
--

CREATE TABLE `trimestres` (
  `Id_trimestre` int(11) NOT NULL,
  `nombre_trimestre` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_finalizacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `trimestres`
--

INSERT INTO `trimestres` (`Id_trimestre`, `nombre_trimestre`, `fecha_inicio`, `fecha_finalizacion`) VALUES
(17, 'Primer Trimestre', '2023-11-08', '2023-11-10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`Id_Area`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`Id_curso`);

--
-- Indices de la tabla `desempeños`
--
ALTER TABLE `desempeños`
  ADD PRIMARY KEY (`id_desempeno`);

--
-- Indices de la tabla `directivos`
--
ALTER TABLE `directivos`
  ADD PRIMARY KEY (`Id_directivo`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`Id_docentes`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`Id_estudiantes`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`Id_materias`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`Id_Notas`);

--
-- Indices de la tabla `trimestres`
--
ALTER TABLE `trimestres`
  ADD PRIMARY KEY (`Id_trimestre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `Id_Area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `Id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `desempeños`
--
ALTER TABLE `desempeños`
  MODIFY `id_desempeno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `directivos`
--
ALTER TABLE `directivos`
  MODIFY `Id_directivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `Id_docentes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `Id_estudiantes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `Id_materias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `Id_Notas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;

--
-- AUTO_INCREMENT de la tabla `trimestres`
--
ALTER TABLE `trimestres`
  MODIFY `Id_trimestre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
