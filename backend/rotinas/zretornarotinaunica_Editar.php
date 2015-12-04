<?php 
include('../yconectaDB.inc');

$rotina_id = $_POST["rotina_id"];

$consultaRotinas = mysqli_query($conectaBanco ,"SELECT * FROM rotinas WHERE rotina_id = '$rotina_id'");
$dados = mysqli_fetch_array($consultaRotinas);
$rotina_nome = $dados["rotina_nome"];
$rotina_descricao = $dados["rotina_descricao"];
$rotina_datacriacao = $dados["rotina_datacriacao"];

echo "<div class='col-md-10 col-md-offset-1' id='temporario_editrotinas'>";
echo "<h3>Alteração de rotina</h3>";
echo "<br>";
echo "<div class='row'>";
echo "<div class='col-md-8'>";
echo "<div class='input-group'> <span class='input-group-addon' id='sizing-addon2'>Nome</span> <input type='text' id='rotina_nome' class='form-control' aria-describedby='sizing-addon2' value='$rotina_nome'></div>";
echo "<br>";
echo "<textarea class='form-control' rows='10' id='rotina_descricao' placeholder='Insira a descrição da rotina...'>$rotina_descricao</textarea>";
echo "<br>";								
echo "<button type='button' class='btn btn-primary' id='btn_EditarRotina' onclick='salvaedicao_rotina(".$rotina_id.")'>";
echo "<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Salvar usuário";
echo "</button>";
echo "<br><br>";
echo "</div></div></div>";
?>