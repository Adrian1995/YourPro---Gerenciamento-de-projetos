<?php
	include ("includes/yverificaAcessoCookie.inc");
?>
<html>
<head>
	<?php	include ("includes/yhead.inc");	?>
</head>
<body>
	<?php	include ("includes/ymenu.inc");	?>
	<?php
	include('backend/yconectaDB.inc');

	//======================================================================================================================CARREGA PERMISSÕES DO USUÁRIO
	$usuario_id_atual = $ID;

	$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id_atual'");
	$dados = mysqli_fetch_array($consultaUsuarios);
	$usuario_visu_projetos_atual = $dados["usuario_visu_projetos"];
	$usuario_cada_projetos_atual = $dados["usuario_cada_projetos"];
	
	//======================================================================================================================CONSULTA CONFIGURAÇÕES

	$consultaConfiguracoes = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes");
	$dadosconfig = mysqli_fetch_array($consultaConfiguracoes);
	$exige_solicitacaonoprojeto = $dadosconfig["exige_solicitacaonoprojeto"];
	?>


<div class="container-fluid">
	<div class="row" id="container_mensagens">
		<?php if($usuario_visu_projetos_atual == "N")
			{
			echo "<div id='temporario_mensagens'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Erro ao acessar...</strong> Você não possui acesso a visualização de projetos!</div></div>";
			}
		?>
	</div>	
	
	<div class="row" id="carregando"><h5><img src='img/carregando.gif'>  Carregando...</h5></div>
	
	<div class="row" id="container_botoesprojetos" <?php if($usuario_cada_projetos_atual == "N" or $usuario_visu_projetos_atual == "N"){echo "hidden";}?>>
		<div class="col-md-3">
			<button type="button" class="btn btn-default" id="btn_NovoProjeto" onclick="abreformulario_novoprojeto()">
			  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Novo projeto
			</button>
			<a href="relatarerro.php?ID=<?php echo $ID; ?>&Sessao=<?php echo $Sessao; ?>" class="btn btn-default"> Relatar erro </a>
		</div>
	</div>
	<div class="row" id="container_cadprojetos">
	</div>
	<div class="row" id="container_visuprojetos">
	</div>
	<div class="row" id="container_editprojetos">
	</div>
	<div class="row" id="container_pesquisaprojetos" <?php if($usuario_visu_projetos_atual == "N"){echo "hidden";}?>>
		<div class="col-md-6 col-md-offset-1">
			<br>
			Pesquisar projetos por:&nbsp;&nbsp;
			<input type="radio" name="pesquisaprojetos" id="id" checked onchange="alterainputpesquisa('text')"><label for="id"> &nbsp;ID</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisaprojetos" id="nome" onchange="alterainputpesquisa('text')"><label for="nome"> &nbsp;Nome</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisaprojetos" id="tipo" onchange="alterainputpesquisa('selecttipo')"><label for="tipo"> &nbsp;Tipo</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisaprojetos" id="status" onchange="alterainputpesquisa('selectstatus')"><label for="status"> &nbsp;Status</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisaprojetos" id="iniciodata" onchange="alterainputpesquisa('datainicio')"><label for="iniciodata"> &nbsp;Início</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisaprojetos" id="finaldata" onchange="alterainputpesquisa('datafinal')"><label for="finaldata"> &nbsp;Final</label><br>
			<div id="container_textopesquisa">
				<input type="text" id="textopesquisa" class="form-control">
			</div>
		</div>
		<div class="col-md-3">
			<br>
			<br>
			<button type="button" class="btn btn-default" id="btn_pesquisarprojetos" onclick="retornaprojetos('S', '')">
			  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
			</button>
		</div>
	</div>

	<div class="row" id="conteiner_exibeprojetos" <?php if($usuario_visu_projetos_atual == "N"){echo "hidden";}?>>
		<div class="col-md-10 col-md-offset-1">
			<div id="container_projetos">
			</div>
		</div>
	</div>
</div>
	
	
	
<script>
$(document).ready(function() 
	{
	$("#projetos").addClass("active");
	
	retornaprojetos('N', '');
	});
	
	//===========================================================================Pesquisa de projetos
	function alterainputpesquisa(tipocampo)
		{
		$("#textopesquisa").remove();
		$("#textopesquisadata").remove();
		
		if(tipocampo == "text")
			{
			$("#container_textopesquisa").append("<input type='text' id='textopesquisa' class='form-control'>");
			}
		if(tipocampo == "selecttipo")
			{
			$("#container_textopesquisa").append("<select class='form-control' aria-describedby='sizing-addon2' id='textopesquisa'>"+
														"<option value='Novo'>Novo"+
														"<option value='Alteração'>Alteração"+
														"<option value='Correção'>Correção"+
													"</select></div>");
			}
		if(tipocampo == "selectstatus")
			{
			$("#container_textopesquisa").append("<select class='form-control' aria-describedby='sizing-addon2' id='textopesquisa'>"+
														"<option value='Aguardando'>Aguardando"+
														"<option value='Em andamento'>Em andamento"+
														"<option value='Finalizado'>Finalizado"+
													"</select></div>");
			}
		if(tipocampo == "datainicio")
			{
			$("#container_textopesquisa").append("<div class='row' id='textopesquisadata'>"+
												"<div class='col-md-1'>"+
													"<h4>Entre</h4>"+
												"</div>"+
												"<div class='col-md-5'>"+
													"<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='textopesquisaD1'>"+
												"</div>"+
												"<div class='col-md-1'>"+
													"<h4> e </h4>"+
												"</div>"+
												"<div class='col-md-5'>"+
													"<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='textopesquisaD2'>"+
												"</div>"+
												"</div>");
			}
		if(tipocampo == "datafinal")
			{
			$("#container_textopesquisa").append("<div class='row' id='textopesquisadata'>"+
												"<div class='col-md-1'>"+
													"<h4>Entre</h4>"+
												"</div>"+
												"<div class='col-md-5'>"+
													"<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='textopesquisaD1'>"+
												"</div>"+
												"<div class='col-md-1'>"+
													"<h4> e </h4>"+
												"</div>"+
												"<div class='col-md-5'>"+
													"<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='textopesquisaD2'>"+
												"</div>"+
												"</div>");
			}
		}
	
	function retornaprojetos(pesquisa, paginasolicitada)
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		var textopesquisa = $("#textopesquisa").val();
		
		if(textopesquisa == "")
			{
			pesquisa = "N";
			}
		
		if($("#id").is(":checked"))	{var id = "S";}
		else						{var id = "N";}
		
		if($("#nome").is(":checked"))	{var nome = "S";}
		else							{var nome = "N";}
		
		if($("#tipo").is(":checked"))	{var tipo = "S";}
		else							{var tipo = "N";}
		
		if($("#status").is(":checked"))	{var status = "S";}
		else							{var status = "N";}
		
		if($("#iniciodata").is(":checked"))	
			{
			var textopesquisaD1 = $("#textopesquisaD1").val();
			var textopesquisaD2 = $("#textopesquisaD2").val();
			
			if(textopesquisaD1 == "")
				{
				exibemensagem("Campo Início deve ser preenchido completamente!", "alert");
				
				$("#textopesquisaD1").val("");
				}
			if(textopesquisaD2 == "")
				{
				exibemensagem("Campo Final deve ser preenchido completamente!", "alert");
				
				$("#textopesquisaD2").val("");
				}
				
			if(textopesquisaD1 != "" & textopesquisaD2 != "")
				{
				if(textopesquisaD1 > textopesquisaD2)
					{
					$("#temporario_mensagens").remove();
					$("#container_mensagens").append("<div id='temporario_mensagens'><div class='alert alert-danger alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data inicial não pode ser maior que a data final!</div></div>");
					}
				}
			
			textopesquisa = textopesquisaD1+textopesquisaD2;
			
			var iniciodata = "S";
			}
		else{var iniciodata = "N";}
		
		if($("#finaldata").is(":checked"))	
			{
			var textopesquisaD1 = $("#textopesquisaD1").val();
			var textopesquisaD2 = $("#textopesquisaD2").val();
			
			if(textopesquisaD1 == "")
				{
				exibemensagem("Campo Início deve ser preenchido completamente!", "alert");
				
				$("#textopesquisaD1").val("");
				}
			else if(textopesquisaD2 == "")
				{
				exibemensagem("Campo Final deve ser preenchido completamente!", "alert");
				
				$("#textopesquisaD2").val("");
				}
				
			textopesquisa = textopesquisaD1+textopesquisaD2;
			
			var finaldata = "S";
			}
		else{var finaldata = "N";}
		
		$.ajax({
				type: 'POST',
				url: 'backend/projetos/zretornaprojetos.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						pesquisa: pesquisa,
						textopesquisa: textopesquisa,
						id: id,
						nome: nome,
						tipo: tipo,
						status: status,
						iniciodata: iniciodata,
						finaldata: finaldata,
						paginasolicitada: paginasolicitada},
				async: false
				})
			.done(function(dados)
				{
				$("#carregando").hide();
				$("#temporario_projetos").remove();
				$("#container_projetos").append("<div id='temporario_projetos'><h3>Projetos</h3>"+dados+"</div>");
				});
		}

		
		
	//===========================================================================Retorna página de Cadastro de Projeto	
	function abreformulario_novoprojeto()
		{
		$("#container_botoesprojetos").hide();
		$("#container_pesquisaprojetos").hide();
		$("#conteiner_exibeprojetos").hide();
		
		$("#container_cadprojetos").append("<div class='col-md-10 col-md-offset-1' id='temporario_cadprojetos'>"+
											"<h3>Cadastro de novo projeto</h3>"+
											"<br>"+
											"<div class='row'>"+
											
											"<div class='col-md-6'>"+
											"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span>"+
											"<input type='text' class='form-control' aria-describedby='sizing-addon2' id='projeto_nome'>"+
											"</div>"+
											"<br>"+
											"<textarea class='form-control' rows='10' id='projeto_descricao' placeholder='Insira a descrição do projeto...'></textarea>"+
											"<br>"+
											"</div>"+
											
											"<div class='col-md-6'>"+
											"<div class='row'>"+
											"<div class='col-md-6'>"+
											"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Tipo</span>"+
											"<select class='form-control' aria-describedby='sizing-addon2' id='projeto_tipo'><?php
											
											$consultaTipos = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes_tipos");
											while($dados = mysqli_fetch_array($consultaTipos))
												{
												$tipo_nome = $dados["tipo_nome"];
												
												echo "<option value='$tipo_nome'>$tipo_nome";
												}
											?></select>"+
											"</div>"+
											"<br>"+
											"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Status</span>"+
											"<select class='form-control' aria-describedby='sizing-addon2' id='projeto_status'><?php
											
											$consultaStatus = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes_status_projetos");
											while($dados = mysqli_fetch_array($consultaStatus))
												{
												$status_nome = $dados["status_nome"];
												
												echo "<option value='$status_nome'>$status_nome";
												}
											?></select></div>"+
											"<br>"+
											"</div>"+
											
											"<div class='col-md-6'>"+
											"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Início</span>"+
											"<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='projeto_inicio'>"+
											"</div>"+
											"<br>"+
											"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Final</span>"+
											"<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='projeto_final'>"+
											"</div>"+
											"<br>"+
											"</div>"+
											"</div>"+
											"</div>"+
											"<div class='row'>"+
											"<div class='col-md-6'>"+
											"<br>"+
											"<br>"+
											"<div class='panel panel-default'>"+
												"<div class='panel-body'>"+
													"<select class='form-control' aria-describedby='sizing-addon2' id='select_modulo'>"+
														"<option value=''>Selecione..."+
														"<option value='Tarefas'>Tarefas - Atribuir tarefas para os usuários"+
														"<option value='Solicitacao'>Solicitação - Vincule uma solicitação a esse projeto"+
														"<option value='Inovacao'>Inovação - Para criação de novas funções/rotinas"+
														"<option value='Alteracao'>Alteração - Para alteração de funções/rotinas"+
														"<option value='Correcao'>Correção - Para correção de funções/rotinas"+
													"</select>"+
													"<br>"+
													"<button type='button' class='btn btn-default' id='btn_AdicionaModulo' onclick='adiciona_modulo()'>"+
													"<span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span> Adicionar modulo"+
													"</button>"+
												"</div>"+
											"</div>"+
											"</div>"+
											"</div>"+
											"</div>"+
											"<div class='row' id='container_modulos'>"+
												"<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>"+
												"</div>"+
											"</div>"+
											"<div class='row'>"+
											"<button type='button' class='btn btn-primary' id='btn_SalvarProjeto' onclick='salvar_novoprojeto()'>"+
											"<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Salvar"+
											"</button>"+
											"</div>"+
											"<br><br></div>");
		}
	
	//===========================================================================Retorna página de Visualização de Projeto
	function visualiza_projeto(projeto_id)
		{
		$("#container_botoesprojetos").hide();
		$("#container_pesquisaprojetos").hide();
		$("#conteiner_exibeprojetos").hide();
		$("#temporario_mensagens").remove();
		
		$.ajax({
				type: 'POST',
				url: 'backend/projetos/zretornaprojetounico_Visualizar.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						projeto_id: projeto_id},
				async: false
				})
			.done(function(dados)
				{
				$("#temporario_visuprojetos").remove();
				$("#container_visuprojetos").append(dados);
				});
		}
	
	//===========================================================================Retorna página de Edição de Projeto
	function edita_projeto(projeto_id)
		{
		$("#container_botoesprojetos").hide();
		$("#container_pesquisaprojetos").hide();
		$("#conteiner_exibeprojetos").hide();
		$("#temporario_mensagens").remove();
		$("#temporario_visuprojetos").remove();
		
		$.ajax({
				type: 'POST',
				url: 'backend/projetos/zretornaprojetounico_Editar.php',
				data: {	projeto_id: projeto_id},
				async: false
				})
			.done(function(dados)
				{
				$("#temporario_editprojetos").remove();
				$("#container_editprojetos").append(dados);
				});
		}
		

		
		
		
	//===========================================================================Gerenciador de Modulos - Cadastro	
	function adiciona_modulo()
		{
		var modulo = $("#select_modulo").val();
		
		if(modulo == "Tarefas")
			{
			if($("#moduloTarefas").length)
				{
				exibemensagem("Modulo já existe!", "alert");
				}
			else
				{
				var modulo = '"moduloTarefas"';
				$("#container_modulos #accordion").append(	"<div class='panel panel-default' id='moduloTarefas'>"+
																"<div class='panel-heading' role='tab' id='heading_moduloTarefas'>"+
																	"<h4 class='panel-title'>"+
																		"<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloTarefas' aria-expanded='true' aria-controls='collapse_moduloTarefas'>"+
																		"<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo("+modulo+")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Tarefas - Atribuir tarefas para os usuários "+
																		"</a>"+
																	"</h4>"+
																"</div>"+
																"<div id='collapse_moduloTarefas' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloTarefas'>"+
																	"<div class='panel-body'>"+
																	"<div class='row'>"+
																		"<div class='col-md-7 col-md-offset-0'>"+
																			"<b> Nome da tarefa </b>"+
																			"<input type='text' class='form-control' id='tarefa_nome' placeholder='Insira o nome da tarefa...'>"+
																			"<br>"+
																			"<textarea class='form-control' rows='6' id='tarefa_descricao' placeholder='Insira a descrição da tarefa...'></textarea>"+
																		"</div>"+
																		"<div class='col-md-5 col-md-offset-0'>"+
																			"<b> Atribuída ao usuário </b>"+
																			"<select id='tarefa_usuario_id' class='form-control'>"+
																				"<option value=''>Selecione o usuário para a tarefa... <?php
																				$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login");
																				while ($dados = mysqli_fetch_array($consultaUsuarios))
																					{
																					$usuario_id = $dados["usuario_id"];
																					$usuario_nome = $dados["usuario_nome"];
																					
																					echo "<option value='$usuario_id'>$usuario_nome";
																					}
																				?> </select>"+
																				"<br>"+
																				"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Início da tarefa</span>"+
																				"<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='tarefa_inicio'>"+
																				"</div>"+
																				"<br>"+
																				"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Final da tarefa</span>"+
																				"<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='tarefa_final'>"+
																				"</div>"+
																				"<br>"+
																				"<button type='button' class='btn btn-primary' id='btn_Incluirtarefa' onclick='adiciona_tarefa()'>"+
																				"<span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span> Adicionar tarefa"+
																				"</button>"+
																		"</div>"+
																	"</div>"+
																	"<br>"+
																	"<div class='row' id='recebe_linhas_tarefas'>"+
																	"</div>"+
																	"</div>"+
																"</div>"+
															"</div>");
				}
			}
		
		if(modulo == "Solicitacao")
			{
			if($("#moduloSolicitacao").length)
				{
				exibemensagem("Modulo já existe!", "alert");
				}
			else
				{
				var modulo = '"moduloSolicitacao"';
				$("#container_modulos #accordion").append(	"<div class='panel panel-default' id='moduloSolicitacao'>"+
																"<div class='panel-heading' role='tab' id='heading_moduloSolicitacao'>"+
																	"<h4 class='panel-title'>"+
																		"<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloSolicitacao' aria-expanded='true' aria-controls='collapse_moduloSolicitacao'>"+
																		"<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo("+modulo+")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Solicitação - Vincule uma solicitação a esse projeto "+
																		"</a>"+
																	"</h4>"+
																"</div>"+
																"<div id='collapse_moduloSolicitacao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloSolicitacao'>"+
																	"<div class='panel-body'>"+
																	"<div class='row'>"+
																		"<div class='col-md-7 col-md-offset-0'>"+
																			"<b> Selecione o nome da solicitação </b>"+
																			"<select id='projeto_solicitacao_id' class='form-control' onchange='retorna_info_solicitacao()'>"+
																				"<option value=''>Selecione a solicitação... <?php
																				$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes ORDER BY solicitacao_id DESC");
																				while ($dados = mysqli_fetch_array($consultaSolicitacoes))
																					{
																					$solicitacao_id = $dados["solicitacao_id"];
																					$solicitacao_nome = $dados["solicitacao_nome"];
																					
																					echo "<option value='$solicitacao_id'>$solicitacao_id :: $solicitacao_nome";
																					}
																			?> </select>"+
																		"</div>"+
																		"<div class='col-md-4 col-md-offset-0'>"+
																			"<b> Ou insira o ID da mesma </b><br>"+
																			"<input type='number' id='seleciona_id_solicitacao' class='form-control' onchange='seleciona_solicitacao_por_id()'>"+
																		"</div>"+
																	"</div>"+
																	"<div class='row' id='container_info_solicitacao'>"+
																	"</div>"+
																"</div>"+
															"</div>");
				}
			}
		
		if(modulo == "Inovacao")
			{
			if($("#moduloInovacao").length)
				{
				exibemensagem("Modulo já existe!", "alert");
				}
			else
				{
				var modulo = '"moduloInovacao"';
				$("#container_modulos #accordion").append(	"<div class='panel panel-default' id='moduloInovacao'>"+
																"<div class='panel-heading' role='tab' id='heading_moduloInovacao'>"+
																	"<h4 class='panel-title'>"+
																		"<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloInovacao' aria-expanded='true' aria-controls='collapse_moduloInovacao'>"+
																		"<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo("+modulo+")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Inovação - Para criação de novas funções/rotinas "+
																		"</a>"+
																	"</h4>"+
																"</div>"+
																"<div id='collapse_moduloInovacao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloInovacao'>"+
																	"<div class='panel-body'>"+
																	"<div class='row'>"+
																		"<div class='col-md-9 col-md-offset-1'>"+
																			"<b>Nome da nova função/rotina:</b>"+
																			"<input type='text' class='form-control' id='inovacao_rotina_nome'>"+
																			"<b>Descrição da nova função/rotina</b>"+
																			"<textarea class='form-control' rows='5' id='inovacao_rotina_descricao'></textarea>"+
																		"</div>"+
																		"<div class='col-md-2'>"+
																			"<br>"+
																			"<button type='button' class='btn btn-primary' id='btn_Incluirinovacao' onclick='adiciona_inovacao()'>"+
																			"<span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span> Adicionar inovação"+
																			"</button>"+
																		"</div>"+
																	"</div>"+
																	"<div class='row' id='container_inovacao'>"+
																	"</div>"+
																"</div>"+
															"</div>");
				}
			}
		
		if(modulo == "Alteracao")
			{
			if($("#moduloAlteracao").length)
				{
				exibemensagem("Modulo já existe!", "alert");
				}
			else
				{
				var modulo = '"moduloAlteracao"';
				$("#container_modulos #accordion").append(	"<div class='panel panel-default' id='moduloAlteracao'>"+
																"<div class='panel-heading' role='tab' id='heading_moduloAlteracao'>"+
																	"<h4 class='panel-title'>"+
																		"<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloAlteracao' aria-expanded='true' aria-controls='collapse_moduloAlteracao'>"+
																		"<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo("+modulo+")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Alteração - Para alteração de funções/rotinas "+
																		"</a>"+
																	"</h4>"+
																"</div>"+
																"<div id='collapse_moduloAlteracao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloAlteracao'>"+
																	"<div class='panel-body'>"+
																	"<div class='row'>"+
																		"<div class='col-md-10'>"+
																			"<b> Selecione a rotina que será alterada </b>"+
																			"<select id='alteracao_rotina_id' class='form-control' onchange='retorna_info_alteracao()'>"+
																				"<option value=''>Selecione a rotina... <?php
																				$consultaRotinas = mysqli_query($conectaBanco ,"SELECT * FROM rotinas ORDER BY rotina_id DESC");
																				while ($dados = mysqli_fetch_array($consultaRotinas))
																					{
																					$rotina_id = $dados["rotina_id"];
																					$rotina_nome = $dados["rotina_nome"];
																					
																					echo "<option value='$rotina_id'>$rotina_id :: $rotina_nome";
																					}
																			?> </select>"+
																			"<input type='text' class='form-control' placeholder='Nome da alteração...' id='alteracao_nome'>"+
																		"</div>"+
																		"<div class='col-md-2'>"+
																			"<br>"+
																			"<button type='button' class='btn btn-primary' id='btn_Incluiralteracao' onclick='adiciona_alteracao()'>"+
																			"<span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span> Adicionar alteração"+
																			"</button>"+
																		"</div>"+
																	"</div>"+
																	"<div class='row'>"+
																		"<br>"+
																		"<div class='col-md-3'>"+
																			"<textarea class='form-control' rows='5' placeholder='Como era antes das alterações...' id='alteracao_antes'></textarea>"+
																		"</div>"+
																		"<div class='col-md-3'>"+
																			"<textarea class='form-control' rows='5' placeholder='Como ficará depois das alterações...' id='alteracao_depois'></textarea>"+
																		"</div>"+
																		"<div class='col-md-4'>"+
																			"<textarea class='form-control' rows='5' placeholder='Qual o objetivo da alteração...' id='alteracao_objetivo'></textarea>"+
																		"</div>"+
																	"</div>"+
																	"<div class='row' id='container_alteracao'>"+
																	"</div>"+
																	"</div>"+
																"</div></div>");
				}
		
		
			}
		
		if(modulo == "Correcao")
			{
			if($("#moduloCorrecao").length)
				{
				exibemensagem("Modulo já existe!", "alert");
				}
			else
				{
				var modulo = '"moduloCorrecao"';
				$("#container_modulos #accordion").append(	"<div class='panel panel-default' id='moduloCorrecao'>"+
																"<div class='panel-heading' role='tab' id='heading_moduloCorrecao'>"+
																	"<h4 class='panel-title'>"+
																		"<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloCorrecao' aria-expanded='true' aria-controls='collapse_moduloCorrecao'>"+
																		"<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo("+modulo+")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Correção - Para correção de funções/rotinas "+
																		"</a>"+
																	"</h4>"+
																"</div>"+
																"<div id='collapse_moduloCorrecao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloCorrecao'>"+
																	"<div class='panel-body'>"+
																	"<div class='row'>"+
																		"<div class='col-md-9 col-md-offset-1'>"+
																		
																			"<b> Selecione a rotina que será corrigida </b>"+
																			"<select id='correcao_rotina_id' class='form-control'>"+
																				"<option value=''>Selecione a rotina... <?php
																				$consultaRotinas = mysqli_query($conectaBanco ,"SELECT * FROM rotinas ORDER BY rotina_id DESC");
																				while ($dados = mysqli_fetch_array($consultaRotinas))
																					{
																					$rotina_id = $dados["rotina_id"];
																					$rotina_nome = $dados["rotina_nome"];
																					
																					echo "<option value='$rotina_id'>$rotina_id :: $rotina_nome";
																					}
																			?> </select>"+
																		
																		
																			"<b>Nome da correção:</b>"+
																			"<input type='text' class='form-control' id='correcao_nome'>"+
																			"<b>Descrição da correção</b>"+
																			"<textarea class='form-control' rows='5' id='correcao_descricao'></textarea>"+
																		"</div>"+
																		"<div class='col-md-2'>"+
																			"<br>"+
																			"<button type='button' class='btn btn-primary' onclick='adiciona_correcao()'>"+
																			"<span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span> Adicionar correção"+
																			"</button>"+
																		"</div>"+
																	"</div>"+
																	"<div class='row' id='container_correcao'>"+
																	"</div>"+
																"</div>"+
															"</div>");
				}
			}
		
		if(modulo == "Forum")
			{
			if($("#moduloForum").length)
				{
				exibemensagem("Modulo já existe!", "alert");
				}
			else
				{
				var modulo = '"moduloForum"';
				$("#container_modulos #accordion").append(	"<div class='panel panel-default' id='moduloForum'>"+
																"<div class='panel-heading' role='tab' id='heading_moduloForum'>"+
																	"<h4 class='panel-title'>"+
																		"<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloForum' aria-expanded='true' aria-controls='collapse_moduloForum'>"+
																		"<button type='button' class='btn btn-default btn-xs' onclick='remove_modulo("+modulo+")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button> &nbsp; &nbsp; Forum do projeto - Para que sejam descutidas ideias "+
																		"</a>"+
																	"</h4>"+
																"</div>"+
																"<div id='collapse_moduloForum' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloForum'>"+
																	"<div class='panel-body'>"+
																	"<div class='row' id='container_mensagensforum'>"+
																	"</div>"+
																	"<div class='row' id='insere_mensagens'>"+
																		"<div class='col-md-10'>"+
																			"<input type='text' class='form-control' id='forum_mensagem'>"+
																		"</div>"+
																		"<div class='col-md-2'>"+
																			"<button type='button' class='btn btn-primary' onclick='insere_mensagem()'>"+
																			"<span class='glyphicon glyphicon-screenshot' aria-hidden='true'></span> Inserir mensagem"+
																			"</button>"+
																		"</div>"+
																	"</div>"+
																"</div>"+
															"</div></div>");
				
				retorna_mensagens();
				}
			}
		}
	function remove_modulo(modulo)
		{
		$("#"+modulo).remove();
		}
	






	//===========================================================================Modulo Tarefas
	function adiciona_tarefa()
		{
		if($("#moduloTarefas #ultimoregistro").length)
			{
			var ultimoregistro = $("#moduloTarefas #ultimoregistro").val();
			var ultimoregistro = parseInt(ultimoregistro);
			$("#moduloTarefas #ultimoregistro").val(ultimoregistro + 1);
			}
		else
			{
			$("#moduloTarefas").append("<input type='hidden' id='ultimoregistro' value='1'>");
			}
			
		var tarefa_numero = $("#moduloTarefas #ultimoregistro").val();
		var tarefa_nome = $("#tarefa_nome").val();
		var tarefa_descricao = $("#tarefa_descricao").val();
		var tarefa_usuario_id = $("#tarefa_usuario_id").val();
		var tarefa_inicio = $("#tarefa_inicio").val();
		var tarefa_final = $("#tarefa_final").val();
		
		if(tarefa_nome == "")
			{
			exibemensagem("Campo Nome do Tarefa é obrigatório!", "alert");
			var continuar_adicionar_tarefa = "N";
			}
		else if(tarefa_inicio != "" & tarefa_final != "")
			{
			if(tarefa_inicio > tarefa_final)
				{
				exibemensagem("Início da tarefa não pode ser maior que o final da tarefa!", "alert");
				var continuar_adicionar_tarefa = "N";
				}
			else
				{
				var continuar_adicionar_tarefa = "S";
				}
			}
		else
			{
			var continuar_adicionar_tarefa = "S";
			}
		
		if(continuar_adicionar_tarefa == "S")
			{
			$("#recebe_linhas_tarefas").append( "<div class='row' id='container_tarefa"+tarefa_numero+"'>"+
												"<br>"+
												"<div class='col-md-6 col-md-offset-0'>"+
													"<div class='col-md-4'>"+
														"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>ID </span>"+
															"<input type='text' class='form-control' id='tarefa_numero"+tarefa_numero+"' value='"+tarefa_numero+"' disabled>"+
														"</div>"+
													"</div>"+
													"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Atribuída a </span>"+
														"<select id='tarefa_usuario_id_banco"+tarefa_numero+"' class='form-control'>"+
															"<option value=''>Selecione o usuário para a tarefa... <?php
															$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login");
															while ($dados = mysqli_fetch_array($consultaUsuarios))
																{
																$usuario_id = $dados["usuario_id"];
																$usuario_nome = $dados["usuario_nome"];
																				
																echo "<option value='$usuario_id'>$usuario_nome";
																				}
														?> </select>"+
													"</div>"+
													"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da tarefa </span>"+
														"<input type='text' class='form-control' id='tarefa_nome_banco"+tarefa_numero+"' value='"+tarefa_nome+"'>"+
													"</div>"+
													"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Início </span>"+
														"<input type='datetime-local' class='form-control' id='tarefa_inicio_banco"+tarefa_numero+"' value='"+tarefa_inicio+"'>"+
													"</div>"+
													"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Final </span>"+
														"<input type='datetime-local' class='form-control' id='tarefa_final_banco"+tarefa_numero+"' value='"+tarefa_final+"'>"+
													"</div>"+
												"</div>"+
												"<div class='col-md-6 col-md-offset-0'>"+
													"<b>Descrição</b>&nbsp;&nbsp; <button type='button' class='btn btn-default btn-xs' onclick='remove_tarefa("+tarefa_numero+")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button>"+
													"<textarea class='form-control' rows='5' id='tarefa_descricao_banco"+tarefa_numero+"'>"+tarefa_descricao+"</textarea>"+
												"</div>"+
												"</div>");
											
											$("#tarefa_usuario_id_banco"+tarefa_numero).val(tarefa_usuario_id);
			}
		}
	function remove_tarefa(tarefa_numero)
		{
		$("#container_tarefa"+tarefa_numero).remove();
		}

	//===========================================================================Modulo Solicitação
	function seleciona_solicitacao_por_id()
		{
		var numero_solicitacao_id = $("#seleciona_id_solicitacao").val();
		
		$("#projeto_solicitacao_id").val(numero_solicitacao_id);
		
		retorna_info_solicitacao()
		}
	function retorna_info_solicitacao()
		{
		var solicitacao_id = $("#projeto_solicitacao_id").val();
		
		$.ajax({
				type: 'POST',
				url: 'backend/solicitacoes/zretornasolicitacaoparaprojeto.php',
				data: {	solicitacao_id: solicitacao_id},
				async: false
				})
			.done(function(dados)
				{
				if(dados == "SOLICITACAONAOEXISTE")
					{
					exibemensagem("Não existe solicitação com esse ID", "alert");
					$("#seleciona_id_solicitacao").val("");
					$("#projeto_solicitacao_id").val("");
					}
				else
					{
					$("#recebe_info_solicitacao").remove();
					$("#container_info_solicitacao").append(dados);
					}
				});
		}
	
	//===========================================================================Modulo Inovação
	function adiciona_inovacao()
		{
		if($("#moduloInovacao #ultimoregistro").length)
			{
			var ultimoregistro = $("#moduloInovacao #ultimoregistro").val();
			var ultimoregistro = parseInt(ultimoregistro);
			$("#moduloInovacao #ultimoregistro").val(ultimoregistro + 1);
			}
		else
			{
			$("#moduloInovacao").append("<input type='hidden' id='ultimoregistro' value='1'>");
			}
			
		var inovacao_numero = $("#moduloInovacao #ultimoregistro").val();
		var inovacao_rotina_nome = $("#inovacao_rotina_nome").val();
		var inovacao_rotina_descricao = $("#inovacao_rotina_descricao").val();
		
		if(inovacao_rotina_nome == "")
			{
			exibemensagem("Campo Nome da inovação é obrigatório!", "alert");
			var continuar_adicionar_inovacao = "N";
			}
		else
			{
			var continuar_adicionar_inovacao = "S";
			}
		
		if(continuar_adicionar_inovacao == "S")
			{
			$("#container_inovacao").append( "<div class='row' id='container_inovacao"+inovacao_numero+"'>"+
												"<br>"+
												"<div class='col-md-10 col-md-offset-1'>"+
													"<div class='col-md-2'>"+
														"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>ID </span>"+
															"<input type='text' class='form-control' id='inovacao_numero"+inovacao_numero+"' value='"+inovacao_numero+"' disabled>"+
														"</div>"+
													"</div>"+
													"<div class='col-md-8'>"+
														"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da inovação </span>"+
															"<input type='text' class='form-control' id='inovacao_rotina_nome"+inovacao_numero+"' value='"+inovacao_rotina_nome+"'>"+
														"</div>"+
													"</div>"+
													"<div class='col-md-2'>"+
														"<button type='button' class='btn btn-default btn-xs' onclick='remove_inovacao("+inovacao_numero+")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button>"+
													"</div>"+
													"<div class='col-md-10'>"+
														"<textarea class='form-control' rows='5' id='inovacao_rotina_descricao"+inovacao_numero+"'>"+inovacao_rotina_descricao+"</textarea>"+
													"</div>"+
												"</div>"+
												"</div>");
			}
		}
	function remove_inovacao(inovacao_numero)
		{
		$("#container_inovacao"+inovacao_numero).remove();
		}

	//===========================================================================Modulo Alteração
	function retorna_info_alteracao(alteracaonumero)
		{
		if (typeof alteracaonumero == "undefined") 
			{
			alteracaonumero = "";
			}
		
		var alteracao_rotina_id = $("#alteracao_rotina_id"+alteracaonumero).val();
		
		$.ajax({
				type: 'POST',
				url: 'backend/projetos/modulos/zretornadescricaoparaalteracao.php',
				data: {	alteracao_rotina_id: alteracao_rotina_id},
				async: false
				})
			.done(function(dados)
				{
				$("#alteracao_antes"+alteracaonumero).val(dados);
				});
		}
		
	function adiciona_alteracao()
		{
		if($("#moduloAlteracao #ultimoregistro").length)
			{
			var ultimoregistro = $("#moduloAlteracao #ultimoregistro").val();
			var ultimoregistro = parseInt(ultimoregistro);
			$("#moduloAlteracao #ultimoregistro").val(ultimoregistro + 1);
			}
		else
			{
			$("#moduloAlteracao").append("<input type='hidden' id='ultimoregistro' value='1'>");
			}
			
		var alteracao_numero = $("#moduloAlteracao #ultimoregistro").val();
		var alteracao_rotina_id = $("#alteracao_rotina_id").val();
		var alteracao_nome = $("#alteracao_nome").val();
		var alteracao_antes = $("#alteracao_antes").val();
		var alteracao_depois = $("#alteracao_depois").val();
		var alteracao_objetivo = $("#alteracao_objetivo").val();
		
		if(alteracao_nome == "")
			{
			exibemensagem("Campo Nome da alteração é obrigatório!", "alert");
			var continuar_adicionar_alteracao = "N";
			}
		else
			{
			var continuar_adicionar_alteracao = "S";
			}
		
		if(continuar_adicionar_alteracao == "S")
			{
			$("#container_alteracao").append( "<div class='row' id='container_alteracao"+alteracao_numero+"'>"+
												"<br>"+
												"<div class='col-md-10 col-md-offset-1'>"+
												"<div class='row'>"+
													"<div class='col-md-2'>"+
														"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>ID </span>"+
															"<input type='text' class='form-control' id='alteracao_numero"+alteracao_numero+"' value='"+alteracao_numero+"' disabled>"+
														"</div>"+
													"</div>"+
													"<div class='col-md-9'>"+
														"<select id='alteracao_rotina_id"+alteracao_numero+"' class='form-control' onchange='retorna_info_alteracao("+alteracao_numero+")'>"+
														"<option value=''>Selecione a rotina... <?php
															$consultaRotinas = mysqli_query($conectaBanco ,"SELECT * FROM rotinas ORDER BY rotina_id DESC");
															while ($dados = mysqli_fetch_array($consultaRotinas))
																{
																$rotina_id = $dados["rotina_id"];
																$rotina_nome = $dados["rotina_nome"];
																					
																echo "<option value='$rotina_id'>$rotina_id :: $rotina_nome";
																}
															?> </select>"+
													"</div>"+
													"<div class='col-md-1'>"+
														"<button type='button' class='btn btn-default btn-xs' onclick='remove_alteracao("+alteracao_numero+")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button>"+
													"</div>"+
												"</div>"+
												"<div class='row'>"+
														"<div class='col-md-11'>"+
														"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da alteração </span>"+
															"<input type='text' class='form-control' id='alteracao_nome"+alteracao_numero+"' value='"+alteracao_nome+"'>"+
														"</div>"+
														"</div>"+
												"</div>"+
												"<div class='row'>"+
													"<div class='col-md-3'>"+
														"<textarea class='form-control' rows='5' placeholder='Como era antes das alterações...' id='alteracao_antes"+alteracao_numero+"'>"+alteracao_antes+"</textarea>"+
													"</div>"+
													"<div class='col-md-3'>"+
														"<textarea class='form-control' rows='5' placeholder='Como ficará depois das alterações...' id='alteracao_depois"+alteracao_numero+"'>"+alteracao_depois+"</textarea>"+
													"</div>"+
													"<div class='col-md-4'>"+
														"<textarea class='form-control' rows='5' placeholder='Qual o objetivo da alteração...' id='alteracao_objetivo"+alteracao_numero+"'>"+alteracao_objetivo+"</textarea>"+
													"</div>"+
												"</div>"+	
												"</div>"+
												"</div>");
												
												$("#alteracao_rotina_id"+alteracao_numero).val(alteracao_rotina_id);
			}
		}
		
	function remove_alteracao(alteracao_numero)
		{
		$("#container_alteracao"+alteracao_numero).remove();
		}
		
	//===========================================================================Modulo Correção
	function adiciona_correcao()
		{
		if($("#moduloCorrecao #ultimoregistro").length)
			{
			var ultimoregistro = $("#moduloCorrecao #ultimoregistro").val();
			var ultimoregistro = parseInt(ultimoregistro);
			$("#moduloCorrecao #ultimoregistro").val(ultimoregistro + 1);
			}
		else
			{
			$("#moduloCorrecao").append("<input type='hidden' id='ultimoregistro' value='1'>");
			}
			
		var correcao_numero = $("#moduloCorrecao #ultimoregistro").val();
		var correcao_rotina_id = $("#correcao_rotina_id").val();
		var correcao_nome = $("#correcao_nome").val();
		var correcao_descricao = $("#correcao_descricao").val();
		
		if(correcao_nome == "")
			{
			exibemensagem("Campo Nome da correção é obrigatório!", "alert");
			var continuar_adicionar_correcao = "N";
			}
		else
			{
			var continuar_adicionar_correcao = "S";
			}
		
		if(continuar_adicionar_correcao == "S")
			{
			$("#container_correcao").append( "<div class='row' id='container_correcao"+correcao_numero+"'>"+
												"<br>"+
												"<div class='col-md-10 col-md-offset-1'>"+
													"<div class='col-md-2'>"+
														"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>ID </span>"+
															"<input type='text' class='form-control' id='correcao_numero"+correcao_numero+"' value='"+correcao_numero+"' disabled>"+
														"</div>"+
													"</div>"+
													"<div class='col-md-8'>"+
														"<select id='correcao_rotina_id"+correcao_numero+"' class='form-control'>"+
															"<option value=''>Selecione a rotina... <?php
																$consultaRotinas = mysqli_query($conectaBanco ,"SELECT * FROM rotinas ORDER BY rotina_id DESC");
																while ($dados = mysqli_fetch_array($consultaRotinas))
																{
																$rotina_id = $dados["rotina_id"];
																$rotina_nome = $dados["rotina_nome"];
																					
																echo "<option value='$rotina_id'>$rotina_id :: $rotina_nome";
																					}
															?> </select>"+
														"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da correção </span>"+
															"<input type='text' class='form-control' id='correcao_nome"+correcao_numero+"' value='"+correcao_nome+"'>"+
														"</div>"+
													"</div>"+
													"<div class='col-md-2'>"+
														"<button type='button' class='btn btn-default btn-xs' onclick='remove_correcao("+correcao_numero+")'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></button>"+
													"</div>"+
													"<div class='col-md-10'>"+
														"<textarea class='form-control' rows='5' id='correcao_descricao"+correcao_numero+"'>"+correcao_descricao+"</textarea>"+
													"</div>"+
												"</div>"+
												"</div>");
												
												$("#correcao_rotina_id"+correcao_numero).val(correcao_rotina_id);
			}
		}
	
	function remove_correcao(correcao_numero)
		{
		$("#container_correcao"+correcao_numero).remove();
		}

	//===========================================================================Modulo Forum
	function retorna_mensagens()
		{
		var forum_projeto_id = $("#projeto_id").val();
		
		$.ajax({
				type: 'POST',
				url: 'backend/projetos/modulos/zretornamensagensforum.php',
				data: {	forum_projeto_id: forum_projeto_id},
				async: false
				})
			.done(function(dados)
				{
				$("#recebe_mensagensforum").remove();
				$("#container_mensagensforum").append(dados);
				});
		}
		
	function insere_mensagem()
		{
		var forum_projeto_id = $("#projeto_id").val();
		var forum_mensagem = $("#forum_mensagem").val();
		
		if(forum_mensagem == "")
			{
			exibemensagem('Campo de texto a ser inserido no forum não está preenchido!', 'alert');
			}
		else
			{
			$.ajax({
				type: 'POST',
				url: 'backend/projetos/modulos/zinseremensagemforum.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						forum_projeto_id: forum_projeto_id,
						forum_mensagem: forum_mensagem},
				async: false
				})
			.done(function(dados)
				{
				$("#forum_mensagem").val("");
				retorna_mensagens();
				});
			}
		}
	
	//===========================================================================Modulo Erros
	function retorna_erros()
		{
		var erro_projeto_id = $("#projeto_id").val();
		
		$.ajax({
				type: 'POST',
				url: 'backend/projetos/modulos/zretornaerros.php',
				data: {	erro_projeto_id: erro_projeto_id},
				async: false
				})
			.done(function(dados)
				{
				$("#recebe_erros").remove();
				$("#container_erros").append(dados);
				});
		}
		
	function altera_erro(erro_id)
		{
		var erro_status = $("#erro_status"+erro_id).val();
		var erro_usuario_id = $("#erro_usuario_id"+erro_id).val();
		
		$.ajax({
				type: 'POST',
				url: 'backend/projetos/modulos/zeditaerro.php',
				data: {	erro_id: erro_id,
						erro_status: erro_status,
						erro_usuario_id: erro_usuario_id},
				async: false
				})
			.done(function(dados)
				{
				retorna_erros();
				exibemensagem('Erro foi alterado com sucesso!', 'success');
				});
		}
	
	
	
	//============================================================================Interação com banco de dados - Cadastro
	function salvar_novoprojeto()
		{		
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		var projeto_nome = $("#projeto_nome").val();
		var projeto_descricao = $("#projeto_descricao").val();
		var projeto_tipo = $("#projeto_tipo").val();
		var projeto_status = $("#projeto_status").val();
		var projeto_inicio = $("#projeto_inicio").val();
		var projeto_final = $("#projeto_final").val();
		
		var exige_solicitacaonoprojeto = "<?php echo "$exige_solicitacaonoprojeto";?>";
		
		if($("#projeto_solicitacao_id").length)
			{
			var projeto_solicitacao_id = $("#projeto_solicitacao_id").val();
			}
		else
			{
			var projeto_solicitacao_id = "";
			}
		
		if(projeto_nome == "")
			{
			exibemensagem("Campo Nome do Projeto é obrigatório!", "alert");
				
			var continuar_salvar_novoprojeto = "N";
			}
		else if(projeto_inicio != "" & projeto_final != "")
			{
			if(projeto_inicio > projeto_final)
				{
				exibemensagem("Data inicial não pode ser maior que a data final!", "alert");
				
				var continuar_salvar_novoprojeto = "N";
				}
			else
				{
				var continuar_salvar_novoprojeto = "S";
				}
			}
		else if(exige_solicitacaonoprojeto == "S")
			{
			if(projeto_solicitacao_id == "")
				{
				exibemensagem("É obrigatório vincular uma solicitação a esse projeto!", "alert");
				
				var continuar_salvar_novoprojeto = "N";
				}
			else
				{
				var continuar_salvar_novoprojeto = "S";
				}
			}
		else
			{
			var continuar_salvar_novoprojeto = "S";
			}
			
		if(continuar_salvar_novoprojeto == "S")
			{
			$.ajax({
					type: 'POST',
					url: 'backend/projetos/zcadastraprojetos.php',
					data: {	usuario_id_atual: <?php echo $ID; ?>,
							projeto_nome: projeto_nome,
							projeto_descricao: projeto_descricao,
							projeto_tipo: projeto_tipo,
							projeto_status: projeto_status,
							projeto_inicio: projeto_inicio,
							projeto_final: projeto_final,
							projeto_solicitacao_id: projeto_solicitacao_id},
					async: false
					})
				.done(function(dados)
					{
					$("#carregando").hide();
					
					dados = $.parseJSON(dados);
					var projeto_id = dados.projeto_id;
					var ResultadoCadastro = dados.ResultadoCadastro;
					
					salvamoduloscadastro(projeto_id);
					
					if(ResultadoCadastro == "OK")
						{
						exibemensagem("Projeto cadastrado com sucesso!", "success");
						}
					else
						{
						exibemensagem(ResultadoCadastro, "alert");
						}
					
					$("#temporario_cadprojetos").remove();

					$("#container_botoesprojetos").show();
					$("#container_pesquisaprojetos").show();
					$("#conteiner_exibeprojetos").show();
					retornaprojetos('N', '')
					});
			}
		}	
	function salvamoduloscadastro(projeto_id)
		{
		if($("#moduloTarefas #ultimoregistro").length)
			{
			var numeroregistros = $("#moduloTarefas #ultimoregistro").val();
			
			for (i = 1; i <= numeroregistros; i++)
				{
				var tarefa_numero = $("#tarefa_numero"+i).val();
				var tarefa_usuario_id_banco = $("#tarefa_usuario_id_banco"+i).val();
				var tarefa_nome_banco = $("#tarefa_nome_banco"+i).val();
				var tarefa_descricao_banco = $("#tarefa_descricao_banco"+i).val();
				var tarefa_inicio_banco = $("#tarefa_inicio_banco"+i).val();
				var tarefa_final_banco = $("#tarefa_final_banco"+i).val();
				
				$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zcadastratarefas.php',
					data: {	tarefa_projeto_id: projeto_id,
							tarefa_numero: tarefa_numero,
							tarefa_usuario_id_banco: tarefa_usuario_id_banco,
							tarefa_nome_banco: tarefa_nome_banco,
							tarefa_descricao_banco: tarefa_descricao_banco,
							tarefa_inicio_banco: tarefa_inicio_banco,
							tarefa_final_banco: tarefa_final_banco},
					async: false
					})
				.done(function(dados)
					{
					});
				}
			}
		
		if($("#moduloInovacao #ultimoregistro").length)
			{
			var numeroregistros = $("#moduloInovacao #ultimoregistro").val();
			
			for (i = 1; i <= numeroregistros; i++)
				{
				var inovacao_numero = $("#inovacao_numero"+i).val();
				var inovacao_rotina_nome = $("#inovacao_rotina_nome"+i).val();
				var inovacao_rotina_descricao = $("#inovacao_rotina_descricao"+i).val();
				
				$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zcadastrainovacao.php',
					data: {	usuario_id_atual: <?php echo $ID; ?>,
							inovacao_projeto_id: projeto_id,
							inovacao_numero: inovacao_numero,
							inovacao_rotina_nome: inovacao_rotina_nome,
							inovacao_rotina_descricao: inovacao_rotina_descricao},
					async: false
					})
				.done(function(dados)
					{
					});
				}
			}
		
		if($("#moduloAlteracao #ultimoregistro").length)
			{
			var numeroregistros = $("#moduloAlteracao #ultimoregistro").val();
			
			for (i = 1; i <= numeroregistros; i++)
				{
				var alteracao_numero = $("#alteracao_numero"+i).val();
				var alteracao_rotina_id = $("#alteracao_rotina_id"+i).val();
				var alteracao_nome = $("#alteracao_nome"+i).val();
				var alteracao_antes = $("#alteracao_antes"+i).val();
				var alteracao_depois = $("#alteracao_depois"+i).val();
				var alteracao_objetivo = $("#alteracao_objetivo"+i).val();

				$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zcadastraalteracao.php',
					data: {	usuario_id_atual: <?php echo $ID; ?>,
							alteracao_projeto_id: projeto_id,
							alteracao_numero: alteracao_numero,
							alteracao_rotina_id: alteracao_rotina_id,
							alteracao_nome: alteracao_nome,
							alteracao_antes: alteracao_antes,
							alteracao_depois: alteracao_depois,
							alteracao_objetivo: alteracao_objetivo},
					async: false
					})
				.done(function(dados)
					{
					});
				}
			}
		
		if($("#moduloCorrecao #ultimoregistro").length)
			{
			var numeroregistros = $("#moduloCorrecao #ultimoregistro").val();
			
			for (i = 1; i <= numeroregistros; i++)
				{
				var correcao_numero = $("#correcao_numero"+i).val();
				var correcao_rotina_id = $("#correcao_rotina_id"+i).val();
				var correcao_nome = $("#correcao_nome"+i).val();
				var correcao_descricao = $("#correcao_descricao"+i).val();
				
				$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zcadastracorrecao.php',
					data: {	usuario_id_atual: <?php echo $ID; ?>,
							correcao_projeto_id: projeto_id,
							correcao_numero: correcao_numero,
							correcao_rotina_id: correcao_rotina_id,
							correcao_nome: correcao_nome,
							correcao_descricao: correcao_descricao},
					async: false
					})
				.done(function(dados)
					{
					});
				}
			}
		
		}
	//============================================================================Interação com banco de dados - Edição
	function salvaedicao_projeto(projeto_id)
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		var projeto_nome = $("#projeto_nome").val();
		var projeto_descricao = $("#projeto_descricao").val();
		var projeto_tipo = $("#projeto_tipo").val();
		var projeto_status = $("#projeto_status").val();
		var projeto_inicio = $("#projeto_inicio").val();
		var projeto_final = $("#projeto_final").val();
		
		var exige_solicitacaonoprojeto = "<?php echo "$exige_solicitacaonoprojeto";?>";
		
		if($("#projeto_solicitacao_id").length)
			{
			var projeto_solicitacao_id = $("#projeto_solicitacao_id").val();
			}
		else
			{
			var projeto_solicitacao_id = "";
			}
			
		if(exige_solicitacaonoprojeto == "S")
			{
			if(projeto_solicitacao_id == "")
				{
				exibemensagem("É obrigatório vincular uma solicitação a esse projeto!", "alert");
				
				var continuar_salvar_novoprojeto = "N";
				}
			else
				{
				var continuar_salvar_novoprojeto = "S";
				}
			}
		else
			{
			var continuar_salvar_novoprojeto = "S";
			}
		
		if(continuar_salvar_novoprojeto == "S")
			{
			$.ajax({
					type: 'POST',
					url: 'backend/projetos/zeditaprojetos.php',
					data: {	usuario_id_atual: <?php echo $ID; ?>,
							projeto_id: projeto_id,
							projeto_nome: projeto_nome,
							projeto_descricao: projeto_descricao,
							projeto_tipo: projeto_tipo,
							projeto_status: projeto_status,
							projeto_inicio: projeto_inicio,
							projeto_final: projeto_final,
							projeto_solicitacao_id: projeto_solicitacao_id},
					async: false
					})
				.done(function(dados)
					{
					salvamodulosedicao(projeto_id)
					$("#carregando").hide();
					
					$("#temporario_editprojetos").remove();
					
					if(dados == "OK")
						{
						exibemensagem("Projeto alterado com sucesso!", "success");
						}
					else
						{
						exibemensagem(dados, "alert");
						}

					$("#container_botoesprojetos").show();
					$("#container_pesquisaprojetos").show();
					$("#conteiner_exibeprojetos").show();
					retornaprojetos('N', '');
					});	
			}
		}
	function salvamodulosedicao(projeto_id)
		{
		if($("#moduloTarefas #ultimoregistro").length)
			{
			var numeroregistros = $("#moduloTarefas #ultimoregistro").val();
			
			for (i = 1; i <= numeroregistros; i++)
				{
				var tarefa_numero = $("#tarefa_numero"+i).val();
				var tarefa_id = $("#tarefa_id"+i).val();
				var tarefa_usuario_id_banco = $("#tarefa_usuario_id_banco"+i).val();
				var tarefa_nome_banco = $("#tarefa_nome_banco"+i).val();
				var tarefa_descricao_banco = $("#tarefa_descricao_banco"+i).val();
				var tarefa_inicio_banco = $("#tarefa_inicio_banco"+i).val();
				var tarefa_final_banco = $("#tarefa_final_banco"+i).val();
					
				if (typeof tarefa_numero == "undefined") 
					{
					tarefa_numero = i;
					}
					
				$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zeditatarefas.php',
					data: {	tarefa_projeto_id: projeto_id,
							tarefa_numero: tarefa_numero,
							tarefa_id: tarefa_id,
							tarefa_usuario_id_banco: tarefa_usuario_id_banco,
							tarefa_nome_banco: tarefa_nome_banco,
							tarefa_descricao_banco: tarefa_descricao_banco,
							tarefa_inicio_banco: tarefa_inicio_banco,
							tarefa_final_banco: tarefa_final_banco},
					async: false
					})
				.done(function(dados)
					{
					});
				}
			}
		else
			{
			$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zremovetarefas.php',
					data: {	tarefa_projeto_id: projeto_id},
					async: false
					})
				.done(function(dados)
					{
					});
			}
		
		if($("#moduloInovacao #ultimoregistro").length)
			{
			var numeroregistros = $("#moduloInovacao #ultimoregistro").val();
			
			for (i = 1; i <= numeroregistros; i++)
				{
				var inovacao_numero = $("#inovacao_numero"+i).val();
				var inovacao_id = $("#inovacao_id"+i).val();
				var inovacao_rotina_id = $("#inovacao_rotina_id"+i).val();
				var inovacao_rotina_nome = $("#inovacao_rotina_nome"+i).val();
				var inovacao_rotina_descricao = $("#inovacao_rotina_descricao"+i).val();
				
				if (typeof inovacao_numero == "undefined") 
					{
					inovacao_numero = i;
					}
				
				$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zeditainovacao.php',
					data: {	inovacao_projeto_id: projeto_id,
							inovacao_numero: inovacao_numero,
							inovacao_id: inovacao_id,
							inovacao_rotina_id: inovacao_rotina_id,
							inovacao_rotina_nome: inovacao_rotina_nome,
							inovacao_rotina_descricao: inovacao_rotina_descricao},
					async: false
					})
				.done(function(dados)
					{
					});
				}
			
			}
		else
			{
			$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zremoveinovacao.php',
					data: {	inovacao_projeto_id: projeto_id},
					async: false
					})
				.done(function(dados)
					{
					});
			}
		
		if($("#moduloAlteracao #ultimoregistro").length)
			{
			var numeroregistros = $("#moduloAlteracao #ultimoregistro").val();
			
			for (i = 1; i <= numeroregistros; i++)
				{
				var alteracao_id = $("#alteracao_id"+i).val();
				var alteracao_numero = $("#alteracao_numero"+i).val();
				var alteracao_rotina_id = $("#alteracao_rotina_id"+i).val();
				var alteracao_nome = $("#alteracao_nome"+i).val();
				var alteracao_objetivo = $("#alteracao_objetivo"+i).val();
				var alteracao_antes = $("#alteracao_antes"+i).val();
				var alteracao_depois = $("#alteracao_depois"+i).val();
				
				if (typeof alteracao_numero == "undefined") 
					{
					alteracao_numero = i;
					}
				
				$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zeditaalteracao.php',
					data: {	alteracao_id: alteracao_id,
							alteracao_projeto_id: projeto_id,
							alteracao_numero: alteracao_numero,
							alteracao_rotina_id: alteracao_rotina_id,
							alteracao_nome: alteracao_nome,
							alteracao_objetivo: alteracao_objetivo,
							alteracao_antes: alteracao_antes,
							alteracao_depois: alteracao_depois},
					async: false
					})
				.done(function(dados)
					{
					});
				}
			}
		else
			{
			$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zremovealteracao.php',
					data: {	alteracao_projeto_id: projeto_id},
					async: false
					})
				.done(function(dados)
					{
					});
			}
		
		if($("#moduloCorrecao #ultimoregistro").length)
			{
			var numeroregistros = $("#moduloCorrecao #ultimoregistro").val();
			
			for (i = 1; i <= numeroregistros; i++)
				{
				var correcao_numero = $("#correcao_numero"+i).val();
				var correcao_id = $("#correcao_id"+i).val();
				var correcao_rotina_id = $("#correcao_rotina_id"+i).val();
				var correcao_nome = $("#correcao_nome"+i).val();
				var correcao_descricao = $("#correcao_descricao"+i).val();
				
				if (typeof correcao_numero == "undefined") 
					{
					correcao_numero = i;
					}
				
				$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zeditacorrecao.php',
					data: {	correcao_projeto_id: projeto_id,
							correcao_numero: correcao_numero,
							correcao_id: correcao_id,
							correcao_rotina_id: correcao_rotina_id,
							correcao_nome: correcao_nome,
							correcao_descricao: correcao_descricao},
					async: false
					})
				.done(function(dados)
					{
					});
				}
			
			}
		else
			{
			$.ajax({
					type: 'POST',
					url: 'backend/projetos/modulos/zremovecorrecao.php',
					data: {	correcao_projeto_id: projeto_id},
					async: false
					})
				.done(function(dados)
					{
					});
			}
		
		
		
		}
	
	//============================================================================Interação com banco de dados - Remoção
	function remove_projeto(projeto_id)
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		$.ajax({
				type: 'POST',
				url: 'backend/projetos/zremoveprojetos.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						projeto_id: projeto_id},
				async: false
				})
			.done(function(dados)
				{
				$("#carregando").hide();
				
				if(dados == "OK")
					{
					exibemensagem("Projeto removido com sucesso!", "success");
					}
				else
					{
					exibemensagem(dados, "alert");
					}
				
				retornaprojetos('N', '');
				});
		}

	
	

	
	function exibemensagem(mensagem, tipo)
		{
		$("#temporario_mensagens").remove();
		
		if(tipo == "success")
			{
			$("#container_mensagens").append("<div id='temporario_mensagens'><div class='alert alert-success alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+mensagem+"</div></div>");
			}
		if(tipo == "alert")
			{
			$("#container_mensagens").append("<div id='temporario_mensagens'><div class='alert alert-danger alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+mensagem+"</div></div>");
			}

		$("body, html").animate({scrollTop:0}, "slow");	
		}
		

	
</script>	
</body>
</html>
<!--
# Registro do software / Software registration

Software Registrado junto ao INPI.
Todos os direitos reservados. 
Não é permitido o uso comercial do software no todo ou em parte.
Para uso comercial entre em contato com adrianmedeiros@outlook.com ou +55 11 997996355.
---------------------------------------------------------------------------------------
Software Joined at the INPI(Brazilian organization software registration).
All rights reserved.
No commercial use of the software in whole or in part is allowed.
For commercial use please contact adrianmedeiros@outlook.com or +55 11 997 996 355.
-->