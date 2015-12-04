<?php 
include('../yconectaDB.inc');

//======================================================================================================================CARREGA PERMISSÕES DO USUÁRIO
$usuario_id_atual = $_POST["usuario_id_atual"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id_atual'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_edit_solicitacao_atual = $dados["usuario_edit_solicitacao"];
$usuario_excl_solicitacao_atual = $dados["usuario_excl_solicitacao"];
//----------------------------------------------------------------------------------------------------------------------------------------------------

$pesquisa = $_POST["pesquisa"];
$textopesquisa = $_POST["textopesquisa"];
$id = $_POST["id"];
$nome = $_POST["nome"];
$usuario = $_POST["usuario"];
$data = $_POST["data"];
$status = $_POST["status"];

if(!empty($_POST["paginasolicitada"]))
		{
		$paginasolicitada = $_POST["paginasolicitada"];
		}
	else {$paginasolicitada = "1";}

$consultaconfiguracao = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes");
$dados = mysqli_fetch_array($consultaconfiguracao);
$itensporpagina = $dados["itens_solicitacoesadm"];
	
$inicioConsulta = $paginasolicitada * $itensporpagina;
$inicioConsulta = $inicioConsulta - $itensporpagina;

if($pesquisa == "N")
	{
	$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes ORDER BY solicitacao_id DESC");
	$NumeroLinhas = mysqli_num_rows($consultaSolicitacoes);	
	$numPaginas =  $NumeroLinhas / $itensporpagina;	
	
	$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes ORDER BY solicitacao_id DESC LIMIT $inicioConsulta, $itensporpagina");
	
	echo "<table class='table'>";
	echo "<thead><th>id</th><th>nome</th><th>usuário</th><th>data</th><th>status</th></thead>";
	while ($dados = mysqli_fetch_array($consultaSolicitacoes))
		{
		$solicitacao_id = $dados["solicitacao_id"];
		$solicitacao_nome = $dados["solicitacao_nome"];
		$solicitacao_usuario = $dados["solicitacao_usuario"];
		$solicitacao_data = $dados["solicitacao_data"];
		$solicitacao_status = $dados["solicitacao_status"];
		
		$consultaUsuariodaSolicitacao = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$solicitacao_usuario'");
		$dadosUsuario = mysqli_fetch_array($consultaUsuariodaSolicitacao);
		$solicitacao_usuario = $dadosUsuario["usuario_nome"];
		
		$solicitacao_data = date_create("$solicitacao_data");
		$solicitacao_data = (date_format($solicitacao_data, "d/m/Y H:i"));
		
		echo "<tbody><td>$solicitacao_id</td><td>$solicitacao_nome</td><td>$solicitacao_usuario</td><td>$solicitacao_data</td><td>$solicitacao_status</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
		if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
		if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
		if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
		echo "<button type='button' class='btn btn-primary' onclick='retornasolicitacoes(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
		if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
		if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
		if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
	echo "</div>";
		
	}
	
else if($pesquisa == "S")
	{
	if($id == "S")
		{
		$consultaSolicitacoesID = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_id = '$textopesquisa' ORDER BY solicitacao_id DESC");
		
		if(mysqli_num_rows($consultaSolicitacoesID) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>usuário</th><th>data</th><th>status</th></thead>";
			while($dados = mysqli_fetch_array($consultaSolicitacoesID))
				{
				$solicitacao_id = $dados["solicitacao_id"];
				$solicitacao_nome = $dados["solicitacao_nome"];
				$solicitacao_usuario = $dados["solicitacao_usuario"];
				$solicitacao_data = $dados["solicitacao_data"];
				$solicitacao_status = $dados["solicitacao_status"];
				
				$consultaUsuariodaSolicitacao = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$solicitacao_usuario'");
				$dadosUsuario = mysqli_fetch_array($consultaUsuariodaSolicitacao);
				$solicitacao_usuario = $dadosUsuario["usuario_nome"];
				
				$solicitacao_data = date_create("$solicitacao_data");
				$solicitacao_data = (date_format($solicitacao_data, "d/m/Y H:i"));
				
				echo "<tbody><td>$solicitacao_id</td><td>$solicitacao_nome</td><td>$solicitacao_usuario</td><td>$solicitacao_data</td><td>$solicitacao_status</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
				}
			echo "</table>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o ID de solicitação '$textopesquisa'";
			}
		}
	if($nome == "S")
		{
		$consultaSolicitacoesNome = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_nome LIKE '%$textopesquisa%' ORDER BY solicitacao_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaSolicitacoesNome);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaSolicitacoesNome = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_nome LIKE '%$textopesquisa%' ORDER BY solicitacao_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaSolicitacoesNome) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>usuário</th><th>data</th><th>status</th></thead>";
			while($dados = mysqli_fetch_array($consultaSolicitacoesNome))
				{
				$solicitacao_id = $dados["solicitacao_id"];
				$solicitacao_nome = $dados["solicitacao_nome"];
				$solicitacao_usuario = $dados["solicitacao_usuario"];
				$solicitacao_data = $dados["solicitacao_data"];
				$solicitacao_status = $dados["solicitacao_status"];
				
				$consultaUsuariodaSolicitacao = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$solicitacao_usuario'");
				$dadosUsuario = mysqli_fetch_array($consultaUsuariodaSolicitacao);
				$solicitacao_usuario = $dadosUsuario["usuario_nome"];
				
				$solicitacao_data = date_create("$solicitacao_data");
				$solicitacao_data = (date_format($solicitacao_data, "d/m/Y H:i"));
				
				echo "<tbody><td>$solicitacao_id</td><td>$solicitacao_nome</td><td>$solicitacao_usuario</td><td>$solicitacao_data</td><td>$solicitacao_status</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornasolicitacoes(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o Nome de solicitação '$textopesquisa'";
			}
		}
	
	if($usuario == "S")
		{
		
		$condicaousuarios = "(";
		$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_nome LIKE '%$textopesquisa%' ORDER BY usuario_id DESC");
		while ($dadosusuarios = mysqli_fetch_array($consultaUsuarios))
			{	
			$usuario_id = $dadosusuarios["usuario_id"];
			
			$condicaousuarios = $condicaousuarios."'".$usuario_id."',";
			}
		$condicaousuarios = $condicaousuarios."'')";
		
		$consultaSolicitacoesUsuario = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_usuario IN $condicaousuarios ORDER BY solicitacao_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaSolicitacoesUsuario);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaSolicitacoesUsuario = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_usuario IN $condicaousuarios ORDER BY solicitacao_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaSolicitacoesUsuario) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>usuário</th><th>data</th><th>status</th></thead>";
			while($dados = mysqli_fetch_array($consultaSolicitacoesUsuario))
				{
				$solicitacao_id = $dados["solicitacao_id"];
				$solicitacao_nome = $dados["solicitacao_nome"];
				$solicitacao_usuario = $dados["solicitacao_usuario"];
				$solicitacao_data = $dados["solicitacao_data"];
				$solicitacao_status = $dados["solicitacao_status"];
				
				$consultaUsuariodaSolicitacao = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$solicitacao_usuario'");
				$dadosUsuario = mysqli_fetch_array($consultaUsuariodaSolicitacao);
				$solicitacao_usuario = $dadosUsuario["usuario_nome"];
				
				$solicitacao_data = date_create("$solicitacao_data");
				$solicitacao_data = (date_format($solicitacao_data, "d/m/Y H:i"));
				
				echo "<tbody><td>$solicitacao_id</td><td>$solicitacao_nome</td><td>$solicitacao_usuario</td><td>$solicitacao_data</td><td>$solicitacao_status</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornasolicitacoes(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o Nome de Usuário '$textopesquisa'";
			}
		}
	
	if($data == "S")
		{
		$inicio = substr($textopesquisa, 0, 16);
		$final = substr($textopesquisa, 16, 16);
		
		$consultaSolicitacoesData = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_data BETWEEN '$inicio' AND '$final' ORDER BY solicitacao_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaSolicitacoesData);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaSolicitacoesData = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_data BETWEEN '$inicio' AND '$final' ORDER BY solicitacao_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaSolicitacoesData) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>usuário</th><th>data</th><th>status</th></thead>";
			while($dados = mysqli_fetch_array($consultaSolicitacoesData))
				{
				$solicitacao_id = $dados["solicitacao_id"];
				$solicitacao_nome = $dados["solicitacao_nome"];
				$solicitacao_usuario = $dados["solicitacao_usuario"];
				$solicitacao_data = $dados["solicitacao_data"];
				$solicitacao_status = $dados["solicitacao_status"];
				
				$consultaUsuariodaSolicitacao = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$solicitacao_usuario'");
				$dadosUsuario = mysqli_fetch_array($consultaUsuariodaSolicitacao);
				$solicitacao_usuario = $dadosUsuario["usuario_nome"];
				
				$solicitacao_data = date_create("$solicitacao_data");
				$solicitacao_data = (date_format($solicitacao_data, "d/m/Y H:i"));
				
				echo "<tbody><td>$solicitacao_id</td><td>$solicitacao_nome</td><td>$solicitacao_usuario</td><td>$solicitacao_data</td><td>$solicitacao_status</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornasolicitacoes(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			$inicio = date_create("$inicio");
			$final = date_create("$final");
			$inicio = (date_format($inicio, "d/m/Y H:i"));
			$final = (date_format($final, "d/m/Y H:i"));
			
			echo "Não existem resultados para a pesquisa para a Data entre '$inicio' e '$final'! ";
			}
		
		}
	
	if($status == "S")
		{
		$consultaSolicitacoesStatus = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_status LIKE '%$textopesquisa%' ORDER BY solicitacao_id DESC");
		$NumeroLinhas = mysqli_num_rows($consultaSolicitacoesStatus);	
		$numPaginas =  $NumeroLinhas / $itensporpagina;	
		
		$consultaSolicitacoesStatus = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_status LIKE '%$textopesquisa%' ORDER BY solicitacao_id DESC LIMIT $inicioConsulta, $itensporpagina");
		
		if(mysqli_num_rows($consultaSolicitacoesStatus) > 0)
			{
			echo "<table class='table'>";
			echo "<thead><th>id</th><th>nome</th><th>usuário</th><th>data</th><th>status</th></thead>";
			while($dados = mysqli_fetch_array($consultaSolicitacoesStatus))
				{
				$solicitacao_id = $dados["solicitacao_id"];
				$solicitacao_nome = $dados["solicitacao_nome"];
				$solicitacao_usuario = $dados["solicitacao_usuario"];
				$solicitacao_data = $dados["solicitacao_data"];
				$solicitacao_status = $dados["solicitacao_status"];
				
				$consultaUsuariodaSolicitacao = mysqli_query("SELECT * FROM login WHERE usuario_id = '$solicitacao_usuario'");
				$dadosUsuario = mysqli_fetch_array($consultaUsuariodaSolicitacao);
				$solicitacao_usuario = $dadosUsuario["usuario_nome"];
				
				$solicitacao_data = date_create("$solicitacao_data");
				$solicitacao_data = (date_format($solicitacao_data, "d/m/Y H:i"));
				
				echo "<tbody><td>$solicitacao_id</td><td>$solicitacao_nome</td><td>$solicitacao_usuario</td><td>$solicitacao_data</td><td>$solicitacao_status</td><td><button type='button' class='btn btn-default' aria-label='' onclick='visualiza_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>"; if($usuario_edit_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='edita_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>";} if($usuario_excl_solicitacao_atual == "S"){echo "<button type='button' class='btn btn-default' aria-label='' onclick='remove_solicitacao(".$solicitacao_id.")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";} echo "</td></tbody>";
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
				if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenostres.")'>$paginamenostres</button>";}
				if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenosdois.")'>$paginamenosdois</button>";}
				if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamenosum.")'>$paginamenosum</button>";}
				echo "<button type='button' class='btn btn-primary' onclick='retornasolicitacoes(".$P.", ".$paginasolicitada.")'>$paginasolicitada</button>";
				if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaisum.")'>$paginamaisum</button>";}
				if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaisdois.")'>$paginamaisdois</button>";}
				if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='retornasolicitacoes(".$P.", ".$paginamaistres.")'>$paginamaistres</button>";}
			echo "</div>";
			}
		else
			{
			echo "Não existem resultados para a pesquisa para o Status de solicitação '$textopesquisa'";
			}
		}
	
	
	
	
	}
?>