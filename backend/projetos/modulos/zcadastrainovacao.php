<?php 
include('../../yconectaDB.inc');

$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(inovacao_id) FROM mod_inovacao");		
$dados = mysqli_fetch_array($consultaUltimoID);
$ultimoID = $dados["0"];

$inovacao_id = $ultimoID+1;
$inovacao_projeto_id = $_POST["inovacao_projeto_id"];
$inovacao_numero = $_POST["inovacao_numero"];

$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(rotina_id) FROM rotinas");		
$dados = mysqli_fetch_array($consultaUltimoID);
$ultimoID = $dados["0"];
$inovacao_rotina_id = $ultimoID+1;

$inovacao_rotina_nome = $_POST["inovacao_rotina_nome"];
$inovacao_rotina_descricao = $_POST["inovacao_rotina_descricao"];

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
													
	$cadHistoricoProjetoCadastrado = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_rotina, historico_texto) 
																	VALUES ('$historico_id', '$usuario_id_atual', 'cadastroderotina', '$historico_data', '$inovacao_rotina_id', 'O usuário $usuario_nome cadastrou uma inovação que deu origem a rotina :: $inovacao_rotina_id - $inovacao_rotina_nome')");

	//---------------------------------------------------------------------------------------------------------------------------------------------	
													
?>