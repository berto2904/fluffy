<?php
	require_once("../clases/MuroMascotaClass.php");
	require_once("../clases/mascotaClass.php");
	require_once ("../clases/UsuarioClass.php");


	$usuario = $_POST["id_usuario"];
	$idUsuario = (int)$usuario;
	$sexo = $_POST["opcionesSexo"];
	$fechaNacimiento = $_POST["fechaNacimiento"];
	$urlLite = "urlSarasa";
	$nombre = $_POST["nombre"];
	$idRaza = $_POST["tipoRaza"];
	$idAnimal = $_POST["tipoAnimal"];
	$fotoPerfil = $_FILES["fotoPerfil"];

	$idRazaInt = (int)$idRaza;
	$idAnimalInt = (int)$idAnimal;


	$adopcion = 0;
	$cita = 0;
	$perdido = 0;

	$muroMascota = new MuroMascota($adopcion, $cita, $perdido);
	$idMuroMascota = $muroMascota->persistirMuroMascota();

// Ingreso de la foto de perfil de la mascota a carpeta resources
	//Obtengo nombre del archivo original y obtengo la extension
	$nombreFoto = $fotoPerfil['name'];
	$ext = pathinfo($nombreFoto, PATHINFO_EXTENSION);
	//creo el path para almacenar la foto donde quiero
	$pathFotoMascota = "resources/fotosDePerfiles/mascotas/mascota_".$usuario."_".$idMuroMascota.".".$ext;
	move_uploaded_file($fotoPerfil['tmp_name'], "../".$pathFotoMascota);
//Fin de ingreso de foto de perfil a la carpeta resources

//Llamado datos de Usuario por ID
	//$usuarioArray = Usuario::consultarUsuarioPorID($idUsuario);
	//$animal = Mascota::consultarTipoAnimalPorID($idAnimal);
	//$raza = Mascota::consultarTipoRazaPorID($idRaza);
	//$sexoDescripcion = Mascota::consultarSexoPorID($sexo);

//Armado de String URLLite
	$urlBase = "/perfilesExternos/perfilExternoMascota.php?fluffy=" . $idMuroMascota;
	$urlLite = $urlBase;	
	
	

//Fin armado URLLite

	$mascota = new Mascota($idUsuario, $sexo, $fechaNacimiento, $urlLite, $nombre, $idMuroMascota, $idRazaInt, $idAnimalInt, $pathFotoMascota);
	$mascota->persistirMascota();
	
	header("location:../vistas/home.php");
	

?>
