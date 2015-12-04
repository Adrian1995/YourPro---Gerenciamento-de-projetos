<?php 
include('../../yconectaDB.inc');

$alteracao_rotina_id = $_POST["alteracao_rotina_id"];

$consultarotina = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id = '$alteracao_rotina_id'");		
$dados = mysqli_fetch_array($consultarotina);
$rotina_descricao = $dados["rotina_descricao"];

echo $rotina_descricao;
?>