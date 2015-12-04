<?php 
include('../yconectaDB.inc');

//======================================================================================================================CARREGA PERMISSÕES DO USUÁRIO
$usuario_id_atual = $_POST["usuario_id_atual"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id_atual'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_edit_solicitacao_atual = $dados["usuario_edit_solicitacao"];
//----------------------------------------------------------------------------------------------------------------------------------------------------

$solicitacao_id = $_POST["solicitacao_id"];

$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_id = '$solicitacao_id'");
$dados = mysqli_fetch_array($consultaSolicitacoes);
$solicitacao_nome = $dados["solicitacao_nome"];
$solicitacao_usuario = $dados["solicitacao_usuario"];
$solicitacao_data = $dados["solicitacao_data"];
$solicitacao_status = $dados["solicitacao_status"];
$solicitacao_observacao = $dados["solicitacao_observacao"];

$solicitacao_data = str_replace(" ", "T", $solicitacao_data);

echo "<div class='col-md-10 col-md-offset-1' id='temporario_visusolicitacoes'>"; 
echo "<h3>Visualização de solicitação</h3>";
echo "<br>";
echo "<div class='row'>";
											
echo "<div class='col-md-6'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span>";
echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' id='solicitacao_nome' value='".$solicitacao_nome."' disabled>";
echo "</div>";
echo "<br>";
echo "<textarea class='form-control' rows='10' id='solicitacao_observacao' placeholder='Insira observações da solicitação...' disabled>".$solicitacao_observacao."</textarea>";
echo "<br>";
echo "</div>";

echo "<div class='col-md-6'>";
echo "<div class='input-group'><div class='input-group-addon'>Solicitante</span> </div>";
	echo "<select id='solicitacao_usuario' class='form-control' disabled>";
		if($solicitacao_usuario == ""){echo "<option value=''>Selecione...";}
		else
		{
		$consultaNomeUsuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$solicitacao_usuario'");
		$nomedousuario = mysqli_fetch_array($consultaNomeUsuario);
		$nome = $nomedousuario["usuario_nome"];
		
		echo "<option value='$solicitacao_usuario'>$nome";
		}
		
	$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_tipo='Solicitante' ");
		while ($dados = mysqli_fetch_array($consultaUsuarios))
		{	$usuario_id = $dados["usuario_id"];
			$usuario_nome = $dados["usuario_nome"];
			
			if($usuario_id != $solicitacao_usuario)echo "<option value='$usuario_id'>$usuario_nome";
		}
	echo "</select>";
echo "</div>";
	
	echo "<br>";
	echo "<div class='input-group'><div class='input-group-addon'>Data solicitação</span> </div>";
		echo "<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='solicitacao_data' value='$solicitacao_data' disabled>";
	echo "</div>";
	echo "<br>";
	echo "<div class='input-group'><div class='input-group-addon'>Status</span> </div>";
		echo "<select id='solicitacao_status' class='form-control' disabled>";
		
		if($solicitacao_status == ""){echo "<option value=''>Selecione...";}
		else
		{
		echo "<option value='$solicitacao_status'>$solicitacao_status";
		}
		
		if($solicitacao_status != "Aguardando") {echo "<option value='Aguardando'>Aguardando";}
		if($solicitacao_status != "Em andamento") {echo "<option value='Em andamento'>Em andamento";}
		if($solicitacao_status != "Finalizado") {echo "<option value='Finalizado'>Finalizado";}
		echo "</select>";
	echo "</div>";

	
	

echo "</div>";








	echo "</div>";
	echo "<div class='row' id='container_perguntas'>";
	
	$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT MAX(solicitacao_numero) FROM solicitacoesrespostas WHERE solicitacao_id = '$solicitacao_id' ");		
	$dados = mysqli_fetch_array($consultaSolicitacoes);
	$ultimoID = $dados["0"];
	echo "<input type='hidden' id='ultimoregistro' value='$ultimoID'>";
			
	for ($i = 1; $i <= $ultimoID; $i++) 
		{
		$consultasolicitacao = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoesrespostas WHERE solicitacao_id = '$solicitacao_id' and solicitacao_numero = '$i' ");		
		$numeroregistros = mysqli_num_rows($consultasolicitacao);
			
		if($numeroregistros > 0)
			{	
			$dados = mysqli_fetch_array($consultasolicitacao);
			$solicitacao_numero = $dados["solicitacao_numero"];
			$solicitacao_pergunta = $dados["solicitacao_pergunta"];
			$solicitacao_resposta = $dados["solicitacao_resposta"];
					
			echo "<div class='row' id='perguntaresposta".$solicitacao_numero."'>";
				echo "<div class='col-md-1'>";
					echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' value='".$solicitacao_numero."' id='solicitacao_numero".$solicitacao_numero."' disabled>";
				echo "</div>";
				echo "<div class='col-md-10'>";
					echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Pergunta</span>";
					echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' id='pergunta".$solicitacao_numero."' value='".$solicitacao_pergunta."' disabled>";
					echo "</div>";
					echo "<textarea class='form-control' rows='7' id='resposta".$solicitacao_numero."' disabled>".$solicitacao_resposta."</textarea>";
					echo "<br>";
				echo "</div>";
			echo "</div>";
			}
		}
										
	echo "</div>";
echo "<div class='row'>";
if($usuario_edit_solicitacao_atual == "S")
	{
	echo "<button type='button' class='btn btn-primary' id='btn_SalvarProjeto' onclick='edita_solicitacao(".$solicitacao_id.")'>";
	echo "<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Editar";
	echo "</button>";
	}
echo "</div>";
echo "</div>";
?>