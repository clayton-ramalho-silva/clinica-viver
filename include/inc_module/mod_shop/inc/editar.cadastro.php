<?php
if(isset($_POST['cad_login'])){
	// ======= Cria a conexão com o banco de dados =======
	require_once ('../../../../config/phpwcms/conf.inc.php');
	include ('../../../../include/inc_lib/default.inc.php');
	include ('../../../../include/inc_lib/general.inc.php');
	include ('../../../../include/inc_front/front.func.inc.php');
	$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);
	// ===================================================
	$num_user = $_POST['cad_id'];
	
	$query = 'SELECT * FROM phpwcms_userdetail WHERE detail_login = "'.$_POST['cad_login'].'" AND detail_aktiv != 9'; 
	$resource = mysqli_query($conexao,$query) or die (mysql_error());
	
	$query2 = 'SELECT * FROM phpwcms_userdetail WHERE detail_id = "'.$_POST['cad_id'].'"'; 
	$resource2 = mysqli_query($conexao,$query2) or die (mysql_error());
	$row = mysqli_fetch_array($resource2);
	
	if($_POST['cad_senha'] != ""){$senha = md5(clean_slweg($_POST['cad_senha']));} else {$senha = $row['detail_password'];} 
	
	$detail['data'] = array(
		'detail_title'		=> '',
		'detail_created'	=> date('Y-m-d H:i:s'),
		'detail_changed'	=> date('Y-m-d H:i:s'),
		'detail_firstname'	=> clean_slweg($_POST['cad_nome']),
		'detail_lastname'	=> clean_slweg($_POST['cad_fantasia']),
		'detail_company'	=> clean_slweg($_POST['cad_pais']),
		'detail_street'		=> clean_slweg($_POST['cad_endereco']),
		'detail_city'		=> clean_slweg($_POST['cad_cidade']),
		'detail_zip'		=> clean_slweg($_POST['cad_cep']),
		'detail_region'		=> clean_slweg($_POST['cad_bairro']),
		'detail_country'	=> clean_slweg($_POST['cad_uf']),
		'detail_fon'		=> clean_slweg($_POST['cad_fone']),
		'detail_mobile'		=> clean_slweg($_POST['cad_cel']),
		'detail_prof'		=> clean_slweg($_POST['cad_atendido']),
		'detail_public'		=> $row['detail_public'],
		'detail_aktiv'		=> $row['detail_aktiv'],
		'detail_varchar1'	=> utf8_encode($row['detail_varchar1']),
		'detail_varchar2'	=> $row['detail_varchar2'],
		'detail_varchar3'	=> clean_slweg($_POST['cad_ie']),
		'detail_varchar4'	=> '',
		'detail_varchar5'	=> '',
		'detail_text1'		=> slweg($_POST['cad_obs']),
		'detail_text2'		=> slweg($_POST['cad_comp']),
		'detail_text3'		=> clean_slweg($_POST['cad_razao']),
		'detail_text4'		=> clean_slweg($_POST['cad_registro']),
		'detail_text5'		=> $campos_adicionais,
		'detail_email'		=> clean_slweg($_POST['cad_email']),
		'detail_login'		=> clean_slweg(strtolower($_POST['cad_login'])),
		'detail_password'	=> $senha,
		'detail_notes'		=> array(
			'user_login'		=> clean_slweg($_POST['cad_login']),
			'user_firstname'	=> clean_slweg($_POST['cad_nome']),
			'user_lastname'		=> '',
			'user_tel'			=> clean_slweg($_POST['cad_fone']),
			'user_email'		=> clean_slweg($_POST['cad_email']),
			'user_company'		=> clean_slweg($_POST['cad_empresa']),
			'user_gender'		=> '',
			'user_street'		=> clean_slweg($_POST['cad_endereco']),
			'user_zip'			=> clean_slweg($_POST['cad_cep']),
			'user_city'			=> clean_slweg($_POST['cad_cidade']),
			'user_title'		=> '',
			'user_name'			=> '',
			'user_image'		=> '',
		),
	);
	
	if(mysqli_num_rows($resource)>0 && ($_POST['cad_login'] != $row['detail_login'])){
		echo '1';
	} else {
		$query = "UPDATE phpwcms_userdetail SET ";
		$query .= "detail_firstname = '".utf8_decode($detail['data']['detail_firstname'])."', ";
		$query .= "detail_lastname = '".utf8_decode($detail['data']['detail_lastname'])."', ";
		$query .= "detail_company = '".utf8_decode($detail['data']['detail_company'])."', ";
		$query .= "detail_street = '".utf8_decode($detail['data']['detail_street'])."', ";
		$query .= "detail_city = '".utf8_decode($detail['data']['detail_city'])."', ";
		$query .= "detail_zip = '".utf8_decode($detail['data']['detail_zip'])."', ";
		$query .= "detail_region = '".utf8_decode($detail['data']['detail_region'])."', ";
		$query .= "detail_fon = '".utf8_decode($detail['data']['detail_fon'])."', ";
		$query .= "detail_mobile = '".utf8_decode($detail['data']['detail_mobile'])."', ";
		$query .= "detail_prof = '".utf8_decode($detail['data']['detail_prof'])."', ";
		$query .= "detail_login = '".utf8_decode($detail['data']['detail_login'])."', ";
		$query .= "detail_password = '".$detail['data']['detail_password']."', ";
		$query .= "detail_notes = '".serialize($detail['data']['detail_notes'])."', ";
		$query .= "detail_aktiv = '".utf8_decode($detail['data']['detail_aktiv'])."', ";
		$query .= "detail_public = '".utf8_decode($detail['data']['detail_public'])."', ";
		$query .= "detail_country = '".utf8_decode($detail['data']['detail_country'])."', ";
		$query .= "detail_varchar1 = '".utf8_decode($detail['data']['detail_varchar1'])."', ";
		$query .= "detail_varchar2 = '".utf8_decode($detail['data']['detail_varchar2'])."', ";
		$query .= "detail_varchar3 = '".utf8_decode($detail['data']['detail_varchar3'])."', ";
		$query .= "detail_email = '".utf8_decode($detail['data']['detail_login'])."', ";
		$query .= "detail_int1 = '".utf8_decode($detail['data']['detail_int1'])."' ";
		$query .= "WHERE detail_id = '".$num_user."'";

		$resource = mysqli_query($conexao,$query) or die (mysql_error());
	}
}
?>