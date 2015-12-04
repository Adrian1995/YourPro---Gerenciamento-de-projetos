<?php 
include('../../yconectaDB.inc');

$tarefa_id = $_POST["tarefa_id"];
$tarefa_projeto_id = $_POST["tarefa_projeto_id"];
$tarefa_numero = $_POST["tarefa_numero"];
$tarefa_usuario_id = $_POST["tarefa_usuario_id_banco"];
$tarefa_nome = $_POST["tarefa_nome_banco"];
$tarefa_descricao = $_POST["tarefa_descricao_banco"];
$tarefa_inicio = $_POST["tarefa_inicio_banco"];
$tarefa_final = $_POST["tarefa_final_banco"];

$consultaHistorico = mysqli_query($conectaBanco ,"SELECT * FROM mod_tarefas WHERE tarefa_projeto_id = '$tarefa_projeto_id'");		
$dados = mysqli_fetch_array($consultaHistorico);
$tarefa_inicio_antigo = $dados["tarefa_inicio"];
$tarefa_final_antigo = $dados["tarefa_final"];

if($tarefa_id != "")
	{
	if($tarefa_nome != "")
		{
		$editaUsuario = mysqli_query ($conectaBanco ,"UPDATE mod_tarefas SET tarefa_id='$tarefa_id', 
																			tarefa_projeto_id='$tarefa_projeto_id',
																			tarefa_numero='$tarefa_numero',
																			tarefa_usuario_id='$tarefa_usuario_id',
																			tarefa_nome='$tarefa_nome',
																			tarefa_descricao='$tarefa_descricao',
																			tarefa_inicio='$tarefa_inicio',
																			tarefa_final='$tarefa_final'
																
																WHERE tarefa_id='$tarefa_id'") or die (mysql_error());
						
		//==========================================================================================================================Cadastra histórico
		if($tarefa_inicio == "")
			{
			$deletaTarefaEspecifica = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tarefa = '$tarefa_id' and historico_tipo='iniciodetarefa'") or die (mysql_error());
			}
		else if($tarefa_inicio != $tarefa_inicio_antigo)
			{
			$deletaTarefaEspecifica = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tarefa = '$tarefa_id' and historico_tipo='iniciodetarefa'") or die (mysql_error());
			
			$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
			$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
			$ultimoID = $dadoshistorico["0"];
			$historico_id = $ultimoID+1;

			$historico_data = $tarefa_inicio;
			$historico_data_formatada = $tarefa_inicio;
			
				$historico_data_formatada = date_create("$historico_data_formatada");
				$historico_data_formatada = (date_format($historico_data_formatada, "d/m/Y H:i"));

			$cadHistoricoTarefaInicio = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_tarefa, historico_texto) 
																	VALUES ('$historico_id', '$tarefa_usuario_id', 'iniciodetarefa', '$historico_data', '$tarefa_id', 'A tarefa $tarefa_id - $tarefa_nome, deverá ser iniciada em $historico_data_formatada')");
			}
			
		if($tarefa_final == "")
			{
			$deletaTarefaEspecifica = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tarefa = '$tarefa_id' and historico_tipo='finaldetarefa'") or die (mysql_error());
			}
		else if($tarefa_final != $tarefa_final_antigo)
			{
			$deletaTarefaEspecifica = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tarefa = '$tarefa_id' and historico_tipo='finaldetarefa'") or die (mysql_error());
			
			$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
			$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
			$ultimoID = $dadoshistorico["0"];
			$historico_id = $ultimoID+1;

			$historico_data = $tarefa_final;
			$historico_data_formatada = $tarefa_final;
			
				$historico_data_formatada = date_create("$historico_data_formatada");
				$historico_data_formatada = (date_format($historico_data_formatada, "d/m/Y H:i"));

			$cadHistoricoTarefaInicio = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_tarefa, historico_texto) 
																	VALUES ('$historico_id', '$tarefa_usuario_id', 'finaldetarefa', '$historico_data', '$tarefa_id', 'A tarefa $tarefa_id - $tarefa_nome, deverá ser finalizada em $historico_data_formatada')");
			}
		//---------------------------------------------------------------------------------------------------------------------------------------------	
		}
	}							
else if($tarefa_id == "")
	{
	if($tarefa_nome != "")
		{
		$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(tarefa_id) FROM mod_tarefas");		
		$dados = mysqli_fetch_array($consultaUltimoID);
		$ultimoID = $dados["0"];
		$tarefa_id = $ultimoID+1;
		
		$cadTarefa = mysqli_query ($conectaBanco ,"INSERT INTO mod_tarefas (tarefa_id,
																tarefa_projeto_id, 
																tarefa_numero,
																tarefa_usuario_id, 
																tarefa_nome,
																tarefa_descricao,
																tarefa_inicio,
																tarefa_final)				
																
														VALUES ('$tarefa_id',
																'$tarefa_projeto_id', 
																'$tarefa_numero',
																'$tarefa_usuario_id',
																'$tarefa_nome',
																'$tarefa_descricao',
																'$tarefa_inicio',
																'$tarefa_final')") or die (mysql_error());
																
		//==========================================================================================================================Cadastra histórico
		
														
		if($tarefa_inicio != "")
			{
			$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
			$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
			$ultimoID = $dadoshistorico["0"];
			$historico_id = $ultimoID+1;

			$historico_data = $tarefa_inicio;
			$historico_data_formatada = $tarefa_inicio;
			
				$historico_data_formatada = date_create("$historico_data_formatada");
				$historico_data_formatada = (date_format($historico_data_formatada, "d/m/Y H:i"));

			$cadHistoricoTarefaInicio = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_tarefa, historico_texto) 
																	VALUES ('$historico_id', '$tarefa_usuario_id', 'iniciodetarefa', '$historico_data', '$tarefa_id', 'A tarefa $tarefa_id - $tarefa_nome, deverá ser iniciada em $historico_data_formatada')");											
			}
			
		if($tarefa_final != "")
			{
			$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
			$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
			$ultimoID = $dadoshistorico["0"];
			$historico_id = $ultimoID+1;

			$historico_data = $tarefa_final;
			$historico_data_formatada = $tarefa_final;
			
				$historico_data_formatada = date_create("$historico_data_formatada");
				$historico_data_formatada = (date_format($historico_data_formatada, "d/m/Y H:i"));

			$cadHistoricoTarefaFinal = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_tarefa, historico_texto) 
																	VALUES ('$historico_id', '$tarefa_usuario_id', 'finaldetarefa', '$historico_data', '$tarefa_id', 'A tarefa $tarefa_id - $tarefa_nome, deverá ser finalizada em $historico_data_formatada')");											
			}
			
		//---------------------------------------------------------------------------------------------------------------------------------------------											
		}
	}
	
if($tarefa_nome == "" AND $tarefa_descricao == "" AND $tarefa_inicio == "" AND $tarefa_final == "")
	{
	$tarefa_id = mysqli_query($conectaBanco ,"SELECT tarefa_id FROM mod_tarefas WHERE tarefa_projeto_id = '$tarefa_projeto_id' AND tarefa_numero = '$tarefa_numero' ");
	$dados = mysqli_fetch_array($tarefa_id);
	$tarefa_id = $dados["0"];
	
	$deletaHistoricoTarefas = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tipo in ('iniciodetarefa', 'finaldetarefa') AND historico_tarefa = '$tarefa_id'") or die (mysql_error());
		
	$deletaProjetoTarefas = mysqli_query($conectaBanco ,"DELETE FROM mod_tarefas WHERE tarefa_projeto_id = '$tarefa_projeto_id' AND tarefa_numero = '$tarefa_numero'") or die (mysql_error());
	}
					
?>