<?php
	include ("includes/yverificaAcessoCookie.inc");
?>
<html>
<head>
	<?php	include ("includes/yhead.inc");	?>
</head>
<body>
	<?php	include ("includes/ymenu.inc");
			include('backend/yconectaDB.inc');
	?>

<div class="container-fluid">
	<form action="backend/configuracoes/zsalvaconfiguracoes.php" METHOD="POST" enctype="multipart/form-data">
		<input type="hidden" name="sessao" value="<?php echo $Sessao; ?>">
		<input type="hidden" name="usuario_id" value="<?php echo $ID; ?>">
	<div class="row" id="container_mensagens">
		<?php if(!empty($_GET["a"]))
			{
			echo "<div id='temporario_mensagens'><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Informações salvas com sucesso!</div></div>";
			}
		?>
	</div>
	
	<!--==================================================================================Itens-->
	<?php
	$consultaConfiguracoes = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes");
	$dados = mysqli_fetch_array($consultaConfiguracoes);
	$itens_eventos = $dados["itens_eventos"];
	$itens_projetos = $dados["itens_projetos"];
	$itens_usuarios = $dados["itens_usuarios"];
	$itens_solicitacoesadm = $dados["itens_solicitacoesadm"];
	$itens_rotinas = $dados["itens_rotinas"];
	$itens_solicitacoes = $dados["itens_solicitacoes"];
	$exige_solicitacaonoprojeto = $dados["exige_solicitacaonoprojeto"];
	?>
	<div class="row">	
		<div class="col-md-10">
		<h3>Itens por página</h3>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-2">
		Eventos
		<input type="number" name="itens_eventos" id="itens_eventos" class="form-control" value="<?php echo $itens_eventos; ?>">
		</div>
		<div class="col-md-2">
		Projetos
		<input type="number" name="itens_projetos" id="itens_projetos" class="form-control" value="<?php echo $itens_projetos; ?>">
		</div>
		<div class="col-md-2">
		Usuários
		<input type="number" name="itens_usuarios" id="itens_usuarios" class="form-control" value="<?php echo $itens_usuarios; ?>">
		</div>
		<div class="col-md-2">
		Adm. de Solicitações
		<input type="number" name="itens_solicitacoesadm" id="itens_solicitacoesadm" class="form-control" value="<?php echo $itens_solicitacoesadm; ?>">
		</div>
		<div class="col-md-2">
		Solicitações usuários
		<input type="number" name="itens_solicitacoes" id="itens_solicitacoes" class="form-control" value="<?php echo $itens_solicitacoes; ?>">
		</div>
		<div class="col-md-2">
		Rotinas
		<input type="number" name="itens_rotinas" id="itens_rotinas" class="form-control" value="<?php echo $itens_rotinas; ?>">
		</div>
	</div>
	
	
	
	
	
	<!--==================================================================================Status dos projetos-->
	<div class="row">
		<div class="col-md-3 col-md-offset-1" id="container_status_projetos">
		<br>
		<h3>Status de projetos</h3>
		<div class='input-group'>
			<input type='text' class='form-control' aria-describedby='basic-addon2' id='novo_status_projetos'>
			<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-plus-sign' type='button' onclick='adiciona_status_projetos()'></button></span>
		</div>
		<?php
		$consultaStatusProjetos = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes_status_projetos ORDER BY status_id");
		while ($dados = mysqli_fetch_array($consultaStatusProjetos))
			{
			$status_id = $dados["status_id"];
			$status_nome = $dados["status_nome"];
			
			echo "<div class='input-group' id='status_projetos$status_id'>";
				echo "<input type='text' class='form-control' aria-describedby='basic-addon2' name='status_nome$status_id' id='status_nome$status_id' value='$status_nome'>";
				 echo "<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-remove-circle' type='button' onclick='exclui_status_projetos($status_id)'></button></span>";
			echo "</div>";
			}
		$numeroStatusProjetos = $status_id;
		?>
		<input type="hidden" name="numero_status" id="numero_status" value="<?php echo $numeroStatusProjetos; ?>">
		</div>
	
	
	
		<div class="col-md-3" id="container_tipos_projetos">
		<br>
		<h3>Tipos de projetos</h3>
		<div class='input-group'>
			<input type='text' class='form-control' aria-describedby='basic-addon2' id='novo_tipos_projetos'>
			<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-plus-sign' type='button' onclick='adiciona_tipos_projetos()'></button></span>
		</div>
		<?php
		$consultaTiposProjetos = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes_tipos ORDER BY tipo_id");
		while ($dados = mysqli_fetch_array($consultaTiposProjetos))
			{
			$tipo_id = $dados["tipo_id"];
			$tipo_nome = $dados["tipo_nome"];
			
			echo "<div class='input-group' id='tipos_projetos$tipo_id'>";
				echo "<input type='text' class='form-control' aria-describedby='basic-addon2' name='tipos_nome$tipo_id' id='tipos_nome$tipo_id' value='$tipo_nome'>";
				echo "<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-remove-circle' type='button' onclick='exclui_tipos_projetos($tipo_id)'></button></span>";
			echo "</div>";
			}
		$numeroTiposProjetos = $tipo_id;
		?>
		<input type="hidden" name="numero_tipos" id="numero_tipos" value="<?php echo $numeroTiposProjetos; ?>">
		</div>
	
	
	
		<div class="col-md-4" id="container_perguntas">
		<br>
		<h3>Perguntas aos usuários</h3>
		<div class='input-group'>
			<input type='text' class='form-control' aria-describedby='basic-addon2' id='novo_perguntas'>
			<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-plus-sign' type='button' onclick='adiciona_perguntas()'></button></span>
		</div>
		<?php
		$consultaPerguntas = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes_perguntas ORDER BY pergunta_id");
		while ($dados = mysqli_fetch_array($consultaPerguntas))
			{
			$pergunta_id = $dados["pergunta_id"];
			$pergunta_texto = $dados["pergunta_texto"];
			
			echo "<div class='input-group' id='perguntas$pergunta_id'>";
				echo "<input type='text' class='form-control' aria-describedby='basic-addon2' name='perguntas$pergunta_id' id='perguntas$pergunta_id' value='$pergunta_texto'>";
				echo "<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-remove-circle' type='button' onclick='exclui_perguntas($pergunta_id)'></button></span>";
			echo "</div>";
			}
		$numeroPerguntas = $pergunta_id;
		?>
		<input type="hidden" name="numero_perguntas" id="numero_perguntas" value="<?php echo $numeroPerguntas; ?>">
		</div>
	</div>
	
	
	
	
	<div class="row">
		<div class="col-md-3 col-md-offset-1" id="container_status_solicitacoes">
		<br>
		<h3>Status das solicitações</h3>
		<div class='input-group'>
			<input type='text' class='form-control' aria-describedby='basic-addon2' id='novo_status_solicitacoes'>
			<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-plus-sign' type='button' onclick='adiciona_status_solicitacoes()'></button></span>
		</div>
		<?php
		$consultaStatusSolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes_status_solicitacoes ORDER BY status_id");
		while ($dados = mysqli_fetch_array($consultaStatusSolicitacoes))
			{
			$status_id = $dados["status_id"];
			$status_nome = $dados["status_nome"];
			
			echo "<div class='input-group' id='status_solicitacoes$status_id'>";
				echo "<input type='text' class='form-control' aria-describedby='basic-addon2' name='status_solicitacoes$status_id' id='status_solicitacoes$status_id' value='$status_nome'>";
				echo "<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-remove-circle' type='button' onclick='exclui_status_solicitacoes($status_id)'></button></span>";
			echo "</div>";
			}
		$numeroStatusSolicitacoes = $status_id;
		?>
		<input type="hidden" name="numero_status_solicitacoes" id="numero_status_solicitacoes" value="<?php echo $numeroStatusSolicitacoes; ?>">
		</div>

		
		<div class="col-md-3" id="container_outrasconfiguracoes">
			<br>
			<h3>Outras configurações</h3>
			<label for="exige_solicitacaonoprojeto">Exigir solicitação para o projeto?     <input type="checkbox" name="exige_solicitacaonoprojeto" id="exige_solicitacaonoprojeto" <?php if($exige_solicitacaonoprojeto == "S"){echo "checked";} ?>></label>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-3 col-md-offset-1" id="container_status_projetos">
		<br><br>
		<?php
		
		$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$ID'");
		$dados = mysqli_fetch_array($consultaUsuarios);
		$usuario_edit_configuracao = $dados["usuario_edit_configuracao"];
		
		if($usuario_edit_configuracao == "S")
			{
			echo "<button type='submit' class='btn btn-success btn-lg'><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Salvar informações</button>";
			}
		?>
		</div>
	</div>
	</form>
</div>


		
<script>
$(document).ready(function() 
	{	
	$("#configuracoes").addClass("active");
	
	});
	
	function adiciona_status_projetos()
		{
		var novo_status_projetos = $("#novo_status_projetos").val();
		
		var numero_status = $("#numero_status").val();
		var numero_status = parseInt(numero_status);
		$("#numero_status").val(numero_status + 1);
		var numero_status = $("#numero_status").val();
		
		$("#container_status_projetos").append("<div class='input-group' id='status_projetos"+numero_status+"'>"+
												"<input type='text' class='form-control' aria-describedby='basic-addon2' name='status_nome"+numero_status+"' id='status_nome"+numero_status+"' value='"+novo_status_projetos+"'>"+
												"<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-remove-circle' type='button' onclick='exclui_status_projetos("+numero_status+")'></button></span>"+
												"</div>");
		}
		
	function exclui_status_projetos(numero_status)
		{
		$("#status_projetos"+numero_status).remove();
		}
	
	
	
	function adiciona_tipos_projetos()
		{
		var novo_tipos_projetos = $("#novo_tipos_projetos").val();
		
		var numero_tipos = $("#numero_tipos").val();
		var numero_tipos = parseInt(numero_tipos);
		$("#numero_tipos").val(numero_tipos + 1);
		var numero_tipos = $("#numero_tipos").val();
		
		$("#container_tipos_projetos").append("<div class='input-group' id='tipos_projetos"+numero_tipos+"'>"+
												"<input type='text' class='form-control' aria-describedby='basic-addon2' name='tipos_nome"+numero_tipos+"' id='tipos_nome"+numero_tipos+"' value='"+novo_tipos_projetos+"'>"+
												"<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-remove-circle' type='button' onclick='exclui_tipos_projetos("+numero_tipos+")'></button></span>"+
												"</div>");
		}
		
	function exclui_tipos_projetos(numero_tipos)
		{
		$("#tipos_projetos"+numero_tipos).remove();
		}
	
	
	
	function adiciona_perguntas()
		{
		var novo_perguntas = $("#novo_perguntas").val();
		
		var numero_perguntas = $("#numero_perguntas").val();
		var numero_perguntas = parseInt(numero_perguntas);
		$("#numero_perguntas").val(numero_perguntas + 1);
		var numero_perguntas = $("#numero_perguntas").val();
		
		$("#container_perguntas").append("<div class='input-group' id='perguntas"+numero_perguntas+"'>"+
												"<input type='text' class='form-control' aria-describedby='basic-addon2' name='perguntas"+numero_perguntas+"' id='perguntas"+numero_perguntas+"' value='"+novo_perguntas+"'>"+
												"<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-remove-circle' type='button' onclick='exclui_perguntas("+numero_perguntas+")'></button></span>"+
												"</div>");
		}
		
	function exclui_perguntas(numero_perguntas)
		{
		$("#perguntas"+numero_perguntas).remove();
		}
	
	
	
	
	function adiciona_status_solicitacoes()
		{
		var novo_status_solicitacoes = $("#novo_status_solicitacoes").val();
		
		var numero_status_solicitacoes = $("#numero_status_solicitacoes").val();
		var numero_status_solicitacoes = parseInt(numero_status_solicitacoes);
		$("#numero_status_solicitacoes").val(numero_status_solicitacoes + 1);
		var numero_status_solicitacoes = $("#numero_status_solicitacoes").val();
		
		$("#container_status_solicitacoes").append("<div class='input-group' id='status_solicitacoes"+numero_status_solicitacoes+"'>"+
												"<input type='text' class='form-control' aria-describedby='basic-addon2' name='status_solicitacoes"+numero_status_solicitacoes+"' id='status_solicitacoes"+numero_status_solicitacoes+"' value='"+novo_status_solicitacoes+"'>"+
												"<span class='input-group-btn'><button class='btn btn-default glyphicon glyphicon-remove-circle' type='button' onclick='exclui_status_solicitacoes("+numero_status_solicitacoes+")'></button></span>"+
												"</div>");
		}
		
	function exclui_status_solicitacoes(numero_status_solicitacoes)
		{
		$("#status_solicitacoes"+numero_status_solicitacoes).remove();
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