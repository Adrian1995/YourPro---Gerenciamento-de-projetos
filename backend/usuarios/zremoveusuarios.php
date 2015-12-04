<?php 
include('../yconectaDB.inc');

$usuario_id = $_POST["usuario_id"];
$consultaNomeUsuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$usuario_id'");		
$dadoshistorico = mysqli_fetch_array($consultaNomeUsuario);
$usuario_nome = $dadoshistorico["usuario_nome"];

	if ($usuario_id == 1)
		{
		echo "O usuário Administrador não pode ser excluído!";
		}
	else
		{
		$deletaUsuarioEspecifico = mysqli_query($conectaBanco ,"DELETE FROM login WHERE usuario_id = '$usuario_id'") or die (mysql_error());
		
		//==========================================================================================================================Cadastra histórico
		$consultaUltimoHistorico = mysqli_query($conectaBanco ,"SELECT MAX(historico_id) FROM historico");		
		$dadoshistorico = mysqli_fetch_array($consultaUltimoHistorico);
		$ultimoID = $dadoshistorico["0"];
		$historico_id = $ultimoID+1;												

		$usuario_id_atual = $_POST["usuario_id_atual"];
		$consultaNomeUsuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$usuario_id_atual'");		
		$dadoshistorico = mysqli_fetch_array($consultaNomeUsuario);
		$usuario_nome_atual = $dadoshistorico["usuario_nome"];

		$historico_data = date('Y-m-d H:i:s'); 
														
		$cadHistoricoProjetoCadastrado = mysqli_query($conectaBanco ,"INSERT INTO historico (historico_id, historico_usuario_id, historico_tipo, historico_data, historico_usuario, historico_texto) 
																		VALUES ('$historico_id', '$usuario_id_atual', 'remocaodeusuario', '$historico_data', '0', 'O usuário $usuario_nome_atual removeu o usuário :: $usuario_id - $usuario_nome')");

		$deletaHistoricoUsuarios = mysqli_query($conectaBanco ,"DELETE FROM historico WHERE historico_tipo in ('cadastrodeusuario', 'alteracaodeusuario') AND historico_usuario = '$usuario_id'") or die (mysql_error());
		
			
		//---------------------------------------------------------------------------------------------------------------------------------------------											
		}
?>