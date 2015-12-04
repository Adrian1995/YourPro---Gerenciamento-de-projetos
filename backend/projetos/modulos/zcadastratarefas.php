<?php 
include('../../yconectaDB.inc');

$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(tarefa_id) FROM mod_tarefas");		
$dados = mysqli_fetch_array($consultaUltimoID);
$ultimoID = $dados["0"];

$tarefa_id = $ultimoID+1;
$tarefa_projeto_id = $_POST["tarefa_projeto_id"];
$tarefa_numero = $_POST["tarefa_numero"];
$tarefa_usuario_id = $_POST["tarefa_usuario_id_banco"];
$tarefa_nome = $_POST["tarefa_nome_banco"];
$tarefa_descricao = $_POST["tarefa_descricao_banco"];
$tarefa_inicio = $_POST["tarefa_inicio_banco"];
$tarefa_final = $_POST["tarefa_final_banco"];

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
			
												
	echo "OK";

	
?>