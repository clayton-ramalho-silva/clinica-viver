<?

ini_set('display_errors', 0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();

//Carrega as informacoes do banco de Dados
require_once ('../../../config/phpwcms/conf.inc.php');
require_once ('../../../include/inc_lib/default.inc.php');
require_once ('../../../include/inc_lib/dbcon.inc.php');
require_once ('../../../include/inc_lib/general.inc.php');
checkLogin();
require_once PHPWCMS_ROOT.'/include/inc_lib/modules.check.inc.php';

// Conexão com o banco de dados
$conexao = mysqli_connect(
    $phpwcms['db_host'],
    $phpwcms['db_user'],
    $phpwcms['db_pass'] ,
    $phpwcms['db_table']
);

// Variáveis gerais
$paginas = $estururas = $jumpMenu = '';
$ordem   = ($_GET['org'] == 'acat_id') ? 'acat_id ASC' : 'article_id ASC';

// Busca as informações do banco de dados
$sql = 'SELECT
        article_id,
        article_nositemap,
        article_summary,
        article_alias,
        article_subtitle,
        article_title,
        article_keyword,
        article_pagetitle,
        article_cid,
        article_description,
        acat_id,
        acat_name,
        acat_pagetitle,
        acat_keywords,
        acat_info
        FROM
        phpwcms_article AS art
        LEFT JOIN
        phpwcms_articlecat AS cat
        ON
        article_cid = acat_id
        WHERE
        article_id IS NOT NULL
        ORDER BY '.$ordem;
$res = mysqli_query($conexao, $sql);

// Busca as informações das estruturas
$sqlEst = 'SELECT
           *
           FROM
           phpwcms_articlecat
           WHERE
           acat_trash = 0
           ORDER BY acat_id ASC';
$resEst = mysqli_query($conexao, $sqlEst);

// Verifica o check dos campos de ordenação
if ($_GET['org'] == 'ord_catid'){
    $checkArt = '';
    $checkEst = ' checked';
    $ord_pag  = ' style="order: 2"';
    $ord_est  = ' style="order: 1"';
} else {
    $checkArt = ' checked';
    $checkEst = '';
    $ord_pag  = $ord_est = '';
}

// Verifica o check do filtro
$checkTit  = ($_GET) ? (($_GET['a'] == 1) ? ' checked' : '') : ' checked';
$checkSub  = ($_GET) ? (($_GET['s'] == 1) ? ' checked' : '') : '';
$checkSeo  = ($_GET) ? (($_GET['t'] == 1) ? ' checked' : '') : ' checked';
$checkDesc = ($_GET) ? (($_GET['d'] == 1) ? ' checked' : '') : ' checked';
$checkCha  = ($_GET) ? (($_GET['p'] == 1) ? ' checked' : '') : ' checked';
$checkSum  = ($_GET) ? (($_GET['m'] == 1) ? ' checked' : '') : '';
$checkUrl  = ($_GET) ? (($_GET['u'] == 1) ? ' checked' : '') : ' checked';
$checkStr  = ($_GET) ? (($_GET['e'] == 1) ? ' checked' : '') : '';

// LISTA DE PÁGINAS ------------------------------------------------------------
while ($row = mysqli_fetch_assoc($res)) {

    if (stripos($row['article_alias'], "_del") == false && $row['article_nositemap'] == 1 ){

        $titulo    = (strlen($row['article_title']) > 60) ? substr($row['article_title'],0,60) : $row['article_title'];
        $jumpMenu .= '<option value="#'.$row['article_id'].'">'.$row['article_title'].'</option>';

        $source  = file_get_contents('template/content/pages.html');
        $content = array(
            'ID'         => $row['article_id'],
            'LINK'       => PHPWCMS_URL,
            'TITULO'     => $titulo,
            'NOME'       => $row['article_title'],
            'SUBTITULO'  => $row['article_subtitle'],
            'ESTRUTURA'  => $row['acat_name'],
            'TITULO-SEO' => $row['article_pagetitle'],
            'DESCRICAO'  => $row['article_description'],
            'PALAVRAS'   => $row['article_keyword'],
            'SUMARIO'    => $row['article_summary'],
            'ALIAS'      => $row['article_alias']
        );

        foreach($content as $key => $value){
            $source = str_replace('{'.$key.'}', $value, $source);
        }

        $paginas .= $source;

    }

}

// LISTA DE ESTRUTURAS ---------------------------------------------------------
if(mysqli_num_rows($resEst) > 0){

    while($cat = mysqli_fetch_assoc($resEst)) {

        $source  = file_get_contents('template/content/structures.html');
        $content = array(
            'ID'          => $cat['acat_id'],
            'LINK'        => PHPWCMS_URL,
            'TITULO'      => $cat['acat_pagetitle'],
            'NOME'        => $cat['acat_name'],
            'PALAVRAS'    => $cat['acat_keywords'],
            'INFORMACOES' => $cat['acat_info']
        );

        foreach($content as $key => $value){
            $source = str_replace('{'.$key.'}', $value, $source);
        }

        $estruturas .= $source;

    }

} else {

    $estruturas = '<div class="sem-resultado">Não há estruturas cadastradas</div>';

}

//Configura a URL de acordo com as informações do menu lateral
if(isset($_POST['atualizar'])){

	$ordenacao = $_POST['ord_radio'];
	$val_art   = (isset($_POST['check_artigo']))    ? '1' : '0';
	$val_sub   = (isset($_POST['check_subtitulo'])) ? '1' : '0';
	$val_tit   = (isset($_POST['check_titulo']))    ? '1' : '0';
	$val_des   = (isset($_POST['check_descricao'])) ? '1' : '0';
	$val_pal   = (isset($_POST['check_palavras']))  ? '1' : '0';
	$val_sum   = (isset($_POST['check_sumario']))   ? '1' : '0';
	$val_url   = (isset($_POST['check_url']))       ? '1' : '0';
    $val_cat   = (isset($_POST['check_estrutura'])) ? '1' : '0';

	if($ordenacao === 'ord_catid'){
        header('Location: seo.php?org='.$ordenacao.'&a='.$val_art.'&s='.$val_sub.'&t='.$val_tit.'&d='.$val_des.'&p='.$val_pal.'&m='.$val_sum.'&u='.$val_url.'&e='.$val_cat);
	} else{
		header('Location: seo.php?a='.$val_art.'&s='.$val_sub.'&t='.$val_tit.'&d='.$val_des.'&p='.$val_pal.'&m='.$val_sum.'&u='.$val_url.'&e='.$val_cat);
    }

}

//Código do HTML da página
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../../../include/inc_css/phpwcms.css" />
    <link rel="stylesheet" type="text/css" href="template/css/seo.css" />
    <script src="//code.jquery.com/jquery-latest.min.js" ></script>
    <script src="scripts/funcoes.js" type="text/javascript"></script>
    <script src="scripts/floatlabels.min.js" type="text/javascript"></script>
</head>

<body>

    <nav class="menu-lateral">

        <a href="<?= PHPWCMS_URL ?>phpwcms.php?do=modules" class="bt-voltar db fl">Voltar</a>
        <a href="<?= PHPWCMS_URL ?>phpwcms.php?do=logout" class="bt-sair db fr" target="_top">Sair</a>

        <hr>

        <strong>Ir para a página:</strong>
        <select id="select"><?= $jumpMenu ?></select>
        <hr>

        <form id="preferencias" method="post">

            <strong>Campos visíveis:</strong>

            <label>
                <input name="check_artigo" type="checkbox" id="check_artigo" value="2"<?= $checkTit ?>>Título da Página
            </label>
            <label>
                <input name="check_subtitulo" type="checkbox" id="check_subtitulo" value="2"<?= $checkSub ?>>Subtítulo
            </label>
            <label>
                <input name="check_titulo" type="checkbox" id="check_titulo" value="2"<?= $checkSeo ?>>Título do SEO
            </label>
            <label>
                <input name="check_descricao" type="checkbox" id="check_descricao" value="2"<?= $checkDesc ?>>Descrição do SEO
            </label>
            <label>
                <input name="check_palavras" type="checkbox" id="check_palavras" value="2"<?= $checkCha ?>>Palavras Chave
            </label>
            <label>
                <input name="check_sumario" type="checkbox" id="check_sumario" value="2"<?= $checkSum ?>>Sumário
            </label>
            <label>
                <input name="check_url" type="checkbox" id="check_url" value="2"<?= $checkUrl ?>>URL Amigável
            </label>
            <label>
                <input name="check_estrutura" type="checkbox" id="check_estrutura" value="2"<?= $checkStr ?>>Estruturas
            </label>

            <hr>

            <strong>Ordenar páginas por:</strong>

            <label>
                <input name="ord_radio" type="radio" id="ord_artid" value="ord_artid"<?= $checkArt ?>>ID do Artigo
            </label>
            <label>
                <input name="ord_radio" type="radio" id="ord_catid" value="ord_catid"<?= $checkEst ?>>ID da Estrutura
            </label>

            <input type="submit" id="atualizar" name="atualizar" value="Atualizar" />
        </form>
    </nav>

    <div class="corpo">

        <div class="content-total">

            <div class="menu-trigger"></div>

            <div class="link-site">
                <a href="<?= PHPWCMS_URL ?>" target="_blank"><?= PHPWCMS_HOST ?></a>
            </div>

            <h1>S.E.O. - Otimização de Site</h1>

            <div class="accordion" style="display: block">

                <div class="content-paginas"<?= $ord_pag ?>>
                    <h3>PÁGINAS</h3>
                    <?= $paginas ?>
                </div>

                <div class="content-estruturas"<?= $ord_est ?>>
                    <h3>ESTRUTURAS</h3>
                    <?= $estruturas ?>
                </div>

            </div>

        </div>

    </div>

</body>