<?php 
include('../../yconectaDB.inc');

$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(alteracao_id) FROM mod_alteracao");		
$dados = mysqli_fetch_array($consultaUltimoID);
$ultimoID = $dados["0"];

$alteracao_id = $ultimoID+1;
$alteracao_projeto_id = $_POST["alteracao_projeto_id"];
$alteracao_numero = $_POST["alteracao_numero"];
$alteracao_rotina_id = $_POST["alteracao_rotina_id"];
$alteracao_nome = $_POST["alteracao_nome"];
$alteracao_objetivo = $_POST["alteracao_objetivo"];
$alteracao_antes = $_POST["alteracao_antes"];
$alteracao_depois = $_POST["alteracao_depois"];


$cadinovacao = mysqli_query ($conectaBanco ,"INSERT INTO mod_alteracao (alteracao_id,
														alteracao_projeto_id, 
														alteracao_numero,
														alteracao_rotina_id, 
														alteracao_nome,
														alteracao_objetivo,
														alteracao_antes,
														alteracao_depois)				
												
												VALUES ('$alteracao_id',
														'$alteracao_projeto_id', 
														'$alteracao_numero',
														'$alteracao_rotina_id',
														'$alteracao_nome',
														'$alteracao_objetivo',
														'$alteracao_antes',
														'$alteracao_depois')") or die (mysql_error());
												
$altrotina = mysqli_query ($conectaBanco ,"UPDATE rotinas SET rotina_descricao='$alteracao_depois' 
														WHERE rotina_id='$alteracao_rotina_id'") or die (mysql_error());
																							
?>