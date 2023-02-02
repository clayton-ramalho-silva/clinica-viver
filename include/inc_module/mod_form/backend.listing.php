<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2013, Oliver Georgi
 * @license http://opensource.org/licenses/GPL-2.0 GNU GPL-2
 * @link http://www.phpwcms.de
 *
 **/

// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------

//Carrega as informacoes do necessárias
require_once PHPWCMS_ROOT.'/include/inc_lib/dbcon.inc.php';
require PHPWCMS_ROOT.'/include/inc_front/js.inc.php';

//Conexão com o banco de dados
$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'] , $phpwcms['db_table'] ); 

//Carrega as informações dos artigos do banco de dados
$consulta_content = 'SELECT * FROM phpwcms_articlecontent WHERE acontent_id IS NOT NULL';
$conteudo = mysqli_query($conexao, $consulta_content);

$consulta_artigo = 'SELECT art.article_id, art.article_title, art.article_cid, cat.acat_id FROM phpwcms_article AS art LEFT JOIN phpwcms_articlecat AS cat ON art.article_cid=cat.acat_id WHERE article_id IS NOT NULL';
$artigo = mysqli_query($conexao, $consulta_artigo);

// Gera o id da parte de conteúdo 
$consulta_id = 'SELECT acontent_id FROM phpwcms_articlecontent ORDER BY acontent_id DESC LIMIT 1';
$id = mysqli_query($conexao, $consulta_id);
$ultimo_id = mysqli_fetch_array($id);
$ultimo = $ultimo_id['acontent_id'];
$total = $ultimo + 1;

// Busca as informações de tags
$sql  = "SELECT pagelayout_var FROM ".DB_PREPEND."phpwcms_pagelayout WHERE pagelayout_trash=0 ORDER BY pagelayout_default DESC LIMIT 1";
$result = _dbQuery($sql);
$pagelayout = @unserialize($result[0]['pagelayout_var']); 	
$val = explode(', ', $pagelayout['layout_customblocks']);

// Início do formulário de criação
$email = strlen($phpwcms['admin_email']);
$enderecoimg = 'http://'.PHPWCMS_HOST.'/images/img-form.jpg';
$nome_empresa = strlen('http://'.PHPWCMS_HOST.'/images/img-form.jpg');
$total_form_resposta = 1465 + $totalenderecoimg;
$totalformrespostarighttitulo = 1401 + $totalenderecoimg;
$totalformrespostarightimagem = 1548 + $totalenderecoimg;
//$totalid = strlen($total);

/********* Informações dos tipos de formulários *********/

// Início Formulário Padrão
$form_padrao = utf8_decode('a:39:{s:7:"subject";s:39:"Nome da Empresa - Formulário de Contato";s:7:"startup";s:0:"";s:12:"startup_html";i:0;s:5:"class";s:0:"";s:11:"error_class";s:0:"";s:10:"label_wrap";s:1:"|";s:13:"cform_reqmark";s:1:"*";s:23:"cform_function_validate";s:0:"";s:2:"cc";s:0:"";s:10:"targettype";s:5:"email";s:6:"target";s:'.$email.':"'.$phpwcms['admin_email'].'";s:13:"subjectselect";s:0:"";s:10:"sendertype";s:16:"emailfield_email";s:6:"sender";s:0:"";s:14:"sendernametype";s:6:"custom";s:10:"sendername";s:0:"";s:11:"verifyemail";s:0:"";s:8:"labelpos";i:2;s:8:"sendcopy";i:0;s:6:"copyto";s:4:"nome";s:16:"formtracking_off";i:0;s:11:"checktofrom";i:0;s:18:"onsuccess_redirect";i:2;s:16:"onerror_redirect";i:2;s:9:"onsuccess";s:203:"<div class="obrigado">
<big>Obrigado {nome},</big>

<b>Recebemos seu Contato com SUCESSO!</b>

Assim que possível entraremos em Contato. 
<br />
<a class="fr" href="/">« Voltar para Home</a></div>";s:7:"onerror";s:172:"<font color="#ff0000"><b>
Existem campos que não foram preenchidos corretamente.</b><br/><br/>Por favor preencha e envie novamente o formulário. Obrigado.<br/><br/></font>";s:15:"template_format";i:1;s:8:"template";s:1465:"<table border="0" cellpadding="8" cellspacing="1" style=" font-family:Verdana, Geneva, sans-serif" width="752">
	<tbody>
		<tr bgcolor="#187CE0">
			<td align="right" colspan="2">
			<table border="0" cellpadding="8" cellspacing="0" style="font-size:15px; color:#FFF;" width="100%">
				<tbody>
					<tr>
						<td><strong>NOME DA EMPRESA</strong></td>
						<td align="right"><strong>Formul&aacute;rio de Contato</strong></td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td align="right" colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right" bgcolor="#F4F4F4" width="25%"><strong>Assunto:</strong></td>
			<td bgcolor="#fafafa" width="75%">{assunto}</td>
		</tr>
		<tr>
			<td align="right" bgcolor="#F4F4F4"><strong>Nome:</strong></td>
			<td bgcolor="#fafafa">{nome}</td>
		</tr>
		<tr>
			<td align="right" bgcolor="#F4F4F4"><strong>Email:</strong></td>
			<td bgcolor="#fafafa">{email}</td>
		</tr>
		<tr>
			<td align="right" bgcolor="#F4F4F4"><strong>Telefone:</strong></td>
			<td bgcolor="#fafafa">{telefone}</td>
		</tr>
		<tr>
			<td align="right" bgcolor="#F4F4F4"><strong>Como Conheceu:</strong></td>
			<td bgcolor="#fafafa">{conheceu}</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td bgcolor="#f4f4f4" colspan="2"><strong>Informa&ccedil;&otilde;es:</strong></td>
		</tr>
		<tr>
			<td bgcolor="#fafafa" colspan="2">{info}</td>
		</tr>
	</tbody>
</table>";s:20:"template_format_copy";i:0;s:13:"template_copy";s:0:"";s:11:"function_to";s:0:"";s:11:"function_cc";s:0:"";s:14:"template_equal";i:1;s:10:"customform";s:978:"<!--[if lt IE 10]>
<style type="text/css">
.formulario strong{ display:block}
</style>

<![endif]-->

<script src="Scripts/jquery.validate.js" type="text/javascript"></script>

<script type="text/javascript">
$().ready(function() {	  
	$("#phpwcmsForm{ID}").validate({
		rules:{
			nome: "required",			
			email: {required: true, email: true},
			telefone: "required"},		
		messages:{
			nome: "",
			email: {required: "", email: ""}, 	
 			telefone: ""}
	});
});
</script>

<div class="formulario">
<font size="1">Os campos em destaque <font color="#FF0000">vermelho</font> são obrigatórios para o envio do formulário.</font><br /><br />

<p><strong>Nome:</strong>{nome}</p>
<p><strong>E-mail:</strong>{email}</p>
<p><strong>Telefone:</strong>{telefone}</p>
<p>{conheceu}</p>
<p><strong>Assunto:</strong>{assunto}</p>


<p><strong>Informações:</strong>{info}</p>
<p><input type="submit" name="enviar" id="enviar" value="Enviar" /></p>
</div>";s:6:"savedb";i:0;s:11:"saveprofile";i:0;s:10:"anchor_off";i:0;s:3:"ssl";i:0;s:6:"fields";a:6:{i:1;a:12:{s:4:"type";s:4:"text";s:4:"name";s:4:"nome";s:5:"label";s:0:"";s:8:"required";i:1;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:11:"placeholder";s:4:"Nome";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:2;a:12:{s:4:"type";s:5:"email";s:4:"name";s:5:"email";s:5:"label";s:0:"";s:8:"required";i:1;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:11:"placeholder";s:5:"Email";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:3;a:12:{s:4:"type";s:4:"text";s:4:"name";s:8:"telefone";s:5:"label";s:0:"";s:8:"required";i:1;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:11:"placeholder";s:14:"(DDD) Telefone";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:4;a:12:{s:4:"type";s:4:"text";s:4:"name";s:7:"assunto";s:5:"label";s:0:"";s:8:"required";i:0;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:11:"placeholder";s:7:"Assunto";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:5;a:12:{s:4:"type";s:6:"select";s:4:"name";s:8:"conheceu";s:5:"label";s:0:"";s:8:"required";i:0;s:5:"value";s:90:"Como nos Conheceu?
Google
Internet
Facebook
Twitter
Anúncios
Email Marketing
Outros";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:11:"placeholder";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:6;a:12:{s:4:"type";s:8:"textarea";s:4:"name";s:4:"info";s:5:"label";s:0:"";s:8:"required";i:0;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:11:"placeholder";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";i:3;}}}');
// Fim Formulário Padrão


// Início Formulário Right (Com Títulos)
$form_right_nomes = utf8_decode('a:39:{s:7:"subject";s:21:"Formulário de Contato";s:7:"startup";s:0:"";s:12:"startup_html";i:0;s:5:"class";s:0:"";s:11:"error_class";s:0:"";s:10:"label_wrap";s:1:"|";s:13:"cform_reqmark";s:1:"*";s:23:"cform_function_validate";s:0:"";s:2:"cc";s:0:"";s:10:"targettype";s:5:"email";s:6:"target";s:'.$email.':"'.$phpwcms['admin_email'].'";s:13:"subjectselect";s:0:"";s:10:"sendertype";s:16:"emailfield_email";s:6:"sender";s:0:"";s:14:"sendernametype";s:6:"custom";s:10:"sendername";s:0:"";s:11:"verifyemail";s:0:"";s:8:"labelpos";i:2;s:8:"sendcopy";i:0;s:6:"copyto";s:4:"nome";s:16:"formtracking_off";i:0;s:11:"checktofrom";i:0;s:18:"onsuccess_redirect";i:2;s:16:"onerror_redirect";i:2;s:9:"onsuccess";s:128:"<big>Obrigado {nome}</big>

<b>Recebemos seu Contato com SUCESSO!</b>
<br /><br />
Assim que possível entraremos em Contato.";s:7:"onerror";s:172:"<font color="#ff0000"><b>
Existem campos que não foram preenchidos corretamente.</b><br/><br/>Por favor preencha e envie novamente o formulário. Obrigado.<br/><br/></font>";s:15:"template_format";i:1;s:8:"template";s:'.$totalformrespostarighttitulo.':"<table border="0" cellpadding="0" cellspacing="0" width="500">
	<tbody>
		<tr>
			<td><img src="'.$enderecoimg.'" /></td>
		</tr>
		<tr>
			<td>
			<table cellpadding="6" cellspacing="1" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;" width="100%">
				<tbody>
					<tr>
						<td align="right" colspan="2" style="padding:0">&nbsp;</td>
					</tr>
					<tr>
						<td align="right" bgcolor="#f4f4f4" width="26%"><strong>Nome:</strong></td>
						<td bgcolor="#fafafa" width="74%">{nome}</td>
					</tr>
					<tr>
						<td align="right" bgcolor="#f4f4f4"><strong>Email:</strong></td>
						<td bgcolor="#fafafa">{email}</td>
					</tr>
					<tr>
						<td align="right" bgcolor="#f4f4f4"><strong>Telefone:</strong></td>
						<td bgcolor="#fafafa">{telefone}</td>
					</tr>
					<tr>
						<td align="right" bgcolor="#f4f4f4"><strong>Empresa:</strong></td>
						<td bgcolor="#fafafa">{empresa}</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
			<table border="0" cellpadding="6" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;" width="100%">
				<tbody>
					<tr>
						<td bgcolor="#f4f4f4"><strong>Descritivo</strong></td>
					</tr>
					<tr>
						<td bgcolor="#fafafa">{info}</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>";s:20:"template_format_copy";i:0;s:13:"template_copy";s:0:"";s:11:"function_to";s:0:"";s:11:"function_cc";s:0:"";s:14:"template_equal";i:1;s:10:"customform";s:706:"<script src="Scripts/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {	  
	$("#phpwcmsForm{ID}").validate({
		rules:{
			nome: "required",			
			email: {required: true, email: true},
			telefone: "required"},		
		messages:{
			nome: "",
			email: {required: "", email: ""}, 	
 			telefone: ""}
	});
});  
</script>

<div class="formulario-interna">
<p><strong>Nome</strong>{nome}</p>
<p><strong>Empresa</strong>{empresa}</p>
<p><strong>Email</strong>{email}</p>
<p><strong>Telefone</strong>{telefone}</p>
<p><strong>Informações</strong>{info}</p>
<p><input type="submit" name="enviar" id="enviar" value="Enviar" /></p>
</div>";s:6:"savedb";i:0;s:11:"saveprofile";i:0;s:10:"anchor_off";i:0;s:3:"ssl";i:0;s:6:"fields";a:5:{i:1;a:11:{s:4:"type";s:4:"text";s:4:"name";s:4:"nome";s:5:"label";s:0:"";s:8:"required";i:1;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:2;a:11:{s:4:"type";s:5:"email";s:4:"name";s:5:"email";s:5:"label";s:0:"";s:8:"required";i:1;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:3;a:11:{s:4:"type";s:4:"text";s:4:"name";s:8:"telefone";s:5:"label";s:0:"";s:8:"required";i:1;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:4;a:11:{s:4:"type";s:8:"textarea";s:4:"name";s:4:"info";s:5:"label";s:0:"";s:8:"required";i:0;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";i:3;}i:5;a:11:{s:4:"type";s:4:"text";s:4:"name";s:7:"empresa";s:5:"label";s:0:"";s:8:"required";i:0;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}}}');
// Fim Formulário Right (Com Títulos)

// Início Formulário Right (Com Imagens)
$form_right_imagens = utf8_decode('a:39:{s:7:"subject";s:21:"Formulário de Contato";s:7:"startup";s:0:"";s:12:"startup_html";i:0;s:5:"class";s:0:"";s:11:"error_class";s:0:"";s:10:"label_wrap";s:1:"|";s:13:"cform_reqmark";s:1:"*";s:23:"cform_function_validate";s:0:"";s:2:"cc";s:0:"";s:10:"targettype";s:5:"email";s:6:"target";s:'.$email.':"'.$phpwcms['admin_email'].'";s:13:"subjectselect";s:0:"";s:10:"sendertype";s:16:"emailfield_email";s:6:"sender";s:0:"";s:14:"sendernametype";s:6:"custom";s:10:"sendername";s:0:"";s:11:"verifyemail";s:0:"";s:8:"labelpos";i:2;s:8:"sendcopy";i:0;s:6:"copyto";s:4:"nome";s:16:"formtracking_off";i:0;s:11:"checktofrom";i:0;s:18:"onsuccess_redirect";i:2;s:16:"onerror_redirect";i:2;s:9:"onsuccess";s:209:"<div class="obrigado">
<big>Obrigado <b>{nome}</b></big>

<b>Recebemos seu Contato com SUCESSO!</b>

Assim que possível entraremos em Contato. 
<br />
<a class="fr" href="/">« Voltar para Home</a></div>";s:7:"onerror";s:172:"<font color="#ff0000"><b>
Existem campos que não foram preenchidos corretamente.</b><br/><br/>Por favor preencha e envie novamente o formulário. Obrigado.<br/><br/></font>";s:15:"template_format";i:1;s:8:"template";s:'.$totalformrespostarightimagem.':"<table border="0" cellpadding="0" cellspacing="0" width="500">
	<tbody>
		<tr>
			<td><img src="'.$enderecoimg.'" /></td>
		</tr>
		<tr>
			<td>
			<table cellpadding="6" cellspacing="1" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;" width="100%">
				<tbody>
					<tr>
						<td align="right" colspan="2" style="padding:0">&nbsp;</td>
					</tr>
					<tr>
						<td align="right" bgcolor="#f4f4f4" width="26%">&nbsp;</td>
						<td bgcolor="#fafafa" width="74%">&nbsp;</td>
					</tr>
					<tr>
						<td align="right" bgcolor="#f4f4f4"><strong>Nome:</strong></td>
						<td bgcolor="#fafafa">{nome}</td>
					</tr>
					<tr>
						<td align="right" bgcolor="#f4f4f4"><strong>Email:</strong></td>
						<td bgcolor="#fafafa">{email}</td>
					</tr>
					<tr>
						<td align="right" bgcolor="#f4f4f4"><strong>Telefone:</strong></td>
						<td bgcolor="#fafafa">{ddd} {telefone}</td>
					</tr>
					<tr>
						<td align="right" bgcolor="#f4f4f4"><strong>Como Conheceu:</strong></td>
						<td bgcolor="#fafafa">{conheceu}</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
			<table border="0" cellpadding="6" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;" width="100%">
				<tbody>
					<tr>
						<td bgcolor="#f4f4f4"><strong>Informa&ccedil;&otilde;es</strong></td>
					</tr>
					<tr>
						<td bgcolor="#fafafa">{info}</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>";s:20:"template_format_copy";i:0;s:13:"template_copy";s:0:"";s:11:"function_to";s:0:"";s:11:"function_cc";s:0:"";s:14:"template_equal";i:1;s:10:"customform";s:662:"<script src="Scripts/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {	  
   $("#phpwcmsForm{ID}").validate({
      rules:{
         nome: "required",			
         email: {required: true, email: true},
         telefone: "required"},		
      messages:{
         nome: "",
         email: {required: "", email: ""}, 	
         telefone: ""}
   });
});
</script>

<div class="formulario-interna">
<p>{nome}</p>
<p>{email}</p>
<p>{telefone}</p>
<p>{conheceu}</p>
<p><span class="ico-info"></span>{info}</p>
<p><input type="submit" name="enviar" id="enviar" value="Enviar" /></p>
</div>";s:6:"savedb";i:0;s:11:"saveprofile";i:0;s:10:"anchor_off";i:0;s:3:"ssl";i:0;s:6:"fields";a:5:{i:1;a:12:{s:4:"type";s:4:"text";s:4:"name";s:4:"nome";s:5:"label";s:0:"";s:8:"required";i:1;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:9:"autofocus";s:11:"placeholder";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:2;a:12:{s:4:"type";s:5:"email";s:4:"name";s:5:"email";s:5:"label";s:0:"";s:8:"required";i:1;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:11:"placeholder";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:3;a:12:{s:4:"type";s:4:"text";s:4:"name";s:8:"telefone";s:5:"label";s:0:"";s:8:"required";i:1;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:11:"placeholder";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:4;a:12:{s:4:"type";s:6:"select";s:4:"name";s:8:"conheceu";s:5:"label";s:0:"";s:8:"required";i:0;s:5:"value";s:97:"Como nos conheceu?
Google
Internet
Redes Sociais
Indicação
Anúncios
Email Marketing
Outros";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:11:"placeholder";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";s:0:"";}i:5;a:12:{s:4:"type";s:8:"textarea";s:4:"name";s:4:"info";s:5:"label";s:0:"";s:8:"required";i:0;s:5:"value";s:0:"";s:5:"error";s:0:"";s:5:"style";s:0:"";s:5:"class";s:0:"";s:11:"placeholder";s:0:"";s:7:"profile";s:0:"";s:4:"size";s:0:"";s:3:"max";i:3;}}}');
// Fim Formulário Right (Com Imagens)

// Gera o formulário do módulo
echo '
<head>
<script src="//code.jquery.com/jquery-latest.min.js" ></script>
<link rel="stylesheet" type="text/css" href="include/inc_module/mod_form/template/css/form.css" />
</head>
<div class="content fl">
<h1 style="margin-bottom:10px" class="title">Formul&aacute;rios</h1>
<div class="content-form-left fl">
<form action="phpwcms.php?do=modules&module=form_creator" method="post">
	<input type="hidden" value="'.$total.'" name="valor" id="valor" />
	Selecione o artigo:<br />
	<select name="nome-artigo" id="nome-artigo">';
	while ($row = mysqli_fetch_array($artigo)) {
		echo '<option value="'.$row['article_id'].'">'.$row['article_title'].'</option>';
	}
	
	echo '
	</select><br /><br />
	Selecione a parte de conte&uacute;do:<br />
	<select name="bloco" id="bloco">
		<option value="CONTENT">CONTENT</option>
		<option value="LEFT">LEFT</option>
		<option value="RIGHT">RIGHT</option>
		<option value="FOOTER">FOOTER</option>
		<option value="HEADER">HEADER</option>
		<option value="BANNER">BANNER</option>
		<option value="SERVICOS">SERVICOS</option>
		<option value="PRODUTOS">PRODUTOS</option>
		<option value="MAPA">MAPA</option>
		<option value="CLIENTES">CLIENTES</option>';
	foreach($val as $value) {
		$value = trim($value);
    	$valhtml = htmlspecialchars($value);
		echo '<option value="'.$valhtml.'">'.$valhtml.'</option>';                         
    }
	
	echo '
	</select><br /><br />
	Selecione o tipo de formul&aacute;rio:<br />
		<select name="form" id="form">
			<option name="" value="" />Selecione</option>
			<option id="form-padrao" name="form-padrao" value="'.htmlspecialchars($form_padrao).'" />Formul&aacute;rio Padr&atilde;o</option>
			<option id="form-padrao" name="form-padrao" value="'.htmlspecialchars($form_right_nomes).'" />Formul&aacute;rio Right (Com t&iacute;tulos)</option>
			<option id="form-padrao" name="form-padrao" value="'.htmlspecialchars($form_right_imagens).'" />Formul&aacute;rio Right (Com imagens)</option>
		</select><br /><br />	
	<input type="submit" name="create-form" value="Criar" id="create-form" />
	</form>
</div>
<div class="content-form-right fl">';	
	if(isset($_POST['create-form'])){
		$pagina = utf8_decode($_POST['nome-artigo']);
		$bloco = utf8_decode($_POST['bloco']);
		$blocoid = utf8_decode($_POST['valor']);
		$form = $_POST['form'];
	
		echo '<div class="form-criado">O formul&aacute;rio foi criado com sucesso.<br /> Para visualiz&aacute;-lo, clique <a href="phpwcms.php?do=articles&p=2&s=1&aktion=2&id='.$pagina.'&acid='.$blocoid.'">aqui</a>.</div>';
		$query = "INSERT INTO phpwcms_articlecontent SET acontent_id = '$blocoid', acontent_aid = '$pagina', acontent_type = '23', acontent_form = '$form', acontent_block = '$bloco', acontent_created = NOW(), acontent_sorting = '10', acontent_visible = '1'";
		mysqli_query($conexao, $query);
	}
	$form = $_GET['form'];
	$blocoid = utf8_decode($_GET['valor']);
echo '</div>
</div>';

?>	