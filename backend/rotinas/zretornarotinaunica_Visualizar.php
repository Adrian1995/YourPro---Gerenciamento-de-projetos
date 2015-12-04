<?php 
include('../yconectaDB.inc');

//======================================================================================================================CARREGA PERMISSÕES DO USUÁRIO
$usuario_id_atual = $_POST["usuario_id_atual"];

$consultaUsuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id = '$usuario_id_atual'");
$dados = mysqli_fetch_array($consultaUsuarios);
$usuario_edit_rotina_atual = $dados["usuario_edit_rotina"];
//----------------------------------------------------------------------------------------------------------------------------------------------------

$rotina_id = $_POST["rotina_id"];

$consultaRotinas = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id = '$rotina_id'");
$dados = mysqli_fetch_array($consultaRotinas);
$rotina_nome = $dados["rotina_nome"];
$rotina_descricao = $dados["rotina_descricao"];
$rotina_datacriacao = $dados["rotina_datacriacao"];

echo "<div class='col-md-10 col-md-offset-1' id='temporario_visurotinas'>";
echo "<h3>Visualização de rotina</h3>";

echo "<br>";
echo "<div class='row'>";
echo "<div class='col-md-8'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span> <input type='text' id='rotina_nome' class='form-control' aria-describedby='sizing-addon2' value='$rotina_nome' disabled></div>";
echo "<br>";
echo "<textarea class='form-control' rows='10' id='rotina_descricao' placeholder='Insira a descrição da rotina...' disabled>$rotina_descricao</textarea>";
echo "<br>";
if($usuario_edit_rotina_atual == "S")
	{
	echo "<button type='button' class='btn btn-primary' id='btn_EditarRotina' onclick='edita_rotina(".$rotina_id.")'>";
	echo "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Editar rotina";
	echo "</button>";
	}
echo "<br><br>";
echo "</div></div>";

echo "<div class='row' id='recebe_alteracoescorrecoes'>";
	echo "<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";


$consultamoduloalteracao = mysqli_query($conectaBanco ,"SELECT * FROM mod_alteracao WHERE alteracao_rotina_id = '$rotina_id'");		
	$verificamoduloalteracao = mysqli_num_rows($consultamoduloalteracao);
	if($verificamoduloalteracao > 0)
		{
		
		echo "<div class='panel panel-default' id='moduloAlteracao'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloAlteracao'>";
				echo "<h4 class='panel-title'>";
					echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloAlteracao' aria-expanded='true' aria-controls='collapse_moduloAlteracao'>";
					echo "Alteração - Para alteração de funções/rotinas ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloAlteracao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloAlteracao'>";
				echo "<div class='panel-body'>";
					echo "<div class='row' id='container_alteracao'>";
					
					
			$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(alteracao_numero) FROM mod_alteracao WHERE alteracao_rotina_id = '$rotina_id' ");		
			$dados = mysqli_fetch_array($consultaUltimoID);
			$ultimoID = $dados["0"];
			echo "<input type='hidden' id='ultimoregistro' value='$ultimoID'>";
			
			for ($i = 1; $i <= $ultimoID; $i++) 
				{
				$consultaalteracao = mysqli_query($conectaBanco ,"SELECT * FROM mod_alteracao WHERE alteracao_rotina_id = '$rotina_id' and alteracao_numero = '$i' ");		
				$numeroregistros = mysqli_num_rows($consultaalteracao);
				
				if($numeroregistros > 0)
					{		
					$dados = mysqli_fetch_array($consultaalteracao);
					$alteracao_id = $dados["alteracao_id"];
					$alteracao_projeto_id = $dados["alteracao_projeto_id"];
					$alteracao_numero = $dados["alteracao_numero"];
					$alteracao_rotina_id = $dados["alteracao_rotina_id"];
					$alteracao_nome = $dados["alteracao_nome"];
					$alteracao_objetivo = $dados["alteracao_objetivo"];
					$alteracao_antes = $dados["alteracao_antes"];
					$alteracao_depois = $dados["alteracao_depois"];
					
					echo "<div class='row' id='container_alteracao".$alteracao_numero."'>";
					echo "<br>";
						echo "<div class='col-md-10 col-md-offset-1'>";
							echo "<div class='row'>";
								echo "<div class='col-md-2'>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>ID </span>";
									echo "<input type='text' class='form-control' id='alteracao_numero".$alteracao_numero."' value='".$alteracao_numero."' disabled>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-9'>";
									echo "<select id='alteracao_rotina_id".$alteracao_numero."' class='form-control' onchange='retorna_info_alteracao(".$alteracao_numero.")' disabled>";
									
									$consultarotina = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id = '$alteracao_rotina_id' ");		
									$dados = mysqli_fetch_array($consultarotina);
									$alteracao_rotina_nome = $dados["rotina_nome"];
									
										echo "<option value='$alteracao_rotina_id'>$alteracao_rotina_id :: $alteracao_rotina_nome ";
									echo "</select>";
								echo "</div>";
							echo "</div>";
							echo "<div class='row'>";
								echo "<div class='col-md-11'>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2' disabled>Nome da alteração </span>";
									echo "<input type='text' class='form-control' id='alteracao_nome".$alteracao_numero."' value='".$alteracao_nome."' disabled>";
									echo "</div>";
								echo "</div>";
							echo "</div>";
							echo "<div class='row'>";
								echo "<div class='col-md-3'>";
									echo "<textarea class='form-control' rows='5' placeholder='Como era antes das alterações...' id='alteracao_antes".$alteracao_numero."' disabled>".$alteracao_antes."</textarea>";
								echo "</div>";
								echo "<div class='col-md-3'>";
									echo "<textarea class='form-control' rows='5' placeholder='Como ficará depois das alterações...' id='alteracao_depois".$alteracao_numero."' disabled>".$alteracao_depois."</textarea>";
								echo "</div>";
								echo "<div class='col-md-4'>";
									echo "<textarea class='form-control' rows='5' placeholder='Qual o objetivo da alteração...' id='alteracao_objetivo".$alteracao_numero."' disabled>".$alteracao_objetivo."</textarea>";
								echo "</div>";
							echo "</div>";	
						echo "</div>";
					echo "</div>";
					}
				}
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		}
		
	
	$consultamodulocorrecao = mysqli_query($conectaBanco ,"SELECT * FROM mod_correcao WHERE correcao_rotina_id = '$rotina_id'");		
	$verificamodulocorrecao = mysqli_num_rows($consultamodulocorrecao);
	if($verificamodulocorrecao > 0)
		{	
		
		echo "<div class='panel panel-default' id='moduloCorrecao'>";
			echo "<div class='panel-heading' role='tab' id='heading_moduloCorrecao'>";
				echo "<h4 class='panel-title'>";
					echo "<a class='collapsed' data-toggle='collapse' data-parent='#accordion' href='#collapse_moduloCorrecao' aria-expanded='true' aria-controls='collapse_moduloCorrecao'>";
					echo "Correção - Para correção de funções/rotinas ";
					echo "</a>";
				echo "</h4>";
			echo "</div>";
			echo "<div id='collapse_moduloCorrecao' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading_moduloCorrecao'>";
				echo "<div class='panel-body'>";
				echo "<div class='row' id='container_correcao'>";
				
			
			$consultaUltimoID = mysqli_query($conectaBanco ,"SELECT MAX(correcao_numero) FROM mod_correcao WHERE correcao_rotina_id = '$rotina_id' ");		
			$dados = mysqli_fetch_array($consultaUltimoID);
			$ultimoID = $dados["0"];
			echo "<input type='hidden' id='ultimoregistro' value='$ultimoID'>";
			
			for ($i = 1; $i <= $ultimoID; $i++) 
				{
				$consultacorrecao = mysqli_query($conectaBanco ,"SELECT * FROM mod_correcao WHERE correcao_rotina_id = '$rotina_id' and correcao_numero = '$i' ");		
				$numeroregistros = mysqli_num_rows($consultacorrecao);
				
				if($numeroregistros > 0)
					{		
					$dados = mysqli_fetch_array($consultacorrecao);
					$correcao_id = $dados["correcao_id"];
					$correcao_projeto_id = $dados["correcao_projeto_id"];
					$correcao_numero = $dados["correcao_numero"];
					$correcao_rotina_id = $dados["correcao_rotina_id"];
					$correcao_nome = $dados["correcao_nome"];
					$correcao_descricao = $dados["correcao_descricao"];
		
						echo "<div class='row' id='container_correcao".$correcao_numero."'>";
							echo "<br>";
							echo "<div class='col-md-10 col-md-offset-1'>";
								echo "<div class='col-md-2'>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>ID </span>";
										echo "<input type='text' class='form-control' id='correcao_numero".$correcao_numero."' value='".$correcao_numero."' disabled>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-8'>";
									echo "<select id='correcao_rotina_id".$correcao_numero."' class='form-control' disabled>";
									
									$consultarotina = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id = '$correcao_rotina_id' ");		
									$dados = mysqli_fetch_array($consultarotina);
									$correcao_rotina_nome = $dados["rotina_nome"];
									
										echo "<option value='$correcao_rotina_id'>$correcao_rotina_id :: $correcao_rotina_nome ";
									echo "</select>";
									echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome da correção </span>";
										echo "<input type='text' class='form-control' id='correcao_nome".$correcao_numero."' value='".$correcao_nome."' disabled>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-md-10'>";
									echo "<textarea class='form-control' rows='5' id='correcao_descricao".$correcao_numero."' disabled>".$correcao_descricao."</textarea>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
					}
				}
				
				echo "</div>";
			echo "</div>";
		echo "</div>";
		
		}
		

	echo "</div>";
echo "</div>";

echo "</div>";
?>