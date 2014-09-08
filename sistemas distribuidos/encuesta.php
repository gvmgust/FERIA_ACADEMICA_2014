<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Encuesta</title>
</head>
<body>
	<?php
		include('util.php');
		if(isset($_GET['votante']) && !isset($_POST['encuesta'])){
			$mysqli = conectar();
			$ci = $_GET['votante'];
			$consulta = "SELECT * FROM votante WHERE ci = '".$ci."'";
			$ci=NULL;
			$resultado = $mysqli->query($consulta);
			if($resultado){
				while($fila = $resultado->fetch_assoc()){
					$ci = $fila['ci'];
					$registro = $fila['registro'];
					$nombre = $fila['nombre'];	
				}
			}
			$mysqli->close();
			## error cuando se introduce un usuario no registrado
			
			if($ci==NULL)
				die('ERROR: NO REGISTRADO');
							
			## lista de encuestas en la que no ha participado el elector
			$ci = $_GET['votante'];
			$consulta = "SELECT encuesta.`id_enc`,encuesta.`titulo`
						FROM encuesta LEFT JOIN responde
						ON encuesta.id_enc = responde.id_enc AND ci = ".$ci."
						WHERE responde.`id_enc` IS NULL AND estado = '1';";
			$mysqli = conectar();
			$resultado = $mysqli->query($consulta);
			
			if($resultado){
				while($fila = $resultado->fetch_assoc()){
					echo '<div align="center"><form method="post" 
						  action="encuesta.php?votante='.$_GET['votante'].'">'."\n";
					echo '<input type="hidden" name=encuesta value="'.$fila['id_enc'].'">';
					echo '<input type="submit" name="votar" value="'.$fila['titulo'].'"></form>'."\n</div>";
				}
			}
			$mysqli->close();
			
		}else{
			if(!isset($_POST['encuesta'])||!isset($_GET['votante'])){
				die('usted no está autorizado para votar');
			}
			$pregunta = new pregunta();
			$pregunta->listar($_POST['encuesta'],$_GET['votante']);
		}
	?>
</body>
</html>
