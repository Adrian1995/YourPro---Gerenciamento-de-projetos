<?php
	if(!empty($_GET['ID']) or !empty($_GET['Sessao']))
		{
		$ID = $_GET['ID']; 
		$Sessao = $_GET['Sessao'];
		
		$IDCookie = $_COOKIE['IDCookie'];
		$SessaoCookie = $_COOKIE['SessaoCookie'];
		
		if($ID != $IDCookie   or   $Sessao != $SessaoCookie)
			{
			header("Location: index.php");
			}
		}
	else
		{
		header("Location: index.php");
		}
?>