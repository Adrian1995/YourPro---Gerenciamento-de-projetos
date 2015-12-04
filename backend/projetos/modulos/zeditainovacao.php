<?php 
include('../../yconectaDB.inc');

$inovacao_id = $_POST["inovacao_id"];
$inovacao_projeto_id = $_POST["inovacao_projeto_id"];
$inovacao_numero = $_POST["inovacao_numero"];
$inovacao_rotina_id = $_POST["inovacao_rotina_id"];
$inovacao_rotina_nome = $_POST["inovacao_rotina_nome"];
$inovacao_rotina_descricao = $_POST["inovacao_rotina_descricao"];

if($inovacao_id != "")
	{
	if($inovacao_rotina_nome != "")
		{
		$editainovacao = mysqli_query ($conectaBanco ,"UPDATE mod_inovacao SET inovacao_id='$inovacao_id', 
																				inovacao_projeto_id='$inovacao_projeto_id',
																				inovacao_numero='$inovacao_numero',
																				inovacao_rotina_nome='$inovacao_rotina_nome',
																				inovacao_rotina_descricao='$inovacao_rotina_descricao'
																	
																	WHERE inovacao_id='$inovacao_id'") or die (mysql_error());
		
		$rotina_datacriacao = date('Y-m-d H:i:s'); 
		$editarotina = mysqli_query ($conectaBanco ,"UPDATE rotinas SET rotina_nome='$inovacao_rotina_nome',
																		rotina_descricao='$inovacao_rotina_descricao',
																		rotina_datacriacao='$rotina_datacriacao'
															
															WHERE rotina_id='$inovacao_rotina_id'") or die (mysql_error());
		}
	}							
else if($inovacao_id == "")
	{
	if($inovacao_rotina_nome != "")
		{
		$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(inovacao_id) FROM mod_inovacao");		
		$dados = mysqli_fetch_array($consultaUltimoID);
		$ultimoID = $dados["0"];
		$inovacao_id = $ultimoID+1;
		
		$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(rotina_id) FROM rotinas");		
		$dados = mysqli_fetch_array($consultaUltimoID);
		$ultimoID = $dados["0"];
		$inovacao_rotina_id = $ultimoID+1;		
		
		$cadinovacao = mysqli_query ($conectaBanco ,"INSERT INTO mod_inovacao (inovacao_id,
																inovacao_projeto_id, 
																inovacao_numero,
																inovacao_rotina_id,
																inovacao_rotina_nome, 
																inovacao_rotina_descricao)				
																
														VALUES ('$inovacao_id',
																'$inovacao_projeto_id', 
																'$inovacao_numero',
																'$inovacao_rotina_id',
																'$inovacao_rotina_nome',
																'$inovacao_rotina_descricao')") or die (mysql_error());
						
						
		$rotina_datacriacao = date('Y-m-d H:i:s'); 
		$cadRotina = mysqli_query ($conectaBanco ,"INSERT INTO rotinas (rotina_id, 
																rotina_nome, 
																rotina_descricao,
																rotina_datacriacao)					
															VALUES ('$inovacao_rotina_id', 
																	'$inovacao_rotina_nome',
																	'$inovacao_rotina_descricao',
																	'$rotina_datacriacao')") or die (mysql_error());
		}
	}
	
if($inovacao_rotina_nome == "" AND $inovacao_rotina_descricao == "")
	{
	$selecionarotinasremover = mysqli_query($conectaBanco ,"SELECT * FROM mod_inovacao WHERE inovacao_projeto_id = '$inovacao_projeto_id' AND inovacao_numero = '$inovacao_numero'");
	while($dados = mysqli_fetch_array($selecionarotinasremover))
		{
		$inovacao_rotina_id = $dados["inovacao_rotina_id"];
		
		$deletaRotinasInovacao = mysqli_query($conectaBanco ,"DELETE FROM rotinas WHERE rotina_id = '$inovacao_rotina_id'") or die (mysql_error());
		$deletaHistoricoInovacao = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tipo = 'cadastroderotina' AND historico_rotina = '$inovacao_rotina_id'") or die (mysql_error());
		}
	
	$deletaProjetoinovacao = mysqli_query($conectaBanco ,"DELETE FROM mod_inovacao WHERE inovacao_projeto_id = '$inovacao_projeto_id' AND inovacao_numero = '$inovacao_numero'") or die (mysql_error());
	}
					
?>