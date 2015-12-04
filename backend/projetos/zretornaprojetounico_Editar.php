<?php 
include('../yconectaDB.inc');

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

echo "<div class='col-md-10 col-md-offset-1' id='temporario_editprojetos'>";
echo "<h3>Alteração de projeto</h3>";
echo "<br>";
echo "<div class='row'>";
											
echo "<div class='col-md-6'>";
echo "<input type='hidden' id='projeto_id' value='$projeto_id'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span>";
echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' value='$projeto_nome' id='projeto_nome'>";
echo "</div>";
echo "<br>";
echo "<textarea class='form-control' rows='10' id='projeto_descricao' placeholder='Insira a descrição do projeto...'>$projeto_descricao</textarea>";
echo "<br>";
echo "</div>";
											
echo "<div class='col-md-3'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Tipo</span>";
echo "<select class='form-control' aria-describedby='sizing-addon2' id='projeto_tipo'>";
	echo "<option value='$projeto_tipo'>$projeto_tipo";
	
	$consultaTipos = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes_tipos");
		while($dados = mysqli_fetch_array($consultaTipos))
			{
			$tipo_nome = $dados["tipo_nome"];
			
			if($projeto_tipo != $tipo_nome)
				{
				echo "<option value='$tipo_nome'>$tipo_nome";
				}
			}
	
echo "</select></div>";
echo "<br>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Status</span>";
echo "<select class='form-control' aria-describedby='sizing-addon2' id='projeto_status'>";
	echo "<option value='$projeto_status'>$projeto_status";

	$consultaStatus = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes_status_projetos");
		while($dados = mysqli_fetch_array($consultaStatus))
			{
			$status_nome = $dados["status_nome"];
			
			if($projeto_status != $status_nome)
				{
				echo "<option value='$status_nome'>$status_nome";
				}
			}
	
echo "</select></div>";
echo "<br>";
echo "</div>";
											
echo "<div class='col-md-3'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Início</span>";
echo "<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='projeto_inicio' value='$projeto_inicio'>";
echo "</div>";
echo "<br>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Final</span>";
echo "<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='projeto_final' value='$projeto_final'>";
echo "</div>";
echo "<br>";
echo "</div>";
											
	echo "<div class='row'>";
		echo "<div class='col-md-6'>";
		echo "<br>";
		echo "<br>";
		echo "<div class='panel panel-default'>";
			echo "<div class='panel-body'>";
				echo "<select class='form-control' aria-describedby='sizing-addon2' id='select_modulo'>";
					echo "<option value=''>Selecione...";
					echo "<option value='Tarefas'>Tarefas - Atribuir tarefas para os usuários";
					echo "<option value='Solicitacao'>Solicitação - Vincule uma solicitação a esse projeto";
					echo "<option value='Inovacao'>Inovação - Para criação de novas funções/rotinas";
					echo "<option value='Alteracao'>Alteração - Para alteração de funções/rotinas";
					echo "<option value='Correcao'>Correção - Para correção de funções/rotinas";
					echo "<option value='Forum'>Forum do projeto - Para que sejam descutidas ideias";
				echo "</select>";
				echo "<br>";
				echo "<button type='button' class='btn btn-default' id='btn_AdicionaModulo' onclick='adiciona_modulo()'>";
				echo "<span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span> Adicionar modulo";
				echo "</button>";
			echo "</div>";
		echo "</div>";
		echo "</div>";
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
					$modulo = '"moduloTarefas"'; echo "<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo($modulo)'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Tarefas - Atribuir tarefas para os usuários ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloTarefas' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloTarefas'>";
			echo "<div class='panel-body'>";
				echo "<div class='row'>";
				echo "<div class='col-md-7 col-md-offset-0'>";
					echo "<b> Nome da tarefa </b>";
					echo "<input type='text' class='form-control' id='tarefa_nome' placeholder='Insira o nome da tarefa...'>";
					echo "<br>";
					echo "<textarea class='form-control' rows='6' id='tarefa_descricao' placeholder='Insira a descrição da tarefa...'></textarea>";
				echo "</div>";
				echo "<div class='col-md-5 col-md-offset-0'>";
					echo "<b> Atribuída ao usuário </b>";
					echo "<select id='tarefa_usuario_id' class='form-control'>";
					echo "<option value=''>Selecione o usuário para a tarefa...";							
					$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login");
						while ($dados = mysqli_fetch_array($consultaUsuarios))
							{
							$usuario_id = $dados["usuario_id"];
							$usuario_nome = $dados["usuario_nome"];
																					
							echo "<option value='$usuario_id'>$usuario_nome";
							}												
					echo "</select>";
					echo "<br>";
					echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Início da tarefa</span>";
					echo "<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='tarefa_inicio'>";
					echo "</div>";
					echo "<br>";
					echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Final da tarefa</span>";
					echo "<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='tarefa_final'>";
					echo "</div>";
					echo "<br>";
					echo "<button type='button' class='btn btn-primary' id='btn_Incluirtarefa' onclick='adiciona_tarefa()'>";
					echo "<span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span> Adicionar tarefa";
					echo "</button>";
				echo "</div>";
			echo "</div>";
			echo "<br>";
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
								echo "<input type='hidden' id='tarefa_id".$tarefa_numero."' value='".$tarefa_id."' disabled>";
							echo "</div>";
						echo "</div>";
						echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Atribuída a </span>";
							echo "<select id='tarefa_usuario_id_banco".$tarefa_numero."' class='form-control'>";
							
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
							echo "<input type='text' class='form-control' id='tarefa_nome_banco".$tarefa_numero."' value='".$tarefa_nome."'>";
						echo "</div>";
						echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Início </span>";
							echo "<input type='datetime-local' class='form-control' id='tarefa_inicio_banco".$tarefa_numero."' value='".$tarefa_inicio."'>";
						echo "</div>";
						echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Final </span>";
							echo "<input type='datetime-local' class='form-control' id='tarefa_final_banco".$tarefa_numero."' value='".$tarefa_final."'>";
						echo "</div>";
						echo "</div>";
						echo "<div class='col-md-6 col-md-offset-0'>";
							echo "<b>Descrição</b>&nbsp;&nbsp; <button type='button' class='btn btn-default btn-xs' onclick='remove_tarefa(".$tarefa_numero.")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button>";
							echo "<textarea class='form-control' rows='5' id='tarefa_descricao_banco".$tarefa_numero."'>".$tarefa_descricao."</textarea>";
						echo "</div>";
						echo "</div>";
					}
				}
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
					$modulo = '"moduloSolicitacao"'; echo "<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo($modulo)'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Solicitação - Vincule uma solicitação a esse projeto ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloSolicitacao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloSolicitacao'>";
				echo "<div class='panel-body'>";
				
				echo "<div class='row'>";
					echo "<div class='col-md-7 col-md-offset-0'>";
						echo "<b> Selecione o nome da solicitação </b>";
						echo "<select id='projeto_solicitacao_id' class='form-control' onchange='retorna_info_solicitacao()'>";
							echo "<option value='$solicitacao_id'>$solicitacao_id :: $solicitacao_nome";
								$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes ORDER BY solicitacao_id DESC");
								while ($dados = mysqli_fetch_array($consultaSolicitacoes))
									{
									$solicitacao_id_outros = $dados["solicitacao_id"];
									$solicitacao_nome_outros = $dados["solicitacao_nome"];
																					
									if($solicitacao_id != $solicitacao_id_outros)
										{
										echo "<option value='$solicitacao_id_outros'>$solicitacao_id_outros :: $solicitacao_nome_outros";
										}
									}
						echo "</select>";
					echo "</div>";
					echo "<div class='col-md-4 col-md-offset-0'>";
						echo "<b> Ou insira o ID da mesma </b><br>";
						echo "<input type='number' id='seleciona_id_solicitacao' class='form-control' onchange='seleciona_solicitacao_por_id()'>";
					echo "</div>";
				echo "</div>";
				
				echo "<div class='row' id='container_info_solicitacao'>";
																	
					echo "<div id='recebe_info_solicitacao'>";
					echo "<br>";
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
					$modulo = '"moduloInovacao"'; echo "<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo($modulo)'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Inovação - Para criação de novas funções/rotinas ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloInovacao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloInovacao'>";
				echo "<div class='panel-body'>";
				
				echo "<div class='row'>";
					echo "<div class='col-md-9 col-md-offset-1'>";
						echo "<b>Nome da nova função/rotina:</b>";
						echo "<input type='text' class='form-control' id='inovacao_rotina_nome'>";
						echo "<b>Descrição da nova função/rotina</b>";
						echo "<textarea class='form-control' rows='5' id='inovacao_rotina_descricao'></textarea>";
					echo "</div>";
					echo "<div class='col-md-2'>";
						echo "<br>";
						echo "<button type='button' class='btn btn-primary' id='btn_Incluirinovacao' onclick='adiciona_inovacao()'>";
						echo "<span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span> Adicionar inovação";
						echo "</button>";
					echo "</div>";
				echo "</div>";
				
				
				
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
										echo "<input type='hidden' id='inovacao_id".$inovacao_numero."' value='".$inovacao_id."' disabled>";
										echo "<input type='hidden' id='inovacao_rotina_id".$inovacao_numero."' value='".$inovacao_rotina_id."' disabled>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-8'>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da inovação </span>";
										echo "<input type='text' class='form-control' id='inovacao_rotina_nome".$inovacao_numero."' value='".$inovacao_rotina_nome."'>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-2'>";
									echo "<button type='button' class='btn btn-default btn-xs' onclick='remove_inovacao(".$inovacao_numero.")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button>";
								echo "</div>";
								echo "<div class='col-md-10'>";
									echo "<textarea class='form-control' rows='5' id='inovacao_rotina_descricao".$inovacao_numero."'>".$inovacao_rotina_descricao."</textarea>";
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
					$modulo = '"moduloAlteracao"'; echo "<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo($modulo)'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Alteração - Para alteração de funções/rotinas ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloAlteracao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloAlteracao'>";
				echo "<div class='panel-body'>";
				
				
				echo "<div class='row'>";
					echo "<div class='col-md-10'>";
						echo "<b> Selecione a rotina que será alterada </b>";
						echo "<select id='alteracao_rotina_id' class='form-control' onchange='retorna_info_alteracao()'>";
							echo "<option value=''>Selecione a rotina...";
							$consultaRotinas = mysqli_query($conectaBanco ,"SELECT * FROM rotinas ORDER BY rotina_id DESC");
							while ($dados = mysqli_fetch_array($consultaRotinas))
								{
								$rotina_id = $dados["rotina_id"];
								$rotina_nome = $dados["rotina_nome"];
																					
								echo "<option value='$rotina_id'>$rotina_id :: $rotina_nome";
								}
						echo "</select>";
						echo "<input type='text' class='form-control' placeholder='Nome da alteração...' id='alteracao_nome'>";
					echo "</div>";
					echo "<div class='col-md-2'>";
						echo "<br>";
						echo "<button type='button' class='btn btn-primary' id='btn_Incluiralteracao' onclick='adiciona_alteracao()'>";
						echo "<span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span> Adicionar alteração";
						echo "</button>";
					echo "</div>";
				echo "</div>";
				echo "<div class='row'>";
					echo "<br>";
					echo "<div class='col-md-3'>";
						echo "<textarea class='form-control' rows='5' placeholder='Como era antes das alterações...' id='alteracao_antes'></textarea>";
					echo "</div>";
					echo "<div class='col-md-3'>";
						echo "<textarea class='form-control' rows='5' placeholder='Como ficará depois das alterações...' id='alteracao_depois'></textarea>";
					echo "</div>";
					echo "<div class='col-md-4'>";
						echo "<textarea class='form-control' rows='5' placeholder='Qual o objetivo da alteração...' id='alteracao_objetivo'></textarea>";
					echo "</div>";
				echo "</div>";
				
				
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
										echo "<input type='hidden' id='alteracao_id".$alteracao_numero."' value='".$alteracao_id."'>";
										echo "</div>";
									echo "</div>";
									echo "<div class='col-md-9'>";
										echo "<select id='alteracao_rotina_id".$alteracao_numero."' class='form-control' onchange='retorna_info_alteracao(".$alteracao_numero.")'>";
										
										$consultarotina = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id = '$alteracao_rotina_id' ");		
										$dados = mysqli_fetch_array($consultarotina);
										$alteracao_rotina_nome = $dados["rotina_nome"];
										
											echo "<option value='$alteracao_rotina_id'>$alteracao_rotina_id :: $alteracao_rotina_nome ";
											
										$consultarotina = mysqli_query($conectaBanco ,"SELECT * FROM rotinas");		
										while($dados = mysqli_fetch_array($consultarotina))
											{
											$rotina_id = $dados["rotina_id"];
											$rotina_nome = $dados["rotina_nome"];
											
											if($alteracao_rotina_id != $rotina_id)
												{
												echo "<option value='$rotina_id'>$rotina_id :: $rotina_nome ";
												}
											}
											
										echo "</select>";
									echo "</div>";
									echo "<div class='col-md-1'>";
										echo "<button type='button' class='btn btn-default btn-xs' onclick='remove_alteracao(".$alteracao_numero.")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button>";
									echo "</div>";
								echo "</div>";
								echo "<div class='row'>";
									echo "<div class='col-md-11'>";
										echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da alteração </span>";
										echo "<input type='text' class='form-control' id='alteracao_nome".$alteracao_numero."' value='".$alteracao_nome."'>";
										echo "</div>";
									echo "</div>";
								echo "</div>";
								echo "<div class='row'>";
									echo "<div class='col-md-3'>";
										echo "<textarea class='form-control' rows='5' placeholder='Como era antes das alterações...' id='alteracao_antes".$alteracao_numero."'>".$alteracao_antes."</textarea>";
									echo "</div>";
									echo "<div class='col-md-3'>";
										echo "<textarea class='form-control' rows='5' placeholder='Como ficará depois das alterações...' id='alteracao_depois".$alteracao_numero."'>".$alteracao_depois."</textarea>";
									echo "</div>";
									echo "<div class='col-md-4'>";
										echo "<textarea class='form-control' rows='5' placeholder='Qual o objetivo da alteração...' id='alteracao_objetivo".$alteracao_numero."'>".$alteracao_objetivo."</textarea>";
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
					$modulo = '"moduloCorrecao"'; echo "<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo($modulo)'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Correção - Para correção de funções/rotinas ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloCorrecao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloCorrecao'>";
				echo "<div class='panel-body'>";
				
				
				
				
				
				echo "<div class='row'>";
					echo "<div class='col-md-9 col-md-offset-1'>";
						echo "<b> Selecione a rotina que será corrigida </b>";
						echo "<select id='correcao_rotina_id' class='form-control'>";
						echo "<option value=''>Selecione a rotina...";
							$consultaRotinas = mysqli_query($conectaBanco ,"SELECT * FROM rotinas ORDER BY rotina_id DESC");
							while ($dados = mysqli_fetch_array($consultaRotinas))
								{
								$rotina_id = $dados["rotina_id"];
								$rotina_nome = $dados["rotina_nome"];
																					
								echo "<option value='$rotina_id'>$rotina_id :: $rotina_nome";
								}
						echo "</select>";
																		
						echo "<b>Nome da correção:</b>";
						echo "<input type='text' class='form-control' id='correcao_nome'>";
						echo "<b>Descrição da correção</b>";
						echo "<textarea class='form-control' rows='5' id='correcao_descricao'></textarea>";
					echo "</div>";
					echo "<div class='col-md-2'>";
						echo "<br>";
						echo "<button type='button' class='btn btn-primary' onclick='adiciona_correcao()'>";
						echo "<span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span> Adicionar correção";
						echo "</button>";
					echo "</div>";
				echo "</div>";
				
				
				
				
				
				
				
				
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
										echo "<input type='hidden' id='correcao_id".$correcao_numero."' value='".$correcao_id."'>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-8'>";
									echo "<select id='correcao_rotina_id".$correcao_numero."' class='form-control'>";
									
									$consultarotina = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id = '$correcao_rotina_id' ");		
									$dados = mysqli_fetch_array($consultarotina);
									$correcao_rotina_nome = $dados["rotina_nome"];
									
									echo "<option value='$correcao_rotina_id'>$correcao_rotina_id :: $correcao_rotina_nome ";
									
									$consultarotina = mysqli_query($conectaBanco ,"SELECT * FROM rotinas");		
										while($dados = mysqli_fetch_array($consultarotina))
											{
											$rotina_id = $dados["rotina_id"];
											$rotina_nome = $dados["rotina_nome"];
											
											if($correcao_rotina_id != $rotina_id)
												{
												echo "<option value='$rotina_id'>$rotina_id :: $rotina_nome ";
												}
											}
									
									echo "</select>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da correção </span>";
										echo "<input type='text' class='form-control' id='correcao_nome".$correcao_numero."' value='".$correcao_nome."'>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-2'>";
									echo "<button type='button' class='btn btn-default btn-xs' onclick='remove_correcao(".$correcao_numero.")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button>";
								echo "</div>";
								echo "<div class='col-md-10'>";
									echo "<textarea class='form-control' rows='5' id='correcao_descricao".$correcao_numero."'>".$correcao_descricao."</textarea>";
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
				echo "<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo()'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Forum do projeto - Para que sejam descutidas ideias ";
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
					echo "<div class='row' id='insere_mensagens'>";
						echo "<div class='col-md-10'>";
							echo "<input type='text' class='form-control' id='forum_mensagem'>";
						echo "</div>";
						echo "<div class='col-md-2'>";
							echo "<button type='button' class='btn btn-primary' onclick='insere_mensagem()'>";
							echo "<span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span> Inserir mensagem";
							echo "</button>";
						echo "</div>";
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
						echo "<div class='row' id='recebe_erros'>";
					
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
						
						echo "<div class='row'>";
						echo "<hr>";
							echo "<div class='col-md-4 col-md-offset-1'>";
								echo "<b> ID/Nome do erro : </b> $erro_id - $erro_nome";
							echo "</div>";
							echo "<div class='col-md-3'>";
								echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Status : </span>";
								echo "<select class='form-control' aria-describedby='sizing-addon2' id='erro_status$erro_id'>";
									echo "<option value='$erro_status'>$erro_status";
									if($erro_status != "Em andamento") {echo "<option value='Em andamento'>Em andamento";}
									if($erro_status != "Finalizado") {echo "<option value='Finalizado'>Finalizado";}
								echo "</select>";
								echo "</div>";
							echo "</div>";
							echo "<div class='col-md-3'>";
								echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Atribuido a : </span>";
								echo "<select class='form-control' aria-describedby='sizing-addon2' id='erro_usuario_id$erro_id'>";
									echo "<option value='$erro_usuario_id'>$erro_usuario_id :: $erro_usuario_nome";
									
									$consultausuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_tipo = 'Normal' ORDER BY usuario_id");
										while($dados = mysqli_fetch_array($consultausuarios))
										{
										$usuario_id = $dados["usuario_id"];
										$usuario_nome = $dados["usuario_nome"];
										
										if($erro_usuario_id != $usuario_id)
											{
											echo "<option value='$usuario_id'>$usuario_id :: $usuario_nome";
											}
										}
								echo "</select>";
								echo "</div>";
							echo "</div>";
							echo "<div class='col-md-1'>";
								echo "<input type='button' class='btn btn-primary' value='Ok' onclick='altera_erro($erro_id)'>";
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
		echo "</div>";
		}
		

	
		
	echo "</div>";
echo "</div>";
	
echo "<div class='row'>";				
echo "<button type='button' class='btn btn-primary' id='btn_SalvarProjeto' onclick='salvaedicao_projeto(".$projeto_id.")'>";
echo "<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Salvar";
echo "</button>";
echo "</div>";
echo "<br><br>";
echo "</div>";
?>