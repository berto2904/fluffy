<?php
require ('../connQuery.php');

$usuarioIngreso = $_POST["user"];
$passIngreso = $_POST["pass"];

$queryStringIngresoEmail = 'select * from usuario where e_mail = "'.$usuarioIngreso.'" and contrasenia ="'.$passIngreso.'"';
$queryStringIngresoUser = 'select * from usuario where nombre_usuario = "'.$usuarioIngreso.'" and contrasenia ="'.$passIngreso.'"';

$connQuery = new connQuery();
$resultadoConEmail = $connQuery->ejecutarConsulta($queryStringIngresoEmail);
$resultadoConUserName = $connQuery->ejecutarConsulta($queryStringIngresoUser);
$idUsuario = null;

session_start();

if ($resultadoConEmail) {
  $idUsuario = $connQuery->getFila($queryStringIngresoEmail)['id_usuario'];
  $_SESSION["usuario"] = $idUsuario;
  header("location: ../pantallaLogueada.php");

}else if ($resultadoConUserName) {
  $idUsuario = $connQuery->getFila($queryStringIngresoUser)['id_usuario'];
  $usuario = $_SESSION["usuario"] = $idUsuario;
  header("location:../pantallaLogueada.php");
}else {
    session_destroy();
    header("location:../index.php");
  }

?>