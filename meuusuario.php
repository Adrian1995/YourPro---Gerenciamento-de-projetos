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
	$usuario_nomecompleto = $dados["usuario_nomecompleto"];
	$usuario_telefone = $dados["usuario_telefone"];
	$usuario_cargo = $dados["usuario_cargo"];
	$usuario_foto = $dados["usuario_foto"];
	?>

<div class="container-fluid">

	<div class="row" id="container_mensagens">
		<?php if(!empty($_GET["a"]))
			{
			echo "<div id='temporario_mensagens'><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Informações salvas com sucesso!</div></div>";
			}
		?>
	</div>
	
	<div class="col-md-10 col-md-offset-1">
		<div id="container_meuusuario">
		<form action="backend/usuarios/zsalvameuusuario.php" METHOD="POST" enctype="multipart/form-data">
			<div class="col-md-3" id="container_foto">
			<br>
			<?php
			if($usuario_foto != "")
				{
				echo "<img src='backend/usuarios/imgusuarios/$usuario_foto' class='img-thumbnail img-responsive' id='usuario_foto'>";
				echo "<button type='button' class='btn btn-primary' id='btn_alterafoto' onclick='alterafoto()'><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Alterar foto</button>";
				}
			else
				{
				echo "<input type='file' name='foto' id='foto' accept='gif|jpeg' onchange='validaExtensao()'/>";
				}
			?>
			<input type='hidden' name='statusfoto' id='statusfoto' value='N'>
			</div>
			<div class="col-md-6 col-md-offset-1">
			<br>
			<input type="hidden" name="sessao" value="<?php echo $Sessao; ?>">
			<input type="hidden" name="usuario_id" value="<?php echo $ID; ?>">
			<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span> <input type='text' name='usuario_nomecompleto' class='form-control' aria-describedby='sizing-addon2' value='<?php echo $usuario_nomecompleto; ?>'></div>
			<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Telefone</span> <input type='text' name='usuario_telefone' class='form-control' aria-describedby='sizing-addon2' value='<?php echo $usuario_telefone; ?>'></div>
			<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Cargo</span> <input type='text' name='usuario_cargo' class='form-control' aria-describedby='sizing-addon2' value='<?php echo $usuario_cargo; ?>'></div>
			<br>
			<button type='submit' class='btn btn-success btn-lg'><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Salvar informações</button>
			</div>
		</form>
		</div>
	</div>


		
</div>
<script><!--Valida imagem a carregar-->

	function validaExtensao()
		{
		var id = "foto";
		
			var extensoes = new Array('bmp','jpg','png');
			
			var ext = $('#'+id).val().split(".")[1].toLowerCase();
			
			if($.inArray(ext, extensoes) == -1)
				{
				alert("Arquivo não permitido: Possui extensão ."+ext);
				$('#'+id).val("").empty();
				}
				
		$("#statusfoto").attr("value", "A");
		}
		
	$('#foto').bind('change', function()
		{
		var tamanhoFotoMaximo;
		tamanhoFotoMaximo = "1572864";
		
		var tamanhoFoto;
		tamanhoFoto = this.files[0].size;
		
		if(tamanhoFoto > tamanhoFotoMaximo)
			{
			alert("Arquivo não permitido: Imagem deve ser menor que 1,5 mb")
			$('#foto').val("").empty();
			}
		
		});
</script>
<script>
$(document).ready(function() 
	{	
	$("#meuusuario").addClass("active");
	
	});
	
	function alterafoto()
		{
		$("#usuario_foto").remove();
		$("#btn_alterafoto").remove();
		
		$("#container_foto").append("<input type='file' name='foto' id='foto' accept='gif|jpeg' onchange='validaExtensao()'/>");
		$("#statusfoto").attr("value", "R");
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