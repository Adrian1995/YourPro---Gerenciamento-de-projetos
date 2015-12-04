<?php 
include('../yconectaDB.inc');

$projeto_id = $_POST["projeto_id"];
$consultaNomeProjeto = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_id='$projeto_id'");		
$dadoshistorico = mysqli_fetch_array($consultaNomeProjeto);
$projeto_nome = $dadoshistorico["projeto_nome"];

	$deletaProjetoEspecifico = mysqli_query($conectaBanco ,"DELETE FROM projetos WHERE projeto_id = '$projeto_id'") or die (mysql_error());
	
	
	
	
	$selecionahistoricotarefasremover = mysqli_query($conectaBanco ,"SELECT * FROM mod_tarefas WHERE tarefa_projeto_id = '$projeto_id'");
	while($dados = mysqli_fetch_array($selecionahistoricotarefasremover))
		{
		$tarefa_id = $dados["tarefa_id"];
		
		$deletaHistoricoTarefas = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tipo in ('iniciodetarefa', 'finaldetarefa') AND historico_tarefa = '$tarefa_id'") or die (mysql_error());
		}	
	$deletaProjetoTarefas = mysqli_query($conectaBanco ,"DELETE FROM mod_tarefas WHERE tarefa_projeto_id = '$projeto_id'") or die (mysql_error());
	
	
	$selecionarotinasremover = mysqli_query($conectaBanco ,"SELECT * FROM mod_inovacao WHERE inovacao_projeto_id = '$projeto_id'");
	while($dados = mysqli_fetch_array($selecionarotinasremover))
		{
		$inovacao_rotina_id = $dados["inovacao_rotina_id"];
		
		$deletaRotinasInovacao = mysqli_query($conectaBanco ,"DELETE FROM rotinas WHERE rotina_id = '$inovacao_rotina_id'") or die (mysql_error());
		$deletaHistoricoInovacao = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tipo = 'cadastroderotina' AND historico_rotina = '$inovacao_rotina_id'") or die (mysql_error());
		}
	$deletaProjetoInovacao = mysqli_query($conectaBanco ,"DELETE FROM mod_inovacao WHERE inovacao_projeto_id = '$projeto_id'") or die (mysql_error());
	

	$selecionarotinaseditar = mysqli_query($conectaBanco ,"SELECT * FROM mod_alteracao WHERE alteracao_projeto_id = '$projeto_id'") or die(mysql_error());
	$numerorotinaseditar = mysqli_num_rows($selecionarotinaseditar);
	
	if($numerorotinaseditar > 0)
		{
		$selecionaprimeiroregistroalteracao = mysqli_query($conectaBanco ,"SELECT MIN(alteracao_id) as alteracao_id, alteracao_rotina_id, alteracao_antes FROM mod_alteracao WHERE alteracao_projeto_id = '$projeto_id'") or die(mysql_error());
		
		$dados = mysqli_fetch_array($selecionaprimeiroregistroalteracao);
		$alteracao_rotina_id = $dados["alteracao_rotina_id"];
		$alteracao_antes = $dados["alteracao_antes"];
		
		$retornadescricaoantigapararotina = mysqli_query($conectaBanco ,"UPDATE rotinas SET rotina_descricao = '$alteracao_antes' WHERE rotina_id = '$alteracao_rotina_id' ") or die(mysql_error());
		}
	
	
	$deletaProjetoAlteracao = mysqli_query($conectaBanco ,"DELETE FROM mod_alteracao WHERE alteracao_projeto_id = '$projeto_id'") or die (mysql_error());
	
	$deletaProjetoCorrecao = mysqli_query($conectaBanco ,"DELETE FROM mod_correcao WHERE correcao_projeto_id = '$projeto_id'") or die (mysql_error());
	
	$deletaProjetoForum = mysqli_query($conectaBanco ,"DELETE FROM mod_forum WHERE forum_projeto_id = '$projeto_id'") or die (mysql_error());
	
	
	$selecionaerrosremover = mysqli_query($conectaBanco ,"SELECT * FROM mod_erros WHERE erro_projeto_id = '$projeto_id'");
	while($dados = mysqli_fetch_array($selecionaerrosremover))
		{
		$erro_imagem1 = $dados["erro_imagem1"];
		$erro_imagem2 = $dados["erro_imagem2"];
		$erro_imagem3 = $dados["erro_imagem3"];
		$erro_imagem4 = $dados["erro_imagem4"];
		$erro_imagem5 = $dados["erro_imagem5"];
		
		if (!empty($erro_imagem1))
			{
			unlink("relatarerro/fotos/".$erro_imagem1);
			}
			
		if (!empty($erro_imagem2))
			{
			unlink("relatarerro/fotos/".$erro_imagem2);
			}
			
		if (!empty($erro_imagem3))
			{
			unlink("relatarerro/fotos/".$erro_imagem3);
			}
			
		if (!empty($erro_imagem4))
			{
			unlink("relatarerro/fotos/".$erro_imagem4);
			}
			
		if (!empty($erro_imagem5))
			{
			unlink("relatarerro/fotos/".$erro_imagem5);
			}
		}
	$deletaErros = mysqli_query($conectaBanco ,"DELETE FROM mod_erros WHERE erro_projeto_id = '$projeto_id'") or die (mysql_error());
	
	
	
//==========================================================================================================================Cadastra histórico
$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
$ultimoID = $dadoshistorico["0"];
$historico_id = $ultimoID+1;												

$usuario_id_atual = $_POST["usuario_id_atual"];
$consultaNomeUsuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$usuario_id_atual'");		
$dadoshistorico = mysqli_fetch_array($consultaNomeUsuario);
$usuario_nome = $dadoshistorico["usuario_nome"];

$historico_data = date('Y-m-d H:i:s'); 
												
$cadHistorico = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_projeto, historico_texto) 
												VALUES ('$historico_id', '$usuario_id_atual', 'exclusaodeprojeto', '$historico_data', '0', 'O usuário $usuario_nome excluiu o projeto :: $projeto_id - $projeto_nome')");
//---------------------------------------------------------------------------------------------------------------------------------------------											
					
//==========================================================================================================================Remove histórico inicio e final
	
$deletaProjetoEspecifico = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_projeto = '$projeto_id' and historico_tipo in('cadastrodeprojeto', 'alteracaodeprojeto', 'iniciodeprojeto', 'finaldeprojeto') ") or die (mysql_error());
//---------------------------------------------------------------------------------------------------------------------------------------------		
	echo "OK";
?>