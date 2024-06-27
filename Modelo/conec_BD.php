<?php
$conex=mysqli_connect("localhost","root","","sistemadeplanillas");

$hostDB = '127.0.0.1';
$nombreDB='sistemadeplanillas';
$usuarioDB='root';
$contrasenaDB='';
$hostPDO="mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO= new PDO($hostPDO,$usuarioDB,$contrasenaDB);

?>