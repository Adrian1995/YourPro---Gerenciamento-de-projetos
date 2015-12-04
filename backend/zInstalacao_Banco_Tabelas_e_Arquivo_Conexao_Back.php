<?php
	
	$host = $_POST['host'];
	$user= $_POST['usuario'];
	$pass = $_POST['senha'];
	$banco = $_POST['nomedobanco'];

	$conectaBanco = mysqli_connect ($host, $user, $pass) or die (mysql_error());
	$selecionaBanco = mysqli_select_db ($conectaBanco, $banco) or die (mysql_error());
	
																
	$criaTabelaLogin = mysqli_query ($conectaBanco, "CREATE TABLE login (usuario_id BIGINT,
																		usuario_nome VARCHAR(100) not null,
																		usuario_email VARCHAR(100) not null,
																		usuario_senha VARCHAR(100) not null,
																		usuario_tipo VARCHAR(100) not null,
																		usuario_nomecompleto VARCHAR(100) not null,
																		usuario_telefone VARCHAR(100) not null,
																		usuario_cargo VARCHAR(100) not null,
																		usuario_foto VARCHAR(100) not null,
																		usuario_visu_projetos CHAR(2) not null,
																		usuario_cada_projetos CHAR(2) not null,
																		usuario_edit_projetos CHAR(2) not null,
																		usuario_excl_projetos CHAR(2) not null,
																		usuario_visu_usuarios CHAR(2) not null,
																		usuario_cada_usuarios CHAR(2) not null,
																		usuario_edit_usuarios CHAR(2) not null,
																		usuario_excl_usuarios CHAR(2) not null,
																		usuario_visu_solicitacao CHAR(2) not null,
																		usuario_cada_solicitacao CHAR(2) not null,
																		usuario_edit_solicitacao CHAR(2) not null,
																		usuario_excl_solicitacao CHAR(2) not null,
																		usuario_visu_rotina CHAR(2) not null,
																		usuario_cada_rotina CHAR(2) not null,
																		usuario_edit_rotina CHAR(2) not null,
																		usuario_excl_rotina CHAR(2) not null,
																		usuario_visu_configuracao CHAR(2) not null,
																		usuario_edit_configuracao CHAR(2) not null,
																		
																		PRIMARY KEY(Usuario_ID));") or die (mysql_error());
	
	$senha = md5("admin");
	$insereUsuarioAdmin = mysqli_query ($conectaBanco, "INSERT INTO login (	usuario_id, 
																			usuario_nome, 
																			usuario_email,
																			usuario_senha,
																			usuario_tipo,
																			usuario_nomecompleto,
																			usuario_telefone,
																			usuario_cargo,
																			usuario_foto,
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
																			
																			VALUES	(	'01', 
																				'Administrador', 
																				'admin@admin.com',
																				'$senha',
																				'Normal',
																				'Administrador do sistema',
																				'(11)99999-9999',
																				'Gerente de projetos',
																				'admin.png',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S',
																				'S')") or die (mysql_error());
																
															
	$criaTabelaProjetos = mysqli_query ($conectaBanco, "CREATE TABLE projetos (projeto_id BIGINT,
																			projeto_nome VARCHAR(500),
																			projeto_descricao VARCHAR(2000),
																			projeto_tipo VARCHAR(200),
																			projeto_status VARCHAR(200),
																			projeto_inicio DATETIME,
																			projeto_final DATETIME,
																			projeto_solicitacao_id BIGINT,
																			
																			PRIMARY KEY(projeto_id));") or die (mysql_error());

	$criaTabelaProjetosTarefas = mysqli_query ($conectaBanco, "CREATE TABLE mod_tarefas(tarefa_id BIGINT,
																						tarefa_projeto_id BIGINT,
																						tarefa_numero BIGINT,
																						tarefa_usuario_id BIGINT,
																						tarefa_nome VARCHAR(500),
																						tarefa_descricao VARCHAR(4000),
																						tarefa_inicio DATETIME,
																						tarefa_final DATETIME,
																					
																						PRIMARY KEY(tarefa_id));") or die (mysql_error());	

																		
	$criaQuestionarioTabelaPai = mysqli_query ($conectaBanco, "CREATE TABLE solicitacoes(solicitacao_id BIGINT,
																						 solicitacao_nome VARCHAR(500),
																						 solicitacao_usuario VARCHAR(100),
																						 solicitacao_data DATETIME,
																						 solicitacao_status VARCHAR(200),
																						 solicitacao_observacao VARCHAR(2000),
																										
																						 PRIMARY KEY(solicitacao_id));") or die (mysql_error());	
																			
	$criaQuestionarioTabelaFilho = mysqli_query ($conectaBanco, "CREATE TABLE solicitacoesrespostas(solicitacaoresposta_id BIGINT,
																									solicitacao_id BIGINT,
																									solicitacao_numero BIGINT,
																									solicitacao_pergunta VARCHAR(500),
																									solicitacao_resposta VARCHAR(2000),
																										
																									PRIMARY KEY(solicitacaoresposta_id));") or die (mysql_error());	
					

	$criaRotinas = mysqli_query ($conectaBanco, "CREATE TABLE rotinas(rotina_id BIGINT,
																	 rotina_nome VARCHAR(500),
																	 rotina_descricao VARCHAR(2000),
																	 rotina_datacriacao DATETIME,
																										
																	 PRIMARY KEY(rotina_id));") or die (mysql_error());	
													 
													 
	$criaConfiguracoesGerais = mysqli_query($conectaBanco, "CREATE TABLE configuracoes (itens_eventos BIGINT not null,
																						itens_projetos BIGINT not null,
																						itens_usuarios BIGINT not null,
																						itens_solicitacoesadm BIGINT not null,
																						itens_rotinas BIGINT not null,
																						itens_solicitacoes BIGINT not null,
																						exige_solicitacaonoprojeto CHAR(2) );") or die (mysql_error());
																		
												$insereConfigPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes (itens_eventos, itens_projetos, itens_usuarios, itens_solicitacoesadm, itens_rotinas, itens_solicitacoes, exige_solicitacaonoprojeto) VALUES('10', '10', '10', '10', '10', '10', 'S')") or die (mysql_error());	

	$criaConfiguracoesTipo = mysqli_query ($conectaBanco, "CREATE TABLE configuracoes_tipos (tipo_id BIGINT,
																			 tipo_nome VARCHAR(200),
																															
																		PRIMARY KEY(tipo_id));") or die (mysql_error());	
												$insereTiposPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_tipos (tipo_id, tipo_nome) VALUES	('01', 'Selecione...')      ") or die (mysql_error());			
												$insereTiposPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_tipos (tipo_id, tipo_nome) VALUES	('02', 'Novo')      ") or die (mysql_error());
												$insereTiposPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_tipos (tipo_id, tipo_nome) VALUES	('03', 'Alteração') ") or die (mysql_error());
												$insereTiposPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_tipos (tipo_id, tipo_nome) VALUES	('04', 'Correção')	") or die (mysql_error());															
					
					
	$criaConfiguracoesStatus = mysqli_query ($conectaBanco, "CREATE TABLE configuracoes_status_projetos(	status_id BIGINT,
																				status_nome VARCHAR(200),
																															
																		PRIMARY KEY(status_id));") or die (mysql_error());	
												$insereStatusPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_projetos (status_id, status_nome) VALUES ('01', 'Selecione...')	") or die (mysql_error());				
												$insereStatusPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_projetos (status_id, status_nome) VALUES ('02', 'Cadastrado')	") or die (mysql_error());	
												$insereStatusPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_projetos (status_id, status_nome) VALUES ('03', 'Em andamento')	") or die (mysql_error());	
												$insereStatusPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_projetos (status_id, status_nome) VALUES ('04', 'Finalizado')	") or die (mysql_error());															
																
																			
	$criaConfiguracoesPerguntas = mysqli_query ($conectaBanco, "CREATE TABLE configuracoes_perguntas(pergunta_id BIGINT,
																					 pergunta_texto VARCHAR(500),
																															
																				PRIMARY KEY(pergunta_id));") or die (mysql_error());	
												$inserePerguntasPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_perguntas (pergunta_id, pergunta_texto) VALUES ('01', 'Qual é a sua solicitação?')	") or die (mysql_error());				
												$inserePerguntasPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_perguntas (pergunta_id, pergunta_texto) VALUES ('02', 'Quais são as metas e objetivos da solicitação?')	") or die (mysql_error());	
												$inserePerguntasPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_perguntas (pergunta_id, pergunta_texto) VALUES ('03', 'A solicitação deverá impactar em quais outras rotinas ou sistemas?')	") or die (mysql_error());			
	
						
	$criaConfiguracoesStatusSolicitacoes = mysqli_query ($conectaBanco, "CREATE TABLE configuracoes_status_solicitacoes(status_id BIGINT,
																										status_nome VARCHAR(200),
																															
																								PRIMARY KEY(status_id));") or die (mysql_error());	
												$insereStatusSPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_solicitacoes (status_id, status_nome) VALUES ('01', 'A analisar')	") or die (mysql_error());				
												$insereStatusSPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_solicitacoes (status_id, status_nome) VALUES ('02', 'Em análise')	") or die (mysql_error());	
												$insereStatusSPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_solicitacoes (status_id, status_nome) VALUES ('03', 'Recusada')	") or die (mysql_error());	
												$insereStatusSPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_solicitacoes (status_id, status_nome) VALUES ('04', 'Aceita')	") or die (mysql_error());															
												$insereStatusSPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_solicitacoes (status_id, status_nome) VALUES ('05', 'Trabalho em andamento')	") or die (mysql_error());	
												$insereStatusSPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_solicitacoes (status_id, status_nome) VALUES ('06', 'A apresentar')	") or die (mysql_error());	
												$insereStatusSPadroes = mysqli_query ($conectaBanco, "INSERT INTO configuracoes_status_solicitacoes (status_id, status_nome) VALUES ('07', 'Finalizada')	") or die (mysql_error());	
																		
																		
	$criaHistorico = mysqli_query ($conectaBanco, "CREATE TABLE historico(historico_id BIGINT,
																		historico_usuario_id BIGINT,
																		historico_tipo VARCHAR(200),
																		historico_data DATETIME,
																		historico_projeto BIGINT,
																		historico_tarefa BIGINT,
																		historico_usuario BIGINT,
																		historico_solicitacao BIGINT,
																		historico_rotina BIGINT,
																		historico_texto VARCHAR(2000),
																																			
																		PRIMARY KEY(historico_id));") or die (mysql_error());																		
																		
	$criaModuloProjetodeInovacao = mysqli_query ($conectaBanco, "CREATE TABLE mod_inovacao (inovacao_id BIGINT,
																							inovacao_projeto_id BIGINT,
																							inovacao_numero BIGINT,
																							inovacao_rotina_id BIGINT,
																							inovacao_rotina_nome  VARCHAR(500),
																							inovacao_rotina_descricao VARCHAR(2000),
																								
																							PRIMARY KEY(inovacao_id));") or die (mysql_error());

	$criaModuloProjetodeAlteracao = mysqli_query ($conectaBanco, "CREATE TABLE mod_alteracao (	alteracao_id BIGINT,
																								alteracao_projeto_id BIGINT,
																								alteracao_numero BIGINT,
																								alteracao_rotina_id BIGINT,
																								alteracao_nome VARCHAR(500),
																								alteracao_objetivo VARCHAR(2000),
																								alteracao_antes VARCHAR(2000),
																								alteracao_depois VARCHAR(2000),
																									
																								PRIMARY KEY(alteracao_id));") or die (mysql_error());

	$criaModuloProjetodeCorrecao = mysqli_query ($conectaBanco, "CREATE TABLE mod_correcao (correcao_id BIGINT,
																							correcao_projeto_id BIGINT,
																							correcao_numero BIGINT,
																							correcao_rotina_id BIGINT,
																							correcao_nome  VARCHAR(500),
																							correcao_descricao VARCHAR(2000),
																								
																							PRIMARY KEY(correcao_id));") or die (mysql_error());	
					
	$criaModuloProjetodeForum = mysqli_query ($conectaBanco, "CREATE TABLE mod_forum (forum_id BIGINT,
																					forum_projeto_id BIGINT,
																					forum_usuario_id BIGINT,
																					forum_mensagem VARCHAR(2000),
																								
																					PRIMARY KEY(forum_id));") or die (mysql_error());	
					
	$criaModuloRelatoErros = mysqli_query ($conectaBanco, "CREATE TABLE mod_erros (	erro_id BIGINT,
																					erro_projeto_id BIGINT,
																					erro_usuario_id BIGINT,
																					erro_status VARCHAR(500),
																					erro_nome VARCHAR(500),
																					erro_descricao VARCHAR(2000),
																					erro_imagem1 VARCHAR(500),
																					erro_imagem2 VARCHAR(500),
																					erro_imagem3 VARCHAR(500),
																					erro_imagem4 VARCHAR(500),
																					erro_imagem5 VARCHAR(500),
																										
																					PRIMARY KEY(erro_id));") or die (mysql_error());	
	
	//Codigo de outras tabelas aqui
															
															

	$arquivo = fopen('yconectaDB.inc', 'w+');
		if ($arquivo==false) 
			{die ("Erro ao criar o arquivo!");}
			
	$arquivo = fopen('yconectaDB.inc', 'a+');
	
	if ($arquivo)
		{
		$host = "'".$host."'";
		$user = "'".$user."'";
		$pass = "'".$pass."'";
		$banco = "'".$banco."'";
		
		
		$conteudoArquivo = '<?php
							$conectaBanco = mysqli_connect ('.$host.', '.$user.', '.$pass.') or die (mysql_error());
							$selecionaBanco = mysqli_select_db ($conectaBanco, '.$banco.') or die (mysql_error());
							
							date_default_timezone_set("Brazil/East");
							?>';
		
		rewind($arquivo);
		
		if(!fwrite($arquivo, $conteudoArquivo)) die ('Erro ao criar arquivo de conexão com o banco de dados');
		fclose($arquivo);		
		}
	
	header("Location: ../index.php?a=first");
	?>