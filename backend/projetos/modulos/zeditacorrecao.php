<?php 
include('../../yconectaDB.inc');

$correcao_id = $_POST["correcao_id"];
$correcao_projeto_id = $_POST["correcao_projeto_id"];
$correcao_numero = $_POST["correcao_numero"];
$correcao_rotina_id = $_POST["correcao_rotina_id"];
$correcao_nome = $_POST["correcao_nome"];
$correcao_descricao = $_POST["correcao_descricao"];

if($correcao_id != "")
	{
	if($correcao_nome != "")
		{
		$editacorrecao = mysqli_query ($conectaBanco ,"UPDATE mod_correcao SET correcao_projeto_id='$correcao_projeto_id',
																				correcao_numero='$correcao_numero',
																				correcao_rotina_id='$correcao_rotina_id',
																				correcao_nome='$correcao_nome',
																				correcao_descricao='$correcao_descricao'
																	
																	WHERE correcao_id='$correcao_id'") or die (mysql_error());
		}
	}							
else if($correcao_id == "")
	{
	if($correcao_nome != "")
		{
		$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(inovacao_id) FROM mod_inovacao");		
		$dados = mysqli_fetch_array($consultaUltimoID);
		$ultimoID = $dados["0"];
		$inovacao_id = $ultimoID+1;
		
		$cadalteracao = mysqli_query ($conectaBanco ,"INSERT INTO mod_correcao (correcao_id,
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
		}
	}
	
if($correcao_nome == "" AND $correcao_descricao == "")
	{
	$deletaProjetocorrecao = mysqli_query($conectaBanco ,"DELETE FROM mod_correcao WHERE correcao_projeto_id = '$correcao_projeto_id' AND correcao_numero = '$correcao_numero'") or die (mysql_error());
	}
					
?>