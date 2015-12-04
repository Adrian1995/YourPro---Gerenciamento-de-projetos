<?php 
include('../../yconectaDB.inc');

$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(correcao_id) FROM mod_correcao");		
$dados = mysqli_fetch_array($consultaUltimoID);
$ultimoID = $dados["0"];

$correcao_id = $ultimoID+1;
$correcao_projeto_id = $_POST["correcao_projeto_id"];
$correcao_numero = $_POST["correcao_numero"];
$correcao_rotina_id = $_POST["correcao_rotina_id"];
$correcao_nome = $_POST["correcao_nome"];
$correcao_descricao = $_POST["correcao_descricao"];

$cadcorrecao = mysqli_query ($conectaBanco ,"INSERT INTO mod_correcao (correcao_id,
																		correcao_projeto_id, 
																		correcao_numero,
																		correcao_rotina_id, 
																		correcao_nome,
																		correcao_descricao)				
																		
																VALUES ('$correcao_id',
																		'$correcao_projeto_id', 
																		'$correcao_numero',
																		'$correcao_rotina_id',
																		'$correcao_nome',
																		'$correcao_descricao')") or die (mysql_error());											
?>