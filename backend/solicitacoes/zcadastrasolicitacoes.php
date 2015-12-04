<?php 
include('../yconectaDB.inc');

$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(solicitacao_id) FROM solicitacoes");		
$dados = mysqli_fetch_array($consultaUltimoID);
$ultimoID = $dados["0"];

$solicitacao_id = $ultimoID+1;
$solicitacao_nome = $_POST["solicitacao_nome"];
$solicitacao_usuario = $_POST["solicitacao_usuario"];
$solicitacao_data = date('Y-m-d H:i:s'); 
$solicitacao_status = "Nova";
$solicitacao_observacao = $_POST["solicitacao_observacao"];

$cadSolicitacao = mysqli_query ($conectaBanco ,"INSERT INTO solicitacoes (	solicitacao_id,
																			solicitacao_nome, 
																			solicitacao_usuario, 
																			solicitacao_data,
																			solicitacao_status,
																			solicitacao_observacao)					
																VALUES ('$solicitacao_id',
																		'$solicitacao_nome', 
																		'$solicitacao_usuario',
																		'$solicitacao_data',
																		'$solicitacao_status',
																		'$solicitacao_observacao')") or die (mysql_error());
												
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
																VALUES ('$historico_id', '$usuario_id_atual', 'cadastrodesolicitacao', '$historico_data', '$solicitacao_id', 'O usuário $usuario_nome cadastrou a solicitação :: $solicitacao_id - $solicitacao_nome')");

//---------------------------------------------------------------------------------------------------------------------------------------------											
	
												
$ResultadoCadastro = "OK";

$arr = array('ResultadoCadastro'=>$ResultadoCadastro, 'solicitacao_id'=>$solicitacao_id);
echo json_encode($arr);
?>