<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="Refresh" content="5;url=index.php">
<title>Encuesta</title>
</head>
<body>
<?php
	include('util.php');
	if(!isset($_POST['encuesta'])){
		die("Usted no est� autorizado para votar");
	}
	$consulta = "SELECT id_pre FROM pregunta WHERE id_enc ='".$_POST['encuesta']."' ORDER BY id_pre";
	$mysqli = conectar();
	$resultado = $mysqli->query($consulta);
	$verificacion = NULL;
	if($resultado){
		while($fila = $resultado->fetch_assoc()){
			$verificacion[] = $fila['id_pre'];
		}
	}
	$mysqli->close();
	for($i = 0;$i< count($verificacion);$i++){
		if(!isset($_POST['p'.$verificacion[$i]]))
			die('FALTAN PREGUNTAS POR RESPONDER EN SU ENCUESTA');	
	}
	if(!isset($_POST['encuestado'])){
		die('Usted no est� autorizado para votar');
	}
	$enc = $_POST['encuesta'];
	$vot = $_POST['encuestado'];
	$mysqli = conectar();
	$consulta = "SELECT MAX(num)+1 num FROM guarda";
	$respuesta = $mysqli->query($consulta);
	$num = 1;
	if($respuesta){
		while($fila = $respuesta->fetch_assoc()){
			if($fila['num']!= NULL)
				$num = $fila['num'];
		}
	}
	$mysqli->close();
	$r = NULL;
	$mysqli = conectar();
	$consulta = "SELECT fecha FROM responde WHERE id_enc = '".$enc."' AND ci = '".$vot."'"; 
	$flag = false;
	$respuesta = $mysqli->query($consulta);
	if($respuesta){
		while($fila = $respuesta->fetch_assoc()){
			$fecha = $fila['fecha'];
			$flag = true;
		}
	}
	
	if(!$flag){
		for($i = 0;$i< count($verificacion);$i++){
			$r = $_POST['p'.$verificacion[$i]];	
			$consulta = "INSERT INTO guarda(num,id_pre,res)VALUES('".$num."','".$verificacion[$i]."','".$r."');";
			$mysqli->query($consulta);
		}
		$consulta = "INSERT INTO responde(id_enc,ci)VALUES('".$enc."','".$vot."');";
		$mysqli->query($consulta);
		$mysqli->close();
		echo "Su Votaci�n est� siendo procesada...<br>
		gracias por su participaci�n";
	}else{
		die('ERROR: Usted ya participo de esta encuesta en esta fecha:"'.$fecha.'"');
	}
?>
</body>
</html>

