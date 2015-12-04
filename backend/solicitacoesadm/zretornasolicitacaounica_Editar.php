<?php 
include('../yconectaDB.inc');

$solicitacao_id = $_POST["solicitacao_id"];

$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_id = '$solicitacao_id'");
$dados = mysqli_fetch_array($consultaSolicitacoes);
$solicitacao_nome = $dados["solicitacao_nome"];
$solicitacao_usuario = $dados["solicitacao_usuario"];
$solicitacao_data = $dados["solicitacao_data"];
$solicitacao_status = $dados["solicitacao_status"];
$solicitacao_observacao = $dados["solicitacao_observacao"];

$solicitacao_data = str_replace(" ", "T", $solicitacao_data);

echo "<div class='col-md-10 col-md-offset-1' id='temporario_editsolicitacoes'>"; 
echo "<h3>Alteração de solicitação</h3>";
echo "<br>";
echo "<div class='row'>";
											
echo "<div class='col-md-6'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span>";
echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' id='solicitacao_nome' value='".$solicitacao_nome."'>";
echo "</div>";
echo "<br>";
echo "<textarea class='form-control' rows='10' id='solicitacao_observacao' placeholder='Insira observações da solicitação...'>".$solicitacao_observacao."</textarea>";
echo "<br>";
echo "</div>";
echo "<div class='row'>";
echo "<div class='col-md-6'>";

echo "<div class='input-group'><div class='input-group-addon'>Solicitante</span> </div>";
	echo "<select id='solicitacao_usuario' class='form-control'>";
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
		echo "<input type='datetime-local' class='form-control' aria-describedby='sizing-addon2' id='solicitacao_data' value='$solicitacao_data'>";
	echo "</div>";
	echo "<br>";
	echo "<div class='input-group'><div class='input-group-addon'>Status</span> </div>";
		echo "<select id='solicitacao_status' class='form-control'>";
		echo "<option value='$solicitacao_status'>$solicitacao_status";
		
		$consultaStatus = mysqli_query($conectaBanco ,"SELECT * FROM configuracoes_status_solicitacoes");
		while($dados = mysqli_fetch_array($consultaStatus))
			{
			$status_nome = $dados["status_nome"];
			
			if($solicitacao_status != $status_nome)
				{
				echo "<option value='$status_nome'>$status_nome";
				}
			}
		
		echo "</select>";
	echo "</div>";

	echo "<br>";
	echo "<div class='panel panel-default'>";
		echo "<div class='panel-body'>";
			echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' id='texto_pergunta'>";
			echo "<br>";
			echo "<button type='button' class='btn btn-default' id='btn_AdicionaPergunta' onclick='adicionar_pergunta()'>";
			echo "<span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span> Adicionar pergunta/tópico";
			echo "</button>";
		echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "<div class='row' id='container_perguntas'>";
	
	$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT MAX(solicitacao_numero) FROM solicitacoesrespostas WHERE solicitacao_id = '$solicitacao_id' ");		
	$dados = mysqli_fetch_array($consultaSolicitacoes);
	$ultimoID = $dados["0"];
	
	if($ultimoID == "")
		{
		$ultimoID = 0;
		}
		
	echo "<input type='hidden' id='ultimapergunta' value='".$ultimoID."'>";
	
		
	for ($i = 1; $i <= $ultimoID; $i++) 
		{
		$consultasolicitacao = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoesrespostas WHERE solicitacao_id = '$solicitacao_id' and solicitacao_numero = '$i' ");		
		$numeroregistros = mysqli_num_rows($consultasolicitacao);
			
		if($numeroregistros > 0)
			{	
			$dados = mysqli_fetch_array($consultasolicitacao);
			$solicitacaoresposta_id = $dados["solicitacaoresposta_id"];
			$solicitacao_numero = $dados["solicitacao_numero"];
			$solicitacao_pergunta = $dados["solicitacao_pergunta"];
			$solicitacao_resposta = $dados["solicitacao_resposta"];
					
			echo "<div class='row' id='perguntaresposta".$solicitacao_numero."'>";
				echo "<div class='col-md-1'>";
					echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' value='".$solicitacao_numero."' id='solicitacao_numero".$solicitacao_numero."' disabled>";
					echo "<input type='hidden' id='solicitacaoresposta_id".$solicitacao_numero."' value='".$solicitacaoresposta_id."'>";
				echo "</div>";
				echo "<div class='col-md-10'>";
					echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Pergunta</span>";
					echo "<input type='text' class='form-control' aria-describedby='sizing-addon2' id='pergunta".$solicitacao_numero."' value='".$solicitacao_pergunta."'>";
					echo "</div>";
					echo "<textarea class='form-control' rows='7' id='resposta".$solicitacao_numero."'>".$solicitacao_resposta."</textarea>";
					echo "<br>";
				echo "</div>";
				echo "<div class='col-md-1'>";
					echo "<button type='button' class='btn btn-primary' id='btn_SalvarProjeto' onclick='remove_pergunta(".$solicitacao_numero.")'>";
					echo "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
					echo "</button>";
				echo "</div>";
			echo "</div>";
			}
		}
										
	echo "</div>";
echo "<div class='row'>";
echo "<button type='button' class='btn btn-primary' id='btn_SalvarProjeto' onclick='salvaedicao_solicitacao(".$solicitacao_id.")'>";
echo "<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Salvar";
echo "</button>";
echo "</div>";
echo "</div>";
?>