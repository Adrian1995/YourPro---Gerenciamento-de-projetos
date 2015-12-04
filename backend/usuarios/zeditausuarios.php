<?php 
include('../yconectaDB.inc');

$usuario_id = $_POST["usuario_id"];
$usuario_nome = $_POST["usuario_nome"];
$usuario_email = $_POST["usuario_email"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_senha_antiga = $dados["usuario_senha"];

if($usuario_senha_antiga != $_POST["usuario_senha"])
	{
	$usuario_senha = $_POST["usuario_senha"]; $usuario_senha = md5($usuario_senha);
	}
else
	{
	$usuario_senha = $usuario_senha_antiga;
	}


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


if ($usuario_id == 1)
		{
		echo "O usuário Administrador não pode ser editado!";
		}
	else
		{
		$editaUsuario = mysqli_query ($conectaBanco ,"UPDATE login SET 	usuario_nome='$usuario_nome', 
																		usuario_email='$usuario_email',
																		usuario_senha='$usuario_senha',
																		usuario_tipo='$usuario_tipo',
																		usuario_visu_projetos='$usuario_visu_projetos',
																		usuario_cada_projetos='$usuario_cada_projetos',
																		usuario_edit_projetos='$usuario_edit_projetos',
																		usuario_excl_projetos='$usuario_excl_projetos',
																		usuario_visu_usuarios='$usuario_visu_usuarios',
																		usuario_cada_usuarios='$usuario_cada_usuarios',
																		usuario_edit_usuarios='$usuario_edit_usuarios',
																		usuario_excl_usuarios='$usuario_excl_usuarios',
																		usuario_visu_solicitacao='$usuario_visu_solicitacao',
																		usuario_cada_solicitacao='$usuario_cada_solicitacao',
																		usuario_edit_solicitacao='$usuario_edit_solicitacao',
																		usuario_excl_solicitacao='$usuario_excl_solicitacao',
																		usuario_visu_rotina='$usuario_visu_rotina',
																		usuario_cada_rotina='$usuario_cada_rotina',
																		usuario_edit_rotina='$usuario_edit_rotina',
																		usuario_excl_rotina='$usuario_excl_rotina',
																		usuario_visu_configuracao='$usuario_visu_configuracao',
																		usuario_edit_configuracao='$usuario_edit_configuracao'
															
															WHERE usuario_id = '$usuario_id'  ") or die (mysql_error());
									
									
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
																		VALUES ('$historico_id', '$usuario_id_atual', 'alteracaodeusuario', '$historico_data', '$usuario_id', 'O usuário $usuario_nome_atual alterou o usuário :: $usuario_id - $usuario_nome')");

			
		//---------------------------------------------------------------------------------------------------------------------------------------------											
			
										
		echo "OK";
		}
										
									
?>