<?php

require_once ('../../../../config/phpwcms/conf.inc.php');
include ('../../../../include/inc_lib/default.inc.php');

$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);

$login = $_POST['login'];

$query = 'SELECT * FROM phpwcms_userdetail WHERE detail_login = "'.$login.'" AND detail_aktiv != 9'; 
$resource = mysqli_query($conexao,$query) or die (mysql_error());
      
if(mysqli_num_rows($resource)>0){echo 'erro';} else {echo 'valid';}  

?>