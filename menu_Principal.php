<?php
	if(!empty($_POST['verificaLogin']))
		{
		$Usuario_Email = $_POST['Usuario_Email'];
		$Usuario_Senha = $_POST['Usuario_Senha'];
		
		$Usuario_Senha =  md5($Usuario_Senha);

		include ("backend/yconectaDB.inc");
		$consultaLogin = mysqli_query($conectaBanco, "SELECT * FROM login WHERE usuario_email = '$Usuario_Email' and usuario_senha = '$Usuario_Senha'") or die (mysql_error());
		$verificaLinhaLogin = mysqli_num_rows ($consultaLogin);
		
		$dados = mysqli_fetch_array($consultaLogin);
		$ID = $dados["usuario_id"];
		$usuario_tipo = $dados["usuario_tipo"];
		
		if($verificaLinhaLogin > 0)
			{
			$id_sessao = md5(rand());
			setcookie('IDCookie', $ID, (time()+(2*36000)));
			setcookie('SessaoCookie', $id_sessao, (time()+(2*36000)));
			$Sessao = $id_sessao;
			}
		else
			{
			header("Location: index.php?a=si");
			}
			
		if($Usuario_Senha == md5("admin"))
			{
			header("Location: alteracaosenhapadrao.php?ID=$ID&Sessao=$Sessao");
			}
			
		if($usuario_tipo == "Solicitante")
			{
			header("Location: solicitacoes.php?ID=$ID&Sessao=$Sessao");
			}
		}
	else
		{
		include ("includes/yverificaAcessoCookie.inc");
		}
?>
<html>
<head>
	<?php	include ("includes/yhead.inc");	?>
</head>
<body>
	<?php	include ("includes/ymenu.inc");	?>
 
<div class="container-fluid">
	<div class="row" id="container_timeline">
	</div>
</div>

	
<script>
$(document).ready(function() 
	{	
	visualiza_timeline('');
	});
	
	function visualiza_timeline(paginasolicitada)
		{
		$.ajax({
				type: 'POST',
				url: 'backend/timeline/zretornatimeline.php',
				data: {	usuario_id_atual: <?php echo $ID; ?>,
						paginasolicitada: paginasolicitada},
				async: true
				})
			.done(function(dados)
				{
				$("#recebe_timeline").remove();
				$("#recebe_eventosparahoje").remove();
				$("#container_timeline").append(dados);
				});
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