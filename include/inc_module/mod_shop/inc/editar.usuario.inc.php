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

session_start();

// ======= Cria a conexão com o banco de dados =======
require_once ('config/phpwcms/conf.inc.php');
require_once ('include/inc_lib/dbcon.inc.php');
require_once ('include/inc_lib/general.inc.php');
require_once ('include/inc_front/front.func.inc.php');
$conexao = mysqli_connect($phpwcms['db_host'],$phpwcms['db_user'],$phpwcms['db_pass'],$phpwcms['db_table']);
// ===================================================

$preco = _getConfig('shop_pref_preco');
$carrinho = _getConfig('shop_pref_id_cart');
 
$num_user = $_SESSION[session_id().'_userdata']['id'];
	
$consulta_user = 'SELECT * FROM phpwcms_userdetail WHERE detail_id="'.$num_user.'"';
$dados = mysqli_query($conexao, $consulta_user);
$row = mysqli_fetch_array($dados);

if($row['detail_birthday'] == '0000-00-00'){
	$data = '';
} else {
	$data = date('d/m/Y', strtotime($row['detail_birthday']));
}


if(isset($_POST['cad_login'])){
	
	$num_user = $_POST['cad_id'];
	$nascimento = explode('/', $_POST['cad_data']);
	$nas = $nascimento[2].'-'.$nascimento[1].'-'.$nascimento[0];
	
	// Limpeza dos valores que serão passados para o mysql
	$formLogin = mysqli_real_escape_string($conexao, $_POST['cad_login']);
	$formID = mysqli_real_escape_string($conexao, $_POST['cad_id']);
	
	foreach($_POST as $key => $val){
		if(preg_match("/^campo_.+/", $key)){
			$campos_adicionais .= $key.'|'.$val.';';
		} else {
			$campos_adicionais .= '';}
	}
	
	$query = 'SELECT * FROM phpwcms_userdetail WHERE detail_login = "'.$formLogin.'" AND detail_aktiv != 9'; 
	$resource = mysqli_query($conexao,$query) or die (mysql_error());
	
	$query2 = 'SELECT * FROM phpwcms_userdetail WHERE detail_id = "'.$formID.'"'; 
	$resource2 = mysqli_query($conexao,$query2) or die (mysql_error());
	$row = mysqli_fetch_array($resource2);
	
	$autorizadas = implode(';', $_POST['cad_autorizadas']);
	
	$detail['data'] = array(
		'detail_title'		=> '',
		'detail_created'	=> date('Y-m-d H:i:s'),
		'detail_changed'	=> date('Y-m-d H:i:s'),
		'detail_firstname'	=> clean_slweg($_POST['cad_nome']),
		'detail_company'	=> clean_slweg($_POST['cad_empresa']),
		'detail_street'		=> clean_slweg($_POST['cad_endereco']),
		'detail_add'		=> clean_slweg($_POST['cad_numero']),
		'detail_city'		=> clean_slweg($_POST['cad_cidade']),
		'detail_zip'		=> clean_slweg($_POST['cad_cep']),
		'detail_region'		=> clean_slweg($_POST['cad_bairro']),
		'detail_country'	=> clean_slweg($_POST['cad_uf']),
		'detail_fon'		=> clean_slweg($_POST['cad_fone']),
		'detail_mobile'		=> clean_slweg($_POST['cad_cel']),
		'detail_fax'		=> clean_slweg($autorizadas),
		'detail_public'		=> $row['detail_public'],
		'detail_aktiv'		=> $row['detail_aktiv'],
		'detail_birthday'	=> $nas,
		'detail_varchar1'	=> clean_slweg($_POST['cad_rg']),
		'detail_varchar2'	=> $row['detail_varchar2'],
		'detail_varchar3'	=> clean_slweg($_POST['cad_cnpj']),
		'detail_varchar4'	=> clean_slweg($_POST['cad_tel_empresa']),
		'detail_varchar5'	=> clean_slweg($_POST['cad_cel_empresa']),
		'detail_text1'		=> slweg($_POST['cad_site']),
		'detail_text2'		=> slweg($_POST['cad_comp']),
		'detail_text3'		=> clean_slweg($_POST['cad_razao']),
		'detail_text4'		=> clean_slweg($_POST['cad_registro']),
		'detail_text5'		=> clean_slweg($_POST['cad_responsavel']),
		'detail_email'		=> clean_slweg(strtolower($_POST['cad_email'])),
		'detail_login'		=> clean_slweg(strtolower($_POST['cad_login'])),
		'detail_int1'		=> $row['detail_int1'],
		'detail_notes'		=> array(
			'user_login'		=> clean_slweg($_POST['cad_login']),
			'user_firstname'	=> clean_slweg($_POST['cad_nome']),
			'user_tel'			=> clean_slweg($_POST['cad_fone']),
			'user_email'		=> clean_slweg($_POST['cad_email']),
			'user_company'		=> clean_slweg($_POST['cad_empresa']),
			'user_street'		=> clean_slweg($_POST['cad_endereco']),
			'user_zip'			=> clean_slweg($_POST['cad_cep']),
			'user_city'			=> clean_slweg($_POST['cad_cidade']),
		),
	);
		
	if(mysqli_num_rows($resource)>0 && ($_POST['cad_login'] != $row['detail_login'])){
		
		header('Location: '.$_SERVER['REQUEST_URI']);
		
		unset($_SESSION['sucesso_alteracao']);
		$_SESSION['erro_alteracao'] = 1;
		exit;
		
	} else {
		
		$query = "UPDATE phpwcms_userdetail SET ";
		$query .= "detail_title = '".$detail['data']['detail_title']."', ";
		$query .= "detail_firstname = '".$detail['data']['detail_firstname']."', ";
		$query .= "detail_lastname = '".$detail['data']['detail_lastname']."', ";
		$query .= "detail_company = '".$detail['data']['detail_company']."', ";
		$query .= "detail_street = '".$detail['data']['detail_street']."', ";
		$query .= "detail_add = '".$detail['data']['detail_add']."', ";
		$query .= "detail_city = '".$detail['data']['detail_city']."', ";
		$query .= "detail_zip = '".$detail['data']['detail_zip']."', ";
		$query .= "detail_region = '".$detail['data']['detail_region']."', ";
		$query .= "detail_fon = '".$detail['data']['detail_fon']."', ";
		$query .= "detail_fax = '".$detail['data']['detail_fax']."', ";
		$query .= "detail_login = '".$detail['data']['detail_login']."', ";
		$query .= "detail_notes = '".$detail['data']['detail_notes']."', ";
		$query .= "detail_aktiv = '".$detail['data']['detail_aktiv']."', ";
		$query .= "detail_public = '".$detail['data']['detail_public']."', ";
		$query .= "detail_mobile = '".$detail['data']['detail_mobile']."', ";
		$query .= "detail_fax = '".$detail['data']['detail_fax']."', ";
		$query .= "detail_signature = '".$detail['data']['detail_signature']."', ";
		$query .= "detail_prof = '".$detail['data']['detail_prof']."', ";
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
		$query .= "detail_int1 = '".$detail['data']['detail_int1']."', ";
		$query .= "detail_int2 = '".$detail['data']['detail_int2']."' ";
		$query .= "WHERE detail_id = '".$num_user."'";

		$resource = mysqli_query($conexao,$query) or die (mysql_error());
				
	}
	
	if(isset($_POST['voltar-finalizacao-cadastro'])){
		header('Location: '.$_SERVER['HTTP_REQUEST'].'index.php?aid='.$carrinho.'&b=1');
	} else {
		header('Location: '.$_SERVER['REQUEST_URI']);
	}
	
	// Atualiza os dados do usuário (ATUALIZAR POSTERIORMENTE, FAZER DIREITO)
	$_SESSION[ session_id()] = htmlspecialchars($detail['data']['detail_login']);
	$_SESSION[ session_id().'_userdata']['login']	= htmlspecialchars($detail['data']['detail_login']);
	$_SESSION[ session_id().'_userdata']['cep']	= htmlspecialchars($detail['data']['detail_zip']);
	
	$_SESSION['sucesso_alteracao'] = 1;
	exit;
	
} elseif(isset($_POST['cad_nova_senha'])){
	
	$senha = $_POST['cad_senha'];
	$conf_senha = $_POST['cad_conf_senha'];
	$nova_senha = $_POST['cad_nova_senha'];
	
	$query_dados = 'SELECT * FROM phpwcms_userdetail WHERE detail_id = "'.$num_user.'"'; 
	$resource_dados = mysqli_query($conexao,$query_dados) or die (mysql_error());
	$row = mysqli_fetch_array($resource_dados);
	
	if(($senha === $conf_senha) && (md5($senha) === $row['detail_password'])){
		$query = "UPDATE phpwcms_userdetail SET ";
		$query .= "detail_password = '".md5($_POST['cad_nova_senha'])."' ";
		$query .= "WHERE detail_id = '".$num_user."'";
		$resource = mysqli_query($conexao,$query) or die (mysql_error());
		
		header('Location: '.$_SERVER['REQUEST_URI']);
		
		$_SESSION['sucesso_senha'] = 1;
		
	} else {
		
		header('Location: '.$_SERVER['REQUEST_URI']);
		$_SESSION['erro_senha'] = 1;
		
	}
	exit;
	
}


// ================== FORMULÁRIO DE ALTERAÇÃO DE CADASTRO ==================
$nascimento = date('d/m/Y', strtotime($row['detail_birthday']));

$cadastro = '
[JS]include/inc_module/mod_shop/template/scripts/jquery.masked.js[/JS]
[JS]include/inc_module/mod_shop/template/scripts/jquery.alphanum.js[/JS]
[JS]include/inc_module/mod_shop/template/scripts/funcoes-alterar-cadastro.js[/JS]
[JS]Scripts/jquery.validate.js[/JS]
[JS]
<script type="text/javascript">
$().ready(function() {	  
	$("#form-atualizar-cadastro").validate({
	rules:{			
		cad_login:{required: true, email:true},
		},		
	messages:{
		cad_login:{required: "", email:""},
		}
	});
});
</script>
[/JS]


	';
	if(!empty($_SESSION['sucesso_alteracao'])){
		$cadastro .= '<div class="mensagem-alteracao sucesso-alteracao fl">As informações foram alteradas com sucesso.</div>';
		unset($_SESSION['sucesso_alteracao']);
	} else if(empty($_SESSION['sucesso_alteracao']) && !empty($_SESSION['erro_alteracao'])){
		$cadastro .= '<div class="mensagem-alteracao erro-alteracao fl">O e-mail informado já está sendo utilizado.</div>';
		unset($_SESSION['erro_alteracao']);
	}
	
	if(isset($_SESSION['alterar-dados'])){
		$input = '<input type="hidden" name="voltar-finalizacao-cadastro" id="voltar-finalizacao-cadastro" value="1" />';
	} else {
		$input = '';
	}
	
	$cadastro .= '
            
		<form name="form-atualizar-cadastro" id="form-atualizar-cadastro" method="post">
			'.$input.$_SESSION['erro_alteracao'].'
			<input type="hidden" name="cad_id" id="cad_id" value="'.$num_user.'" />
			
			
                        <div class="formulario-shop bloco-form">
                        <h3>Informações de Acesso</h3><br/>
                        
			<p class="b2 login">
				<i></i>
				<strong>Login (seu e-mail):</strong>
				<input type="text" name="cad_login" id="cad_login" value="'.$row['detail_login'].'" />
                                <a href="index.php?aid=9">Alterar Senha</a>
			</p>
                            <p class="b2"></p>

			';
			
			if($row['detail_int1'] === '2'){
			
				$cadastro .= '	
                                    <div class="campos-pessoais">
				<h3>Informações Pessoais</h3>
				<p class="b2">
					<strong>Nome:</strong>
					<input type="text" name="cad_nome" id="cad_nome" value="'.$row['detail_firstname'].'" />
				</p>
				<p class="b2">
					<strong>Telefone:</strong>
					<input type="text" name="cad_fone" id="cad_fone" value="'.$row['detail_fon'].'" />
				</p>
				<p class="b2">
					<strong>Celular:</strong>
					<input type="text" name="cad_cel" id="cad_cel" value="'.$row['detail_mobile'].'" />
				</p>
				<p class="b2">
					<strong>CPF:</strong>
					<input type="text" name="cad_cpf" id="cad_cpf" value="'.$row['detail_varchar2'].'" disabled="disabled" />
				</p>
				<p class="b2">
					<strong>RG:</strong>
					<input type="text" name="cad_rg" id="cad_rg" value="'.$row['detail_varchar1'].'" />
				</p></div>';
				
			} else if($row['detail_int1'] === '1'){
			
				$cadastro .= '	
				<h3>Informações da Empresa</h3>
                                    <div class="campos-empresa">

				<p class="b2">
                    <strong>Nome Fantasia:</strong>
                    <input type="text" name="cad_empresa" id="cad_empresa" value="'.$row['detail_company'].'" />
                </p>
                <p class="b4">
                    <strong>CNPJ:</strong>
                    <input type="text" name="cad_cnpj" id="cad_cnpj" value="'.$row['detail_varchar3'].'" />
                </p>
                <p class="b4">
                    <strong>Registro Estadual:</strong>
                    <input type="text" name="cad_registro" id="cad_registro" value="'.$row['detail_text4'].'" />
                </p>
                <p class="b2">
                    <strong>Razão Social:</strong>
                    <input type="text" name="cad_razao" id="cad_razao" value="'.$row['detail_text3'].'" />
                </p>
                <p class="b4">
                    <strong>Telefone:</strong>
                    <input type="text" name="cad_tel_empresa" id="cad_tel_empresa" value="'.$row['detail_varchar4'].'" />
                </p>
                <p class="b4">
                    <strong>Celular:</strong>
                    <input type="text" name="cad_cel_empresa" id="cad_cel_empresa" value="'.$row['detail_varchar5'].'" />
                </p>
                <p class="b2">
                    <strong>Responsável / Contato:</strong>
                    <input type="text" name="cad_responsavel" id="cad_responsavel" value="'.$row['detail_text5'].'" />
                </p>
                <p class="b2">
                    <strong>Site da Empresa:</strong>
                    <input type="text" name="cad_site" id="cad_site" value="'.$row['detail_text1'].'" />
                </p></div>';
				
			}
			
			$cadastro .= '	
			<h3 class="tit-endereco">Informações de Endereço</h3>
			<p class="b3">
				<strong>CEP:</strong>
				<input type="text" name="cad_cep" id="cad_cep" value="'.$row['detail_zip'].'" />
			</p>
			<p class="b3">
				<strong>Endereço:</strong>
				<input type="text" name="cad_endereco" id="cad_endereco" value="'.$row['detail_street'].'" />
			</p>
			<p class="b3">
				<strong>Bairro:</strong>
				<input type="text" name="cad_bairro" id="cad_bairro" value="'.$row['detail_region'].'" />
			</p>
			<p class="b4">
				<strong>Cidade:</strong>
				<input type="text" name="cad_cidade" id="cad_cidade" value="'.$row['detail_city'].'" />
			</p>
			<p class="b4">
				<strong>Número:</strong>
				<input type="text" name="cad_numero" id="cad_numero" value="'.$row['detail_add'].'" />
			</p>
			<p class="b4">
				<strong>Complemento:</strong>
				<input type="text" name="cad_comp" id="cad_comp" value="'.$row['detail_text2'].'" />
			</p>
			<p class="b4">
				<strong>UF:</strong>
				<select name="cad_uf" id="cad_uf">';
					if($row['detail_country'] == 'AC'){$cadastro .= '<option value="AC" selected="selected">AC</option>';} else {$cadastro .= '<option value="AC">AC</option>';}
					if($row['detail_country'] == 'AL'){$cadastro .= '<option value="AL" selected="selected">AL</option>';} else {$cadastro .= '<option value="AL">AL</option>';}
					if($row['detail_country'] == 'AM'){$cadastro .= '<option value="AM" selected="selected">AM</option>';} else {$cadastro .= '<option value="AM">AM</option>';}
					if($row['detail_country'] == 'AP'){$cadastro .= '<option value="AP" selected="selected">AP</option>';} else {$cadastro .= '<option value="AP">AP</option>';}
					if($row['detail_country'] == 'BA'){$cadastro .= '<option value="BA" selected="selected">BA</option>';} else {$cadastro .= '<option value="BA">BA</option>';}
					if($row['detail_country'] == 'CE'){$cadastro .= '<option value="CE" selected="selected">CE</option>';} else {$cadastro .= '<option value="CE">CE</option>';}
					if($row['detail_country'] == 'DF'){$cadastro .= '<option value="DF" selected="selected">DF</option>';} else {$cadastro .= '<option value="DF">DF</option>';}
					if($row['detail_country'] == 'ES'){$cadastro .= '<option value="ES" selected="selected">ES</option>';} else {$cadastro .= '<option value="ES">ES</option>';}
					if($row['detail_country'] == 'GO'){$cadastro .= '<option value="GO" selected="selected">GO</option>';} else {$cadastro .= '<option value="GO">GO</option>';}
					if($row['detail_country'] == 'MA'){$cadastro .= '<option value="MA" selected="selected">MA</option>';} else {$cadastro .= '<option value="MA">MA</option>';}
					if($row['detail_country'] == 'MG'){$cadastro .= '<option value="MG" selected="selected">MG</option>';} else {$cadastro .= '<option value="MG">MG</option>';}
					if($row['detail_country'] == 'MS'){$cadastro .= '<option value="MS" selected="selected">MS</option>';} else {$cadastro .= '<option value="MS">MS</option>';}
					if($row['detail_country'] == 'MT'){$cadastro .= '<option value="MT" selected="selected">MT</option>';} else {$cadastro .= '<option value="MT">MT</option>';}
					if($row['detail_country'] == 'PA'){$cadastro .= '<option value="PA" selected="selected">PA</option>';} else {$cadastro .= '<option value="PA">PA</option>';}
					if($row['detail_country'] == 'PB'){$cadastro .= '<option value="PB" selected="selected">PB</option>';} else {$cadastro .= '<option value="PB">PB</option>';}
					if($row['detail_country'] == 'PE'){$cadastro .= '<option value="PE" selected="selected">PE</option>';} else {$cadastro .= '<option value="PE">PE</option>';}
					if($row['detail_country'] == 'PI'){$cadastro .= '<option value="PI" selected="selected">PI</option>';} else {$cadastro .= '<option value="PI">PI</option>';}
					if($row['detail_country'] == 'PR'){$cadastro .= '<option value="PR" selected="selected">PR</option>';} else {$cadastro .= '<option value="PR">PR</option>';}
					if($row['detail_country'] == 'RJ'){$cadastro .= '<option value="RJ" selected="selected">RJ</option>';} else {$cadastro .= '<option value="RJ">RJ</option>';}
					if($row['detail_country'] == 'RN'){$cadastro .= '<option value="RN" selected="selected">RN</option>';} else {$cadastro .= '<option value="RN">RN</option>';}
					if($row['detail_country'] == 'RO'){$cadastro .= '<option value="RO" selected="selected">RO</option>';} else {$cadastro .= '<option value="RO">RO</option>';}
					if($row['detail_country'] == 'RR'){$cadastro .= '<option value="RR" selected="selected">RR</option>';} else {$cadastro .= '<option value="RR">RR</option>';}
					if($row['detail_country'] == 'RS'){$cadastro .= '<option value="RS" selected="selected">RS</option>';} else {$cadastro .= '<option value="RS">RS</option>';}
					if($row['detail_country'] == 'SC'){$cadastro .= '<option value="SC" selected="selected">SC</option>';} else {$cadastro .= '<option value="SC">SC</option>';}
					if($row['detail_country'] == 'SE'){$cadastro .= '<option value="SE" selected="selected">SE</option>';} else {$cadastro .= '<option value="SE">SE</option>';}
					if($row['detail_country'] == 'SP' || $row['detail_country'] == ''){$cadastro .= '<option value="SP" selected="selected">SP</option>';} else {$cadastro .= '<option value="SP">SP</option>';}
					if($row['detail_country'] == 'TO'){$cadastro .= '<option value="TO" selected="selected">TO</option>';} else {$cadastro .= '<option value="TO">TO</option>';}
				   $cadastro .= '</select>
			</p>';
			$cadastro .= '<p>
				<strong>&nbsp;</strong>
				<input name="shop_order_step1" type="submit" value="Salvar Alterações" class="bt-continuar" />
			</p>
		</div></form>
	
';


$senha = '
[JS]include/inc_module/mod_shop/template/scripts/funcoes-senha.js[/JS]


	<div class="formulario-shop bloco-form">';
	if(!empty($_SESSION['sucesso_senha'])){
		$senha .= '<div class="mensagem-alteracao sucesso-alteracao fl">Sua senha foi alterada com sucesso.</div>';
		unset($_SESSION['sucesso_senha']);
	} elseif(!empty($_SESSION['erro_senha'])){
		$senha .= '<div class="mensagem-alteracao erro-alteracao fl">A senha informada está incorreta.</div>';
		unset($_SESSION['erro_senha']);
	}
$senha .= '
		<form name="form-atualizar-cadastro" id="form-atualizar-cadastro" method="post">
			<input type="hidden" name="cad_id" id="cad_id" value="'.$num_user.'" />

			<input type="hidden" name="cad_id" id="cad_id" value="'.$num_user.'" />
			<p class="bloco-1">
				<strong>Senha Atual:</strong>
				<input type="password" name="cad_senha" id="cad_senha" value="" placeholder="Senha Atual" class="floatlabel" />
			</p>
			<p class="bloco-1">
				<strong>Digite Novamente:</strong>
				<input type="password" name="cad_conf_senha" id="cad_conf_senha" value="" placeholder="Repetir Senha" class="floatlabel"/>
			</p>
			<p class="bloco-1">
				<strong>Nova Senha:</strong>
				<input type="password" name="cad_nova_senha" id="cad_nova_senha" value="" placeholder="Nova Senha" class="floatlabel"/>
			</p>
			<p class="bloco-1"><input name="shop_order_step1" type="submit" value="Salvar Alteração" class="bt-continuar" /></p>
		</form>


	
</div>';

?>