<?php 
include('../yconectaDB.inc');



$tempoatual = date('Y-m-d H:i:s'); 
$consultahistorico = mysqli_query($conectaBanco, "SELECT * FROM historico WHERE historico_data < '$tempoatual' ORDER BY historico_data DESC");

//=====================================================================Paginação
if(!empty($_POST["paginasolicitada"]))
		{
		$paginasolicitada = $_POST["paginasolicitada"];
		}
	else {$paginasolicitada = "1";}
	
	
$consultaconfiguracao = mysqli_query($conectaBanco, "SELECT * FROM configuracoes");
$dados = mysqli_fetch_array($consultaconfiguracao);
$itensporpagina = $dados["itens_eventos"];


$inicioConsulta = $paginasolicitada * $itensporpagina;
$inicioConsulta = $inicioConsulta - $itensporpagina;
$NumeroLinhas = mysqli_num_rows($consultahistorico);	
$numPaginas =  $NumeroLinhas / $itensporpagina;	
$consultahistorico = mysqli_query($conectaBanco ,"SELECT * FROM historico WHERE historico_data < '$tempoatual' ORDER BY historico_data DESC LIMIT $inicioConsulta, $itensporpagina");
//-------------------------------------------------------------------------------



echo "<div class='col-md-8' id='recebe_timeline'>";
		echo "<h3>Eventos</h3>";
while($dados = mysqli_fetch_array($consultahistorico))
	{
	$historico_id = $dados["historico_id"];
	$historico_usuario_id = $dados["historico_usuario_id"];
	$historico_tipo = $dados["historico_tipo"];
	$historico_data = $dados["historico_data"];
	$historico_projeto = $dados["historico_projeto"];
	$historico_usuario = $dados["historico_usuario"];
	$historico_solicitacao = $dados["historico_solicitacao"];
	$historico_rotina = $dados["historico_rotina"];
	$historico_texto = $dados["historico_texto"];
	
	$historico_data = date_create("$historico_data");
	$historico_data = (date_format($historico_data, "d/m/Y H:i"));
	
		$consultaNomeUsuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$historico_usuario_id'");		
		$dadoshistorico = mysqli_fetch_array($consultaNomeUsuario);
		$historico_usuario_foto = $dadoshistorico["usuario_foto"];
		$historico_usuario_nomecompleto = $dadoshistorico["usuario_nomecompleto"];
		$historico_usuario_nome = $dadoshistorico["usuario_nome"];
		$historico_usuario_cargo = $dadoshistorico["usuario_cargo"];
	
	
		echo "<div class='panel panel-default'>";
		  echo "<div class='panel-body'>";
		  
			echo "<div class='col-md-2'>";
			if($historico_usuario_foto != "")
				{
				echo "<img src='backend/usuarios/imgusuarios/$historico_usuario_foto' class='img-responsive img-rounded'>";
				}
			else
				{
				echo "<img src='backend/usuarios/imgusuarios/padrao.png' class='img-responsive img-rounded'>";
				}
			echo "</div>";
				
			echo "<div class='col-md-3'>";
				if($historico_usuario_nomecompleto != "")
					{echo "<b>$historico_usuario_nomecompleto</b><br>";}
				else {echo "<b>$historico_usuario_nome</b><br>";}
				echo "<i><h6>$historico_usuario_cargo</h6></i><br>";
				echo "<i><h6>Em $historico_data</h6></i>";
			echo "</div>";
			echo "<div class='col-md-7'>";
				echo "$historico_texto";
			echo "</div>";
		  echo "</div>";
		echo "</div>";
	}


	$paginamenostres = $paginasolicitada - 3;
	$paginamenosdois = $paginasolicitada - 2;
	$paginamenosum = $paginasolicitada - 1;
	$paginamaisum = $paginasolicitada + 1;
	$paginamaisdois = $paginasolicitada + 2;
	$paginamaistres = $paginasolicitada + 3;
	
	$verificaExibicao = $numPaginas - $paginasolicitada;
	
	echo "<div class='btn-group' role='group' aria-label='...'>";
		if($paginamenostres > 0) {echo "<button type='button' class='btn btn-default' onclick='visualiza_timeline(".$paginamenostres.")'>$paginamenostres</button>";}
		if($paginamenosdois > 0) {echo "<button type='button' class='btn btn-default' onclick='visualiza_timeline(".$paginamenosdois.")'>$paginamenosdois</button>";}
		if($paginamenosum > 0) {echo "<button type='button' class='btn btn-default' onclick='visualiza_timeline(".$paginamenosum.")'>$paginamenosum</button>";}
		echo "<button type='button' class='btn btn-primary' onclick='visualiza_timeline(".$paginasolicitada.")'>$paginasolicitada</button>";
		if ($verificaExibicao > 0){echo "<button type='button' class='btn btn-default' onclick='visualiza_timeline(".$paginamaisum.")'>$paginamaisum</button>";}
		if ($verificaExibicao > 1){echo "<button type='button' class='btn btn-default' onclick='visualiza_timeline(".$paginamaisdois.")'>$paginamaisdois</button>";}
		if ($verificaExibicao > 2){echo "<button type='button' class='btn btn-default' onclick='visualiza_timeline(".$paginamaistres.")'>$paginamaistres</button>";}
	echo "</div>";

echo "</div>";

echo "<div class='col-md-4' id='recebe_eventosparahoje'>";
	echo "<div class='panel panel-default'>";
		echo "<div class='panel-body'>";
			echo "<h4>Projetos iniciando hoje</h4>";
			$diaatual = $historico_data = date('Y-m-d');
			$inicio = $diaatual." 00:00:00";
			$final = $diaatual." 23:59:59";
			$consultaprojetos = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_inicio BETWEEN '$inicio' AND '$final' ORDER BY projeto_id DESC");
			echo "<table class='table'>";
				while($dados = mysqli_fetch_array($consultaprojetos))
				{
				$projeto_id = $dados["projeto_id"];
				$projeto_nome = $dados["projeto_nome"];
				
				$projeto_inicio = $dados["projeto_inicio"];
				$projeto_inicio = date_create("$projeto_inicio");
				$projeto_inicio = (date_format($projeto_inicio, "H:i"));
				
				echo "<tbody><td>$projeto_id</td><td>$projeto_nome</td><td>$projeto_inicio</td></tbody>";
				}
			echo "</table>";
		echo "</div>";
	echo "</div>";
	
	
	echo "<div class='panel panel-default'>";
		echo "<div class='panel-body'>";
			echo "<h4>Projetos finalizando hoje</h4>";
			$diaatual = $historico_data = date('Y-m-d');
			$inicio = $diaatual." 00:00:00";
			$final = $diaatual." 23:59:59";
			$consultaprojetos = mysqli_query($conectaBanco ,"SELECT * FROM projetos WHERE projeto_final BETWEEN '$inicio' AND '$final' ORDER BY projeto_id DESC");
			echo "<table class='table'>";
				while($dados = mysqli_fetch_array($consultaprojetos))
				{
				$projeto_id = $dados["projeto_id"];
				$projeto_nome = $dados["projeto_nome"];
				
				$projeto_final = $dados["projeto_final"];
				$projeto_final = date_create("$projeto_final");
				$projeto_final = (date_format($projeto_final, "H:i"));
				
				echo "<tbody><td>$projeto_id</td><td>$projeto_nome</td><td>$projeto_final</td></tbody>";
				}
			echo "</table>";
		echo "</div>";
	echo "</div>";
echo "</div>";









?>