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
// Revised by Isac Ara�jo  isacaraujo@sapo.pt
// Last updated 16.jun 2004


$BL['usr_online']                       = 'usu�rios online';

// Login Page
$BL["login_text"]                       = 'Introduza os seus dados de in�cio da sess�o';
$BL['login_error']                      = 'Erros durante o in�cio da sess�o!';
$BL["login_username"]                   = 'usu�rio';
$BL["login_userpass"]                   = 'senha';
$BL["login_button"]                     = 'Iniciar sess�o';
$BL["login_lang"]                       = 'linguagem do backend';

// phpwcms.php
$BL['be_nav_logout']                    = '<img src="img/icon-webcis/sair.png" alt="Sair do Sistema" border="0"/>SAIR';
$BL['be_nav_articles']                  = '<img src="img/icon-webcis/artigos.png" alt="Visualizar e editar P�ginas" border="0"/>P�GINAS';
$BL['be_nav_files']                     = '<img src="img/icon-webcis/arquivos.png" alt="Subir e editar Arquivos" border="0"/>ARQUIVOS';
$BL['be_nav_modules']                   = '<img src="img/icon-webcis/modulos.png" alt="Configura��o de Modulos" border="0"/>M�DULOS';
$BL['be_nav_dados']                   = '<img src="img/icon-webcis/modulos.png" alt="Informa��es da Empresa" border="0"/>DADOS DA EMPRESA';
$BL['be_nav_messages']                  = '<img src="img/icon-webcis/mensagem.png" alt="Envio e Cadastro de Newsletter" border="0"/>MENSAGEM';
$BL['be_nav_chat']                      = 'CHAT';
$BL['be_nav_profile']                   = '<img src="img/icon-webcis/perfil.png" alt="Edite seu Perfil" border="0"/>PERFIL';
$BL['be_nav_admin']                     = '<img src="img/icon-webcis/admin.png" alt="�rea para Desenvolvedor" border="0"/>ADMINISTRADOR';
$BL['be_nav_discuss']                   = 'DISCUTA';

$BL['be_page_title']                    = 'Administrador do Site';

$BL['be_subnav_article_center']         = 'P�GINAS DO SITE';
$BL['be_subnav_article_new']            = 'nova p�gina';
$BL['be_subnav_file_center']            = 'arquivos do site';
$BL['be_subnav_file_ftptakeover']       = 'envio por ftp';
$BL['be_subnav_mod_artists']            = 'artista, categoria, g�nero';
$BL['be_subnav_msg_center']             = 'centro de mensagems';
$BL['be_subnav_msg_new']                = 'nova mensagem';
$BL['be_subnav_msg_newsletter']         = 'Boletim de Not�cias';
$BL['be_subnav_chat_main']              = 'p�gina principal do chat';
$BL['be_subnav_chat_internal']          = 'chat interno';
$BL['be_subnav_profile_login']          = 'informa��o do in�cio da sess�o';
$BL['be_subnav_profile_personal']       = 'dados pessoais';
$BL['be_subnav_admin_pagelayout']       = 'disposi��o de p�gina';
$BL['be_subnav_admin_templates']        = 'templates (moldes)';
$BL['be_subnav_admin_css']              = 'css por defeito';
$BL['be_subnav_admin_sitestructure']    = 'estrutura do site';
$BL['be_subnav_admin_users']            = 'administra��o de usu�rios';
$BL['be_subnav_admin_filecat']          = 'categorias de arquivos';


// admin.functions.inc.php
$BL['be_func_struct_articleID']         = 'ID da p�gina';
$BL['be_func_struct_preview']           = 'Pr� Visualizar';
$BL['be_func_struct_edit']              = 'editar artigo';
$BL['be_func_struct_sedit']             = 'editar o n�vel da estrutura';
$BL['be_func_struct_cut']               = 'cortar artigo';
$BL['be_func_struct_nocut']             = 'desligar cortar artigo';
$BL['be_func_struct_svisible']          = 'mudar vis�vel/invis�vel';;
$BL['be_func_struct_spublic']           = 'mudar p�blico/privado';
$BL['be_func_struct_sort_up']           = 'ordenar para cima';
$BL['be_func_struct_sort_down']         = 'ordenar para baixo';
$BL['be_func_struct_del_article']       = 'apagar artigo';
$BL['be_func_struct_del_jsmsg']         = 'Tem certeza que \npretende apagar a p�gina?'; // "\n" = JavaScript Linebreak
$BL['be_func_struct_new_article']       = 'criar nova p�gina no n�vel da estrutura';
$BL['be_func_struct_paste_article']     = 'colocar artigo no n�vel da estrutura';
$BL['be_func_struct_insert_level']      = 'colocar n�vel da estrutura em';
$BL['be_func_struct_paste_level']       = 'colar n�vel da estrutura em';
$BL['be_func_struct_cut_level']         = 'cortar n�vel da estrutura';
$BL['be_func_struct_no_cut']            = "N�o � poss�vel cortar o n�vel da raiz!";
$BL['be_func_struct_no_paste1']         = "N�o � poss�vel colocar aqui!";
$BL['be_func_struct_no_paste2']         = '� parente do n�vel da raiz';
$BL['be_func_struct_no_paste3']         = 'isso deve colar-se aqui dentro';
$BL['be_func_struct_paste_cancel']      = 'cancelar mudan�a do n�vel da estrutura';
$BL['be_func_struct_del_struct']        = 'apagar este n�vel da estrutura';
$BL['be_func_struct_del_sjsmsg']        = 'Tem certeza que \npretende apagar o n�vel estrutural?'; // "\n" = JavaScript Linebreak
$BL['be_func_struct_open']              = 'abrir';
$BL['be_func_struct_close']             = 'fechar';
$BL['be_func_struct_empty']             = 'vazio ';

// article.contenttype.inc.php
$BL['be_ctype_plaintext']               = 'texto normal';
$BL['be_ctype_html']                    = 'html';
$BL['be_ctype_code']                    = 'c�digo';
$BL['be_ctype_textimage']               = 'texto c/ imagem';
$BL['be_ctype_images']                  = 'imagens';
$BL['be_ctype_bulletlist']              = 'Lista Simples';
$BL['be_ctype_ullist']                          = 'lista';
$BL['be_ctype_link']                    = 'link &amp; email';
$BL['be_ctype_linklist']                = 'link listagem';
$BL['be_ctype_linkarticle']             = 'link artigo';
$BL['be_ctype_multimedia']              = 'multim�dia';
$BL['be_ctype_filelist']                = 'listagem de arquivos';
$BL['be_ctype_emailform']               = 'formul�rio de email';
$BL['be_ctype_newsletter']              = 'boletim de not�cias';

// profile.create.inc.php
$BL['be_profile_create_success']        = 'Perfil criado com sucesso.';
$BL['be_profile_create_error']          = 'Ocorreu um erro ao criar o perfil.';

// profile.update.inc.php
$BL['be_profile_update_success']        = 'Dados do perfil actualizados com sucesso.';
$BL['be_profile_update_error']          = 'Ocorreu um erro durante a actualiza��o do perfil.';

// profile.updateaccount.inc.php
$BL['be_profile_account_err1']          = 'o utilizador {VAL} � inv�lido';
$BL['be_profile_account_err2']          = 'senha muito curta (apenas {VAL} caracteres: pelo menos 5 s�o necess�rios)';
$BL['be_profile_account_err3']          = 'a repeti��o da senha t�m de ser igual � primeira';
$BL['be_profile_account_err4']          = 'o email {VAL} � inv�lido';

// profile.data.tmpl.php
$BL['be_profile_data_title']            = 'os seus dados pessoais';
$BL['be_profile_data_text']             = 'os dados pessoais s�o opcionais. Isto pode ajudar outros usu�rios ou visitantes do local a conhecer melhor quais os seus interesses e habilidades. Se voc� selecionar os usu�rios apropriados no checkbox estes podem ver as suas informa��es de perfil na �rea p�blica ou em p�ginas (ou n�o).';
$BL['be_profile_label_title']           = 't�tulo';
$BL['be_profile_label_firstname']       = 'nome';
$BL['be_profile_label_name']            = 'pronome';
$BL['be_profile_label_company']         = 'empresa';
$BL['be_profile_label_street']          = 'rua';
$BL['be_profile_label_city']            = 'cidade';
$BL['be_profile_label_state']           = 'prov�ncia, regi�o';
$BL['be_profile_label_zip']             = 'c�digo postal';
$BL['be_profile_label_country']         = 'pa�s';
$BL['be_profile_label_phone']           = 'telefone';
$BL['be_profile_label_fax']             = 'fax';
$BL['be_profile_label_cellphone']       = 'telem�vel';
$BL['be_profile_label_signature']       = 'assinatura';
$BL['be_profile_label_notes']           = 'notas';
$BL['be_profile_label_profession']      = 'profiss�o';
$BL['be_profile_label_newsletter']      = 'boletim de not�cias';
$BL['be_profile_text_newsletter']       = 'Eu quero receber o boletim de not�cias geral de phpwcms.';
$BL['be_profile_label_public']          = 'p�blico';
$BL['be_profile_text_public']           = 'Qualquer um deve poder ver meu perfil pessoal.';
$BL['be_profile_label_button']          = 'atualizar dados pessoais';

// profile.account.tmpl.php
$BL['be_profile_account_title']         = 'sua informa��o do in�cio da sess�o';
$BL['be_profile_account_text']          = 'Normalmente n�o � necess�rio mudar o nome de utilizador.<br />Mas a senha deve ser mudada de tempo a tempo.';
$BL['be_profile_label_err']             = 'por favor verifique';
$BL['be_profile_label_username']        = 'usu�rio';
$BL['be_profile_label_newpass']         = 'nova senha';
$BL['be_profile_label_repeatpass']      = 'repita a nova senha';
$BL['be_profile_label_email']           = 'email';
$BL['be_profile_account_button']        = 'atualizar os dados';
$BL['be_profile_label_lang']            = 'l�ngua';


// files.ftptakeover.tmpl.php
$BL['be_ftptakeover_title']             = 'enviar arquivos por ftp';
$BL['be_ftptakeover_mark']              = 'seleccionar';
$BL['be_ftptakeover_available']         = 'arquivos dispon�veis';
$BL['be_ftptakeover_size']              = 'tamanho';
$BL['be_ftptakeover_nofile']            = 'n�o existe nenhum arquivo dispon�vel &#8211; deve primeiro enviar os arquivos para a sua pasta ftp';
$BL['be_ftptakeover_all']               = 'TODOS';
$BL['be_ftptakeover_directory']         = 'Diret�rio';
$BL['be_ftptakeover_rootdir']           = 'direct�rio raiz';
$BL['be_ftptakeover_needed']            = 'necess�rio!!! (tem que escolher pelo menos 1)';
$BL['be_ftptakeover_optional']          = 'opcional';
$BL['be_ftptakeover_keywords']          = 'palavras-chave';
$BL['be_ftptakeover_additional']        = 'complementar';
$BL['be_ftptakeover_longinfo']          = 'descri��o longa';
$BL['be_ftptakeover_status']            = 'status';
$BL['be_ftptakeover_active']            = 'ativo';
$BL['be_ftptakeover_public']            = 'p�blico';
$BL['be_ftptakeover_createthumb']       = 'criar miniatura';
$BL['be_ftptakeover_button']            = 'copiar arquivo(s) selecionado(s)';

// files.reiter.tmpl.php
$BL['be_ftab_title']                    = 'CENTRO DE ARQUIVOS';
$BL['be_ftab_createnew']                = 'criar novo direct�rio na raiz';
$BL['be_ftab_paste']                    = 'colar arquivo do clipboard para o diret�rio raiz';
$BL['be_ftab_disablethumb']             = 'desligar inspec��o pr�via de miniaturas';
$BL['be_ftab_enablethumb']              = 'ligar inspec��o pr�via de miniaturas';
$BL['be_ftab_private']                  = 'arquivos privados';
$BL['be_ftab_public']                   = 'arquivos p�blicos';
$BL['be_ftab_search']                   = 'pesquisa';
$BL['be_ftab_trash']                    = 'lixeira';
$BL['be_ftab_open']                     = 'abrir todos os diret�rios';
$BL['be_ftab_close']                    = 'fechar todos os diret�rios';
$BL['be_ftab_upload']                   = 'enviar arquivo para o direct�rio raiz';
$BL['be_ftab_filehelp']                 = 'abrir p�gina de ajuda';

// files.private.newdir.tmpl.php
$BL['be_fpriv_rootdir']                 = 'direct�rio raiz';
$BL['be_fpriv_title']                   = 'criar novo direct�rio';
$BL['be_fpriv_inside']                  = 'Dentro de';
$BL['be_fpriv_error']                   = 'erro: atribua um nome ao diret�rio';
$BL['be_fpriv_name']                    = 'nome';
$BL['be_fpriv_status']                  = 'status';
$BL['be_fpriv_button']                  = 'criar novo diret�rio';

// files.private.editdir.tmpl.php
$BL['be_fpriv_edittitle']               = 'editar diret�rio';
$BL['be_fpriv_newname']                 = 'novo nome';
$BL['be_fpriv_updatebutton']            = 'atualizar os dados do diret�rio';

// files.private.upload.tmpl.php
$BL['be_fprivup_err1']                  = 'Selecione o arquivo que quer submeter';
$BL['be_fprivup_err2']                  = 'O tamanho do arquivo � maior do que';
$BL['be_fprivup_err3']                  = 'Erro ao tentar enviar o arquivo para armazenamento';
$BL['be_fprivup_err4']                  = 'Erro ao criar o diret�rio de usu�rio.';
$BL['be_fprivup_err5']                  = 'n�o existem miniaturas';
$BL['be_fprivup_err6']                  = 'Por favor n�o tente novamente - � um erro de servidor! Contacte o <a href="mailto:{VAL}">webmaster</a> o mais r�pido possivel!';
$BL['be_fprivup_title']                 = 'Enviar Arquivos';
$BL['be_fprivup_button']                = 'Enviar Arquivos';
$BL['be_fprivup_upload']                = 'Selecionar';

// files.private.editfile.tmpl.php
$BL['be_fprivedit_title']               = 'editar informa��o do arquivo';
$BL['be_fprivedit_filename']            = 'nome do Arquivo';
$BL['be_fprivedit_created']             = 'criado';
$BL['be_fprivedit_dateformat']          = 'd-m-Y H:i';
$BL['be_fprivedit_err1']                = 'reverter nome do arquivo (igual ao original)';
$BL['be_fprivedit_clockwise']           = 'gire a miniatura no sentido dos ponteiros do rel�gio [original +90&deg;]';
$BL['be_fprivedit_cclockwise']          = 'gire a miniatura no sentido contr�rio dos ponteiros do rel�gio [original -90&deg;]';
$BL['be_fprivedit_button']              = 'atualizar a informa��o do arquivo';
$BL['be_fprivedit_size']                = 'tamanho';

// files.private-functions.inc.php
$BL['be_fprivfunc_upload']              = 'copiar arquivo para o diret�rio';
$BL['be_fprivfunc_makenew']             = 'criar novo diret�rio dentro de';
$BL['be_fprivfunc_paste']               = 'colar arquivo do clipboard no diret�rio';
$BL['be_fprivfunc_edit']                = 'editar diret�rio';
$BL['be_fprivfunc_cactive']             = 'mudar vis�vel/invis�vel';
$BL['be_fprivfunc_cpublic']             = 'mudar p�blico/n�o p�blico';
$BL['be_fprivfunc_deldir']              = 'apagar diret�rio';
$BL['be_fprivfunc_jsdeldir']            = 'Tem certeza que \npretende apagar este diret�rio?';
$BL['be_fprivfunc_notempty']            = 'diret�rio {VAL} n�o est� vazio !';
$BL['be_fprivfunc_opendir']             = 'abrir diret�rio';
$BL['be_fprivfunc_closedir']            = 'fechar diret�rio';
$BL['be_fprivfunc_dlfile']              = 'descarregar arquivo';
$BL['be_fprivfunc_clipfile']            = 'arquivo do clipboard';
$BL['be_fprivfunc_cutfile']             = 'cortar';
$BL['be_fprivfunc_editfile']            = 'editar informa��o do arquivo';
$BL['be_fprivfunc_cactivefile']         = 'mudar vis�vel/invis�vel';
$BL['be_fprivfunc_cpublicfile']         = 'mudar p�blico/n�o p�blico';
$BL['be_fprivfunc_movetrash']           = 'para a lixeira';
$BL['be_fprivfunc_jsmovetrash1']        = 'Tem certeza que quer deletar';
$BL['be_fprivfunc_jsmovetrash2']        = 'para a lixeira?';

// files.private.additions.inc.php
$BL['be_fprivadd_nofolders']            = 'n�o existem arquivos ou diret�rios n�o p�blicos';

// files.public.list.tmpl.php
$BL['be_fpublic_user']                  = 'usu�rio';
$BL['be_fpublic_nofiles']               = 'n�o existem arquivos ou diret�rios publicos';

// files.private.trash.tmpl.php
$BL['be_ftrash_nofiles']                = 'a lixeira est� vazia';
$BL['be_ftrash_show']                   = 'ver arquivos n�o p�blicos';

// files.private-delfilelist.inc.php
$BL['be_ftrash_restore']                = 'Tem certeza que quer restabelecer o arquivo {VAL} \npara o diret�rio n�o p�blico?';
$BL['be_ftrash_delete']                 = 'Tem certeza que quer apagar {VAL}?';
$BL['be_ftrash_undo']                   = 'restabelecer (tirar da lixeira)';
$BL['be_ftrash_delfinal']               = 'apagamento final';

// files.search.tmpl.php
$BL['be_fsearch_err1']                  = 'o termo de pesquisa est� vazio.';
$BL['be_fsearch_title']                 = 'PESQUISA DE ARQUIVOS';
$BL['be_fsearch_infotext']              = 'Pesquisa simples para encontrar informa��es sobre arquivos. A pesquisa ser� feita pelas palavras-chave, nome do arquivo e finalmente pela descri��o longa. Wildcards s�o ignorados. Pode separar as palavras-chave com um espa�o<br /. Selecione E/OU e que arquivos pretende: pessoais/p�licos.';
$BL['be_fsearch_nonfound']              = 'N�o foi encontrado nenhum arquivo. Tente novamente e introduza outros termos ou palavras chave!';
$BL['be_fsearch_fillin']                = 'N�o foi introduzido nenhum termo para a pesquisa.';
$BL['be_fsearch_searchlabel']           = 'pesquisar';
$BL['be_fsearch_startsearch']           = 'iniciar a pesquisa';
$BL['be_fsearch_and']                   = 'E';
$BL['be_fsearch_or']                    = 'OU';
$BL['be_fsearch_all']                   = 'todos os arquivos';
$BL['be_fsearch_personal']              = 'privados';
$BL['be_fsearch_public']                = 'p�blicos';

// chat.main.tmpl.php & chat.list.tmpl.php
$BL['be_chat_title']                    = 'chat interno';
$BL['be_chat_info']                     = 'Aqui voc� pode conversar com outros usu�rios (backend) sobre tudo o que voc� quizer. Este servi�o realiza-se em tempo real, voc� pode deixar tamb�m uma mensagem que todos possam ler.';
$BL['be_chat_start']                    = 'clique aqui para iniciar a conversa';
$BL['be_chat_lines']                    = 'n�mero de linhas no chat';

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
$BL['be_msg_unread']                    = 'n�o lidas ou novas mensagens';
$BL['be_msg_lastread']                  = '�ltimas {VAL} menssagens lidas';
$BL['be_msg_lastsent']                  = '�ltimas {VAL} mensagens enviadas';
$BL['be_msg_marked']                    = 'mensagens marcadas para apagar (lixeira)';
$BL['be_msg_nomsg']                     = 'n�o foi encontrada nenhuma mensagem nesta pasta';

// message.send.tmpl.php
$BL['be_msg_RE']                        = 'RE';
$BL['be_msg_by']                        = 'enviada por';
$BL['be_msg_on']                        = 'em';
$BL['be_msg_msg']                       = 'menssagem';
$BL['be_msg_err1']                      = 'vo�� esqueceu do destin�rio...';
$BL['be_msg_err2']                      = 'preencha o assunto (assim o destin�rio pode ordenar melhor a sua mensagem)';
$BL['be_msg_err3']                      = 'n�o faz qualquer sentido enviar uma mensagem vazia ;-)';
$BL['be_msg_sent']                      = 'a mensagem foi enviada!';
$BL['be_msg_fwd']                       = 'vai ser redirecionado para o centro de mensagens ou';
$BL['be_msg_newmsgtitle']               = 'escreva uma nova mensagem';
$BL['be_msg_err']                       = 'erro durante o envio da mensagem';
$BL['be_msg_sendto']                    = 'enviar mensagem para';
$BL['be_msg_available']                 = 'lista de todos os poss�veis destinat�rios';
$BL['be_msg_all']                       = 'enviar a mensagem para os destinat�rios selecionados';

// message.subscription.tmpl.php
$BL['be_newsletter_title']              = 'subscri��es do boletim de not�cias';
$BL['be_newsletter_titleedit']          = 'editar uma assinatura';
$BL['be_newsletter_new']                = 'criar novo';
$BL['be_newsletter_add']                = 'criar novo boletim de not�cias';
$BL['be_newsletter_name']               = 'nome';
$BL['be_newsletter_info']               = 'info';
$BL['be_newsletter_button_save']        = 'salvar subscri��o';
$BL['be_newsletter_button_cancel']      = 'Cancelar';

// admin.newuser.tmpl.php
$BL['be_admin_usr_err1']                = 'nome de usu�rio inv�lido, por favor escolha outro';
$BL['be_admin_usr_err2']                = 'nome de usu�rio vazio (obrigat�rio)';
$BL['be_admin_usr_err3']                = 'senha vazia (obrigat�rio)';
$BL['be_admin_usr_err4']                = "o email n�o � v�lido";
$BL['be_admin_usr_err']                 = 'erro';
$BL['be_admin_usr_mailsubject']         = 'bem vindo ao phpwcms backend';
$BL['be_admin_usr_mailbody']            = "BEM VINDO AO BACKEND DO PHPWCMS\n\n    usu�rio: {LOGIN}\n    senha: {PASSWORD}\n\n\nVo�� pode ligar-se em: {LOGIN_PAGE}\n\nphpwcms admin\n ";
$BL['be_admin_usr_title']               = 'criar novo usu�rio';
$BL['be_admin_usr_realname']            = 'nome real';
$BL['be_admin_usr_setactive']           = 'ativar';
$BL['be_admin_usr_iflogin']             = 'se activar o usu�rio pode entrar';
$BL['be_admin_usr_isadmin']             = 'o usu�rio � o administrador';
$BL['be_admin_usr_ifadmin']             = 'se estiver marcado o usu�rio tem direitos de administra��o';
$BL['be_admin_usr_verify']              = 'verifica��o';
$BL['be_admin_usr_sendemail']           = 'enviar uma mensagem para o novo usu�rio com os dados da conta';
$BL['be_admin_usr_button']              = 'enviar dados do usu�rio';

// admin.edituser.tmpl.php
$BL['be_admin_usr_etitle']              = 'editar conta do usu�rio';
$BL['be_admin_usr_emailsubject']        = 'phpwcms - dados da conta alterados';
$BL['be_admin_usr_mailbody']            = "Seja Bem vindo ao Splash Buum - Segue abaixo seus dados de acesso:\n\n    usu�rio: {LOGIN}\n    senha: {PASSWORD}\n\n\nVoc� pode se logar em: http://www.splashbuum.com.br/index.php?Convite-Online\n\nObrigado - Splash Buum Buffet\n\n ";
$BL['be_admin_usr_passnochange']        = '[N�O MUDAR - UTILIZAR A MESMA]';
$BL['be_admin_usr_ebutton']             = 'atualizar dados do usu�rio';

// admin.listuser.tmpl.php
$BL['be_admin_usr_ltitle']              = 'phpwcms lista de usu�rios';
$BL['be_admin_usr_ldel']                = 'ATEN��O!&#13O isto vai apagar o usu�rio';
$BL['be_admin_usr_create']              = 'criar novo usu�rio';
$BL['be_admin_usr_editusr']             = 'editar usu�rio';

// admin.structform.tmpl.php
$BL['be_admin_struct_title']            = 'Estrutura do Site';
$BL['be_admin_struct_child']            = '(parente de)';
$BL['be_admin_struct_index']            = 'index (in�cio do website)';
$BL['be_admin_struct_cat']              = 'titulo da categoria';
$BL['be_admin_struct_hide1']            = 'escondido';
$BL['be_admin_struct_hide2']            = 'ver na estrutura do menu';
$BL['be_admin_struct_info']             = 'informa��o sobre a categoria';
$BL['be_admin_struct_template']         = 'modelo (template)';
$BL['be_admin_struct_alias']            = 'atalho (alias) da categoria';
$BL['be_admin_struct_visible']          = 'vis�vel';
$BL['be_admin_struct_button']           = 'enviar dados da categoria';
$BL['be_admin_struct_close']            = 'fechar';

// admin.filecat.tmpl.php
$BL['be_admin_fcat_title']              = 'categorias de arquivos';
$BL['be_admin_fcat_err']                = 'o nome da categoria est� vazio!';
$BL['be_admin_fcat_name']               = 'nome da categoria';
$BL['be_admin_fcat_needed']             = 'necess�rio';
$BL['be_admin_fcat_button1']            = 'atualizar';
$BL['be_admin_fcat_button2']            = 'criar';
$BL['be_admin_fcat_delmsg']             = 'Tem a certeza que quer apagar \n a chave do arquivo?';
$BL['be_admin_fcat_fcat']               = 'arquivo da categoria';
$BL['be_admin_fcat_err1']               = 'a chave do arquivo est� vazia!';
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
$BL['be_admin_page_title']              = 'instala��o do frontend: layout da p�gina';
$BL['be_admin_page_align']              = 'alinhamento da p�gina';
$BL['be_admin_page_align_left']         = 'alinhamento da p�gina a esquerda (normal)';
$BL['be_admin_page_align_center']       = 'alinhamento da p�gina ao centro';
$BL['be_admin_page_align_right']        = 'alinhamento da p�gina � direita';
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
$BL['be_admin_page_leftspace']          = 'espa�o � esquerda';
$BL['be_admin_page_rightspace']         = 'espa�o � direita';
$BL['be_admin_page_class']              = 'class';
$BL['be_admin_page_image']              = 'imagem';
$BL['be_admin_page_text']               = 'texto';
$BL['be_admin_page_link']               = 'link';
$BL['be_admin_page_js']                 = 'javascript';
$BL['be_admin_page_visited']            = 'visited';
$BL['be_admin_page_pagetitle']          = 'T�tulo SEO';
$BL['be_admin_page_addtotitle']         = 'adicionar ao titulo';
$BL['be_admin_page_category']           = 'categoria';
$BL['be_admin_page_articlename']        = 'nome da p�gina';
$BL['be_admin_page_blocks']             = 'bloco';
$BL['be_admin_page_allblocks']          = 'tudo blocos';
$BL['be_admin_page_col1']               = 'layout de 3 colunas';
$BL['be_admin_page_col2']               = 'layout de 2 colunas (navega��o a esquera)';
$BL['be_admin_page_col3']               = 'layout de 2 colunas (navega��o a direita)';
$BL['be_admin_page_col4']               = 'layout de 1 coluna';
$BL['be_admin_page_header']             = 'cabe�alho';
$BL['be_admin_page_footer']             = 'rodap�';
$BL['be_admin_page_topspace']           = 'espa�o&nbsp;em&nbsp;cima';
$BL['be_admin_page_bottomspace']        = 'espa�o&nbsp;em&nbsp;baixo';
$BL['be_admin_page_button']             = 'gravar layout da p�gina';

// admin.frontendcss.tmpl.php
$BL['be_admin_css_title']               = 'arranjo do frontend: dados da css';
$BL['be_admin_css_css']                 = 'css';
$BL['be_admin_css_button']              = 'gravar arquivo css';

// admin.templates.tmpl.php
$BL['be_admin_tmpl_title']              = 'frontend setup: modelos';
$BL['be_admin_tmpl_default']            = 'Padr�o';
$BL['be_admin_tmpl_add']                = 'adicionar modelo';
$BL['be_admin_tmpl_edit']               = 'editar modelo';
$BL['be_admin_tmpl_new']                = 'criar novo modelo';
$BL['be_admin_tmpl_css']                = 'arquivo css';
$BL['be_admin_tmpl_head']               = 'cabe�alho html (HEAD)';
$BL['be_admin_tmpl_js']                 = 'js onload';
$BL['be_admin_tmpl_error']              = 'erro';
$BL['be_admin_tmpl_button']             = 'salvar modelo';
$BL['be_admin_tmpl_name']               = 'nome';

// article.structlist.tmpl.php
$BL['be_article_title']                 = 'ESTRUTURA DE MENU E P�GINAS DO SITE';

// article.new.tmpl.php
$BL['be_article_err1']                  = 'o titulo para esta p�gina est� vazio';
$BL['be_article_err2']                  = 'a data de in�cio est� errada - ajuste-a agora';
$BL['be_article_err3']                  = 'a data do fim est� errada - ajuste-a agora';
$BL['be_article_title1']                = 'informa��o base da p�gina';
$BL['be_article_cat']                   = 'categoria';
$BL['be_article_atitle']                = 't�tulo da p�gina';
$BL['be_article_asubtitle']             = 'subt�tulo';
$BL['be_article_abegin']                = 'come�a';
$BL['be_article_aend']                  = 'termina';
$BL['be_article_aredirect']             = 'redirecionar para';
$BL['be_article_akeywords']             = 'palavras-chave';
$BL['be_article_asummary']              = 'sum�rio';
$BL['be_article_abutton']               = 'criar artigo';

// article.editcontent.inc.php
$BL['be_article_err4']                  = 'a data de finaliza��o estava errada - foi ajustada para +1 semana';

// article.editsummary.tmpl.php
$BL['be_article_estitle']               = 'editar informa��o base da p�gina';
$BL['be_article_eslastedit']            = 'ultima actualiza��o';
$BL['be_article_esnoupdate']            = 'formul�rio n�o atualizado';
$BL['be_article_esbutton']              = 'atualizar dados do arquivo';

// articlecontent.edit.tmpl.php
$BL['be_article_cnt_title']             = 'conte�do da p�gina';
$BL['be_article_cnt_type']              = 'tipo de cont�udo';
$BL['be_article_cnt_space']             = 'espa�o';
$BL['be_article_cnt_before']            = 'antes';
$BL['be_article_cnt_after']             = 'depois';
$BL['be_article_cnt_top']               = 'topo';
$BL['be_article_cnt_ctitle']            = 't�tulo do conte�do';
$BL['be_article_cnt_back']              = 'informa��o completa da p�gina';
$BL['be_article_cnt_button1']           = 'Atualizar Conte�do';
$BL['be_article_cnt_button2']           = 'criar conte�do';

// articlecontent.list.tmpl.php
$BL['be_article_cnt_ltitle']            = 'INFORMA��O SOBRE A P�GINA ';
$BL['be_article_cnt_ledit']             = 'editar p�gina';
$BL['be_article_cnt_lvisible']          = 'mudar vis�vel / invis�vel';
$BL['be_article_cnt_ldel']              = 'apagar esta p�gina';
$BL['be_article_cnt_ldeljs']            = 'Apagar p�gina?';
$BL['be_article_cnt_redirect']          = 'redirecionamento';
$BL['be_article_cnt_edited']            = 'editado por';
$BL['be_article_cnt_start']             = 'data de in�cio';
$BL['be_article_cnt_end']               = 'data de finaliza��o';
$BL['be_article_cnt_add']               = 'adicionar nova parte ao conte�do';
$BL['be_article_cnt_up']                = 'mover conte�do para cima';
$BL['be_article_cnt_down']              = 'mover conte�do para baixo';
$BL['be_article_cnt_edit']              = 'editar parte do conte�do';
$BL['be_article_cnt_delpart']           = 'apagar esta parte da p�gina';
$BL['be_article_cnt_delpartjs']         = 'Apagar esta parte do conte�do?';
$BL['be_article_cnt_center']            = 'P�GINAS DO SITE';

// content forms
$BL['be_cnt_plaintext']                 = 'texto simples';
$BL['be_cnt_htmltext']                  = 'texto html';
$BL['be_cnt_image']                     = 'imagem';
$BL['be_cnt_position']                  = 'posi��o';
$BL['be_cnt_pos0']                      = 'Acima, esquerda';
$BL['be_cnt_pos1']                      = 'Acima, centro';
$BL['be_cnt_pos2']                      = 'Acima, direita';
$BL['be_cnt_pos3']                      = 'Abaixo, esquerda';
$BL['be_cnt_pos4']                      = 'Abaixo, centro';
$BL['be_cnt_pos5']                      = 'Abaixo, direita';
$BL['be_cnt_pos6']                      = 'No texto, esquerda';
$BL['be_cnt_pos7']                      = 'No texto, direita';
$BL['be_cnt_pos0i']                     = 'alinhar a imagem acima e � esquerda do bloco de texto';
$BL['be_cnt_pos1i']                     = 'alinhar a imagem acima e ao centro do bloco de texto';
$BL['be_cnt_pos2i']                     = 'alinhar a imagem acima e � direita do bloco de texto';
$BL['be_cnt_pos3i']                     = 'alinhar a imagem abaixo e � esquerda do bloco de texto';
$BL['be_cnt_pos4i']                     = 'alinhar a imagem abaixo e ao centro do bloco de texto';
$BL['be_cnt_pos5i']                     = 'alinhar a imagem abaixo e � direita do bloco de texto';
$BL['be_cnt_pos6i']                     = 'alinhar a imagem � esquerda dentro do bloco de texto';
$BL['be_cnt_pos7i']                     = 'alinhar a imagem � direita dentro do bloco de texto';
$BL['be_cnt_maxw']                      = 'largura&nbsp;max.';
$BL['be_cnt_maxh']                      = 'altura&nbsp;max.';
$BL['be_cnt_enlarge']                   = 'clicar&nbsp;ampliar';
$BL['be_cnt_caption']                   = 'legenda';
$BL['be_cnt_subject']                   = 'assunto';
$BL['be_cnt_recipient']                 = 'destinat�rio';
$BL['be_cnt_buttontext']                = 'texto do bot�o';
$BL['be_cnt_sendas']                    = 'enviar como';
$BL['be_cnt_text']                      = 'texto';
$BL['be_cnt_html']                      = 'html';
$BL['be_cnt_formfields']                = 'campos do formul�rio';
$BL['be_cnt_code']                      = 'c�digo';
$BL['be_cnt_infotext']                  = 'texto&nbsp;de&nbsp;informa��o';
$BL['be_cnt_subscription']              = 'subscri��o';
$BL['be_cnt_labelemail']                = 'etiqueta&nbsp;email';
$BL['be_cnt_tablealign']                = 'alinhamento&nbsp;da&nbsp;tabela';
$BL['be_cnt_labelname']                 = 'etiqueta&nbsp;name';
$BL['be_cnt_labelsubsc']                = 'etiqueta&nbsp;subscr.';
$BL['be_cnt_allsubsc']                  = 'todas&nbsp;subsc..';
$BL['be_cnt_default']                   = 'default';
$BL['be_cnt_left']                      = 'esquerda';
$BL['be_cnt_center']                    = 'centro';
$BL['be_cnt_right']                     = 'direita';
$BL['be_cnt_buttontext']                = 'texto do bot�o';
$BL['be_cnt_successtext']               = 'texto&nbsp;do&nbsp;sucesso';
$BL['be_cnt_regmail']                   = 'regist.email';
$BL['be_cnt_logoffmail']                = 'logoff.email';
$BL['be_cnt_changemail']                = 'mudar.email';
$BL['be_cnt_openimagebrowser']          = 'abrir browser de imagem';
$BL['be_cnt_openfilebrowser']           = 'abrir browser de arquivos';
$BL['be_cnt_sortup']                    = 'mova para cima';
$BL['be_cnt_sortdown']                  = 'mova para baixo';
$BL['be_cnt_delimage']                  = 'remover imagem selecionada';
$BL['be_cnt_delfile']                   = 'remover arquivo selecionado';
$BL['be_cnt_delmedia']                  = 'remover media selecionada';
$BL['be_cnt_column']                    = 'coluna';
$BL['be_cnt_imagespace']                = 'imagem&nbsp;espa�o';
$BL['be_cnt_directlink']                = 'link directo';
$BL['be_cnt_target']                    = 'alvo';
$BL['be_cnt_target1']                   = 'numa janela nova';
$BL['be_cnt_target2']                   = 'no frame parente da janela';
$BL['be_cnt_target3']                   = 'na mesma janela sem frames';
$BL['be_cnt_target4']                   = 'no mesmo frame ou janela';
$BL['be_cnt_bullet']                    = 'lists (tabela)';
$BL['be_cnt_ullist']                            = 'lista';
$BL['be_cnt_ullist_desc']                   = '~ = 1� n�vel, &nbsp; ~~ = 2� n�vel, &nbsp; etc.';
$BL['be_cnt_linklist']                  = 'listagem de links';
$BL['be_cnt_plainhtml']                 = 'simplesmente html';
$BL['be_cnt_files']                     = 'arquivos';
$BL['be_cnt_description']               = 'descri��o';
$BL['be_cnt_linkarticle']               = 'link para artigo';
$BL['be_cnt_articles']                  = 'P�GINAS';
$BL['be_cnt_movearticleto']             = 'mover artigo selecionado para a listagem de links';
$BL['be_cnt_removearticleto']           = 'eliminar artigo selecionado para da listagem de links';
$BL['be_cnt_mediatype']                 = 'tipo de media';
$BL['be_cnt_control']                   = 'controle';
$BL['be_cnt_showcontrol']               = 'mostrar barra de controle';
$BL['be_cnt_autoplay']                  = 'in�cio autom�tico';
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
$BL['form_force_ssl']                   = 'For�ar envio com SSL';
// added: 28-12-2003
$BL['be_admin_page_add']                = 'criar novo modelo';
$BL['be_admin_page_name']               = 'nome do modelo';
$BL['be_admin_page_edit']               = 'editar modelo';
$BL['be_admin_page_render']             = 'renderiza��o';
$BL['be_admin_page_table']              = 'tabela';
$BL['be_admin_page_div']                = 'css div';
$BL['be_admin_page_custom']             = 'personalizado';
$BL['be_admin_page_custominfo']         = 'a partir do bloco main';
$BL['be_admin_tmpl_layout']             = 'modelo';
$BL['be_admin_tmpl_nolayout']           = 'n�o existem modelos!';

// added: 31-12-2003
$BL['be_ctype_search']                  = 'pesquisa';
$BL['be_cnt_results']                   = 'resultados';
$BL['be_cnt_results_per_page']          = 'por&nbsp;p�gina (se vazio, mostra todos)';
$BL['be_cnt_opennewwin']                = 'abrir nova janela';
$BL['be_cnt_searchlabeltext']           = 'estes s�o valores e dados predefinidos para o formul�rio de pesquisa quando forem encontrados mais do que os resultados desejados por p�gina.';
$BL['be_cnt_input']                     = 'entrada';
$BL['be_cnt_style']                     = 'estilo';
$BL['be_cnt_result']                    = 'resultado';
$BL['be_cnt_next']                      = 'pr�ximo';
$BL['be_cnt_previous']                  = 'anterior';
$BL['be_cnt_align']                     = 'alinhamento';
$BL['be_cnt_searchformtext']            = 'o seguinte texto aparece no in�cio do formul�rio e quando n�o existem resultados durante a pesquisa.';
$BL['be_cnt_intro']                     = 'texto de entrada';
$BL['be_cnt_noresult']                  = 'sem resultado';

// added: 02-01-2004
$BL['be_admin_page_disable']            = 'desligado';

// added: 09-01-2004
$BL['be_article_articleowner']          = 'propriet�rio da p�gina';
$BL['be_article_adminuser']             = 'usu�rio administrativo';
$BL['be_article_username']              = 'autor';

// added: 10-01-2004
$BL['be_ctype_wysywig']                 = 'EDITOR DE TEXTOS';

// added, changed: 11-01-2004
$BL['be_admin_struct_regonly']          = 'visivel apenas por usu�rios registados/ligados';
$BL['be_admin_struct_status']           = 'status no frontend';

// added: 15-02-2004
$BL['be_ctype_articlemenu']                             = 'menu de artigos';
$BL['be_cnt_sitelevel']                                 = 'n�vel do site';
$BL['be_cnt_sitecurrent']                               = 'n�vel actual do site';

// added: 24-03-2004
$BL['be_subnav_admin_starttext']                = 'texto por defeito no backend';
$BL['be_ctype_ecard']                                   = 'e-card';
$BL['be_ctype_blog']                                    = 'blog';
$BL['be_cnt_ecardtext']                 = 'titulo/e-card';
$BL['be_cnt_ecardtmpl']                 = 'mail tmpl';
$BL['be_cnt_ecard_image']               = 'e-card imagem';
$BL['be_cnt_ecard_title']               = 'e-card titulo';
$BL['be_cnt_alignment']                 = 'alinhamento';
$BL['be_cnt_ecardform']                 = 'formulario tmpl';
$BL['be_cnt_ecardform_err']             = 'Os campos marcados com * s�o obrigat�rios';
$BL['be_cnt_ecardform_sender']          = 'Remetente';
$BL['be_cnt_ecardform_recipient']       = 'Destinat�rio';
$BL['be_cnt_ecardform_name']            = 'Nome';
$BL['be_cnt_ecardform_msgtext']         = 'A sua mensagem para o destinat�rio';
$BL['be_cnt_ecardform_button']          = 'enviar e-card';
$BL['be_cnt_ecardsend']                 = 'enviar tmpl';

// added: 28-03-2004
$BL['be_admin_startup_title']           = 'Texto inicial por defeito do backend';
$BL['be_admin_startup_text']            = 'texto de entrada';
$BL['be_admin_startup_button']          = 'salvar texto de entrada';

// added: 17-04-2004
$BL['be_ctype_guestbook']                               = 'livro de visitas/coment�rio.';
$BL['be_cnt_guestbook_listing']                 = 'listagem';
$BL['be_cnt_guestbook_listing_all']             = 'mostrar&nbsp;todas&nbsp;as&nbsp;entradas';
$BL['be_cnt_guestbook_list']                    = 'lista';
$BL['be_cnt_guestbook_perpage']                 = 'por&nbsp;p�gina';
$BL['be_cnt_guestbook_form']                    = 'form';
$BL['be_cnt_guestbook_signed']                  = 'assinado';
$BL['be_cnt_guestbook_nav']                             = 'nav';
$BL['be_cnt_guestbook_before']                  = 'anterior';
$BL['be_cnt_guestbook_after']                   = 'pr�xima';
$BL['be_cnt_guestbook_entry']                   = 'entrada';
$BL['be_cnt_guestbook_edit']                    = 'editar';
$BL['be_cnt_ecardform_selector']        = 'seletor';
$BL['be_cnt_ecardform_radiobutton']     = 'radio button';
$BL['be_cnt_ecardform_javascript']      = 'Funcionalidade JavaScript';
$BL['be_cnt_ecardform_over']            = 'onMouseOver';
$BL['be_cnt_ecardform_click']           = 'onClick';
$BL['be_cnt_ecardform_out']                     = 'onMouseOut';
$BL['be_admin_struct_topcount']         = 'Contagem superior da p�gina';

// added: 19-04-2004
$BL['be_subnav_msg_newslettersend']     = 'boletim de not�cias';
$BL['be_newsletter_addnl']              = 'adicionar boletim de not�cias';
$BL['be_newsletter_titleeditnl']        = 'editar boletim de not�cias';
$BL['be_newsletter_newnl']              = 'criar novo';
$BL['be_newsletter_button_savenl']      = 'salvar boletim de not�cias';
$BL['be_newsletter_fromname']           = 'de: nome';
$BL['be_newsletter_fromemail']          = 'de: email';
$BL['be_newsletter_replyto']            = 'enviar para email';
$BL['be_newsletter_changed']            = '�ltima altera��o';
$BL['be_newsletter_placeholder']        = 'placeholder';
$BL['be_newsletter_htmlpart']           = 'Conte�do HTML do boletim de not�cias';
$BL['be_newsletter_textpart']           = 'Conte�do TEXTO do boletim de not�cias';
$BL['be_newsletter_allsubscriptions']   = 'todas os subscritores';
$BL['be_newsletter_verifypage']         = 'verificar link';
$BL['be_newsletter_open']               = 'HTML e TEXTO entrada';
$BL['be_newsletter_open1']              = '(clique na imagem para abrir)';
$BL['be_newsletter_sendnow']            = 'Enviar boletim de not�cias';
$BL['be_newsletter_attention']          = '<strong style="color:#CC3300;">Aten��o!</strong> Enviar o boletim de not�cias para multiplos destinat�rios � uma tarefa �rdua para o servidor. Os destinat�rios devem ter sido analizados e verificados para ter a certeza que n�o vai email indesejados. Pense duas vezes antes de enviar o boletim de not�cias. Verifique o boletim de not�cias enviando um teste primeiro.';
$BL['be_newsletter_attention1']         = 'Se fez quaisquer altera��es no boletim de not�cias em cima, por favor guarde as altera��es primeiro, ou as altera��es ser�o ignoradas.'; 
$BL['be_newsletter_testemail']          = 'testar email';
$BL['be_newsletter_sendnlbutton']       = 'enviar boletim de not�cias';
$BL['be_newsletter_sendprocess']        = 'envio em processamento';
$BL['be_newsletter_attention2']         = '<strong style="color:#CC3300;">Aten��o!</strong> Por favor n�o pare o processo de envio. Se o fizer o mesmo destinat�rio pode receber duas c�pias do boletim de not�cias. Se o envio falhar, os destinat�rios em falta ser�o registados podendo efectuar o envio posteriormente.';
$BL['be_newsletter_testerror']          = '<span style="color:#CC3300;font-size:11px;">o endere�o de email para o envio do teste <strong>###TEST###</strong> N�O � valido!<br />&nbsp;<br />Por favor tente novamente!';
$BL['be_newsletter_to']                 = 'Destinat�rios';
$BL['be_newsletter_ready']              = 'enviando boletim de not�cias: CONCLU�DO';
$BL['be_newsletter_readyfailed']        = 'Falhou o envio do boletim de not�cias para';
$BL['be_subnav_msg_subscribers']        = 'subscritores do boletim de not�cias';

// added: 20-04-2004
$BL['be_ctype_sitemap']                             = 'mapa do site';
$BL['be_cnt_sitemap_catimage']          = 'icon da categoria';
$BL['be_cnt_sitemap_articleimage']      = 'icon da p�gina';
$BL['be_cnt_sitemap_display']           = 'mostrar';
$BL['be_cnt_sitemap_structuronly']      = 'estrutura das categorias';
$BL['be_cnt_sitemap_structurarticle']   = 'estrutura das categorias + artigos';
$BL['be_cnt_sitemap_catclass']          = '(css) class das categorias';
$BL['be_cnt_sitemap_articleclass']      = '(css) class dos artigos';
$BL['be_cnt_sitemap_count']             = 'contador';
$BL['be_cnt_sitemap_classcount']        = 'adicionar ao nome da class';
$BL['be_cnt_sitemap_noclasscount']      = 'n�o adicionar ao nome da class';

// added: 23-04-2004
$BL['be_ctype_bid']                                     = 'oferta';
$BL['be_cnt_bid_bidtext']               = 'texto da oferta';
$BL['be_cnt_bid_sendtext']              = 'texto enviado';
$BL['be_cnt_bid_verifiedtext']          = 'texto para verifica��o';
$BL['be_cnt_bid_errortext']             = 'oferta apagada';
$BL['be_cnt_bid_verifyemail']           = 'verificar email';
$BL['be_cnt_bid_startbid']              = 'iniciar oferta';

// added: 29-04-2004
$BL['be_cnt_bid_nextbidadd']            = 'aumentar&nbsp;por';

// added: 10-05-2004
$BL['be_ctype_pages']                   = 'conte�do ext.';
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
$BL['be_cnt_reference_aligntext']       = 'imagens pequenas de refer�ncia';
$BL['be_cnt_reference_largetext']       = 'imagens grandes de refer�ncia';
$BL['be_cnt_reference_zoom']            = 'zoom';
$BL['be_cnt_reference_middle']          = 'meio';
$BL['be_cnt_reference_border']          = 'border';
$BL['be_cnt_reference_block']           = 'bloco w x h';

// added: 31-05-2004
$BL['be_article_rendering']             = 'rendring';
$BL['be_article_nosummary']             = 'n�o mostrar o sum�rio com a p�gina completa';
$BL['be_article_forlist']               = 'lista de p�ginas';
$BL['be_article_forfull']               = 'mostrar artigo completo';
$BL['be_acat_disable301']				= 'article 301 redirect';




$BL['be_fileuploader_uploadButtonText'] = 'Selecione seus Arquivos ou Arraste aqui';
//Boletim de Not�cias
$BL['be_cnt_export_selection']			= 'Exportar Selecionados';
$BL['be_cnt_delete_duplicates']			= 'Deletar Duplicados';
$BL['be_cnt_new_recipient']				= 'Add E-mail';


$BL['be_cnt_newsletter_prepare']		= 'newsletter active';
$BL['be_cnt_newsletter_prepare1']		= 'all recipients will be taken over to sending queue';
$BL['be_cnt_newsletter_prepare2']		= 'sending queue will be updated&#8230;';


//Colocados Manualmente - 21-06-2012
$BL['be_file_replace'] = 'Substituir arquivos existentes';
$BL['be_func_content_copy']              = 'copiar esta parte de conte�do';
$BL['be_cnt_css_style']                  = 'Place Holder';
$BL['be_cnt_css_class']                  = 'Tags HTML5';
$BL['be_file_multiple_upload']           = 'Carregar V�rios Arquivos';
$BL['be_ctype']                          = 'Partes de Conte�do';
$BL['be_last_edited']                    = '�ltimos editados';
$BL['be_article_cnt_button3']            = 'Salvar e Fechar';
$BL['be_cnt_results_wordlimit']          = 'N� max�mo de palavras';
$BL['be_article_urlalias']               = 'URL Amig�vel';
$BL['be_article_noteaser']               = 'Sem Template';
$BL['be_granted_feuser']                 = 'Somente para usu�rios logados';
$BL['be_func_switch_contentpart'] = 'Voc� realmente deseja trocar o tipo de conte�do? \n\nIsso ir� DELETAR o conte�do atual!\n';
$BL['be_cnt_same_as_summary']            = 'Usar imagem do artigo';
$BL['be_admin_struct_orderdesc']        = 'decrescente';
$BL['be_admin_struct_orderasc']         = 'crescente';
$BL['be_admin_struct_orderarticle']     = 'Ordenar por';
$BL['be_admin_struct_orderdate']        = 'data cria��o';
$BL['be_admin_struct_orderchangedate']  = 'data altera��o';
$BL['be_admin_struct_orderstartdate']   = 'data in�cio';
$BL['be_admin_struct_ordermanual']      = 'manual (arrow up/down)';
$BL['be_cnt_sitemap_startid']           = 'Come�a em';
$BL['be_admin_struct_orderkilldate']    = 'data t�rmino';
$BL['be_delete_selected_files']         = 'Deletar arquivos selecionados';
$BL['be_fileuploader_dragText']         = "Solte seus arquivos aqui para carrega-los.";
$BL['be_news']                          = 'Not�cias';
$BL['be_cnt_type']                      = 'tipo';
$BL['be_cnt_last_edited']               = '�ltima altera��o';
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
$BL['be_cnt_search_hidesummary']        = 'Esconder descri��o';
$BL['be_cnt_search_searchnot']	        ='N�o procurar por';
$BL['be_settings']			         	= 'Configura��es';
$BL['be_cnt_field']						= array("text"=>'Texto (Linha Simples)', 
												"email"=>'E-mail', 
												"textarea"=>'Caixa de Texto (Linhas M�ltiplas)', 
												"hidden"=>'Invisivel', 
												"password"=>'Senha', 
												"select"=>'Menu de Sele��o', 
												"list"=>'Lista de Menu', 
												"checkbox"=>'Caixa de Sele��o', 
												"radio"=>'Caixa de Op��o', 
												"upload"=>'Arquivo', 
												"submit"=>'Bot�o Enviar', 
												"reset"=>'Bot�o Limpar', 
												"break"=>'Data HTML5', "breaktext"=>'Telefone HTML5', 
												"special"=>'Texto (Especial)',
												"captchaimg"=>'Imagem de Verifica��o', 
												"captcha"=>'C�digo de Verica��o', 
												'newsletter'=>'Newsletter',
												'selectemail'=>'Sele��o de Email', 
												'country'=>'Sele��o de Pa�s',
												'mathspam'=>'Protetor de Spam', 
												'summing'=>'summing', 
												'subtract'=>'Subtrair', 
												'divide'=>'divide', 'multiply'=>'Multiplicar', 
												'calculation'=>'Calcular:',
												'formtracking_off'=>'Desativar Rastreador', 
												'checktofrom'=>'E-mail do destinat�rio deve ser diferente do remetente',
												'recaptcha'=>'Repetir Verifica��o',
												'recaptcha_signapikey'=>'Cadastre-se para Receber uma Chave de Verifica��o');

$BL['be_subnav_file_actions']           = 'Editar arquivos';
$BL['file_actions_step1']				= "Passo 1: Escolha a Pasta";
$BL['file_actions_step2']				= "Passo 2: Selecione os arquivos";
$BL['file_actions_step3']				= "Passo 3: Selecione a A��o";
$BL['file_actions_button']				= 'Executar';
$BL['file_actions_no']					= 'Pasta vazia. Por favor escolha outra pasta';
$BL['file_actions_delete']				= 'Tem certeza que deseja deletar os arquivos selecionados?';
$BL['file_actions_bemuser']				= 'Os arquivos selecionados ser�o designados para o novo usu�rio e foram movidos para a sua raiz.';
$BL['file_actions_bemfolder']			= 'Por favor selecione a nova pasta de destino. <br/>Os arquivos selecionados ser�o movidos para esta pasta. ';
$BL['file_actions_pdl_empty']			= 'Selecione a A��o';
$BL['file_actions_pdl_delete']			= 'Deletar arquivos';
$BL['file_actions_pdl_move']			= 'Mover arquivos';
$BL['file_actions_pdl_status']			= 'Mudar Status';
$BL['file_actions_pdl_user']			= 'Mudar Propriet�rio';
$BL['file_actions_msg_move']			= 'Os arquivos foram movidos com sucesso';
$BL['file_actions_msg_delete']			= 'Os arquivos foram deletados com sucesso';
$BL['file_actions_msg_status']			= 'O status dos arquivos foram alterados com sucesso';
$BL['file_actions_msg_error']			= 'Nenhum arquivo selecionado';
$BL['file_actions_msg_user']			= 'Os arquivos foram designados para o novo usu�rio com sucesso';

?>