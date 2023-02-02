<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2012, Oliver Georgi
 * @license http://opensource.org/licenses/GPL-2.0 GNU GPL-2
 * @link http://www.phpwcms.de
 *
 **/


// Language: Portuguese, Language Code: pt
// please use HTML safe strings ONLY,neccessary to reduce processing time
// normal line break:    '&#13', JavaScript Linebreak: '\n'
// Revised by Isac Araújo  isacaraujo@sapo.pt
// Last updated 16.jun 2004


$BL['usr_online']                       = 'usuários online';

// Login Page
$BL["login_text"]                       = 'Introduza os seus dados de início da sessão';
$BL['login_error']                      = 'Usuário ou senha invalido';
$BL["login_username"]                   = 'usuário';
$BL["login_userpass"]                   = 'senha';
$BL["login_button"]                     = 'Iniciar sessão';
$BL["login_lang"]                       = 'linguagem do backend';

// phpwcms.php
$BL['be_nav_logout']                    = '<i class="fas fa-times-circle"></i> Sair';
$BL['be_nav_articles']                  = '<i class="fas fa-pen-square"></i> Páginas';
$BL['be_nav_files']                     = '<i class="fas fa-file-image"></i> Imagens e Arquivos';
$BL['be_nav_modules']                   = '<i class="fas fa-puzzle-piece"></i> Módulos';
$BL['be_nav_dados']                   = '<i class="fas fa-info-circle"></i> Dados da Empresa';
$BL['be_nav_messages']                  = '<i class="fas fa-envelope"></i> Newsletter';
$BL['be_nav_chat']                      = 'CHAT';
$BL['be_nav_profile']                   = '<i class="fas fa-user"></i> Perfil';
$BL['be_nav_admin']                     = '<i class="fas fa-users-cog"></i> Administrador';
$BL['be_nav_discuss']                   = 'DISCUTA';

$BL['be_page_title']                    = 'Administrador do Site';

$BL['be_subnav_article_center']         = 'PÁGINAS DO SITE';
$BL['be_subnav_article_new']            = 'nova página';
$BL['be_subnav_file_center']            = 'arquivos do site';
$BL['be_subnav_file_ftptakeover']       = 'envio por ftp';
$BL['be_subnav_mod_artists']            = 'artista, categoria, género';
$BL['be_subnav_msg_center']             = 'centro de mensagems';
$BL['be_subnav_msg_new']                = 'nova mensagem';
$BL['be_subnav_msg_newsletter']         = 'E-mail Marketing';
$BL['be_subnav_chat_main']              = 'página principal do chat';
$BL['be_subnav_chat_internal']          = 'chat interno';
$BL['be_subnav_profile_login']          = 'informação do início da sessão';
$BL['be_subnav_profile_personal']       = 'dados pessoais';
$BL['be_subnav_admin_pagelayout']       = 'disposição de página';
$BL['be_subnav_admin_templates']        = 'templates (moldes)';
$BL['be_subnav_admin_css']              = 'css por defeito';
$BL['be_subnav_admin_sitestructure']    = 'estrutura do site';
$BL['be_subnav_admin_users']            = 'administração de usuários';
$BL['be_subnav_admin_filecat']          = 'categorias de arquivos';
$BL['be_contentpart']					= 'Partes de Conteúdo';

$BL['tit_paginas']						= 'P&Aacute;GINAS DO SITE';
$BL['tit_dados']						= 'DADOS DA EMPRESA';
$BL['tit_arquivos']						= 'ARQUIVOS';
$BL['tit_modulos']						= 'M&Oacute;DULOS';
$BL['tit_emails']						= 'LISTA DE E-MAILS';
$BL['tit_perfil']						= 'PERFIL';
$BL['tit_admin']						= 'ADMINISTRA&Ccedil;&Atilde;O';

// admin.functions.inc.php
$BL['be_func_struct_articleID']         = 'ID da página';
$BL['be_func_struct_preview']           = 'Visualizar';
$BL['be_func_struct_edit']              = 'editar página';
$BL['be_func_struct_sedit']             = 'editar estrutura';
$BL['be_func_struct_cut']               = 'cortar página';
$BL['be_func_struct_nocut']             = 'desligar cortar página';
$BL['be_func_struct_svisible']          = 'mudar visível/invisível';;
$BL['be_func_struct_spublic']           = 'mudar público/privado';
$BL['be_func_struct_sort_up']           = 'mover para cima';
$BL['be_func_struct_sort_down']         = 'mover para baixo';
$BL['be_func_struct_del_article']       = 'apagar página';
$BL['be_func_struct_del_jsmsg']         = 'Tem certeza que \npretende apagar a página?'; // "\n" = JavaScript Linebreak
$BL['be_func_struct_new_article']       = 'criar nova página dentro da estrutura';
$BL['be_func_struct_paste_article']     = 'colocar página dentro da estrutura';
$BL['be_func_struct_insert_level']      = 'criar estrutura dentro de';
$BL['be_func_struct_paste_level']       = 'colar estrutura em';
$BL['be_func_struct_cut_level']         = 'cortar estrutura';
$BL['be_func_struct_no_cut']            = "Não é possível cortar o nível da raiz!";
$BL['be_func_struct_no_paste1']         = "Não é possível colocar aqui!";
$BL['be_func_struct_no_paste2']         = 'é parente do nível da raiz';
$BL['be_func_struct_no_paste3']         = 'isso deve colar-se aqui dentro';
$BL['be_func_struct_paste_cancel']      = 'cancelar mudança do nível da estrutura';
$BL['be_func_struct_del_struct']        = 'apagar este nível da estrutura';
$BL['be_func_struct_del_sjsmsg']        = 'Tem certeza que \npretende apagar o nível estrutural?'; // "\n" = JavaScript Linebreak
$BL['be_func_struct_open']              = 'abrir';
$BL['be_func_struct_close']             = 'fechar';
$BL['be_func_struct_empty']             = 'vazio ';

// article.contenttype.inc.php
$BL['be_ctype_plaintext']               = 'texto normal';
$BL['be_ctype_html']                    = 'html';
$BL['be_ctype_code']                    = 'código';
$BL['be_ctype_textimage']               = 'Texto e Imagem';
$BL['be_ctype_images']                  = 'imagens';
$BL['be_ctype_bulletlist']              = 'Texto em Blocos';
$BL['be_ctype_ullist']                  = 'lista';
$BL['be_ctype_link']                    = 'link &amp; email';
$BL['be_ctype_linklist']                = 'Videos (Youtube)';
$BL['be_ctype_linkarticle']             = 'Lista de Páginas';
$BL['be_ctype_multimedia']              = 'multimídia';
$BL['be_ctype_filelist']                = 'Downloads';
$BL['be_ctype_emailform']               = 'formulário de email';
$BL['be_ctype_newsletter']              = 'Newsletter';
$BL['be_ctype_telefone']                = 'Lista Telefone';

// profile.create.inc.php
$BL['be_profile_create_success']        = 'Perfil criado com sucesso.';
$BL['be_profile_create_error']          = 'Ocorreu um erro ao criar o perfil.';

// profile.update.inc.php
$BL['be_profile_update_success']        = 'Dados do perfil atualizados com sucesso.';
$BL['be_profile_update_error']          = 'Ocorreu um erro durante a atualização do perfil.';

// profile.updateaccount.inc.php
$BL['be_profile_account_err1']          = 'o usuário {VAL} é inválido';
$BL['be_profile_account_err2']          = 'senha muito curta (apenas {VAL} caracteres: pelo menos 5 são necessários)';
$BL['be_profile_account_err3']          = 'a repetição da senha têm de ser igual à primeira';
$BL['be_profile_account_err4']          = 'o email {VAL} é inválido';

// profile.data.tmpl.php
$BL['be_profile_data_title']            = 'os seus dados pessoais';
$BL['be_profile_data_text']             = 'os dados pessoais são opcionais. Isto pode ajudar outros usuários ou visitantes do local a conhecer melhor quais os seus interesses e habilidades. Se você selecionar os usuários apropriados no checkbox estes podem ver as suas informações de perfil na área pública ou em páginas (ou não).';
$BL['be_profile_label_title']           = 'título';
$BL['be_profile_label_firstname']       = 'nome';
$BL['be_profile_label_name']            = 'pronome';
$BL['be_profile_label_company']         = 'empresa';
$BL['be_profile_label_street']          = 'rua';
$BL['be_profile_label_city']            = 'cidade';
$BL['be_profile_label_state']           = 'província, região';
$BL['be_profile_label_zip']             = 'código postal';
$BL['be_profile_label_country']         = 'país';
$BL['be_profile_label_phone']           = 'telefone';
$BL['be_profile_label_fax']             = 'fax';
$BL['be_profile_label_cellphone']       = 'telemóvel';
$BL['be_profile_label_signature']       = 'assinatura';
$BL['be_profile_label_notes']           = 'notas';
$BL['be_profile_label_profession']      = 'profissão';
$BL['be_profile_label_newsletter']      = 'Newsletter';
$BL['be_profile_text_newsletter']       = 'Eu quero receber o Newsletter geral de phpwcms.';
$BL['be_profile_label_public']          = 'público';
$BL['be_profile_text_public']           = 'Qualquer um deve poder ver meu perfil pessoal.';
$BL['be_profile_label_button']          = 'atualizar dados pessoais';

// profile.account.tmpl.php
$BL['be_profile_account_title']         = 'sua informação do início da sessão';
$BL['be_profile_account_text']          = 'Normalmente não é necessário mudar o nome de usuário.<br />Mas a senha deve ser mudada de tempo a tempo.';
$BL['be_profile_label_err']             = 'por favor verifique';
$BL['be_profile_label_username']        = 'usuário';
$BL['be_profile_label_newpass']         = 'nova senha';
$BL['be_profile_label_repeatpass']      = 'repita a nova senha';
$BL['be_profile_label_email']           = 'email';
$BL['be_profile_account_button']        = 'atualizar os dados';
$BL['be_profile_label_lang']            = 'língua';


// files.ftptakeover.tmpl.php
$BL['be_ftptakeover_title']             = 'enviar arquivos por ftp';
$BL['be_ftptakeover_mark']              = 'selecionar';
$BL['be_ftptakeover_available']         = 'arquivos disponíveis';
$BL['be_ftptakeover_size']              = 'tamanho';
$BL['be_ftptakeover_nofile']            = 'não existe nenhum arquivo disponível &#8211; deve primeiro enviar os arquivos para a sua pasta ftp';
$BL['be_ftptakeover_all']               = 'Selecionar Tudo';
$BL['be_ftptakeover_directory']         = 'Selecionar Pasta';
$BL['be_ftptakeover_rootdir']           = 'pasta raiz';
$BL['be_ftptakeover_needed']            = 'necessário!!! (tem que escolher pelo menos 1)';
$BL['be_ftptakeover_optional']          = 'opcional';
$BL['be_ftptakeover_keywords']          = 'palavras-chave';
$BL['be_ftptakeover_additional']        = 'complementar';
$BL['be_ftptakeover_longinfo']          = 'descrição longa';
$BL['be_ftptakeover_status']            = 'status';
$BL['be_ftptakeover_active']            = 'ativo';
$BL['be_ftptakeover_public']            = 'público';
$BL['be_ftptakeover_createthumb']       = 'criar miniatura';
$BL['be_ftptakeover_button']            = 'copiar arquivo(s) selecionado(s)';

// files.reiter.tmpl.php
$BL['be_ftab_title']                    = 'Arquivos e Imagens do Site';
$BL['be_ftab_createnew']                = 'criar novo directório na raiz';
$BL['be_ftab_paste']                    = 'colar arquivo do clipboard para a pasta raiz';
$BL['be_ftab_disablethumb']             = 'desligar inspecção prévia de miniaturas';
$BL['be_ftab_enablethumb']              = 'ligar inspecção prévia de miniaturas';
$BL['be_ftab_private']                  = 'Lista de Arquivos';
$BL['be_ftab_public']                   = 'arquivos públicos';
$BL['be_ftab_search']                   = 'pesquisa';
$BL['be_ftab_trash']                    = 'lixeira';
$BL['be_ftab_open']                     = 'abrir todos as pastas';
$BL['be_ftab_close']                    = 'fechar todos as pastas';
$BL['be_ftab_upload']                   = 'enviar arquivo para o directório raiz';
$BL['be_ftab_filehelp']                 = 'abrir página de ajuda';

// files.private.newdir.tmpl.php
$BL['be_fpriv_rootdir']                 = 'pasta raiz';
$BL['be_fpriv_title']                   = 'Criar nova pasta';
$BL['be_fpriv_inside']                  = 'dentro de';
$BL['be_fpriv_error']                   = 'erro: atribua um nome a pasta';
$BL['be_fpriv_name']                    = 'nome';
$BL['be_fpriv_status']                  = 'status';
$BL['be_fpriv_button']                  = 'criar nova pasta';

// files.private.editdir.tmpl.php
$BL['be_fpriv_edittitle']               = 'Editar pasta';
$BL['be_fpriv_newname']                 = 'Novo Nome';
$BL['be_fpriv_updatebutton']            = 'atualizar os dados da pasta';

// files.private.upload.tmpl.php
$BL['be_fprivup_err1']                  = 'Selecione o arquivo que quer submeter';
$BL['be_fprivup_err2']                  = 'O tamanho do arquivo é maior do que';
$BL['be_fprivup_err3']                  = 'Erro ao tentar enviar o arquivo para armazenamento';
$BL['be_fprivup_err4']                  = 'Erro ao criar pasta de usuário.';
$BL['be_fprivup_err5']                  = 'não existem miniaturas';
$BL['be_fprivup_err6']                  = 'Por favor não tente novamente - é um erro de servidor! Contacte o <a href="mailto:{VAL}">webmaster</a> o mais rápido possivel!';
$BL['be_fprivup_title']                 = 'Enviar Arquivos';
$BL['be_fprivup_button']                = 'Enviar Arquivos';
$BL['be_fprivup_upload']                = 'Selecionar';

// files.private.editfile.tmpl.php
$BL['be_fprivedit_title']               = 'Informações do Arquivo';
$BL['be_fprivedit_filename']            = 'Nome do Arquivo';
$BL['be_fprivedit_created']             = 'criado';
$BL['be_fprivedit_dateformat']          = 'd-m-Y H:i';
$BL['be_fprivedit_err1']                = 'reverter nome do arquivo (igual ao original)';
$BL['be_fprivedit_clockwise']           = 'gire a miniatura no sentido dos ponteiros do relógio [original +90&deg;]';
$BL['be_fprivedit_cclockwise']          = 'gire a miniatura no sentido contrário dos ponteiros do relógio [original -90&deg;]';
$BL['be_fprivedit_button']              = 'atualizar a informação do arquivo';
$BL['be_fprivedit_size']                = 'tamanho';

// files.private-functions.inc.php
$BL['be_fprivfunc_upload']              = 'copiar arquivo para a pasta';
$BL['be_fprivfunc_makenew']             = 'criar nova pasta dentro de';
$BL['be_fprivfunc_paste']               = 'colar arquivo do clipboard na pasta';
$BL['be_fprivfunc_edit']                = 'editar pasta';
$BL['be_fprivfunc_cactive']             = 'mudar visível/invisível';
$BL['be_fprivfunc_cpublic']             = 'mudar público/não público';
$BL['be_fprivfunc_deldir']              = 'apagar pasta';
$BL['be_fprivfunc_jsdeldir']            = 'Tem certeza que \npretende apagar esta pasta?';
$BL['be_fprivfunc_notempty']            = 'pasta {VAL} não está vazio !';
$BL['be_fprivfunc_opendir']             = 'abrir pasta';
$BL['be_fprivfunc_closedir']            = 'fechar pasta';
$BL['be_fprivfunc_dlfile']              = 'descarregar arquivo';
$BL['be_fprivfunc_clipfile']            = 'arquivo do clipboard';
$BL['be_fprivfunc_cutfile']             = 'cortar';
$BL['be_fprivfunc_editfile']            = 'editar informação do arquivo';
$BL['be_fprivfunc_cactivefile']         = 'mudar visível/invisível';
$BL['be_fprivfunc_cpublicfile']         = 'mudar público/não público';
$BL['be_fprivfunc_movetrash']           = 'para a lixeira';
$BL['be_fprivfunc_jsmovetrash1']        = 'Tem certeza que quer deletar';
$BL['be_fprivfunc_jsmovetrash2']        = 'para a lixeira?';

// files.private.additions.inc.php
$BL['be_fprivadd_nofolders']            = 'não existem arquivos ou pastas não públicos';

// files.public.list.tmpl.php
$BL['be_fpublic_user']                  = 'usuário';
$BL['be_fpublic_nofiles']               = 'não existem arquivos ou pastas publicos';

// files.private.trash.tmpl.php
$BL['be_ftrash_nofiles']                = 'a lixeira está vazia';
$BL['be_ftrash_show']                   = 'ver arquivos não públicos';
$BL['be_ftrash_delallfiles']                   = 'Limpar Lixeira';
$BL['be_ftrash_delall']                   = 'Tem certeza que quer EXCLUIR TODOS os arquivos?';

// files.private-delfilelist.inc.php
$BL['be_ftrash_restore']                = 'Tem certeza que quer restaurar o arquivo {VAL}?';
$BL['be_ftrash_delete']                 = 'Tem certeza que quer apagar {VAL}?';
$BL['be_ftrash_undo']                   = 'restabelecer (tirar da lixeira)';
$BL['be_ftrash_delfinal']               = 'apagamento final';

// files.search.tmpl.php
$BL['be_fsearch_err1']                  = 'o termo de pesquisa está vazio.';
$BL['be_fsearch_title']                 = 'PESQUISA DE ARQUIVOS';
$BL['be_fsearch_infotext']              = 'Pesquisa simples para encontrar informações sobre arquivos. A pesquisa será feita pelas palavras-chave, nome do arquivo e finalmente pela descrição longa. Wildcards são ignorados. Pode separar as palavras-chave com um espaço<br /. Selecione E/OU e que arquivos pretende: pessoais/púlicos.';
$BL['be_fsearch_nonfound']              = 'Não foi encontrado nenhum arquivo. Tente novamente e introduza outros termos ou palavras chave!';
$BL['be_fsearch_fillin']                = 'Não foi introduzido nenhum termo para a pesquisa.';
$BL['be_fsearch_searchlabel']           = 'pesquisar';
$BL['be_fsearch_startsearch']           = 'iniciar a pesquisa';
$BL['be_fsearch_and']                   = 'E';
$BL['be_fsearch_or']                    = 'OU';
$BL['be_fsearch_all']                   = 'todos os arquivos';
$BL['be_fsearch_personal']              = 'privados';
$BL['be_fsearch_public']                = 'públicos';

// chat.main.tmpl.php & chat.list.tmpl.php
$BL['be_chat_title']                    = 'chat interno';
$BL['be_chat_info']                     = 'Aqui você pode conversar com outros usuários (backend) sobre tudo o que você quizer. Este serviço realiza-se em tempo real, você pode deixar também uma mensagem que todos possam ler.';
$BL['be_chat_start']                    = 'clique aqui para iniciar a conversa';
$BL['be_chat_lines']                    = 'número de linhas no chat';

// message.center.tmpl.php
$BL['be_msg_title']                     = 'centro de mensagens';
$BL['be_msg_new']                       = 'nova';
$BL['be_msg_old']                       = 'antiga';
$BL['be_msg_senttop']                   = 'enviada';
$BL['be_msg_del']                       = 'apagada';
$BL['be_msg_from']                      = 'de';
$BL['be_msg_subject']                   = 'assunto';
$BL['be_msg_date']                      = 'data/hora';
$BL['be_msg_close']                     = 'fechar mensagem';
$BL['be_msg_create']                    = 'criar uma nova mensagem';
$BL['be_msg_reply']                     = 'responder a esta mensagem';
$BL['be_msg_move']                      = 'enviar esta mensagem para a lixeira';
$BL['be_msg_unread']                    = 'não lidas ou novas mensagens';
$BL['be_msg_lastread']                  = 'últimas {VAL} menssagens lidas';
$BL['be_msg_lastsent']                  = 'últimas {VAL} mensagens enviadas';
$BL['be_msg_marked']                    = 'mensagens marcadas para apagar (lixeira)';
$BL['be_msg_nomsg']                     = 'não foi encontrada nenhuma mensagem nesta pasta';

// message.send.tmpl.php
$BL['be_msg_RE']                        = 'RE';
$BL['be_msg_by']                        = 'enviada por';
$BL['be_msg_on']                        = 'em';
$BL['be_msg_msg']                       = 'menssagem';
$BL['be_msg_err1']                      = 'voçê esqueceu do destinário...';
$BL['be_msg_err2']                      = 'preencha o assunto (assim o destinário pode ordenar melhor a sua mensagem)';
$BL['be_msg_err3']                      = 'não faz qualquer sentido enviar uma mensagem vazia ;-)';
$BL['be_msg_sent']                      = 'a mensagem foi enviada!';
$BL['be_msg_fwd']                       = 'vai ser redirecionado para o centro de mensagens ou';
$BL['be_msg_newmsgtitle']               = 'escreva uma nova mensagem';
$BL['be_msg_err']                       = 'erro durante o envio da mensagem';
$BL['be_msg_sendto']                    = 'enviar mensagem para';
$BL['be_msg_available']                 = 'lista de todos os possíveis destinatários';
$BL['be_msg_all']                       = 'enviar a mensagem para os destinatários selecionados';

// message.subscription.tmpl.php
$BL['be_newsletter_title']              = 'subscrições do Newsletter';
$BL['be_newsletter_titleedit']          = 'editar uma assinatura';
$BL['be_newsletter_new']                = 'criar novo';
$BL['be_newsletter_add']                = 'criar novo Newsletter';
$BL['be_newsletter_name']               = 'nome';
$BL['be_newsletter_info']               = 'info';
$BL['be_newsletter_button_save']        = 'salvar subscrição';
$BL['be_newsletter_button_cancel']      = 'Cancelar';

// admin.newuser.tmpl.php
$BL['be_admin_usr_err1']                = 'nome de usuário inválido, por favor escolha outro';
$BL['be_admin_usr_err2']                = 'nome de usuário vazio (obrigatório)';
$BL['be_admin_usr_err3']                = 'senha vazia (obrigatório)';
$BL['be_admin_usr_err4']                = "o email não é válido";
$BL['be_admin_usr_err']                 = 'erro';
$BL['be_admin_usr_mailsubject']         = '{EMPRESA} - Cadastro de novo usuário';
$BL['be_admin_usr_mailbody']            = "BEM VINDO AO BACKEND DO PHPWCMS\n\n    usuário: {LOGIN}\n    senha: {PASSWORD}\n\n\nVoçê pode ligar-se em: {LOGIN_PAGE}\n\nphpwcms admin\n ";
$BL['be_admin_usr_title']               = 'criar novo usuário';
$BL['be_admin_usr_realname']            = 'nome real';
$BL['be_admin_usr_setactive']           = 'ativar';
$BL['be_admin_usr_iflogin']             = 'se ativar o usuário pode entrar';
$BL['be_admin_usr_isadmin']             = 'Usuário administrador';
$BL['be_admin_usr_ifadmin']             = 'se estiver marcado o usuário tem direitos de administração';
$BL['be_admin_usr_verify']              = 'verificação';
$BL['be_admin_usr_sendemail']           = 'enviar uma mensagem para o novo usuário com os dados da conta';
$BL['be_admin_usr_button']              = 'enviar dados do usuário';

// admin.edituser.tmpl.php
$BL['be_admin_usr_etitle']              = 'editar conta do usuário';
$BL['be_admin_usr_emailsubject']        = '{EMPRESA} - Dados de acesso alterados';
$BL['be_admin_usr_mailbody']            = "Seja Bem vindo a {EMPRESA}.\n\nSeguem abaixo seus dados de acesso:\nUsuário: {LOGIN}\n Senha: {PASSWORD}\n\nPara acessar, clique no link abaixo:\n {SITE}adm\n\nObrigado,\n{EMPRESA}.";
$BL['be_admin_usr_passnochange']        = '[Utilizar a mesma senha]';
$BL['be_admin_usr_ebutton']             = 'atualizar dados do usuário';

$BL['be_admin_usr_emailbody']           = "Seus dados de acesso foram alterados:\n\nUsuário: {LOGIN}\nSenha: {PASSWORD}\n\nPara acessar, clique no link abaixo:\n {SITE}adm\n\nObrigado,\n{EMPRESA}.";

// admin.listuser.tmpl.php
$BL['be_admin_usr_ltitle']              = 'phpwcms lista de usuários';
$BL['be_admin_usr_ldel']                = 'ATENÇÃO!&#13O isto vai apagar o usuário';
$BL['be_admin_usr_create']              = 'criar novo usuário';
$BL['be_admin_usr_editusr']             = 'editar usuário';

// admin.structform.tmpl.php
$BL['be_admin_struct_title']            = 'Estrutura do Site';
$BL['be_admin_struct_child']            = '(parente de)';
$BL['be_admin_struct_index']            = 'index (início do website)';
$BL['be_admin_struct_cat']              = 'titulo da categoria';
$BL['be_admin_struct_hide1']            = 'escondido';
$BL['be_admin_struct_hide2']            = 'ver na estrutura do menu';
$BL['be_admin_struct_info']             = 'informação sobre a categoria';
$BL['be_admin_struct_template']         = 'Aparência';
$BL['be_admin_struct_alias']            = 'atalho (alias) da categoria';
$BL['be_admin_struct_visible']          = 'Mostrar no Site';
$BL['be_admin_struct_button']           = 'enviar dados da categoria';
$BL['be_admin_struct_close']            = 'fechar';
$BL['be_admin_struct_img_tit']          = 'Configurações de Imagens';
$BL['be_admin_struct_img_width']        = 'Largura (px)';
$BL['be_admin_struct_img_height']       = 'Altura (px)';

// admin.filecat.tmpl.php
$BL['be_admin_fcat_title']              = 'categorias de arquivos';
$BL['be_admin_fcat_err']                = 'o nome da categoria está vazio!';
$BL['be_admin_fcat_name']               = 'nome da categoria';
$BL['be_admin_fcat_needed']             = 'necessário';
$BL['be_admin_fcat_button1']            = 'atualizar';
$BL['be_admin_fcat_button2']            = 'criar';
$BL['be_admin_fcat_delmsg']             = 'Tem a certeza que quer apagar \n a chave do arquivo?';
$BL['be_admin_fcat_fcat']               = 'arquivo da categoria';
$BL['be_admin_fcat_err1']               = 'a chave do arquivo está vazia!';
$BL['be_admin_fcat_fkeyname']           = 'chave do arquivo';
$BL['be_admin_fcat_exit']               = 'sair do modo editar';
$BL['be_admin_fcat_addkey']             = 'acrescentar nova chave';
$BL['be_admin_fcat_editcat']            = 'editar a categoria';
$BL['be_admin_fcat_delcatmsg']          = 'Tem a certeza que pretende\napagar esta categoria de arquivos?';
$BL['be_admin_fcat_delcat']             = 'apagar categoria de arquivos';
$BL['be_admin_fcat_delkey']             = 'apagar chave do arquivo';
$BL['be_admin_fcat_editkey']            = 'editar chave';
$BL['be_admin_fcat_addcat']             = 'criar nova categoria de arquivos';

// admin.pagelayout.tmpl.php
$BL['be_admin_page_title']              = 'instalação do frontend: layout da página';
$BL['be_admin_page_align']              = 'alinhamento da página';
$BL['be_admin_page_align_left']         = 'alinhamento da página a esquerda (normal)';
$BL['be_admin_page_align_center']       = 'alinhamento da página ao centro';
$BL['be_admin_page_align_right']        = 'alinhamento da página à direita';
$BL['be_admin_page_margin']             = 'margem';
$BL['be_admin_page_top']                = 'em cima';
$BL['be_admin_page_bottom']             = 'em baixo';
$BL['be_admin_page_left']               = 'esquerda';
$BL['be_admin_page_right']              = 'direita';
$BL['be_admin_page_bg']                 = 'fundo';
$BL['be_admin_page_color']              = 'cor';
$BL['be_admin_page_height']             = 'altura';
$BL['be_admin_page_width']              = 'largura';
$BL['be_admin_page_main']               = 'principal';
$BL['be_admin_page_leftspace']          = 'espaço à esquerda';
$BL['be_admin_page_rightspace']         = 'espaço à direita';
$BL['be_admin_page_class']              = 'class';
$BL['be_admin_page_image']              = 'imagem';
$BL['be_admin_page_text']               = 'texto';
$BL['be_admin_page_link']               = 'link';
$BL['be_admin_page_js']                 = 'javascript';
$BL['be_admin_page_visited']            = 'visited';
$BL['be_admin_page_pagetitle']          = 'Título SEO';
$BL['be_admin_page_addtotitle']         = 'adicionar ao titulo';
$BL['be_admin_page_category']           = 'categoria';
$BL['be_admin_page_articlename']        = 'nome da página';
$BL['be_admin_page_blocks']             = 'bloco';
$BL['be_admin_page_allblocks']          = 'tudo blocos';
$BL['be_admin_page_col1']               = 'layout de 3 colunas';
$BL['be_admin_page_col2']               = 'layout de 2 colunas (navegação a esquera)';
$BL['be_admin_page_col3']               = 'layout de 2 colunas (navegação a direita)';
$BL['be_admin_page_col4']               = 'layout de 1 coluna';
$BL['be_admin_page_header']             = 'cabeçalho';
$BL['be_admin_page_footer']             = 'rodapé';
$BL['be_admin_page_banner']             = 'banner';
$BL['be_admin_page_mapa']             	= 'mapa';
$BL['be_admin_page_clientes']           = 'clientes';
$BL['be_admin_page_servicos']           = 'servicos';
$BL['be_admin_page_produtos']           = 'produtos';
$BL['be_admin_page_topspace']           = 'espaço&nbsp;em&nbsp;cima';
$BL['be_admin_page_bottomspace']        = 'espaço&nbsp;em&nbsp;baixo';
$BL['be_admin_page_button']             = 'gravar layout da página';

// admin.frontendcss.tmpl.php
$BL['be_admin_css_title']               = 'arranjo do frontend: dados da css';
$BL['be_admin_css_css']                 = 'css';
$BL['be_admin_css_button']              = 'gravar arquivo css';

// admin.templates.tmpl.php
$BL['be_admin_tmpl_title']              = 'frontend setup: modelos';
$BL['be_admin_tmpl_default']            = 'Padrão';
$BL['be_admin_tmpl_add']                = 'adicionar modelo';
$BL['be_admin_tmpl_edit']               = 'editar modelo';
$BL['be_admin_tmpl_new']                = 'criar novo modelo';
$BL['be_admin_tmpl_css']                = 'Arquivos css';
$BL['be_admin_tmpl_scripts']					= 'Arquivos Javascript';
$BL['be_admin_tmpl_head']               = 'Cabeçalho html';
$BL['be_admin_tmpl_js']                 = 'Javascript';
$BL['be_admin_tmpl_error']              = 'Texto Erro 404';
$BL['be_admin_tmpl_button']             = 'salvar modelo';
$BL['be_admin_tmpl_name']               = 'Nome do Template';

// article.structlist.tmpl.php
$BL['be_article_title']                 = 'Páginas do Site';

// article.new.tmpl.php
$BL['be_article_err1']                  = 'o titulo para esta página está vazio';
$BL['be_article_err2']                  = 'a data de início está errada - ajuste-a agora';
$BL['be_article_err3']                  = 'a data do fim está errada - ajuste-a agora';
$BL['be_article_title1']                = 'informação base da página';
$BL['be_article_cat']                   = 'categoria';
$BL['be_article_atitle']                = 'título da página';
$BL['be_article_asubtitle']             = 'subtítulo';
$BL['be_article_abegin']                = 'Data de Início';
$BL['be_article_aend']                  = 'Data de Finalização';
$BL['be_article_aredirect']             = 'redirecionar para';
$BL['be_article_akeywords']             = 'palavras-chave';
$BL['be_article_asummary']              = 'sumário';
$BL['be_article_abutton']               = 'criar página';

// article.editcontent.inc.php
$BL['be_article_err4']                  = 'a data de finalização estava errada - foi ajustada para +1 semana';

// article.editsummary.tmpl.php
$BL['be_article_estitle']               = 'editar informação base da página';
$BL['be_article_eslastedit']            = 'ultima atualização';
$BL['be_article_esnoupdate']            = 'formulário não atualizado';
$BL['be_article_esbutton']              = 'atualizar dados do arquivo';

// articlecontent.edit.tmpl.php
$BL['be_article_cnt_title']             = 'conteúdo da página';
$BL['be_article_cnt_type']              = 'tipo de contéudo';
$BL['be_article_cnt_space']             = 'espaço';
$BL['be_article_cnt_before']            = 'Espaço Antes (px)';
$BL['be_article_cnt_after']             = 'Espaço Depois (px)';
$BL['be_article_cnt_top']               = 'topo';
$BL['be_article_cnt_ctitle']            = 'título do conteúdo';
$BL['be_article_cnt_back']              = 'informação completa da página';
$BL['be_article_cnt_button1']           = 'Salvar Alterações';
$BL['be_article_cnt_button2']           = 'criar conteúdo';

// articlecontent.list.tmpl.php
$BL['be_article_cnt_ltitle']            = 'Editar Página ';
$BL['be_article_cnt_ledit']             = 'editar página';
$BL['be_article_cnt_lvisible']          = 'mudar visível / invisível';
$BL['be_article_cnt_ldel']              = 'apagar esta página';
$BL['be_article_cnt_ldeljs']            = 'Apagar página?';
$BL['be_article_cnt_redirect']          = 'redirecionamento';
$BL['be_article_cnt_edited']            = 'editado por';
$BL['be_article_cnt_start']             = 'data de início';
$BL['be_article_cnt_end']               = 'data de finalização';
$BL['be_article_cnt_add']               = 'Criar Novo Conteúdo';
$BL['be_article_cnt_up']                = 'mover conteúdo para cima';
$BL['be_article_cnt_down']              = 'mover conteúdo para baixo';
$BL['be_article_cnt_edit']              = 'editar parte do conteúdo';
$BL['be_article_cnt_delpart']           = 'apagar esta parte da página';
$BL['be_article_cnt_delpartjs']         = 'Apagar esta parte do conteúdo?';
$BL['be_article_cnt_center']            = 'Fechar Edição';

// content forms
$BL['be_cnt_plaintext']                 = 'texto simples';
$BL['be_cnt_htmltext']                  = 'texto html';
$BL['be_cnt_image']                     = 'imagem';
$BL['be_cnt_position']                  = 'posição';
$BL['be_cnt_pos0']                      = 'Acima, esquerda';
$BL['be_cnt_pos1']                      = 'Acima, centralizado';
$BL['be_cnt_pos2']                      = 'Acima, direita';
$BL['be_cnt_pos3']                      = 'Abaixo, esquerda';
$BL['be_cnt_pos4']                      = 'Abaixo, centralizado';
$BL['be_cnt_pos5']                      = 'Abaixo, direita';
$BL['be_cnt_pos6']                      = 'No texto, esquerda';
$BL['be_cnt_pos7']                      = 'No texto, direita';
$BL['be_cnt_pos8']                      = 'Em Bloco, Imagem a esquerda';
$BL['be_cnt_pos9']                      = 'Em Bloco, Imagem a Direita';
$BL['be_cnt_pos0i']                     = 'alinhar a imagem acima e à esquerda do bloco de texto';
$BL['be_cnt_pos1i']                     = 'alinhar a imagem acima e ao centro do bloco de texto';
$BL['be_cnt_pos2i']                     = 'alinhar a imagem acima e à direita do bloco de texto';
$BL['be_cnt_pos3i']                     = 'alinhar a imagem abaixo e à esquerda do bloco de texto';
$BL['be_cnt_pos4i']                     = 'alinhar a imagem abaixo e ao centro do bloco de texto';
$BL['be_cnt_pos5i']                     = 'alinhar a imagem abaixo e à direita do bloco de texto';
$BL['be_cnt_pos6i']                     = 'alinhar a imagem à esquerda dentro do bloco de texto';
$BL['be_cnt_pos7i']                     = 'alinhar a imagem à direita dentro do bloco de texto';
$BL['be_cnt_maxw']                      = 'largura&nbsp;max.';
$BL['be_cnt_maxh']                      = 'altura&nbsp;max.';
$BL['be_cnt_enlarge']                   = 'clicar&nbsp;ampliar';
$BL['be_cnt_caption']                   = 'legenda';
$BL['be_cnt_subject']                   = 'assunto';
$BL['be_cnt_recipient']                 = 'destinatário';
$BL['be_cnt_buttontext']                = 'texto do botão';
$BL['be_cnt_sendas']                    = 'enviar como';
$BL['be_cnt_text']                      = 'texto';
$BL['be_cnt_html']                      = 'html';
$BL['be_cnt_formfields']                = 'campos do formulário';
$BL['be_cnt_code']                      = 'código';
$BL['be_cnt_infotext']                  = 'texto&nbsp;de&nbsp;informação';
$BL['be_cnt_subscription']              = 'subscrição';
$BL['be_cnt_labelemail']                = 'Texto Email';
$BL['be_cnt_tablealign']                = 'Modelo&nbsp;da&nbsp;tabela';
$BL['be_cnt_labelname']                 = 'Texto Nome';
$BL['be_cnt_labelsubsc']                = 'etiqueta&nbsp;subscr.';
$BL['be_cnt_allsubsc']                  = 'todas&nbsp;subsc..';
$BL['be_cnt_default']                   = 'Padrão';
$BL['be_cnt_left']                      = 'Modelo sem Títulos';
$BL['be_cnt_center']                    = 'Modelo Padrão';
$BL['be_cnt_buttontext']                = 'texto do botão';
$BL['be_cnt_successtext']               = 'Texto de Envio com Sucesso';
$BL['be_cnt_regmail']                   = 'Email de Confirmação de Incrição';
$BL['be_cnt_logoffmail']                = 'Email de Cancelamento de Inscrição';
$BL['be_cnt_changemail']                = 'Mudança de Email';
$BL['be_cnt_openimagebrowser']          = 'abrir browser de imagem';
$BL['be_cnt_openfilebrowser']           = 'abrir browser de arquivos';
$BL['be_cnt_sortup']                    = 'mova para cima';
$BL['be_cnt_sortdown']                  = 'mova para baixo';
$BL['be_cnt_delimage']                  = 'remover imagem selecionada';
$BL['be_cnt_delfile']                   = 'remover arquivo selecionado';
$BL['be_cnt_delmedia']                  = 'remover media selecionada';
$BL['be_cnt_column']                    = 'coluna';
$BL['be_cnt_imagespace']                = 'imagem&nbsp;espaço';
$BL['be_cnt_directlink']                = 'link directo';
$BL['be_cnt_target']                    = 'alvo';
$BL['be_cnt_target1']                   = 'numa janela nova';
$BL['be_cnt_target2']                   = 'no frame parente da janela';
$BL['be_cnt_target3']                   = 'na mesma janela sem frames';
$BL['be_cnt_target4']                   = 'no mesmo frame ou janela';
$BL['be_cnt_bullet']                    = 'lists (tabela)';
$BL['be_cnt_ullist']                            = 'lista';
$BL['be_cnt_ullist_desc']                   = '~ = 1º nível, &nbsp; ~~ = 2º nível, &nbsp; etc.';
$BL['be_cnt_linklist']                  = 'listagem de links';
$BL['be_cnt_plainhtml']                 = 'Código html';
$BL['be_cnt_files']                     = 'arquivos';
$BL['be_cnt_description']               = 'descrição';
$BL['be_cnt_linkarticle']               = 'link para artigo';
$BL['be_cnt_articles']                  = 'PÁGINAS';
$BL['be_cnt_movearticleto']             = 'mover artigo selecionado para a listagem de links';
$BL['be_cnt_removearticleto']           = 'eliminar artigo selecionado para da listagem de links';
$BL['be_cnt_mediatype']                 = 'tipo de media';
$BL['be_cnt_control']                   = 'controle';
$BL['be_cnt_showcontrol']               = 'mostrar barra de controle';
$BL['be_cnt_autoplay']                  = 'início automático';
$BL['be_cnt_source']                    = 'fonte';
$BL['be_cnt_internal']                  = 'interno';
$BL['be_cnt_openmediabrowser']          = 'abrir media browser';
$BL['be_cnt_external']                  = 'externo';
$BL['be_cnt_mediapos0']                 = 'esquerda (default)';
$BL['be_cnt_mediapos1']                 = 'centro';
$BL['be_cnt_mediapos2']                 = 'direita';
$BL['be_cnt_mediapos3']                 = 'bloco, esquerda';
$BL['be_cnt_mediapos4']                 = 'bloco, direita';
$BL['be_cnt_mediapos0i']                = 'alinhar a imagem acima e a esquerda do bloco de texto';
$BL['be_cnt_mediapos1i']                = 'alinhar a imagem acima e ao centro do bloco de texto';
$BL['be_cnt_mediapos2i']                = 'alinhar a imagem acima e a direita do bloco de texto';
$BL['be_cnt_mediapos3i']                = 'alinhar a imagem a esquerda dentro do bloco de texto';
$BL['be_cnt_mediapos4i']                = 'alinhar a imagem a direita dentro do bloco de texto';
$BL['be_cnt_setsize']                   = 'ajustar tamanho';
$BL['be_cnt_set1']                      = 'ajustar tamanho media para 160x120px';
$BL['be_cnt_set2']                      = 'ajustar tamanho media para 240x180px';
$BL['be_cnt_set3']                      = 'ajustar tamanho media para 320x240px';
$BL['be_cnt_set4']                      = 'ajustar tamanho media para 480x360px';
$BL['be_cnt_set5']                      = 'apagar tamanho media';
$BL['form_force_ssl']                   = 'Forçar envio com SSL';
// added: 28-12-2003
$BL['be_admin_page_add']                = 'criar novo modelo';
$BL['be_admin_page_name']               = 'nome do modelo';
$BL['be_admin_page_edit']               = 'editar modelo';
$BL['be_admin_page_render']             = 'renderização';
$BL['be_admin_page_table']              = 'tabela';
$BL['be_admin_page_div']                = 'css div';
$BL['be_admin_page_custom']             = 'personalizado';
$BL['be_admin_page_custominfo']         = 'a partir do bloco main';
$BL['be_admin_tmpl_layout']             = 'modelo';
$BL['be_admin_tmpl_nolayout']           = 'não existem modelos!';
$BL['random_image']                     = 'Modo Aleatório';
$BL['limit_image_from_list']            = 'Nº Máx. de Imagens';

// added: 31-12-2003
$BL['be_ctype_search']                  = 'pesquisa';
$BL['be_cnt_results']                   = 'resultados';
$BL['be_cnt_results_per_page']          = 'por&nbsp;página (se vazio, mostra todos)';
$BL['be_cnt_opennewwin']                = 'abrir nova janela';
$BL['be_cnt_searchlabeltext']           = 'estes são valores e dados predefinidos para o formulário de pesquisa quando forem encontrados mais do que os resultados desejados por página.';
$BL['be_cnt_input']                     = 'entrada';
$BL['be_cnt_style']                     = 'estilo';
$BL['be_cnt_result']                    = 'resultado';
$BL['be_cnt_next']                      = 'próximo';
$BL['be_cnt_previous']                  = 'anterior';
$BL['be_cnt_align']                     = 'alinhamento';
$BL['be_cnt_searchformtext']            = 'o seguinte texto aparece no início do formulário e quando não existem resultados durante a pesquisa.';
$BL['be_cnt_intro']                     = 'texto de entrada';
$BL['be_cnt_noresult']                  = 'sem resultado';

// added: 02-01-2004
$BL['be_admin_page_disable']            = 'desligado';

// added: 09-01-2004
$BL['be_article_articleowner']          = 'proprietário da página';
$BL['be_article_adminuser']             = 'usuário administrativo';
$BL['be_article_username']              = 'autor';

// added: 10-01-2004
$BL['be_ctype_wysywig']                 = 'Editor de Textos';

// added, changed: 11-01-2004
$BL['be_admin_struct_regonly']          = 'visivel apenas por usuários registados/ligados';
$BL['be_admin_struct_status']           = 'status no frontend';

// added: 15-02-2004
$BL['be_ctype_articlemenu']                             = 'menu de artigos';
$BL['be_cnt_sitelevel']                                 = 'nível do site';
$BL['be_cnt_sitecurrent']                               = 'nível actual do site';

// added: 24-03-2004
$BL['be_subnav_admin_starttext']                = 'texto por defeito no backend';
$BL['be_ctype_ecard']                                   = 'Banner';
$BL['be_ctype_blog']                                    = 'blog';
$BL['be_cnt_ecardtext']                 = 'titulo/e-card';
$BL['be_cnt_ecardtmpl']                 = 'mail tmpl';
$BL['be_cnt_ecard_image']               = 'e-card imagem';
$BL['be_cnt_ecard_title']               = 'e-card titulo';
$BL['be_cnt_alignment']                 = 'alinhamento';
$BL['be_cnt_ecardform']                 = 'formulario tmpl';
$BL['be_cnt_ecardform_err']             = 'Os campos marcados com * são obrigatórios';
$BL['be_cnt_ecardform_sender']          = 'Remetente';
$BL['be_cnt_ecardform_recipient']       = 'Destinatário';
$BL['be_cnt_ecardform_name']            = 'Nome';
$BL['be_cnt_ecardform_msgtext']         = 'A sua mensagem para o destinatário';
$BL['be_cnt_ecardform_button']          = 'enviar e-card';
$BL['be_cnt_ecardsend']                 = 'enviar tmpl';

// added: 28-03-2004
$BL['be_admin_startup_title']           = 'Texto inicial por defeito do backend';
$BL['be_admin_startup_text']            = 'texto de entrada';
$BL['be_admin_startup_button']          = 'salvar texto de entrada';

// added: 17-04-2004
$BL['be_ctype_guestbook']                               = 'livro de visitas/comentário.';
$BL['be_cnt_guestbook_listing']                 = 'listagem';
$BL['be_cnt_guestbook_listing_all']             = 'mostrar&nbsp;todas&nbsp;as&nbsp;entradas';
$BL['be_cnt_guestbook_list']                    = 'lista';
$BL['be_cnt_guestbook_perpage']                 = 'por&nbsp;página';
$BL['be_cnt_guestbook_form']                    = 'form';
$BL['be_cnt_guestbook_signed']                  = 'assinado';
$BL['be_cnt_guestbook_nav']                             = 'nav';
$BL['be_cnt_guestbook_before']                  = 'anterior';
$BL['be_cnt_guestbook_after']                   = 'próxima';
$BL['be_cnt_guestbook_entry']                   = 'entrada';
$BL['be_cnt_guestbook_edit']                    = 'editar';
$BL['be_cnt_ecardform_selector']        = 'Modo de Exibição';
$BL['be_cnt_ecardform_radiobutton']     = 'radio button';
$BL['be_cnt_ecardform_javascript']      = 'Funcionalidade JavaScript';
$BL['be_cnt_ecardform_over']            = 'onMouseOver';
$BL['be_cnt_ecardform_click']           = 'onClick';
$BL['be_cnt_ecardform_out']                     = 'onMouseOut';
$BL['be_admin_struct_topcount']         = 'Contagem superior da página';

// added: 19-04-2004
$BL['be_subnav_msg_newslettersend']     = 'Newsletter';
$BL['be_newsletter_addnl']              = 'adicionar Newsletter';
$BL['be_newsletter_titleeditnl']        = 'editar Newsletter';
$BL['be_newsletter_newnl']              = 'criar novo';
$BL['be_newsletter_button_savenl']      = 'salvar Newsletter';
$BL['be_newsletter_fromname']           = 'de: nome';
$BL['be_newsletter_fromemail']          = 'de: email';
$BL['be_newsletter_replyto']            = 'enviar para email';
$BL['be_newsletter_changed']            = 'última alteração';
$BL['be_newsletter_placeholder']        = 'placeholder';
$BL['be_newsletter_htmlpart']           = 'Conteúdo HTML do Newsletter';
$BL['be_newsletter_textpart']           = 'Conteúdo TEXTO do Newsletter';
$BL['be_newsletter_allsubscriptions']   = 'todas os subscritores';
$BL['be_newsletter_verifypage']         = 'verificar link';
$BL['be_newsletter_open']               = 'HTML e TEXTO entrada';
$BL['be_newsletter_open1']              = '(clique na imagem para abrir)';
$BL['be_newsletter_sendnow']            = 'Enviar Newsletter';
$BL['be_newsletter_attention']          = '<strong style="color:#CC3300;">Atenção!</strong> Enviar o Newsletter para multiplos destinatários é uma tarefa árdua para o servidor. Os destinatários devem ter sido analizados e verificados para ter a certeza que não vai email indesejados. Pense duas vezes antes de enviar o Newsletter. Verifique o Newsletter enviando um teste primeiro.';
$BL['be_newsletter_attention1']         = 'Se fez quaisquer alterações no Newsletter em cima, por favor guarde as alterações primeiro, ou as alterações serão ignoradas.';
$BL['be_newsletter_testemail']          = 'testar email';
$BL['be_newsletter_sendnlbutton']       = 'enviar Newsletter';
$BL['be_newsletter_sendprocess']        = 'envio em processamento';
$BL['be_newsletter_attention2']         = '<strong style="color:#CC3300;">Atenção!</strong> Por favor não pare o processo de envio. Se o fizer o mesmo destinatário pode receber duas cópias do Newsletter. Se o envio falhar, os destinatários em falta serão registados podendo efectuar o envio posteriormente.';
$BL['be_newsletter_testerror']          = '<span style="color:#CC3300;font-size:11px;">o endereço de email para o envio do teste <strong>###TEST###</strong> NÃO é valido!<br />&nbsp;<br />Por favor tente novamente!';
$BL['be_newsletter_to']                 = 'Destinatários';
$BL['be_newsletter_ready']              = 'enviando Newsletter: CONCLUÍDO';
$BL['be_newsletter_readyfailed']        = 'Falhou o envio do Newsletter para';
$BL['be_subnav_msg_subscribers']        = 'Lista de E-mails';

// added: 20-04-2004
$BL['be_ctype_sitemap']                             = 'mapa do site';
$BL['be_cnt_sitemap_catimage']          = 'icon da categoria';
$BL['be_cnt_sitemap_articleimage']      = 'icon da página';
$BL['be_cnt_sitemap_display']           = 'mostrar';
$BL['be_cnt_sitemap_structuronly']      = 'estrutura das categorias';
$BL['be_cnt_sitemap_structurarticle']   = 'estrutura das categorias + artigos';
$BL['be_cnt_sitemap_catclass']          = '(css) class das categorias';
$BL['be_cnt_sitemap_articleclass']      = '(css) class dos artigos';
$BL['be_cnt_sitemap_count']             = 'contador';
$BL['be_cnt_sitemap_classcount']        = 'adicionar ao nome da class';
$BL['be_cnt_sitemap_noclasscount']      = 'não adicionar ao nome da class';

// added: 23-04-2004
$BL['be_ctype_bid']                                     = 'oferta';
$BL['be_cnt_bid_bidtext']               = 'texto da oferta';
$BL['be_cnt_bid_sendtext']              = 'texto enviado';
$BL['be_cnt_bid_verifiedtext']          = 'texto para verificação';
$BL['be_cnt_bid_errortext']             = 'oferta apagada';
$BL['be_cnt_bid_verifyemail']           = 'verificar email';
$BL['be_cnt_bid_startbid']              = 'iniciar oferta';

// added: 29-04-2004
$BL['be_cnt_bid_nextbidadd']            = 'aumentar&nbsp;por';

// added: 10-05-2004
$BL['be_ctype_pages']                   = 'conteúdo ext.';
$BL['be_cnt_pages_select']              = 'selecione arquivo';
$BL['be_cnt_pages_fromfile']            = 'arquivo da estrutura';
$BL['be_cnt_pages_manually']            = 'custom path/arquivo ou URL';
$BL['be_cnt_pages_cust']                = 'arquivo/URL';
$BL['be_cnt_pages_from']                = 'fonte';

// added: 24-05-2004
$BL['be_ctype_reference']               = 'imagens rollover';
$BL['be_cnt_reference_basis']           = 'alinhamento';
$BL['be_cnt_reference_horizontal']      = 'horizontal';
$BL['be_cnt_reference_vertical']        = 'vertical';
$BL['be_cnt_reference_aligntext']       = 'imagens pequenas de referência';
$BL['be_cnt_reference_largetext']       = 'imagens grandes de referência';
$BL['be_cnt_reference_zoom']            = 'zoom';
$BL['be_cnt_reference_middle']          = 'meio';
$BL['be_cnt_reference_border']          = 'border';
$BL['be_cnt_reference_block']           = 'bloco w x h';

// added: 31-05-2004
$BL['be_article_rendering']             = 'rendring';
$BL['be_article_nosummary']             = 'Esconder Introdução na Página Completa';
$BL['be_article_forlist']               = 'Introdução da Página';
$BL['be_article_forfull']               = 'Pagina Interna Completa';
$BL['be_acat_disable301']				= 'article 301 redirect';
$BL['be_article_paginate']              = 'Paginate';
$BL['be_paginate_desc']                 = 'Ativar paginate da lista de artigos';
$BL['be_paginate_itens']                = 'Iten por página';



$BL['be_fileuploader_uploadButtonText'] = 'Selecionar Arquivos';
//Boletim de Notícias
$BL['be_cnt_export_selection']			= 'Exportar Lista';
$BL['be_cnt_delete_duplicates']			= 'Excluir E-mails Duplicados';
$BL['be_cnt_new_recipient']			= 'Add E-mail';


$BL['be_cnt_newsletter_prepare']		= 'newsletter active';
$BL['be_cnt_newsletter_prepare1']		= 'all recipients will be taken over to sending queue';
$BL['be_cnt_newsletter_prepare2']		= 'sending queue will be updated&#8230;';


//Colocados Manualmente - 21-06-2012
$BL['be_file_replace'] = 'Substituir arquivos existentes';
$BL['be_func_content_copy']              = 'Duplicar esta parte de conteúdo';
$BL['be_cnt_css_style']                  = 'Place Holder';
$BL['be_cnt_css_class']                  = 'Tags HTML5';
$BL['be_file_multiple_upload']           = 'Carregar Vários Arquivos';
$BL['be_ctype']                          = 'Partes de Conteúdo';
$BL['be_last_edited']                    = 'últimos editados';
$BL['be_article_cnt_button3']            = 'Concluir';
$BL['be_cnt_results_wordlimit']          = 'N° maxímo de palavras';
$BL['be_article_urlalias']               = 'URL da Página';
$BL['be_article_noteaser']               = 'Sem Template';
$BL['be_granted_feuser']                 = 'Conteúdo Restrito';
$BL['be_func_switch_contentpart'] = 'Você realmente deseja trocar o tipo de conteúdo? \n\nIsso irá DELETAR o conteúdo atual!\n';
$BL['be_cnt_same_as_summary']            = 'Usar mesma imagem da página interna completa';
$BL['be_admin_struct_orderdesc']        = 'decrescente';
$BL['be_admin_struct_orderasc']         = 'crescente';
$BL['be_admin_struct_orderarticle']     = 'Ordenar por';
$BL['be_admin_struct_orderdate']        = 'data criação';
$BL['be_admin_struct_orderchangedate']  = 'data alteração';
$BL['be_admin_struct_orderstartdate']   = 'data início';
$BL['be_admin_struct_ordermanual']      = 'manual (arrow up/down)';
$BL['be_cnt_sitemap_startid']           = 'Começa em';
$BL['be_admin_struct_orderkilldate']    = 'data término';
$BL['be_delete_selected_files']         = 'Deletar arquivos selecionados';
$BL['be_fileuploader_dragText']         = "Solte seus arquivos aqui para carrega-los.";
$BL['be_news']                          = 'Notícias';
$BL['be_cnt_type']                      = 'tipo';
$BL['be_cnt_last_edited']               = 'última alteração';
$BL['be_files_select_available']        = 'Selecione os arquivos enviados anteriormente';


// added: Flash Media Player
$BL['be_ctype_flashplayer']				= 'HTML5/Flash media player';
$BL['be_flashplayer_caption']           = 'Legenda';
$BL['be_flashplayer_thumbnail']			= 'Miniatura';
$BL['be_flashplayer_selectsize']		= 'Tamanho do Player';
$BL['be_flash_media']					= 'Flash';
$BL['be_html5_media']					= 'HTML5';
$BL['be_html5_h264']					= 'H.264';
$BL['be_html5_webm']					= 'WebM';
$BL['be_html5_ogg']						= 'Ogg';
$BL['be_media_format']					= 'formato';
$BL['be_media_watermark']				= 'Sobrepor imagem';
$BL['be_skin']							= 'skin';
$BL['be_foreground_color']				= 'Cor do primeiro plano';
$BL['be_background_color']				= 'cor de fundo';
$BL['be_highlight_color']				= 'Cor de destaque';
$BL['be_cnt_search_hidesummary']        = 'Esconder descrição';
$BL['be_cnt_search_searchnot']	        ='Não procurar por';
$BL['be_settings']			         	= 'Configurações';
$BL['be_cnt_field']						= array("text"=>'Texto (Linha Simples)',
												"email"=>'E-mail',
												"textarea"=>'Caixa de Texto (Linhas Múltiplas)',
												"hidden"=>'Invisivel',
												"password"=>'Senha',
												"select"=>'Menu de Seleção',
												"list"=>'Lista de Menu',
												"checkbox"=>'Caixa de Seleção',
												"radio"=>'Caixa de Opção',
												"upload"=>'Arquivo',
												"submit"=>'Botão Enviar',
												"reset"=>'Botão Limpar',
												"break"=>'Data HTML5', "breaktext"=>'Telefone HTML5',
												"special"=>'Texto (Especial)',
												"captchaimg"=>'Imagem de Verificação',
												"captcha"=>'Código de Vericação',
												'newsletter'=>'Newsletter',
												'selectemail'=>'Seleção de Email',
												'country'=>'Seleção de País',
												'mathspam'=>'Protetor de Spam',
												'summing'=>'summing',
												'subtract'=>'Subtrair',
												'divide'=>'divide', 'multiply'=>'Multiplicar',
												'calculation'=>'Calcular:',
												'formtracking_off'=>'Desativar Rastreador',
												'checktofrom'=>'E-mail do destinatário deve ser diferente do remetente',
												'recaptcha'=>'Repetir Verificação',
												'recaptcha_signapikey'=>'Cadastre-se para Receber uma Chave de Verificação');

$BL['be_subnav_file_actions']           = 'Editar arquivos';
$BL['file_actions_step1']				= "Passo 1: Escolha a Pasta";
$BL['file_actions_step2']				= "Passo 2: Selecione os arquivos";
$BL['file_actions_step3']				= "Passo 3: Selecione a Ação";
$BL['file_actions_button']				= 'Executar';
$BL['file_actions_no']					= 'Pasta vazia. Por favor escolha outra pasta';
$BL['file_actions_delete']				= 'Tem certeza que deseja deletar os arquivos selecionados?';
$BL['file_actions_bemuser']				= 'Os arquivos selecionados serão designados para o novo usuário e foram movidos para a sua raiz.';
$BL['file_actions_bemfolder']			= 'Por favor selecione a nova pasta de destino. <br/>Os arquivos selecionados serão movidos para esta pasta. ';
$BL['file_actions_pdl_empty']			= 'Selecione a Ação';
$BL['file_actions_pdl_delete']			= 'Deletar arquivos';
$BL['file_actions_pdl_move']			= 'Mover arquivos';
$BL['file_actions_pdl_status']			= 'Mudar Status';
$BL['file_actions_pdl_user']			= 'Mudar Proprietário';
$BL['file_actions_msg_move']			= 'Os arquivos foram movidos com sucesso';
$BL['file_actions_msg_delete']			= 'Os arquivos foram deletados com sucesso';
$BL['file_actions_msg_status']			= 'O status dos arquivos foram alterados com sucesso';
$BL['file_actions_msg_error']			= 'Nenhum arquivo selecionado';
$BL['file_actions_msg_user']			= 'Os arquivos foram designados para o novo usuário com sucesso';
$BL['be_func_struct_copy']              = 'copiar página';
$BL['be_func_struct_nocopy']            = 'cancelar cópia de artigo';
$BL['be_article_cnt_addtitle']          = 'Adicionar nova parte à página';
$BL['be_opengraph_support']				= 'Permitir compartilhamento social';
$BL['be_no_search']						= 'Não pesquisar';
$BL['be_show_archived']					= 'Disponível após a data final (arquivar)';
$BL['be_overwrite_default']				= 'Irá sobrescrever as configurações padrões do arquivo:';
$BL['be_pagination']					= 'paginação';
$BL['be_article_pagination']			= 'paginação de artigos';
$BL['be_article_per_page']			    = 'artigos por página';
$BL['be_structform_selected_cp']		= 'Selecionar partes de conteúdo';
$BL['be_archive']						= 'arquivo';
$BL['be_admin_struct_acat_hiddenactive'] = 'visível quando ativo';


//Nomes das novas opções de Images Div e Link de Artigo
$BL['be_cnt_addclasse']                 = 'Adicionar Classe';
$BL['be_cnt_numero']                    = 'Nº do Elemento';
$BL['be_cnt_imglist_classe']			= 'Classe';
$BL['be_cnt_behavior_multi']			= 'Classe Múltiplos';
$BL['be_cnt_behavior_addclasse']		= 'Classe Individual';

$BL['frontendjs_load']					= 'load frontend.js';

// Nova de parte de conteúdo: Banners
$BL['be_banner_thumbnail']	 		    = 'Imagem';
$BL['be_banner_tempo']                  = 'Duração em Segundos';
$BL['be_banner_texto_botao']            = 'Texto do Botão';

$BL['be_ctype_imagesspecial']		= 'Imagens com Links';
$BL['be_ctype_imagesdiv']		= 'Galeria Simples';

$BL['be_article_cnt_anchor']		= 'Ancora';
$BL['be_show_content']          	= 'Mostrar em';
$BL['be_image_crop']                    = 'Forçar Ajuste';
$BL['be_random']                        = 'Aleatório';
$BL['be_sorted']                        = 'Ordem';
$BL['be_allowed_tags']                  = 'Tags Permitidas';
$BL['be_tab_add']                       = 'Add Novo Bloco de Texto';
$BL['be_cnt_download_direct']           = 'Forçar Download';
$BL['be_newsletter_newimport']          = 'Importar Lista';

$BL['be_image_slider']                  = 'Ativar Slider';
$BL['tit_tab_slider']                   = 'Código do Slider';

?>