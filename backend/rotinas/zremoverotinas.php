<?php 
include('../yconectaDB.inc');

$rotina_id = $_POST["rotina_id"];
$consultaNomeRotina = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id='$rotina_id'");		
$dadoshistorico = mysqli_fetch_array($consultaNomeRotina);
$rotina_nome = $dadoshistorico["rotina_nome"];

	$deletaRotinaEspecifica = mysqli_query($conectaBanco ,"DELETE FROM rotinas WHERE rotina_id = '$rotina_id'") or die (mysql_error());
	
	//==========================================================================================================================Cadastra histórico
	$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
	$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
	$ultimoID = $dadoshistorico["0"];
	$historico_id = $ultimoID+1;												

	$usuario_id_atual = $_POST["usuario_id_atual"];
	$consultaNomeUsuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$usuario_id_atual'");		
	$dadoshistorico = mysqli_fetch_array($consultaNomeUsuario);
	$usuario_nome = $dadoshistorico["usuario_nome"];

	$historico_data = date('Y-m-d H:i:s'); 
													
	$cadHistoricoProjetoCadastrado = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_rotina, historico_texto) 
																	VALUES ('$historico_id', '$usuario_id_atual', 'remocaoderotina', '$historico_data', '0', 'O usuário $usuario_nome removeu a rotina :: $rotina_id - $rotina_nome')");

	$deletaHistoricoUsuarios = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tipo in ('cadastroderotina', 'alteracaoderotina') AND historico_rotina = '$rotina_id'") or die (mysql_error());
		
	//---------------------------------------------------------------------------------------------------------------------------------------------											
		
?>