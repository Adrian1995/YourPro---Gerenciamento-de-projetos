<?php 
include('../../yconectaDB.inc');

$alteracao_id = $_POST["alteracao_id"];
$alteracao_projeto_id = $_POST["alteracao_projeto_id"];
$alteracao_numero = $_POST["alteracao_numero"];
$alteracao_rotina_id = $_POST["alteracao_rotina_id"];
$alteracao_nome = $_POST["alteracao_nome"];
$alteracao_objetivo = $_POST["alteracao_objetivo"];
$alteracao_antes = $_POST["alteracao_antes"];
$alteracao_depois = $_POST["alteracao_depois"];

if($alteracao_id != "")
	{
	if($alteracao_nome != "")
		{
		$editaalteracao = mysqli_query ($conectaBanco ,"UPDATE mod_alteracao SET alteracao_projeto_id='$alteracao_projeto_id',
																				alteracao_numero='$alteracao_numero',
																				alteracao_rotina_id='$alteracao_rotina_id',
																				alteracao_nome='$alteracao_nome',
																				alteracao_objetivo='$alteracao_objetivo',
																				alteracao_antes='$alteracao_antes',
																				alteracao_depois='$alteracao_depois'
											
														WHERE alteracao_id='$alteracao_id'") or die (mysql_error());
		
		$editarotina = mysqli_query ($conectaBanco ,"UPDATE rotinas SET rotina_descricao='$alteracao_depois'
													WHERE rotina_id='$alteracao_rotina_id'") or die (mysql_error());
		}
	}							
else if($alteracao_id == "")
	{
	if($alteracao_nome != "")
		{
		$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(alteracao_id) FROM mod_alteracao");		
		$dados = mysqli_fetch_array($consultaUltimoID);
		$ultimoID = $dados["0"];
		$alteracao_id = $ultimoID+1;
		
		$cadalteracao = mysqli_query ($conectaBanco ,"INSERT INTO mod_alteracao (alteracao_id,
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
						
		$editarotina = mysqli_query ($conectaBanco ,"UPDATE rotinas SET rotina_descricao='$alteracao_depois'
													WHERE rotina_id='$alteracao_rotina_id'") or die (mysql_error());
		}
	}
	
if($alteracao_rotina_id == "" AND $alteracao_nome == "")
	{
	$consultaalteracao = mysqli_query($conectaBanco ,"SELECT * FROM mod_alteracao WHERE alteracao_projeto_id = '$alteracao_projeto_id' AND alteracao_numero = '$alteracao_numero'");		
	$dados = mysqli_fetch_array($consultaalteracao);
	$alteracao_rotina_id = $dados["alteracao_rotina_id"];
	$alteracao_antes = $dados["alteracao_antes"];
		
	$editarotina = mysqli_query ($conectaBanco ,"UPDATE rotinas SET rotina_descricao='$alteracao_antes'
												WHERE rotina_id='$alteracao_rotina_id'") or die (mysql_error());
	
	$deletaProjetoalteracao = mysqli_query($conectaBanco ,"DELETE FROM mod_alteracao WHERE alteracao_projeto_id = '$alteracao_projeto_id' AND alteracao_numero = '$alteracao_numero'") or die (mysql_error());
	}
					
?>