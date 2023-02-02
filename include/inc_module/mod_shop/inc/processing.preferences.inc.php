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

	if( isset($_POST['save']) ) {
		
		// =========== Montagem da lista de status ===========
		var_dump($_POST);
		// Pega a lista de status
		foreach($_POST as $key => $value){
			if(strpos($key, 'lista_status') !== false){
				$status[] .= $value;
			} else {
				continue;
			}
		}
		
		// Pega a lista de check dos status
		foreach($_POST as $key => $value){
			if(strpos($key, 'check_status') !== false){
				$checks[] .= $value;
			} else {
				continue;
			}
		}
		
		// Junta os arrays
		$preListaStatus = array_combine($status, $checks);
		
		// Combina o valor do status com o 
		foreach($preListaStatus as $key => $value){
			if(!empty($key)){
				$pre[] = $key.','.$value;
			} else {
				continue;
			}
		}
		
		// Cria o valor com todos os status
		$listaStatus = implode('|', $pre);
		var_dump($listaStatus);
		$listaStatus = 'Pedido Realizado,2|Aguardando Pagamento,2|Em Análise,2|Aprovado,2|Disponível,2|Em Disputa,2|Devolvida,2|Em Devolução,2|Em Contestação,2|'.$listaStatus.'|Cancelado,1|Finalizado,1';
		
		$plugin['data']['shop_pref_status']				= $listaStatus;
		
		// =========== Fim da lista de status ===========
		
		
		// Configurações de e-mail -----
		$plugin['data']['shop_pref_email_admin']		= slweg($_POST['email-admin']);
		$plugin['data']['shop_pref_email_cliente']		= slweg($_POST['email-cliente']);
		$plugin['data']['shop_pref_email_cadastro']		= slweg($_POST['email-cadastro']);
		$plugin['data']['shop_pref_email_aprovado']		= slweg($_POST['email-aprovado']);
		
		
		// Configurações do administrador -----
		$plugin['data']['shop_pref_id_shop']			= slweg($_POST['pref_shop_id']);				// Aid da página de pedidos
		$plugin['data']['shop_pref_id_cart']			= slweg($_POST['pref_cart_id']);				// Aid da página do carrinho
		$plugin['data']['shop_pref_id_cliente']			= slweg($_POST['pref_cliente_id']);				// Aid da página de clientes
		$plugin['data']['shop_pref_itens_pedidos']		= slweg($_POST['pref_itens_pedidos']);			// Pedidos por página (cliente)
		$plugin['data']['shop_pref_alteravel']			= clean_slweg($_POST['pref_alteravel']);		// Quantidade alterável
		$plugin['data']['shop_pref_submenu']			= clean_slweg($_POST['pref_submenu']);			// Submenu aberto
		$plugin['data']['shop_pref_paginate']			= clean_slweg($_POST['pref_paginate']);			// Paginate ativo / desativado
		
		
		// Configurações gerais -----
		$plugin['data']['shop_pref_itens_home']			= slweg($_POST['pref_itens_home']);				// Qtd de itens na página inicial
		$plugin['data']['shop_pref_itens_paginate']		= slweg($_POST['pref_itens_paginate']);			// Qtd de itens por página
		$plugin['data']['shop_pref_frete_global']		= slweg($_POST['pref_frete_global']);			// Frete global
		$plugin['data']['shop_pref_id_aprovacao']		= slweg($_POST['pref_aprovacao_id']);			// Aid da página de aprov. usuário
		if($user['admin_config_pagseguro'] === 1){ 
			$plugin['data']['shop_pref_pagseguro']		= clean_slweg($_POST['pref_pagseguro']);		// Pagseguro ativo / desativado
		} else {
			$plugin['data']['shop_pref_pagseguro']		= 0;											// Pagseguro desativado
		}
		$plugin['data']['shop_pref_email_pagseguro_sandbox']  = clean_slweg($_POST['pref_email_pagseguro_sandbox']);  // E-mail (sandbox)
		$plugin['data']['shop_pref_token_pagseguro_sandbox']  = clean_slweg($_POST['pref_token_pagseguro_sandbox']);  // Token (sandbox)
		$plugin['data']['shop_pref_email_pagseguro_producao'] = clean_slweg($_POST['pref_email_pagseguro_producao']); // E-mail (produção)
		$plugin['data']['shop_pref_token_pagseguro_producao'] = clean_slweg($_POST['pref_token_pagseguro_producao']); // Token (produção)
		
		$plugin['data']['shop_pref_interna']			= clean_slweg($_POST['pref_interna']);			// Desabilita página interna
		$plugin['data']['shop_pref_redirect']			= clean_slweg($_POST['pref_redirect']);			// Redicionar para o carrinho
		$plugin['data']['shop_pref_preco']				= clean_slweg($_POST['pref_preco']);			// Ativa / Desativa o preço
		$plugin['data']['shop_pref_texto_preco']		= slweg($_POST['texto-preco']);					// Texto no lugar do preço
		$plugin['data']['shop_pref_preco_logado']		= clean_slweg($_POST['pref_preco_logado']);		// Preço só para logados
		$plugin['data']['shop_pref_texto_logado']		= slweg($_POST['texto-preco-logado']);			// Texto do preço não logado
		$plugin['data']['shop_pref_mod_users']			= slweg($_POST['pref_mod_users']);				// Moderação de usuários
		$plugin['data']['shop_pref_compra_logado']		= clean_slweg($_POST['pref_compra_logado']);	// Desabilita compra não logados
		$plugin['data']['shop_pref_texto_compra']		= slweg($_POST['texto-compra']);				// Texto de compra para não logados
		
		
		// Outras configurações -----
		$plugin['data']['shop_pref_currency']			= clean_slweg($_POST['pref_currency']);			// Moeda
		$plugin['data']['shop_pref_unit_weight']		= clean_slweg($_POST['pref_unit_weight']);		// Peso
		$plugin['data']['shop_pref_terms']				= slweg($_POST['pref_terms']);					// Termos
		$plugin['data']['shop_pref_terms_format']		= empty($_POST['pref_terms_format']) ? 0 : 1;	// Formato de texto dos termos
		$plugin['data']['shop_pref_felang']				= empty($_POST['pref_felang']) ? 0 : 1;			// Linguagem
		$plugin['data']['shop_pref_vat']				= clean_slweg($_POST['pref_vat']);
		$plugin['data']['shop_pref_vat']				= str_replace($BLM['thousands_sep'], '', $plugin['data']['shop_pref_vat']);
		$plugin['data']['shop_pref_vat']				= str_replace($BLM['dec_point'], '.', $plugin['data']['shop_pref_vat']);
		$plugin['data']['shop_pref_vat']				= explode(LF, $plugin['data']['shop_pref_vat']);
		$plugin['data']['shop_pref_vat']				= array_map('roundAll', $plugin['data']['shop_pref_vat']);
		natsort($plugin['data']['shop_pref_vat']);
		$plugin['data']['shop_pref_vat']				= array_unique($plugin['data']['shop_pref_vat']);
		
		$plugin['data']['shop_pref_email_to']			= convertStringToArray( sanitize_multiple_emails( clean_slweg($_POST['pref_email_to']) ), ';');
		$plugin['data']['shop_pref_email_from']			= clean_slweg($_POST['pref_email_from']);
		$plugin['data']['shop_pref_email_paypal']		= clean_slweg($_POST['pag_email_paypal']);
				
		
		// check if multiple emails
		foreach($plugin['data']['shop_pref_email_to'] as $key => $value) {
			if(!is_valid_email($value) ) {
				unset( $plugin['data']['shop_pref_email_to'][$key] );
			}
		}
		$plugin['data']['shop_pref_email_to']			= strtolower( implode(';', $plugin['data']['shop_pref_email_to'] ) );
		
		if(! is_valid_email($plugin['data']['shop_pref_email_from']) )		$plugin['data']['shop_pref_email_from']		= '';
		if(! is_valid_email($plugin['data']['shop_pref_email_paypal']) )	$plugin['data']['shop_pref_email_paypal']	= '';
		
		for( $x = 0; $x <= 4; $x++ ) {
		
			$plugin['data']['shop_pref_shipping'][$x]['weight']	= clean_slweg($_POST['pref_shipping_weight'][$x]);
			$plugin['data']['shop_pref_shipping'][$x]['net']	= clean_slweg($_POST['pref_shipping_net'][$x]);
			$plugin['data']['shop_pref_shipping'][$x]['vat']	= clean_slweg($_POST['pref_shipping_vat'][$x]);
			
			$plugin['data']['shop_pref_shipping'][$x]['weight']	= str_replace($BLM['thousands_sep'], '', $plugin['data']['shop_pref_shipping'][$x]['weight']);
			$plugin['data']['shop_pref_shipping'][$x]['weight']	= round(str_replace($BLM['dec_point'], '.', $plugin['data']['shop_pref_shipping'][$x]['weight']), 3);
			
			$plugin['data']['shop_pref_shipping'][$x]['net']	= str_replace($BLM['thousands_sep'], '', $plugin['data']['shop_pref_shipping'][$x]['net']);
			$plugin['data']['shop_pref_shipping'][$x]['net']	= round(str_replace($BLM['dec_point'], '.', $plugin['data']['shop_pref_shipping'][$x]['net']), 3);
			
			$plugin['data']['shop_pref_shipping'][$x]['vat']	= str_replace($BLM['thousands_sep'], '', $plugin['data']['shop_pref_shipping'][$x]['vat']);
			$plugin['data']['shop_pref_shipping'][$x]['vat']	= round(str_replace($BLM['dec_point'], '.', $plugin['data']['shop_pref_shipping'][$x]['vat']), 2);
		
		}
		
		$plugin['data']['shop_pref_payment']	= array(
			'paypal'			=> empty($_POST['pag_paypal']) ? 0 : 1,
			'transferencia'		=> empty($_POST['pag_transferencia']) ? 0 : 1,
			'boleto'			=> empty($_POST['pag_boleto']) ? 0 : 1,
			'deposito'			=> empty($_POST['pag_deposito']) ? 0 : 1,
			'cartao'			=> empty($_POST['pag_cartao']) ? 0 : 1,
			'accepted_ccard'	=> array_filter(preg_split('/\r\n|[\r\n]/', trim($_POST['pref_supported_ccard']))),
		);
		
		// Discount Setting
		$plugin['data']['shop_pref_discount']	= array(
			'discount'		=> empty($_POST['pref_discount']) ? 0 : 1,
			'percent'		=> clean_slweg($_POST['pref_discount_percent'])
																);
		$plugin['data']['shop_pref_discount']['percent'] = str_replace($BLM['thousands_sep'], '', $plugin['data']['shop_pref_discount']['percent']);
		$plugin['data']['shop_pref_discount']['percent'] = round(str_replace($BLM['dec_point'], '.', $plugin['data']['shop_pref_discount']['percent']), 2);		
		
		// Low Order
		$plugin['data']['shop_pref_loworder']			= array(
													'loworder'			=> empty($_POST['pref_loworder']) ? 0 : 1,
													'under'				=> clean_slweg($_POST['pref_loworder_under']),
													'charge'			=> clean_slweg($_POST['pref_loworder_charge']),
													'vat'				=> clean_slweg($_POST['pref_loworder_vat'])
																);
		$plugin['data']['shop_pref_loworder']['under']	= str_replace($BLM['thousands_sep'], '', $plugin['data']['shop_pref_loworder']['under']);
		$plugin['data']['shop_pref_loworder']['under']	= round(str_replace($BLM['dec_point'], '.', $plugin['data']['shop_pref_loworder']['under']), 2);
		$plugin['data']['shop_pref_loworder']['charge']	= str_replace($BLM['thousands_sep'], '', $plugin['data']['shop_pref_loworder']['charge']);
		$plugin['data']['shop_pref_loworder']['charge']	= round(str_replace($BLM['dec_point'], '.', $plugin['data']['shop_pref_loworder']['charge']), 2);
		$plugin['data']['shop_pref_loworder']['vat']	= str_replace($BLM['thousands_sep'], '', $plugin['data']['shop_pref_loworder']['vat']);
		$plugin['data']['shop_pref_loworder']['vat']	= round(str_replace($BLM['dec_point'], '.', $plugin['data']['shop_pref_loworder']['vat']), 2);
		
		/*
		// Checagem se a opção de moderação está ativa
		if($plugin['data']['shop_pref_mod_users'] === '1'){
		
			// Verifica se a estrutura existe
			$sqlEst = 'SELECT acat_id FROM phpwcms_articlecat WHERE acat_id = 9999';
			$resEst = mysqli_query($sqlEst,$conexao);
			if(mysqli_num_rows($resEst) > 0){
			
			} else {
				$sqlAddEst  = 'INSERT INTO phpwcms_articlecat SET acat_id = 9999, ';
				$sqlAddEst .= 'acat_name = "Aprovação de Usuário", acat_public = 1, acat_tstamp = now(), ';
				$sqlAddEst .= 'acat_aktiv = 1, acat_uid = 1, acat_trash = 0, acat_struct = 0, acat_sort = 9990, ';
				$sqlAddEst .= 'acat_alias = "aprovacao-de-usuario", acat_hidden = 1, acat_template = 2, ';
				$sqlAddEst .= 'acat_ssl = 0, acat_regonly = 0, acat_topcount = "-1", acat_redirect = "", ';
				$sqlAddEst .= 'acat_order = 0, acat';
				$sqlAddEst .= '';
				$sqlAddEst .= '';
				$sqlAddEst .= '';
			}
		
		} else {
		
		}
		*/
		
		
		if( empty($plugin['error'] )) {
			
			_setConfig('shop_pref_id_shop',		 	 	$plugin['data']['shop_pref_id_shop'],			'module_shop');
			_setConfig('shop_pref_id_cart',		 	 	$plugin['data']['shop_pref_id_cart'],			'module_shop');
			_setConfig('shop_pref_id_cliente',	 	 	$plugin['data']['shop_pref_id_cliente'],		'module_shop');
			_setConfig('shop_pref_itens_pedidos',	 	$plugin['data']['shop_pref_itens_pedidos'],		'module_shop');
			_setConfig('shop_pref_alteravel',	 	 	$plugin['data']['shop_pref_alteravel'],			'module_shop');
			_setConfig('shop_pref_submenu',	 	 		$plugin['data']['shop_pref_submenu'],			'module_shop');
			_setConfig('shop_pref_paginate',	 	 	$plugin['data']['shop_pref_paginate'],			'module_shop');
			
			_setConfig('shop_pref_itens_home',	 	 	$plugin['data']['shop_pref_itens_home'],		'module_shop');
			_setConfig('shop_pref_itens_paginate',	 	$plugin['data']['shop_pref_itens_paginate'],	'module_shop');
			_setConfig('shop_pref_frete_global',	 	$plugin['data']['shop_pref_frete_global'],		'module_shop');
			_setConfig('shop_pref_id_aprovacao', 	 	$plugin['data']['shop_pref_id_aprovacao'],		'module_shop');
			_setConfig('shop_pref_pagseguro', 	 		$plugin['data']['shop_pref_pagseguro'],			'module_shop');
			
			_setConfig('shop_pref_interna',	 	 	 	$plugin['data']['shop_pref_interna'],			'module_shop');
			_setConfig('shop_pref_redirect',	 	 	$plugin['data']['shop_pref_redirect'],			'module_shop');
			_setConfig('shop_pref_preco',		 	 	$plugin['data']['shop_pref_preco'],				'module_shop');
			_setConfig('shop_pref_texto_preco',		 	$plugin['data']['shop_pref_texto_preco'],		'module_shop');	
			_setConfig('shop_pref_preco_logado',	 	$plugin['data']['shop_pref_preco_logado'],		'module_shop');
			_setConfig('shop_pref_texto_logado',		$plugin['data']['shop_pref_texto_logado'],		'module_shop');
			_setConfig('shop_pref_mod_users',	 		$plugin['data']['shop_pref_mod_users'],			'module_shop');
			_setConfig('shop_pref_compra_logado',	 	$plugin['data']['shop_pref_compra_logado'],		'module_shop');
			_setConfig('shop_pref_texto_compra',	 	$plugin['data']['shop_pref_texto_compra'],		'module_shop');	
			
			_setConfig('shop_pref_email_admin',  	 	$plugin['data']['shop_pref_email_admin'],  		'module_shop');
			_setConfig('shop_pref_email_cliente',	 	$plugin['data']['shop_pref_email_cliente'],		'module_shop');
			_setConfig('shop_pref_email_cadastro',	 	$plugin['data']['shop_pref_email_cadastro'],	'module_shop');
			_setConfig('shop_pref_email_aprovado',	 	$plugin['data']['shop_pref_email_aprovado'],	'module_shop');

			_setConfig('shop_pref_currency', 	 	 	$plugin['data']['shop_pref_currency'], 			'module_shop');
			_setConfig('shop_pref_unit_weight',  	 	$plugin['data']['shop_pref_unit_weight'], 		'module_shop');
			_setConfig('shop_pref_vat', 		 	 	$plugin['data']['shop_pref_vat'], 				'module_shop');
			_setConfig('shop_pref_email_to', 	 	 	$plugin['data']['shop_pref_email_to'], 			'module_shop');
			_setConfig('shop_pref_email_from', 	 	 	$plugin['data']['shop_pref_email_from'], 		'module_shop');
			_setConfig('shop_pref_email_paypal', 	 	$plugin['data']['shop_pref_email_paypal'], 		'module_shop');
			_setConfig('shop_pref_shipping', 	 	 	$plugin['data']['shop_pref_shipping'], 			'module_shop');
			_setConfig('shop_pref_payment', 	 	 	$plugin['data']['shop_pref_payment'], 			'module_shop');
			_setConfig('shop_pref_terms', 		 	 	$plugin['data']['shop_pref_terms'], 			'module_shop');
			_setConfig('shop_pref_terms_format', 	 	$plugin['data']['shop_pref_terms_format'],		'module_shop');			
			_setConfig('shop_pref_discount',	 	 	$plugin['data']['shop_pref_discount'],			'module_shop');
			_setConfig('shop_pref_loworder',	 	 	$plugin['data']['shop_pref_loworder'],			'module_shop');
			_setConfig('shop_pref_felang',		 	 	$plugin['data']['shop_pref_felang'],			'module_shop');		
			_setConfig('shop_pref_status',		 	 	$plugin['data']['shop_pref_status'],			'module_shop');	
			
			_setConfig('shop_pref_email_pagseguro_sandbox',  $plugin['data']['shop_pref_email_pagseguro_sandbox'],  'module_shop');
			_setConfig('shop_pref_token_pagseguro_sandbox',  $plugin['data']['shop_pref_token_pagseguro_sandbox'],  'module_shop');
			_setConfig('shop_pref_email_pagseguro_producao', $plugin['data']['shop_pref_email_pagseguro_producao'], 'module_shop');
			_setConfig('shop_pref_token_pagseguro_producao', $plugin['data']['shop_pref_token_pagseguro_producao'], 'module_shop');
			
			// save and back to listing mode
			headerRedirect( shop_url('controller=preferences', '') );
			
		}

	}
	
	$_checkPref = array(
		
		'shop_pref_id_shop'					 =>	0,
		'shop_pref_id_cart'					 =>	0,
		'shop_pref_id_cliente'				 =>	0,
		'shop_pref_itens_pedidos'			 =>	'',
		'shop_pref_alteravel'				 =>	'0',
		'shop_pref_submenu'					 =>	'0',
		'shop_pref_paginate'				 =>	'0',
		
		'shop_pref_itens_home'				 =>	'',
		'shop_pref_itens_paginate'			 =>	'',
		'shop_pref_frete_global'			 =>	'',
		'shop_pref_id_aprovacao'			 =>  0,
		'shop_pref_pagseguro'				 =>	'0',
		'shop_pref_email_pagseguro_sandbox'	 =>	'',
		'shop_pref_token_pagseguro_sandbox'	 =>	'',
		'shop_pref_email_pagseguro_producao' =>	'',
		'shop_pref_token_pagseguro_producao' =>	'',
		
		'shop_pref_interna'					 => '0',	
		'shop_pref_redirect'				 => '0',
		'shop_pref_preco'					 => '0',
		'shop_pref_texto_preco'				 => '',
		'shop_pref_preco_logado'			 => '0',
		'shop_pref_texto_logado'			 => '',
		'shop_pref_mod_users'				 => '',
		'shop_pref_compra_logado'			 => '',
		'shop_pref_texto_compra'			 => '',
	
		'shop_pref_email_admin'				 => '',
		'shop_pref_email_cliente'			 => '',
		'shop_pref_email_cadastro'			 => '',
		'shop_pref_email_aprovado'			 => '',
	
		'shop_pref_currency'				 =>	'',
		'shop_pref_unit_weight'				 =>	'kg',
		'shop_pref_vat'						 =>	array( '0.00', '7.00', '19.00' ),
		'shop_pref_email_to'				 =>	'',
		'shop_pref_email_from'				 =>	'',
		'shop_pref_email_paypal'			 =>	'',		
		'shop_pref_felang'					 =>	0,
		'shop_pref_shipping'				 =>	array(	0 => array('weight'=>'50', 'net'=>0, 'vat'=>0), 
													1 => array('weight'=>'', 'net'=>0, 'vat'=>0), 
													2 => array('weight'=>'', 'net'=>0, 'vat'=>0),
													3 => array('weight'=>'', 'net'=>0, 'vat'=>0),
													4 => array('weight'=>'', 'net'=>0, 'vat'=>0)
											 ),
		'shop_pref_payment'					 =>	array(	'paypal' => 1, 
													'prepay'=> 1, 
													'pod' => 1, 
													'onbill' => 1, 
													'ccard' => 1, 
													'accepted_ccard' => array('americanexpress', 'mastercard', 'visa')
											 ),
		'shop_pref_terms'					 =>	'',
		'shop_pref_terms_format'			 =>  0,
		'shop_pref_discount'				 => array('discount' => 0, 'percent' => 0),
		'shop_pref_loworder'				 => array('loworder' => 0, 'under' => 0, 'charge' => 0, 'vat' => 0),
		'shop_pref_status'					 => '',		
			
	);

	// retrieve all settings
	foreach( $_checkPref as $key => $value ) {
		if( false === ( $plugin['data'][ $key ] = _getConfig( $key ) ) ) {
			$plugin['data'][ $key ] = $value;
			_setConfig( $key , $plugin['data'][ $key ], 'module_shop');
		}
	}

}


?>