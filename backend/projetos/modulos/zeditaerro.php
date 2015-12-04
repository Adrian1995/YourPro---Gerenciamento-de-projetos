<?php 
include('../../yconectaDB.inc');

$erro_id = $_POST["erro_id"];
$erro_status = $_POST["erro_status"];
$erro_usuario_id = $_POST["erro_usuario_id"];
					
$editacorrecao = mysqli_query ($conectaBanco ,"UPDATE mod_erros SET erro_status='$erro_status',
																	erro_usuario_id='$erro_usuario_id'
															
															WHERE erro_id='$erro_id'") or die (mysql_error());

?>