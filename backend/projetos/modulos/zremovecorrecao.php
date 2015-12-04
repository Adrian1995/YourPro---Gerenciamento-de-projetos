<?php 
include('../../yconectaDB.inc');

$correcao_projeto_id = $_POST["correcao_projeto_id"];

	$deletaProjetocorrecao = mysqli_query($conectaBanco ,"DELETE FROM mod_correcao WHERE correcao_projeto_id = '$correcao_projeto_id'") or die (mysql_error());
		
?>