<?php 
include('../../yconectaDB.inc');

$forum_projeto_id = $_POST["forum_projeto_id"];

$consultaforum = mysqli_query($conectaBanco ,"SELECT * FROM mod_forum WHERE forum_projeto_id ='$forum_projeto_id' ORDER BY forum_projeto_id");

echo "<table class='table' id='recebe_mensagensforum'>";
echo "<tbody><td><h3>Usuário</h3></td><td><h3>Mensagem</h3></td></tbody>";
while ($dados = mysqli_fetch_array($consultaforum))
	{
	$forum_id = $dados["forum_id"];
	$forum_projeto_id = $dados["forum_projeto_id"];
	$forum_usuario_id = $dados["forum_usuario_id"];
	$forum_mensagem = $dados["forum_mensagem"];
	
	$consultausuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$forum_usuario_id'");
	$dados = mysqli_fetch_array($consultausuario);
	$usuario_nome = $dados["usuario_nome"];
	
	echo "<tbody><td><b>$usuario_nome</b></td><td>$forum_mensagem</td></tbody>";
	}
echo "</table>";
?>