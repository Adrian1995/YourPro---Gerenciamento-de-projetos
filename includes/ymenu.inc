<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo "menu_Principal.php?ID=$ID&Sessao=$Sessao"; ?>"><div class="letraLogo"><span>your</span>Pro</div></a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		<li id="projetos"><a href="projetos.php?ID=<?php echo $ID; ?>&Sessao=<?php echo $Sessao; ?>">Projetos</a></li>
        <li id="usuarios"><a href="usuarios.php?ID=<?php echo $ID; ?>&Sessao=<?php echo $Sessao; ?>">Usuários</a></li>
		<li id="solicitacoesadm"><a href="solicitacoesadm.php?ID=<?php echo $ID; ?>&Sessao=<?php echo $Sessao; ?>">Solicitações</a></li>
		<li id="rotinas"><a href="rotinas.php?ID=<?php echo $ID; ?>&Sessao=<?php echo $Sessao; ?>">Rotinas</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<li><a href="#"><span class="glyphicon glyphicon-print" aria-hidden="true" onclick='window.print()'></span></a></li>
		<li id="meuusuario"><a href="meuusuario.php?ID=<?php echo $ID; ?>&Sessao=<?php echo $Sessao; ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>

		<?php
	include('backend/yconectaDB.inc');

	$consultaUsuarios = mysqli_query($conectaBanco, "SELECT * FROM login WHERE usuario_id = '$ID'");
	$dados = mysqli_fetch_array($consultaUsuarios);
	$usuario_visu_configuracao = $dados["usuario_visu_configuracao"];
	
	if($usuario_visu_configuracao == "S")
		{
		echo "<li id='configuracoes'><a href='configuracoes.php?ID=$ID&Sessao=$Sessao'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span></a></li>";
		} 
	?>
        <li><a href="index.php?a=ac">Sair</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>