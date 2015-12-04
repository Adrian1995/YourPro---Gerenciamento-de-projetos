<?php 

$filename = 'backend/yconectaDB.inc';
		if (file_exists($filename)) 
			{} 
		else {
			header("Location: instalacao_Banco_Tabelas_e_Arquivo.php");
			}

	if(!empty($_GET['a']))
		{
		$a = $_GET['a'];
		
		if($a == "si")
			{
			echo "<div class='alert alert-danger alert-dismissible' role='alert'>";
			echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
			echo "<strong>Não foi possível acessar!</strong> O login ou senha estão incorretos.";
			echo "</div>";
			}
		if($a == "first")
			{
			echo "<div class='alert alert-success alert-dismissible' role='alert'>";
			echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
			echo "<strong>Esse é o primeiro acesso!</strong> Utilize o login = admin@admin.com e a senha = admin, logo após efetue a alteração de senha!";
			echo "</div>";
			}
		if($a == "firsta")
			{
			echo "<div class='alert alert-success alert-dismissible' role='alert'>";
			echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
			echo "<strong>Senha alterada com sucesso!</strong> Realize seu primeiro login com a nova senha!";
			echo "</div>";			
			}
		if($a == "ac")
			{
			setcookie('IDCookie', "", time()-3600);
			setcookie('SessaoCookie', "", time()-3600);
			}
		}
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
			<form action="menu_Principal.php" method="POST">
				<div class="input-group">
				<div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
					<input type="text" name="Usuario_Email" id="Usuario_Email" class="form-control" placeholder="Insira o Email">
				</div>
				<div class="input-group">
				<div class="input-group-addon"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></div>
					<input type="password" name="Usuario_Senha" id="Usuario_Senha" class="form-control" placeholder="Insira a Senha">
				</div>
			<input type="hidden" name="verificaLogin" value="Sim">
			<br>
			<input type="submit" class="btn btn-primary btn-lg center-block" value="Acessar" id="btnAcessar">
			</form>	
		</div>
		<div class="col-md-7 col-md-offset-1">
			<br>
			<div class="letraLogo"><h2>yourPro</h2><h3>Gerenciador de projetos</h3></div>
			<br>
			<br>
			Duvidas de como utilizar o software? Acesse o manual clicando <a href="manual.php">Aqui!<a/>
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