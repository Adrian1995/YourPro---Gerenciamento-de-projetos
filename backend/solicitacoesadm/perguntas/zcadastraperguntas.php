<?php 
include('../../yconectaDB.inc');

$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(solicitacaoresposta_id) FROM solicitacoesrespostas");		
$dados = mysqli_fetch_array($consultaUltimoID);
$ultimoID = $dados["0"];

$solicitacaoresposta_id = $ultimoID+1;
$solicitacao_id = $_POST["solicitacao_id"];
$solicitacao_numero = $_POST["solicitacao_numero"];
$solicitacao_pergunta = $_POST["solicitacao_pergunta"];
$solicitacao_resposta = $_POST["solicitacao_resposta"];

$cadSolicitacao = mysqli_query ($conectaBanco ,"INSERT INTO solicitacoesrespostas (solicitacaoresposta_id,
																					solicitacao_id,
																					solicitacao_numero,
																					solicitacao_pergunta, 
																					solicitacao_resposta)					
																		VALUES ('$solicitacaoresposta_id',
																				'$solicitacao_id', 
																				'$solicitacao_numero',
																				'$solicitacao_pergunta',
																				'$solicitacao_resposta')") or die (mysql_error());
?>