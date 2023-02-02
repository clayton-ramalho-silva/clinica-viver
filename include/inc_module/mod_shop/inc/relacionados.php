<?
require_once ('config/phpwcms/conf.inc.php');
$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'] , $phpwcms['db_table'] ); 
$consulta_produtos = 'SELECT * FROM phpwcms_shop_products WHERE shopprod_status=1 AND shopprod_listall=1 LIMIT 10';
$produtos = mysqli_query($conexao, $consulta_produtos);

if ($_GET['shop_detail']){
while($row = mysqli_fetch_array($produtos)){
	echo ''.$row['shopprod_name1'].'';
};}
?>