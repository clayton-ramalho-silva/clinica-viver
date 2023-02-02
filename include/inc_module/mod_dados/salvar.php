<?php
require_once ('../../../config/phpwcms/conf.inc.php');
include ('../../../include/inc_lib/default.inc.php');

$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);
$db = ($phpwcms['db_prepend'] != '') ? $phpwcms['db_prepend'].'_' : '';

// Contagem de erros
$GLOBALS['count'] = 0;
$GLOBALS['erros'] = array();

// Busca as informações da tabela de Dados
$sql = 'SELECT *
        FROM '.$db.'phpwcms_dados';
$res = mysqli_query($conexao, $sql);
$row = mysqli_fetch_array($res);


/* Nome da Empresa ========================================================== */
if (isset($_POST['empresa'])) {

	$empresa = utf8_decode($_POST['empresa']);

	// Chama as informações do template de Disposição de Página --
	$sqlLayout = 'SELECT *
                  FROM '.$db.'phpwcms_pagelayout
                  WHERE pagelayout_default = 1';
	$resLayout = mysqli_query($conexao, $sqlLayout);
	$page = mysqli_fetch_array($resLayout);

	// Insere o nome da Empresa na área de Disposição de Página
	$infoLayout = unserialize($page['pagelayout_var']);
	$nomeEmpresa = array('layout_title' => $empresa);
	$pageLayout = array_merge($infoLayout, $nomeEmpresa);
	$final = serialize($pageLayout);

	$sqlUpdate1 = "UPDATE ".$db."phpwcms_pagelayout
                   SET pagelayout_var = '$final'";
	$resUpdate1 = mysqli_query($conexao, $sqlUpdate1);

	$sqlUpdate2 = "UPDATE ".$db."phpwcms_dados
                   SET dados_empresa = '".$empresa."'";
	$resUpdate2 = mysqli_query($conexao, $sqlUpdate2);

	checagem($conexao, $resUpdate2);

}


/* Números de Telefone ====================================================== */
if (isset($_POST['telefone'])) {

	$check         = implode(',',$_POST['check_fone']);
	$telefone      = implode(',',$_POST['telefone']);
	$checkWhatsapp = $_POST['check_whatsapp'][0];
    $whatsapp      = implode(',',$_POST['whatsapp']);
    $msgWhatsapp   = utf8_decode($_POST['msgWhatsapp']);
	$dadosWhatsapp = $checkWhatsapp.','.$whatsapp;

	$sql = "UPDATE ".$db."phpwcms_dados
            SET
            dados_fone = '".$telefone."',
            dados_whatsapp = '".$dadosWhatsapp."',
            dados_msg_whatsapp = '".$msgWhatsapp."',
            dados_fone_checkbox = '".$check."'";
	$res = mysqli_query($conexao, $sql);

	checagem($conexao, $res);

}


/* Redes Sociais ============================================================ */
if (isset($_POST['redes'])) {

	$check     = $_POST['check_redes'];
	$redes     = $_POST['redes'];
	$infoRedes = $check.','.$redes;

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_redes = '".$infoRedes."'";
	$res = mysqli_query($conexao, $sql);

	checagem($conexao, $res);

}


/* Lista de E-mails ========================================================= */
if (isset($_POST['emails'])) {

	$check      = $_POST['check_emails'];
	$emails     = $_POST['emails'];
	$infoEmails = $check.','.$emails;

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_emails = '".$infoEmails."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}


/* E-mails de Formulários =================================================== */
if (isset($_POST['id'])) {

    if(!empty($_POST['id'])){

        $id = $_POST['id'];
        $emails = $_POST['formemails'];

        $listaId     = explode(',', $id);
        $listaEmails = explode(',', $emails);
        $geral       = array_combine($listaId, $listaEmails);

        foreach($geral as $key => $value){

            // Chama as informações dos formulários
            $sqlForms = 'SELECT acontent_form FROM '.$db.'phpwcms_articlecontent
                        WHERE acontent_id = '.$key;
            $resForms = mysqli_query($conexao, $sqlForms);
            $form = mysqli_fetch_array($resForms);

            // Insere o e-mail no campo de envio
            $infoForm = unserialize($form['acontent_form']);
            $emailForm = array('target' => $value);
            $formulario = array_merge($infoForm, $emailForm);
            $final = serialize($formulario);

            $sql = "UPDATE ".$db."phpwcms_articlecontent
                    SET acontent_form = '".$final."'
                    WHERE acontent_id = ".$key;
            $res = mysqli_query($conexao, $sql);

        }

        checagem($conexao, $res);

    }

}


/* Endereço da Empresa ====================================================== */
if (isset($_POST['endereco'])) {

	$endereco = utf8_decode($_POST['endereco']);

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_endereco = '".$endereco."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}

/* Segundo Endereço da Empresa ============================================== */
if (isset($_POST['endereco2'])) {

	$endereco2 = utf8_decode($_POST['endereco2']);

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_endereco2 = '".$endereco2."'";
	$res = mysqli_query($conexao, $sql);

}

/* Ativa / desativa o segundo endereço ====================================== */
if (isset($_POST['ativado'])) {

	$ativado = $_POST['ativado'];

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_segundo_endereco = '".$ativado."'";
	$res = mysqli_query($conexao, $sql);

}

/* Ativa / desativa o primeiro mapa ========================================= */
if (isset($_POST['mapa1'])) {

	$mapa = $_POST['mapa1'];

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_mapa1 = '".$mapa."'";
	$res = mysqli_query($conexao, $sql);

}

/* Ativa / desativa o primeiro mapa ========================================= */
if (isset($_POST['mapa2'])) {

	$mapa = $_POST['mapa2'];

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_mapa2 = '".$mapa."'";
	$res = mysqli_query($conexao, $sql);

}

/* Texto de Rodapé ========================================================== */
if (isset($_POST['rodape'])) {

	$rodape = utf8_encode($_POST['rodape']);

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_rodape = '".$rodape."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}

/* Texto de Campo Adicional 1 =============================================== */
if (isset($_POST['campo1'])) {

	$campo1 = utf8_encode($_POST['campo1']);

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_campo_adicional1 = '".$campo1."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}

/* Texto de Campo Adicional 2 =============================================== */
if (isset($_POST['campo2'])) {

	$campo2 = utf8_encode($_POST['campo2']);

	$sql = "UPDATE ".$db."phpwcms_dados
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

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_recaptcha = '".json_encode($recaptcha)."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}

/*  Cookies ================================================================= */
if (isset($_POST['check_cookies']) && isset($_POST['politica_cookies']) && isset($_POST['msg_cookies'])) {

    $cookies = array(
        'ativo'    => $_POST['check_cookies'],
        'politica' => $_POST['politica_cookies'],
        'mensagem' => $_POST['msg_cookies']
    );

    $sql = "UPDATE
            ".$db."phpwcms_dados
            SET
            dados_cookies = '".serialize($cookies)."'";
	$res = mysqli_query($conexao, $sql);

    checagem($conexao, $res);

}


/* Configurações de E-mail ================================================== */
if (isset($_POST['email_from']) || isset($_POST['email_nome']) || isset($_POST['email_host']) || isset($_POST['email_porta']) || isset($_POST['email_modo']) || isset($_POST['email_usuario']) || isset($_POST['email_senha']) || isset($_POST['email_seguro']) || isset($_POST['email_autenticacao']) || isset($_POST['check_ssl'])) {

    $eConfig = array(
        'ssl'          => $_POST['check_ssl'],
        'from'         => $_POST['email_from'],
        'nome'         => $_POST['email_nome'],
        'host'         => $_POST['email_host'],
        'porta'        => $_POST['email_porta'],
        'modo'         => $_POST['email_modo'],
        'usuario'      => $_POST['email_usuario'],
        'senha'        => $_POST['email_senha'],
        'seguro'       => $_POST['email_seguro'],
        'autenticacao' => $_POST['email_autenticacao'],
    );

    // Busca as configurações do conf.inc.php
    $file   = $_SERVER['DOCUMENT_ROOT'].'/'.$phpwcms['root'].'config/phpwcms/conf.inc.php';
    $info   = array();
    $config = @file_get_contents($file);
    preg_match_all("/phpwcms\['site_ssl_mode'\]     = (.*?);/", $config, $info['ssl']);
    preg_match_all("/phpwcms\['SMTP_FROM_EMAIL'\]   = (.*?);/", $config, $info['from']);
    preg_match_all("/phpwcms\['SMTP_FROM_NAME'\]    = (.*?);/", $config, $info['nome']);
    preg_match_all("/phpwcms\['SMTP_HOST'\]         = (.*?);/", $config, $info['host']);
    preg_match_all("/phpwcms\['SMTP_PORT'\]         = (.*?);/", $config, $info['porta']);
    preg_match_all("/phpwcms\['SMTP_MAILER'\]       = (.*?);/", $config, $info['modo']);
    preg_match_all("/phpwcms\['SMTP_USER'\]         = (.*?);/", $config, $info['usuario']);
    preg_match_all("/phpwcms\['SMTP_PASS'\]         = (.*?);/", $config, $info['senha']);
    preg_match_all("/phpwcms\['SMTP_SECURE'\]       = (.*?);/", $config, $info['seguro']);
    preg_match_all("/phpwcms\['SMTP_AUTH'\]         = (.*?);/", $config, $info['autenticacao']);

    // Altera os dados do config
    foreach($info as $key => $value){

        $termo  = ($key === 'ssl' || $key === 'porta') ? $eConfig[$key] : (($key === 'autenticacao') ? (int)$eConfig[$key] : "'$eConfig[$key]'");
        $novo   = str_replace($value[1], $termo, $value[0]);
        $config = str_replace($value[0], $novo, $config);

    }

    // Atualiza os dados do arquivo
    $file_config = fopen($file, "wb", 0);
    if ($bytesWritten = fwrite($file_config, $config) ) {
        //echo "There were " . $bytesWritten . " bytes written to " . $file;
    }
    if (!fclose($file_config)) {
        //die("There was a problem closing " . $file);
    }

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

		if ($row['dados_empresa'] != ''){
			$meta_temp = str_replace('{EMPRESA}', $row['dados_empresa'], $meta_temp);
		} else {
			$meta_temp = str_replace('{EMPRESA}', '', $meta_temp);
		}

	}

	if (isset($_POST['endereco'])){

		$endereco = explode(',',utf8_decode($_POST['endereco']));
		$meta_temp = str_replace(array('{CIDADE}', '{UF}'), array($endereco[4],$endereco[3]), $meta_temp);

	} else {

		if ($row['dados_endereco'] != ''){

			$endereco = explode(',',$row['dados_endereco'] );
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

    /*
    // Chama as informações de META dos templates
	$sqlTemplate = 'SELECT * FROM '.$db.'phpwcms_template
                    WHERE template_trash = 0';
	$resTemplate = mysqli_query($conexao, $sqlTemplate);

	while($temp = mysqli_fetch_array($resTemplate)){

		$cod_webmaster = ($temp['template_id'] == 1) ? LF.$webmaster : '';

		// -- Insere a META nos demais templates --
		$infoTemplate = unserialize($temp['template_var']);
        $infoTemplate['htmlhead'] = $meta_temp.LF.$analytics.$cod_webmaster;
        $temp_final   = serialize($infoTemplate);

		$sqlTemp = "UPDATE ".$db."phpwcms_template
                    SET template_var = '".$temp_final."'
                    WHERE template_id = '".$temp['template_id']."'";
		$resTemp = mysqli_query($conexao, $sqlTemp);

    }
    */

	$sql = "UPDATE ".$db."phpwcms_dados
            SET dados_meta = '".$meta."', dados_analytics = '".$analytics."',
            dados_webmaster = '".$webmaster."'";
	$res = mysqli_query($conexao, $sql);

}

// Mensagem de sucesso / erro
$mensagem = ($GLOBALS['count'] === 0) ? 'Informações salvas com sucesso' : 'Erro: '.implode('<br>', $GLOBALS['erros']);
$classe   = ($GLOBALS['count'] === 0) ? 'sucesso' : 'erro';
$delay    = ($GLOBALS['count'] === 0) ? 1000 : 8000;

$dados = array(
    'mensagem' => utf8_encode($mensagem),
    'classe'   => $classe,
    'delay'    => $delay,
);

echo json_encode($dados);

// FUNÇÕES ================================================================== */

// Verifica se as informações foram salvas corretamente
function checagem($conexao,$res){

    $erro = mysqli_error($conexao);

    if(!$res){
        $GLOBALS['count']++;
        $GLOBALS['erros'][] = $erro;
    }

}

?>