<?php
require_once('../clases/mascotaClass.php');
$idUser = $_GET['idUsuario'];
$idMuroMascota = $_GET['idMuroMascota'];

Mascota::cambiarDeDuenio($idUser, $idMuroMascota);
header("location:cambiarMascotaAAdopcionController.php?adopcion=0&mascota=".$idMuroMascota);
?>
