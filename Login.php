<?php

$documento=isset($_REQUEST['documento'])?$_REQUEST['documento']:null;
$password=isset($_REQUEST['contrasena'])?$_REQUEST['contrasena']:null;
$Cargo=isset($_REQUEST['cargo'])?$_REQUEST['cargo']:null;

$errores=[];
if($_SERVER['REQUEST_METHOD']=='POST'){
     $input = $_POST["usuario"];
     if (!empty($input) && strpos($input, ' ') !== false) {
          list($nombre, $apellido) = explode(" ", $input);
          if (!empty($nombre) && !empty($apellido)) {
               if($Cargo == "Rector(a)" || $Cargo == "Coordinador(a)"){
                    $usuario="root"; 
                    $clave='';
                    $miPDO= new PDO('mysql:host=localhost;dbname=sistemadeplanillas',$usuario,$clave);
                    
                    $miConsulta=$miPDO->prepare("SELECT Activo, contraseña FROM directivos WHERE Documento_Direc=:documento AND Cargo=:cargo AND Nombre_Directivo=:nombre AND Apellido_Directivo=:apellido");
                    $miConsulta->execute([
                         'documento' => $documento,
                         'cargo' => $Cargo,
                         'nombre' => $nombre,
                         'apellido' => $apellido
                    ]);
                    $resultado=$miConsulta->fetch();
                    if ($resultado) {
                    if((int)$resultado['Activo']!==1){
                    $errores[]='Usuario inactivo. Por favor, contacte con el Administrador';
                    }else{
                         if(password_verify($password,$resultado['contraseña'])){
               
                              session_start();
                              $_SESSION["usuario"] = $nombre . " " . $apellido;
                              $_SESSION['cargo']=$Cargo;
                              $_SESSION['documento']=$documento;
               
                                   // Establecer una cookie con un nombre que indique que el mensaje ya se mostró
                                   setcookie("bienvenida_mostrada", "true", time() + 5, "/"); // La cookie expirará en 5seg
                                   // Redirigir al usuario a la página principal
                                   header('location: Pagina_principal.php');
                                   die();
                         }else{
                              $errores[]='Los datos ingresados son incorrectos. Por favor, verifica la información e inténtalo nuevamente';
                         }
                    }
                    }else{
                              $errores[] = 'Los datos ingresados son incorrectos. Por favor, verifica la información e inténtalo nuevamente';
                         }
                    }
                    elseif($Cargo == 'Docente'){
                    $usuario="root"; 
                    $clave='';
                    $miPDO= new PDO('mysql:host=localhost;dbname=sistemadeplanillas',$usuario,$clave);
                    
                    $miConsulta=$miPDO->prepare("SELECT Activo, contraseña FROM docentes WHERE Documento_Docente=:documento AND Nombre_Docente=:nombre AND Apellido_Docente=:apellido");
                    $miConsulta->execute([
                         'documento' => $documento,
                         'nombre' => $nombre,
                         'apellido' => $apellido
                    ]);
                    $resultado=$miConsulta->fetch();
                    if ($resultado) {
                    if((int)$resultado['Activo']!==1){
                    $errores[]='Usuario inactivo. Por favor, contacte con el Administrador ';
                    }else{
                         if(password_verify($password,$resultado['contraseña'])){
                              session_start();
                              $_SESSION["usuario"] = $nombre . " " . $apellido;
                              $_SESSION['cargo']=$Cargo;
                              $_SESSION['documento']=$documento;
                              
                                   // Establecer una cookie con un nombre que indique que el mensaje ya se mostró
                                   setcookie("bienvenida_mostrada", "true", time() + 5, "/"); // La cookie expirará en 5seg
                                   // Redirigir al usuario a la página principal
                                   header('location:Pagina_principal.php');
                                   die();
                         }else{
                              $errores[]='Los datos ingresados son incorrectos. Por favor, verifica la información e inténtalo nuevamente';
                         }
                    }
                    }else{
                              $errores[] = 'Los datos ingresados son incorrectos. Por favor, verifica la información e inténtalo nuevamente';
                         }
                    }
                    elseif($Cargo == 'Estudiante'){
                    $usuario="root"; 
                    $clave='';
                    $miPDO= new PDO('mysql:host=localhost;dbname=sistemadeplanillas',$usuario,$clave);
                    
                    $miConsulta=$miPDO->prepare("SELECT Activo, contraseña FROM estudiantes WHERE Documento_Estudiante=:documento AND Nombre_Estudiante=:nombre AND Apellido_Estudiante=:apellido");
                    $miConsulta->execute([
                         'documento' => $documento,
                         'nombre' => $nombre,
                         'apellido' => $apellido
                    ]);
                    $resultado=$miConsulta->fetch();
                    if ($resultado) {
                    if((int)$resultado['Activo']!==1){
                    $errores[]='Usuario inactivo. Por favor, contacte con el Administrador ';
                    }else{
                         if(password_verify($password,$resultado['contraseña'])){
                              session_start();
                              $_SESSION["usuario"] = $nombre . " " . $apellido;
                              $_SESSION['cargo']=$Cargo;
                              $_SESSION['documento']=$documento;
                              
                                   // Establecer una cookie con un nombre que indique que el mensaje ya se mostró
                                   setcookie("bienvenida_mostrada", "true", time() + 5, "/"); // La cookie expirará en 5seg
                                   // Redirigir al usuario a la página principal
                                   header('location:Pagina_principal.php');
                                   die();
                         }else{
                              $errores[]='Los datos ingresados son incorrectos. Por favor, verifica la información e inténtalo nuevamente';
                         }
                    }
                    }else{
                              $errores[] = 'Los datos ingresados son incorrectos. Por favor, verifica la información e inténtalo nuevamente';
                         }
                    }
          }else {
               $errores[] = 'Los datos ingresados son incorrectos. Por favor, verifica la información e inténtalo nuevamente';
          }
     }else{
          $errores[] = 'Los datos ingresados son incorrectos. Por favor, verifica la información e inténtalo nuevamente';
     }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="Vista/Estilo/Login.css">
     <link rel="shorcut icon" href="Vista/IMG/escudo.png">
     <script src="https://kit.fontawesome.com/5038b205c4.js" crossorigin="anonymous"></script>
     <!--Google Font-->
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
     <title>Inicio de sesión</title>
</head>
<body>



     <img src="Vista/IMG/escudo.png" id="escudo">
     <section id="Login">
          
          <form  method="post">
               <img src="Vista/IMG/usuario.png" id="IM1">

               
          <!-- Nombre y apellido -->
          <div class="campos">
                    <i class="fa-solid fa-user-large" class="icono"></i>
                    <input type="text" placeholder="Nombre y Apellido" required name="usuario" autocomplete="off">
               </div>
               <br>
          <!-- Documento -->
          <div class="campos">
                    <i class="fa-solid fa-address-card" class="icono"></i>
                    <input type="text" placeholder="Documento" required name="documento" autocomplete="off">
               </div>
               <br>
          <!-- Contraseña -->
               <div class="campos">
                    <i class="fa-solid fa-key" class="icono"></i>
                    <input type="password" placeholder="Contraseña" required name="contrasena" autocomplete="off">
               </div>
               <br>
          <!-- Cargo/Rol -->
          
          <div class="select">
               <select  id="format" name="cargo">
               <option selected disabled>Tu rol en la institución es de :</option>
               <option value="Rector(a)" >Rector(a)</option>
               <option value="Coordinador(a)" >Coordinador(a)</option>
               <option value="Docente" >Docente</option>
               <option value="Estudiante" >Estudiante</option>
               </select>
          </div>

               <p id="text"></p>
          <!--Boton-->
               <button type="submit" name="Ingresar">
                    <h3 id="boton">Ingresar</h3>
               </button>

               
          </form>
     </section>
     <?php if(count($errores) > 0): ?>
          <div class="errores">
               <?php foreach($errores as $error): ?>
                    <p><?= $error ?></p>
               <?php endforeach; ?>
          </div>
     <?php endif; ?>
</body>
</html>