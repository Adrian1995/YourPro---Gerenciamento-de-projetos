<?php
	include ("includes/yverificaAcessoCookie.inc");
?>
<html>
<head>
	<?php	include ("includes/yhead.inc");	?>
</head>
<body>

<div class="container-fluid">
	<div class="row">
	<div class="col-md-3 col-md-offset-1">
	
		<br>
		<img src="img/logogrande.png" class="img-responsive center-block">
		<br>
		<br>
		Voce não pode continuar com sua senha padrão (admin), favor realizar alteração abaixo
		<br>
		<br>
		<form action="backend/zalteracaosenhapadrao.php" method="post">
			<input type="hidden" name="usuario_id" value="<?php echo $ID?>">
			<div class="input-group">
			<div class="input-group-addon"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></div>
				<input type="password" name="usuario_senha" id="usuario_senha" class="form-control" placeholder="Insira a nova senha...">
			</div>
			<br>
			<input type="submit" class="btn btn-primary" value="Realizar alteração de senha">
		</form>
	</div>
	</div>
</div>
<script>
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