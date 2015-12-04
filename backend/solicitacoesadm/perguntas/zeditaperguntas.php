<?php 
include('../../yconectaDB.inc');

$solicitacaoresposta_id = $_POST["solicitacaoresposta_id"];
$solicitacao_id = $_POST["solicitacao_id"];
$solicitacao_numero = $_POST["solicitacao_numero"]; 
$solicitacao_pergunta = $_POST["solicitacao_pergunta"];
$solicitacao_resposta = $_POST["solicitacao_resposta"];

if($solicitacaoresposta_id != "")
	{
	$editaPergunta = mysqli_query ($conectaBanco ,"UPDATE solicitacoesrespostas SET solicitacao_id='$solicitacao_id', 
																					solicitacao_numero='$solicitacao_numero',
																					solicitacao_pergunta='$solicitacao_pergunta',
																					solicitacao_resposta='$solicitacao_resposta'
																	
																				WHERE solicitacaoresposta_id='$solicitacaoresposta_id'") or die (mysql_error());
	}
else if($solicitacaoresposta_id == "")
	{
	$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(solicitacaoresposta_id) FROM solicitacoesrespostas");		
	$dados = mysqli_fetch_array($consultaUltimoID);
	$ultimoID = $dados["0"];
	$solicitacaoresposta_id = $ultimoID+1;
	
	$cadPergunta = mysqli_query ($conectaBanco ,"INSERT INTO solicitacoesrespostas 
															(solicitacaoresposta_id,
															solicitacao_id, 
															solicitacao_numero,
															solicitacao_pergunta, 
															solicitacao_resposta)				
															
													VALUES ('$solicitacaoresposta_id',
															'$solicitacao_id', 
															'$solicitacao_numero',
															'$solicitacao_pergunta',
															'$solicitacao_resposta')") or die (mysql_error());
	}
	
if($solicitacao_pergunta == "" AND $solicitacao_resposta == "")
	{
	$deletaPergunta = mysqli_query($conectaBanco ,"DELETE FROM solicitacoesrespostas WHERE solicitacao_id = '$solicitacao_id' AND solicitacao_numero = '$solicitacao_numero'") or die (mysql_error());
	}
				
	
	
	
?>