<?php 
include('../yconectaDB.inc');

//======================================================================================================================CARREGA PERMISSÕES DO USUÁRIO
$usuario_id_atual = $_POST["usuario_id_atual"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id_atual'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_edit_usuarios_atual = $dados["usuario_edit_usuarios"];
$usuario_excl_usuarios_atual = $dados["usuario_excl_usuarios"];
//----------------------------------------------------------------------------------------------------------------------------------------------------

$pesquisa = $_POST["pesquisa"];
$textopesquisa = $_POST["textopesquisa"];
$id = $_POST["id"];
$nome = $_POST["nome"];
$email = $_POST["email"];


if(!empty($_POST["paginasolicitada"]))
		{
		$paginasolicitada = $_POST["paginasolicitada"];
		}
	else {$paginasolicitada = "1";}

$consultaconfiguracao = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes");
$dados = mysqli_fetch_array($consultaconfiguracao);
$itensporpagina = $dados["itens_usuarios"];
	
$inicioConsulta = $paginasolicitada * $itensporpagina;
$inicioConsulta = $inicioConsulta - $itensporpagina;

if($pesquisa == "N")
	{
	$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login ORDER BY usuario_id DESC");
	$NumeroLinhas = mysqli_num_rows($consultaUsuarios);	
	$numPaginas =  $NumeroLinhas / $itensporpagina;	
	
	$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login ORDER BY usuario_id DESC LIMIT $inicioConsulta, $itensporpagina");
	
	echo "<table class='table'>";
	echo "<thead><th>id</th><th>nome</th><th>email</th></thead>";
	while ($dados = mysqli_fetch_array($consultaUsuarios))
		{
		$usuario_id = $dados["usuario_id"];
		$usuario_nome = $dados["usuario_nome"];
		$usuario_email = $dados["usuario_email"];
		
		echo "<tbody><td>$usuario_id</td><td>$usuario_nome</td><td>$usuario_email</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_usuarios_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_usuarios_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
		}
	echo "</table>";
	
	$paginamenostres = $paginasolicitada - 3;
	$paginamenosdois = $paginasolicitada - 2;
	$paginamenosum = $paginasolicitada - 1;
	$paginamaisum = $paginasolicitada + 1;
	$paginamaisdois = $paginasolicitada + 2;
	$paginamaistres = $paginasolicitada + 3;
	
	$verificaExibicao = $numPaginas - $paginasolicitada;
	
	$P = '"N"';
	echo "<div class='btn-group' role='group' aria-label='...'>";
		if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
		if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
		if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
		echo "<button type='button' class='btn btn-primary' onclick='retornausuarios(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
		if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
		if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
		if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
	echo "</div>";
		
	}
else if($pesquisa == "S")
	{
	if($id == "S")
		{
		$consultaUsuariosID = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$textopesquisa' ORDER BY usuario_id DESC");
		
		if(mysqli_num_rows($consultaUsuariosID) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>email</th></thead>";
			while($dados = mysqli_fetch_array($consultaUsuariosID))
				{
				$usuario_id = $dados["usuario_id"];
				$usuario_nome = $dados["usuario_nome"];
				$usuario_email = $dados["usuario_email"];
				
				echo "<tbody><td>$usuario_id</td><td>$usuario_nome</td><td>$usuario_email</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_usuarios_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_usuarios_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
				}
			echo "</table>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o ID de usuário '$textopesquisa'";
			}
		}
	if($nome == "S")
		{
		$consultaUsuariosNome = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_nome LIKE '%$textopesquisa%' ORDER BY usuario_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaUsuariosNome);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaUsuariosNome = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_nome LIKE '%$textopesquisa%' ORDER BY usuario_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaUsuariosNome) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>email</th></thead>";
			while($dados = mysqli_fetch_array($consultaUsuariosNome))
				{
				$usuario_id = $dados["usuario_id"];
				$usuario_nome = $dados["usuario_nome"];
				$usuario_email = $dados["usuario_email"];
				
				echo "<tbody><td>$usuario_id</td><td>$usuario_nome</td><td>$usuario_email</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_usuarios_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_usuarios_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
				}
			echo "</table>";
			
			$paginamenostres = $paginasolicitada - 3;
			$paginamenosdois = $paginasolicitada - 2;
			$paginamenosum = $paginasolicitada - 1;
			$paginamaisum = $paginasolicitada + 1;
			$paginamaisdois = $paginasolicitada + 2;
			$paginamaistres = $paginasolicitada + 3;
			
			$verificaExibicao = $numPaginas - $paginasolicitada;
			
			$P = '"S"';
			echo "<div class='btn-group' role='group' aria-label='...'>";
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornausuarios(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o Nome de usuário '$textopesquisa'";
			}

		}
	if($email == "S")
		{
		$consultaUsuariosEmail = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_email LIKE '%$textopesquisa%' ORDER BY usuario_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaUsuariosEmail);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaUsuariosEmail = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_email LIKE '%$textopesquisa%' ORDER BY usuario_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaUsuariosEmail) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>email</th></thead>";
			while($dados = mysqli_fetch_array($consultaUsuariosEmail))
				{
				$usuario_id = $dados["usuario_id"];
				$usuario_nome = $dados["usuario_nome"];
				$usuario_email = $dados["usuario_email"];
				
				echo "<tbody><td>$usuario_id</td><td>$usuario_nome</td><td>$usuario_email</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_usuarios_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_usuarios_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_usuario(".$usuario_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
				}
			echo "</table>";
			
			$paginamenostres = $paginasolicitada - 3;
			$paginamenosdois = $paginasolicitada - 2;
			$paginamenosum = $paginasolicitada - 1;
			$paginamaisum = $paginasolicitada + 1;
			$paginamaisdois = $paginasolicitada + 2;
			$paginamaistres = $paginasolicitada + 3;
			
			$verificaExibicao = $numPaginas - $paginasolicitada;
			
			$P = '"S"';
			echo "<div class='btn-group' role='group' aria-label='...'>";
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornausuarios(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornausuarios(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o Email de usuário '$textopesquisa'";
			}
		}
	}
	
	
?>