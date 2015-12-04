<?php 
include('../yconectaDB.inc');

$usuario_nome = $_POST["usuario_nome"];
$usuario_email = $_POST["usuario_email"];

$consultaSeUsuarioExiste = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_nome = '$usuario_nome'");
$consultaSeUsuarioExiste2 = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_email = '$usuario_email'");
$verificadorSeUsuarioExiste = mysqli_num_rows($consultaSeUsuarioExiste);
$verificadorSeUsuarioExiste2 = mysqli_num_rows($consultaSeUsuarioExiste2);

if($verificadorSeUsuarioExiste == 0)
	{
	if($verificadorSeUsuarioExiste2 == 0)
		{
		$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(Usuario_ID) FROM login");
		$dados = mysqli_fetch_array($consultaUltimoID);
		$ultimoID = $dados["0"];
		$ultimoID = $ultimoID+1;

		$usuario_id = $ultimoID;
		$usuario_nome = $_POST["usuario_nome"];
		$usuario_email = $_POST["usuario_email"];
		$usuario_senha = $_POST["usuario_senha"]; $usuario_senha = md5($usuario_senha);
		$usuario_tipo = $_POST["usuario_tipo"]; 
		$usuario_visu_projetos = $_POST["usuario_visu_projetos"];
		$usuario_cada_projetos = $_POST["usuario_cada_projetos"];
		$usuario_edit_projetos = $_POST["usuario_edit_projetos"];
		$usuario_excl_projetos = $_POST["usuario_excl_projetos"];
		$usuario_visu_usuarios = $_POST["usuario_visu_usuarios"];
		$usuario_cada_usuarios = $_POST["usuario_cada_usuarios"];
		$usuario_edit_usuarios = $_POST["usuario_edit_usuarios"];
		$usuario_excl_usuarios = $_POST["usuario_excl_usuarios"];
		$usuario_visu_solicitacao = $_POST["usuario_visu_solicitacao"];
		$usuario_cada_solicitacao = $_POST["usuario_cada_solicitacao"];
		$usuario_edit_solicitacao = $_POST["usuario_edit_solicitacao"];
		$usuario_excl_solicitacao = $_POST["usuario_excl_solicitacao"];
		$usuario_visu_rotina = $_POST["usuario_visu_rotina"];
		$usuario_cada_rotina = $_POST["usuario_cada_rotina"];
		$usuario_edit_rotina = $_POST["usuario_edit_rotina"];
		$usuario_excl_rotina = $_POST["usuario_excl_rotina"];
		$usuario_visu_configuracao = $_POST["usuario_visu_configuracao"];
		$usuario_edit_configuracao = $_POST["usuario_edit_configuracao"];

		$cadCliente = mysqli_query ($conectaBanco ,"INSERT INTO login (	usuario_id, 
																		usuario_nome, 
																		usuario_email,
																		usuario_senha,
																		usuario_tipo,
																		usuario_visu_projetos,
																		usuario_cada_projetos,
																		usuario_edit_projetos,
																		usuario_excl_projetos,
																		usuario_visu_usuarios,
																		usuario_cada_usuarios,
																		usuario_edit_usuarios,
																		usuario_excl_usuarios,
																		usuario_visu_solicitacao,
																		usuario_cada_solicitacao,
																		usuario_edit_solicitacao,
																		usuario_excl_solicitacao,
																		usuario_visu_rotina,
																		usuario_cada_rotina,
																		usuario_edit_rotina,
																		usuario_excl_rotina,
																		usuario_visu_configuracao,
																		usuario_edit_configuracao)					
															VALUES ('$usuario_id', 
																	'$usuario_nome',
																	'$usuario_email',
																	'$usuario_senha',
																	'$usuario_tipo',
																	'$usuario_visu_projetos',
																	'$usuario_cada_projetos',
																	'$usuario_edit_projetos',
																	'$usuario_excl_projetos',
																	'$usuario_visu_usuarios',
																	'$usuario_cada_usuarios',
																	'$usuario_edit_usuarios',
																	'$usuario_excl_usuarios',
																	'$usuario_visu_solicitacao',
																	'$usuario_cada_solicitacao',
																	'$usuario_edit_solicitacao',
																	'$usuario_excl_solicitacao',
																	'$usuario_visu_rotina',
																	'$usuario_cada_rotina',
																	'$usuario_edit_rotina',
																	'$usuario_excl_rotina',
																	'$usuario_visu_configuracao',
																	'$usuario_edit_configuracao')") or die (mysql_error());
													
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
																		VALUES ('$historico_id', '$usuario_id_atual', 'cadastrodeusuario', '$historico_data', '$usuario_id', 'O usuário $usuario_nome_atual cadastrou o usuário :: $usuario_id - $usuario_nome')");

			
		//---------------------------------------------------------------------------------------------------------------------------------------------											
				
																							
		echo "OK";
		}
	else
		{
		echo "<strong>Cadastro não efetuado!</strong> Já existe um usuário com esse E-mail!";
		}
	}
else
	{
	echo "<strong>Cadastro não efetuado!</strong> Já existe um usuário com esse Nome!";
	}
?>