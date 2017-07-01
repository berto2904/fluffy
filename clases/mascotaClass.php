<?php


require_once("connQuery.php");




Class Mascota{

	private $idUsuario;
	private $sexo;
	private $fechaNacimiento;
	private $urlLite;
	private $nombre;
	private $idMuroMascota;
	private $idRaza;
	private $idAnimal;
	private $fotoPerfil;
	function __construct($idUsuario, $sexo, $fechaNacimiento, $urlLite, $nombre, $idMuroMascota, $idRaza, $idAnimal, $fotoPerfil){
		$this->idUsuario = $idUsuario;
		$this->sexo = $sexo;
		$this->fechaNacimiento = $fechaNacimiento;
		$this->urlLite = $urlLite;
		$this->nombre = $nombre;
		$this->idMuroMascota = $idMuroMascota;
		$this->idRaza = $idRaza;
		$this->idAnimal = $idAnimal;
		$this->fotoPerfil = $fotoPerfil;
	}

	function persistirMascota(){
		$cq = new ConnQuery();
		$sql = "insert into mascota (	id_usuario,
										id_sexo,
										fecha_nacimiento,
										url_lite,
										nombre,
										id_muro_mascota,
										id_raza,
										id_animal,
										foto_mascota) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ps = $cq->prepare($sql);
		mysqli_stmt_bind_param($ps,
		"iisssiiis",
		$this->idUsuario,
		$this->sexo,
		$this->fechaNacimiento,
		$this->urlLite,
		$this->nombre,
		$this->idMuroMascota,
		$this->idRaza,
		$this->idAnimal,
		$this->fotoPerfil);
		$persistenciaMascota = mysqli_stmt_execute($ps);
	}

	public static function  ingresarMascota ($id,$nombre){
		$cq = new ConnQuery();
		$sql = "select * from mascota where id = ? and nombre = ? ";
		$ps = $cq->prepare($sql);

		mysqli_stmt_bind_param($ps,
		"is",
		$idMascota,
		$nombre);

		mysqli_stmt_execute($ps);
		$consultaIsTrue = mysqli_stmt_fetch($ps);

		return $consultaIsTrue;
	}

	public static function  consultarTipoAnimal (){
		$cq = new ConnQuery();
		$sql = "select id_animal, descripcion from animal";
		$ps = $cq->ejecutarConsulta($sql);

		$resultadoConsulta = array();
		while ($filaResultado = mysqli_fetch_assoc($ps)) {
			$resultadoConsulta[] =  $filaResultado;
		}

		return $resultadoConsulta;
	}

	public static function  consultarTipoRaza ($id_animal){
		$cq = new ConnQuery();
		$sql = "select id_raza, descripcion from raza where id_animal =".$id_animal;
		$ps = $cq->ejecutarConsulta($sql);

		$resultadoConsulta = array();
		while ($filaResultado = mysqli_fetch_assoc($ps)) {
			$resultadoConsulta[] =  $filaResultado;
		}

		return $resultadoConsulta;
	}
	public static function getMascotasListByIdUsuario($idUsuario){
	    $cq = new connQuery();
	    $sql = "select  mm.id_muro_mascota          muro_mascota,
							        m.nombre                    nombre_mascota,
							        m.foto_mascota              foto_mascota
											from mascota m
											join usuario u on u.id_usuario = m.id_usuario
											join muro_mascota mm on m.id_muro_mascota = mm.id_muro_mascota
											where u.id_usuario =".$idUsuario.";";

	    $filas = $cq->ejecutarConsulta($sql);
	    $mascotasUser = array();

	    while ($fila =  mysqli_fetch_assoc($filas)) {
	      $mascotaUser = array( 'muroMascota' => $fila['muro_mascota'],
	      											'nombreMascota' => $fila['nombre_mascota'],
															'fotoMascota'	=> $fila['foto_mascota']
	           										);
				$mascotasUser[] = $mascotaUser;
				}
			return $mascotasUser;
	}



	public static function verPerdidos($desde, $cantidad){
		$conexion = new ConnQuery();

		//definicion de la consulta
		$sql = "SELECT  M.id_mascota, M.nombre nombreMascota, U.id_usuario, U.nombre nombreUsuario
			FROM usuario U join mascota M on U.id_usuario=M.id_usuario join
				muro_mascota MM on MM.id_muro_mascota=M.id_muro_mascota 
			where MM.perdido =  1
			limit ?,?";
		/* private $idUsuario;
	private $sexo;
	private $fechaNacimiento;
	private $urlLite;
	private $nombre;
	private $idMuroMascota;
	private $idRaza;
	private $idAnimal;
	private $fotoPerfil;*/
		//ejecucion de prepare_statement	
		$stmt = $conexion->prepare($sql);
		//bindeo de datos al statement
		mysqli_stmt_bind_param($stmt, "ii", $desde, $cantidad);
		//ejecucion de statement
		mysqli_stmt_execute($stmt);

		$output = array();
		//captura del resultado de la ejecucion del statement
		$resultado = mysqli_stmt_get_result($stmt);
		//preparacion del array a retornar
		while($fila = mysqli_fetch_assoc($resultado)){
			$output[] = $fila;
		}

		return $output;
	}

	public static function verEnAdopcion($desde, $cantidad){
		$conexion = new ConnQuery();

		//definicion de la consulta
		$sql = "SELECT  M.id_mascota, M.nombre nombreMascota, U.id_usuario, U.nombre nombreUsuario
			FROM usuario U join mascota M on U.id_usuario=M.id_usuario join
				muro_mascota MM on MM.id_muro_mascota=M.id_muro_mascota 
			where MM.adopcion =  1
			limit ?,?";

		//ejecucion de prepare_statement	
		$stmt = $conexion->prepare($sql);
		//bindeo de datos al statement
		mysqli_stmt_bind_param($stmt, "ii", $desde, $cantidad);
		//ejecucion de statement
		mysqli_stmt_execute($stmt);

		$output = array();
		//captura del resultado de la ejecucion del statement
		$resultado = mysqli_stmt_get_result($stmt);
		//preparacion del array a retornar
		while($fila = mysqli_fetch_assoc($resultado)){
			$output[] = $fila;
		}
		
		return $output;
	}

	public static function traerCitas( $desde, $cantidad){
		
		$conexion = new ConnQuery();

		$output = array();
		$sql = "SELECT  M.id_mascota, M.nombre nombreMascota, U.id_usuario, U.nombre nombreUsuario
			FROM usuario U join mascota M on U.id_usuario=M.id_usuario join
				muro_mascota MM on MM.id_muro_mascota=M.id_muro_mascota 
			where MM.cita =  1
			limit ?,?";

		$stmt = $conexion->prepare($sql);

		mysqli_stmt_bind_param($stmt, "ii", $desde, $cantidad);

		mysqli_stmt_execute($stmt);
		$resultado = mysqli_stmt_get_result($stmt);

		while ($row = mysqli_fetch_array($resultado)) {
			$output[] =$row;
		}
		
		return $output;								

	}
	

}

?>
