<?php
include('../../yconectaDB.inc');

$sessao = $_POST["sessao"];
$usuario_id = $_POST["usuario_id"];

$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(erro_id) FROM mod_erros");
$dados = mysqli_fetch_array($consultaUltimoID);
$ultimoID = $dados["0"];
$erro_id = $ultimoID+1;
$erro_projeto_id = $_POST["erro_projeto_id"];
$erro_usuario_id = $_POST["erro_usuario_id"];
$erro_status = "Cadastrado";
$erro_nome = $_POST["erro_nome"];
$erro_descricao = $_POST["erro_descricao"];

$foto = $_FILES["foto1"]; 
	if (!empty($foto["name"])) 
	{ 
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
	$erro_imagem1 = md5(uniqid(time())) . "." . $ext[1];
	$caminho_imagem = "fotos/" . $erro_imagem1;
	move_uploaded_file($foto["tmp_name"], $caminho_imagem);
	}
	
$foto = $_FILES["foto2"]; 
	if (!empty($foto["name"])) 
	{ 
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
	$erro_imagem2 = md5(uniqid(time())) . "." . $ext[1];
	$caminho_imagem = "fotos/" . $erro_imagem2;
	move_uploaded_file($foto["tmp_name"], $caminho_imagem);
	}
	
$foto = $_FILES["foto3"]; 
	if (!empty($foto["name"])) 
	{ 
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
	$erro_imagem3 = md5(uniqid(time())) . "." . $ext[1];
	$caminho_imagem = "fotos/" . $erro_imagem3;
	move_uploaded_file($foto["tmp_name"], $caminho_imagem);
	}
	
$foto = $_FILES["foto4"]; 
	if (!empty($foto["name"])) 
	{ 
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
	$erro_imagem4 = md5(uniqid(time())) . "." . $ext[1];
	$caminho_imagem = "fotos/" . $erro_imagem4;
	move_uploaded_file($foto["tmp_name"], $caminho_imagem);
	}
	
$foto = $_FILES["foto5"]; 
	if (!empty($foto["name"])) 
	{ 
	preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
	$erro_imagem5 = md5(uniqid(time())) . "." . $ext[1];
	$caminho_imagem = "fotos/" . $erro_imagem5;
	move_uploaded_file($foto["tmp_name"], $caminho_imagem);
	}
	
$cadPortfolio = mysqli_query ($conectaBanco ,"INSERT INTO mod_erros (erro_id, 
																	erro_projeto_id, 
																	erro_usuario_id, 
																	erro_status, 
																	erro_nome, 
																	erro_descricao,
																	erro_imagem1,
																	erro_imagem2,
																	erro_imagem3,
																	erro_imagem4,
																	erro_imagem5)
																	
															VALUES ('$erro_id', 
																	'$erro_projeto_id', 
																	'$erro_usuario_id', 
																	'$erro_status', 
																	'$erro_nome', 
																	'$erro_descricao',
																	'$erro_imagem1',
																	'$erro_imagem2',
																	'$erro_imagem3',
																	'$erro_imagem4',
																	'$erro_imagem5')") or die (mysql_error());
				
														
header("Location: ../../../relatarerro.php?ID=$usuario_id&Sessao=$sessao&a=OK");		
?>