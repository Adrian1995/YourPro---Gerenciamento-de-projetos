<?php 
include('../../yconectaDB.inc');

$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(forum_id) FROM mod_forum");		
$dados = mysqli_fetch_array($consultaUltimoID);
$ultimoID = $dados["0"];

$forum_id = $ultimoID+1;
$forum_projeto_id = $_POST["forum_projeto_id"];
$forum_usuario_id = $_POST["usuario_id_atual"];
$forum_mensagem = $_POST["forum_mensagem"];

$cadmensagem = mysqli_query ($conectaBanco ,"INSERT INTO mod_forum (forum_id,
														forum_projeto_id, 
														forum_usuario_id,
														forum_mensagem)				
														
												VALUES ('$forum_id',
														'$forum_projeto_id', 
														'$forum_usuario_id',
														'$forum_mensagem')") or die (mysql_error());
?>