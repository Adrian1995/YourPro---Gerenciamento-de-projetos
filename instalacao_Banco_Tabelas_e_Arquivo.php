<html>
<head>
	<?php	include ("includes/yhead.inc");	?>
</head>
<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 col-md-offset-1">
			<br>
			<br>
			<img src="img/logogrande.png" class="img-responsive center-block">
			<br>
		</div>
		<div class="col-md-3">
			<br>
			<br>			
			<form action="backend/zInstalacao_Banco_Tabelas_e_Arquivo_Conexao_Back.php" method="POST">
			<h3>Instalação do software.</h3><br>
			<h4>1º Crie um banco de dados em seu servidor.</h4>
			<h4>2º Insira as informações do banco de dados criado abaixo e clique em "Instalar".</h4><br>
			<div id="lb_host">Host:</div> <input type="text" name="host" id="host" class="form-control" value="localhost">
			<div id="lb_usuario">Usuário:</div> <input type="text" name="usuario" id="usuario" class="form-control" value="root">
			<div id="lb_senha">Senha:</div> <input type="password" name="senha" id="senha" class="form-control">
			<div id="lb_nomedobanco">Nome do Banco de dados:</div> <input type="text" name="nomedobanco" id="nomedobanco" class="form-control" value="yourpro">
			<br>
			<input type="submit" value="Instalar" id="btn_InstaBanco"class="btn btn-primary">

			</form>
	
		</div>
	</div>
</div>


</body>
</html>