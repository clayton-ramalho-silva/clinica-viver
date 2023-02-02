<?php

require_once ('../../../config/phpwcms/conf.inc.php');
$conexao = mysqli_connect(
    $phpwcms['db_host'],
    $phpwcms['db_user'],
    $phpwcms['db_pass'],
    $phpwcms['db_table']
);

$row = array();
parse_str($_POST['form'], $row);

if (isset($row['id'])) {

	$id          = mysqli_real_escape_string($conexao, utf8_decode($row['id']));
	$alias       = mysqli_real_escape_string($conexao, utf8_decode($row['article_alias']));
	$subtitulo   = mysqli_real_escape_string($conexao, utf8_decode($row['subtitulo']));
	$title       = mysqli_real_escape_string($conexao, utf8_decode($row['artigo']));
	$keyword     = mysqli_real_escape_string($conexao, utf8_decode($row['palavra-chave']));
	$pagetitle   = mysqli_real_escape_string($conexao, utf8_decode($row['titulo']));
	$description = mysqli_real_escape_string($conexao, utf8_decode($row['descricao']));
	$summary     = mysqli_real_escape_string($conexao, utf8_decode($row['sumario']));
	$menutitle   = mysqli_real_escape_string($conexao, utf8_decode($row['menutitle']));

	$sql = 'UPDATE
            phpwcms_article
            SET
            article_alias       = "'.$alias.'",
            article_title       = "'.$title.'",
            article_subtitle    = "'.$subtitulo.'",
            article_pagetitle   = "'.$pagetitle.'",
            article_description = "'.$description.'",
            article_keyword     = "'.$keyword.'",
            article_summary     = "'.$summary.'",
            article_menutitle   = "'.$menutitle.'"
            WHERE
            article_id = '.$id;
    $res = mysqli_query($conexao,$sql);

    echo $res ? 'Salvo!' : 'As alterações não puderam ser salvas';

}

else

if (isset($row['cat-id'])) {

	$id        = mysqli_real_escape_string($conexao, utf8_decode($row['cat-id']));
	$name      = mysqli_real_escape_string($conexao, utf8_decode($row['cat-nome']));
	$pagetitle = mysqli_real_escape_string($conexao, utf8_decode($row['cat-titulo']));
	$info      = mysqli_real_escape_string($conexao, utf8_decode($row['cat-info']));
	$keywords  = mysqli_real_escape_string($conexao, utf8_decode($row['cat-palavra-chave']));

	$sql = 'UPDATE
            phpwcms_articlecat
            SET
            acat_name      = "'.$name.'",
            acat_pagetitle = "'.$pagetitle.'",
            acat_info      = "'.$info.'",
            acat_keywords  = "'.$keywords.'"
            WHERE
            acat_id = '.$id;
    $res = mysqli_query($conexao,$sql);

    echo $res ? 'Salvo!' : 'As alterações não puderam ser salvas';

}


?>