<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Encuesta</title>
<script>
	function validacion(){
		cntreg = document.getElementsByName('carnet').item(0).value;
		_rad = document.getElementsByName('rad');
		_pass = document.getElementsByName('pass').item(0).value;
		if(cntreg == ""){
			alert('ERROR: Debe poner un numero de Carnet o Registro si es Universitario');
			return false;
		}
		if(isNaN(cntreg)){
			alert('ERROR: En el campo "C.I o Nº Reg:" sólo se permiten valores numéricos');
			return false;
		}
		var seleccionado = false;
		var n=0;
		for(var i=0; i<_rad.length; i++) {    
		  if(_rad[i].checked) {
			seleccionado = true;
			n=i;
			break;
		  }
		}
		if(_rad.item(n).value == "univ"){
			if(_pass==""){
				alert('Error: Ha seleccionado universitario y no puso su contraseña');
				return false;
			}
		}		
		return true;
	}

</script>
</head>
<body>
	<?php		
		include('util.php');
		/* SI ES QUE NO SE RECIBE NUMERO DE CARNET O SE RECIBE NOMBRE */
		if(!isset($_POST['carnet'])||isset($_POST['nombre'])){	
			/*EN CASO DE QUE NO HAY NUMERO DE CARNET, SE MUESTRA LA PAGINA INICIAL*/
			if(!isset($_POST['carnet'])){	
			?>
				<div align="center">
                	<form name="login" method="post" action="" onSubmit="return validacion()">
                    	C.I o Nº Reg: <input type="text" name="carnet">
                    	<input type="submit" value="Siguiente"><br>
                        Contraseña:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="password" name="pass" disabled>
                        <label onClick="alert('Su Contraseña es la convinacion de las dos primeras  letras de sus apellidos con sus nombres (perez ortiz juan pablo=peorjupa) ')">(Universitario)</label><br>   
                        <input type="radio" name="rad" value="univ" onClick="login.pass.disabled=false"> Universitario
                        <input type="radio" name="rad" value="otro" checked onClick="login.pass.disabled=true"> Visitante                    
					</form>
                </div>
			<?php
			/*EN CASO DE QUE SE RECIBE UN NOMBRE Y POR ENDE UN NUMERO DE CARNET - SE PROCEDE A REGISTRAR AL VISITANTE
			  Y REDIRECCIONAR LA PAGINA PARA QUE VAYA A VOTAR*/
            }else{
				$ci = $_POST['carnet'];	
				$nombre = $_POST['nombre'];
				$mysqli = conectar();
				$consulta = "INSERT INTO votante(ci,nombre) VALUES('".$ci."','".strtoupper($nombre)."');";
				$resultado = $mysqli->query($consulta);
				if($resultado){
					$mysqli->close();
					header('Location: encuesta.php?votante='.$ci.'');
				}
				$mysqli->close();
				die('error al registrar los datos, consulte al administrador');
			}
		}else{
			/*EN CASO DE QUE SE RECIBA SOLAMENTE NUMERO DE CARNET O REGISTRO, SE PROCEDE A CONSUTLAR SI EL USUARIO
			EXISTE EN ALGUNA DE LAS TABLAS DE REGISTRO*/
			if(isset($_POST['pass'])){
				$pass = $_POST['pass'];
				$consulta = "SELECT * FROM universitario 
							WHERE registro = '".$_POST['carnet']."' AND pass ='".sha1(strtoupper($pass))."';";
			}else{
				$consulta = "SELECT ci,nombre,colegio FROM votante WHERE ci = '".$_POST['carnet']."';";
			}
			$mysqli = conectar();
			$resultado = $mysqli->query($consulta);
			if($resultado){
				if(isset($pass)){
					while($fila = $resultado->fetch_assoc()){
						$nombre = $_fila['nombre'];	
						$reg = $fila['registro'];
						$carr = $fila['carrera'];
					}
				}else{
					while($fila = $resultado->fetch_assoc()){
						$nombre = $fila['nombre'];
						$col = $fila['colegio'];
						$ci = $fila['ci'];	
					}
				}
			}		
			
			if(!isset($ci)&&!isset($carr)){
				if(!isset($pass)){
					echo '<div align="center"><form method="post" action="">
					C.I:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="carnet" value="'.$_POST['carnet'].'"><br>
					Nombre:<input type="text" name="nombre"><br>
					<input type="submit" value="Registrar">
					</form> </div>';
				}else{
					die('ERROR: Los datos ingresados como universitario, no coinciden, revise su información');	
				}
			}else{
				if(isset($pass)){
					//relocate(‘page.php’,{‘var1':’hola’,'var2':’Mundo’});
					header('Location: encuesta.php?votante='.$reg.'&univ=1');
				}else{
					header('Location: encuesta.php?votante='.$ci.'');
				}
			}
			$mysqli->close();
		}
	?>
</body>
</html>
