<?php 
include('../yconectaDB.inc');

//=======================================================Configurações gerais
$itens_eventos = $_POST["itens_eventos"];
$itens_projetos = $_POST["itens_projetos"];
$itens_usuarios = $_POST["itens_usuarios"];
$itens_solicitacoesadm = $_POST["itens_solicitacoesadm"];
$itens_solicitacoes = $_POST["itens_solicitacoes"];
$itens_rotinas = $_POST["itens_rotinas"];

if(isset($_POST['exige_solicitacaonoprojeto']))
	{ $exige_solicitacaonoprojeto = "S";}
else
	{$exige_solicitacaonoprojeto = "N";}

$editaUsuario = mysqli_query ($conectaBanco ,"UPDATE configuracoes SET 	itens_eventos='$itens_eventos',
														itens_projetos='$itens_projetos', 
														itens_usuarios='$itens_usuarios',
														itens_solicitacoesadm='$itens_solicitacoesadm',
														itens_solicitacoes='$itens_solicitacoes',
														itens_rotinas='$itens_rotinas',
														exige_solicitacaonoprojeto='$exige_solicitacaonoprojeto' ") or die (mysql_error());


//=======================================================Status dos projetos
$deletaStatus = mysqli_query($conectaBanco ,"DELETE FROM configuracoes_status_projetos") or die (mysql_error());
$numero_status = $_POST["numero_status"];
for ($i = 1; $i <= $numero_status; $i++) 
	{
	if(!empty($_POST["status_nome".$i]))
		{
		$status_nome = $_POST["status_nome".$i];
		
		$cadStatus = mysqli_query ($conectaBanco ,"INSERT INTO configuracoes_status_projetos (status_id, status_nome)				
													VALUES ('$i',
															'$status_nome')") or die (mysql_error());
		}
	}
	
	
//=======================================================Tipos dos projetos
$deletaTipos = mysqli_query($conectaBanco ,"DELETE FROM configuracoes_tipos") or die (mysql_error());
$numero_tipos = $_POST["numero_tipos"];
for ($i = 1; $i <= $numero_tipos; $i++) 
	{
	if(!empty($_POST["tipos_nome".$i]))
		{
		$tipos_nome = $_POST["tipos_nome".$i];
		
		$cadTipos = mysqli_query ($conectaBanco ,"INSERT INTO configuracoes_tipos (tipo_id, tipo_nome)				
													VALUES ('$i',
															'$tipos_nome')") or die (mysql_error());
		}
	}
	


//=======================================================Perguntas
$deletaPerguntas = mysqli_query($conectaBanco ,"DELETE FROM configuracoes_perguntas") or die (mysql_error());
$numero_perguntas = $_POST["numero_perguntas"];
for ($i = 1; $i <= $numero_perguntas; $i++) 
	{
	if(!empty($_POST["perguntas".$i]))
		{
		$perguntas = $_POST["perguntas".$i];
		
		$cadPerguntas = mysqli_query ($conectaBanco ,"INSERT INTO configuracoes_perguntas (pergunta_id, pergunta_texto)				
														VALUES ('$i',
																'$perguntas')") or die (mysql_error());
		}
	}	


	
//=======================================================Status das solicitações
$deletaStatusSolicitacoes = mysqli_query($conectaBanco ,"DELETE FROM configuracoes_status_solicitacoes") or die (mysql_error());
$numero_status_solicitacoes = $_POST["numero_status_solicitacoes"];
for ($i = 1; $i <= $numero_status_solicitacoes; $i++) 
	{
	if(!empty($_POST["status_solicitacoes".$i]))
		{
		$status_solicitacoes = $_POST["status_solicitacoes".$i];
		
		$cadStatusSolicitacoes = mysqli_query ($conectaBanco ,"INSERT INTO configuracoes_status_solicitacoes (status_id, status_nome)				
																VALUES ('$i',
																		'$status_solicitacoes')") or die (mysql_error());
		}
	}
	
	

//==========================================================================================================================Cadastra histórico
$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
$ultimoID = $dadoshistorico["0"];
$historico_id = $ultimoID+1;												

$usuario_id_atual = $_POST["usuario_id"];
$consultaNomeUsuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$usuario_id_atual'");		
$dadoshistorico = mysqli_fetch_array($consultaNomeUsuario);
$usuario_nome = $dadoshistorico["usuario_nome"];

$historico_data = date('Y-m-d H:i:s'); 
												
$cadHistoricoProjetoCadastrado = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_texto) 
																VALUES ('$historico_id', '$usuario_id_atual', 'alteracaoconfiguracoes', '$historico_data', 'As configurações foram alteradas pelo usuário :: $usuario_id_atual - $usuario_nome')");

//---------------------------------------------------------------------------------------------------------------------------------------------											
	
	
	
	
	
$sessao = $_POST["sessao"];
$usuario_id = $_POST["usuario_id"];

header("Location: ../../configuracoes.php?ID=$usuario_id&Sessao=$sessao&a=OK");	
?>