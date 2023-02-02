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

// ======= Cria a conexão com o banco de dados =======
require_once ('config/phpwcms/conf.inc.php');
require_once ('include/inc_lib/dbcon.inc.php');
require_once ('include/inc_lib/general.inc.php');
require_once ('include/inc_front/front.func.inc.php');
$conexao = mysqli_connect($phpwcms['db_host'],$phpwcms['db_user'],$phpwcms['db_pass'],$phpwcms['db_table']);
// ===================================================


// =========== CONFIGURAÇÕES GERAIS ==========

$preco = _getConfig('shop_pref_preco'); // Checa se a opção "Esconder preço" esta ativada
$url = 'index.php?aid='.$GLOBALS['content']['article_id']; // URL para os links do paginate

// Busca o ID do cliente
$num_user = $_SESSION[session_id().'_userdata']['id'];
$consulta_user = 'SELECT * FROM phpwcms_userdetail WHERE detail_id="'.$num_user.'"';
$dados = mysqli_query($conexao, $consulta_user);
$row = mysqli_fetch_array($dados);

// --- Paginate ---
$range = 3; // Quantidade de páginas a serem mostradas como opções
$rowsporpagina = 5; // Quantidade de resultados por página
isset($_GET['pg']) ? $pagina = $_GET['pg'] : $pagina = ''; // Checa o número da página do paginate

// ========== FIM DAS CONFIGURAÇÕES ==========


if($row['detail_birthday'] === '0000-00-00'){
	$data = '';
} else {
	$data = date('d/m/Y', strtotime($row['detail_birthday']));
}


if(isset($_POST['cad_login'])){
	
	$num_user = $_POST['cad_id'];
	$nascimento = explode('/', $_POST['cad_nascimento']);
	$nas = $nascimento[2].'-'.$nascimento[1].'-'.$nascimento[0];
	
	// Limpeza dos valores que serão passados para o mysql
	$formLogin = mysqli_real_escape_string($conexao, $_POST['cad_login']);
	$formID = mysqli_real_escape_string($conexao, $_POST['cad_id']);
	
	/* Campos Adicinais (EM DESENVOLVIMENTO)
	foreach($_POST as $key => $val){
		if(preg_match("/^campo_.+/", $key)){
			$campos_adicionais .= $key.'|'.$val.';';
		} else {
			$campos_adicionais .= '';}
	}
	*/
	
	$query = 'SELECT * FROM phpwcms_userdetail WHERE detail_login = "'.$formLogin.'" AND detail_aktiv != 9'; 
	$resource = mysqli_query($conexao,$query) or die (mysql_error());
	
	$query2 = 'SELECT * FROM phpwcms_userdetail WHERE detail_id = "'.$formID.'"'; 
	$resource2 = mysqli_query($conexao,$query2) or die (mysql_error());
	$row = mysqli_fetch_array($resource2);
	
	$data = date('dmyHis');
	$arquivo = $data.'_'.$_FILES['arquivo']['name'];
	
	$detail['data'] = array(
		'detail_title'		=> '',
		'detail_created'	=> date('Y-m-d H:i:s'),
		'detail_changed'	=> date('Y-m-d H:i:s'),
		'detail_firstname'	=> clean_slweg($_POST['cad_nome']),
		'detail_company'	=> clean_slweg($_POST['cad_empresa']),
		'detail_street'		=> clean_slweg($_POST['cad_endereco_ent']),
		'detail_add'		=> clean_slweg($_POST['cad_num_ent']),
		'detail_city'		=> clean_slweg($_POST['cad_cidade_ent']),
		'detail_zip'		=> clean_slweg($_POST['cad_cep_ent']),
		'detail_region'		=> clean_slweg($_POST['cad_bairro_ent']),
		'detail_country'	=> clean_slweg($_POST['cad_uf_ent']),
		'detail_fon'		=> clean_slweg($_POST['cad_fone']),
		'detail_fax'		=> '',
		'detail_mobile'		=> clean_slweg($_POST['cad_cel']),
		'detail_signature'	=> '',
		'detail_prof'		=> '',
		'detail_public'		=> $row['detail_public'],
		'detail_aktiv'		=> $row['detail_aktiv'],
		'detail_newsletter'	=> 0,
		'detail_website'	=> '',
		'detail_gender'		=> '',
		'detail_birthday'	=> $nas,
		'detail_varchar1'	=> clean_slweg($_POST['cad_rg']),
		'detail_varchar2'	=> $row['detail_varchar2'],
		'detail_varchar3'	=> clean_slweg($_POST['cad_cnpj']),
		'detail_varchar4'	=> '',
		'detail_varchar5'	=> '',
		'detail_text2'		=> clean_slweg($_POST['cad_comp_ent']),
		'detail_text3'		=> clean_slweg($_POST['cad_razao']),
		'detail_text4'		=> clean_slweg($_POST['cad_registro']),
		'detail_text5'		=> '',
		'detail_email'		=> clean_slweg($_POST['cad_email']),
		'detail_login'		=> clean_slweg(strtolower($_POST['cad_login'])),
		'detail_int1'		=> $row['detail_int1'],
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
	
	$upload_dir= 'content/arquivos';
	if(isset($_FILES['arquivo']['tmp_name'])){
		if(is_uploaded_file($_FILES['arquivo']['tmp_name'])){
			$nomes = $data.'_'.$_FILES['arquivo']['name'];
			$files = $upload_dir.'/'.$data.'_'.$_FILES['arquivo']['name'];
           	copy(
				$_FILES['arquivo']['tmp_name'],
				$upload_dir.'/'.$data.'_'.$_FILES['arquivo']['name']
			);
       	}
	}
	
	if(mysqli_num_rows($resource)>0 && ($_POST['cad_login'] != $row['detail_login'])){
		echo '1';
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
		$query .= "detail_signature = '".$detail['data']['detail_signature']."', ";
		$query .= "detail_prof = '".$detail['data']['detail_prof']."', ";
		$query .= "detail_website = '".$detail['data']['detail_website']."', ";
		$query .= "detail_gender = '".$detail['data']['detail_gender']."', ";
		$query .= "detail_country = '".$detail['data']['detail_country']."', ";
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
	
	header('Location: '.$_SERVER['REQUEST_URI']);
	
	// Atualiza os dados do usuário (ATUALIZAR POSTERIORMENTE, FAZER DIREITO)
	$_SESSION[ session_id()] = htmlspecialchars($detail['data']['detail_login']);
	$_SESSION[ session_id().'_userdata']['login']	= htmlspecialchars($detail['data']['detail_login']);
	$_SESSION[ session_id().'_userdata']['cep']	= htmlspecialchars($detail['data']['detail_zip']);
	
	$_SESSION['sucesso-dados'] = '<div class="mensagem-alteracao-sucesso fr">As informações foram alteradas com sucesso.</div>';
	exit;
	
} else if(isset($_POST['cad_senha']) && isset($_POST['cad_conf_senha']) && isset($_POST['cad_nova_senha'])){
	
	$num_user = $_POST['cad_id'];
	$senha = $_POST['cad_senha'];
	$conf_senha = $_POST['cad_conf_senha'];
	$nova_senha = $_POST['cad_nova_senha'];
	
	if(($senha === $conf_senha) && (md5($senha) === $row['detail_password'])){
		$query  = "UPDATE phpwcms_userdetail SET ";
		$query .= "detail_password = '".md5($_POST['cad_nova_senha'])."' ";
		$query .= "WHERE detail_id = '".$num_user."'";
		$resource = mysqli_query($conexao,$query) or die (mysql_error($conexao));
		
		header('Location: '.$_SERVER['REQUEST_URI']);
		
		$_SESSION['sucesso-senha'] = '<div class="mensagem-alteracao-sucesso fr">As informações foram alteradas com sucesso</div>';
		exit;
		
	} else {
		
		header('Location: '.$_SERVER['REQUEST_URI']);
		
		$_SESSION['erro-senha'] = '<div class="mensagem-alteracao-erro fr">Senha atual incorreta</div>';
		exit;
		
	}
	
}

// ================== ALTERAÇÃO DE CADASTRO ==================

$cadastro = '';

// Mensagens de erro e sucesso
if($_SESSION['sucesso-dados']){

	$cadastro .= $_SESSION['sucesso-dados'];
	unset($_SESSION['sucesso-dados']);

}

$cadastro .= '
{HEAD:include/inc_module/mod_shop/template/scripts/jquery.alphanum.js}
{HEAD:include/inc_module/mod_shop/template/scripts/jquery.masked.js}
{HEAD:include/inc_module/mod_shop/template/scripts/funcoes-alterar-cadastro.js}

<div class="formulario-shop">
	<form name="form-atualizar-cadastro" id="form-atualizar-cadastro" method="post" enctype="multipart/form-data">
		<input type="hidden" name="cad_id" id="cad_id" value="'.$num_user.'" />
		<p class="campo1-l login pr">
			<i></i>
			<strong>Login:</strong>
			<input type="text" name="cad_login" id="cad_login" value="'.htmlspecialchars($row['detail_login']).'" />
		</p>';
		
	if($row['detail_int1'] == 1){
		$cadastro .= '<h4>Informações da Empresa</h4>
			<p class="campo2-l">
				<strong>Empresa:</strong>
				<input type="text" name="cad_empresa" id="cad_empresa" value="'.htmlspecialchars($row['detail_company']).'" />
			</p>
			<p class="campo2-r">
				<strong>Razão Social:</strong>
				<input type="text" name="cad_razao" id="cad_razao" value="'.htmlspecialchars($row['detail_text3']).'" />
			</p>
			<p class="campo2-l">
				<strong>Registro Estadual:</strong>
				<input type="text" name="cad_registro" id="cad_registro" value="'.htmlspecialchars($row['detail_text4']).'" />
			</p>
			<p class="campo2-r">
				<strong>CNPJ:</strong>
				<input type="text" name="cad_cnpj" id="cad_cnpj" value="'.htmlspecialchars($row['detail_varchar3']).'" />
			</p>';
	}
	
	$cadastro .= '<h4>Informações Pessoais</h4>
		<p class="campo2-l">
			<strong>Nome:</strong>
			<input type="text" name="cad_nome" id="cad_nome" value="'.htmlspecialchars($row['detail_firstname']).'" />
		</p>
		<p class="campo2-l">
			<strong>E-mail:</strong>
			<input type="text" name="cad_email" id="cad_email" value="'.htmlspecialchars($row['detail_email']).'" />
		</p>
		<p class="campo4-l">
			<strong>RG:</strong>
			<input type="text" name="cad_rg" id="cad_rg" value="'.htmlspecialchars($row['detail_varchar1']).'" />
		</p>
		<p class="campo4-r">
			<strong>CPF:</strong>
			<input type="text" name="cad_cpf" id="cad_cpf" value="'.htmlspecialchars($row['detail_varchar2']).'" disabled="disabled" />
		</p>
		<p class="campo4-ll">
			<strong>Data de Nascimento:</strong>
			<input type="text" name="cad_nascimento" id="cad_nascimento" value="'.$data.'" />
		</p>
		<p class="campo4-l">
			<strong>Telefone:</strong>
			<input type="text" name="cad_fone" id="cad_fone" value="'.htmlspecialchars($row['detail_fon']).'" />
		</p>
		<p class="campo4-l">
			<strong>Celular:</strong>
			<input type="text" name="cad_cel" id="cad_cel" value="'.htmlspecialchars($row['detail_mobile']).'" />
		</p>
		
		<h4>Endereço de Entrega</h4>
		
		<p class="campo1">
			<strong>CEP:</strong>
			<input type="text" name="cad_cep_ent" id="cad_cep_ent" value="'.htmlspecialchars($row['detail_zip']).'" />
		</p>
		<p class="campo2-l">
			<strong>Endereço:</strong>
			<input type="text" name="cad_endereco_ent" id="cad_endereco_ent" value="'.htmlspecialchars($row['detail_street']).'" />
		</p>
		<p class="campo4-l">
			<strong>Número:</strong>
			<input type="text" name="cad_num_ent" id="cad_num_ent" value="'.htmlspecialchars($row['detail_add']).'" />
		</p>
		<p class="campo4-r">
			<strong>Complemento:</strong>
			<input type="text" name="cad_comp_ent" id="cad_comp_ent" value="'.htmlspecialchars($row['detail_text2']).'" />
		</p>
		<p class="campo2-l">
			<strong>Bairro:</strong>
			<input type="text" name="cad_bairro_ent" id="cad_bairro_ent" value="'.htmlspecialchars($row['detail_region']).'" />
		</p>
		<p class="campo4-l">
			<strong>Cidade:</strong>
			<input type="text" name="cad_cidade_ent" id="cad_cidade_ent" value="'.htmlspecialchars($row['detail_city']).'" />
		</p>
		<p class="campo4-r">
			<strong>UF:</strong>
			'.estados('cad_uf_ent', $row['detail_country']).'
		</p>
		<p>
			<strong>&nbsp;</strong>
			<input name="shop_order_step1" type="submit" value="Salvar Alterações" class="bt-continuar" />
		</p>
	</form>
</div>';


// ================== ALTERAÇÃO DE SENHA ==================

$senha = '';

// Mensagens de erro e sucesso
if($_SESSION['sucesso-senha']){
	
	$senha .= $_SESSION['sucesso-senha'];
	unset($_SESSION['sucesso-senha']);
	
} else if(isset($_SESSION['erro-senha'])){
	
	$senha .= $_SESSION['erro-senha'];
	unset($_SESSION['erro-senha']);
	
}

$senha .= '
{HEAD:include/inc_module/mod_shop/template/scripts/funcoes-senha.js}

<div class="formulario-shop form-senha">
	<form name="form-atualizar-cadastro" id="form-atualizar-cadastro" method="post">
		<input type="hidden" name="cad_id" id="cad_id" value="'.$num_user.'" />
		<p class="campo2-l senha fl pr">
			<strong>Senha Atual:
				<i></i>
			</strong>
			<input type="password" name="cad_senha" id="cad_senha" value="" />
		</p>
		<p class="campo2-r conf-senha fl pr">
			<strong>Digite Novamente:
				<i></i>
			</strong>
			<input type="password" name="cad_conf_senha" id="cad_conf_senha" value="" />
		</p>
		<p class="campo1-l">
			<strong>Nova Senha:</strong>
			<input type="password" name="cad_nova_senha" id="cad_nova_senha" value="" />
		</p>
		<p>
			<input name="shop_order_step1" type="submit" value="Salvar Alteração" class="bt-continuar" />
		</p>
	</form>
</div>';


// =============================== Histórico de Pedidos ===============================

$sql = 'SELECT * FROM phpwcms_shop_orders WHERE order_user_id = '.$num_user;
list($result_paginate, $totalpaginas, $paginaatual, $numerorows) = paginate($sql, $rowsporpagina, $pagina, 'ORDER BY order_id DESC LIMIT', $conexao);

	// Muda as classes caso não haja Forma de Pagamento
	if($preco != '1'){
		$col_data = 'col25';
		$col_status = 'col25';
		$col_detalhes = 'col30';
		$col_info = 'col30';
	} else {
		$col_data = 'col30';
		$col_status = 'col30';
		$col_detalhes = 'col25';
	}

	// Conteúdo do Paginate
	$historico = '
<script type="text/javascript">
$(document).ready(function() {
	$(".historicoButton").click(function() {
		var seta = $(this).find("img");
		$(".historicoButton").parent().removeClass("on");
	 	$(".historicoContent").slideUp("fast");
		$(".historicoButton img").attr("src","include/inc_module/mod_shop/template/images/bg-seta-historico.png")
		$(seta).attr("src","include/inc_module/mod_shop/template/images/bg-seta-historico.png")
		if($(this).next().is(":hidden") == true) {
			$(this).parent().addClass("on");
			$(this).next().slideDown("fast");
			$(seta).attr("src","include/inc_module/mod_shop/template/images/bg-seta-historico-on.png")
		 } 
	});
	$(".historicoContent").hide();
});
</script>

<div class="historico-shop">
	<div class="titulos-historico fl">
		<span class="col-tit col1 col20">Código</span>
		<span class="col-tit '.$col_data.'">Data</span>
		<span class="col-tit '.$col_status.'">Status</span>
		<span class="col-tit '.$col_info.'">Informações</span>
	</div>';

$i = 0;
while($row = mysqli_fetch_array($result_paginate)){
	
	$data = date('d/m/Y', strtotime($row['order_date']));
	$info = unserialize($row['order_data']);
	if($i % 2){$cor = ' style="background:#f6f6f6"';} else {$cor = '';};
	
	if(!empty($info['cartao'])){$cartao = '<br />'.$info['cartao'];} else {$cartao = '';}
	
	if($row['order_status'] == 'NEW-ORDER' || $row['order_status'] == '7'){
		$status = 'Pendente';
	} else {
		if($row['order_status'] == '1'){$status = 'Documenta&ccedil;&atilde;o Entregue';}
		elseif($row['order_status'] == '2'){$status = 'Pagamento Confirmado';}
		elseif($row['order_status'] == '3'){$status = 'Opera&ccedil;&atilde;o Registrada';}
		elseif($row['order_status'] == '4'){$status = 'Entrega Agendada';}
		elseif($row['order_status'] == '5'){$status = 'Pedido Finalizado';}
		elseif($row['order_status'] == '6'){$status = 'Cancelado';}
	}
	
	$i++;
	
	$historico .= '
	<div class="lista-historico fl"'.$cor.'>
		<span class="col-historico col1 col20">'.$row['order_number'].'</span>
		<span class="col-historico '.$col_data.'">'.$data.'</span>
		<span class="col-historico '.$col_status.'">'.$status.'</span>
		<span class="historicoButton col-historico '.$col_detalhes.'">
			<strong>VER DETALHES</strong>
			<img src="include/inc_module/mod_shop/template/images/bg-seta-historico.png" width="22" height="22" />
		</span>
		<div class="historicoContent fl">
			<table width="100%" border="0" cellspacing="1" cellpadding="12" style="background:#fff">
  				<tr class="tit-produtos">
    				<td><strong>PRODUTO</strong></td>
					<td align="center"><strong>MOEDA</strong></td>
					<td align="center"><strong>IOF (%)</strong></td>
					<td align="center"><strong>COTAÇÃO</strong></td>
					<td align="center"><strong>QUANTIDADE</strong></td>
					<td align="center"><strong>SEGURO</strong></td>
					<td align="center"><strong>SUBTOTAL</strong></td>
				</tr>';
				$x = 0;
				if(isset($info['orcamento'])){
					foreach($info['cart'] as $value){
						$i++;
						$parte = explode('|', $value);
						
						$taxaSub = str_replace(',', '.', $parte['2']);
						$subtotal = number_format($parte[1] * $taxaSub, 2, ',', '.');
						
						$orcQuery = 'SELECT * FROM phpwcms_shop_products WHERE shopprod_id = "'.$parte['0'].'"';
						$orcResult = mysqli_query($conexao, $orcQuery);
						$orc = mysqli_fetch_array($orcResult);
						
						if(strpos($orc['shopprod_category'],'1') !== false){
							$tipo = 'Moeda';
						} else if($orc['shopprod_category'] == '2'){
							if(!empty($info['recarga'])){
								$tipo = 'Recarga';
							} else {
								$tipo = 'Cartão';
							}
						}
						
						$taxa = number_format($orc['shopprod_vat'], 2, ',', '.');
						
						$historico .= '
						<tr>
							<td'.$cor.'>'.$tipo.'</td>
							<td align="center"'.$cor.'>'.$orc['shopprod_ordernumber'].'</td>
							<td align="center"'.$cor.'>'.$taxa.'</td>
							<td align="center"'.$cor.'>R$ '.$parte['2'].'</td>
							<td align="center"'.$cor.'>'.$parte['1'].'</td>
							<td align="center"'.$cor.'>incluso</td>
							<td align="center"'.$cor.'>R$ '.$subtotal.'</td>
						</tr>';
					}
				} else {
					foreach($info['cart'] as $plugin['product']){
						$x++;
						if($x % 2){$cor = '';} else {$cor = ' bgcolor="#f6f6f6"';}
						
						if(strpos($plugin['product']['shopprod_category'],'1') !== false){
							$tipo = 'Moeda';
						} else if($plugin['product']['shopprod_category'] == '2'){
							if(!empty($plugin['product']['recarga'])){
								$tipo = 'Recarga';
							} else {
								$tipo = 'Cartão';
							}
						}
						
						$valor = number_format(($plugin['product']['shopprod_quantity'] * $plugin['product']['shopprod_price']), 2, ',', '.');
												
		 $historico .= '<tr>
							<td'.$cor.'>'.$tipo.'</td>
							<td align="center"'.$cor.'>'.$plugin['product']['shopprod_ordernumber'].'</td>
							<td align="center"'.$cor.'>'.$taxa.'</td>
							<td align="center"'.$cor.'>R$ '.number_format($plugin['product']['shopprod_price'], 4, ',','.').'</td>
							<td align="center"'.$cor.'>'.$plugin['product']['shopprod_quantity'].'</td>
							<td align="center"'.$cor.'>incluso</td>
							<td align="center"'.$cor.'>R$ '.$valor_total.'</td>
						</tr>';
					}
				}
$historico .= '</table>
			<div class="valor-pedido fl">';
				if(!empty($info['entrega'])){
					$historico .= "<p>TAXA DE ENTREGA: R$ ".$info['entrega']."</p>";
				}
				$historico .= 'TOTAL GERAL <b>R$ '.$row['order_gross'].'</b>
			</div>
		</div>
	</div>';
}
$historico .= links_paginate($totalpaginas, $paginaatual, $range, $_SERVER['REQUEST_URI']);
// ============================= Fim Histórico de Pedidos =============================


// =============================== Compras Ativas ===============================

$listaStatusFechados = implode('", "', $statusFechamento);
$sql = 'SELECT * FROM phpwcms_shop_orders WHERE order_user_id = '.$num_user.' AND order_status NOT IN ("'.$listaStatusFechados.'")';
list($result_paginate, $totalpaginas, $paginaatual, $numerorows) = paginate($sql, $rowsporpagina, $pagina, 'ORDER BY order_id DESC LIMIT', $conexao);

	// Muda as classes caso não haja Forma de Pagamento
	if($preco != '1'){
		$col_data = 'col25';
		$col_status = 'col25';
		$col_detalhes = 'col30';
		$col_info = 'col30';
	} else {
		$col_data = 'col30';
		$col_status = 'col30';
		$col_detalhes = 'col25';
	}

	// Conteúdo do Paginate
	$ativo = '
<script type="text/javascript">
$(document).ready(function() {
	$(".historicoButton").click(function() {
		var seta = $(this).find("img");
		$(".historicoButton").parent().removeClass("on");
	 	$(".historicoContent").slideUp("fast");
		$(".historicoButton img").attr("src","include/inc_module/mod_shop/template/images/bg-seta-historico.png")
		$(seta).attr("src","include/inc_module/mod_shop/template/images/bg-seta-historico.png")
		if($(this).next().is(":hidden") == true) {
			$(this).parent().addClass("on");
			$(this).next().slideDown("fast");
			$(seta).attr("src","include/inc_module/mod_shop/template/images/bg-seta-historico-on.png")
		 } 
	});
	$(".historicoContent").hide();
});
</script>

<div class="historico-shop">
	<div class="titulos-historico fl">
		<span class="col-tit col1 col20">Código</span>
		<span class="col-tit '.$col_data.'">Data</span>
		<span class="col-tit '.$col_status.'">Status</span>
		<span class="col-tit '.$col_info.'">Informações</span>
	</div>';

$i = 0;
while($row = mysqli_fetch_array($result_paginate)){
	$data = date('d/m/Y', strtotime($row['order_date']));
	$info = unserialize($row['order_data']);
	if(!empty($info['cartao'])){$cartao = '<br />'.$info['cartao'];} else {$cartao = '';}
	if($row['order_status'] == 'NEW-ORDER'){
		$status = 'Pendente';
	} else {
		if($row['order_status'] == '1'){$status = 'Documenta&ccedil;&atilde;o Entregue';}
		elseif($row['order_status'] == '2'){$status = 'Pagamento Confirmado';}
		elseif($row['order_status'] == '3'){$status = 'Opera&ccedil;&atilde;o Registrada';}
		elseif($row['order_status'] == '4'){$status = 'Entrega Enviada';}
		elseif($row['order_status'] == '5'){$status = 'Pedido Finalizado';}
		elseif($row['order_status'] == '6'){$status = 'Cancelado';}
	}
	
	$i++;
	if($i % 2){$cor = ' style="background:#f6f6f6"';} else {$cor = '';};
	$ativo .= '
	<div class="lista-historico fl"'.$cor.'>
		<span class="col-historico col1 col20">'.$row['order_number'].'</span>
		<span class="col-historico '.$col_data.'">'.$data.'</span>
		<span class="col-historico '.$col_status.'">'.$status.'</span>
		<span class="historicoButton col-historico '.$col_detalhes.'"><strong>VER DETALHES</strong><img src="include/inc_module/mod_shop/template/images/bg-seta-historico.png" width="22" height="22" /></span>
		<div class="historicoContent fl">
			<table width="100%" border="0" cellspacing="1" cellpadding="12" style="background:#fff">
  				<tr class="tit-produtos" style="">
    				<td><strong>PRODUTO</strong></td>
					<td align="center"><strong>MOEDA</strong></td>
					<td align="center"><strong>COTAÇÃO</strong></td>
					<td align="center"><strong>QUANTIDADE</strong></td>
					<td align="center"><strong>R$</strong></td>
					<td align="center"><strong>IOF</strong></td>
					<td align="center"><strong>SUBTOTAL</strong></td>
				</tr>';
				$x = 0;
				foreach($info['cart'] as $plugin['product']){
					$x++;
					if($x % 2){$cor = '';} else {$cor = ' bgcolor="#f6f6f6"';}
					
					if(strpos($plugin['product']['shopprod_category'],'1') !== false){
						$tipo = 'Moeda';
					} else if($plugin['product']['shopprod_category'] == '2'){
						if(!empty($plugin['product']['recarga'])){
							$tipo = 'Recarga';
						} else {
							$tipo = 'Cartão';
						}
					}
					
					$valor = number_format(($plugin['product']['shopprod_quantity'] * $plugin['product']['shopprod_price']), 2, ',', '.');
					
					$valoriof = ($plugin['product']['shopprod_quantity'] * $plugin['product']['shopprod_price']) * ($plugin['product']['shopprod_vat'] / 100);
    				$iof = number_format($valoriof, 2, ',', '.');
					
					$valor_total = number_format(($plugin['product']['shopprod_quantity'] * $plugin['product']['shopprod_price']), 2, ',', '.');
					
					$geral = number_format($plugin['product']['subtotal_gross'], 2, ',', '.');
					
					$ativo .= '
					<tr>
						<td'.$cor.'>'.$tipo.'</td>
						<td align="center"'.$cor.'>'.$plugin['product']['shopprod_ordernumber'].'</td>
						<td align="center"'.$cor.'>R$ '.number_format($plugin['product']['shopprod_price'], 4, ',','.').'</td>
						<td align="center"'.$cor.'>'.$plugin['product']['shopprod_quantity'].'</td>
						<td align="center"'.$cor.'>R$ '.$valor.'</td>
						<td align="center"'.$cor.'>R$ '.$iof.'</td>
						<td align="center"'.$cor.'>R$ '.$valor_total.'</td>
					</tr>';
				}				
$ativo .= '</table>
			<div class="valor-pedido fl"> TOTAL GERAL <b>R$ '.$row['order_gross'].'</b></div>
		</div>
	</div>';
}	
$ativo .= links_paginate($totalpaginas, $paginaatual, $range, $_SERVER['REQUEST_URI']);

?>