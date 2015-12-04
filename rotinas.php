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
	$usuario_visu_rotina_atual = $dados["usuario_visu_rotina"];
	$usuario_cada_rotina_atual = $dados["usuario_cada_rotina"];
	?>

<div class="container-fluid">

	<div class="row" id="container_mensagens">
		<?php if($usuario_visu_rotina_atual == "N")
			{
			echo "<div id='temporario_mensagens'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Erro ao acessar...</strong> Você não possui acesso a visualização de rotinas!</div></div>";
			}
		?>
	</div>
	
	<div class="row" id="carregando"><h5><img src='img/carregando.gif'>  Carregando...</h5></div>
	
	<div class="row" id="container_botoesrotinas" <?php if($usuario_cada_rotina_atual == "N" or $usuario_visu_rotina_atual == "N"){echo "hidden";}?>>
		<div class="col-md-2">
			<button type="button" class="btn btn-default" id="btn_NovaRotina" onclick="abreformulario_novarotina()">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nova rotina
			</button>
		</div>
	</div>

	
	<div class="row" id="container_cadrotinas">
	</div>
	<div class="row" id="container_visurotinas">
	</div>
	<div class="row" id="container_editrotinas">
	</div>
	

	<div class="row" id="container_pesquisarotinas" <?php if($usuario_visu_rotina_atual == "N"){echo "hidden";}?>>
		<div class="col-md-6 col-md-offset-1">
			<br>
			Pesquisar rotinas por:&nbsp;&nbsp;
			<input type="radio" name="pesquisarotinas" id="id" checked><label for="id"> &nbsp;ID</label>&nbsp;&nbsp;
			<input type="radio" name="pesquisarotinas" id="nome"><label for="nome"> &nbsp;Nome</label>&nbsp;&nbsp;
			<input type="text" id="textopesquisa" class="form-control">
		</div>
		<div class="col-md-3">
			<br>
			<br>
			<button type="button" class="btn btn-default" id="btn_pesquisarrotinas" onclick="retornarotinas('S', '')">
				<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
			</button>
		</div>
	</div>

	<div class="row" id="conteiner_exiberotinas" <?php if($usuario_visu_rotina_atual == "N"){echo "hidden";}?>>
		<div class="col-md-10 col-md-offset-1">
			<div id="container_rotinas">
			</div>
		</div>
	</div>

	
</div>
	
<script>
$(document).ready(function() 
	{	
	$("#carregando").hide();
	
	$("#rotinas").addClass("active");
	
	retornarotinas('N', '');
	});
	
	function retornarotinas(pesquisa, paginasolicitada)
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
		
		$.ajax({
				type: 'POST',
				url: 'backend/rotinas/zretornarotinas.php',
				data: {	usuario_id_atual: <?php echo $ID?>,
						pesquisa: pesquisa,
						textopesquisa: textopesquisa,
						id: id,
						nome: nome,
						paginasolicitada: paginasolicitada},
				async: false
				})
			.done(function(dados)
				{
				$("#carregando").hide();
				$("#temporario_rotinas").remove();
				$("#container_rotinas").append("<div id='temporario_rotinas'><h3>Rotinas</h3>"+dados+"</div>");
				});
		}

	function abreformulario_novarotina()
		{
		$("#container_botoesrotinas").hide();
		$("#container_pesquisarotinas").hide();
		$("#conteiner_exiberotinas").hide();
		
		$("#container_cadrotinas").append("<div class='col-md-10 col-md-offset-1' id='temporario_cadrotinas'>"+
											"<h3>Cadastro de nova rotina</h3>"+
											"<br>"+
											"<div class='row'>"+
											"<div class='col-md-8'>"+
											"<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span> <input type='text' id='rotina_nome' class='form-control' aria-describedby='sizing-addon2'></div>"+
											"<br>"+
											"<textarea class='form-control' rows='10' id='rotina_descricao' placeholder='Insira a descrição da rotina...'></textarea>"+
											"<br>"+
											"<button type='button' class='btn btn-primary' id='btn_SalvarRotina' onclick='salvar_novarotina()'>"+
											"<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Salvar"+
											"</button>"+
											"<br><br>"+
											"</div></div></div>");
		}

	function salvar_novarotina()
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		var rotina_nome = $("#rotina_nome").val();
		var rotina_descricao = $("#rotina_descricao").val();
		
		$.ajax({
				type: 'POST',
				url: 'backend/rotinas/zcadastrarotinas.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						rotina_nome: rotina_nome,
						rotina_descricao: rotina_descricao},
				async: false
				})
			.done(function(dados)
				{
				if(dados == "OK")
					{
					exibemensagem('Rotina cadastrada com sucesso!', 'success')
					}
				else
					{
					exibemensagem(dados, 'alert');
					}
				
				$("#carregando").hide();
				$("#temporario_cadrotinas").remove();

				$("#container_botoesrotinas").show();
				$("#container_pesquisarotinas").show();
				$("#conteiner_exiberotinas").show();
				
				retornarotinas('N', '');
				});
		}
	
	function visualiza_rotina(rotina_id)
		{
		$("#container_botoesrotinas").hide();
		$("#container_pesquisarotinas").hide();
		$("#conteiner_exiberotinas").hide();
		$("#temporario_mensagens").remove();
		
		$.ajax({
				type: 'POST',
				url: 'backend/rotinas/zretornarotinaunica_Visualizar.php',
				data: { usuario_id_atual: <?php echo $ID; ?>,
						rotina_id: rotina_id},
				async: false
				})
			.done(function(dados)
				{
				$("#temporario_visurotinas").remove();
				$("#container_visurotinas").append(dados);
				});
		}
	
	function edita_rotina(rotina_id)
		{
		$("#container_botoesrotinas").hide();
		$("#container_pesquisarotinas").hide();
		$("#conteiner_exiberotinas").hide();
		$("#temporario_mensagens").remove();
		$("#temporario_visurotinas").remove();
		
		$.ajax({
				type: 'POST',
				url: 'backend/rotinas/zretornarotinaunica_Editar.php',
				data: {	rotina_id: rotina_id},
				async: false
				})
			.done(function(dados)
				{
				$("#temporario_editrotinas").remove();
				$("#container_editrotinas").append(dados);
				});
		}
		
	function salvaedicao_rotina(rotina_id)
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		var rotina_nome = $("#rotina_nome").val();
		var rotina_descricao = $("#rotina_descricao").val();
		
		$.ajax({
				type: 'POST',
				url: 'backend/rotinas/zeditarotinas.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						rotina_id: rotina_id,
						rotina_nome: rotina_nome,
						rotina_descricao: rotina_descricao},
				async: false
				})
			.done(function(dados)
				{
				$("#carregando").hide();
				$("#temporario_editrotinas").remove();
				
				if(dados == "OK")
					{
					exibemensagem('Usuário alterado com sucesso!', 'success');
					}
				else
					{
					exibemensagem(dados, 'alert');
					}

				$("#container_botoesrotinas").show();
				$("#container_pesquisarotinas").show();
				$("#conteiner_exiberotinas").show();
				retornarotinas('N', '');
				});
		}
		
	function remove_rotina(rotina_id)
		{
		$("#carregando").show();
		$("body, html").animate({scrollTop:0}, "slow");
		
		$.ajax({
				type: 'POST',
				url: 'backend/rotinas/zremoverotinas.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						rotina_id: rotina_id},
				async: false
				})
			.done(function(dados)
				{
				$("#carregando").hide();
				$("#temporario_mensagens").remove();
				
				if(dados == "")
					{
					exibemensagem('Rotina removida com sucesso!', 'success');
					}
				else
					{
					exibemensagem(dados, 'alert');
					}
				
				retornarotinas('N', '');
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