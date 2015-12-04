<?php 
include('../yconectaDB.inc');

$solicitacao_id = $_POST["solicitacao_id"];

$consultaSolicitacoes = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoes WHERE solicitacao_id = '$solicitacao_id'");
$verificasolicitacao = mysqli_num_rows($consultaSolicitacoes);

if($verificasolicitacao > 0)
	{
	$dados = mysqli_fetch_array($consultaSolicitacoes);
	$solicitacao_usuario = $dados["solicitacao_usuario"];
	$solicitacao_data = $dados["solicitacao_data"];
	$solicitacao_status = $dados["solicitacao_status"];
	$solicitacao_observacao = $dados["solicitacao_observacao"];

		$solicitacao_data = date_create("$solicitacao_data");
		$solicitacao_data = (date_format($solicitacao_data, "d/m/Y H:i"));

	$consultausuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$solicitacao_usuario' ");
	$dados = mysqli_fetch_array($consultausuario);
	$solicitacao_usuario_nome = $dados["usuario_nome"];
		

	echo "<div id='recebe_info_solicitacao'>";
	echo "<br>";
	echo "<div class='row' id='recebe_solicitacao'>";
		echo "<div class='col-md-3 col-md-offset-1'>";
			echo "<b>Usuário solicitante:</b> $solicitacao_usuario_nome";
		echo "</div>";
		echo "<div class='col-md-4'>";
			echo "<b>Data de solicitação:</b> $solicitacao_data<br>";
		echo "</div>";
		echo "<div class='col-md-3'>";
			echo "<b>Status da solicitação:</b> $solicitacao_status<br>";
		echo "</div>";
	echo "</div>";
	echo "<div class='row'>";
		echo "<div class='col-md-10 col-md-offset-1'>";
			echo "<b>Observação da solicitação:</b> $solicitacao_observacao";
		echo "</div>";
	echo "</div>";
	echo "<div class='row' id='recebe_perguntas'>";
		echo "<br>";
		echo "<div class='col-md-10 col-md-offset-1'>";
		echo "<h3>Perguntas e respostas da solicitação</h3>";
		$consultaperguntas = mysqli_query($conectaBanco ,"SELECT * FROM solicitacoesrespostas WHERE solicitacao_id = '$solicitacao_id'");
		while($dados = mysqli_fetch_array($consultaperguntas))
			{
			$solicitacao_pergunta = $dados["solicitacao_pergunta"];
			$solicitacao_resposta = $dados["solicitacao_resposta"];
			
			echo "<b>$solicitacao_pergunta</b><br>$solicitacao_resposta<br><br>";
			}
		echo "</div>";
	echo "</div>";
	echo "</div>";
	}
else
	{
	echo "SOLICITACAONAOEXISTE";
	}
?>