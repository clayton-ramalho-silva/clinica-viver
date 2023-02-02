<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2014, Oliver Georgi
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


if($action == 'edit') {
	
	$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']); // Cria a conexão com o banco de dados
	$num_user = intval($_GET['edit']); // Pega o ID do usuário (0 para novo cadastro)
		 
	if($num_user !== 0 && !empty($num_user)){	
	
		$consulta_user = 'SELECT * FROM phpwcms_userdetail WHERE detail_id="'.$num_user.'"';
		$dados = mysqli_query($conexao, $consulta_user);
		$row = mysqli_fetch_array($dados);
	
		if (isset($_POST['atualizar'])){	
				
			// Configura a senha. Se o campo estiver em branco, mantêm a senha original
			if($_POST['senha_user'] != ""){
				$senha = md5(clean_slweg($_POST['senha_user']));
			} else {
				$senha = $row['detail_password'];
			}
			
			// Gera a data de nascimento para o banco
			$nascimento = explode('/', $_POST['nascimento_user']);
			$data = $nascimento[2].'-'.$nascimento[1].'-'.$nascimento[0];
			
			// Checa se o uduário está ativo
			if(isset($_POST['ativo_user'])){ $ativo = 1; } else { $ativo = 0; }
			
			$detail['data'] = array(
				'detail_changed'	=> date('Y-m-d H:i:s'),
				'detail_firstname'	=> clean_slweg($_POST['nome_user']),		// Nome
				'detail_company'	=> clean_slweg($_POST['empresa_user']),		// Empresa
				'detail_street'		=> clean_slweg($_POST['endereco_user']),	// Endereço
				'detail_add'		=> clean_slweg($_POST['numero_user']),		// Número
				'detail_city'		=> clean_slweg($_POST['cidade_user']),		// Cidade
				'detail_zip'		=> clean_slweg($_POST['cep_user']),			// CEP
				'detail_region'		=> clean_slweg($_POST['bairro_user']),		// Bairro
				'detail_country'	=> clean_slweg($_POST['estado_user']),		// Estado
				'detail_fon'		=> clean_slweg($_POST['fone_user']),		// Telefone
				'detail_mobile'		=> clean_slweg($_POST['cel_user']),			// Celular
				'detail_website'	=> slweg($_POST['obs_user']),				// Observações
				'detail_gender'		=> '',
				'detail_public'		=> 1,										// Público
				'detail_aktiv'		=> $ativo,									// Ativo
				'detail_newsletter'	=> 0,
				'detail_birthday'	=> $data,									// Aniversário
				'detail_varchar1'	=> clean_slweg($_POST['rg_user']),			// RG
				'detail_varchar2'	=> $row['detail_varchar2'],					// CPF (não alterável)
				'detail_varchar3'	=> clean_slweg($_POST['cnpj_user']),		// CNPJ
				'detail_varchar4'	=> clean_slweg($_POST['tel_empresa_user']),	// Telefone Empresa
				'detail_varchar5'	=> clean_slweg($_POST['cel_empresa_user']),	// Celular Empresa
				'detail_text1'		=> slweg($_POST['site_user']),				// Site
				'detail_text2'		=> slweg($_POST['comp_user']),				// Complemento
				'detail_text3'		=> clean_slweg($_POST['razao_user']),		// Razão Social
				'detail_text4'		=> clean_slweg($_POST['registro_user']),	// Registro Empresa
				'detail_text5'		=> clean_slweg($_POST['responsavel_user']),	// Responsável Empresa
				'detail_email'		=> clean_slweg($_POST['email_user']),		// E-mail (igual a Login)
				'detail_login'		=> clean_slweg($_POST['login_user']),		// Login (igual a E-mail)
				'detail_password'	=> $senha,									// Senha
				'detail_int1'		=> $row['detail_int1'],
				'detail_notes'		=> array(
					'user_login'		=> clean_slweg($_POST['login_user']),
					'user_firstname'	=> clean_slweg($_POST['nome_user']),
					'user_lastname'		=> '',
					'user_tel'			=> clean_slweg($_POST['fone_user']),
					'user_email'		=> clean_slweg($_POST['email_user']),
					'user_company'		=> clean_slweg($_POST['empresa_user']),
					'user_gender'		=> '',
					'user_street'		=> clean_slweg($_POST['endereco_user']),
					'user_zip'			=> clean_slweg($_POST['cep_user']),
					'user_city'			=> clean_slweg($_POST['cidade_user']),
					'user_title'		=> '',
					'user_name'			=> '',
					'user_image'		=> '',
				),
			);
		
			$usuario = 'SELECT * FROM phpwcms_userdetail WHERE detail_login = "'.$_POST['login_user'].'" AND detail_aktiv != 9'; 
			$checagem = mysqli_query($conexao,$usuario) or die (mysql_error());
			$info = mysqli_fetch_array($checagem);
			
			if(mysqli_num_rows($checagem)>0 && $_POST['login_user'] != $row['detail_login']){
				$erro = '1'; // Retorna 1 se o login já estiver sendo utilizado
			} else {
				$query  = "UPDATE phpwcms_userdetail SET ";
				$query .= "detail_firstname = '".$detail['data']['detail_firstname']."', ";
				$query .= "detail_company = '".$detail['data']['detail_company']."', ";
				$query .= "detail_street = '".$detail['data']['detail_street']."', ";
				$query .= "detail_add = '".$detail['data']['detail_add']."', ";
				$query .= "detail_city = '".$detail['data']['detail_city']."', ";
				$query .= "detail_zip = '".$detail['data']['detail_zip']."', ";
				$query .= "detail_region = '".$detail['data']['detail_region']."', ";
				$query .= "detail_fon = '".$detail['data']['detail_fon']."', ";
				$query .= "detail_login = '".$detail['data']['detail_login']."', ";
				$query .= "detail_password = '".$detail['data']['detail_password']."', ";
				$query .= "detail_notes = '".serialize($detail['data']['detail_notes'])."', ";
				$query .= "detail_aktiv = '".$detail['data']['detail_aktiv']."', ";
				$query .= "detail_public = '".$detail['data']['detail_public']."', ";
				$query .= "detail_mobile = '".$detail['data']['detail_mobile']."', ";
				$query .= "detail_website = '".$detail['data']['detail_website']."', ";
				$query .= "detail_gender = '".$detail['data']['detail_gender']."', ";
				$query .= "detail_country = '".$detail['data']['detail_country']."', ";
				$query .= "detail_text1 = '".$detail['data']['detail_text1']."', ";
				$query .= "detail_text2 = '".$detail['data']['detail_text2']."', ";
				$query .= "detail_text3 = '".$detail['data']['detail_text3']."', ";
				$query .= "detail_text4 = '".$detail['data']['detail_text4']."', ";
				$query .= "detail_text5 = '".$detail['data']['detail_text5']."', ";
				$query .= "detail_varchar1 = '".$detail['data']['detail_varchar1']."', ";
				$query .= "detail_varchar2 = '".$detail['data']['detail_varchar2']."', ";
				$query .= "detail_varchar3 = '".$detail['data']['detail_varchar3']."', ";
				$query .= "detail_varchar4 = '".$detail['data']['detail_varchar4']."', ";
				$query .= "detail_varchar5 = '".$detail['data']['detail_varchar5']."', ";
				$query .= "detail_email = '".$detail['data']['detail_email']."', ";
				$query .= "detail_birthday = '".$detail['data']['detail_birthday']."', ";
				$query .= "detail_int1 = '".$detail['data']['detail_int1']."' ";
				$query .= "WHERE detail_id = '".$num_user."'";
				$resource = mysqli_query($conexao,$query) or die (mysql_error());
			}
			header("location: http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]."");
		}
		
	} else {
	
		if (isset($_POST['atualizar'])){	
			
			if($_POST['empresa_user']){
				$tipo = 1;
			} else {
				$tipo = 2;
			}
			
			// Gera a data de nascimento para o banco
			$nascimento = explode('/', $_POST['nascimento_user']);
			$data = $nascimento[2].'-'.$nascimento[1].'-'.$nascimento[0];
			
			// Checa se o uduário está ativo
			if(isset($_POST['ativo_user'])){ $ativo = 1; } else { $ativo = 0; }
			
			$detail['data'] = array(
				'detail_changed'	=> date('Y-m-d H:i:s'),
				'detail_firstname'	=> clean_slweg($_POST['nome_user']),		// Nome
				'detail_company'	=> clean_slweg($_POST['empresa_user']),		// Empresa
				'detail_street'		=> clean_slweg($_POST['endereco_user']),	// Endereço
				'detail_add'		=> clean_slweg($_POST['numero_user']),		// Número
				'detail_city'		=> clean_slweg($_POST['cidade_user']),		// Cidade
				'detail_zip'		=> clean_slweg($_POST['cep_user']),			// CEP
				'detail_region'		=> clean_slweg($_POST['bairro_user']),		// Bairro
				'detail_country'	=> clean_slweg($_POST['estado_user']),		// Estado
				'detail_fon'		=> clean_slweg($_POST['fone_user']),		// Telefone
				'detail_mobile'		=> clean_slweg($_POST['cel_user']),			// Celular
				'detail_website'	=> '',
				'detail_gender'		=> '',
				'detail_public'		=> 1,										// Público
				'detail_aktiv'		=> $ativo,									// Ativo
				'detail_newsletter'	=> 0,
				'detail_birthday'	=> $data,									// Aniversário
				'detail_varchar1'	=> clean_slweg($_POST['rg_user']),			// RG
				'detail_varchar2'	=> clean_slweg($_POST['cpf_user']),			// CPF
				'detail_varchar3'	=> clean_slweg($_POST['cnpj_user']),		// CNPJ		
				'detail_text1'		=> slweg($_POST['obs_user']),				// Observações
				'detail_text2'		=> slweg($_POST['comp_user']),				// Complemento
				'detail_text3'		=> clean_slweg($_POST['razao_user']),		// Razão Social
				'detail_text4'		=> clean_slweg($_POST['registro_user']),	// Registro Empresa
				'detail_email'		=> clean_slweg($_POST['email_user']),		// E-mail (igual a Login)
				'detail_login'		=> clean_slweg($_POST['login_user']),		// Login (igual a E-mail)
				'detail_password'	=> md5(clean_slweg($_POST['senha_user'])),	// Senha
				'detail_int1'		=> $tipo,
				'detail_notes'		=> array(
					'user_login'		=> clean_slweg($_POST['login_user']),
					'user_firstname'	=> clean_slweg($_POST['nome_user']),
					'user_lastname'		=> '',
					'user_tel'			=> clean_slweg($_POST['fone_user']),
					'user_email'		=> clean_slweg($_POST['email_user']),
					'user_company'		=> clean_slweg($_POST['empresa_user']),
					'user_gender'		=> '',
					'user_street'		=> clean_slweg($_POST['endereco_user']),
					'user_zip'			=> clean_slweg($_POST['cep_user']),
					'user_city'			=> clean_slweg($_POST['cidade_user']),
					'user_title'		=> '',
					'user_name'			=> '',
					'user_image'		=> '',
				),
			);
		
			$usuario = 'SELECT * FROM phpwcms_userdetail WHERE detail_login = "'.$_POST['login_user'].'" AND detail_aktiv != 9'; 
			$checagem = mysqli_query($conexao,$usuario) or die (mysql_error());
			$info = mysqli_fetch_array($checagem);
			
			if(mysqli_num_rows($checagem)>0){
				
				$_SESSION['erro-login'] = '1'; // Retorna 1 se o login já estiver sendo utilizado
				
			} else {

				$sqlUltimoID = 'SELECT detail_id FROM phpwcms_userdetail ORDER BY detail_id DESC LIMIT 1'; 
				$resUltimoID = mysqli_query($conexao, $sqlUltimoID) or die (mysql_error());
				$ultimoID = mysqli_fetch_array($resUltimoID);
				$idNovo = intval($ultimoID['detail_id']) + 1;
								
				$query  = "INSERT INTO phpwcms_userdetail (detail_firstname, detail_company, ";
				$query .= "detail_street, detail_add, detail_city, detail_zip, detail_region, ";
				$query .= "detail_fon, detail_login, detail_password, detail_notes, detail_aktiv, ";
				$query .= "detail_public, detail_mobile, detail_website, detail_gender, detail_country, ";
				$query .= "detail_text1, detail_text2, detail_text3, detail_text4, detail_varchar1, ";
				$query .= "detail_varchar2, detail_varchar3, detail_email,detail_birthday, detail_int1) ";
				$query .= " VALUES (";
				$query .= "'".$detail['data']['detail_firstname']."', '".$detail['data']['detail_company']."', ";
				$query .= "'".$detail['data']['detail_street']."', '".$detail['data']['detail_add']."', ";
				$query .= "'".$detail['data']['detail_city']."', '".$detail['data']['detail_zip']."', ";
				$query .= "'".$detail['data']['detail_region']."', '".$detail['data']['detail_fon']."', ";
				$query .= "'".$detail['data']['detail_login']."', '".$detail['data']['detail_password']."', ";
				$query .= "'".serialize($detail['data']['detail_notes'])."', '".$detail['data']['detail_aktiv']."', ";
				$query .= "'".$detail['data']['detail_public']."', '".$detail['data']['detail_mobile']."', ";
				$query .= "'".$detail['data']['detail_website']."', '".$detail['data']['detail_gender']."', ";
				$query .= "'".$detail['data']['detail_country']."', '".$detail['data']['detail_text1']."', ";
				$query .= "'".$detail['data']['detail_text2']."', '".$detail['data']['detail_text3']."', ";
				$query .= "'".$detail['data']['detail_text4']."', '".$detail['data']['detail_varchar1']."', ";
				$query .= "'".$detail['data']['detail_varchar2']."', '".$detail['data']['detail_varchar3']."', ";
				$query .= "'".$detail['data']['detail_email']."', '".$detail['data']['detail_birthday']."', ";
				$query .= "'".$detail['data']['detail_int1']."')";
				$resource = mysqli_query($conexao,$query) or die (mysql_error());
				
				$pagina = htmlspecialchars_decode(shop_url(array('controller=users', 'edit='.$idNovo.'')));
				header("location: ".$pagina."");
				
			}
				
		}
	
	}
	
	if (isset($_POST['voltar'])){
		headerRedirect( shop_url('controller=users', '') );
	}	

} elseif($action == 'delete') {

	$plugin['data']['detail_id']		= intval($_GET['delete']);

	$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_userdetail SET ';
	$sql .= "detail_aktiv = 9 WHERE detail_id = ".$plugin['data']['detail_id'];

	_dbQuery($sql, 'UPDATE');

	headerRedirect( shop_url('controller=users', '') );

}


?>