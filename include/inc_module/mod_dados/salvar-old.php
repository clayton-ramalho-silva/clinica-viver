<?php
require_once ('../../../config/phpwcms/conf.inc.php');
include ('../../../include/inc_lib/default.inc.php');

$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);
$db_prepend = ($phpwcms['db_prepend'] != '') ? $phpwcms['db_prepend'].'_' : '';

// Busca as informações da tabela de Dados
$dados_empresa = 'SELECT * FROM '.$db_prepend.'phpwcms_dados';
$empresa = mysqli_query($conexao, $dados_empresa);
$dados = mysqli_fetch_array($empresa);


/* Nome da Empresa ========================================================== */
if (isset($_POST['empresa'])) {

	$empresa = utf8_decode($_POST['empresa']);

	// -- Chama as informações do template de Disposição de Página --
	$sqlLayout = 'SELECT * FROM '.$db_prepend.'phpwcms_pagelayout
                  WHERE pagelayout_default = 1';
	$resLayout = mysqli_query($conexao, $sqlLayout);
	$page = mysqli_fetch_array($resLayout);

	// Insere o nome da Empresa na área de Disposição de Página
	$infoLayout = unserialize($page['pagelayout_var']);
	$nomeEmpresa = array('layout_title' => $empresa);
	$pageLayout = array_merge($infoLayout, $nomeEmpresa);
	$final = serialize($pageLayout);

	$sqlUpdate1 = "UPDATE ".$db_prepend."phpwcms_pagelayout
                   SET pagelayout_var = '$final'";
	$resUpdate1 = mysqli_query($conexao, $sqlUpdate1);

	$sqlUpdate2 = "UPDATE ".$db_prepend."phpwcms_dados
                   SET dados_empresa = '".$empresa."'";
	$resUpdate2 = mysqli_query($conexao, $sqlUpdate2);

	checagem($conexao, $resUpdate2);

}


/* Números de Telefone ====================================================== */
if (isset($_POST['telefone'])) {

	$check         = implode(',',$_POST['check']);
	$telefone      = implode(',',$_POST['telefone']);
	$checkWhatsapp = $_POST['check_whatsapp'][0];
    $whatsapp      = implode(',',$_POST['whatsapp']);
    $msgWhatsapp   = utf8_decode($_POST['msgWhatsapp']);
	$dadosWhatsapp = $checkWhatsapp.','.$whatsapp;
	$classes       = $_POST['classes'][0];

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET
            dados_fone = '".$telefone."',
            dados_whatsapp = '".$dadosWhatsapp."',
            dados_msg_whatsapp = '".$msgWhatsapp."',
            dados_fone_checkbox = '".$check."',
            dados_classe_fone = '".$classes."'";
	$res = mysqli_query($conexao, $sql);

	checagem($conexao, $res);

}


/* Redes Sociais ============================================================ */
if (isset($_POST['redes'])) {

	$check     = $_POST['check'];
	$redes     = $_POST['redes'];
	$infoRedes = $check.','.$redes;

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_redes = '".$infoRedes."'";
	$res = mysqli_query($conexao, $sql);

	checagem($conexao, $res);

}


/* Lista de E-mails ========================================================= */
if (isset($_POST['emails'])) {

	$check      = $_POST['check'];
	$emails     = $_POST['emails'];
	$infoEmails = $check.','.$emails;

    var_dump($infoEmails);

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_emails = '".$infoEmails."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}


/* E-mails de Formulários =================================================== */
if (isset($_POST['id'])) {

	$id = $_POST['id'];
	$emails = $_POST['formemails'];

	$listaId     = explode(',', $id);
	$listaEmails = explode(',', $emails);
	$geral       = array_combine($listaId, $listaEmails);

	foreach($geral as $key => $value){

		// Chama as informações dos formulários
		$sqlForms = 'SELECT acontent_form FROM '.$db_prepend.'phpwcms_articlecontent
                     WHERE acontent_id = '.$key;
		$resForms = mysqli_query($conexao, $sqlForms);
		$form = mysqli_fetch_array($resForms);

		// Insere o e-mail no campo de envio
		$infoForm = unserialize($form['acontent_form']);
		$emailForm = array('target' => $value);
		$formulario = array_merge($infoForm, $emailForm);
		$final = serialize($formulario);

		$sql = "UPDATE ".$db_prepend."phpwcms_articlecontent
                SET acontent_form = '".$final."'
                WHERE acontent_id = ".$key;
		$res = mysqli_query($conexao, $sql);
		// if (false === $resource){printf("erro: %s\n", mysqli_error($conexao));} else {echo 'ok';}

	}

    checagem($conexao, $res);

}


/* Endereço da Empresa ====================================================== */
if (isset($_POST['endereco'])) {

	$endereco = utf8_decode($_POST['endereco']);

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_endereco = '".$endereco."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}

/* Segundo Endereço da Empresa ============================================== */
if (isset($_POST['endereco2'])) {

	$endereco2 = utf8_decode($_POST['endereco2']);

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_endereco2 = '".$endereco2."'";
	$res = mysqli_query($conexao, $sql);

}

/* Ativa / desativa o segundo endereço ====================================== */
if (isset($_POST['ativado'])) {

	$ativado = $_POST['ativado'];

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_segundo_endereco = '".$ativado."'";
	$res = mysqli_query($conexao, $sql);

}

/* Ativa / desativa o primeiro mapa ========================================= */
if (isset($_POST['mapa1'])) {

	$mapa = $_POST['mapa1'];

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_mapa1 = '".$mapa."'";
	$res = mysqli_query($conexao, $sql);

}

/* Ativa / desativa o primeiro mapa ========================================= */
if (isset($_POST['mapa2'])) {

	$mapa = $_POST['mapa2'];

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_mapa2 = '".$mapa."'";
	$res = mysqli_query($conexao, $sql);

}

/* Texto de Rodapé ========================================================== */
if (isset($_POST['rodape'])) {

	$rodape = utf8_encode($_POST['rodape']);

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_rodape = '".$rodape."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}

/* Texto de Campo Adicional 1 =============================================== */
if (isset($_POST['campo1'])) {

	$campo1 = utf8_encode($_POST['campo1']);

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_campo_adicional1 = '".$campo1."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}

/* Texto de Campo Adicional 2 =============================================== */
if (isset($_POST['campo2'])) {

	$campo2 = utf8_encode($_POST['campo2']);

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_campo_adicional2 = '".$campo2."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}


/* reCAPTCHA ================================================================ */
if (isset($_POST['check_recaptcha']) && isset($_POST['site_recaptcha']) && isset($_POST['secret_recaptcha'])) {

    $recaptcha = array(
        'ativo'  => $_POST['check_recaptcha'],
        'site'   => $_POST['site_recaptcha'],
        'secret' => $_POST['secret_recaptcha']
    );

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_recaptcha = '".json_encode($recaptcha)."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}


/* META e Analytics da Empresa ============================================== */
if (isset($_POST['meta'])) {

	// Informações do META
	$meta = utf8_decode(meta($_POST['meta']));
	$meta = str_replace("'", '"', $meta);
	$meta_temp = $meta;

	if (isset($_POST['empresa'])){

		$meta_temp = str_replace('{EMPRESA}', utf8_decode($_POST['empresa']), $meta_temp);

	} else {

		if ($dados['dados_empresa'] != ''){
			$meta_temp = str_replace('{EMPRESA}', $dados['dados_empresa'], $meta_temp);
		} else {
			$meta_temp = str_replace('{EMPRESA}', '', $meta_temp);
		}

	}

	if (isset($_POST['endereco'])){

		$endereco = explode(',',utf8_decode($_POST['endereco']));
		$meta_temp = str_replace(array('{CIDADE}', '{UF}'), array($endereco[4],$endereco[3]), $meta_temp);

	} else {

		if ($dados['dados_endereco'] != ''){

			$endereco = explode(',',$dados['dados_endereco'] );
			$meta_temp = str_replace(array('{CIDADE}', '{UF}'), array($endereco[4],$endereco[3]), $meta_temp);

		} else {

			$meta_temp = str_replace(array('{CIDADE}', '{UF}'), array('', ''), $meta_temp);

		}

	}

	$meta_temp = str_replace('{SITE}', $_SERVER['HTTP_HOST'], $meta_temp);

    // Informações do ANALYTICS
	$analytics = utf8_decode(meta($_POST['analytics']));
	$analytics = str_replace("'", '"', $analytics);

    // Informações do WEBMASTER
	$webmaster = utf8_decode(meta($_POST['webmaster']));
	$webmaster = str_replace("'", '"', $webmaster);

	// Chama as informações de META dos templates
	$sqlTemplate = 'SELECT * FROM '.$db_prepend.'phpwcms_template
                    WHERE template_trash = 0';
	$resTemplate = mysqli_query($conexao, $sqlTemplate);

	while($temp = mysqli_fetch_array($resTemplate)){

		$cod_webmaster = ($temp['template_id'] == 1) ? LF.$webmaster : '';

		// -- Insere a META nos demais templates --
		$infoTemplate = unserialize($temp['template_var']);
        $infoTemplate['htmlhead'] = $meta_temp.LF.$analytics.$cod_webmaster;
        $temp_final   = serialize($infoTemplate);

		$sqlTemp = "UPDATE ".$db_prepend."phpwcms_template
                    SET template_var = '".$temp_final."'
                    WHERE template_id = '".$temp['template_id']."'";
		$resTemp = mysqli_query($conexao, $sqlTemp);

	}

	$sql = "UPDATE ".$db_prepend."phpwcms_dados
            SET dados_meta = '".$meta."', dados_analytics = '".$analytics."',
            dados_webmaster = '".$webmaster."'";
	$res = mysqli_query($conexao, $sql);

}



// FUNÇÕES ================================================================== */

// Verifica se as informações foram salvas corretamente
function checagem($conexao,$res){

	$erro = mysqli_error($conexao);

	$mensagem = $res ? 'Informações salvas com sucesso' : 'Erro: '.$erro;
	$classe   = $res ? 'sucesso' : 'erro';

	$dados = array(
		'mensagem'	=> utf8_encode($mensagem),
		'classe'	=> $classe,
	);

	echo json_encode($dados);

}

?>