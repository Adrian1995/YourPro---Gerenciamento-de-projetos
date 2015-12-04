<?php 
include('../../yconectaDB.inc');

$alteracao_projeto_id = $_POST["alteracao_projeto_id"];

	$selecionarotinaseditar = mysqli_query($conectaBanco ,"SELECT * FROM mod_alteracao WHERE alteracao_projeto_id = '$alteracao_projeto_id'") or die(mysql_error());
	$numerorotinaseditar = mysqli_num_rows($selecionarotinaseditar);
	
	if($numerorotinaseditar > 0)
		{
		$selecionaprimeiroregistroalteracao = mysqli_query($conectaBanco ,"SELECT MIN(alteracao_id) as alteracao_id, alteracao_rotina_id, alteracao_antes FROM mod_alteracao WHERE alteracao_projeto_id = '$alteracao_projeto_id'") or die(mysql_error());
		
		$dados = mysqli_fetch_array($selecionaprimeiroregistroalteracao);
		$alteracao_rotina_id = $dados["alteracao_rotina_id"];
		$alteracao_antes = $dados["alteracao_antes"];
		
		$retornadescricaoantigapararotina = mysqli_query($conectaBanco ,"UPDATE rotinas SET rotina_descricao = '$alteracao_antes' WHERE rotina_id = '$alteracao_rotina_id' ") or die(mysql_error());
		}

	$deletaProjetoAlteracao = mysqli_query($conectaBanco ,"DELETE FROM mod_alteracao WHERE alteracao_projeto_id = '$alteracao_projeto_id'") or die (mysql_error());
			
?>