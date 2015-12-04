<?php 
include('../yconectaDB.inc');

$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(projeto_id) FROM projetos");		
$dados = mysqli_fetch_array($consultaUltimoID);
$ultimoID = $dados["0"];

$projeto_id = $ultimoID+1;
$projeto_nome = $_POST["projeto_nome"];
$projeto_descricao = $_POST["projeto_descricao"];
$projeto_tipo = $_POST["projeto_tipo"];
$projeto_status = $_POST["projeto_status"];
$projeto_inicio = $_POST["projeto_inicio"];
$projeto_final = $_POST["projeto_final"];
$projeto_solicitacao_id = $_POST["projeto_solicitacao_id"];

$cadCliente = mysqli_query ($conectaBanco ,"INSERT INTO projetos (	projeto_id,
																	projeto_nome, 
																	projeto_descricao, 
																	projeto_tipo,
																	projeto_status,
																	projeto_inicio,
																	projeto_final,
																	projeto_solicitacao_id)					
														VALUES ('$projeto_id',
																'$projeto_nome', 
																'$projeto_descricao',
																'$projeto_tipo',
																'$projeto_status',
																'$projeto_inicio',
																'$projeto_final',
																'$projeto_solicitacao_id')") or die (mysql_error());

												
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
												
$cadHistoricoProjetoCadastrado = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_projeto, historico_texto) 
																VALUES ('$historico_id', '$usuario_id_atual', 'cadastrodeprojeto', '$historico_data', '$projeto_id', 'O usuário $usuario_nome cadastrou o projeto :: $projeto_id - $projeto_nome')");

if($projeto_inicio != "")
	{
	$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
	$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
	$ultimoID = $dadoshistorico["0"];
	$historico_id = $ultimoID+1;

	$historico_data = $projeto_inicio;

	$cadHistoricoProjetoInicio = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_projeto, historico_texto) 
																VALUES ('$historico_id', '$usuario_id_atual', 'iniciodeprojeto', '$historico_data', '$projeto_id', 'O projeto :: $projeto_id - $projeto_nome , irá iniciar em $historico_data')");											
	}
	
if($projeto_final != "")
	{
	$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
	$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
	$ultimoID = $dadoshistorico["0"];
	$historico_id = $ultimoID+1;

	$historico_data = $projeto_final;

	$cadHistoricoProjetoFinal = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_projeto, historico_texto) 
																VALUES ('$historico_id', '$usuario_id_atual', 'finaldeprojeto', '$historico_data', '$projeto_id', 'O projeto :: $projeto_id - $projeto_nome , irá finalizar em $historico_data')");											
	}
	
	
//---------------------------------------------------------------------------------------------------------------------------------------------											
												
												
$ResultadoCadastro = "OK";

$arr = array('ResultadoCadastro'=>$ResultadoCadastro, 'projeto_id'=>$projeto_id);
echo json_encode($arr);
?>