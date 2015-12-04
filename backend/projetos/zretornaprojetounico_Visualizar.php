<?php 
include('../yconectaDB.inc');

//======================================================================================================================CARREGA PERMISSÕES DO USUÁRIO
$usuario_id_atual = $_POST["usuario_id_atual"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id_atual'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_edit_projetos_atual = $dados["usuario_edit_projetos"];
//----------------------------------------------------------------------------------------------------------------------------------------------------

$projeto_id = $_POST["projeto_id"];

$consultaProjetos = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_id = '$projeto_id'");
$dados = mysqli_fetch_array($consultaProjetos);
$projeto_nome = $dados["projeto_nome"];
$projeto_descricao = $dados["projeto_descricao"];
$projeto_tipo = $dados["projeto_tipo"];
$projeto_status = $dados["projeto_status"];
$projeto_inicio = $dados["projeto_inicio"];
$projeto_final = $dados["projeto_final"];
$projeto_solicitacao_id = $dados["projeto_solicitacao_id"];

$projeto_inicio = str_replace(" ", "T", $projeto_inicio);
$projeto_final = str_replace(" ", "T", $projeto_final);

echo "<div class='col-md-10 col-md-offset-1' id='temporario_visuprojetos'>";
echo "<h3>Visualização de projeto</h3>";
echo "<br>";
echo "<div class='row'>";
											
echo "<div class='col-md-6'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span>";
echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' value='$projeto_nome' id='projeto_nome' disabled>";
echo "</div>";
echo "<br>";
echo "<textarea class='form-control' rows='10' id='projeto_descricao' placeholder='Insira a descrição do projeto...' disabled>$projeto_descricao</textarea>";
echo "<br>";
echo "</div>";
											
echo "<div class='col-md-3'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Tipo</span>";
echo "<select class='form-control' aria-describedby='sizing-addon2' id='projeto_tipo' disabled>";
	echo "<option value='$projeto_status'>$projeto_status";
echo "</select></div>";
echo "<br>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Status</span>";
echo "<select class='form-control' aria-describedby='sizing-addon2' id='projeto_status' disabled>";
	echo "<option value='$projeto_tipo'>$projeto_tipo";
echo "</select></div>";
echo "<br>";
echo "</div>";
											
echo "<div class='col-md-3'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Início</span>";
echo "<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='projeto_inicio' value='$projeto_inicio' disabled>";
echo "</div>";
echo "<br>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Final</span>";
echo "<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='projeto_final' value='$projeto_final' disabled>";
echo "</div>";
echo "<br>";
echo "</div>";
											
echo "</div>";

echo "<div class='row' id='container_modulos'>";
	echo "<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";
		
		
	$consultamodulotarefas = mysqli_query($conectaBanco ,"SELECT * FROM mod_tarefas WHERE tarefa_projeto_id = '$projeto_id'");		
	$verificamodulotarefas = mysqli_num_rows($consultamodulotarefas);
	if($verificamodulotarefas > 0)
		{	
		echo "<div class='panel panel-default' id='moduloTarefas'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloTarefas'>";
				echo "<h4 class='panel-title'>";
					echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloTarefas' aria-expanded='true' aria-controls='collapse_moduloTarefas'>";
					echo "Tarefas - Atribuir tarefas para os usuários ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloTarefas' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloTarefas'>";
			echo "<div class='panel-body'>";
			echo "<div class='row' id='recebe_linhas_tarefas'>";
		
			$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(tarefa_numero) FROM mod_tarefas WHERE tarefa_projeto_id = '$projeto_id' ");		
			$dados = mysqli_fetch_array($consultaUltimoID);
			$ultimoID = $dados["0"];
			echo "<input type='hidden' id='ultimoregistro' value='$ultimoID'>";
			
			for ($i = 1; $i <= $ultimoID; $i++) 
				{
				$consultatarefas = mysqli_query($conectaBanco ,"SELECT * FROM mod_tarefas WHERE tarefa_projeto_id = '$projeto_id' and tarefa_numero = '$i' ");		
				$numeroregistros = mysqli_num_rows($consultatarefas);
				
				if($numeroregistros > 0)
					{		
					$dados = mysqli_fetch_array($consultatarefas);
					$tarefa_id = $dados["tarefa_id"];
					$tarefa_projeto_id = $dados["tarefa_projeto_id"];
					$tarefa_numero = $dados["tarefa_numero"];
					$tarefa_usuario_id = $dados["tarefa_usuario_id"];
					$tarefa_nome = $dados["tarefa_nome"];
					$tarefa_descricao = $dados["tarefa_descricao"];
					$tarefa_inicio = $dados["tarefa_inicio"];
					$tarefa_final = $dados["tarefa_final"];
					
					$tarefa_inicio = str_replace(" ", "T", $tarefa_inicio);
					$tarefa_final = str_replace(" ", "T", $tarefa_final);
					
					echo "<div class='row' id='container_tarefa".$tarefa_numero."'>";
					echo "<br>";
					echo "<div class='col-md-6 col-md-offset-0'>";
						echo "<div class='col-md-4'>";
							echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>ID </span>";
								echo "<input type='text' class='form-control' id='tarefa_numero".$tarefa_numero."' value='".$tarefa_numero."' disabled>";
							echo "</div>";
						echo "</div>";
						echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Atribuída a </span>";
							echo "<select id='tarefa_usuario_id_banco".$tarefa_numero."' class='form-control' disabled>";
							
							$consultaUsuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$tarefa_usuario_id'");
							$dados = mysqli_fetch_array($consultaUsuario);
							$usuario_nome = $dados["usuario_nome"];
							
								echo "<option value='$tarefa_usuario_id'>$usuario_nome";								
								$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login");
								while ($dados = mysqli_fetch_array($consultaUsuarios))
									{
									$usuario_id = $dados["usuario_id"];
									$usuario_nome = $dados["usuario_nome"];
											
									if($tarefa_usuario_id <> $usuario_id)
										{echo "<option value='$usuario_id'>$usuario_nome";}
									}
							echo "</select>";
						echo "</div>";
						echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da tarefa </span>";
							echo "<input type='text' class='form-control' id='tarefa_nome_banco".$tarefa_numero."' value='".$tarefa_nome."' disabled>";
						echo "</div>";
						echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Início </span>";
							echo "<input type='datetime-local' class='form-control' id='tarefa_inicio_banco".$tarefa_numero."' value='".$tarefa_inicio."' disabled>";
						echo "</div>";
						echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Final </span>";
							echo "<input type='datetime-local' class='form-control' id='tarefa_final_banco".$tarefa_numero."' value='".$tarefa_final."' disabled>";
						echo "</div>";
						echo "</div>";
						echo "<div class='col-md-6 col-md-offset-0'>";
							echo "<b>Descrição</b>";
							echo "<textarea class='form-control' rows='5' id='tarefa_descricao_banco".$tarefa_numero."' disabled>".$tarefa_descricao."</textarea>";
						echo "</div>";
						echo "</div>";
					}
				}
				
		//========================================================Grafico de Gantt		
			$consultaTarefasGrafico = mysqli_query($conectaBanco ,"SELECT * FROM mod_tarefas WHERE tarefa_projeto_id='$projeto_id' ORDER BY tarefa_inicio");
			echo "<br><div id='recebeGanttparaTarefas'><div class='ganttTarefas'></div></div>";
			
			echo "<script>$('.ganttTarefas').gantt({ source: [";
			while ($dados = mysqli_fetch_array($consultaTarefasGrafico))
				{
				$num_Tarefa = $dados["tarefa_numero"];
				$Nome_Tarefa = $dados["tarefa_nome"];
				
				$usuario_id = $dados["tarefa_usuario_id"];
				
				$consultanome = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id'");
				$dadosusuario = mysqli_fetch_array($consultanome);
				$Usuario_Tarefa = $dadosusuario["usuario_nome"];
				
				$Inicio_Tarefa = $dados["tarefa_inicio"];
				$Final_Tarefa = $dados["tarefa_final"];
					
					if ($Inicio_Tarefa == "0000-00-00 00:00:00" or $Final_Tarefa == "0000-00-00 00:00:00")
					{}
					else
					{
					$Inicio_Tarefa = date_create("$Inicio_Tarefa")->format('U');
					
					$Final_Tarefa = date_create("$Final_Tarefa")->format('U');
					
					$Inicio_Tarefa = $Inicio_Tarefa."000";
 					$Final_Tarefa = $Final_Tarefa."000";
					
					echo "{ name: '$num_Tarefa : $Nome_Tarefa', desc: 'Para: $Usuario_Tarefa', values: [{from: '/Date($Inicio_Tarefa)/',	to: '/Date($Final_Tarefa)/', label: '$num_Tarefa : $Nome_Tarefa', customClass: 'ganttOrange'}] },";
					}
				}
				echo "], months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'], dow: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'], navigate: 'scroll', waitText:'Aguarde confecção do Gráfico de Gannt para Tarefas...'  });</script>";
			//-----------------------------------------------------------------------------		
			

			echo "</div>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
		}

	if($projeto_solicitacao_id != 0)
		{
		$solicitacao_id = $projeto_solicitacao_id;

		$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_id = '$solicitacao_id'");
		$dados = mysqli_fetch_array($consultaSolicitacoes);
		$solicitacao_nome = $dados["solicitacao_nome"];
		$solicitacao_usuario = $dados["solicitacao_usuario"];
		$solicitacao_data = $dados["solicitacao_data"];
		$solicitacao_status = $dados["solicitacao_status"];
		$solicitacao_observacao = $dados["solicitacao_observacao"];

			$solicitacao_data = date_create("$solicitacao_data");
			$solicitacao_data = (date_format($solicitacao_data, "d/m/Y H:i"));

		$consultausuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$solicitacao_usuario' ");
		$dados = mysqli_fetch_array($consultausuario);
		$solicitacao_usuario_nome = $dados["usuario_nome"];
			
			
		echo "<div class='panel panel-default' id='moduloSolicitacao'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloSolicitacao'>";
				echo "<h4 class='panel-title'>";
					echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloSolicitacao' aria-expanded='true' aria-controls='collapse_moduloSolicitacao'>";
					echo "Solicitação - Vincule uma solicitação a esse projeto ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloSolicitacao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloSolicitacao'>";
				echo "<div class='panel-body'>";
				echo "<div class='row' id='container_info_solicitacao'>";
																	
					echo "<div id='recebe_info_solicitacao'>";
					echo "<br>";
					echo "<div class='row' id='recebe_nome_id'>";
						echo "<div class='col-md-10 col-md-offset-1'>";
							echo "<b>ID:</b> $projeto_solicitacao_id <b>Nome:</b> $solicitacao_nome";
						echo "</div>";
					echo "</div>";
					echo "<div class='row' id='recebe_solicitacao'>";
						echo "<div class='col-md-3 col-md-offset-1'>";
							echo "<b>Usuário solicitante:</b> $solicitacao_usuario_nome";
						echo "</div>";
						echo "<div class='col-md-4'>";
							echo "<b>Data de solicitação:</b> $solicitacao_data<br>";
						echo "</div>";
						echo "<div class='col-md-3'>";
							echo "<b>Status da solicitação:</b> $solicitacao_status<br>";
						echo "</div>";
					echo "</div>";
					echo "<div class='row'>";
						echo "<div class='col-md-10 col-md-offset-1'>";
							echo "<b>Observação da solicitação:</b> $solicitacao_observacao";
						echo "</div>";
					echo "</div>";
					echo "<div class='row' id='recebe_perguntas'>";
						echo "<br>";
						echo "<div class='col-md-10 col-md-offset-1'>";
						echo "<h3>Perguntas e respostas da solicitação</h3>";
						$consultaperguntas = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoesrespostas WHERE solicitacao_id = '$solicitacao_id'");
						while($dados = mysqli_fetch_array($consultaperguntas))
							{
							$solicitacao_pergunta = $dados["solicitacao_pergunta"];
							$solicitacao_resposta = $dados["solicitacao_resposta"];
							
							echo "<b>$solicitacao_pergunta</b><br>$solicitacao_resposta<br><br>";
							}
						echo "</div>";
					echo "</div>";
					echo "</div>";

				echo "</div>";
			echo "</div>";
		echo "</div>";
		}
		
	$consultamoduloinovacao = mysqli_query($conectaBanco ,"SELECT * FROM mod_inovacao WHERE inovacao_projeto_id = '$projeto_id'");		
	$verificamoduloinovacao = mysqli_num_rows($consultamoduloinovacao);
	if($verificamoduloinovacao > 0)
		{	
		
		echo "<div class='panel panel-default' id='moduloInovacao'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloInovacao'>";
				echo "<h4 class='panel-title'>";
					echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloInovacao' aria-expanded='true' aria-controls='collapse_moduloInovacao'>";
					echo "Inovação - Para criação de novas funções/rotinas ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloInovacao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloInovacao'>";
				echo "<div class='panel-body'>";
				echo "<div class='row' id='container_inovacao'>";
				
			
			$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(inovacao_numero) FROM mod_inovacao WHERE inovacao_projeto_id = '$projeto_id' ");		
			$dados = mysqli_fetch_array($consultaUltimoID);
			$ultimoID = $dados["0"];
			echo "<input type='hidden' id='ultimoregistro' value='$ultimoID'>";
			
			for ($i = 1; $i <= $ultimoID; $i++) 
				{
				$consultainovacao = mysqli_query($conectaBanco ,"SELECT * FROM mod_inovacao WHERE inovacao_projeto_id = '$projeto_id' and inovacao_numero = '$i' ");		
				$numeroregistros = mysqli_num_rows($consultainovacao);
				
				if($numeroregistros > 0)
					{		
					$dados = mysqli_fetch_array($consultainovacao);
					$inovacao_id = $dados["inovacao_id"];
					$inovacao_projeto_id = $dados["inovacao_projeto_id"];
					$inovacao_numero = $dados["inovacao_numero"];
					$inovacao_rotina_id = $dados["inovacao_rotina_id"];
					$inovacao_rotina_nome = $dados["inovacao_rotina_nome"];
					$inovacao_rotina_descricao = $dados["inovacao_rotina_descricao"];
		
						echo "<div class='row' id='container_inovacao".$inovacao_numero."'>";
							echo "<br>";
							echo "<div class='col-md-10 col-md-offset-1'>";
								echo "<div class='col-md-2'>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>ID </span>";
										echo "<input type='text' class='form-control' id='inovacao_numero".$inovacao_numero."' value='".$inovacao_numero."' disabled>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-10'>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da inovação </span>";
										echo "<input type='text' class='form-control' id='inovacao_rotina_nome".$inovacao_numero."' value='".$inovacao_rotina_nome."' disabled>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-12'>";
									echo "<textarea class='form-control' rows='5' id='inovacao_rotina_descricao".$inovacao_numero."' disabled>".$inovacao_rotina_descricao."</textarea>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
					}
				}
				
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "</div>";
		}
		
	$consultamoduloalteracao = mysqli_query($conectaBanco ,"SELECT * FROM mod_alteracao WHERE alteracao_projeto_id = '$projeto_id'");		
	$verificamoduloalteracao = mysqli_num_rows($consultamoduloalteracao);
	if($verificamoduloalteracao > 0)
		{
		
		echo "<div class='panel panel-default' id='moduloAlteracao'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloAlteracao'>";
				echo "<h4 class='panel-title'>";
					echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloAlteracao' aria-expanded='true' aria-controls='collapse_moduloAlteracao'>";
					echo "Alteração - Para alteração de funções/rotinas ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloAlteracao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloAlteracao'>";
				echo "<div class='panel-body'>";
					echo "<div class='row' id='container_alteracao'>";
					
					
			$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(alteracao_numero) FROM mod_alteracao WHERE alteracao_projeto_id = '$projeto_id' ");		
			$dados = mysqli_fetch_array($consultaUltimoID);
			$ultimoID = $dados["0"];
			echo "<input type='hidden' id='ultimoregistro' value='$ultimoID'>";
			
			for ($i = 1; $i <= $ultimoID; $i++) 
				{
				$consultaalteracao = mysqli_query($conectaBanco ,"SELECT * FROM mod_alteracao WHERE alteracao_projeto_id = '$projeto_id' and alteracao_numero = '$i' ");		
				$numeroregistros = mysqli_num_rows($consultaalteracao);
				
				if($numeroregistros > 0)
					{		
					$dados = mysqli_fetch_array($consultaalteracao);
					$alteracao_id = $dados["alteracao_id"];
					$alteracao_projeto_id = $dados["alteracao_projeto_id"];
					$alteracao_numero = $dados["alteracao_numero"];
					$alteracao_rotina_id = $dados["alteracao_rotina_id"];
					$alteracao_nome = $dados["alteracao_nome"];
					$alteracao_objetivo = $dados["alteracao_objetivo"];
					$alteracao_antes = $dados["alteracao_antes"];
					$alteracao_depois = $dados["alteracao_depois"];
					
					echo "<div class='row' id='container_alteracao".$alteracao_numero."'>";
					echo "<br>";
						echo "<div class='col-md-10 col-md-offset-1'>";
							echo "<div class='row'>";
								echo "<div class='col-md-2'>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>ID </span>";
									echo "<input type='text' class='form-control' id='alteracao_numero".$alteracao_numero."' value='".$alteracao_numero."' disabled>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-9'>";
									echo "<select id='alteracao_rotina_id".$alteracao_numero."' class='form-control' onchange='retorna_info_alteracao(".$alteracao_numero.")' disabled>";
									
									$consultarotina = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id = '$alteracao_rotina_id' ");		
									$dados = mysqli_fetch_array($consultarotina);
									$alteracao_rotina_nome = $dados["rotina_nome"];
									
										echo "<option value='$alteracao_rotina_id'>$alteracao_rotina_id :: $alteracao_rotina_nome ";
									echo "</select>";
								echo "</div>";
							echo "</div>";
							echo "<div class='row'>";
								echo "<div class='col-md-11'>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2' disabled>Nome da alteração </span>";
									echo "<input type='text' class='form-control' id='alteracao_nome".$alteracao_numero."' value='".$alteracao_nome."' disabled>";
									echo "</div>";
								echo "</div>";
							echo "</div>";
							echo "<div class='row'>";
								echo "<div class='col-md-3'>";
									echo "<textarea class='form-control' rows='5' placeholder='Como era antes das alterações...' id='alteracao_antes".$alteracao_numero."' disabled>".$alteracao_antes."</textarea>";
								echo "</div>";
								echo "<div class='col-md-3'>";
									echo "<textarea class='form-control' rows='5' placeholder='Como ficará depois das alterações...' id='alteracao_depois".$alteracao_numero."' disabled>".$alteracao_depois."</textarea>";
								echo "</div>";
								echo "<div class='col-md-4'>";
									echo "<textarea class='form-control' rows='5' placeholder='Qual o objetivo da alteração...' id='alteracao_objetivo".$alteracao_numero."' disabled>".$alteracao_objetivo."</textarea>";
								echo "</div>";
							echo "</div>";	
						echo "</div>";
					echo "</div>";
					}
				}
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		}
		
	
	$consultamodulocorrecao = mysqli_query($conectaBanco ,"SELECT * FROM mod_correcao WHERE correcao_projeto_id = '$projeto_id'");		
	$verificamodulocorrecao = mysqli_num_rows($consultamodulocorrecao);
	if($verificamodulocorrecao > 0)
		{	
		
		echo "<div class='panel panel-default' id='moduloCorrecao'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloCorrecao'>";
				echo "<h4 class='panel-title'>";
					echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloCorrecao' aria-expanded='true' aria-controls='collapse_moduloCorrecao'>";
					echo "Correção - Para correção de funções/rotinas ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloCorrecao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloCorrecao'>";
				echo "<div class='panel-body'>";
				echo "<div class='row' id='container_correcao'>";
				
			
			$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(correcao_numero) FROM mod_correcao WHERE correcao_projeto_id = '$projeto_id' ");		
			$dados = mysqli_fetch_array($consultaUltimoID);
			$ultimoID = $dados["0"];
			echo "<input type='hidden' id='ultimoregistro' value='$ultimoID'>";
			
			for ($i = 1; $i <= $ultimoID; $i++) 
				{
				$consultacorrecao = mysqli_query($conectaBanco ,"SELECT * FROM mod_correcao WHERE correcao_projeto_id = '$projeto_id' and correcao_numero = '$i' ");		
				$numeroregistros = mysqli_num_rows($consultacorrecao);
				
				if($numeroregistros > 0)
					{		
					$dados = mysqli_fetch_array($consultacorrecao);
					$correcao_id = $dados["correcao_id"];
					$correcao_projeto_id = $dados["correcao_projeto_id"];
					$correcao_numero = $dados["correcao_numero"];
					$correcao_rotina_id = $dados["correcao_rotina_id"];
					$correcao_nome = $dados["correcao_nome"];
					$correcao_descricao = $dados["correcao_descricao"];
		
						echo "<div class='row' id='container_correcao".$correcao_numero."'>";
							echo "<br>";
							echo "<div class='col-md-10 col-md-offset-1'>";
								echo "<div class='col-md-2'>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>ID </span>";
										echo "<input type='text' class='form-control' id='correcao_numero".$correcao_numero."' value='".$correcao_numero."' disabled>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-8'>";
									echo "<select id='correcao_rotina_id".$correcao_numero."' class='form-control' disabled>";
									
									$consultarotina = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id = '$correcao_rotina_id' ");		
									$dados = mysqli_fetch_array($consultarotina);
									$correcao_rotina_nome = $dados["rotina_nome"];
									
										echo "<option value='$correcao_rotina_id'>$correcao_rotina_id :: $correcao_rotina_nome ";
									echo "</select>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da correção </span>";
										echo "<input type='text' class='form-control' id='correcao_nome".$correcao_numero."' value='".$correcao_nome."' disabled>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-10'>";
									echo "<textarea class='form-control' rows='5' id='correcao_descricao".$correcao_numero."' disabled>".$correcao_descricao."</textarea>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
					}
				}
				
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "</div>";
		}
		
		
	$consultamoduloforum = mysqli_query($conectaBanco ,"SELECT * FROM mod_forum WHERE forum_projeto_id = '$projeto_id'");		
	$verificamoduloforum = mysqli_num_rows($consultamoduloforum);
	if($verificamoduloforum > 0)
		{
		echo "<div class='panel panel-default' id='moduloForum'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloForum'>";
				echo "<h4 class='panel-title'>";
				echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloForum' aria-expanded='true' aria-controls='collapse_moduloForum'>";
				echo "Forum do projeto - Para que sejam descutidas ideias ";
				echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloForum' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloForum'>";
				echo "<div class='panel-body'>";
					echo "<div class='row' id='container_mensagensforum'>";
					
					$consultaforum = mysqli_query($conectaBanco ,"SELECT * FROM mod_forum WHERE forum_projeto_id ='$projeto_id' ORDER BY forum_projeto_id");

					echo "<table class='table' id='recebe_mensagensforum'>";
					echo "<tbody><td><h3>Usuário</h3></td><td><h3>Mensagem</h3></td></tbody>";
					while ($dados = mysqli_fetch_array($consultaforum))
						{
						$forum_id = $dados["forum_id"];
						$forum_projeto_id = $dados["forum_projeto_id"];
						$forum_usuario_id = $dados["forum_usuario_id"];
						$forum_mensagem = $dados["forum_mensagem"];
						
						$consultausuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$forum_usuario_id'");
						$dados = mysqli_fetch_array($consultausuario);
						$usuario_nome = $dados["usuario_nome"];
						
						echo "<tbody><td><b>$usuario_nome</b></td><td>$forum_mensagem</td></tbody>";
						}
					echo "</table>";
					
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		}
	
		
	$consultamoduloerros = mysqli_query($conectaBanco ,"SELECT * FROM mod_erros WHERE erro_projeto_id = '$projeto_id'");		
	$verificamoduloerros = mysqli_num_rows($consultamoduloerros);
	if($verificamoduloerros > 0)
		{
		echo "<div class='panel panel-default' id='moduloErros'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloErros'>";
				echo "<h4 class='panel-title'>";
				echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloErros' aria-expanded='true' aria-controls='collapse_moduloErros'>";
				echo "Erros do projeto";
				echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloErros' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloErros'>";
				echo "<div class='panel-body'>";
					echo "<div class='row' id='container_erros'>";
					
					$consultaerros = mysqli_query($conectaBanco ,"SELECT * FROM mod_erros WHERE erro_projeto_id ='$projeto_id' and erro_status <> 'Finalizado' ORDER BY erro_projeto_id");

					while ($dados = mysqli_fetch_array($consultaerros))
						{
						$erro_id = $dados["erro_id"];
						$erro_usuario_id = $dados["erro_usuario_id"];
						$erro_status = $dados["erro_status"];
						$erro_nome = $dados["erro_nome"];
						$erro_descricao = $dados["erro_descricao"];
						$erro_imagem1 = $dados["erro_imagem1"];
						$erro_imagem2 = $dados["erro_imagem2"];
						$erro_imagem3 = $dados["erro_imagem3"];
						$erro_imagem4 = $dados["erro_imagem4"];
						$erro_imagem5 = $dados["erro_imagem5"];
						
						$consultausuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$erro_usuario_id'");
						$dados = mysqli_fetch_array($consultausuario);
						$erro_usuario_nome = $dados["usuario_nome"];
						
						echo "<hr>";
						echo "<div class='row'>";
							echo "<div class='col-md-5 col-md-offset-1'>";
								echo "<b> ID/Nome do erro : </b> $erro_id - $erro_nome";
							echo "</div>";
							echo "<div class='col-md-3'>";
								echo "<b> Status do erro : </b> $erro_status";
							echo "</div>";
							echo "<div class='col-md-2'>";
								echo "<b> Atribuído ao usuário : </b> $erro_usuario_nome";
							echo "</div>";
							echo "<div class='col-md-10 col-md-offset-1'>";
								echo "<b> Descrição : </b> $erro_descricao";
							echo "</div>";
							echo "<div class='col-md-10 col-md-offset-1'>";
								echo "<br><b> Imagens do erro: </b><br><br>";
									if($erro_imagem1 != "")
										{
										echo "<div class='col-md-4'>";
											echo "<img src='backend/projetos/relatarerro/fotos/$erro_imagem1' class='img-responsive img-rounded'>";
										echo "</div>";
										}
									if($erro_imagem2 != "")
										{
										echo "<div class='col-md-4'>";
											echo "<img src='backend/projetos/relatarerro/fotos/$erro_imagem2' class='img-responsive img-rounded'>";
										echo "</div>";
										}
									if($erro_imagem3 != "")
										{
										echo "<div class='col-md-4'>";
											echo "<img src='backend/projetos/relatarerro/fotos/$erro_imagem3' class='img-responsive img-rounded'>";
										echo "</div>";
										}
									if($erro_imagem4 != "")
										{
										echo "<div class='col-md-4'>";
											echo "<img src='backend/projetos/relatarerro/fotos/$erro_imagem4' class='img-responsive img-rounded'>";
										echo "</div>";
										}
									if($erro_imagem5 != "")
										{
										echo "<div class='col-md-4'>";
											echo "<img src='backend/projetos/relatarerro/fotos/$erro_imagem5' class='img-responsive img-rounded'>";
										echo "</div>";
										}
							echo "</div>";
						echo "</div>";
						}
					
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		}
		
		
		
	echo "</div>";
echo "</div>";

echo "<div class='row' id='historico'>";
$consultahistorico = mysqli_query($conectaBanco ,"SELECT * FROM historico WHERE historico_projeto = '$projeto_id'");
echo "<br><h4>Histórico</h4>";
echo "<table class='table'>";
while ($dados = mysqli_fetch_array($consultahistorico))
	{
	$historico_usuario_id = $dados["historico_usuario_id"];
	$historico_data = $dados["historico_data"];
	$historico_texto = $dados["historico_texto"];
	
	$historico_data = date_create("$historico_data");
	$historico_data = (date_format($historico_data, "d/m/Y H:i"));
	
		$consultaNomeUsuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$historico_usuario_id'");		
		$dadoshistorico = mysqli_fetch_array($consultaNomeUsuario);
		$historico_usuario_nomecompleto = $dadoshistorico["usuario_nomecompleto"];
		$historico_usuario_cargo = $dadoshistorico["usuario_cargo"];
																					
		echo "<tbody><td><b><h5>$historico_usuario_nomecompleto</h5></b>";
				echo "<i><h6>$historico_usuario_cargo</h6></i></td>";
			echo "<td>$historico_texto</td>";
			echo "<td><i><h6>Em $historico_data</h6></i></td>";
	}
echo "</table>";
echo "</div>";


echo "<div class='row'>";

if($usuario_edit_projetos_atual == "S")
	{
	echo "<button type='button' class='btn btn-primary' id='btn_SalvarProjeto' onclick='edita_projeto(".$projeto_id.")'>";
	echo "<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Editar projeto";
	echo "</button>";
	}
echo "</div>";
echo "<br><br>";
echo "</div>";
?>