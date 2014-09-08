<?php
	include('util.php');
	$consulta = "SELECT id_pre FROM pregunta WHERE id_enc ='".$_GET['encuesta']."'";
?>