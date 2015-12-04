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
	$usuario_edit_projetos = $dados["usuario_edit_projetos"];
	?>

<div class="container-fluid">

	<div class="row" id="container_mensagens">
		<?php 
		if(!empty($_GET["a"]))
			{
			echo "<div id='temporario_mensagens'><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Erro relatado com sucesso!</div></div>";
			}
		if($usuario_edit_projetos == "N")
			{
			echo "<div id='temporario_mensagens'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Usuário não pode relatar erro, pois não possui acesso a edição de projetos!</div></div>";
			}
		?>
	</div>
	
	<div class="col-md-10 col-md-offset-1">
		<div id="container_relatarerro">
		<form action='backend/projetos/relatarerro/zcadastraerro.php' METHOD='POST' enctype='multipart/form-data'>
			<h3>Relatar erro</h3>
			<input type="hidden" name="sessao" value="<?php echo $Sessao; ?>">
			<input type="hidden" name="usuario_id" value="<?php echo $ID; ?>">
			<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Erro no projeto : </span>
				<select class='form-control' aria-describedby='sizing-addon2' name='erro_projeto_id'>
				<option value=''>Selecione...
				<?php
				$consultaProjetos = mysqli_query($conectaBanco ,"SELECT * FROM projetos ORDER BY projeto_id");
					while($dados = mysqli_fetch_array($consultaProjetos))
					{
					$projeto_id = $dados["projeto_id"];
					$projeto_nome = $dados["projeto_nome"];
					
					echo "<option value='$projeto_id'>$projeto_id :: $projeto_nome";
					}
				?>
				</select>
			</div>
			<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Atribuir erro a usuário : </span>
				<select class='form-control' aria-describedby='sizing-addon2' name='erro_usuario_id'>
				<option value=''>Selecione...
				<?php
				$consultausuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_tipo = 'Normal' ORDER BY usuario_id");
					while($dados = mysqli_fetch_array($consultausuarios))
					{
					$usuario_id = $dados["usuario_id"];
					$usuario_nome = $dados["usuario_nome"];
					
					echo "<option value='$usuario_id'>$usuario_id :: $usuario_nome";
					}
				?>
				</select>
			</div>
			<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome do erro : </span>
				<input type='text' class='form-control' aria-describedby='sizing-addon2' name='erro_nome'>
			</div>
			<textarea class='form-control' rows='10' placeholder='Insira a descrição do erro...' name='erro_descricao'></textarea>
			<input type='file' class='form-control' name='foto1' id='foto1' onchange='validaExtensao("foto1")' />
			<input type='file' class='form-control' name='foto2' id='foto2' onchange='validaExtensao("foto2")' />
			<input type='file' class='form-control' name='foto3' id='foto3' onchange='validaExtensao("foto3")' />
			<input type='file' class='form-control' name='foto4' id='foto4' onchange='validaExtensao("foto4")' />
			<input type='file' class='form-control' name='foto5' id='foto5' onchange='validaExtensao("foto5")' />
			<br>
			<input type='submit' class='btn btn-success btn-lg' value='Enviar erro'>
		</form>
		</div>
	</div>


</div>
<script><!--Valida imagem a carregar-->
		
	function validaExtensao(id)
		{
			var extensoes = new Array('bmp','jpg','png');
			
			var ext = $('#'+id).val().split(".")[1].toLowerCase();
			
			if($.inArray(ext, extensoes) == -1)
				{
				alert("Arquivo não permitido: Possui extensão ."+ext);
				$('#'+id).val("").empty();
				}
		}
		
	$('#foto1').bind('change', function()
		{
		var tamanhoFotoMaximo;
		tamanhoFotoMaximo = "2048000";
		
		var tamanhoFoto;
		tamanhoFoto = this.files[0].size;
		
		if(tamanhoFoto > tamanhoFotoMaximo)
			{
			alert("Arquivo não permitido: Tamanho deve ser menor que 2 mb")
			$('#foto1').val("").empty();
			}
		
		});
	$('#foto2').bind('change', function()
		{
		var tamanhoFotoMaximo;
		tamanhoFotoMaximo = "2048000";
		
		var tamanhoFoto;
		tamanhoFoto = this.files[0].size;
		
		if(tamanhoFoto > tamanhoFotoMaximo)
			{
			alert("Arquivo não permitido: Tamanho deve ser menor que 2 mb")
			$('#foto2').val("").empty();
			}
		
		});
	$('#foto3').bind('change', function()
		{
		var tamanhoFotoMaximo;
		tamanhoFotoMaximo = "2048000";
		
		var tamanhoFoto;
		tamanhoFoto = this.files[0].size;
		
		if(tamanhoFoto > tamanhoFotoMaximo)
			{
			alert("Arquivo não permitido: Tamanho deve ser menor que 2 mb")
			$('#foto3').val("").empty();
			}
		
		});
	$('#foto4').bind('change', function()
		{
		var tamanhoFotoMaximo;
		tamanhoFotoMaximo = "2048000";
		
		var tamanhoFoto;
		tamanhoFoto = this.files[0].size;
		
		if(tamanhoFoto > tamanhoFotoMaximo)
			{
			alert("Arquivo não permitido: Tamanho deve ser menor que 2 mb")
			$('#foto4').val("").empty();
			}
		
		});
	$('#foto5').bind('change', function()
		{
		var tamanhoFotoMaximo;
		tamanhoFotoMaximo = "2048000";
		
		var tamanhoFoto;
		tamanhoFoto = this.files[0].size;
		
		if(tamanhoFoto > tamanhoFotoMaximo)
			{
			alert("Arquivo não permitido: Tamanho deve ser menor que 2 mb")
			$('#foto5').val("").empty();
			}
		
		});
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