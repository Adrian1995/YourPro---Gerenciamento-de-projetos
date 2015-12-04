<?php 
include('../yconectaDB.inc');

$solicitacao_id = $_POST["solicitacao_id"];
$solicitacao_nome = $_POST["solicitacao_nome"];
$solicitacao_data =  date('Y-m-d H:i:s'); 
$solicitacao_status = "Solicitação editada por solicitante";
$solicitacao_observacao = $_POST["solicitacao_observacao"];

	$editaUsuario = mysqli_query ($conectaBanco ,"UPDATE solicitacoes SET solicitacao_nome='$solicitacao_nome', 
																			solicitacao_data='$solicitacao_data',
																			solicitacao_status='$solicitacao_status',
																			solicitacao_observacao='$solicitacao_observacao'
																			
																WHERE solicitacao_id='$solicitacao_id'") or die (mysql_error());
										
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
																VALUES ('$historico_id', '$usuario_id_atual', 'alteracaodesolicitacao', '$historico_data', '$solicitacao_id', 'O usuário $usuario_nome alterou a solicitação :: $solicitacao_id - $solicitacao_nome')");

//---------------------------------------------------------------------------------------------------------------------------------------------											
	
				
	echo "OK";
?>