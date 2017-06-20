<?php
	require ("../clases/MuroMascotaClass.php");
	require ("../clases/mascotaClass.php");

	// $usuario = $_GET["id_usuario"];
	// $idUsuario = (int)$usuario;
	// $sexo = 4;
	// $fechaNacimiento = '2017-01-01';
	// $urlLite = "urlSarasa";
	// $nombre = "pancho";
	// $idMuroMascota = 1;
	// $idRaza = 1;
	// $idAnimal = 1;

	$usuario = $_POST["id_usuario"];
	$idUsuario = (int)$usuario;
	$sexo = $_POST["opcionesSexo"];
	$fechaNacimiento = $_POST["fechaNacimiento"];
	$urlLite = "urlSarasa";
	$nombre = $_POST["nombre"];
	$idRaza = $_POST["tipoRaza"];
	$idAnimal = $_POST["tipoAnimal"];
	$fotoPerfil = $_POST["fotoPerfil"];

	var_dump($idUsuario,$sexo,$fechaNacimiento,$urlLite,$nombre,$idRaza,$idAnimal,$fotoPerfil);
	die();
	$adopcion = 0;
	$cita = 0;
	$perdido = 0;

	$muroMascota = new MuroMascota($adopcion, $cita, $perdido);
	$idMuroMascota = $muroMascota->persistirMuroMascota();

	$mascota = new Mascota($idUsuario, $sexo, $fechaNacimiento, $urlLite, $nombre, $idMuroMascota, $idRaza, $idAnimal, $fotoPerfil);
	$resultado_ingreso = $mascota->persistirMascota();
	$resultado_consulta = Mascota::ingresarMascota($id,$nombre);

	if(!$consultaIsTrue){
		header("location:../vistas/pantallaLogueada.php");
	}else{
		// echo "<h1>Ha ocurrido un error</h1><h3>Debera volver a intentarlo</h3><a href='index.php'>Volver a Fluffy</a>";
	}

?>
