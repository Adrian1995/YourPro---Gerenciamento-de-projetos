<?php 
include('../yconectaDB.inc');

//======================================================================================================================CARREGA PERMISSÕES DO USUÁRIO
$usuario_id_atual = $_POST["usuario_id_atual"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id_atual'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_edit_projetos_atual = $dados["usuario_edit_projetos"];
$usuario_excl_projetos_atual = $dados["usuario_excl_projetos"];
//----------------------------------------------------------------------------------------------------------------------------------------------------


$pesquisa = $_POST["pesquisa"];
$textopesquisa = $_POST["textopesquisa"];
$id = $_POST["id"];
$nome = $_POST["nome"];
$tipo = $_POST["tipo"];
$status = $_POST["status"];
$iniciodata = $_POST["iniciodata"];
$finaldata = $_POST["finaldata"];

if(!empty($_POST["paginasolicitada"]))
		{
		$paginasolicitada = $_POST["paginasolicitada"];
		}
	else {$paginasolicitada = "1";}

$consultaconfiguracao = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes");
$dados = mysqli_fetch_array($consultaconfiguracao);
$itensporpagina = $dados["itens_projetos"];
	
$inicioConsulta = $paginasolicitada * $itensporpagina;
$inicioConsulta = $inicioConsulta - $itensporpagina;

if($pesquisa == "N")
	{
	$consultaProjetos = mysqli_query($conectaBanco ,"SELECT * FROM projetos ORDER BY projeto_id DESC");
	$NumeroLinhas = mysqli_num_rows($consultaProjetos);	
	$numPaginas =  $NumeroLinhas / $itensporpagina;	
	
	$consultaProjetos = mysqli_query($conectaBanco ,"SELECT * FROM projetos ORDER BY projeto_id DESC LIMIT $inicioConsulta, $itensporpagina");
	
	echo "<table class='table'>";
	echo "<thead><th>id</th><th>nome</th><th>tipo</th><th>status</th><th>início</th><th>final</th></thead>";
	while ($dados = mysqli_fetch_array($consultaProjetos))
		{
		$projeto_id = $dados["projeto_id"];
		$projeto_nome = $dados["projeto_nome"];
		$projeto_tipo = $dados["projeto_tipo"];
		$projeto_status = $dados["projeto_status"];
		$projeto_inicio = $dados["projeto_inicio"];
		$projeto_final = $dados["projeto_final"];
		
		$projeto_inicio = date_create("$projeto_inicio");
		$projeto_final = date_create("$projeto_final");
		$projeto_inicio = (date_format($projeto_inicio, "d/m/Y H:i"));
		$projeto_final = (date_format($projeto_final, "d/m/Y H:i"));
		
		echo "<tbody><td>$projeto_id</td><td>$projeto_nome</td><td>$projeto_tipo</td><td>$projeto_status</td><td>$projeto_inicio</td><td>$projeto_final</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
		if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
		if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
		if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
		echo "<button type='button' class='btn btn-primary' onclick='retornaprojetos(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
		if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
		if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
		if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
	echo "</div>";
		
	}
else if($pesquisa == "S")
	{
	if($id == "S")
		{
		$consultaProjetosID = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_id = '$textopesquisa' ORDER BY projeto_id DESC");
		
		if(mysqli_num_rows($consultaProjetosID) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>tipo</th><th>status</th><th>início</th><th>final</th></thead>";
			while($dados = mysqli_fetch_array($consultaProjetosID))
				{
				$projeto_id = $dados["projeto_id"];
				$projeto_nome = $dados["projeto_nome"];
				$projeto_tipo = $dados["projeto_tipo"];
				$projeto_status = $dados["projeto_status"];
				$projeto_inicio = $dados["projeto_inicio"];
				$projeto_final = $dados["projeto_final"];
				
				$projeto_inicio = date_create("$projeto_inicio");
				$projeto_final = date_create("$projeto_final");
				$projeto_inicio = (date_format($projeto_inicio, "d/m/Y H:i"));
				$projeto_final = (date_format($projeto_final, "d/m/Y H:i"));
				
				echo "<tbody><td>$projeto_id</td><td>$projeto_nome</td><td>$projeto_tipo</td><td>$projeto_status</td><td>$projeto_inicio</td><td>$projeto_final</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
				}
			echo "</table>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o ID de projeto '$textopesquisa'";
			}
		}
	if($nome == "S")
		{
		$consultaProjetosNome = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_nome LIKE '%$textopesquisa%' ORDER BY projeto_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaProjetosNome);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaProjetosNome = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_nome LIKE '%$textopesquisa%' ORDER BY projeto_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaProjetosNome) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>tipo</th><th>status</th><th>início</th><th>final</th></thead>";
			while($dados = mysqli_fetch_array($consultaProjetosNome))
				{
				$projeto_id = $dados["projeto_id"];
				$projeto_nome = $dados["projeto_nome"];
				$projeto_tipo = $dados["projeto_tipo"];
				$projeto_status = $dados["projeto_status"];
				$projeto_inicio = $dados["projeto_inicio"];
				$projeto_final = $dados["projeto_final"];
				
				$projeto_inicio = date_create("$projeto_inicio");
				$projeto_final = date_create("$projeto_final");
				$projeto_inicio = (date_format($projeto_inicio, "d/m/Y H:i"));
				$projeto_final = (date_format($projeto_final, "d/m/Y H:i"));
				
				echo "<tbody><td>$projeto_id</td><td>$projeto_nome</td><td>$projeto_tipo</td><td>$projeto_status</td><td>$projeto_inicio</td><td>$projeto_final</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornaprojetos(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o Nome de projeto '$textopesquisa'";
			}

		}
	if($tipo == "S")
		{
		$consultaProjetosTipo = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_tipo LIKE '%$textopesquisa%' ORDER BY projeto_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaProjetosTipo);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaProjetosTipo = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_tipo LIKE '%$textopesquisa%' ORDER BY projeto_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaProjetosTipo) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>tipo</th><th>status</th><th>início</th><th>final</th></thead>";
			while($dados = mysqli_fetch_array($consultaProjetosTipo))
				{
				$projeto_id = $dados["projeto_id"];
				$projeto_nome = $dados["projeto_nome"];
				$projeto_tipo = $dados["projeto_tipo"];
				$projeto_status = $dados["projeto_status"];
				$projeto_inicio = $dados["projeto_inicio"];
				$projeto_final = $dados["projeto_final"];
				
				$projeto_inicio = date_create("$projeto_inicio");
				$projeto_final = date_create("$projeto_final");
				$projeto_inicio = (date_format($projeto_inicio, "d/m/Y H:i"));
				$projeto_final = (date_format($projeto_final, "d/m/Y H:i"));
				
				echo "<tbody><td>$projeto_id</td><td>$projeto_nome</td><td>$projeto_tipo</td><td>$projeto_status</td><td>$projeto_inicio</td><td>$projeto_final</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornaprojetos(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o Tipo de projeto '$textopesquisa'";
			}
		}
	
	if($status == "S")
		{
		$consultaProjetosStatus = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_status LIKE '%$textopesquisa%' ORDER BY projeto_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaProjetosStatus);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaProjetosStatus = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_status LIKE '%$textopesquisa%' ORDER BY projeto_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaProjetosStatus) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>tipo</th><th>status</th><th>início</th><th>final</th></thead>";
			while($dados = mysqli_fetch_array($consultaProjetosStatus))
				{
				$projeto_id = $dados["projeto_id"];
				$projeto_nome = $dados["projeto_nome"];
				$projeto_tipo = $dados["projeto_tipo"];
				$projeto_status = $dados["projeto_status"];
				$projeto_inicio = $dados["projeto_inicio"];
				$projeto_final = $dados["projeto_final"];
				
				$projeto_inicio = date_create("$projeto_inicio");
				$projeto_final = date_create("$projeto_final");
				$projeto_inicio = (date_format($projeto_inicio, "d/m/Y H:i"));
				$projeto_final = (date_format($projeto_final, "d/m/Y H:i"));
				
				echo "<tbody><td>$projeto_id</td><td>$projeto_nome</td><td>$projeto_tipo</td><td>$projeto_status</td><td>$projeto_inicio</td><td>$projeto_final</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornaprojetos(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o Tipo de projeto '$textopesquisa'";
			}
		}
	
	
	if($iniciodata == "S")
		{
		$inicio = substr($textopesquisa, 0, 16);
		$final = substr($textopesquisa, 16, 16);
		
		$consultaProjetosInicio = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_inicio BETWEEN '$inicio' AND '$final' ORDER BY projeto_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaProjetosInicio);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaProjetosInicio = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_inicio BETWEEN '$inicio' AND '$final' ORDER BY projeto_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaProjetosInicio) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>tipo</th><th>status</th><th>início</th><th>final</th></thead>";
			while($dados = mysqli_fetch_array($consultaProjetosInicio))
				{
				$projeto_id = $dados["projeto_id"];
				$projeto_nome = $dados["projeto_nome"];
				$projeto_tipo = $dados["projeto_tipo"];
				$projeto_status = $dados["projeto_status"];
				$projeto_inicio = $dados["projeto_inicio"];
				$projeto_final = $dados["projeto_final"];
				
				$projeto_inicio = date_create("$projeto_inicio");
				$projeto_final = date_create("$projeto_final");
				$projeto_inicio = (date_format($projeto_inicio, "d/m/Y H:i"));
				$projeto_final = (date_format($projeto_final, "d/m/Y H:i"));
				
				echo "<tbody><td>$projeto_id</td><td>$projeto_nome</td><td>$projeto_tipo</td><td>$projeto_status</td><td>$projeto_inicio</td><td>$projeto_final</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornaprojetos(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			$inicio = date_create("$inicio");
			$final = date_create("$final");
			$inicio = (date_format($inicio, "d/m/Y H:i"));
			$final = (date_format($final, "d/m/Y H:i"));
			
			echo "Não existem resultados para a pesquisa para o Início entre '$inicio' e '$final'! ";
			}
		
		}
		
	if($finaldata == "S")
		{
		$inicio = substr($textopesquisa, 0, 16);
		$final = substr($textopesquisa, 16, 16);
		
		$consultaProjetosFinal = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_final BETWEEN '$inicio' AND '$final' ORDER BY projeto_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaProjetosFinal);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaProjetosFinal = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_final BETWEEN '$inicio' AND '$final' ORDER BY projeto_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaProjetosFinal) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>tipo</th><th>status</th><th>início</th><th>final</th></thead>";
			while($dados = mysqli_fetch_array($consultaProjetosFinal))
				{
				$projeto_id = $dados["projeto_id"];
				$projeto_nome = $dados["projeto_nome"];
				$projeto_tipo = $dados["projeto_tipo"];
				$projeto_status = $dados["projeto_status"];
				$projeto_inicio = $dados["projeto_inicio"];
				$projeto_final = $dados["projeto_final"];
				
				$projeto_inicio = date_create("$projeto_inicio");
				$projeto_final = date_create("$projeto_final");
				$projeto_inicio = (date_format($projeto_inicio, "d/m/Y H:i"));
				$projeto_final = (date_format($projeto_final, "d/m/Y H:i"));
				
				echo "<tbody><td>$projeto_id</td><td>$projeto_nome</td><td>$projeto_tipo</td><td>$projeto_status</td><td>$projeto_inicio</td><td>$projeto_final</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_projetos_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_projeto(".$projeto_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornaprojetos(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornaprojetos(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			$inicio = date_create("$inicio");
			$final = date_create("$final");
			$inicio = (date_format($inicio, "d/m/Y H:i"));
			$final = (date_format($final, "d/m/Y H:i"));
							
			echo "Não existem resultados para a pesquisa para o Final entre '$inicio' e '$final'! ";
			}
		
		}
	
	}
?>