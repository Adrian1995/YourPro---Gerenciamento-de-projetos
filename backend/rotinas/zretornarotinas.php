<?php 
include('../yconectaDB.inc');

//======================================================================================================================CARREGA PERMISSÕES DO USUÁRIO
$usuario_id_atual = $_POST["usuario_id_atual"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id_atual'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_edit_rotina_atual = $dados["usuario_edit_rotina"];
$usuario_excl_rotina_atual = $dados["usuario_excl_rotina"];
//----------------------------------------------------------------------------------------------------------------------------------------------------

$pesquisa = $_POST["pesquisa"];
$textopesquisa = $_POST["textopesquisa"];
$id = $_POST["id"];
$nome = $_POST["nome"];


if(!empty($_POST["paginasolicitada"]))
		{
		$paginasolicitada = $_POST["paginasolicitada"];
		}
	else {$paginasolicitada = "1";}

$consultaconfiguracao = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes");
$dados = mysqli_fetch_array($consultaconfiguracao);
$itensporpagina = $dados["itens_rotinas"];
	
$inicioConsulta = $paginasolicitada * $itensporpagina;
$inicioConsulta = $inicioConsulta - $itensporpagina;

if($pesquisa == "N")
	{
	$consultaRotinas = mysqli_query($conectaBanco ,"SELECT * FROM rotinas ORDER BY rotina_id DESC");
	$NumeroLinhas = mysqli_num_rows($consultaRotinas);	
	$numPaginas =  $NumeroLinhas / $itensporpagina;	
	
	$consultaRotinas = mysqli_query($conectaBanco ,"SELECT * FROM rotinas ORDER BY rotina_id DESC LIMIT $inicioConsulta, $itensporpagina");
	
	echo "<table class='table'>";
	echo "<thead><th>id</th><th>nome</th></thead>";
	while ($dados = mysqli_fetch_array($consultaRotinas))
		{
		$rotina_id = $dados["rotina_id"];
		$rotina_nome = $dados["rotina_nome"];
		
		echo "<tbody><td>$rotina_id</td><td>$rotina_nome</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_rotina(".$rotina_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_rotina_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_rotina(".$rotina_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_rotina_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_rotina(".$rotina_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
		if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
		if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
		if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
		echo "<button type='button' class='btn btn-primary' onclick='retornarotinas(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
		if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
		if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
		if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
	echo "</div>";
		
	}
else if($pesquisa == "S")
	{
	if($id == "S")
		{
		$consultaRotinasID = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id = '$textopesquisa' ORDER BY rotina_id DESC");
		
		if(mysqli_num_rows($consultaRotinasID) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th></thead>";
			while($dados = mysqli_fetch_array($consultaRotinasID))
				{
				$rotina_id = $dados["rotina_id"];
				$rotina_nome = $dados["rotina_nome"];
				
				echo "<tbody><td>$rotina_id</td><td>$rotina_nome</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_rotina(".$rotina_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_rotina_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_rotina(".$rotina_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_rotina_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_rotina(".$rotina_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
				}
			echo "</table>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o ID de rotina '$textopesquisa'";
			}
		}
	if($nome == "S")
		{
		$consultaRotinasNome = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_nome LIKE '%$textopesquisa%' ORDER BY rotina_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaRotinasNome);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaRotinasNome = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_nome LIKE '%$textopesquisa%' ORDER BY rotina_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaRotinasNome) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th></thead>";
			while($dados = mysqli_fetch_array($consultaRotinasNome))
				{
				$rotina_id = $dados["rotina_id"];
				$rotina_nome = $dados["rotina_nome"];
				
				echo "<tbody><td>$rotina_id</td><td>$rotina_nome</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_rotina(".$rotina_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_rotina_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_rotina(".$rotina_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_rotina_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_rotina(".$rotina_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornarotinas(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornarotinas(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o Nome de rotina '$textopesquisa'";
			}

		}
	}
	
	
?>