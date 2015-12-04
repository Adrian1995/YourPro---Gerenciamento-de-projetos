<?php
	include ("yconectaDB.inc");

	$usuario_id = $_POST["usuario_id"];
	$usuario_senha = $_POST["usuario_senha"];
	
	$usuario_senha =  md5($usuario_senha);
	
	$editaUsuario = mysqli_query ($conectaBanco, "UPDATE login SET 	usuario_senha='$usuario_senha'
										
										WHERE usuario_id='$usuario_id'") or die (mysql_error());
	
	header("Location: ../index.php?a=firsta");
?>