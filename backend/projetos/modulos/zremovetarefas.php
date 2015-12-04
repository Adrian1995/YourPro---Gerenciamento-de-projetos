<?php 
include('../../yconectaDB.inc');

$tarefa_projeto_id = $_POST["tarefa_projeto_id"];

	$selecionahistoricotarefasremover = mysqli_query($conectaBanco ,"SELECT * FROM mod_tarefas WHERE tarefa_projeto_id = '$tarefa_projeto_id'");
	while($dados = mysqli_fetch_array($selecionahistoricotarefasremover))
		{
		$tarefa_id = $dados["tarefa_id"];
		
		$deletaHistoricoTarefas = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tipo in ('iniciodetarefa', 'finaldetarefa') AND historico_tarefa = '$tarefa_id'") or die (mysql_error());
		}
$deletaProjetoTarefas = mysqli_query($conectaBanco ,"DELETE FROM mod_tarefas WHERE tarefa_projeto_id = '$tarefa_projeto_id'") or die (mysql_error());
			
?>