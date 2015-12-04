<?php 
include('../yconectaDB.inc');

$rotina_nome = $_POST["rotina_nome"];
$rotina_descricao = $_POST["rotina_descricao"];

$consultaSeRotinaExiste = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_nome = '$rotina_nome'");
$verificadorSeRotinaExiste = mysqli_num_rows($consultaSeRotinaExiste);

if($verificadorSeRotinaExiste == 0)
	{
		$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(rotina_id) FROM rotinas");
		$dados = mysqli_fetch_array($consultaUltimoID);
		$ultimoID = $dados["0"];
		$ultimoID = $ultimoID+1;

		$rotina_id = $ultimoID;
		$rotina_datacriacao = date('Y-m-d H:i:s'); 


		$cadRotina = mysqli_query ($conectaBanco ,"INSERT INTO rotinas (rotina_id, 
																rotina_nome, 
																rotina_descricao,
																rotina_datacriacao)					
													VALUES ('$rotina_id', 
															'$rotina_nome',
															'$rotina_descricao',
															'$rotina_datacriacao')") or die (mysql_error());
													
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
																	VALUES ('$historico_id', '$usuario_id_atual', 'cadastroderotina', '$historico_data', '$rotina_id', 'O usuário $usuario_nome cadastrou a rotina :: $rotina_id - $rotina_nome')");

	//---------------------------------------------------------------------------------------------------------------------------------------------											
		
		echo "OK";
	}
else
	{
	echo "<strong>Cadastro não efetuado!</strong> Já existe uma rotina com esse Nome!";
	}
?>