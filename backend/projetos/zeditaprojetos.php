<?php 
include('../yconectaDB.inc');

$projeto_id = $_POST["projeto_id"];

$consultaHistorico = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_id = '$projeto_id'");		
$dados = mysqli_fetch_array($consultaHistorico);
$projeto_inicio_antigo = $dados["projeto_inicio"];
$projeto_final_antigo = $dados["projeto_final"];


$projeto_nome = $_POST["projeto_nome"];
$projeto_descricao = $_POST["projeto_descricao"];
$projeto_tipo = $_POST["projeto_tipo"];
$projeto_status = $_POST["projeto_status"];
$projeto_inicio = $_POST["projeto_inicio"];
$projeto_final = $_POST["projeto_final"];
$projeto_solicitacao_id = $_POST["projeto_solicitacao_id"];

	$editaUsuario = mysqli_query ($conectaBanco ,"UPDATE projetos SET 	projeto_nome='$projeto_nome', 
																		projeto_descricao='$projeto_descricao',
																		projeto_tipo='$projeto_tipo',
																		projeto_status='$projeto_status',
																		projeto_inicio='$projeto_inicio',
																		projeto_final='$projeto_final',
																		projeto_solicitacao_id='$projeto_solicitacao_id'
															
															WHERE projeto_id='$projeto_id'") or die (mysql_error());
										
										
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
												VALUES ('$historico_id', '$usuario_id_atual', 'alteracaodeprojeto', '$historico_data', '$projeto_id', 'O usuário $usuario_nome editou o projeto :: $projeto_id - $projeto_nome')");
//---------------------------------------------------------------------------------------------------------------------------------------------											

//==========================================================================================================================Cadastra histórico												
	
	
	
if($projeto_inicio == "")
	{
	$deletaProjetoEspecifico = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_projeto = '$projeto_id' and historico_tipo='iniciodeprojeto'") or die (mysql_error());
	}
else if($projeto_inicio != $projeto_inicio_antigo)
	{
	$deletaProjetoEspecifico = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_projeto = '$projeto_id' and historico_tipo='iniciodeprojeto'") or die (mysql_error());
	
	$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
	$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
	$ultimoID = $dadoshistorico["0"];
	$historico_id = $ultimoID+1;

	$historico_data = $projeto_inicio;
	$historico_data_formatada = $projeto_inicio;
	
		$historico_data_formatada = date_create("$historico_data_formatada");
		$historico_data_formatada = (date_format($historico_data_formatada, "d/m/Y H:i"));

	$cadHistoricoProjetoInicio = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_projeto, historico_texto) 
																VALUES ('$historico_id', '$usuario_id_atual', 'iniciodeprojeto', '$historico_data', '$projeto_id', 'O projeto :: $projeto_id - $projeto_nome , irá iniciar em $historico_data_formatada')");											
	}

	
	
	
	
if($projeto_final == "")
	{
	$deletaProjetoEspecifico = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_projeto = '$projeto_id' and historico_tipo='finaldeprojeto'") or die (mysql_error());
	}
else if($projeto_final != $projeto_final_antigo)
	{
	$deletaProjetoEspecifico = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_projeto = '$projeto_id' and historico_tipo='finaldeprojeto'") or die (mysql_error());
	
	$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
	$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
	$ultimoID = $dadoshistorico["0"];
	$historico_id = $ultimoID+1;

	$historico_data = $projeto_final;
	$historico_data_formatada = $projeto_final;
	
		$historico_data_formatada = date_create("$historico_data_formatada");
		$historico_data_formatada = (date_format($historico_data_formatada, "d/m/Y H:i"));

	$cadHistoricoProjetoFinal = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_projeto, historico_texto) 
																VALUES ('$historico_id', '$usuario_id_atual', 'finaldeprojeto', '$historico_data', '$projeto_id', 'O projeto :: $projeto_id - $projeto_nome , irá finalizar em $historico_data_formatada')");											
	}


//---------------------------------------------------------------------------------------------------------------------------------------------		
		
	echo "OK";
?>