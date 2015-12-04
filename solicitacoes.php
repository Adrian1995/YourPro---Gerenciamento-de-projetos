<?php
	include ("includes/yverificaAcessoCookie.inc");
?>
<html>
<head>
	<?php	include ("includes/yhead.inc");	?>
</head>
<body>
	<?php
	include('backend/yconectaDB.inc');

	//======================================================================================================================CARREGA PERMISSÕES DO USUÁRIO
	$usuario_id_atual = $ID;

	$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id_atual'");
	$dados = mysqli_fetch_array($consultaUsuarios);
	$usuario_visu_solicitacao_atual = $dados["usuario_visu_solicitacao"];
	$usuario_cada_solicitacao_atual = $dados["usuario_cada_solicitacao"];
	?>
<br>
<div class="container-fluid">

	<div class="row">
		<div class="col-md-1 col-md-offset-11">
			<a href="index.php?a=ac" class="btn btn-danger">Sair</a>
		</div>
	</div>



	<div class="row" id="container_mensagens">
		<?php if($usuario_visu_solicitacao_atual == "N")
			{
			echo "<div id='temporario_mensagens'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Erro ao acessar...</strong> Você não possui acesso a visualização de solicitações!</div></div>";
			}
		?>
	</div>	
	
	<div class="row" id="carregando"><h5><img src='img/carregando.gif'>  Carregando...</h5></div>
	
	<div class="row" id="container_botoessolicitacoes" <?php if($usuario_cada_solicitacao_atual == "N" or $usuario_visu_solicitacao_atual == "N"){echo "hidden";}?>>
		<div class="col-md-2">
			<button type="button" class="btn btn-default" id="btn_NovaSolicitacao" onclick="abreformulario_novasolicitacao()">
			  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nova solicitação
			</button>
		</div>
	</div>
	<div class="row" id="container_cadsolicitacoes">
	</div>
	<div class="row" id="container_visusolicitacoes">
	</div>
	<div class="row" id="container_editsolicitacoes">
	</div>
	<div class="row" id="container_pesquisasolicitacoes" <?php if($usuario_visu_solicitacao_atual == "N"){echo "hidden";}?>>
		<div class="col-md-6 col-md-offset-1">
			<br>
			Pesquisar solicitações por:&nbsp;&nbsp;
			<input type="radio" name="pesquisasolicitacoes" id="id" checked onchange="alterainputpesquisa('text')"><label for="id"> &nbsp;ID</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisasolicitacoes" id="nome" onchange="alterainputpesquisa('text')"><label for="nome"> &nbsp;Nome</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisasolicitacoes" id="data" onchange="alterainputpesquisa('data')"><label for="data"> &nbsp;Data</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisasolicitacoes" id="status" onchange="alterainputpesquisa('status')"><label for="status"> &nbsp;Status</label>&nbsp;&nbsp;
			<div id="container_textopesquisa">
				<input type="text" id="textopesquisa" class="form-control">
			</div>
		</div>
		<div class="col-md-3">
			<br>
			<br>
			<button type="button" class="btn btn-default" id="btn_pesquisarsolicitacoes" onclick="retornasolicitacoes('S', '')">
			  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
			</button>
		</div>
	</div>

	<div class="row" id="conteiner_exibesolicitacoes" <?php if($usuario_visu_solicitacao_atual == "N"){echo "hidden";}?>>
		<div class="col-md-10 col-md-offset-1">
			<div id="container_solicitacoes">
			</div>
		</div>
	</div>
</div>
	
	
	
<script>
$(document).ready(function() 
	{
	retornasolicitacoes('N', '');
	});
	
	//===========================================================================Pesquisa de solicitações
	function alterainputpesquisa(tipocampo)
		{
		$("#textopesquisa").remove();
		$("#textopesquisadata").remove();
		
		if(tipocampo == "text")
			{
			$("#container_textopesquisa").append("<input type='text' id='textopesquisa' class='form-control'>");
			}

		if(tipocampo == "data")
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
		
		if(tipocampo == "status")
			{
			$("#container_textopesquisa").append("<select class='form-control' aria-describedby='sizing-addon2' id='textopesquisa'>"+
														"<option value='Aguardando'>Aguardando"+
														"<option value='Em andamento'>Em andamento"+
														"<option value='Finalizado'>Finalizado"+
													"</select></div>");
			}
		}
	
	function retornasolicitacoes(pesquisa, paginasolicitada)
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
		
		if($("#data").is(":checked"))	
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
			
			var data = "S";
			}
		else{var data = "N";}
		
		if($("#status").is(":checked"))	{var status = "S";}
		else							{var status = "N";}
		
		
		$.ajax({
				type: 'POST',
				url: 'backend/solicitacoes/zretornasolicitacoesusuario.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						pesquisa: pesquisa,
						textopesquisa: textopesquisa,
						id: id,
						nome: nome,
						data: data,
						status: status,
						paginasolicitada: paginasolicitada},
				async: false
				})
			.done(function(dados)
				{
				$("#carregando").hide();
				
				$("#temporario_solicitacoes").remove();
				$("#container_solicitacoes").append("<div id='temporario_solicitacoes'><h3>Solicitações</h3>"+dados+"</div>");
				});
		}

		
		
		
		
		
		
		
	//===========================================================================Retorna página de Cadastro de Solicitação	
	function abreformulario_novasolicitacao()
		{
		$("#container_botoessolicitacoes").hide();
		$("#container_pesquisasolicitacoes").hide();
		$("#conteiner_exibesolicitacoes").hide();
		
		$("#container_cadsolicitacoes").append("<div class='col-md-10 col-md-offset-1' id='temporario_cadsolicitacoes'>"+ 
											"<h3>Cadastro de nova solicitação</h3>"+
											"<br>"+
											"<div class='row'>"+
											
											"<div class='col-md-6'>"+
											"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span>"+
											"<input type='text' class='form-control' aria-describedby='sizing-addon2' id='solicitacao_nome'>"+
											"</div>"+
											"<br>"+
											"<textarea class='form-control' rows='10' id='solicitacao_observacao' placeholder='Insira observações da solicitação...'></textarea>"+
											"<br>"+
											"</div>"+
											"<div class='row'>"+
											"<div class='col-md-6'>"+
											"<br>"+
											"<br>"+
											"<br>"+
											"<div class='panel panel-default'>"+
												"<div class='panel-body'>"+
													"<input type='text' class='form-control' aria-describedby='sizing-addon2' id='texto_pergunta'>"+
													"<br>"+
													"<button type='button' class='btn btn-default' id='btn_AdicionaPergunta' onclick='adicionar_pergunta()'>"+
													"<span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span> Adicionar pergunta/tópico"+
													"</button>"+
												"</div>"+
											"</div>"+
											"</div>"+
											"</div>"+
											"</div>"+
											"<div class='row' id='container_perguntas'><?php
												
											$consultaPerguntas = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes_perguntas");
											while($dados = mysqli_fetch_array($consultaPerguntas))
												{
												$pergunta_id = $dados["pergunta_id"];
												$pergunta_texto = $dados["pergunta_texto"];
												
												echo "<div class='row' id='perguntaresposta$pergunta_id'>";
													echo "<div class='col-md-1'>";
														echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' value='$pergunta_id' id='solicitacao_numero$pergunta_id' disabled>";
													echo "</div>";
													echo "<div class='col-md-10'>";
														echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Pergunta</span>";
														echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' value='$pergunta_texto' id='pergunta$pergunta_id'>";
														echo "</div>";
														echo "<textarea class='form-control' rows='7' id='resposta$pergunta_id' placeholder='Insira a resposta da pergunta acima, sobre a solicitação...'></textarea>";
														echo "<br>";
													echo "</div>";
													echo "<div class='col-md-1'>";
														echo "<button type='button' class='btn btn-primary' onclick='remove_pergunta($pergunta_id)'>";
														echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
														echo "</button>";
													echo "</div>";
												echo "</div>";
												}
												
												echo "<input type='hidden' id='ultimapergunta' value='$pergunta_id'>";
												
												?></div>"+
											"<div class='row'>"+
											"<button type='button' class='btn btn-primary' id='btn_SalvarProjeto' onclick='salvar_novasolicitacao()'>"+
											"<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Salvar"+
											"</button>"+
											"</div>"+
											"</div>");
		}
	
	//===========================================================================Retorna página de Visualização de Projeto
	function visualiza_solicitacao(solicitacao_id)
		{
		$("#container_botoessolicitacoes").hide();
		$("#container_pesquisasolicitacoes").hide();
		$("#conteiner_exibesolicitacoes").hide();
		$("#temporario_mensagens").remove();
		
		$.ajax({
				type: 'POST',
				url: 'backend/solicitacoes/zretornasolicitacaounica_Visualizar.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						solicitacao_id: solicitacao_id},
				async: false
				})
			.done(function(dados)
				{
				$("#temporario_visusolicitacoes").remove();
				$("#container_visusolicitacoes").append(dados);
				});
		}
	
	//===========================================================================Retorna página de Edição de Projeto
	function edita_solicitacao(solicitacao_id)
		{
		$("#container_botoessolicitacoes").hide();
		$("#container_pesquisasolicitacoes").hide();
		$("#conteiner_exibesolicitacoes").hide();
		$("#temporario_mensagens").remove();
		$("#temporario_visusolicitacoes").remove();
		
		$.ajax({
				type: 'POST',
				url: 'backend/solicitacoes/zretornasolicitacaounica_Editar.php',
				data: {	solicitacao_id: solicitacao_id},
				async: false
				})
			.done(function(dados)
				{
				$("#temporario_editsolicitacoes").remove();
				$("#container_editsolicitacoes").append(dados);
				});
		}
		

		
		
		
		
		
		
	//===========================================================================Gerenciador de Perguntas - Cadastro	
	function adicionar_pergunta()
		{
		if($("#ultimapergunta").length)
			{
			var ultimapergunta = $("#ultimapergunta").val();
			var ultimapergunta = parseInt(ultimapergunta);
			$("#ultimapergunta").val(ultimapergunta + 1);
			}
		else
			{
			$("#container_perguntas").append("<input type='hidden' id='ultimapergunta' value='1'>");
			}
		
		var ultimapergunta = $("#ultimapergunta").val();
		var texto_pergunta = $("#texto_pergunta").val();
		
		$("#container_perguntas").append("<div class='row' id='perguntaresposta"+ultimapergunta+"'>"+
													"<div class='col-md-1'>"+
														"<input type='text' class='form-control' aria-describedby='sizing-addon2' value='"+ultimapergunta+"' id='solicitacao_numero"+ultimapergunta+"' disabled>"+
													"</div>"+
													"<div class='col-md-10'>"+
														"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Pergunta</span>"+
														"<input type='text' class='form-control' aria-describedby='sizing-addon2' id='pergunta"+ultimapergunta+"' value='"+texto_pergunta+"'>"+
														"</div>"+
														"<textarea class='form-control' rows='7' id='resposta"+ultimapergunta+"' placeholder='Insira a resposta da pergunta acima, sobre a solicitação...'></textarea>"+
														"<br>"+
													"</div>"+
													"<div class='col-md-1'>"+
														"<button type='button' class='btn btn-primary' id='btn_SalvarProjeto' onclick='remove_pergunta("+ultimapergunta+")'>"+
														"<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"+
														"</button>"+
													"</div>"+
												"</div>");
		}
	function remove_pergunta(pergunta)
		{
		$("#perguntaresposta"+pergunta).remove();
		}
	
	
	
	
	
	
	

	
	//============================================================================Interação com banco de dados - Cadastro
	function salvar_novasolicitacao()
		{		
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		var solicitacao_nome = $("#solicitacao_nome").val();
		var solicitacao_observacao = $("#solicitacao_observacao").val();
		
		if(solicitacao_nome == "")
			{
			exibemensagem("Campo Nome da Solicitação é obrigatório!", "alert");
				
			var continuar_salvar_novasolicitacao = "N";
			}
		else
			{
			var continuar_salvar_novasolicitacao = "S";
			}
			
		if(continuar_salvar_novasolicitacao == "S")
			{
			$.ajax({
					type: 'POST',
					url: 'backend/solicitacoes/zcadastrasolicitacoes.php',
					data: {	usuario_id_atual: <?php echo $ID; ?>,
							solicitacao_nome: solicitacao_nome,
							solicitacao_usuario: <?php echo $ID; ?>,
							solicitacao_observacao: solicitacao_observacao},
					async: false
					})
				.done(function(dados)
					{
					dados = $.parseJSON(dados);
					var solicitacao_id = dados.solicitacao_id;
					var ResultadoCadastro = dados.ResultadoCadastro;
					
					salvaperguntas(solicitacao_id);
					
					$("#carregando").hide();
					
					if(ResultadoCadastro == "OK")
						{
						exibemensagem("Solicitação cadastrada com sucesso!", "success");
						}
					else
						{
						exibemensagem(ResultadoCadastro, "alert");
						}
					
					$("#temporario_cadsolicitacoes").remove();

					$("#container_botoessolicitacoes").show();
					$("#container_pesquisasolicitacoes").show();
					$("#conteiner_exibesolicitacoes").show();
					retornasolicitacoes('N', '')
					});
			}
		}	
	function salvaperguntas(solicitacao_id)
		{
		var numeroperguntas = $("#ultimapergunta").val();
		
		for (i = 1; i <= numeroperguntas; i++)
			{
			var solicitacao_numero = $("#solicitacao_numero"+i).val();
			var solicitacao_pergunta = $("#pergunta"+i).val();
			var solicitacao_resposta = $("#resposta"+i).val();
			
			$.ajax({
				type: 'POST',
				url: 'backend/solicitacoes/perguntas/zcadastraperguntas.php',
				data: {	solicitacao_id: solicitacao_id,
						solicitacao_numero: solicitacao_numero,
						solicitacao_pergunta: solicitacao_pergunta,
						solicitacao_resposta: solicitacao_resposta},
					async: false
					})
				.done(function(dados)
					{
					});
			}
		}
	
	
	
	
	
	
	
	
	
	//============================================================================Interação com banco de dados - Edição
	function salvaedicao_solicitacao(solicitacao_id)
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		var solicitacao_nome = $("#solicitacao_nome").val();
		var solicitacao_observacao = $("#solicitacao_observacao").val();
		
		$.ajax({
				type: 'POST',
				url: 'backend/solicitacoes/zeditasolicitacoes.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						solicitacao_id: solicitacao_id,
						solicitacao_nome: solicitacao_nome,
						solicitacao_observacao: solicitacao_observacao},
				async: false
				})
			.done(function(dados)
				{
				salvaedicaoperguntas(solicitacao_id);
				
				$("#carregando").hide();
				
				$("#temporario_editsolicitacoes").remove();
				
				if(dados == "OK")
					{
					exibemensagem("Projeto alterado com sucesso!", "success");
					}
				else
					{
					exibemensagem(dados, "alert");
					}

				$("#container_botoessolicitacoes").show();
				$("#container_pesquisasolicitacoes").show();
				$("#conteiner_exibesolicitacoes").show();
				retornasolicitacoes('N', '');
				});
		}
	function salvaedicaoperguntas(solicitacao_id)
		{
		var numeroperguntas = $("#ultimapergunta").val();
		
		for (i = 1; i <= numeroperguntas; i++)
			{
			var solicitacaoresposta_id = $("#solicitacaoresposta_id"+i).val();
			var solicitacao_numero = $("#solicitacao_numero"+i).val();
			var solicitacao_pergunta = $("#pergunta"+i).val();
			var solicitacao_resposta = $("#resposta"+i).val();
			
			if (typeof solicitacao_numero == "undefined") 
					{
					solicitacao_numero = i;
					}
					
			$.ajax({
				type: 'POST',
				url: 'backend/solicitacoes/perguntas/zeditaperguntas.php',
				data: {	solicitacao_id: solicitacao_id,
						solicitacaoresposta_id: solicitacaoresposta_id,
						solicitacao_numero: solicitacao_numero,
						solicitacao_pergunta: solicitacao_pergunta,
						solicitacao_resposta: solicitacao_resposta},
					async: false
					})
				.done(function(dados)
					{
					});
			}
		}
	
	
	
	
	
	
	
	
	
	//============================================================================Interação com banco de dados - Remoção
	function remove_solicitacao(solicitacao_id)
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		$.ajax({
				type: 'POST',
				url: 'backend/solicitacoes/zremovesolicitacoes.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						solicitacao_id: solicitacao_id},
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
				
				retornasolicitacoes('N', '');
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