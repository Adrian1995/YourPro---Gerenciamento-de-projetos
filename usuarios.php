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
	$usuario_visu_usuarios_atual = $dados["usuario_visu_usuarios"];
	$usuario_cada_usuarios_atual = $dados["usuario_cada_usuarios"];
	?>

<div class="container-fluid">

	<div class="row" id="container_mensagens">
		<?php if($usuario_visu_usuarios_atual == "N")
			{
			echo "<div id='temporario_mensagens'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Erro ao acessar...</strong> Você não possui acesso a visualização de usuários!</div></div>";
			}
		?>
	</div>
	
	<div class="row" id="carregando"><h5><img src='img/carregando.gif'>  Carregando...</h5></div>
	
	<div class="row" id="container_botoesusuarios" <?php if($usuario_cada_usuarios_atual == "N" or $usuario_visu_usuarios_atual == "N"){echo "hidden";}?>>
		<div class="col-md-2">
			<button type="button" class="btn btn-default" id="btn_NovoUsuario" onclick="abreformulario_novousuario()">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Novo usuário
			</button>
		</div>
	</div>

	
	<div class="row" id="container_cadusuarios">
	</div>
	<div class="row" id="container_visusuarios">
	</div>
	<div class="row" id="container_editusuarios">
	</div>
	

	<div class="row" id="container_pesquisausuarios" <?php if($usuario_visu_usuarios_atual == "N"){echo "hidden";}?>>
		<div class="col-md-6 col-md-offset-1">
			<br>
			Pesquisar usuários por:&nbsp;&nbsp;
			<input type="radio" name="pesquisausuarios" id="id" checked><label for="id"> &nbsp;ID</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisausuarios" id="nome"><label for="nome"> &nbsp;Nome</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisausuarios" id="email"><label for="email"> &nbsp;E-mail</label><br>
			<input type="text" id="textopesquisa" class="form-control">
		</div>
		<div class="col-md-3">
			<br>
			<br>
			<button type="button" class="btn btn-default" id="btn_pesquisarusuarios" onclick="retornausuarios('S', '')">
				<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
			</button>
		</div>
	</div>

	<div class="row" id="conteiner_exibeusuarios" <?php if($usuario_visu_usuarios_atual == "N"){echo "hidden";}?>>
		<div class="col-md-10 col-md-offset-1">
			<div id="container_usuarios">
			</div>
		</div>
	</div>

	
</div>
	
<script>
$(document).ready(function() 
	{	
	$("#usuarios").addClass("active");
	
	retornausuarios('N', '');
	});
	
	function retornausuarios(pesquisa, paginasolicitada)
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
		
		if($("#email").is(":checked"))	{var email = "S";}
		else							{var email = "N";}
		
		$.ajax({
				type: 'POST',
				url: 'backend/usuarios/zretornausuarios.php',
				data: {	usuario_id_atual: <?php echo $ID?>,
						pesquisa: pesquisa,
						textopesquisa: textopesquisa,
						id: id,
						nome: nome,
						email: email,
						paginasolicitada: paginasolicitada},
				async: false
				})
			.done(function(dados)
				{
				$("#carregando").hide();
				if(dados == "NVISUALIZA")
					{
					exibemensagem('Você não possui permissão pra visualizar os usuários!', 'alert');
					
					$("#container_botoesusuarios").remove();
					$("#container_pesquisausuarios").remove();
					}
				else
					{
					$("#temporario_usuarios").remove();
					$("#container_usuarios").append("<div id='temporario_usuarios'><h3>Usuários</h3>"+dados+"</div>");
					}
				});
		}

	function abreformulario_novousuario()
		{
		$("#container_botoesusuarios").hide();
		$("#container_pesquisausuarios").hide();
		$("#conteiner_exibeusuarios").hide();
		
		$("#container_cadusuarios").append("<div class='col-md-10 col-md-offset-1' id='temporario_cadusuarios'>"+
											"<h3>Cadastro de novo usuário</h3>"+
											"<br>"+
											"<div class='row'>"+
											"<div class='col-md-5'>"+
											"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span> <input type='text' id='usuario_nome' class='form-control' aria-describedby='sizing-addon2'></div>"+
											"<br>"+
											"<div class='input-group'><div class='input-group-addon'><span class='glyphicon glyphicon-user' aria-hidden='true'></span> </div> <input type='text' id='usuario_email' class='form-control' placeholder='Insira o Email...'></div>"+
											"<br>"+
											"<div class='input-group'><div class='input-group-addon'><span class='glyphicon glyphicon-eye-close' aria-hidden='true'></span> </div> <input type='password' id='usuario_senha' class='form-control' placeholder='Insira a Senha...'> </div>"+
											"<br>"+
											"<div class='input-group'><div class='input-group-addon'>Tipo</span> </div>"+ 
												"<select id='usuario_tipo' class='form-control'>"+
												"<option value=''>Selecione..."+
												"<option value='Normal'>Normal"+
												"<option value='Solicitante'>Solicitante"+
												"</select>"+
											"</div>"+
											"<br>"+
											"</div>"+
											"<div class='col-md-3'>"+
											
											"<div class='panel panel-default'>"+
											"<div class='panel-body'>"+
											"<h4>Projetos</h4>"+
											"<input type='checkbox' id='usuario_visu_projetos'> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; "+
											"<input type='checkbox' id='usuario_cada_projetos'> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;"+
											"<input type='checkbox' id='usuario_edit_projetos'> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;"+
											"<input type='checkbox' id='usuario_excl_projetos'> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"+
											"</div>"+
											"</div>"+
											
											"<div class='panel panel-default'>"+
											"<div class='panel-body'>"+
											"<h4>Usuários</h4>"+
											"<input type='checkbox' id='usuario_visu_usuarios'> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; "+
											"<input type='checkbox' id='usuario_cada_usuarios'> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;"+
											"<input type='checkbox' id='usuario_edit_usuarios'> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;"+
											"<input type='checkbox' id='usuario_excl_usuarios'> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"+
											"</div>"+
											"</div>"+
											
											"<div class='panel panel-default'>"+
											"<div class='panel-body'>"+
											"<h4>Configurações</h4>"+
											"<input type='checkbox' id='usuario_visu_configuracao'> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; "+
											"<input type='checkbox' id='usuario_edit_configuracao'> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;"+
											"</div>"+
											"</div>"+
			
											"</div>"+
											
											
											"<div class='col-md-3'>"+
											
											"<div class='panel panel-default'>"+
											"<div class='panel-body'>"+
											"<h4>Solicitações</h4>"+
											"<input type='checkbox' id='usuario_visu_solicitacao'> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; "+
											"<input type='checkbox' id='usuario_cada_solicitacao'> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;"+
											"<input type='checkbox' id='usuario_edit_solicitacao'> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;"+
											"<input type='checkbox' id='usuario_excl_solicitacao'> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"+
											"</div>"+
											"</div>"+
											
											"<div class='panel panel-default'>"+
											"<div class='panel-body'>"+
											"<h4>Rotinas</h4>"+
											"<input type='checkbox' id='usuario_visu_rotina'> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; "+
											"<input type='checkbox' id='usuario_cada_rotina'> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;"+
											"<input type='checkbox' id='usuario_edit_rotina'> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;"+
											"<input type='checkbox' id='usuario_excl_rotina'> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"+
											"</div>"+
											"</div>"+
			
											"</div>"+
											
											
											"</div>"+
											
											"<button type='button' class='btn btn-primary' id='btn_SalvarUsuario' onclick='salvar_novousuario()'>"+
											"<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Salvar"+
											"</button>"+
											"<br><br>"+
											"</div>");
		}

	function salvar_novousuario()
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		var usuario_nome = $("#usuario_nome").val();
		var usuario_email = $("#usuario_email").val();
		var usuario_senha = $("#usuario_senha").val();
		var usuario_tipo = $("#usuario_tipo").val();
		
		if($("#usuario_visu_projetos").is(":checked"))	{var usuario_visu_projetos = "S";}
		else											{var usuario_visu_projetos = "N";}
		
		if($("#usuario_cada_projetos").is(":checked"))	{var usuario_cada_projetos = "S";}
		else											{var usuario_cada_projetos = "N";}
		
		if($("#usuario_edit_projetos").is(":checked"))	{var usuario_edit_projetos = "S";}
		else											{var usuario_edit_projetos = "N";}
		
		if($("#usuario_excl_projetos").is(":checked"))	{var usuario_excl_projetos = "S";}
		else											{var usuario_excl_projetos = "N";}
		
		if($("#usuario_visu_usuarios").is(":checked"))	{var usuario_visu_usuarios = "S";}
		else											{var usuario_visu_usuarios = "N";}
		
		if($("#usuario_cada_usuarios").is(":checked"))	{var usuario_cada_usuarios = "S";}
		else											{var usuario_cada_usuarios = "N";}
		
		if($("#usuario_edit_usuarios").is(":checked"))	{var usuario_edit_usuarios = "S";}
		else											{var usuario_edit_usuarios = "N";}
		
		if($("#usuario_excl_usuarios").is(":checked"))	{var usuario_excl_usuarios = "S";}
		else											{var usuario_excl_usuarios = "N";}
		
		if($("#usuario_visu_solicitacao").is(":checked"))	{var usuario_visu_solicitacao = "S";}
		else											{var usuario_visu_solicitacao = "N";}
		
		if($("#usuario_cada_solicitacao").is(":checked"))	{var usuario_cada_solicitacao = "S";}
		else											{var usuario_cada_solicitacao = "N";}
		
		if($("#usuario_edit_solicitacao").is(":checked"))	{var usuario_edit_solicitacao = "S";}
		else											{var usuario_edit_solicitacao = "N";}
		
		if($("#usuario_excl_solicitacao").is(":checked"))	{var usuario_excl_solicitacao = "S";}
		else											{var usuario_excl_solicitacao = "N";}
		
		if($("#usuario_visu_rotina").is(":checked"))	{var usuario_visu_rotina = "S";}
		else											{var usuario_visu_rotina = "N";}
		
		if($("#usuario_cada_rotina").is(":checked"))	{var usuario_cada_rotina = "S";}
		else											{var usuario_cada_rotina = "N";}
		
		if($("#usuario_edit_rotina").is(":checked"))	{var usuario_edit_rotina = "S";}
		else											{var usuario_edit_rotina = "N";}
		
		if($("#usuario_excl_rotina").is(":checked"))	{var usuario_excl_rotina = "S";}
		else											{var usuario_excl_rotina = "N";}
		
		if($("#usuario_visu_configuracao").is(":checked"))	{var usuario_visu_configuracao = "S";}
		else											{var usuario_visu_configuracao = "N";}
		
		if($("#usuario_edit_configuracao").is(":checked"))	{var usuario_edit_configuracao = "S";}
		else											{var usuario_edit_configuracao = "N";}
		
		$.ajax({
				type: 'POST',
				url: 'backend/usuarios/zcadastrausuarios.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						usuario_nome: usuario_nome,
						usuario_email: usuario_email,
						usuario_senha: usuario_senha,
						usuario_tipo: usuario_tipo,
						usuario_visu_projetos: usuario_visu_projetos,
						usuario_cada_projetos: usuario_cada_projetos,
						usuario_edit_projetos: usuario_edit_projetos,
						usuario_excl_projetos: usuario_excl_projetos,
						usuario_visu_usuarios: usuario_visu_usuarios,
						usuario_cada_usuarios: usuario_cada_usuarios,
						usuario_edit_usuarios: usuario_edit_usuarios,
						usuario_excl_usuarios: usuario_excl_usuarios,
						usuario_visu_solicitacao: usuario_visu_solicitacao,
						usuario_cada_solicitacao: usuario_cada_solicitacao,
						usuario_edit_solicitacao: usuario_edit_solicitacao,
						usuario_excl_solicitacao: usuario_excl_solicitacao,
						usuario_visu_rotina: usuario_visu_rotina,
						usuario_cada_rotina: usuario_cada_rotina,
						usuario_edit_rotina: usuario_edit_rotina,
						usuario_excl_rotina: usuario_excl_rotina,
						usuario_visu_configuracao: usuario_visu_configuracao,
						usuario_edit_configuracao: usuario_edit_configuracao},
				async: false
				})
			.done(function(dados)
				{
				$("#carregando").hide();
				
				if(dados == "OK")
					{
					exibemensagem('Usuário cadastrado com sucesso!', 'success');
					}
				else
					{
					exibemensagem(dados, 'alert');
					}
				
				$("#temporario_cadusuarios").remove();

				$("#container_botoesusuarios").show();
				$("#container_pesquisausuarios").show();
				$("#conteiner_exibeusuarios").show();
				retornausuarios('N', '');
				});
		}
	
	function visualiza_usuario(usuario_id)
		{
		$("#container_botoesusuarios").hide();
		$("#container_pesquisausuarios").hide();
		$("#conteiner_exibeusuarios").hide();
		$("#temporario_mensagens").remove();
		
		$.ajax({
				type: 'POST',
				url: 'backend/usuarios/zretornausuariounico_Visualizar.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						usuario_id: usuario_id},
				async: false
				})
			.done(function(dados)
				{
				$("#temporario_visusuarios").remove();
				$("#container_visusuarios").append(dados);
				});
		}
	
	function edita_usuario(usuario_id)
		{
		$("#container_botoesusuarios").hide();
		$("#container_pesquisausuarios").hide();
		$("#conteiner_exibeusuarios").hide();
		$("#temporario_mensagens").remove();
		$("#temporario_visusuarios").remove();
		
		$.ajax({
				type: 'POST',
				url: 'backend/usuarios/zretornausuariounico_Editar.php',
				data: {	usuario_id: usuario_id},
				async: false
				})
			.done(function(dados)
				{
				$("#temporario_editusuarios").remove();
				$("#container_editusuarios").append(dados);
				});
		}
		
	function salvaedicao_usuario(usuario_id)
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		var usuario_nome = $("#usuario_nome").val();
		var usuario_email = $("#usuario_email").val();
		var usuario_senha = $("#usuario_senha").val();
		var usuario_tipo = $("#usuario_tipo").val();
		
		if($("#usuario_visu_projetos").is(":checked"))	{var usuario_visu_projetos = "S";}
		else											{var usuario_visu_projetos = "N";}
		
		if($("#usuario_cada_projetos").is(":checked"))	{var usuario_cada_projetos = "S";}
		else											{var usuario_cada_projetos = "N";}
		
		if($("#usuario_edit_projetos").is(":checked"))	{var usuario_edit_projetos = "S";}
		else											{var usuario_edit_projetos = "N";}
		
		if($("#usuario_excl_projetos").is(":checked"))	{var usuario_excl_projetos = "S";}
		else											{var usuario_excl_projetos = "N";}
		
		if($("#usuario_visu_usuarios").is(":checked"))	{var usuario_visu_usuarios = "S";}
		else											{var usuario_visu_usuarios = "N";}
		
		if($("#usuario_cada_usuarios").is(":checked"))	{var usuario_cada_usuarios = "S";}
		else											{var usuario_cada_usuarios = "N";}
		
		if($("#usuario_edit_usuarios").is(":checked"))	{var usuario_edit_usuarios = "S";}
		else											{var usuario_edit_usuarios = "N";}
		
		if($("#usuario_excl_usuarios").is(":checked"))	{var usuario_excl_usuarios = "S";}
		else											{var usuario_excl_usuarios = "N";}
		
		if($("#usuario_visu_solicitacao").is(":checked"))	{var usuario_visu_solicitacao = "S";}
		else											{var usuario_visu_solicitacao = "N";}
		
		if($("#usuario_cada_solicitacao").is(":checked"))	{var usuario_cada_solicitacao = "S";}
		else											{var usuario_cada_solicitacao = "N";}
		
		if($("#usuario_edit_solicitacao").is(":checked"))	{var usuario_edit_solicitacao = "S";}
		else											{var usuario_edit_solicitacao = "N";}
		
		if($("#usuario_excl_solicitacao").is(":checked"))	{var usuario_excl_solicitacao = "S";}
		else											{var usuario_excl_solicitacao = "N";}
		
		if($("#usuario_visu_rotina").is(":checked"))	{var usuario_visu_rotina = "S";}
		else											{var usuario_visu_rotina = "N";}
		
		if($("#usuario_cada_rotina").is(":checked"))	{var usuario_cada_rotina = "S";}
		else											{var usuario_cada_rotina = "N";}
		
		if($("#usuario_edit_rotina").is(":checked"))	{var usuario_edit_rotina = "S";}
		else											{var usuario_edit_rotina = "N";}
		
		if($("#usuario_excl_rotina").is(":checked"))	{var usuario_excl_rotina = "S";}
		else											{var usuario_excl_rotina = "N";}
		
		if($("#usuario_visu_configuracao").is(":checked"))	{var usuario_visu_configuracao = "S";}
		else											{var usuario_visu_configuracao = "N";}
		
		if($("#usuario_edit_configuracao").is(":checked"))	{var usuario_edit_configuracao = "S";}
		else											{var usuario_edit_configuracao = "N";}
		
		$.ajax({
				type: 'POST',
				url: 'backend/usuarios/zeditausuarios.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						usuario_id: usuario_id,
						usuario_nome: usuario_nome,
						usuario_email: usuario_email,
						usuario_senha: usuario_senha,
						usuario_tipo: usuario_tipo,
						usuario_visu_projetos: usuario_visu_projetos,
						usuario_cada_projetos: usuario_cada_projetos,
						usuario_edit_projetos: usuario_edit_projetos,
						usuario_excl_projetos: usuario_excl_projetos,
						usuario_visu_usuarios: usuario_visu_usuarios,
						usuario_cada_usuarios: usuario_cada_usuarios,
						usuario_edit_usuarios: usuario_edit_usuarios,
						usuario_excl_usuarios: usuario_excl_usuarios,
						usuario_visu_solicitacao: usuario_visu_solicitacao,
						usuario_cada_solicitacao: usuario_cada_solicitacao,
						usuario_edit_solicitacao: usuario_edit_solicitacao,
						usuario_excl_solicitacao: usuario_excl_solicitacao,
						usuario_visu_rotina: usuario_visu_rotina,
						usuario_cada_rotina: usuario_cada_rotina,
						usuario_edit_rotina: usuario_edit_rotina,
						usuario_excl_rotina: usuario_excl_rotina,
						usuario_visu_configuracao: usuario_visu_configuracao,
						usuario_edit_configuracao: usuario_edit_configuracao},
				async: false
				})
			.done(function(dados)
				{
				$("#carregando").hide();
				$("#temporario_editusuarios").remove();
				
				if(dados == "OK")
					{
					exibemensagem('Usuário alterado com sucesso!', 'success');
					}
				else
					{
					exibemensagem(dados, 'alert');
					}

				$("#container_botoesusuarios").show();
				$("#container_pesquisausuarios").show();
				$("#conteiner_exibeusuarios").show();
				retornausuarios('N', '');
				});
		}
		
	function remove_usuario(usuario_id)
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		$.ajax({
				type: 'POST',
				url: 'backend/usuarios/zremoveusuarios.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						usuario_id: usuario_id},
				async: false
				})
			.done(function(dados)
				{
				$("#carregando").hide();
				$("#temporario_mensagens").remove();
				
				if(dados == "")
					{
					exibemensagem('Usuário removido com sucesso!', 'success');
					}
				else
					{
					exibemensagem(dados, 'alert');
					}
				
				retornausuarios('N', '');
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