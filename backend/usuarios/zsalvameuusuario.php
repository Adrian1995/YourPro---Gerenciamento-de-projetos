<?php
include('../yconectaDB.inc');

$sessao = $_POST["sessao"];
$usuario_id = $_POST["usuario_id"];
$usuario_nomecompleto = $_POST["usuario_nomecompleto"];
$usuario_telefone = $_POST["usuario_telefone"];
$usuario_cargo = $_POST["usuario_cargo"];
$statusfoto = $_POST["statusfoto"];

$foto = $_FILES["foto"];


if($statusfoto == "N")
	{
	$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id'");
	$dados = mysqli_fetch_array($consultaUsuarios);
	$nome_imagem = $dados["usuario_foto"];
	}
else if($statusfoto == "R")
	{
	$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id'");
	$dados = mysqli_fetch_array($consultaUsuarios);
	$nome_imagem = $dados["usuario_foto"];
	
	unlink("imgusuarios/".$nome_imagem);
	$nome_imagem = "";
	}
else if($statusfoto == "A")
	{ 
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
	$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
	$caminho_imagem = "imgusuarios/" . $nome_imagem;
	move_uploaded_file($foto["tmp_name"], $caminho_imagem);
	}
	
$editausuario = mysqli_query($conectaBanco ,"UPDATE login SET usuario_nomecompleto='$usuario_nomecompleto',
																usuario_telefone='$usuario_telefone',
																usuario_cargo='$usuario_cargo',
																usuario_foto='$nome_imagem'
															WHERE usuario_id = '$usuario_id' ") or die (mysql_error());
	
	
header("Location: ../../meuusuario.php?ID=$usuario_id&Sessao=$sessao&a=OK");		
?>