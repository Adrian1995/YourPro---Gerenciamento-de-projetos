<?php 
include('../../yconectaDB.inc');

$inovacao_projeto_id = $_POST["inovacao_projeto_id"];

$selecionarotinasremover = mysqli_query($conectaBanco ,"SELECT * FROM mod_inovacao WHERE inovacao_projeto_id = '$inovacao_projeto_id'");
	while($dados = mysqli_fetch_array($selecionarotinasremover))
		{
		$inovacao_rotina_id = $dados["inovacao_rotina_id"];
		
		$deletaRotinasInovacao = mysqli_query($conectaBanco ,"DELETE FROM rotinas WHERE rotina_id = '$inovacao_rotina_id'") or die (mysql_error());
		$deletaHistoricoInovacao = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tipo = 'cadastroderotina' AND historico_rotina = '$inovacao_rotina_id'") or die (mysql_error());
		}
	$deletaProjetoInovacao = mysqli_query($conectaBanco ,"DELETE FROM mod_inovacao WHERE inovacao_projeto_id = '$inovacao_projeto_id'") or die (mysql_error());
			
?>