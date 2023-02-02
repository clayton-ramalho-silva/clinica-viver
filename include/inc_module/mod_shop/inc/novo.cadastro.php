<?php
if(isset($_POST['cad_login'])){
	// ======= Cria a conexão com o banco de dados =======
	require_once ('../../../../config/phpwcms/conf.inc.php');
	include ('../../../../include/inc_lib/default.inc.php');
	include ('../../../../include/inc_lib/general.inc.php');
	$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);
	// ===================================================
	if($_POST['cad_empresa']){$tipo = 1;} else {$tipo = 2;}
	$nascimento = explode('/', $_POST['cad_nascimento']);
	$data = $nascimento[2].'-'.$nascimento[1].'-'.$nascimento[0];
	$detail['data'] = array(
		'detail_title'		=> '',
		'detail_created'	=> date('Y-m-d H:i:s'),
		'detail_changed'	=> date('Y-m-d H:i:s'),
		'detail_firstname'	=> clean_slweg($_POST['cad_nome']),
		'detail_lastname'	=> '',
		'detail_company'	=> clean_slweg($_POST['cad_empresa']),
		'detail_street'		=> clean_slweg($_POST['cad_endereco']),
		'detail_add'		=> clean_slweg($_POST['cad_num']),
		'detail_city'		=> clean_slweg($_POST['cad_cidade']),
		'detail_zip'		=> clean_slweg($_POST['cad_cep']),
		'detail_region'		=> clean_slweg($_POST['cad_bairro']),
		'detail_country'	=> clean_slweg($_POST['cad_uf']),
		'detail_fon'		=> clean_slweg($_POST['cad_fone']),
		'detail_fax'		=> '',
		'detail_mobile'		=> clean_slweg($_POST['cad_cel']),
		'detail_signature'	=> '',
		'detail_prof'		=> '',
		'detail_public'		=> 1,
		'detail_aktiv'		=> 1,
		'detail_newsletter'	=> 0,
		'detail_website'	=> '',
		'detail_gender'		=> '',
		'detail_birthday'	=> $data,
		'detail_varchar1'	=> clean_slweg($_POST['cad_rg']),
		'detail_varchar2'	=> clean_slweg($_POST['cad_cpf']),
		'detail_varchar3'	=> '',
		'detail_varchar4'	=> '',
		'detail_varchar5'	=> '',
		'detail_text1'		=> slweg($_POST['cad_obs']),
		'detail_text2'		=> slweg($_POST['cad_comp']),
		'detail_text3'		=> clean_slweg($_POST['cad_razao']),
		'detail_text4'		=> clean_slweg($_POST['cad_registro']),
		'detail_text5'		=> clean_slweg($_POST['cad_cnpj']),
		'detail_email'		=> clean_slweg($_POST['cad_email']),
		'detail_login'		=> clean_slweg($_POST['cad_login']),
		'detail_password'	=> clean_slweg($_POST['cad_senha']),
		'detail_int1'		=> intval($tipo),
		'detail_int2'		=> '',
		'detail_int3'		=> '',
		'detail_int4'		=> '',
		'detail_int5'		=> '',
		'detail_float1'		=> '',
		'detail_float2'		=> '',
		'detail_float3'		=> '',
		'detail_float4'		=> '',
		'detail_float5'		=> '',
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
	
	$usuario = 'SELECT * FROM phpwcms_userdetail WHERE detail_login = "'.$_POST['cad_login'].'" AND detail_aktiv != 9'; 
	$checagem = mysqli_query($conexao,$usuario) or die (mysql_error());
	
	if(mysqli_num_rows($checagem)>0){
		echo '1';
	} else {
		$query = 'INSERT INTO phpwcms_userdetail (detail_title, detail_firstname, detail_lastname, detail_company, detail_street, detail_add, detail_city, detail_zip, detail_region, detail_fon, detail_login, detail_password, detail_notes, detail_aktiv, detail_prof, detail_signature, detail_public, detail_fax, detail_mobile, detail_country, detail_website, detail_text1, detail_text2, detail_text3, detail_text4, detail_text5, detail_varchar1, detail_varchar2, detail_varchar3, detail_varchar4, detail_varchar5, detail_email, detail_birthday, detail_int1, detail_int2, detail_int3, detail_int4, detail_int5, detail_float1, detail_float2, detail_float3, detail_float4, detail_float5 ) VALUES (';
		$query .= "'".utf8_decode($detail['data']['detail_title'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_firstname'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_lastname'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_company'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_street'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_add'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_city'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_zip'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_region'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_fon'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_login'])."', ";
		$query .= "'".utf8_decode(md5($detail['data']['detail_password']))."', ";
		$query .= "'".utf8_decode(serialize($detail['data']['detail_notes']))."', ";
		$query .= "'".utf8_decode($detail['data']['detail_aktiv'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_prof'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_signature'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_public'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_fax'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_mobile'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_country'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_website'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_text1'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_text2'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_text3'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_text4'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_text5'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_varchar1'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_varchar2'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_varchar3'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_varchar4'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_varchar5'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_email'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_birthday'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_int1'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_int2'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_int3'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_int4'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_int5'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_float1'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_float2'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_float3'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_float4'])."', ";
		$query .= "'".utf8_decode($detail['data']['detail_float5'])."')";

		$resource = mysqli_query($conexao,$query) or die (mysql_error());
		$url = rel_url(array('shop_cart' => 'show'), array('shop_detail'), $_tmpl['config']['cart_url']);
		
		echo "<div class='vpb_success' align='left'></div>
		<script type='text/javascript'>
			$().ready(function(e) {
    		$('.formulario-shop').fadeOut('slow');
			$('.mensagem-cadastro').hide().html('<div class=".$classe."><form action='".$url."'><h3>Cadastro realizado com sucesso</h3><div class=".$classemensagem.">Obrigado por ter se cadastrado em nosso site. Para finalizar sua compra, clique <input type='submit' name='shop_cart_cadastro' value='aqui' class='shop-cart-cadastro'></form></div>').fadeIn('slow');
	});
</script>";		
		
		$from = $phpwcms['admin_email'];
		$to = 'arthur@webcis.com.br';
		$subject = "Badaró Advogados - Novo cadastro realizado";
		$corpo = "Um novo usuário foi cadastrado no shop do site";
		$headers = "From:" . $from."\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to, $subject, $corpo, $headers);
	}
}
?>