<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Encuesta</title>
</head>
<body>
	<?php		
		include('util.php');
		if(!isset($_POST['carnet'])||isset($_POST['nombre'])){	
			if(!isset($_POST['carnet'])){	
				echo '<div align="center"><form method="post" action="">
				C.I o Nº Reg: <input type="text" name="carnet">
				<input type="submit" value="Siguiente">
				</form></div>';
			}else{
				$ci = $_POST['carnet'];	
				$nombre = $_POST['nombre'];
				$mysqli = conectar();
				$consulta = "INSERT INTO votante(ci,nombre) VALUES('".$ci."','".strtoupper($nombre)."');";
				$resultado = $mysqli->query($consulta);
				if($resultado){
					$mysqli->close();
					header('Location: encuesta.php?votante='.$ci.'');
				}else{
					$mysqli->close();
					die('ERROR AL REGISTRAR DATOS');	
				}
			}
		}else{
			$mysqli = conectar();
			$consulta = "SELECT ci,nombre,registro FROM votante WHERE ci = '".$_POST['carnet'].
						"' or registro='".$_POST['carnet']."';";
			$resultado = $mysqli->query($consulta);
			if($resultado){
				while($fila = $resultado->fetch_assoc()){
					$nombre = $fila['nombre'];
					$reg = $fila['registro'];
					$ci = $fila['ci'];	
				}
			}
			if(!isset($ci)){
				echo '<div align="center"><form method="post" action="">
				C.I:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" name="carnet" value="'.$_POST['carnet'].'"><br>
				Nombre:<input type="text" name="nombre"><br>
				<input type="submit" value="Registrar">
				</form> </div>';
			}else{
				header('Location: encuesta.php?votante='.$ci.'');
			}
			$mysqli->close();
		}
	?>
</body>
</html>
