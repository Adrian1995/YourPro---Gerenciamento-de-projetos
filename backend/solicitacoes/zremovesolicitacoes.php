<?php 
include('../yconectaDB.inc');

$solicitacao_id = $_POST["solicitacao_id"];
$consultaNomeSolicitacao = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_id='$solicitacao_id'");		
$dadoshistorico = mysqli_fetch_array($consultaNomeSolicitacao);
$solicitacao_nome = $dadoshistorico["solicitacao_nome"];

	$deletaSolicitacaoEspecifica = mysqli_query($conectaBanco ,"DELETE FROM solicitacoes WHERE solicitacao_id = '$solicitacao_id'") or die (mysql_error());
		
	$deletaPerguntas = mysqli_query($conectaBanco ,"DELETE FROM solicitacoesrespostas WHERE solicitacao_id = '$solicitacao_id'") or die (mysql_error());
	
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
												
$cadHistoricoProjetoCadastrado = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_solicitacao, historico_texto) 
																VALUES ('$historico_id', '$usuario_id_atual', 'remocaodesolicitacao', '$historico_data', '0', 'O usuário $usuario_nome removeu a solicitação :: $solicitacao_id - $solicitacao_nome')");

$deletaHistoricoSolicitacoes = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tipo in ('cadastrodesolicitacao', 'alteracaodesolicitacao') AND historico_solicitacao = '$solicitacao_id'") or die (mysql_error());
	
//---------------------------------------------------------------------------------------------------------------------------------------------											
	
	
	echo "OK";
?>