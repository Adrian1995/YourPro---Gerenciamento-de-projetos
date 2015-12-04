<html>
<head>
	<?php	include ("includes/yhead.inc");	?>
</head>
<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<div class="letraLogo"><h2>yourPro</h2><h3>Gerenciador de projetos</h3></div>
			<br>
			<ul class="nav nav-pills nav-stacked">
			  <li role="presentation">									<a href="index.php">Voltar para Login</a></li>
			  <li role="presentation" id="manual_geral" class="active">	<a href="#" onclick="abre_geral()">Geral</a></li>
			  <li role="presentation" id="manual_eventos">				<a href="#" onclick="abre_eventos()">Eventos</a></li>
			  <li role="presentation" id="manual_projetos">				<a href="#" onclick="abre_projetos()">Projetos</a></li>
			  <li role="presentation" id="manual_usuarios">				<a href="#" onclick="abre_usuarios()">Usuários</a></li>
			  <li role="presentation" id="manual_solicitacoes">			<a href="#" onclick="abre_solicitacoes()">Solicitações</a></li>
			  <li role="presentation" id="manual_rotinas">				<a href="#" onclick="abre_rotinas()">Rotinas</a></li>
			  <li role="presentation" id="manual_configuracoes">		<a href="#" onclick="abre_configuracoes()">Configurações</a></li>
			</ul>
		</div>
		<div class="col-md-9" id="container_manual">
			<div id="recebe_manual">
			</div>
		</div>
	</div>
</div>



	
<script>
$(document).ready(function() 
	{
	$("#manual_geral").addClass("active");
	
	abre_geral();
	});
	
	
	function abre_geral()
		{
		limpa_linkativo();
		$("#manual_geral").addClass("active");
		
		$("#recebe_manual").remove();
		$("#container_manual").append("<div id='recebe_manual'>"+
										"<br>"+
										"<br>"+
										"No YourPro, você gerencia seus projetos de forma agil e eficiente, confira agora um resumo de cada uma das funções "+
										"que o sistema oferece e para mais detalhes acesse o menu à sua esquerda. ;)"+
										"<br>"+
										"<hr>"+
										"<h4>Eventos</h4>"+
										"Nessa sessão você encontrará todo o histórico do que está acontecendo no sistema."+
										"<hr>"+
										"<h4>Projetos</h4>"+
										"Nessa rotina podemos documentar todos os nossos projetos, aqui poderemos guardar as informações nos campos: Nome do Projeto, "+
										"Descrição, Início do projeto, Final do projeto, Tipo do projeto e Status do projeto, além disso é possível registrar as informações "+
										"através de modulos, que seguem abaixo:"+
																
										"<hr>"+
										
										"<h4>Usuários</h4>"+
										"A rotina de usuários efetua todo o controle de quem pode ou não acessar certas funções do sistema, o que torna a ferramenta mais segura, tudo isso é "+
										"feito através de um cadastro individual de permissões que existe no cadastro e na alteração da ferramenta.<br>"+
																
										"<hr>"+
										
										"<h4>Solicitações</h4>"+
										"Nesse software é possível que usuários internos ou usuários solicitantes realizem solicitações de novos projetos, sendo que quando um usuário solicitante "+
										"realiza login, ele é automaticamente redirecionado para uma página especifíca onde somente é possível visualizar suas proprias solicitações e efetuar novas, "+
										"além disso, o mesmo poderá editar e até mesmo remover uma solicitação que ele tenha feito caso o mesmo possua permissão.<br>"+
																			
										"<hr>"+
										
										"<h4>Rotinas</h4>"+
										"O cadastro de rotinas representa os objetos em que serão realizados os projetos, por exemplo, no caso de desenvolvimento de softwares, cada rotina seria uma "+
										"funcionalidade do sistema, existindo a possibilidade de cadastrar e editar o Nome da rotina e a Descrição da rotina.<br>"+
										
										"<hr>"+
										
										"<h4>Impressão</h4>"+
										"O icone de impressão estará sempre disponível, independente da página onde você esteja."+
										"<hr>"+
										
										"<h4>Meu perfil</h4>"+
										"Nessa rotina é possível alterar sua foto de perfil, nome, telefone e cargo em que você está."+
										"<hr>"+
										
										"<h4>Configurações</h4>"+
										"As configurações permitem personalizar totalmente a ferramenta, permitindo selecionar quanto itens por página devem "+
										"ser exibidos em cada resultado de consulta, permitindo informar quais as opções de seleção em alguns pontos de cadastro "+
										"e permitindo configurar se deve ser exibido um vinculo com solicitação para a inclusão de um novo projeto.<br>"+
										
										"</div>");
		}
		
	function abre_eventos()
		{
		limpa_linkativo();
		$("#manual_eventos").addClass("active");
		
		$("#recebe_manual").remove();
		$("#container_manual").append("<div id='recebe_manual'>"+
										"<br><h3>Eventos</h3>"+
										"Nessa sessão você encontrará todo o histórico do que está acontecendo no sistema, incluindo os eventos abaixo: "+
										"<br>"+
										"<br>"+
										"<u>Projetos</u><br>"+
										"<ul>"+
											"<li>Inicio e Final de projeto;</li>"+
											"<li>Inicio e Final de tarefas;</li>"+
											"<li>Cadastro, Alteração e Remoção de projetos;</li>"+
											"<li>Rotinas criadas através de cada registro do modulo inovações;</li>"+
											"<li>Ao excluir projeto apenas o registro de remoção permanece.</li>"+
										"</ul>"+
										"<u>Usuários</u><br>"+
										"<ul>"+
											"<li>Cadastro, Alteração e Remoção de usuários;</li>"+
											"<li>Ao excluir usuário apenas o registro de remoção permanece.</li>"+
										"</ul>"+	
										"<u>Solicitações</u>"+
										"<ul>"+
											"<li>Cadastro, Alteração e Remoção de solicitacoes;</li>"+
											"<li>Ao excluir solicitação apenas o registro de remoção permanece.</li>"+
										"</ul>"+
										"<u>Rotinas</u>"+
										"<ul>"+
											"<li>Cadastro, Alteração e Remoção de rotinas;</li>"+
											"<li>Ao excluir rotina apenas o registro de remoção permanece.</li>"+
										"</ul>"+
										"</div>");
		}
	
	function abre_projetos()
		{
		limpa_linkativo();
		$("#manual_projetos").addClass("active");
		
		$("#recebe_manual").remove();
		$("#container_manual").append("<div id='recebe_manual'>"+
										"<br><h3>Projetos</h3>"+
										"Nessa rotina podemos documentar todos os nossos projetos, aqui poderemos guardar as informações nos campos: Nome do Projeto, "+
										"Descrição, Início do projeto, Final do projeto, Tipo do projeto e Status do projeto, além disso é possível registrar as informações "+
										"através de modulos, que seguem abaixo:"+
										"<br>"+
										"<br><u>Modulo de Tarefas ::</u> Nesse modulo é possível descrever as tarefas de cada usuário, onde é possível informar o "+
										"Nome da tarefa, Descrição da tarefa, Início da tarefa e Final da tarefa, além disso, é possível vincular a tarefa a um "+
										"usuário cadastrado no sistema, compondo as pessoas que participam do projeto."+
										
										"<br><br><u>Modulo de Solicitação ::</u> Esse modulo permite vincular uma solicitação ao projeto, sendo possível visualizar "+
										"todas as informações das solicitações."+
										
										"<br><br><u>Modulo de Inovação ::</u> O modulo de inovação permite cadastrar várias novas rotinas que serão criadas no projeto "+
										"inserindo automaticamente as novas rotinas no banco de dados do sistema, sendo possível cadastrar o Nome da rotina e a Descrição da rotina."+
										
										"<br><br><u>Modulo de Alteração ::</u> Esse modulo permite registrar alterações efetuadas em rotinas do sistema, permitindo selecionara a "+
										"rotina a ser alterada e informar o Nome da alteração, Como a rotina era antes, Como a rotina vai ficar e Qual o objetivo da alteração, sendo "+
										"que o campo Como a rotina vai ficar, se torna a nova descrição da rotina selecionada para alteração."+
										
										"<br><br><u>Modulo de Correção ::</u> No modulo de correção você pode registrar quais os erros das rotinas serão corrigidos nos projetos, isso "+
										"é feito selecionando a rotina que possui o erro e descrevendo o Nome e a Descrição da correção."+
										
										"<br><br><u>Modulo de Forum do Projeto ::</u> O forum do projeto é um espaço onde os usuários coneseguem deixar mensagens "+
										"sendo essas mensagens acessivéis a todos que acessam o projeto."+
										
										
										"<br><br><u>Erros do projeto ::</u> Aqui são exibidos os erros que estão vinculados ao projeto, sendo exibido o ID do erro, "+
										"Descrição do erro e Imagens do erro, sendo possível efetuar a alteração do Status do erro e atribui-lo a outro usuário.<br>"+
										"Obs.: Na página de consulta de projetos existe uma funcionalidade onde os erros podem ser cadastrados, vinculados a um projeto "+
										"e atribuído a um usuário, onde é possível informar o Nome do erro, Descrição do erro e fazer o upload de no máximo 5 imagens relacionadas ao erro descrito"+
										
										"<br><br><u>Histórico do projeto ::</u> No histórico do projeto é possível visualizar quando e por quem ele foi cadastrado e "+
										"quando e por quem ele foi editado."+
										"</div>");
		}
		
	function abre_usuarios()
		{
		limpa_linkativo();
		$("#manual_usuarios").addClass("active");
		
		$("#recebe_manual").remove();
		$("#container_manual").append("<div id='recebe_manual'>"+
										"<br>"+
										"<h3>Usuários</h3>"+
										"A rotina de usuários efetua todo o controle de quem pode ou não acessar certas funções do sistema, o que torna a ferramenta mais segura, tudo isso é "+
										"feito através de um cadastro individual de permissões que existe no cadastro e na alteração da ferramenta.<br>"+
										"<br>"+
										"No cadastro e edição de usuário é possível informar o Nome do usuário, Login, Senha e Tipo de usuário, pois é possível selecionar o usuário do tipo Normal "+
										"que efetua acesso a ferramenta completa ou selecionar o usuário do tipo Solicitante, onde esse usuário será encaminhado para uma página especifíca "+
										"onde somente é possível efetuar solicitação, caso o mesmo possua permissão para tal ato.<br>"+
										"<br>"+
										"Obs.: O usuário padrão(Administrador) não pode ser excluído e nem ter suas permissões alteradas, pois se não haverem usuários o acesso é impossível."+
										"<br><br>"+
										"<u>É possível conceder as seguintes permissões aos usuários:</u><br>"+
										"<ul>"+
											"<li>Visualização de projetos;</li>"+
											"<li>Cadastro de projetos;</li>"+
											"<li>Edição de projetos;</li>"+
											"<li>Exclusão de projetos;</li>"+
											"<li>Visualização de usuários;</li>"+
											"<li>Cadastro de usuários;</li>"+
											"<li>Edição de usuários;</li>"+
											"<li>Exclusão de usuários;</li>"+
											"<li>Visualização de solicitações;</li>"+
											"<li>Cadastro de solicitações;</li>"+
											"<li>Edição de solicitações;</li>"+
											"<li>Exclusão de solicitações;</li>"+
											"<li>Visualização de rotinas;</li>"+
											"<li>Cadastro de rotinas;</li>"+
											"<li>Edição de rotinas;</li>"+
											"<li>Exclusão de rotinas;</li>"+
											"<li>Visualização de configurações;</li>"+
											"<li>Edição de configurações.</li>"+
										"</ul>"+
										
										"</div>");
		}
	
	function abre_solicitacoes()
		{
		limpa_linkativo();
		$("#manual_solicitacoes").addClass("active");
		
		$("#recebe_manual").remove();
		$("#container_manual").append("<div id='recebe_manual'>"+
										"<br><h3>Solicitações</h3>"+
										"Nesse software é possível que usuários internos ou usuários solicitantes realizem solicitações de novos projetos, sendo que quando um usuário solicitante "+
										"realiza login, ele é automaticamente redirecionado para uma página especifíca onde somente é possível visualizar suas proprias solicitações e efetuar novas, "+
										"além disso, o mesmo poderá editar e até mesmo remover uma solicitação que ele tenha feito caso o mesmo possua permissão.<br>"+
										"<br>"+
										"No caso de um usuário interno do sistema cadastrar a solicitação, é fornecida a ele a possibilidade de escolha de quem efetuou a solicitação.<br>"+
										"<br>"+
										"Ao realizar a sua solicitação o usuário conta com um recurso muito interessante, que é a possibilidade de inserir novos tópicos/perguntas, o que da liberdade "+
										"para o usuário inserir diversos tipos de informações."+
										"</div>");
		}
		
	function abre_rotinas()
		{
		limpa_linkativo();
		$("#manual_rotinas").addClass("active");
		
		$("#recebe_manual").remove();
		$("#container_manual").append("<div id='recebe_manual'>"+
										"<br><h3>Rotinas</h3>"+
										"O cadastro de rotinas representa os objetos em que serão realizados os projetos, por exemplo, no caso de desenvolvimento de softwares, cada rotina seria uma "+
										"funcionalidade do sistema, existindo a possibilidade de cadastrar e editar o Nome da rotina e a Descrição da rotina.<br>"+
										"<br>"+
										"Na visualização da rotina são exibidas todas as alterações e correções que a rotina sofreu, sendo essas cadastradas nos projetos:<br>"+
										"<br>"+
										"Nas alterações são exibidas o Nome da alteração, Como era antes da alteração, Como ficou depois da alteração e qual foi o Motivo da alteração.<br>"+
										"Nas correções são exibidas o Nome da correção e a Descrição da correção."+
										"</div>");
		}
		
	function abre_configuracoes()
		{
		limpa_linkativo();
		$("#manual_configuracoes").addClass("active");
		
		$("#recebe_manual").remove();
		$("#container_manual").append("<div id='recebe_manual'>"+
										"<br><h3>Configurações</h3>"+
										"As configurações permitem personalizar totalmente a ferramenta, permitindo selecionar quanto itens por página devem "+
										"ser exibidos em cada resultado de consulta, permitindo informar quais as opções de seleção em alguns pontos de cadastro "+
										"e permitindo configurar se deve ser exibido um vinculo com solicitação para a inclusão de um novo projeto.<br>"+
										"<br>"+
										"<u>É possível configurar os itens por páginas das seguintes rotinas:</u><br>"+
										"<ul>"+
											"<li>Eventos</li>"+
											"<li>Projetos</li>"+
											"<li>Usuários</li>"+
											"<li>Adm. de Solicitações</li>"+
											"<li>Solicitações dos usuários</li>"+
											"<li>Rotinas</li>"+
										"</ul>"+
										"<br>"+
										"<u>Os seguintes campos selecionavéis podem ter suas opções editadas dinamicamente:</u><br>"+
										"<ul>"+
											"<li>Status de projetos</li>"+
											"<li>Tipos de projetos</li>"+
											"<li>Perguntas de Solicitação aos usuários</li>"+
											"<li>Status das solicitações</li>"+
										"</ul>"+
										"</div>");
		}
	
	function limpa_linkativo()
		{
		$("#manual_geral").removeClass("active");
		$("#manual_eventos").removeClass("active");
		$("#manual_projetos").removeClass("active");
		$("#manual_usuarios").removeClass("active");
		$("#manual_solicitacoes").removeClass("active");
		$("#manual_rotinas").removeClass("active");
		$("#manual_meuperfil").removeClass("active");
		$("#manual_configuracoes").removeClass("active");
		}
</script>	
</body>
</html>
<!--
# Registro do software / Software registration

Software Registrado junto ao INPI.
Todos os direitos reservados. 
Não é permitido o uso comercial do software no todo ou em parte.
Para uso comercial entre em contato com adrianmedeiros@outlook.com ou +55 11 997996355.
---------------------------------------------------------------------------------------
Software Joined at the INPI(Brazilian organization software registration).
All rights reserved.
No commercial use of the software in whole or in part is allowed.
For commercial use please contact adrianmedeiros@outlook.com or +55 11 997 996 355.
-->