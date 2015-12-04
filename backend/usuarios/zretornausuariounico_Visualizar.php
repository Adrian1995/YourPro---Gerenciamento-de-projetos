<?php 
include('../yconectaDB.inc');


//======================================================================================================================CARREGA PERMISSÕES DO USUÁRIO
$usuario_id_atual = $_POST["usuario_id_atual"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id_atual'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_edit_usuarios_atual = $dados["usuario_edit_usuarios"];
//----------------------------------------------------------------------------------------------------------------------------------------------------


$usuario_id = $_POST["usuario_id"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_nome = $dados["usuario_nome"];
$usuario_email = $dados["usuario_email"];
$usuario_senha = $dados["usuario_senha"];
$usuario_tipo = $dados["usuario_tipo"];
$usuario_visu_projetos = $dados["usuario_visu_projetos"];
$usuario_cada_projetos = $dados["usuario_cada_projetos"];
$usuario_edit_projetos = $dados["usuario_edit_projetos"];
$usuario_excl_projetos = $dados["usuario_excl_projetos"];
$usuario_visu_usuarios = $dados["usuario_visu_usuarios"];
$usuario_cada_usuarios = $dados["usuario_cada_usuarios"];
$usuario_edit_usuarios = $dados["usuario_edit_usuarios"];
$usuario_excl_usuarios = $dados["usuario_excl_usuarios"];

$usuario_visu_solicitacao = $dados["usuario_visu_solicitacao"];
$usuario_cada_solicitacao = $dados["usuario_cada_solicitacao"];
$usuario_edit_solicitacao = $dados["usuario_edit_solicitacao"];
$usuario_excl_solicitacao = $dados["usuario_excl_solicitacao"];

$usuario_visu_rotina = $dados["usuario_visu_rotina"];
$usuario_cada_rotina = $dados["usuario_cada_rotina"];
$usuario_edit_rotina = $dados["usuario_edit_rotina"];
$usuario_excl_rotina = $dados["usuario_excl_rotina"];

$usuario_visu_configuracao = $dados["usuario_visu_configuracao"];
$usuario_edit_configuracao = $dados["usuario_edit_configuracao"];

echo "<div class='col-md-10 col-md-offset-1' id='temporario_visusuarios'>";
echo "<h3>Visualização de usuário</h3>";
echo "<br>";
echo "<div class='row'>";
echo "<div class='col-md-5'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span> <input type='text' id='usuario_nome' class='form-control' aria-describedby='sizing-addon2' value='$usuario_nome' disabled></div>";
echo "<br>";
echo "<div class='input-group'><div class='input-group-addon'><span class='glyphicon glyphicon-user' aria-hidden='true'></span> </div> <input type='text' id='usuario_email' class='form-control' placeholder='Insira o Email...' value='$usuario_email' disabled></div>";
echo "<br>";
echo "<div class='input-group'><div class='input-group-addon'><span class='glyphicon glyphicon-eye-close' aria-hidden='true'></span> </div> <input type='password' id='usuario_senha' class='form-control' placeholder='Insira a Senha...' value='$usuario_senha' disabled> </div>";
echo "<br>";
echo "<div class='input-group'><div class='input-group-addon'>Tipo</span> </div>";
	echo "<select id='usuario_tipo' class='form-control' disabled>";
	echo "<option value='$usuario_tipo'>$usuario_tipo";
	echo "</select>";
echo "</div>";
echo "<br>";
echo "</div>";

echo "<div class='col-md-3'>";
											
echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";
echo "<h4>Projetos</h4>";
echo "<input type='checkbox' id='usuario_visu_projetos'"; if($usuario_visu_projetos == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; ";
echo "<input type='checkbox' id='usuario_cada_projetos'"; if($usuario_cada_projetos == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_edit_projetos'"; if($usuario_edit_projetos == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_excl_projetos'"; if($usuario_excl_projetos == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
echo "</div>";
echo "</div>";
											
echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";
echo "<h4>Usuários</h4>";
echo "<input type='checkbox' id='usuario_visu_usuarios'"; if($usuario_visu_usuarios == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; ";
echo "<input type='checkbox' id='usuario_cada_usuarios'"; if($usuario_cada_usuarios == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_edit_usuarios'"; if($usuario_edit_usuarios == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_excl_usuarios'"; if($usuario_excl_usuarios == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
echo "</div>";
echo "</div>";

echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";
echo "<h4>Configurações</h4>";
echo "<input type='checkbox' id='usuario_visu_configuracao'"; if($usuario_visu_configuracao == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; ";
echo "<input type='checkbox' id='usuario_edit_configuracao'"; if($usuario_edit_configuracao == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "</div>";
echo "</div>";





			
echo "</div>";




echo "<div class='col-md-3'>";
											
echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";
echo "<h4>Solicitações</h4>";
echo "<input type='checkbox' id='usuario_visu_solicitacao'"; if($usuario_visu_solicitacao == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; ";
echo "<input type='checkbox' id='usuario_cada_solicitacao'"; if($usuario_cada_solicitacao == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_edit_solicitacao'"; if($usuario_edit_solicitacao == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_excl_solicitacao'"; if($usuario_excl_solicitacao == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
echo "</div>";
echo "</div>";
											
echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";
echo "<h4>Rotinas</h4>";
echo "<input type='checkbox' id='usuario_visu_rotina'"; if($usuario_visu_rotina == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; ";
echo "<input type='checkbox' id='usuario_cada_rotina'"; if($usuario_cada_rotina == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_edit_rotina'"; if($usuario_edit_rotina == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_excl_rotina'"; if($usuario_excl_rotina == "S"){echo " checked ";} echo " disabled> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
echo "</div>";
echo "</div>";
			
echo "</div>";







											
echo "</div>";

if($usuario_edit_usuarios_atual == "S")
	{
	echo "<button type='button' class='btn btn-primary' id='btn_EditarUsuario' onclick='edita_usuario(".$usuario_id.")'>";
	echo "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Editar usuário";
	echo "</button>";
	}
echo "<br><br>";


echo "<div class='row' id='recebe_tarefas'>";
	echo "<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";

	
	$consultamodulotarefas = mysqli_query($conectaBanco ,"SELECT * FROM mod_tarefas WHERE tarefa_usuario_id = '$usuario_id'");		
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
		
				
			$consultaTarefas2 = mysqli_query($conectaBanco ,"SELECT * FROM mod_tarefas WHERE tarefa_usuario_id='$usuario_id' ORDER BY tarefa_inicio");
			while ($dados = mysqli_fetch_array($consultaTarefas2))
				{
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
				
		//========================================================Grafico de Gantt		
			$consultaTarefasGrafico = mysqli_query($conectaBanco ,"SELECT * FROM mod_tarefas WHERE tarefa_usuario_id='$tarefa_usuario_id' ORDER BY tarefa_inicio");
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
					$Inicio_Tarefa = date_create("$Inicio_Tarefa");
					$Inicio_Tarefa = date_timestamp_get($Inicio_Tarefa);
					
					$Final_Tarefa = date_create("$Final_Tarefa");
					$Final_Tarefa = date_timestamp_get($Final_Tarefa);
					
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

	
	$consultamoduloerros = mysqli_query($conectaBanco ,"SELECT * FROM mod_erros WHERE erro_usuario_id = '$usuario_id'");		
	$verificamoduloerros = mysqli_num_rows($consultamoduloerros);
	if($verificamoduloerros > 0)
		{
		echo "<div class='panel panel-default' id='moduloErros'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloErros'>";
				echo "<h4 class='panel-title'>";
				echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloErros' aria-expanded='true' aria-controls='collapse_moduloErros'>";
				echo "Erros atribuidos a esse usuário";
				echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloErros' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloErros'>";
				echo "<div class='panel-body'>";
					echo "<div class='row' id='container_erros'>";
					
					$consultaerros = mysqli_query($conectaBanco ,"SELECT * FROM mod_erros WHERE erro_usuario_id ='$usuario_id' and erro_status <> 'Finalizado' ORDER BY erro_projeto_id");

					while ($dados = mysqli_fetch_array($consultaerros))
						{
						$erro_id = $dados["erro_id"];
						$erro_projeto_id = $dados["erro_projeto_id"];
						$erro_usuario_id = $dados["erro_usuario_id"];
						$erro_status = $dados["erro_status"];
						$erro_nome = $dados["erro_nome"];
						$erro_descricao = $dados["erro_descricao"];
						$erro_imagem1 = $dados["erro_imagem1"];
						$erro_imagem2 = $dados["erro_imagem2"];
						$erro_imagem3 = $dados["erro_imagem3"];
						$erro_imagem4 = $dados["erro_imagem4"];
						$erro_imagem5 = $dados["erro_imagem5"];
						
						$consultaprojeto = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_id='$erro_projeto_id'");
						$dadosprojeto = mysqli_fetch_array($consultaprojeto);
						$erro_projeto_nome = $dadosprojeto["projeto_nome"];
						
						$consultausuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$erro_usuario_id'");
						$dados = mysqli_fetch_array($consultausuario);
						$erro_usuario_nome = $dados["usuario_nome"];
						
						echo "<hr>";
						echo "<div class='row'>";
							echo "<div class='col-md-10 col-md-offset-1'>";
								echo "<b>Erro atribuido ao projeto : </b> $erro_projeto_id - $erro_projeto_nome";
							echo "</div>";
						echo "</div>";
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
		

	$consultasolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_usuario = '$usuario_id'");		
	$verificasolicitacoes = mysqli_num_rows($consultasolicitacoes);
	if($verificasolicitacoes > 0)
		{
		echo "<div class='panel panel-default' id='moduloSolicitacoes'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloSolicitacoes'>";
				echo "<h4 class='panel-title'>";
				echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloSolicitacoes' aria-expanded='true' aria-controls='collapse_moduloSolicitacoes'>";
				echo "Solicitações feitas por esse usuário";
				echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloSolicitacoes' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloSolicitacoes'>";
				echo "<div class='panel-body'>";
					echo "<div class='row' id='container_solicitacoes'>";
					
					$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_usuario = '$usuario_id' ORDER BY solicitacao_id DESC");
	
					echo "<table class='table'>";
					echo "<thead><th>id</th><th>nome</th><th>data</th><th>status</th></thead>";
					while ($dados = mysqli_fetch_array($consultaSolicitacoes))
						{
						$solicitacao_id = $dados["solicitacao_id"];
						$solicitacao_nome = $dados["solicitacao_nome"];
						$solicitacao_data = $dados["solicitacao_data"];
						$solicitacao_status = $dados["solicitacao_status"];
						
						$solicitacao_data = date_create("$solicitacao_data");
						$solicitacao_data = (date_format($solicitacao_data, "d/m/Y H:i"));
						
						echo "<tbody><td>$solicitacao_id</td><td>$solicitacao_nome</td><td>$solicitacao_data</td><td>$solicitacao_status</td></tbody>";
						}
					echo "</table>";
					
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		}
		
		
		
		
	echo "</div>";
echo "</div>";



echo "</div>";
?>