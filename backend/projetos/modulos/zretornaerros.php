<?php 
include('../../yconectaDB.inc');

$erro_projeto_id = $_POST["erro_projeto_id"];

echo "<div class='row' id='recebe_erros'>";
					
$consultaerros = mysqli_query($conectaBanco ,"SELECT * FROM mod_erros WHERE erro_projeto_id ='$erro_projeto_id' and erro_status <> 'Finalizado' ORDER BY erro_id");

while ($dados = mysqli_fetch_array($consultaerros))
	{
	$erro_id = $dados["erro_id"];
	$erro_usuario_id = $dados["erro_usuario_id"];
	$erro_status = $dados["erro_status"];
	$erro_nome = $dados["erro_nome"];
	$erro_descricao = $dados["erro_descricao"];
	$erro_imagem1 = $dados["erro_imagem1"];
	$erro_imagem2 = $dados["erro_imagem2"];
	$erro_imagem3 = $dados["erro_imagem3"];
	$erro_imagem4 = $dados["erro_imagem4"];
	$erro_imagem5 = $dados["erro_imagem5"];
						
	$consultausuario = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_id='$erro_usuario_id'");
	$dados = mysqli_fetch_array($consultausuario);
	$erro_usuario_nome = $dados["usuario_nome"];
						
	echo "<div class='row'>";
	echo "<hr>";
		echo "<div class='col-md-4 col-md-offset-1'>";
			echo "<b> ID/Nome do erro : </b> $erro_id - $erro_nome";
		echo "</div>";
		echo "<div class='col-md-3'>";
			echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Status : </span>";
			echo "<select class='form-control' aria-describedby='sizing-addon2' id='erro_status$erro_id'>";
				echo "<option value='$erro_status'>$erro_status";
				if($erro_status != "Em andamento") {echo "<option value='Em andamento'>Em andamento";}
				if($erro_status != "Finalizado") {echo "<option value='Finalizado'>Finalizado";}
			echo "</select>";
			echo "</div>";
		echo "</div>";
		echo "<div class='col-md-3'>";
			echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Atribuido a : </span>";
			echo "<select class='form-control' aria-describedby='sizing-addon2' id='erro_usuario_id$erro_id'>";
				echo "<option value='$erro_usuario_id'>$erro_usuario_id :: $erro_usuario_nome";
									
				$consultausuarios = mysqli_query($conectaBanco ,"SELECT * FROM login WHERE usuario_tipo = 'Normal' ORDER BY usuario_id");
				while($dados = mysqli_fetch_array($consultausuarios))
					{
					$usuario_id = $dados["usuario_id"];
					$usuario_nome = $dados["usuario_nome"];
										
					if($erro_usuario_id != $usuario_id)
						{
						echo "<option value='$usuario_id'>$usuario_id :: $usuario_nome";
						}
					}
			echo "</select>";
			echo "</div>";
		echo "</div>";
		echo "<div class='col-md-1'>";
			echo "<input type='button' class='btn btn-primary' value='Ok' onclick='altera_erro($erro_id)'>";
		echo "</div>";
		echo "<div class='col-md-10 col-md-offset-1'>";
			echo "<b> Descrição : </b> $erro_descricao";
		echo "</div>";
		echo "<div class='col-md-10 col-md-offset-1'>";
			echo "<br><b> Imagens do erro: </b><br><br>";
			if($erro_imagem1 != "")
				{
				echo "<div class='col-md-4'>";
					echo "<img src='backend/projetos/relatarerro/fotos/$erro_imagem1' class='img-responsive img-rounded'>";
				echo "</div>";
				}
			if($erro_imagem2 != "")
				{
				echo "<div class='col-md-4'>";
					echo "<img src='backend/projetos/relatarerro/fotos/$erro_imagem2' class='img-responsive img-rounded'>";
				echo "</div>";
				}
			if($erro_imagem3 != "")
				{
				echo "<div class='col-md-4'>";
					echo "<img src='backend/projetos/relatarerro/fotos/$erro_imagem3' class='img-responsive img-rounded'>";
				echo "</div>";
				}
			if($erro_imagem4 != "")
				{
				echo "<div class='col-md-4'>";
					echo "<img src='backend/projetos/relatarerro/fotos/$erro_imagem4' class='img-responsive img-rounded'>";
				echo "</div>";
				}
			if($erro_imagem5 != "")
				{
				echo "<div class='col-md-4'>";
					echo "<img src='backend/projetos/relatarerro/fotos/$erro_imagem5' class='img-responsive img-rounded'>";
				echo "</div>";
				}
		echo "</div>";
	echo "</div>";
	}
						
echo "</div>";

?>