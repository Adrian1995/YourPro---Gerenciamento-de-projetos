<?php 
include('../yconectaDB.inc');

$usuario_id = $_POST["usuario_id"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_nome = $dados["usuario_nome"];
$usuario_email = $dados["usuario_email"];
$usuario_senha = $dados["usuario_senha"];
$usuario_tipo = $dados["usuario_tipo"];
$usuario_visu_projetos = $dados["usuario_visu_projetos"];
$usuario_cada_projetos = $dados["usuario_cada_projetos"];
$usuario_edit_projetos = $dados["usuario_edit_projetos"];
$usuario_excl_projetos = $dados["usuario_excl_projetos"];
$usuario_visu_usuarios = $dados["usuario_visu_usuarios"];
$usuario_cada_usuarios = $dados["usuario_cada_usuarios"];
$usuario_edit_usuarios = $dados["usuario_edit_usuarios"];
$usuario_excl_usuarios = $dados["usuario_excl_usuarios"];

$usuario_visu_solicitacao = $dados["usuario_visu_solicitacao"];
$usuario_cada_solicitacao = $dados["usuario_cada_solicitacao"];
$usuario_edit_solicitacao = $dados["usuario_edit_solicitacao"];
$usuario_excl_solicitacao = $dados["usuario_excl_solicitacao"];

$usuario_visu_rotina = $dados["usuario_visu_rotina"];
$usuario_cada_rotina = $dados["usuario_cada_rotina"];
$usuario_edit_rotina = $dados["usuario_edit_rotina"];
$usuario_excl_rotina = $dados["usuario_excl_rotina"];

$usuario_visu_configuracao = $dados["usuario_visu_configuracao"];
$usuario_edit_configuracao = $dados["usuario_edit_configuracao"];

echo "<div class='col-md-10 col-md-offset-1' id='temporario_editusuarios'>";
echo "<h3>Alteração de usuário</h3>";
echo "<br>";
echo "<div class='row'>";
echo "<div class='col-md-5'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span> <input type='text' id='usuario_nome' class='form-control' aria-describedby='sizing-addon2' value='$usuario_nome'></div>";
echo "<br>";
echo "<div class='input-group'><div class='input-group-addon'><span class='glyphicon glyphicon-user' aria-hidden='true'></span> </div> <input type='text' id='usuario_email' class='form-control' placeholder='Insira o Email...' value='$usuario_email'></div>";
echo "<br>";
echo "<div class='input-group'><div class='input-group-addon'><span class='glyphicon glyphicon-eye-close' aria-hidden='true'></span> </div> <input type='password' id='usuario_senha' class='form-control' placeholder='Insira a Senha...' value='$usuario_senha'> </div>";
echo "<br>";
echo "<div class='input-group'><div class='input-group-addon'>Tipo</span> </div>";
	echo "<select id='usuario_tipo' class='form-control'"; if($usuario_id == 1 ){echo "disabled";} echo ">";
	echo "<option value='$usuario_tipo'>$usuario_tipo";
	if($usuario_tipo != "Normal") {echo "<option value='Normal'>Normal";}
	if($usuario_tipo != "Solicitante") {echo "<option value='Solicitante'>Solicitante";}
	echo "</select>";
echo "</div>";
echo "<br>";
echo "</div>";

echo "<div class='col-md-3'>";
											
echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";
echo "<h4>Projetos</h4>";
echo "<input type='checkbox' id='usuario_visu_projetos'"; if($usuario_id == 1 ){echo " disabled ";} if($usuario_visu_projetos == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; ";
echo "<input type='checkbox' id='usuario_cada_projetos'"; if($usuario_id == 1 ){echo " disabled ";} if($usuario_cada_projetos == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_edit_projetos'"; if($usuario_id == 1 ){echo " disabled ";} if($usuario_edit_projetos == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_excl_projetos'";if($usuario_id == 1 ){echo " disabled ";}  if($usuario_excl_projetos == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
echo "</div>";
echo "</div>";
											
echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";
echo "<h4>Usuários</h4>";
echo "<input type='checkbox' id='usuario_visu_usuarios'"; if($usuario_id == 1 ){echo " disabled ";} if($usuario_visu_usuarios == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; ";
echo "<input type='checkbox' id='usuario_cada_usuarios'"; if($usuario_id == 1 ){echo " disabled ";} if($usuario_cada_usuarios == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_edit_usuarios'"; if($usuario_id == 1 ){echo " disabled ";} if($usuario_edit_usuarios == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_excl_usuarios'"; if($usuario_id == 1 ){echo " disabled ";} if($usuario_excl_usuarios == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
echo "</div>";
echo "</div>";
			
echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";
echo "<h4>Configurações</h4>";
echo "<input type='checkbox' id='usuario_visu_configuracao'"; if($usuario_visu_configuracao == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; ";
echo "<input type='checkbox' id='usuario_edit_configuracao'"; if($usuario_edit_configuracao == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "</div>";
echo "</div>";
			
			
			
echo "</div>";





echo "<div class='col-md-3'>";
											
echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";
echo "<h4>Solicitações</h4>";
echo "<input type='checkbox' id='usuario_visu_solicitacao'"; if($usuario_visu_solicitacao == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; ";
echo "<input type='checkbox' id='usuario_cada_solicitacao'"; if($usuario_cada_solicitacao == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_edit_solicitacao'"; if($usuario_edit_solicitacao == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_excl_solicitacao'"; if($usuario_excl_solicitacao == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
echo "</div>";
echo "</div>";
											
echo "<div class='panel panel-default'>";
echo "<div class='panel-body'>";
echo "<h4>Rotinas</h4>";
echo "<input type='checkbox' id='usuario_visu_rotina'"; if($usuario_visu_rotina == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp; ";
echo "<input type='checkbox' id='usuario_cada_rotina'"; if($usuario_cada_rotina == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-plus' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_edit_rotina'"; if($usuario_edit_rotina == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> &nbsp; &nbsp; &nbsp;";
echo "<input type='checkbox' id='usuario_excl_rotina'"; if($usuario_excl_rotina == "S"){echo " checked ";} echo "> <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
echo "</div>";
echo "</div>";
			
echo "</div>";





											
echo "</div>";
											
echo "<button type='button' class='btn btn-primary' id='btn_EditarUsuario' onclick='salvaedicao_usuario(".$usuario_id.")'>";
echo "<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Salvar usuário";
echo "</button>";
echo "<br><br>";
echo "</div>";
?>