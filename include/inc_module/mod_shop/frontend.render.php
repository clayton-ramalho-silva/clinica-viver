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

//ini_set("display_errors", "1");
//error_reporting(E_ALL);

// Conexão com o banco de dados
$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);


// =====================================================================================================================
// =============================================== CONFIGURAÇÕES GERAIS ================================================
// =====================================================================================================================

// Module/Plug-in Shop & Products
$_shop_load_cat  		= strpos($content['all'], '{SHOP_CATEGOR');
$_shop_load_list 		= strpos($content['all'], '{SHOP_PRODUCTLIST}');
$_shop_load_cart_small	= strpos($content['all'], '{CART_SMALL}');
$_shop_load_order		= strpos($content['all'], '{SHOP_ORDER_PROCESS}');
$_shop_load_client		= strpos($content['all'], '{SHOP_CLIENTE}');

// Set preferences
$_shopPref = array();

if(_getConfig( 'shop_pref_felang' )) {
	define('SHOP_FELANG_SUPPORT', true);
	define('SHOP_FELANG_SQL', " AND (shopprod_lang='' OR shopprod_lang="._dbEscape($phpwcms['default_lang']).')');
	define('CART_KEY', 'shopping_cart_'.$phpwcms['default_lang']);
} else {
	define('SHOP_FELANG_SUPPORT', false);
	define('SHOP_FELANG_SQL', '');
	define('CART_KEY', 'shopping_cart');
}

//Busca a lista de status de fechamento
$buscaListaStatus = _getConfig('shop_pref_status');
$montagemListaStatus = explode('|', $buscaListaStatus);
foreach($montagemListaStatus as $value){
	$partesStatus = explode(',', $value);
	if($partesStatus[1] === '1'){
		$statusFechamento[] .= remover_acentos_status2($partesStatus[0]);
	} else {
		continue;
	}
}

// Set CART session value
if(!isset($_SESSION[CART_KEY])) {
	$_SESSION[CART_KEY] = array();
}

// Reset cart session error var to allow cart listing
if(isset($_getVar['shop_cart']) && $_getVar['shop_cart'] == 'show') {
	unset($_SESSION[CART_KEY]['error'], $_getVar['cart'], $_GET['cart']);
}

if( $_shop_load_cat !== false || $_shop_load_list !== false || $_shop_load_order !== false || $_shop_load_cart_small !== false) {

	// load template
	$_tmpl = array( 'config' => array(), 'source' => '', 'lang' => $phpwcms['default_lang'] );

	// Check against language specific shop template
	if(is_file($phpwcms['modules']['shop']['path'].'template/'.$phpwcms['default_lang'].'.html')) {
		$_tmpl['source'] = @file_get_contents($phpwcms['modules']['shop']['path'].'template/'.$phpwcms['default_lang'].'.html');
	} else {
		$_tmpl['source'] = @file_get_contents($phpwcms['modules']['shop']['path'].'template/default.html');
	}

	if($_tmpl['source']) {

		$_tmpl['config'] = parse_ini_str(get_tmpl_section('CONFIG', $_tmpl['source']), false);

		$_tmpl['config']['cat_list_products']		= empty($_tmpl['config']['cat_list_products']) ? false : phpwcms_boolval($_tmpl['config']['cat_list_products']);
		$_tmpl['config']['image_list_lightbox']		= empty($_tmpl['config']['image_list_lightbox']) ? false : phpwcms_boolval($_tmpl['config']['image_list_lightbox']);
		$_tmpl['config']['image_detail_lightbox']	= empty($_tmpl['config']['image_detail_lightbox']) ? false : phpwcms_boolval($_tmpl['config']['image_detail_lightbox']);
		$_tmpl['config']['image_detail_crop']		= empty($_tmpl['config']['image_detail_crop']) ? false : phpwcms_boolval($_tmpl['config']['image_detail_crop']);
		$_tmpl['config']['image_list_crop']			= empty($_tmpl['config']['image_list_crop']) ? false : phpwcms_boolval($_tmpl['config']['image_list_crop']);

		// handle custom fields
		$_tmpl['config']['shop_field'] = array();
		$custom_field_number = 1;
		while( !empty( $_tmpl['config']['shop_field_' . $custom_field_number] ) ) {

			$custom_field_type = explode('_', trim($_tmpl['config']['shop_field_' . $custom_field_number]) );
			if($custom_field_type[0] === 'STRING' || $custom_field_type[0] === 'TEXTAREA' || $custom_field_type[0] === 'CHECK') {
				$_tmpl['config']['shop_field'][ $custom_field_number ]['type'] = $custom_field_type[0];
				if(isset($custom_field_type[1]) && $custom_field_type[1] == 'REQ') {
					$_tmpl['config']['shop_field'][ $custom_field_number ]['required'] = true;
					if(empty($custom_field_type[2])) {
						$_tmpl['config']['shop_field'][ $custom_field_number ]['label'] = 'Custom '.$custom_field_number;
					} else {
						$_tmpl['config']['shop_field'][ $custom_field_number ]['label'] = trim($custom_field_type[2]);
					}
				} elseif(empty($custom_field_type[1])) {
					$_tmpl['config']['shop_field'][ $custom_field_number ]['required'] = false;
					$_tmpl['config']['shop_field'][ $custom_field_number ]['label'] = 'Custom '.$custom_field_number;
				} else {
					$_tmpl['config']['shop_field'][ $custom_field_number ]['required'] = false;
					$_tmpl['config']['shop_field'][ $custom_field_number ]['label'] = trim($custom_field_type[1]);
				}
				if($custom_field_type[0] === 'CHECK') {
					if($_tmpl['config']['shop_field'][ $custom_field_number ]['required']) {
						$_tmpl['config']['shop_field'][ $custom_field_number ]['value'] = empty($custom_field_type[3]) ? 1 : trim($custom_field_type[3]);
					} else {
						$_tmpl['config']['shop_field'][ $custom_field_number ]['value'] = empty($custom_field_type[2]) ? 1 : trim($custom_field_type[2]);
					}
				}
			}
			$custom_field_number++;
		}

		if($_shop_load_list) {
			$_tmpl['list_header']		= get_tmpl_section('LIST_HEADER',			$_tmpl['source']);
			$_tmpl['list_entry']		= get_tmpl_section('LIST_ENTRY',			$_tmpl['source']);
			$_tmpl['list_space']		= get_tmpl_section('LIST_SPACE',			$_tmpl['source']);
			$_tmpl['list_none']			= get_tmpl_section('LIST_NONE',				$_tmpl['source']);
			$_tmpl['list_footer']		= get_tmpl_section('LIST_FOOTER',			$_tmpl['source']);
			$_tmpl['detail']			= get_tmpl_section('DETAIL',				$_tmpl['source']);
			$_tmpl['image_space']		= get_tmpl_section('IMAGE_SPACE',			$_tmpl['source']);
		}

		if($_shop_load_cart_small) {
			$_tmpl['cart_small']		= get_tmpl_section('CART_SMALL',			$_tmpl['source']);
		}

		if($_shop_load_client) {
			$_tmpl['shop_client']		= get_tmpl_section('SHOP_CLIENTE',			$_tmpl['source']);
		}

		if($_shop_load_order) {
			$_tmpl['cart_header']		= get_tmpl_section('CART_HEADER',			$_tmpl['source']);
			$_tmpl['cart_entry']		= get_tmpl_section('CART_ENTRY',			$_tmpl['source']);
			$_tmpl['cart_space']		= get_tmpl_section('CART_SPACE',			$_tmpl['source']);
			$_tmpl['cart_footer']		= get_tmpl_section('CART_FOOTER',			$_tmpl['source']);
			$_tmpl['cart_none']			= get_tmpl_section('CART_NONE',				$_tmpl['source']);
			$_tmpl['inv_login']			= get_tmpl_section('ORDER_LOGIN',			$_tmpl['source']);
			$_tmpl['inv_address']		= get_tmpl_section('ORDER_INV_ADDRESS',		$_tmpl['source']);
			$_tmpl['msg_aprovacao']		= get_tmpl_section('MSG_APROVACAO',			$_tmpl['source']);
			$_tmpl['order_terms']		= get_tmpl_section('ORDER_TERMS',			$_tmpl['source']);
			$_tmpl['term_entry']		= get_tmpl_section('ORDER_TERMS_ITEM',		$_tmpl['source']);
			$_tmpl['term_space']		= get_tmpl_section('ORDER_TERMS_ITEMSPACE',	$_tmpl['source']);
			$_tmpl['mail_customer']		= get_tmpl_section('MAIL_CUSTOMER',			$_tmpl['source']);
			$_tmpl['mail_neworder']		= get_tmpl_section('MAIL_NEWORDER',			$_tmpl['source']);
			$_tmpl['order_success']		= get_tmpl_section('ORDER_DONE',			$_tmpl['source']);
			$_tmpl['order_failed']		= get_tmpl_section('ORDER_NOT_DONE',		$_tmpl['source']);
			$_tmpl['mail_item']			= get_tmpl_section('MAIL_ITEM',				$_tmpl['source']);
			$_tmpl['mail_admin_item']	= get_tmpl_section('MAIL_ADMIN_ITEM',		$_tmpl['source']);
			$_tmpl['mail_header']		= get_tmpl_section('MAIL_HEADER',			$_tmpl['source']);
			$_tmpl['mail_footer']		= get_tmpl_section('MAIL_FOOTER',			$_tmpl['source']);

			// Esconde as informações de preço se ele estiver desabilitado (E-mails de pedido)
			if($SHOP['preco'] === '1'){

				$_tmpl['mail_header'] = preg_replace('/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/is', '', $_tmpl['mail_header']);
                $_tmpl['mail_header'] = str_replace('{CLASSE_PRECO}',' sp', $_tmpl['mail_header']);

			} else {

				$textPreco = preg_match("/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/s", $_tmpl['mail_header'], $tp) ? $tp[1] : '';
				$_tmpl['mail_header'] = preg_replace('/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/is', $textPreco, $_tmpl['mail_header']);
                $_tmpl['mail_header'] = str_replace('{CLASSE_PRECO}','', $_tmpl['mail_header']);

			}

		}
	}

	// merge config settings like translations and so on
	$_tmpl['config'] = array_merge(	array(
						'cat_all'					=> '@@All products@@',
						'cat_all_pos'				=> 'bottom',
						'cat_list_products'			=> false,
						'cat_subcat_spacer'			=> ' / ',
						'sigla_moeda'				=> 'R$',
						'unidade_peso'				=> 'kg',
						'price_decimals'			=> 2,
						'vat_decimals'				=> 1,
						'weight_decimals'			=> 1,
						'dec_point'					=> ".",
						'thousands_sep'				=> ",",
						'ele_preco'					=> "b",
						'classe_preco'				=> '',
						'ele_preco_logado'			=> "b",
						'classe_preco_logado'		=> '',
						'ele_botao_escondido'		=> "b",
						'classe_botao_escondido'	=> '',
						'classe_botao_codigo'		=> '',
						'tit_select_1'				=> '',
						'tit_select_2'				=> '',
						'tit_select_3'				=> '',
						'image_list_width'			=> 200,
						'image_list_height'			=> 200,
						'image_detail_width'		=> 200,
						'image_detail_height'		=> 200,
						'image_zoom_width'			=> 750,
						'image_zoom_height'			=> 500,
						'image_list_lightbox'		=> false,
						'image_detail_lightbox'		=> true,
						'image_detail_crop'			=> false,
						'image_list_crop'			=> false,
						'mail_customer_subject'		=> "[#{ORDER}] Your order at MyShop",
						'mail_neworder_subject'		=> "[#{ORDER}] New order",

						'label_payby_transferencia'	=> "@@Cash with order@@",
						'label_payby_boleto'		=> "@@Cash on delivery@@",
						'label_payby_deposito'		=> "@@On account@@",
						'label_payby_paypal'		=> "@@paypal@@",
						'label_payby_cartao'		=> "@@Credit Card@@",
						'order_number_style'		=> 'RANDOM',
						'cat_list_sort_by'			=> 'shopprod_name1 ASC',
						'shop_css'					=> '',
						'shop_wrap'					=> '',
						'image_detail_more_width'	=> 50,
						'image_detail_more_height'	=> 50,
						'image_detail_more_crop'	=> false,
						'image_detail_more_start'	=> 1,
						'image_detail_more_lightbox'=> false,
						'files_direct_download'		=> false,
						'files_template'			=> '', // default
						'on_request_trigger'		=> -999,
						'pagetitle_productname'		=> '%s',
						'pagetitle_model'			=> ', Model: %s',
						'pagetitle_add'				=> '%S- %s',
						'pagetitle_ordernumber'		=> '%S(Order No. %s)',
						'pagetitle'					=> '%1$s%2$s%3$s%4$s'
					),	$_tmpl['config'] );

	foreach( array( 'shop_pref_currency', 'shop_pref_unit_weight', 'shop_pref_vat', 'shop_pref_email_to',
					'shop_pref_email_from', 'shop_pref_email_paypal', 'shop_pref_shipping', 'shop_pref_shipping_calc',
					'shop_pref_payment', 'shop_pref_discount', 'shop_pref_loworder', 'shop_pref_status' ) as $value ) {
		_getConfig( $value, '_shopPref' );
	}

	if(!isset($_tmpl['config']['shop_url'])) {
		$_tmpl['config']['shop_url'] = _getConfig( 'shop_pref_id_shop', '_shopPref' );
	}
	if(!isset($_tmpl['config']['cart_url'])) {
		$_tmpl['config']['cart_url'] = _getConfig( 'shop_pref_id_cart', '_shopPref' );
	}

	if(!is_intval($_tmpl['config']['shop_url']) && is_string($_tmpl['config']['shop_url'])) {
		$_tmpl['config']['shop_url'] = trim($_tmpl['config']['shop_url']);
	} elseif(is_intval($_tmpl['config']['shop_url']) && intval($_tmpl['config']['shop_url'])) {
		$_tmpl['config']['shop_url'] = 'aid='.intval($_tmpl['config']['shop_url']);
	} else {
		$_tmpl['config']['shop_url'] = $aktion[1] ? 'aid='.$aktion[1] : 'id='.$aktion[0];
	}

	if(!is_intval($_tmpl['config']['cart_url']) && is_string($_tmpl['config']['cart_url'])) {
		$_tmpl['config']['cart_url'] = trim($_tmpl['config']['cart_url']);
	} elseif(is_intval($_tmpl['config']['cart_url']) && intval($_tmpl['config']['cart_url'])) {
		$_tmpl['config']['cart_url'] = 'aid='.intval($_tmpl['config']['cart_url']);
	} else {
		$_tmpl['config']['cart_url'] = $aktion[1] ? 'aid='.$aktion[1] : 'id='.$aktion[0];
	}

	if($_tmpl['config']['shop_wrap']) {
		$_tmpl['config']['shop_wrap'] = explode('|', $_tmpl['config']['shop_wrap']);
		$_tmpl['config']['shop_wrap'] = array(
			'prefix' => trim($_tmpl['config']['shop_wrap'][0]) . LF,
			'suffix' => empty($_tmpl['config']['shop_wrap'][1]) ? '' : LF . trim($_tmpl['config']['shop_wrap'][1])
		);
	} else {
		$_tmpl['config']['shop_wrap'] = array('prefix'=>'', 'suffix'=>'');
	}

	$_tmpl['config']['price_decimals'] = (int) $_tmpl['config']['price_decimals'];
	$_tmpl['config']['vat_decimals'] = (int) $_tmpl['config']['vat_decimals'];
	$_tmpl['config']['weight_decimals'] = (int) $_tmpl['config']['weight_decimals'];

	if($_tmpl['config']['shop_css']) {
		renderHeadCSS($_tmpl['config']['shop_css']);
	}

	// OK get cart post data
	if( isset($_POST['shop_action']) && $_POST['shop_action'] == 'add' ) {

		if(!$SHOP['redirecionar']){
            $_SESSION['comprado'] = true;
        }

		$shop_prod_id		= intval($_POST['shop_prod_id']);
		$shop_prod_amount	= abs( intval($_POST['shop_prod_amount']) );
		$shop_prod_size		= $_POST['shop_prod_size'];
		$shop_prod_color	= $_POST['shop_prod_color'];
        $shop_prod_other	= $_POST['shop_prod_other'];
        /*
		if(empty($shop_prod_id) || empty($shop_prod_amount)) {
			break; // leave
        }
        */
		// add product to shopping
		if(isset($_SESSION[CART_KEY]['products'][$shop_prod_id])) {
			$_SESSION[CART_KEY]['products'][$shop_prod_id] += $shop_prod_amount;
		} else {
			$_SESSION[CART_KEY]['products'][$shop_prod_id]  = $shop_prod_amount;
		}

		$_SESSION[CART_KEY]['size'][$shop_prod_id]  = $shop_prod_size;
		$_SESSION[CART_KEY]['color'][$shop_prod_id]  = $shop_prod_color;
		$_SESSION[CART_KEY]['other'][$shop_prod_id]  = $shop_prod_other;

	} elseif( isset($_POST['shop_prod_amount']) && is_array($_POST['shop_prod_amount']) ) {

		foreach($_POST['shop_prod_amount'] as $prod_id => $prod_qty) {

			$prod_id  = intval($prod_id);
			$prod_qty = isset($_POST['shop_cart_delete']) ? 0 : abs( intval($prod_qty) );
			if(isset($_SESSION[CART_KEY]['products'][$prod_id])) {
				if($prod_qty) {
					$_SESSION[CART_KEY]['products'][$prod_id] = $prod_qty;
				} else {
					unset($_SESSION[CART_KEY]['products'][$prod_id]);
				}
			}
		}

	} elseif( isset($_POST['shop_order_step1']) ) {

		// handle invoice address -> checkout

		$_SESSION[CART_KEY]['step1'] = array(
			'INV_FIRSTNAME'	=> isset($_POST['shop_inv_firstname']) ? clean_slweg($_POST['shop_inv_firstname']) : '',
			'INV_NAME'		=> isset($_POST['shop_inv_name']) ? clean_slweg($_POST['shop_inv_name']) : '',
			'INV_ADDRESS'	=> isset($_POST['shop_inv_address']) ? clean_slweg($_POST['shop_inv_address']) : '',
			'INV_ZIP'		=> isset($_POST['shop_inv_zip']) ? clean_slweg($_POST['shop_inv_zip']) : '',
			'INV_CITY'		=> isset($_POST['shop_inv_city']) ? clean_slweg($_POST['shop_inv_city']) : '',
			'INV_REGION'	=> isset($_POST['shop_inv_region']) ? clean_slweg($_POST['shop_inv_region']) : '',
			'INV_COUNTRY'	=> isset($_POST['shop_inv_country']) ? clean_slweg($_POST['shop_inv_country']) : '',
			'EMAIL'			=> isset($_POST['shop_email']) ? clean_slweg($_POST['shop_email']) : '',
			'PHONE'			=> isset($_POST['shop_phone']) ? clean_slweg($_POST['shop_phone']) : ''
		);

		// retrieve all custom field POST data
		foreach($_tmpl['config']['shop_field'] as $key => $row) {

			$_SESSION[CART_KEY]['step1']['shop_field_'.$key] = empty($_POST['shop_field_'.$key]) ? '' : clean_slweg($_POST['shop_field_'.$key]);
			if($row['required'] && $_SESSION[CART_KEY]['step1']['shop_field_'.$key] === '') {
				$ERROR['inv_address']['shop_field_'.$key] = $row['required'] . ' must be filled';
			}
		}

		if(empty($_SESSION[CART_KEY]['step1']['INV_FIRSTNAME'])) {
			$ERROR['inv_address']['INV_FIRSTNAME'] = '@@First name must be filled@@';
		}
		if(empty($_SESSION[CART_KEY]['step1']['INV_ADDRESS'])) {
			$ERROR['inv_address']['INV_ADDRESS'] = '@@Address must be filled@@';
		}
		if(empty($_SESSION[CART_KEY]['step1']['INV_ZIP'])) {
			$ERROR['inv_address']['INV_ZIP'] = '@@ZIP must be filled@@';
		}
		if(empty($_SESSION[CART_KEY]['step1']['INV_CITY'])) {
			$ERROR['inv_address']['INV_CITY'] = '@@City must be filled@@';
		}
		if(empty($_SESSION[CART_KEY]['step1']['EMAIL']) || !is_valid_email($_SESSION[CART_KEY]['step1']['EMAIL'])) {
			$ERROR['inv_address']['EMAIL'] = '@@Email must be filled or is invalid@@';
		}
		if(empty($_SESSION[CART_KEY]['step1']['PHONE'])) {
			$ERROR['inv_address']['PHONE'] = '@@Phone must be filled@@';
		}
		if(isset($ERROR['inv_address']) && count($ERROR['inv_address'])) {
			$_SESSION[CART_KEY]['error']['step1'] = true;
		} elseif(isset($_SESSION[CART_KEY]['error']['step1'])) {
			unset($_SESSION[CART_KEY]['error']['step1']);
		}

	} elseif( isset($_POST['shop_order_submit']) ) {

		if(empty($_POST['shop_terms_agree'])) {
			$_SESSION[CART_KEY]['error']['step2'] = true;
		} elseif(isset($_SESSION[CART_KEY]['error']['step2'])) {
			unset($_SESSION[CART_KEY]['error']['step2']);
		}

	} elseif( isset($_SESSION[CART_KEY]['error']['step2']) && !isset($_POST['shop_order_submit'])) {

		unset($_SESSION[CART_KEY]['error']['step2']);

	}
}

// first we take categories
if( $_shop_load_cat !== false ) {

	preg_match('/\{SHOP_CATEGORY:(\d+)\}/', $content['all'], $catmatch);
	if(!empty($catmatch[1])) {
		$shop_limited_cat = true;
		$shop_limited_catid = intval($catmatch[1]);
		if(empty($GLOBALS['_getVar']['shop_cat'])) {
			$GLOBALS['_getVar']['shop_cat'] = $shop_limited_catid;
		}
	} else {
		$shop_limited_cat = false;
	}

	$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_categories WHERE ';
	$sql .= "cat_type='module_shop' AND cat_status=1 AND cat_pid=0 ";
	if($shop_limited_cat) {
		$sql .= 'AND cat_id = ' . $shop_limited_catid . ' ';
	}
	$sql .= 'ORDER BY cat_sort DESC, cat_name ASC';
	$data = _dbQuery($sql);

	$shop_cat = array();

	$shop_cat_selected	= isset($GLOBALS['_getVar']['shop_cat']) ? $GLOBALS['_getVar']['shop_cat'] : 'all';

	if(strpos($shop_cat_selected, '_')) {

		$shop_cat_selected = explode('_', $shop_cat_selected, 2);
		if(isset($shop_cat_selected[1])) {
			// === Alteração Busca o ID da estrutura de acordo com o alias ===
			$cat = array();
			foreach($shop_cat_selected as $value){
				$sql_cat = 'SELECT cat_id FROM phpwcms_categories WHERE cat_alias = "'.$value.'" AND cat_status != 9';
				$res_cat = _dbQuery($sql_cat);

				$cat[] = $res_cat[0]['cat_id'];
			}
			//$cat = get_cat_name($shop_cat_selected, 2);

			$shop_cat_selected = intval($cat[0]);
			$shop_subcat_selected = intval($cat[1]);
			// ========================================================================
		}

		if(!$shop_cat_selected) {
			$shop_cat_selected		= 'all';
			$shop_subcat_selected	= 0;
		}

	} else {

		// === Alteração - Busca o ID da estrutura de acordo com o alias ===
		$sql = 'SELECT cat_id FROM phpwcms_categories WHERE cat_alias = "'.$shop_cat_selected.'" AND cat_status != 9';
		$res = _dbQuery($sql);
		$shop_cat_selected = $res[0]['cat_id'];
		//$shop_cat_selected = get_cat_name($shop_cat_selected, 1);
		// ========================================================================

		$shop_subcat_selected = 0;
	}

	// === Alteração - Busca o ID do produto de acordo com o alias ===
	if(isset($GLOBALS['_getVar']['shop_detail'])){
		$aliasProduto = $GLOBALS['_getVar']['shop_detail'];
		$sql  = 'SELECT shopprod_id FROM phpwcms_shop_products ';
		$sql .= 'WHERE shopprod_description3 = "'.$aliasProduto.'"';
		$res = _dbQuery($sql);

		$shop_detail_id = intval($res[0]['shopprod_id']);
	} else {
		$shop_detail_id = 0;
	}
	// ======================================================================

	unset($GLOBALS['_getVar']['shop_cat'], $GLOBALS['_getVar']['shop_detail']);

	if($shop_detail_id) {
		$GLOBALS['_getVar']['shop_detail'] = $shop_detail_id;
	}

	if(is_array($data) && count($data)) {

		$x = 0;

		foreach($data as $row) {

			if($shop_limited_cat && $row['cat_id'] != $shop_limited_catid) {
				continue;
			}

            $shop_cat_prods = '';
            $submenuAberto  = ($SHOP['submenuAberto'] === '1') ? ' style="display: block"' : '';
			$shop_cat[$x]   = '<li id="shopcat-'.$row['cat_id'].'"';
            $shop_cat[$x]  .= ((int)$shop_cat_selected === (int)$row['cat_id']) ? ' class="active"' : '';

			// now try to retrieve sub categories for active category
			$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_categories WHERE ';
			$sql .= "cat_type='module_shop' AND cat_status=1 AND cat_pid=" . $row['cat_id'] ;
			$sql .= ' ORDER BY cat_sort DESC, cat_name ASC';
			$sdata = _dbQuery($sql);

			$subcat_count = count($sdata);

			$selected_product_cat = $subcat_count && $shop_subcat_selected ? $shop_subcat_selected : $shop_cat_selected;

			if($subcat_count) {

                $shop_subcat = array();
				$z = 0;
				foreach($sdata as $srow) {

					$shop_subcat[$z]   = '<li id="shopsubcat-'.$row['cat_id'].'"';
					if($srow['cat_id'] == $shop_subcat_selected) {
						$shop_subcat[$z] .= ' class="active"';
					}

					$shop_subcat[$z] .= '><a href="'.shop_rel_url($SHOP['alias'], $srow['cat_pid'].'_'.$srow['cat_id']).'">@@';
					$shop_subcat[$z] .= html($srow['cat_name']);
					$shop_subcat[$z] .= '@@</a>';
					if($srow['cat_id'] == $shop_subcat_selected && $_tmpl['config']['cat_list_products']) {
						$shop_subcat[$z] .= get_category_products($srow['cat_id'], $shop_detail_id, $shop_cat_selected, $shop_subcat_selected, $_tmpl['config']['shop_url']);
					}
					$shop_subcat[$z] .= '</li>';

					$z++;
				}

				if(count($shop_subcat)) {
					$shop_cat_prods = LF . '		<ul class="shop-subcategories"'.$submenuAberto.'>' . LF.'			' . implode(LF.'			', $shop_subcat) . LF .'		</ul>' . LF.'	';
				}

				$linkLista = 'href="javascript:void(0);" class="bt-abrir-categoria"';

			} else {

				$linkLista = 'href="' . shop_rel_url($SHOP['alias'], $row['cat_id']) . '"';

			}

			if($_tmpl['config']['cat_list_products']) {
				 $shop_cat_prods .= get_category_products($shop_cat_selected, $shop_detail_id, $shop_cat_selected, $shop_subcat_selected, $_tmpl['config']['shop_url']);
			}

			$shop_cat[$x] .= '><a '.$linkLista.'><i class="fab fa-microsoft"></i>@@';
		    $shop_cat[$x] .= html($row['cat_name']);
			$shop_cat[$x] .= '@@</a>' . $shop_cat_prods;
			$shop_cat[$x] .= '</li>';

			$x++;
		}
	}

	$shop_cat = count($shop_cat) ? implode(LF.'	', $shop_cat) : '';
	$shop_cat_all = '';

	if(empty($_tmpl['config']['cat_all_pos'])) {
		// fallback for older templates
		$_tmpl['config']['cat_all_pos'] = 'bottom';
	} else {
		$_tmpl['config']['cat_all_pos'] = strtolower($_tmpl['config']['cat_all_pos']);
		if($_tmpl['config']['cat_all_pos'] != 'top' && $_tmpl['config']['cat_all_pos'] != 'bottom') {
			$_tmpl['config']['cat_all_pos'] = 'none';
		}
	}

	if( ! $shop_limited_cat && $_tmpl['config']['cat_all_pos'] != 'none') {


		if($_tmpl['config']['cat_all_pos'] == 'top') {
			$shop_cat = $shop_cat_all . LF . '	' . $shop_cat;
		} else {
			$shop_cat .= LF . $shop_cat_all;
		}
	}

	if($shop_cat !== '') {
		$shop_cat = '<ul class="'.$template_default['classes']['shop-category-menu'].'">' . LF . $shop_cat . LF . '</ul>';
	}

	$content['all'] = str_replace('{SHOP_CATEGORIES}', $shop_cat, $content['all']);
	$content['all'] = preg_replace('/\{SHOP_CATEGORY:\d+\}/', $shop_cat, $content["all"]);

	if($shop_cat_selected) {
		$GLOBALS['_getVar']['shop_cat'] = $shop_cat_selected;
		if($shop_subcat_selected) {
			$GLOBALS['_getVar']['shop_cat'] .= '_' . $shop_subcat_selected;
		}
	}
}


// Ok lets search for product listing
if( $_shop_load_list !== false ) {

    if(isset($_SESSION['comprado'])){
        unset($_SESSION['comprado']);
        echo '<div class="comprado">Produto adicionado ao carrinho</div>';
    }

	// check selected category
	$shop_cat_selected	= isset($GLOBALS['_getVar']['shop_cat']) ? $GLOBALS['_getVar']['shop_cat'] : 0;

	if(strpos($shop_cat_selected, '_')) {
		$shop_cat_selected = explode('_', $shop_cat_selected, 2);
		if(isset($shop_cat_selected[1])) {
			$shop_subcat_selected = intval($shop_cat_selected[1]);
		}
		$shop_cat_selected = intval($shop_cat_selected[0]);
		if(!$shop_cat_selected) {
			$shop_subcat_selected = 0;
		}
	} else {
		$shop_cat_selected		= intval($shop_cat_selected);
		$shop_subcat_selected	= 0;
	}
	$selected_product_cat = $shop_subcat_selected ? $shop_subcat_selected : $shop_cat_selected;

	$shop_detail_id		= isset($GLOBALS['_getVar']['shop_detail']) ? intval($GLOBALS['_getVar']['shop_detail']) : 0;

	list($shop_cat_name,$shop_cat_info) = get_shop_category_name($shop_cat_selected, $shop_subcat_selected);

	if(empty($shop_cat_name)) {
		$shop_cat_name		= $_tmpl['config']['cat_all'];
		$shop_cat_selected	= 0;
	}

	$shop_pagetitle = '';

	// Busca as informações dos produtos no banco de dados
	$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_shop_products ';
	$sql .= 'LEFT JOIN phpwcms_categories ON shopprod_category = cat_id WHERE ';
	$sql .= "shopprod_status=1";

	if($selected_product_cat && !$shop_detail_id) {

		$sql .= ' AND (';
		$sql .= "shopprod_category = '" . $selected_product_cat . "' OR ";
		$sql .= "shopprod_category LIKE '%," . $selected_product_cat . ",%' OR ";
		$sql .= "shopprod_category LIKE '" . $selected_product_cat . ",%' OR ";
		$sql .= "shopprod_category LIKE '%," . $selected_product_cat . "' OR ";
		$sql .= "cat_pid = '" . $selected_product_cat . "'";
		$sql .= ')';

	} elseif($shop_detail_id) {

		$sql .= ' AND shopprod_id=' . $shop_detail_id;

	} else {

		$sql .= ' AND shopprod_listall=1';

	}

	// FE language
	$sql .= SHOP_FELANG_SQL;

	$_tmpl['config']['cat_list_sort_by'] = trim($_tmpl['config']['cat_list_sort_by']);
	if($_tmpl['config']['cat_list_sort_by'] !== '') {
		$ordenacao = ' ORDER BY shopprod_ordenacao ASC, '.aporeplace($_tmpl['config']['cat_list_sort_by']);
	}


	// -------------------- Alteração - Primeira parte do paginate --------------------
	$rowsporpagina = $SHOP['itensPaginate'];
	$pagina = (int)mysqli_real_escape_string($conexao, $_GET['pg']);
	$range = 2;

	list($result_paginate, $totalpaginas, $paginaatual, $numerorows) = paginateShop($sql, $rowsporpagina, $pagina, $ordenacao.' LIMIT', $conexao, $GLOBALS['content']["article_id"], $SHOP['itensHome']);

	$data = _dbQuery($result_paginate);
    // -------------------------- Fim da primeira parte do paginate --------------------------

	if(isset($data[0]) ) {

		$x = 0;
		$entry = array();

		$shop_prod_detail = rel_url(array(), array('shop_detail', 'l'));

		$_tmpl['config']['init_lightbox'] = false;

		foreach($data as $row) {

			$shop_prod_link = shop_rel_url($SHOP['alias'], $GLOBALS['_getVar']['shop_cat'], $row['shopprod_id']);

			$row['vat'] = (float) $row['shopprod_vat'];
			$row['vat_decimals'] = dec_num_count($row['vat']);
			if($row['vat_decimals'] < $_tmpl['config']['vat_decimals']) {
				$row['vat_decimals'] = $_tmpl['config']['vat_decimals'];
			}
			if($row['shopprod_netgross'] == 1) {
				// price given is GROSS price, including VAT
				$row['net']		= $row['shopprod_price'] / (1 + $row['vat'] / 100);
				$row['gross']	= $row['shopprod_price'];
			} else {
				// price given is NET price, excluding VAT
				$row['net']		= $row['shopprod_price'];
				$row['gross']	= $row['shopprod_price'];
			}

			$row['vat']		= number_format($row['vat'],   $row['vat_decimals'],   $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']);
			$row['net']		= number_format($row['net'],   $_tmpl['config']['price_decimals'], $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']);
			$row['gross']	= number_format($row['gross'], $_tmpl['config']['price_decimals'], $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']);
			$row['weight']	= $row['shopprod_weight'] > 0 ? number_format($row['shopprod_weight'], $_tmpl['config']['weight_decimals'], $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']) : '';

			$row['shopprod_var'] = @unserialize($row['shopprod_var']);

			// check custom product URL
			if(empty($row['shopprod_var']['url'])) {
				$row['prod_url'] = array('link'=>'', 'target'=>'');
			} else {
				$row['prod_url'] = get_redirect_link($row['shopprod_var']['url'], ' ', '');
				$row['prod_url']['link'] = html($row['prod_url']['link']);
			}

			// select template based on listing or detail view
			$entry[$x] = $shop_detail_id ? $_tmpl['detail'] : $_tmpl['list_entry'];

			if($_tmpl['config']['on_request_trigger'] == $row['net']) {

				$_cart = '';
				$_cart_add = '';
				$_cart_on_request = TRUE;

			} else {

				$botao = preg_match("/\[BOTAO\](.*?)\[\/BOTAO\]/s", $entry[$x], $g) ? $g[1] : '';
				$_cart = preg_match("/\[CART_ADD\](.*?)\[\/CART_ADD\]/is", $entry[$x], $g) ? $g[1] : '';
				$_cart = str_replace($botao, '', $_cart);
				$linkForm = rel_url(array('shop_cart' => 'show'), array('shop_detail'), $_tmpl['config']['cart_url']);
				$linkProd = rel_url(array('shop_cart' => 'show'), array('shop_detail'), $_tmpl['config']['shop_url']);

				if(isset($_GET['shop_detail'])){

					// Gera a lista de tamanhos do produto (se tiver) ------------------------------------------------------
					if(!empty($row['shopprod_size'])){

						$listaTamanhos = preg_split("/\\r\\n|\\r|\\n/",$row['shopprod_size']);

						$tamanhos = '<p>
							<strong>'.$_tmpl['config']['tit_select_1'].'</strong>
							<select name="shop_prod_size" id="shop_prod_size">
							<option value="">Selecione</option>';
						foreach($listaTamanhos as $value){
							$value = rtrim($value);
							$tamanhos .= '<option value="'.$value.'">'.$value.'</option>';
						}
						$tamanhos .= '</select>
							</p>';

					} else {

						$tamanhos = '';

					}

					// Gera a lista de cores do produto (se tiver) ---------------------------------------------------------
					if(!empty($row['shopprod_color'])){

						$listaCores = preg_split("/\\r\\n|\\r|\\n/",$row['shopprod_color']);

						$cores = '<p>
							<strong>'.$_tmpl['config']['tit_select_2'].'</strong>
							<select name="shop_prod_color" id="shop_prod_color">
							<option value="">Selecione</option>';
						foreach($listaCores as $value){
							$value = rtrim($value);
							$cores .= '<option value="'.$value.'">'.$value.'</option>';
						}
						$cores .= '</select>
							</p>';

					} else {

						$cores = '';

					}

					// Gera a lsita de opções adicionais do produto (se tiver) ---------------------------------------------
					if(!empty($row['shopprod_special_price'])){

						$listaOutros = preg_split("/\\r\\n|\\r|\\n/",$row['shopprod_special_price']);

						$outros = '<p>
							<strong>'.$_tmpl['config']['tit_select_3'].'</strong>
							<select name="shop_prod_other" id="shop_prod_other">
							<option value="">Selecione</option>';
						foreach($listaOutros as $value){
							$value = rtrim($value);
							$outros .= '<option value="'.$value.'">'.$value.'</option>';
						}
						$outros .= '</select>
							</p>';

					} else {

						$outros = '';

					}


					if($SHOP['redirecionar'] === '1'){$action = $linkForm;} else {$action = '';}

					$_cart_add  = '<form action="'.$action.'" method="post">';
					$_cart_add .= $_cart;
					$_cart_add .= '<input type="hidden" name="shop_prod_id" value="'.$row['shopprod_id'].'" />';
					$_cart_add .= '<input type="hidden" name="shop_action" value="add" />';
					$_cart_add .= '<div class="box-opcoes">'.$tamanhos.$cores.$outros.'</div>';

					if($SHOP['confAlteravel'] === '1'){
						$_cart_add .= '<div class="quantidade">'."\n"
                                    . '    <i class="fas fa-plus"></i>'."\n"
                                    . '    <input type="text" name="shop_prod_amount" value="1" />'."\n"
                                    . '    <i class="fas fa-minus"></i>'."\n"
                                    . '</div>';
					} else {
						$_cart_add .= '<input type="hidden" name="shop_prod_amount" value="1" />';
					}

					if(strpos($_cart, 'input ') !== false) {
						// user has set input button
						$_cart_add .= $_cart;
					} else {
						$_cart_add .= '<input type="submit" name="shop_cart_add" value="'.$botao.'" title="adicionar ao carrinho" class="list-add-button adicionar-carrinho" />';
					}
					$_cart_add .= '</form>';

				} else {

					if($SHOP['redirecionar'] === '1'){$action = $linkForm;} else {$action = '';}

					$_cart_add  = '<div class="comprar-produto">';
					$_cart_add .= '<form action="'.$action.'" method="post">';
					$_cart_add .= $_cart;
					$_cart_add .= '<input type="hidden" name="shop_prod_id" value="'.$row['shopprod_id'].'" />';
					$_cart_add .= '<input type="hidden" name="shop_action" value="add" />';

					// Mostra o campo de quantidade se a opção "Quantidade Alterável" estiver ativada
					if($SHOP['confAlteravel'] === '1'){
                        $_cart_add .= '<div class="quantidade">'."\n"
                                    . '    <i class="fas fa-plus"></i>'."\n"
                                    . '    <input type="text" name="shop_prod_amount" value="1" />'."\n"
                                    . '    <i class="fas fa-minus"></i>'."\n"
                                    . '</div>';
					} else {
						$_cart_add .= '<input type="hidden" name="shop_prod_amount" value="1" />';
					}

					if(strpos($_cart, 'input ') !== false) {
						// user has set input button
						$_cart_add .= $_cart;
					} else {
						$_cart_add .= '<input type="submit" name="shop_cart_add" value="'.$botao.'" title="adicionar ao carrinho" class="list-add-button adicionar-carrinho" />';
					}
                    $_cart_add .= '</form>
                    </div>';

				}

				$_cart_on_request = FALSE;

			}

			// ALTERAÇÃO - ESCONDE O BOTÃO DE COMPRA DE ACORDO COM AS OPÇÕES DE CONFIGURAÇÕES ---------------
			$tagBotao = $_tmpl['config']['ele_botao_escondido'];
			$classeBotao = !empty($_tmpl['config']['classe_botao_escondido']) ? ' class="'.$_tmpl['config']['classe_botao_escondido'].'"' : '';
			$classeCodigo = !empty($_tmpl['config']['classe_botao_codigo']) ? ' '.$_tmpl['config']['classe_botao_codigo'] : '';
			$novoBotao = '<'.$tagBotao.$classeBotao.'>'.$SHOP['textoBotao'].'</'.$tagBotao.'>';

			if($SHOP['esconderBotao'] === '1'){

				if($_SESSION[session_id()]){

					$botaoCompra = $_cart_add;
                    $novaClasse = '';

				} else {

					$botaoCompra = $novoBotao;
                    $novaClasse = $classeCodigo;

                }

			} else {

				$botaoCompra = $_cart_add;
                $novaClasse = '';

			}

			$entry[$x] = str_replace('{CLASSE_BOTAO_ESCONDIDO}',$novaClasse,$entry[$x]);
			$entry[$x] = preg_replace('/\[CART_ADD\](.*?)\[\/CART_ADD\]/is', $botaoCompra, $entry[$x]);
			// ------------------------------------------ FIM DA ALTERAÇÃO -----------------------------------------


			// Categoria do Produto
			$listaCategorias = explode(',', $row['shopprod_category']);
			$sqlCat = 'SELECT cat_name FROM phpwcms_categories WHERE cat_id = '.$listaCategorias[0];
			$resultCat = _dbQuery($sqlCat);

			// product name
			$entry[$x] = str_replace('{CURRENCY_SYMBOL}', html($_tmpl['config']['sigla_moeda']), $entry[$x]);


			// ALTERAÇÃO - ESCONDE O PREÇO DE ACORDO COM AS OPÇÕES DE CONFIGURAÇÕES -------------------------
			$tag = $_tmpl['config']['ele_preco'];
			$sigla = $_tmpl['config']['sigla_moeda'];
			$classe = !empty($_tmpl['config']['classe_preco']) ? ' class="'.$_tmpl['config']['classe_preco'].'"' : '';
			$tagLog = $_tmpl['config']['ele_preco_logado'];
			$classeLog = !empty($_tmpl['config']['classe_preco_logado']) ? ' class="'.$_tmpl['config']['classe_preco_logado'].'"' : '';

			if($SHOP['precoLogado'] === '1'){

				if($_SESSION[session_id()]){

					if($SHOP['preco'] === '1'){

					    $texto = !empty($SHOP['textoPreco']) ? '<'.$tag.$classe.'>'.$SHOP['textoPreco'].'</'.$tag.'>' : '';
                        $entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_GROSS_PRICE', $texto);

					} else {

                        $entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_GROSS_PRICE', '<'.$tag.' class="preco">'.$sigla.' '.$row['gross'].'</'.$tag.'>');

					}

				} else {

					$texto = !empty($SHOP['textoLogado']) ? '<'.$tagLog.$classeLog.'>'.$SHOP['textoLogado'].'</'.$tagLog.'>' : '';
					$entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_GROSS_PRICE', $texto);

				}

			} else {

				if($SHOP['preco'] === '1'){

					$texto = !empty($SHOP['textoPreco']) ? '<'.$tag.$classe.'>'.$SHOP['textoPreco'].'</'.$tag.'>' : '';
                    $entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_GROSS_PRICE', $texto);

				} else {

                    $entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_GROSS_PRICE', '<'.$tag.' class="preco">'.$sigla.''.$row['gross'].'</'.$tag.'>');

				}

			}
			// ------------------------------------------ FIM DA ALTERAÇÃO -----------------------------------------

			$entry[$x] = render_cnt_template($entry[$x], 'ON_REQUEST', $_cart_on_request);
			$entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_TITLE', html($row['shopprod_name1']));
			$entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_ADD', html($row['shopprod_name2']));
			$entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_SHORT', $row['shopprod_description0']);
			$entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_LONG', $row['shopprod_description1']);
			$entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_WEIGHT', $row['weight']);
			$entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_NET_PRICE', $row['net']);
			$entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_VAT', $row['vat']);
			$entry[$x] = render_cnt_template($entry[$x], 'PRODUCT_URL', $row['prod_url']['link']);
			$entry[$x] = render_cnt_template($entry[$x], 'BOTAO', $botao);
			$entry[$x] = render_cnt_template($entry[$x], 'CATEGORIA', $resultCat[0]['cat_name']);
			$entry[$x] = render_cnt_template($entry[$x], 'PESO', $row['weight']);

			if(empty($_shopPref['shop_pref_discount']['discount']) || empty($_shopPref['shop_pref_discount']['percent'])) {
				$row['discount'] = '';
			} else {
				$row['discount'] = round($_shopPref['shop_pref_discount']['percent'], 2);
				if($row['discount'] - floor($row['discount']) == 0) {
					$row['discount'] = number_format($row['discount'], 0, $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']);
				} else {
					$row['discount'] = number_format($row['discount'], 1, $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']);
				}
			}
			$entry[$x] = render_cnt_template($entry[$x], 'DISCOUNT', $row['discount']);
			$entry[$x] = str_replace('{PRODUCT_URL_TARGET}', $row['prod_url']['target'], $entry[$x]);

			$entry[$x] = render_cnt_template($entry[$x], 'ORDER_NUM', html($row['shopprod_ordernumber']));
			$entry[$x] = render_cnt_template($entry[$x], 'MODEL', html($row['shopprod_model']));
			$entry[$x] = render_cnt_template($entry[$x], 'VIEWED', number_format($row['shopprod_track_view'], 0, $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']));


			if($shop_detail_id) {

				$_tmpl['config']['mode']		= 'detail';
				$_tmpl['config']['lightbox_id']	= '[product_'.$x.'_'.$shop_detail_id.']';

				if($row['shopprod_name2']) {
					$row['shopprod_name2'] = sprintf(str_replace('%S', ' ', $_tmpl['config']['pagetitle_add']), $row['shopprod_name2']);
				}
				if($row['shopprod_model']) {
					$row['shopprod_model'] = sprintf(str_replace('%S', ' ', $_tmpl['config']['pagetitle_model']), $row['shopprod_model']);
				}
				if($row['shopprod_ordernumber']) {
					$row['shopprod_ordernumber'] = sprintf(str_replace('%S', ' ', $_tmpl['config']['pagetitle_ordernumber']), $row['shopprod_ordernumber']);
				}
				$shop_pagetitle = sprintf(
					$_tmpl['config']['pagetitle'],
					sprintf(str_replace('%S', ' ', $_tmpl['config']['pagetitle_productname']), $row['shopprod_name1']),
					$row['shopprod_name2'],
					$row['shopprod_model'],
					$row['shopprod_ordernumber']
				);

				// product detail
				$entry[$x] = str_replace('{PRODUCT_DETAIL_LINK}', $shop_prod_link, $entry[$x]);
                $entry[$x] = str_replace('{LINK_VIDEO}', $row['shopprod_var']['url'], $entry[$x]);

				$teste = preg_match("/\[LINK_VIDEO\](.*?)\[\/LINK_VIDEO\]/is", $entry[$x], $g) ? $g[1] : '';

				if(!empty($row['shopprod_var']['url'])){
					$entry[$x] = render_cnt_template($entry[$x], 'LINK_VIDEO', $teste);
				} else {
					$entry[$x] = render_cnt_template($entry[$x], 'LINK_VIDEO', '');
				}

				// Images
				$_prod_list_img = array();

				if(count($row['shopprod_var']['images'])) {

					$row['shopprod_var']['img_count'] = 1;
					$content['images']['shop'] = array();

					foreach($row['shopprod_var']['images'] as $img_key => $img_vars) {
						$img_vars['count'] = $row['shopprod_var']['img_count'];
						$cod = $row['shopprod_var']['img_count'] === 1 ? md5('lightbox'.generic_string(5)) : $cod;
						if($_tmpl['config']['image_detail_more_start'] <= $row['shopprod_var']['img_count']) {
							$_tmpl['config']['mode'] = 'detail_more';
						}
						if($img_vars = shop_image_tag($row['shopprod_var']['images'][$img_key], $img_vars['count'], $row['shopprod_name1'], $cod, 1)) {
							$_prod_list_img[] = $img_vars;
							$row['shopprod_var']['img_count']++;
						}
						$content['images']['shop'][] = array(
							'id'	=> $row['shopprod_var']['images'][$img_key]['f_id'],
							'name'	=> $row['shopprod_var']['images'][$img_key]['f_name'],
							'hash'	=> $row['shopprod_var']['images'][$img_key]['f_hash'],
							'ext'	=> $row['shopprod_var']['images'][$img_key]['f_ext']
						);
					}
				}

				// Se o produto não tiver imagem, busca a imagem padrão
				if($_prod_list_img){

					$_prod_list_img = implode($_tmpl['image_space'], $_prod_list_img);

				} else {

					$_prod_list_img = '<span class="shop-article-img img-num-1 img-first">
					<img class="sem-imagem" src="include/inc_module/mod_shop/template/ico-sem-foto.png" alt="Imagem n&atilde;o dispon&iacute;vel" title="Imagem n&atilde;o dispon&iacute;vel" \>
					</span>';

				}


				// Files
				$_prod_list_files = isset($row['shopprod_var']['files'][0]['f_id']) ? shop_files($row['shopprod_var']['files']) : '';

				if($row['shopprod_description0']) {
					$row['meta_description'] = $row['shopprod_description0'];
				} elseif($row['shopprod_description1']) {
					$row['meta_description'] = $row['shopprod_description1'];
				} else {
					$row['meta_description'] = '';
				}

				if($row['meta_description']) {
					$row['meta_description'] = trim( strip_tags( strip_bbcode($row['meta_description']) ) );
					$row['meta_description'] = getCleanSubString($row['meta_description'], 75, '', 'word');
					$row['meta_description_rendered'] = true;
				} else {
					$row['meta_description_rendered'] = false;
				}

				if(!empty($row['shopprod_overwrite_meta'])) {
					$content["pagetitle"] = setPageTitle($content["pagetitle"], $article['cat'], $shop_pagetitle);
					if($row['meta_description_rendered']) {
						set_meta('description', $row['meta_description']);
					}
				}

				//if($row['shopprod_opengraph']) {
					$content['opengraph']['type'] = 'og:product';
					$content['opengraph']['title'] = $shop_pagetitle;
					$content['opengraph']['url'] = PHPWCMS_URL.shop_rel_url($SHOP['alias'], $GLOBALS['_getVar']['shop_cat'], $shop_detail_id);
					//$content['opengraph']['url'] = abs_url(array('shop_detail'=>$shop_detail_id), array('shop_cat', 'shop_cart', 'phpwcms_output_action', 'print', 'phpwcms-preview', 'unsubscribe', 'subscribe'));

					if($row['meta_description_rendered']) {
						$content['opengraph']['description'] = $row['meta_description'];
					}

				//} else {
					//$content['opengraph']['support'] = false;
				//}

				// Update product view count
				// ToDo: Maybe use cookie or session to avoid tracking in case showed once
				$sql = 'UPDATE LOW_PRIORITY '.DB_PREPEND.'phpwcms_shop_products SET shopprod_track_view=shopprod_track_view+1 WHERE shopprod_id='.$shop_detail_id;

				_dbQuery($sql, 'UPDATE');

			} else {

				$_tmpl['config']['mode']		= 'list';
				$_tmpl['config']['lightbox_id']	= '';

				$_prod_list_img = array();

				// Imagens (lightbox com todas as imagens)
				if(count($row['shopprod_var']['images'])) {

					$row['shopprod_var']['img_count'] = 1;
					$content['images']['shop'] = array();

					foreach($row['shopprod_var']['images'] as $img_key => $img_vars) {
						$img_vars['count'] = $row['shopprod_var']['img_count'];
						$cod = $row['shopprod_var']['img_count'] === 1 ? md5('lightbox'.generic_string(5)) : $cod;
						if($_tmpl['config']['image_detail_more_start'] <= $row['shopprod_var']['img_count']) {
							$_tmpl['config']['mode'] = 'detail_more';
						}
						if($img_vars = shop_image_tag($row['shopprod_var']['images'][$img_key], $img_vars['count'], $row['shopprod_name1'], $cod, $SHOP['interna'], $shop_prod_link, 2)) {
							$_prod_list_img[] = $img_vars;
							$row['shopprod_var']['img_count']++;
						}
						$content['images']['shop'][] = array(
							'id'	=> $row['shopprod_var']['images'][$img_key]['f_id'],
							'name'	=> $row['shopprod_var']['images'][$img_key]['f_name'],
							'hash'	=> $row['shopprod_var']['images'][$img_key]['f_hash'],
							'ext'	=> $row['shopprod_var']['images'][$img_key]['f_ext']
						);
					}
				}

				// Se o produto não tiver imagem, busca a imagem padrão
				if($_prod_list_img){

					$_prod_list_img = implode($_tmpl['image_space'], $_prod_list_img);

				} else {

					$_prod_list_img = '<span class="shop-article-img img-num-1 img-first">
						<a href="'.$shop_prod_link.'">
							<img src="include/inc_module/mod_shop/template/ico-sem-foto.png" alt="Imagem não disponível" title="Imagem não disponível" \>
						</a>
					</span>';

				}

				// product listing
				if($SHOP['interna'] === '1'){
					$entry[$x] = str_replace('{PRODUCT_DETAIL_LINK}', '', $entry[$x]);
				} else {
					$entry[$x] = str_replace('{PRODUCT_DETAIL_LINK}', $shop_prod_link, $entry[$x]);
				}

				// no files in list mode
				$_prod_list_files = '';

			}

			if(!$_tmpl['config']['init_lightbox'] && $_prod_list_img) {
				$_tmpl['config']['init_lightbox'] = true;
			}

			$entry[$x] = render_cnt_template($entry[$x], 'IMAGE', $_prod_list_img);


			// Render Files
			$entry[$x] = render_cnt_template($entry[$x], 'FILES', $_prod_list_files);


			$x++;
		}

		// initialize Lightbox effect
		if($_tmpl['config']['init_lightbox'] || $SHOP['interna'] === '1') {
			initLightbox();
		}
		$entries = implode($_tmpl['list_space'], $entry);
	} else {
		$entries = $_tmpl['list_none'];
	}

	if($shop_detail_id) {
		$entries = $_tmpl['config']['shop_wrap']['prefix'] . $entries . $_tmpl['config']['shop_wrap']['suffix'];
	} else {
		$entries = $_tmpl['config']['shop_wrap']['prefix'] . $_tmpl['list_header'] . LF . $entries . LF . $_tmpl['list_footer'] . $_tmpl['config']['shop_wrap']['suffix'];
	}

	$entries = str_replace('{CATEGORY}', html($shop_cat_name), $entries);
	$entries = str_replace('{DESCRICAO}', $shop_cat_info, $entries);

	// ---------- Segunda parte do paginate ----------
	if(isset($pagina) && !empty($pagina)){

		$parts = explode('/', $_SERVER['REQUEST_URI']);
		$parts = array_filter($parts);
		$last = array_pop($parts);
		$parts = array(implode('/', $parts), $last);
		$url = '/'.$parts[0].'/';

	} else {

		$url = $_SERVER['REQUEST_URI'];

	}

	$pagi = links_paginateShop($totalpaginas, $paginaatual, $range, $url);

	if($GLOBALS['content']["article_id"] === '1'){

		$entries = render_cnt_template($entries, 'PAGINATE', '');

	} else {

		if($totalpaginas > 1){
			$entries = render_cnt_template($entries, 'PAGINATE', $pagi);
		} else {
			$entries = render_cnt_template($entries, 'PAGINATE', '');
		}

	}
	// ---------- Fim do paginate ----------

	$entries = render_cnt_template($entries, 'CART_LINK', is_cart_filled() ? rel_url(array('shop_cart' => 'show'), array('shop_detail'), $_tmpl['config']['cart_url']) : '');
	$entries = parse_cnt_urlencode($entries);

	$content['all'] = str_replace('{SHOP_PRODUCTLIST}', $entries, $content['all']);

	if(preg_match('/<!--\s{0,}RENDER_SHOP_PAGETITLE:(BEFORE|AFTER)\s{0,}-->/', $content['all'], $match)) {

		if(empty($GLOBALS['pagelayout']['layout_title_spacer'])) {
			$title_spacer = ' | ';
			$GLOBALS['pagelayout']['layout_title_spacer'] = $title_spacer;
		} else {
			$title_spacer = $GLOBALS['pagelayout']['layout_title_spacer'];
		}

		if($shop_pagetitle) {
			$shop_pagetitle .= $title_spacer;
		}

		$shop_pagetitle .= $shop_cat_name;

		if(empty($content['pagetitle'])) {
			$content['pagetitle'] = html($shop_pagetitle);
		} elseif($match[1] == 'BEFORE') {
			$content['pagetitle'] = html($shop_pagetitle . $title_spacer) . $content['pagetitle'];
		} else {
			$content['pagetitle'] .= html($title_spacer . $shop_pagetitle);
		}

		$content['all'] = str_replace($match[0], '', $content['all']);

	}
}


// =====================================================================================================================
// ================================================ ETAPAS DO SHOPPING =================================================
// =====================================================================================================================

if($_shop_load_order ) {

	$cart_data = get_cart_data();


	// ============================================ CARRINHO VAZIO ============================================
	if(
		empty($cart_data) && !isset($_POST['novo-cadastro']) && !isset($_POST['cad_login']) && !isset($_POST['shop_cart_cadastro']) && !isset($_POST['login_submit']) && !isset($_GET['cad']) && !isset($_GET['apr']) && !isset($_POST['shop_cart_login'])
	) {

		$order_process = $_tmpl['cart_none'];



	// ====================================== PÁGINA DE LOGIN / CADASTRO ======================================
	} elseif(
		(isset($_POST['shop_cart_checkout']) && !isset($_SESSION[session_id()])) ||
		(isset($_POST['user_login']) && !isset($_SESSION[session_id()]))
	) {

		$loginUrl = rel_url( array('profile_reminder'=>'1'), array('profile_manage', 'profile_register'), 'aid='.$SHOP['aidClientes'] );

		$_tmpl['inv_login']= str_replace('{ACTION}', utf8_decode(rel_url(array('shop_cart' => 'show'), array('shop_detail','shop_cat','l','b'), $_tmpl['config']['cart_url'])), $_tmpl['inv_login']);

		$_tmpl['inv_login']= str_replace('{LEMBRAR-SENHA}', $loginUrl, $_tmpl['inv_login']);

		if(isset($_POST['user_login']) && !isset($_SESSION[session_id()])){

			$_tmpl['inv_login'] = str_replace('{ERROR}', '<span>Senha ou login incorreto</span>', $_tmpl['inv_login']);

		} else {

			$_tmpl['inv_login'] = str_replace('{ERROR}', '', $_tmpl['inv_login']);

		}

		$order_process = $_tmpl['inv_login'];

		require_once('inc/validate.login.inc.php');



	// =================================== PÁGINA DE FORMULÁRIO DE CADASTRO ===================================
	} elseif(
		isset($_POST['shop_cart_login']) ||
		(isset($_POST['novo-cadastro']) && !isset($_SESSION[session_id()])) ||
		(!isset($_SESSION[session_id()]) && isset($_GET['cad']) && !isset($_POST['cad_login']))
	) {

		if(isset($_POST['novo-cadastro'])){

			$_tmpl['inv_address'] = str_replace('{VALIDAR}', '<script type="text/javascript">$().ready(function(e) {$("h1").text("Novo Cadastro");});</script><input type="hidden" id="cadastro-topo" name="cadastro-topo" />', $_tmpl['inv_address']);

		} else {

			$_tmpl['inv_address'] = str_replace('{VALIDAR}', '', $_tmpl['inv_address']);

		}

		$order_process = $_tmpl['inv_address'];



		$cores[$prod_id] = $_SESSION[CART_KEY]['cores'][$prod_id];
		$opcoes[$prod_id] = $_SESSION[CART_KEY]['opcoes'][$prod_id];
		$recargas[$prod_id] = $_SESSION[CART_KEY]['numerorecarga'][$prod_id];

		$order_process = '<form id="form-cadastro-shop" enctype="multipart/form-data" action="'.rel_url(array('shop_cart'=>'show'), array('shop_detail','l','b'), $_tmpl['config']['cart_url']) . '" method="post"><input type="hidden" name="cad_url" id="cad_url" value="'.rel_url(array('shop_cart'=>'show'), array('shop_detail','l','b'), $_tmpl['config']['cart_url']).'" />' . LF . trim($order_process) . LF . '</form>';

		if(isset($_SESSION['cep_temp'])){
			$order_process = str_replace('{VALOR_CEP}', htmlspecialchars($_SESSION['cep_temp']), $order_process);
		} else {
			$order_process = str_replace('{VALOR_CEP}', '', $order_process);
		}



	// ========================== GRAVA AS INFORMAÇÕES DE CADASTRO NO BANCO DE DADOS ==========================
	} elseif (
		(empty($cart_data) && !isset($_POST['novo-cadastro']) && isset($_POST['cad_login'])) ||
		(!empty($cart_data) && !isset($_POST['novo-cadastro']) && isset($_POST['cad_login']))
	){

		$ativo = $SHOP['moderado'] === '1' ? 0 : 1;

		if($_POST['cad_nome_fantasia']){$tipo = 1;} else {$tipo = 2;}

		$detail['data'] = array(
			'detail_title'		=> $arquivo,
			'detail_created'	=> date('Y-m-d H:i:s'),
			'detail_changed'	=> date('Y-m-d H:i:s'),
			'detail_firstname'	=> clean_slweg($_POST['cad_nome']),
			'detail_lastname'	=> '',
			'detail_company'	=> clean_slweg($_POST['cad_nome_fantasia']),
			'detail_street'		=> clean_slweg($_POST['cad_endereco_ent']),
			'detail_add'		=> clean_slweg($_POST['cad_num_ent']),
			'detail_city'		=> clean_slweg($_POST['cad_cidade_ent']),
			'detail_zip'		=> clean_slweg($_POST['cad_cep']),
			'detail_region'		=> clean_slweg($_POST['cad_bairro_ent']),
			'detail_country'	=> clean_slweg($_POST['cad_uf_ent']),
			'detail_fon'		=> clean_slweg($_POST['cad_fone']),
			'detail_fax'		=> clean_slweg($autorizadas),
			'detail_mobile'		=> clean_slweg($_POST['cad_cel']),
			'detail_signature'	=> '',
			'detail_prof'		=> '',
			'detail_public'		=> 1,
			'detail_aktiv'		=> $ativo,
			'detail_newsletter'	=> 0,
			'detail_website'	=> '',
			'detail_gender'		=> '',
			'detail_birthday'	=> '',
			'detail_varchar1'	=> clean_slweg($_POST['cad_rg']),
			'detail_varchar2'	=> clean_slweg($_POST['cad_cpf']),
			'detail_varchar3'	=> clean_slweg($_POST['cad_cnpj']),
			'detail_varchar4'	=> clean_slweg($_POST['cad_tel_empresa']),
			'detail_varchar5'	=> clean_slweg($_POST['cad_cel_empresa']),
			'detail_text1'		=> clean_slweg($_POST['cad_site_empresa']),
			'detail_text2'		=> clean_slweg($_POST['cad_comp_ent']),
			'detail_text3'		=> clean_slweg($_POST['cad_razao']),
			'detail_text4'		=> clean_slweg($_POST['cad_registro']),
			'detail_text5'		=> clean_slweg($_POST['cad_responsavel']),
			'detail_email'		=> clean_slweg($_POST['cad_login']),
			'detail_login'		=> clean_slweg(strtolower($_POST['cad_login'])),
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

		$usuario = 'SELECT * FROM phpwcms_userdetail WHERE detail_login = "'.$postLogin.'" AND detail_aktiv != 9';
		$checagem = mysqli_query($conexao,$usuario) or die (mysql_error());

		$consulta_id3 = 'SELECT * FROM phpwcms_userdetail ORDER BY detail_id DESC LIMIT 1';
		$id3 = mysqli_query($conexao, $consulta_id3);
		$ultimo_id3 = mysqli_fetch_array($id3);
		$ultimo3 = $ultimo_id3['detail_id'];
		$total3 = $ultimo3 + 1;

		$query = 'INSERT INTO phpwcms_userdetail (detail_title, detail_firstname, detail_lastname, detail_company, detail_street, detail_add, detail_city, detail_zip, detail_region, detail_fon, detail_login, detail_password, detail_notes, detail_aktiv, detail_prof, detail_signature, detail_public, detail_fax, detail_mobile, detail_country, detail_website, detail_gender, detail_text1, detail_text2, detail_text3, detail_text4, detail_text5, detail_varchar1, detail_varchar2, detail_varchar3, detail_varchar4, detail_varchar5, detail_email, detail_birthday, detail_int1, detail_int2, detail_int3, detail_int4, detail_int5, detail_float1, detail_float2, detail_float3, detail_float4, detail_float5 ) VALUES (';
		$query .= "'".$detail['data']['detail_title']."', ";
		$query .= "'".$detail['data']['detail_firstname']."', ";
		$query .= "'".$detail['data']['detail_lastname']."', ";
		$query .= "'".$detail['data']['detail_company']."', ";
		$query .= "'".$detail['data']['detail_street']."', ";
		$query .= "'".$detail['data']['detail_add']."', ";
		$query .= "'".$detail['data']['detail_city']."', ";
		$query .= "'".$detail['data']['detail_zip']."', ";
		$query .= "'".$detail['data']['detail_region']."', ";
		$query .= "'".$detail['data']['detail_fon']."', ";
		$query .= "'".$detail['data']['detail_login']."', ";
		$query .= "'".md5($detail['data']['detail_password'])."', ";
		$query .= "'".serialize($detail['data']['detail_notes'])."', ";
		$query .= "'".$detail['data']['detail_aktiv']."', ";
		$query .= "'".$detail['data']['detail_prof']."', ";
		$query .= "'".$detail['data']['detail_signature']."', ";
		$query .= "'".$detail['data']['detail_public']."', ";
		$query .= "'".$detail['data']['detail_fax']."', ";
		$query .= "'".$detail['data']['detail_mobile']."', ";
		$query .= "'".$detail['data']['detail_country']."', ";
		$query .= "'".$detail['data']['detail_website']."', ";
		$query .= "'".$detail['data']['detail_gender']."', ";
		$query .= "'".$detail['data']['detail_text1']."', ";
		$query .= "'".$detail['data']['detail_text2']."', ";
		$query .= "'".$detail['data']['detail_text3']."', ";
		$query .= "'".$detail['data']['detail_text4']."', ";
		$query .= "'".$detail['data']['detail_text5']."', ";
		$query .= "'".$detail['data']['detail_varchar1']."', ";
		$query .= "'".$detail['data']['detail_varchar2']."', ";
		$query .= "'".$detail['data']['detail_varchar3']."', ";
		$query .= "'".$detail['data']['detail_varchar4']."', ";
		$query .= "'".$detail['data']['detail_varchar5']."', ";
		$query .= "'".$detail['data']['detail_email']."', ";
		$query .= "'".$detail['data']['detail_birthday']."', ";
		$query .= "'".$detail['data']['detail_int1']."', ";
		$query .= "'".$detail['data']['detail_int2']."', ";
		$query .= "'".$detail['data']['detail_int3']."', ";
		$query .= "'".$detail['data']['detail_int4']."', ";
		$query .= "'".$detail['data']['detail_int5']."', ";
		$query .= "'".$detail['data']['detail_float1']."', ";
		$query .= "'".$detail['data']['detail_float2']."', ";
		$query .= "'".$detail['data']['detail_float3']."', ";
		$query .= "'".$detail['data']['detail_float4']."', ";
		$query .= "'".$detail['data']['detail_float5']."')";

		$resource = mysqli_query($conexao,$query) or die (mysql_error());

		$url = mysqli_real_escape_string($conexao, $_POST['cad_url']);

		if($SHOP['moderado'] === '1'){

			$sqlId = 'SELECT detail_id FROM phpwcms_userdetail ORDER BY detail_id DESC LIMIT 1';
			$resId = mysqli_query($conexao,$sqlId);
			$id = mysqli_fetch_assoc($resId);

			$codigo = codificar($id['detail_id'],1);

			$corpo = _getConfig('shop_pref_email_cadastro', '_shopPref');
			$arrayTags = array('{email}','{nome}','{telefone}','{celular}','{cpf}','{rg}','{fantasia}','{cnpj}','{ie}','{razao}','{responsavel}','{telefone-emp}','{celular-emp}','{url}','{endereco}','{cidade}','{uf}','{bairro}','{cep}','{LINK_APROVACAO}');
			$arrayValores = array(
				$detail['data']['detail_login'],
				$detail['data']['detail_firstname'],
				$detail['data']['detail_fon'],
				$detail['data']['detail_mobile'],
				$detail['data']['detail_varchar2'],
				$detail['data']['detail_varchar1'],
				$detail['data']['detail_company'],
				$detail['data']['detail_varchar3'],
				$detail['data']['detail_text4'],
				$detail['data']['detail_text3'],
				$detail['data']['detail_text5'],
				$detail['data']['detail_varchar4'],
				$detail['data']['detail_varchar5'],
				$detail['data']['detail_text1'],
				$detail['data']['detail_street'],
				$detail['data']['detail_city'],
				$detail['data']['detail_country'],
				$detail['data']['detail_region'],
				$detail['data']['detail_zip'],
				$phpwcms['site'].'index.php?aid='.$SHOP['aidModerado'].'&cod='.$codigo
			);
			$htmlEmail = str_replace($arrayTags,$arrayValores,$corpo);

			$mail_customer = array(
				'recipient'	=> _getConfig('shop_pref_email_to', '_shopPref'),
				'toName'	=> $_SESSION[session_id().'_userdata']['nome'],
				'subject'	=> 'Cadastro de novo usuário',
				'isHTML'	=> 1,
				'html'		=> $htmlEmail,
				'from'		=> _getConfig('shop_pref_email_from', '_shopPref'),
				'sender'	=> _getConfig('shop_pref_email_from', '_shopPref')
			);

			$order_data_mail_customer = sendEmail($mail_customer);

			//header('Location: '.$_SERVER['REQUEST_URI'].'&apr=1');
			header('Location: '.htmlspecialchars_decode(rel_url(array('apr'=>'1'), array('apr','cad'))));

		} else {

			$_loginData['session_key']	= session_id();
			$_loginData['error']		= false;
			$_loginData['login']		= '';
			$_loginData['password']		= '';
			$_loginData['remember']		= 0;
			$_loginData['remind_data']	= '';

			$_loginData['felogin_profile_registration']	= 0;
			$_loginData['felogin_profile_manage']		= 0;
			$_loginData['validate_db']['userdetail']	= 1;
			$_loginData['validate_db']['backenduser']	= 0;

			// handle Login
			if(isset($_POST['cad_login'])) {
				$_loginData['login']		= slweg($_POST['cad_login']);
				$_loginData['password']		= slweg($_POST['cad_senha']);

				$_loginData['remember']		= empty($_POST['feRemember']) ? 0 : 1;

				$_loginData['query_result'] = _checkShopLogin($_loginData['login'], md5($_loginData['password']), $_loginData['validate_db']);

				// ok, and now check if we got valid login data
				if($_loginData['query_result'] !== false && is_array($_loginData['query_result']) && count($_loginData['query_result'])) {
					$_SESSION[ $_loginData['session_key'] ]				= $_loginData['login'];
					$_SESSION[ $_loginData['session_key'].'_userdata']	= _getFrontendUserBaseData($_loginData['query_result']);

				}
			}

			if(empty($cart_data)){
				header('Location: '.$SHOP['alias']);
			} else {
				header('Location: '.$_SERVER['REQUEST_URI'].'&l=1');
			}

		}



	// ================================= FINALIZAÇÃO / VERIFICAÇÃO DE PEDIDO ==================================
	} elseif(
		(isset($_POST['shop_order_submit']) && isset($terms_text) && !isset($_POST['shop_terms_agree']) && isset($_SESSION[session_id()])) ||
		(isset($_POST['shop_cart_checkout']) && isset($_SESSION[session_id()])) ||
		(isset($_POST['shop_cart_cadastro']) && isset($_SESSION[session_id()])) ||
		(isset($_SESSION[session_id()]) && isset($_GET['l'])) ||
		(isset($_SESSION[session_id()]) && isset($_GET['b']))
	) {


		$order_process = $_tmpl['order_terms'];

		unset($_SESSION['alterar-dados']);

		$login = $_SESSION[session_id().'_userdata']['id'];

		$dados_usuario = 'SELECT * FROM phpwcms_userdetail WHERE detail_id = "'.$login.'"';
		$res_usuario = mysqli_query($conexao,$dados_usuario) or die (mysql_error());
		$user = mysqli_fetch_array($res_usuario);

		// Dados de endereço do usuário
		$order_process = render_cnt_template($order_process, 'COMPLEMENTO', $user['detail_text2']);
		$order_process = render_cnt_template($order_process, 'ENDERECO', $user['detail_street']);
		$order_process = render_cnt_template($order_process, 'BAIRRO', $user['detail_region']);
		$order_process = render_cnt_template($order_process, 'CIDADE', $user['detail_city']);
		$order_process = render_cnt_template($order_process, 'PAIS', $user['detail_company']);
		$order_process = render_cnt_template($order_process, 'CEP', $user['detail_zip']);
		$order_process = render_cnt_template($order_process, 'UF', $user['detail_country']);

		// Dados de cadastro do usuário
		$order_process = render_cnt_template($order_process, 'FANTASIA', $user['detail_company']);
		$order_process = render_cnt_template($order_process, 'TELEFONE', $user['detail_fon']);
		$order_process = render_cnt_template($order_process, 'CELULAR', $user['detail_mobile']);
		$order_process = render_cnt_template($order_process, 'LOGIN', $user['detail_login']);
		$order_process = render_cnt_template($order_process, 'NOME', $user['detail_firstname']);

		$order_process = str_replace('{SHOP_LINK}', rel_url(array(), array('shop_cat', 'shop_cart', 'shop_detail','l','b'), $_tmpl['config']['shop_url']), $order_process);
		$order_process = str_replace('{CART_LINK}', rel_url(array('shop_cart' => 'show'), array('shop_detail','l','b'), $_tmpl['config']['cart_url']), $order_process);

		$order_process = render_cnt_template($order_process, 'IF_ERROR', isset($_SESSION[CART_KEY]['error']['step2']) ? ' ' : '');

		$cart_mode = 'terms';
		include($phpwcms['modules']['shop']['path'].'inc/cart.items.inc.php');
		$order_process = str_replace('{ITEMS}', implode($_tmpl['term_space'], $cart_items), $order_process);
		$order_process = str_replace('{COUNT}', $totalProdutos, $order_process);

		// Alteração --------------
		if($SHOP['preco'] === '1'){

			$order_process = preg_replace('/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/is', '', $order_process);
			$order_process = str_replace('{CLASSE_PRECO}',' sp', $order_process);
            $order_process = str_replace('{CLASSE_PRECO}',' sp', $order_process);

		} else {

            $i = 0;
            preg_match_all("/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/s", $order_process, $tpa);

            foreach($tpa[1] as $value){
                $order_process = preg_replace('/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/is', $value, $order_process, 1);
                $i++;
            }

            $order_process = str_replace('{CLASSE_PRECO}','', $order_process);

		}
        // -------------------------------

        // Inicio do Botão de pagseguro -----------------------------------
		if($SHOP['pagseguro']['ativo'] === '1' && ($SHOP['pagseguro']['admin'] === 1)){

			$partesNome = explode(' ', $user['detail_firstname']);
			$nomeUser = $partesNome[1] ? $user['detail_firstname'] : $user['detail_firstname'].' Pagseguro';

			// Método temporário, refazer seguindo os vídeos: https://www.schoolofnet.com/curso-integrando-pagseguro-com-php-parte1/3237
            $url = 'https://ws'.$SHOP['pagseguro']['prefix'].'.pagseguro.uol.com.br/v2/checkout/'; // Url do pagseguro para fazer o checkout
            echo $url;

			// Monta as informações que serão passadas para o pagseguro
			$fields_string = 'email='.$SHOP['pagseguro']['email'].'&token='.$SHOP['pagseguro']['token'].'&currency=BRL&'.$listaItensPagseguro.'&reference='.$order_num.'&senderName='.$nomeUser.'&senderEmail='.$user['detail_login'].'&shippingAddressRequired=false';

			//extraAmount=50.00

			// Cria a conexão com a URL do pagseguro para gerar o token
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);

			if($response === 'Unauthorized'){

				// Altera os botões do finalização
				$btSel = preg_match("/\[ELSE_PAGSEGURO\](.*?)\[\/ELSE_PAGSEGURO\]/s", $order_process, $bt) ? $bt[1] : '';
				$order_process = render_cnt_template($order_process, 'IF_PAGSEGURO', '');
				$order_process = render_cnt_template($order_process, 'ELSE_PAGSEGURO', $btSel);

			} else {

				$xml = new SimpleXMLElement($response);
				$json = json_encode($xml);
				$array = json_decode($json,TRUE);

				// Passa a informação do token para o script do lightbox
				$order_process = render_cnt_template($order_process, 'SCRIPT_PAG', 'https://stc'.$SHOP['pagseguro']['prefix'].'.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js');
				$order_process = render_cnt_template($order_process, 'CODIGO_PAG', $array['code']);

				// Altera os botões do finalização
				$btSel = preg_match("/\[IF_PAGSEGURO\](.*?)\[\/IF_PAGSEGURO\]/s", $order_process, $bt) ? $bt[1] : '';
				$order_process = render_cnt_template($order_process, 'IF_PAGSEGURO', $btSel);
				$order_process = render_cnt_template($order_process, 'ELSE_PAGSEGURO', '');

			}

		} else {

			// Altera os botões do finalização
			$btSel = preg_match("/\[ELSE_PAGSEGURO\](.*?)\[\/ELSE_PAGSEGURO\]/s", $order_process, $bt) ? $bt[1] : '';
			$order_process = render_cnt_template($order_process, 'IF_PAGSEGURO', '');
			$order_process = render_cnt_template($order_process, 'ELSE_PAGSEGURO', $btSel);

		}
		// Fim do Botão de pagseguro --------------------------------------

		$terms_text		= _getConfig( 'shop_pref_terms', '_shopPref' );
		$terms_format	= _getConfig( 'shop_pref_terms_format', '_shopPref' );
		$order_process = str_replace('{TERMS}', $terms_format ? $terms_text : nl2br(html($terms_text)), $order_process);

		include($phpwcms['modules']['shop']['path'].'inc/cart.parse.inc.php');



	// ============================= MENSAGEM DE CADASTRO / MODERAÇÃO DE USUÁRIO ==============================
	} elseif(
		(!isset($_SESSION[session_id()]) && isset($_GET['apr']))
	) {

		$order_process = $_tmpl['msg_aprovacao'];



	// ===================================== PEDIDO REALIZADO / OBRIGADO ======================================
	} elseif(
        (isset($_POST['shop_order_submit']) && isset($_SESSION[session_id()])) ||
        (isset($_GET['ret']) && $_GET['ret'] === 'pagseguro')
	) {

		$infoPedido = $_POST['info-pedido'];

		// Pega o código de transação gerado pelo Pagseguro
		$codigoPagseguro = isset($_POST['shop_order_code']) ? $_POST['shop_order_code'] : '';

		// Gera o código do pedido
		if($_tmpl['config']['order_number_style'] == 'RANDOM') {
			$order_num = generic_string(8, 2);
		} else {
			// count all current orders
			$order_num = _dbCount('SELECT COUNT(*) FROM '.DB_PREPEND.'phpwcms_shop_orders') + 1;
			if(strpos($_tmpl['config']['order_number_style'], '%') !== FALSE) {
				$order_num = sprintf($_tmpl['config']['order_number_style'], $order_num);
			}
		}

		// Puxa os dados do cliente para preencher o e-mail
        $login   = $_SESSION[session_id().'_userdata']['id'];

		$sqlUser = 'SELECT *
                    FROM phpwcms_userdetail
                    WHERE detail_id = "'.$login.'"';
		$resUser = mysqli_query($conexao,$sqlUser) or die (mysql_error());
		$user    = mysqli_fetch_array($resUser);


		// E-mail do Cliente -------------------------------------------------------------------------------------------
		$order_process = _getConfig('shop_pref_email_cliente');

		$cart_mode = 'mail1';
		include($phpwcms['modules']['shop']['path'].'inc/cart.items.inc.php');
		$order_process = str_replace('{ITEMS}', $_tmpl['mail_header'].implode(LF.LF, $cart_items).$_tmpl['mail_footer'], $order_process);

		include($phpwcms['modules']['shop']['path'].'inc/cart.parse.inc.php');

		$valorFinal = $totalGeral;

		$nascimento = date('d/m/Y', strtotime($user['detail_birthday']));

		// Altera as informações dependendo do tipo de cadastro
        $tipo = $user['detail_int1'];

        $nome        = ($tipo === '1') ? $user['detail_company']  : $user['detail_firstname'];
        $celular     = ($tipo === '1') ? $user['detail_varchar5'] : $user['detail_mobile'];
        $telefone    = ($tipo === '1') ? $user['detail_varchar4'] : $user['detail_fon'];
        $tipoCliente = ($tipo === '1') ? 'Pessoa Jurídica'        : 'Pessoa Física';

		$order_process = str_replace('{ORDER}', $order_num, $order_process);
		$order_process = str_replace('{login}', $user['detail_login'], $order_process);
		$order_process = str_replace('{nome}', $nome, $order_process);
		$order_process = str_replace('{cpf}', $user['detail_varchar2'], $order_process);
		$order_process = str_replace('{rg}', $user['detail_varchar1'], $order_process);
		$order_process = str_replace('{email}', $user['detail_login'], $order_process);
		$order_process = str_replace('{telefone}', $telefone, $order_process);
		$order_process = str_replace('{celular}', $celular, $order_process);
		$order_process = str_replace('{cidade}', $user['detail_city'], $order_process);
		$order_process = str_replace('{uf}', $user['detail_country'], $order_process);
		$order_process = str_replace('{cep}', $user['detail_zip'], $order_process);
		$order_process = str_replace('{bairro}', $user['detail_region'], $order_process);
		$order_process = str_replace('{login_cliente}', $phpwcms['site'].'index.php?aid='.$SHOP['aidClientes'], $order_process);
		$order_process = str_replace('{PEDIDO_ENTREGA}', 'Valor da Entrega: R$ '.$confTaxa.'<br />', $order_process);
		$order_process = str_replace('{TOTAL_PEDIDO}',  $valor_formatado, $order_process);
		$order_process = str_replace('{info}', $infoPedido, $order_process);

		$numero = (!empty($user['detail_add']))   ? ', '.$user['detail_add']    : '';
		$comp   = (!empty($user['detail_text2'])) ? ' - '.$user['detail_text2'] : '';
		$order_process = str_replace('{endereco}', $user['detail_street'].$numero.$comp, $order_process);

		$order_process = render_cnt_date($order_process, time());

		$mail_customer = $order_process;

		$content['all'] = str_replace('{CADASTRESE}', $_tmpl['inv_address'], $content['all']);


		// E-mail do Administrador -------------------------------------------------------------------------------------
		$order_process = _getConfig('shop_pref_email_admin');

		$cart_mode = 'mail2';
		include($phpwcms['modules']['shop']['path'].'inc/cart.items.inc.php');
		$order_process = str_replace('{ITEMS}', $_tmpl['mail_header'].implode(LF.LF, $cart_items).$_tmpl['mail_footer'], $order_process);

		include($phpwcms['modules']['shop']['path'].'inc/cart.parse.inc.php');

		$order_process = str_replace('{ORDER}', $order_num, $order_process);
		$order_process = str_replace('{cpf}',$user['detail_varchar2'], $order_process);
		$order_process = str_replace('{login}', $user['detail_login'], $order_process);
		$order_process = str_replace('{nome}',$nome, $order_process);
		$order_process = str_replace('{cpf}', $user['detail_varchar2'], $order_process);
		$order_process = str_replace('{rg}', $user['detail_varchar1'], $order_process);
		$order_process = str_replace('{email}', $user['detail_login'], $order_process);
		$order_process = str_replace('{telefone}', $telefone, $order_process);
		$order_process = str_replace('{celular}', $celular, $order_process);
		$order_process = str_replace('{cidade}', $user['detail_city'], $order_process);
		$order_process = str_replace('{uf}', $user['detail_country'], $order_process);
		$order_process = str_replace('{cep}', $user['detail_zip'], $order_process);
		$order_process = str_replace('{bairro}', $user['detail_region'], $order_process);
		$order_process = str_replace('{site}', $phpwcms['site'], $order_process);
		$order_process = str_replace('{cnpj}', $user['detail_varchar3'], $order_process);
		$order_process = str_replace('{ie}', $user['detail_text4'], $order_process);
		$order_process = str_replace('{razao}', $user['detail_text3'], $order_process);
		$order_process = str_replace('{responsavel}', $user['detail_text5'], $order_process);
		$order_process = str_replace('{url}', $user['detail_varchar3'], $order_process);
		$order_process = str_replace('{PEDIDO_ENTREGA}', 'Valor da Entrega: R$ '.$confTaxa.'<br />', $order_process);
		$order_process = str_replace('{TOTAL_PEDIDO}',  $valor_formatado, $order_process);
		$order_process = str_replace('{info}', $infoPedido, $order_process);
		$order_process = str_replace('{TIPO_CLIENTE}', $tipoCliente, $order_process);

		if(!empty($user['detail_add'])){$numero = ', '.$user['detail_add'];} else {$numero = '';}
		if(!empty($user['detail_text2'])){$comp = ' - '.$user['detail_text2'];} else {$comp = '';}
		$order_process = str_replace('{endereco}', $user['detail_street'].$numero.$comp, $order_process);

		$order_process = render_cnt_date($order_process, time());

		$mail_neworder = $order_process;


		// Gravação das informações do pedido no banco de dados ---------------------------------------------

		//Monta os array das informações que serão passadas
		$order_data = array(
			'order_number'	  => $order_num,
			'order_date'	  => date('Y-m-d H:i'),
			'order_name'	  => $user['detail_login'],
			'order_user_id'	  => $login,
			'order_pagseguro' => $codigoPagseguro,
			'order_firstname' => $nome,
			'order_email'	  => $user['detail_login'],
			'order_net'		  => $subtotal['float_total_gross'],
			'order_gross'	  => $subtotal['float_total_gross'],
			'order_payment'   => '',
			'order_data'	  => @serialize( array(
									'id' 			 => $_SESSION[session_id().'_userdata']['id'],
									'cart' 			 => $cart_data,
									'address' 		 => $user['detail_street'],
									'zip' 			 => $user['detail_zip'],
									'city' 			 => $user['detail_city'],
									'region' 		 => $user['detail_region'],
									'country' 		 => $user['detail_country'],
									'fone' 			 => $user['detail_fon'],
									'order_fantasia' => $user['detail_company'],
									'tamanho' 		 => '',
									'cor' 			 => '',
									'entrega' 		 => $valTaxa,
									'retirada' 		 => $retirada,
									'mail_customer'	 => $mail_customer,
									'mail_self' 	 => $mail_neworder,
									'subtotal' 		 => array(
													 	    'subtotal_net' => $subtotal['float_net'],
													 	    'subtotal_gross' => $subtotal['float_gross']
														),
									'shipping' 		 => array(
													 		'shipping_net' => $subtotal['float_shipping_net'],
															'shipping_gross' => $subtotal['float_shipping_gross']
														),
									'discount' 		 => array(
													        'discount_net' => $subtotal['float_discount_net'],
															'discount_gross' => $subtotal['float_discount_gross']
														),
									'loworder' 		 => array(
															'loworder_net' => $subtotal['float_loworder_net'],
															'loworder_gross' => $subtotal['float_loworder_gross']
														),
									'weight' 		 => $subtotal['float_weight'],
									'lang' 			 => $phpwcms['default_lang']
								) ),
			'order_status'	  => 'NEW-ORDER'
		);

		// Grava as informações na tabela de pedidos
        $order_data = _dbInsert('phpwcms_shop_orders', $order_data);

		// Envia o e-mail para o cliente
		$email_from = _getConfig( 'shop_pref_email_from', '_shopPref' );
		if(!is_valid_email($email_from)) $email_from = $phpwcms['SMTP_FROM_EMAIL'];

		$order_mail_customer = array(
			'recipient'	=> $user['detail_login'],
			'toName'	=> $_SESSION[session_id().'_userdata']['nome'],
			'subject'	=> str_replace('{ORDER}', $order_num, $_tmpl['config']['mail_customer_subject']),
			'isHTML'	=> 1,
			'html'		=> $mail_customer,
			'from'		=> $email_from,
			'sender'	=> $email_from
		);

		$order_data_mail_customer = sendEmail($order_mail_customer);

		// Envia o e-mail para a administração
		$send_order_to = convertStringToArray( _getConfig( 'shop_pref_email_to', '_shopPref' ), ';' );
		if(empty($send_order_to[0]) || !is_valid_email($send_order_to[0])) {
			$email_to = $phpwcms['SMTP_FROM_EMAIL'];
		} else {
			$email_to = $send_order_to[0];
			unset($send_order_to[0]);
		}

		$order_mail_self = array(
			'from'		=> $_SESSION[session_id().'_userdata']['login'],
			'fromName'	=> $_SESSION[session_id().'_userdata']['nome'],
			'subject'	=> str_replace('{ORDER}', $order_num, $_tmpl['config']['mail_neworder_subject']),
			'isHTML'	=> 1,
			'html'		=> $mail_neworder,
			'recipient'	=> $email_to,
			'sender'	=> $email_from
		);

		$order_data_mail_self = sendEmail($order_mail_self);

		// are there additional recipients for orders?
		if(count($send_order_to)) {
			foreach($send_order_to as $value) {
				$order_mail_self['recipient'] = $value;
				@sendEmail($order_mail_self);
			}
		}


		// Página de Obrigado
		if(!empty($order_data['INSERT_ID']) || !empty($order_data_mail_customer[0])) {

			$order_process = $_tmpl['order_success'];

			$order_process = str_replace('{email}', $user['detail_login'], $order_process);
			$order_process = str_replace('{nome}', $nome, $order_process);

            // Inicio do Botão de pagseguro -----------------------------------

			if($SHOP['pagseguro']['ativo'] === '1' && ($SHOP['pagseguro']['admin'] === 1)){

				$partesNome = explode(' ', $user['detail_firstname']);
				$nomeUser = $partesNome[1] ? $user['detail_firstname'] : $user['detail_firstname'].' Pagseguro';

				// Método temporário, refazer seguindo os vídeos: https://www.schoolofnet.com/curso-integrando-pagseguro-com-php-parte1/3237
				$url = 'https://ws'.$SHOP['pagseguro']['prefix'].'.pagseguro.uol.com.br/v2/checkout/'; // Url do pagseguro para fazer o checkout

				// Monta as informações que serão passadas para o pagseguro
				$fields_string = 'email='.$SHOP['pagseguro']['email'].'&token='.$SHOP['pagseguro']['token'].'&currency=BRL&'.$listaItensPagseguro.'&reference='.$order_num.'&senderName='.$nomeUser.'&senderEmail='.$user['detail_login'].'&shippingAddressRequired=false';

				//extraAmount=50.00

				// Cria a conexão com a URL do pagseguro para gerar o token
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$response = curl_exec($ch);

				if($response === 'Unauthorized'){

					// Altera os botões do finalização
					$btSel = preg_match("/\[ELSE_PAGSEGURO\](.*?)\[\/ELSE_PAGSEGURO\]/s", $order_process, $bt) ? $bt[1] : '';
					$order_process = render_cnt_template($order_process, 'IF_PAGSEGURO', '');
					$order_process = render_cnt_template($order_process, 'ELSE_PAGSEGURO', $btSel);

				} else {

					$xml = new SimpleXMLElement($response);
					$json = json_encode($xml);
					$array = json_decode($json,TRUE);

					// Passa a informação do token para o script do lightbox
					$order_process = render_cnt_template($order_process, 'SCRIPT_PAG', 'https://stc'.$SHOP['pagseguro']['prefix'].'.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js');
					$order_process = render_cnt_template($order_process, 'CODIGO_PAG', $array['code']);

					// Altera os botões do finalização
					$btSel = preg_match("/\[IF_PAGSEGURO\](.*?)\[\/IF_PAGSEGURO\]/s", $order_process, $bt) ? $bt[1] : '';
					$order_process = render_cnt_template($order_process, 'IF_PAGSEGURO', $btSel);
					$order_process = render_cnt_template($order_process, 'ELSE_PAGSEGURO', '');

				}

			} else {

				// Altera os botões do finalização
				$btSel = preg_match("/\[ELSE_PAGSEGURO\](.*?)\[\/ELSE_PAGSEGURO\]/s", $order_process, $bt) ? $bt[1] : '';
				$order_process = render_cnt_template($order_process, 'IF_PAGSEGURO', '');
				$order_process = render_cnt_template($order_process, 'ELSE_PAGSEGURO', $btSel);

			}
			// Fim do Botão de pagseguro --------------------------------------

			$dados_bancarios = _getConfig( 'shop_pref_dados_obrigado', '_shopPref' );

			//unset($_SESSION[CART_KEY]);


		// Página de erro
		} else {

			$order_process = $_tmpl['order_failed'];
			$order_process = str_replace('{SUBJECT}', rawurlencode($_tmpl['config']['mail_neworder_subject']), $order_process);
			$order_process = str_replace('{MSG}', rawurlencode('---- FALLBACK MESSAGE ---' . LF . LF . $mail_customer), $order_process);
			foreach($_SESSION[CART_KEY]['step1'] as $item_key => $row) {
				$order_process = render_cnt_template($order_process, $item_key, html($row));
			}

		}

		$order_process = str_replace('{ORDER}', $order_num, $order_process);



	// ============================================== CARRINHO ================================================
	} else {

		// show cart
		$cart_mode = 'cart';
		include($phpwcms['modules']['shop']['path'].'inc/cart.items.inc.php');

		// Alteração --------------
		if($SHOP['preco'] === '1'){

            $_tmpl['cart_header'] = preg_replace('/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/is', '', $_tmpl['cart_header']);
            $_tmpl['cart_footer'] = preg_replace('/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/is', '', $_tmpl['cart_footer']);
			$_tmpl['cart_header'] = str_replace('{CLASSE_PRECO}',' sp', $_tmpl['cart_header']);
            $_tmpl['cart_footer'] = str_replace('{CLASSE_PRECO}',' sp', $_tmpl['cart_footer']);

		} else {

            $precoHead = preg_match("/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/s", $_tmpl['cart_header'], $tp) ? $tp[1] : '';
            $precoFoot = preg_match("/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/s", $_tmpl['cart_footer'], $tp) ? $tp[1] : '';
            $_tmpl['cart_header'] = preg_replace('/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/is', $precoHead, $_tmpl['cart_header']);
            $_tmpl['cart_footer'] = preg_replace('/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/is', $precoFoot, $_tmpl['cart_footer']);
			$_tmpl['cart_header'] = str_replace('{CLASSE_PRECO}','', $_tmpl['cart_header']);
            $_tmpl['cart_footer'] = str_replace('{CLASSE_PRECO}','', $_tmpl['cart_footer']);

		}
		// -------------------------------

		$order_process  = $_tmpl['cart_header'];
		$order_process .= implode($_tmpl['cart_space'], $cart_items);
		$order_process .= $_tmpl['cart_footer'];

		include($phpwcms['modules']['shop']['path'].'inc/cart.parse.inc.php');

		// Update Cart Button
		$_cart_button = preg_match("/\[UPDATE\](.*?)\[\/UPDATE\]/s", $order_process, $g) ? $g[1] : '';
		if(strpos($_cart_button, 'input ') === false) {
			$_cart_button = '<input type="submit" name="shop_cart_update" value="'.html($_cart_button).'" class="cart-update-button" />';
		}
		$order_process  = preg_replace('/\[UPDATE\](.*?)\[\/UPDATE\]/s', $_cart_button , $order_process);

		// Checkout Button
		$_cart_button = preg_match("/\[CHECKOUT\](.*?)\[\/CHECKOUT\]/s", $order_process, $g) ? $g[1] : '';
		if(strpos($_cart_button, 'input ') === false) {
			$_cart_button = '<input type="submit" name="shop_cart_checkout" value="'.html($_cart_button).'" class="cart-checkout-button" />';
		}
		$order_process  = preg_replace('/\[CHECKOUT\](.*?)\[\/CHECKOUT\]/s', $_cart_button , $order_process);

		// Empty Cart Button
		$_cart_button = preg_match("/\[DELETE\](.*?)\[\/DELETE\]/s", $order_process, $g) ? $g[1] : '';
		if(strpos($_cart_button, 'input ') === false) {
			$_cart_button = '<input type="submit" name="shop_cart_delete" value="'.html($_cart_button).'" class="cart-delete-button" />';
		}
		$order_process  = preg_replace('/\[DELETE\](.*?)\[\/DELETE\]/s', $_cart_button , $order_process);

		// Is Shipping?
		$order_process = render_cnt_template($order_process, 'SHIPPING', $subtotal['float_shipping_net'] > 0 ? 1 : '');
		$order_process = '<form id="form-cart" action="' . rel_url(array('shop_cart' => 'show'), array('shop_detail','l'), $_tmpl['config']['cart_url']) . '" method="post">' . LF . trim($order_process) . LF . '</form>';

	}
	$order_process = str_replace('{SHOP_LINK}', rel_url(array(), array('shop_cart', 'shop_detail','l','b'), $_tmpl['config']['shop_url']), $order_process);
	$content['all'] = str_replace('{SHOP_ORDER_PROCESS}', $_tmpl['config']['shop_wrap']['prefix'] . $order_process . $_tmpl['config']['shop_wrap']['suffix'], $content['all']);

}

// small cart
if($_shop_load_cart_small) {

	$_cart_count = 0;

	if(isset($_SESSION[CART_KEY]['products']) && is_array($_SESSION[CART_KEY]['products']) && count($_SESSION[CART_KEY]['products'])) {
		foreach($_SESSION[CART_KEY]['products'] as $cartval) {
			$_cart_count += $cartval;
		}
	}

	if(!$_cart_count) {
		$_cart_count = '';
	}

	if(strpos($_tmpl['cart_small'], '{CART_LINK}')) {

		$shop_cat_selected	= isset($GLOBALS['_getVar']['shop_cat']) ? $GLOBALS['_getVar']['shop_cat'] : 0;
		$shop_detail_id		= isset($GLOBALS['_getVar']['shop_detail']) ? intval($GLOBALS['_getVar']['shop_detail']) : 0;
		unset($GLOBALS['_getVar']['shop_cat'], $GLOBALS['_getVar']['shop_detail']);
		$_tmpl['cart_small'] = str_replace('{CART_LINK}', rel_url(array('shop_cart' => 'show'), array(), $_tmpl['config']['cart_url']), $_tmpl['cart_small']);
		if($shop_cat_selected) {
			$GLOBALS['_getVar']['shop_cat'] = $shop_cat_selected;
		}
		if($shop_detail_id) {
			$GLOBALS['_getVar']['shop_detail'] = $shop_detail_id;
		}
	}

	$_tmpl['cart_small'] = render_cnt_template($_tmpl['cart_small'], 'COUNT', $_cart_count);
	$content['all'] = str_replace('{CART_SMALL}', $_tmpl['cart_small'], $content['all']);
    //$content['all'] = str_replace('{CART_LINK}', $_tmpl['config']['cart_url'], $content['all']);
    $content['all'] = str_replace('{LINK_CART}', 'index.php?aid='.$SHOP['aidCarrinho'], $content['all']);

}


function is_cart_filled() {

	return (empty($_SESSION[CART_KEY]['products']) || !is_array($_SESSION[CART_KEY]['products']) || !count($_SESSION[CART_KEY]['products'])) ? false : true;

}



// =====================================================================================================================
// ================================================ FUNÇÕES DO SHOPPING ================================================
// =====================================================================================================================

// Busca as informações dos produtos no carrinho
function get_cart_data() {

	// retrieve all cart data
	if(!is_cart_filled()) {
		return array();
	}

	$in = array();
	foreach($_SESSION[CART_KEY]['products'] as $key => $value) {
		$key = intval($key);
		$in[$key] = $key;
	}

	$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_shop_products WHERE shopprod_status=1 AND ';
	$sql .= 'shopprod_id IN (' . implode(',', $in) . ')';
	$data = _dbQuery($sql);

	if(isset($data[0])) {

		foreach($data as $key => $value) {
			$data[$key]['shopprod_quantity'] 	= $_SESSION[CART_KEY]['products'][ $value['shopprod_id'] ];
			$data[$key]['shopprod_size'] 		= $_SESSION[CART_KEY]['size'][ $value['shopprod_id'] ];
			$data[$key]['shopprod_color'] 		= $_SESSION[CART_KEY]['color'][ $value['shopprod_id'] ];
			$data[$key]['shopprod_other'] 		= $_SESSION[CART_KEY]['other'][ $value['shopprod_id'] ];
		}

	}

	return $data;

}


function simulation_image_tag($img=array(), $counter=0, $title='') {

	$config =& $GLOBALS['_tmpl']['config'];

	// set image values
	$width		= $config['image_'.$config['mode'].'_width'];
	$height		= $config['image_'.$config['mode'].'_height'];
	$crop		= $config['image_'.$config['mode'].'_crop'];
	$caption	= empty($img['caption']) ? '' : ' :: '.$img['caption'];
	$title		= empty($title) ? '' : ' title="'.html($title.$caption).'"';

	$thumb_image = get_cached_image(array(
		"target_ext"	=>	$img['f_ext'],
		"image_name"	=>	$img['f_hash'] . '.' . $img['f_ext'],
		"max_width"		=>	$width,
		"max_height"	=>	$height,
		"thumb_name"	=>	md5($img['f_hash'].$width.$height.$GLOBALS['phpwcms']["sharpen_level"].$crop.$GLOBALS['phpwcms']['colorspace']),
		'crop_image'	=>	$crop
	));

	if($thumb_image) {

		// now try to build caption and if neccessary add alt to image or set external link for image
		$caption	= getImageCaption($img['caption']);
		// set caption and ALT Image Text for imagelist
		$capt_cur	= html($caption[0]);
		$caption[3] = empty($caption[3]) ? '' : ' title="'.html($caption[3]).'"'; //title
		$caption[1] = html(empty($caption[1]) ? $img['f_name'] : $caption[1]);

		$list_img_temp  = PHPWCMS_IMAGES.$thumb_image[0];

		return $list_img_temp;

	}

	return '';
}

// Busca as imagens dos produtos
function shop_image_tag($img=array(), $counter=0, $title='', $codigo='', $interna=0, $link, $tipo) {

	$config =& $GLOBALS['_tmpl']['config'];

	// set image values
	$width		= $config['image_'.$config['mode'].'_width'];
	$height		= $config['image_'.$config['mode'].'_height'];
	$crop		= $config['image_'.$config['mode'].'_crop'];
	$caption	= empty($img['caption']) ? '' : ' :: '.$img['caption'];
	$title		= empty($title) ? '' : ' title="'.html($title.$caption).'"';

	$thumb_image = get_cached_image(array(
		"target_ext"	=>	$img['f_ext'],
		"image_name"	=>	$img['f_hash'].'.'.$img['f_ext'],
		"max_width"		=>	$width,
		"max_height"	=>	$height,
		"thumb_name"	=>	md5($img['f_hash'].$width.$height.$GLOBALS['phpwcms']["sharpen_level"].$crop.$GLOBALS['phpwcms']['colorspace']),
		'crop_image'	=>	$crop
	));

	if($tipo === 2 && $interna !== '1'){
		//$botaoInicio = '<a href="'.$link.'">';
		//$botaoFinal = '</a>';
	} else {
		$botaoInicio = '';
		$botaoFinal = '';
	}

	if($thumb_image) {

		// now try to build caption and if neccessary add alt to image or set external link for image
		$caption	= getImageCaption($img['caption']);

		// set caption and ALT Image Text for imagelist
		$capt_cur	= html($caption[0]);
		$caption[3] = empty($caption[3]) ? '' : ' title="'.html($caption[3]).'"'; //title
		$caption[1] = html(empty($caption[1]) ? $img['f_name'] : $caption[1]);

		$list_img_temp  = $botaoInicio.'<img src="'.PHPWCMS_IMAGES.$thumb_image[0].'" ';
		$list_img_temp .= $thumb_image[3].' alt="'.$caption[1].'"'.$caption[3].$title.' />'.$botaoFinal;

		// use lightbox effect
		if($tipo === 2) {

			if($interna === '1'){

				$codigo = empty($codigo) ? md5('lightbox'.generic_string(5)) : $codigo;

				$a  = '<a href="img/cmsimage.php/'.$config['image_zoom_width'].'x'.$config['image_zoom_height'].'/';
				$a .= $img['f_hash'].'.'.$img['f_ext'].'" target="_blank" ';
				$a .= 'data-lightbox="img'.$codigo.'"'.$caption[3].$title.' class="image-lightbox">';

				if($counter === 1){
					$list_img_temp = $a.$list_img_temp.'</a>';
				} else {
					$list_img_temp = $a.'</a>';
				}

			}

		} else {

			$codigo = empty($codigo) ? md5('lightbox'.generic_string(5)) : $codigo;

			$a  = '<a href="img/cmsimage.php/'.$config['image_zoom_width'].'x'.$config['image_zoom_height'].'/';
			$a .= $img['f_hash'].'.'.$img['f_ext'].'" target="_blank" ';
			$a .= 'data-lightbox="img'.$codigo.'"'.$caption[3].$title.' class="image-lightbox">';

			$list_img_temp = $a.$list_img_temp.'</a>';

		}

		$class = empty($counter) ? '' : ' img-num-'.$counter;
		$classe = $counter === 1 ? ' img-first' : '';
		if($tipo === 2){$style = $counter === 1 ? '' : ' style="display:none"';} else {$style = '';}

		return '<span class="shop-article-img'.$class.$classe.'"'.$style.'>'.$list_img_temp.'</span>';

	}

	return '';

}

// Busca o nome da categoria de acordo com a página
function get_shop_category_name($id=0, $subid=0) {
	if(empty($id)) {
		return '';
	}
	$cat_name = '';

	$sql  = 'SELECT cat_name, cat_info FROM '.DB_PREPEND.'phpwcms_categories WHERE ';
	$sql .= "cat_type='module_shop' AND cat_status=1 AND cat_id=" . $id . ' LIMIT 1';
	$data = _dbQuery($sql);

	if(isset($data[0]['cat_name'])) {
		$cat_name = $data[0]['cat_name'];
	}

	if(isset($data[0]['cat_info'])) {
		$cat_info = $data[0]['cat_info'];
	} else {
		$cat_info = '';
	}

	if($subid) {

		$sql  = 'SELECT cat_name, cat_info FROM '.DB_PREPEND.'phpwcms_categories WHERE ';
		$sql .= "cat_type='module_shop' AND cat_status=1 AND cat_id=" . $subid . ' LIMIT 1';
		$data = _dbQuery($sql);

		if(isset($data[0]['cat_name'])) {
			if($cat_name) {
				$cat_name .= str_replace('_', ' ', $GLOBALS['_tmpl']['config']['cat_subcat_spacer']);
			}
			$cat_name .= $data[0]['cat_name'];
		}

		if(isset($data[0]['cat_info'])) {
			$cat_info = $data[0]['cat_info'];
		} else {
			$cat_info = '';
		}
	}

	return array($cat_name,$cat_info);
}

/*
// Busca a lista de métodos de pagamento (não disponível)
function get_payment_options() {

	$payment_prefs = _getConfig( 'shop_pref_payment', '_shopPref' );
	$supported = array('prepay' => 0, 'pod' => 0, 'onbill' => 0);
	$available = array();
	foreach($supported as $key => $value) {
		if($payment_prefs[$key]) $available[$key] = $payment_prefs[$key];
	}

	return $available;

}
*/

function get_category_products($selected_product_cat, $shop_detail_id, $shop_cat_selected, $shop_subcat_selected, $shop_alias) {

	$shop_cat_prods = '';

	$sql  = "SELECT * FROM ".DB_PREPEND.'phpwcms_shop_products WHERE ';
	$sql .= "shopprod_status=1";
	$sql .= ' AND (';
	$sql .= "shopprod_category = '" . $selected_product_cat . "' OR ";
	$sql .= "shopprod_category LIKE '%," . $selected_product_cat . ",%' OR ";
	$sql .= "shopprod_category LIKE '" . $selected_product_cat . ",%' OR ";
	$sql .= "shopprod_category LIKE '%," . $selected_product_cat . "'";
	$sql .= ')';

	// FE language
	$sql .= SHOP_FELANG_SQL;
	$pdata = _dbQuery($sql);
	/*
	if(is_array($pdata) && count($pdata)) {

		$z = 0;
		$shop_cat_prods = array();
		foreach($pdata as $prow) {

			$shop_cat_prods[$z] = '<li id="shopcat-product-'.$prow['shopprod_id'].'"';
			if($prow['shopprod_id'] == $shop_detail_id) {
				$shop_cat_prods[$z] .= ' class="active"';
			}
			$shop_cat_prods[$z] .= '>';

			$prow['get'] = array(
				'shop_cat' => $shop_cat_selected,
				'shop_detail' => $prow['shopprod_id']
			);

			if($shop_subcat_selected) {
				$prow['get']['shop_cat'] .= '_' . $shop_subcat_selected;
			}

			$shop_cat_prods[$z] .= '<a href="' . rel_url($prow['get'], array(), $shop_alias) . '">';
			$shop_cat_prods[$z] .= html($prow['shopprod_name1']);
			$shop_cat_prods[$z] .= '</a>';
			$shop_cat_prods[$z] .= '</li>';
			$z++;

		}

		if(count($shop_cat_prods)) {
			$shop_cat_prods = LF . '		<ul class="'.$template_default['classes']['shop-products-menu'].'">' . LF.'			' . implode(LF.'			', $shop_cat_prods) . LF .'		</ul>' . LF.'	';
		}

	}
	*/

	return $shop_cat_prods;

}


// Busca a lista de arquivos de um produto
function shop_files($data=array()) {

	global $phpwcms;

	$value = array(
		'cnt_object'			=> array('cnt_files' => array('id' => array(), 'caption' => array())), // id, caption
		'files_direct_download'	=> $GLOBALS['_tmpl']['config']['files_direct_download'],
		'files_template'		=> $GLOBALS['_tmpl']['config']['files_template']
	);

	foreach($data as $item) {
		$value['cnt_object']['cnt_files']['id'][]		= $item['f_id'];
		$value['cnt_object']['cnt_files']['caption'][]	= $item['caption'];
	}

	$IS_NEWS_CP	= true;
	$news		= array('files_result' => '');
	$crow		= array();

	// include content part files renderer
	include(PHPWCMS_ROOT.'/include/inc_front/content/cnt7.article.inc.php');

	return $news['files_result'];

}

// 
function get_cat_name2($valor, $modo){

	if(!empty($valor)){
		if($modo === 1){
			$sql = 'SELECT cat_id FROM phpwcms_categories WHERE cat_alias = "'.$valor.'"';
			$res = _dbQuery($sql);
			$cat = $res[0]['cat_id'];
		} else {
			foreach($valor as $value){
				$sql_cat = 'SELECT cat_id FROM phpwcms_categories WHERE cat_alias = "'.$value.'"';
				$res_cat = _dbQuery($sql_cat);

				$cat[] = $res_cat[0]['cat_id'];
			}
		}

		return $cat;

	} else {
		return false;
	}
}

// Remove os acentos dos nomes do status
function remover_acentos_status2($string) {

	// Assume ISO-8859-1 if not UTF-8
	$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
	                .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
	                .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
	                .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
	                .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
	                .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
	                .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
	                .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
	                .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
	                .chr(252).chr(253).chr(255);

	$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

	$string = strtr($string, $chars['in'], $chars['out']);
	$double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
	$double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
	$string = str_replace($double_chars['in'], $double_chars['out'], $string);
	$string = str_replace(' ', '-', $string);

	return strtolower(trim($string));
}

// Codificação / Descodificação do código do usuário para aprovação
function codificar($codigo,$tipo){

	$chave = '4%#TR*!RF5';

	if($tipo == 1){
		$codigo = urlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($chave),$codigo, MCRYPT_MODE_CBC, md5(md5($chave)))));
	} else {
		$codigo = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($chave), base64_decode($codigo), MCRYPT_MODE_CBC, md5(md5($chave))), "\0");
	}

	return $codigo;

}

//Cadastro de usuários no shop
//include(PHPWCMS_ROOT.'/include/inc_module/mod_shop/inc/cadastro.usuario.inc.php');

//$content['all'] = str_replace('{SHOP_CADASTRO}', $cadastro, $content['all']);

//include(PHPWCMS_ROOT.'/include/inc_module/mod_shop/inc/site-editar.usuario.inc.php');
//$content['all'] = str_replace('{SHOP_DADOS_CLIENTE}', $cadastro, $content['all']);
//$content['all'] = str_replace('{SHOP_SENHA_CLIENTE}', $senha, $content['all']);
//$content['all'] = str_replace('{SHOP_HISTORICO}', $historico, $content['all']);
//$content['all'] = str_replace('{SHOP_HISTORICO_ATIVO}', $ativo, $content['all']);


// Montagem do paginate
function paginateShop($query, $rows, $pagina, $ordem, $conexao, $idPagina, $numPagina){

	if(!empty($query)){

		$dados = mysqli_query($conexao, $query);	// Executa o query para que seja contado o número de itens
		$numerorows = mysqli_num_rows($dados);		// Número de itens encontrados
		$totalpaginas = ceil($numerorows / $rows); 	// Quantidade total de páginas

		// Faz os cálculos de páginas e limites com os dados informados
		if ($pagina && is_int($pagina)) {$paginaatual = (int)$pagina;} else {$paginaatual = 1;}
		if ($paginaatual > $totalpaginas) {$paginaatual = $totalpaginas;}
		if ($paginaatual < 1) {$paginaatual = 1;}
		$offsete = ($paginaatual - 1) * $rows;

		$resultados = ($idPagina === '1') ? $query.' '.$ordem.' '.$numPagina : $query.' '.$ordem.' '.$offsete.', '.$rows;
		$lista_resultado = mysqli_query($conexao , $resultados);

	} else {

		return false;

	}

	return array($resultados, $totalpaginas, $paginaatual, $numerorows);

};


// Cria os links para o paginate
function links_paginateShop($totalpaginas, $paginaatual, $range, $url){

	$links = '';
	if ($totalpaginas > 1) {

		$links = '<div class="cb"></div>
		<div class="paginacao">
		<div class="apn_navi">';

			if ($paginaatual > 1) {

				$prevpage = $paginaatual - 1;
				$prevlink = $url.$prevpage;
				$firstlink = $url.'1';

				$links .= "<a href='".$firstlink."/' class='apn_prev' title='Primeira p&aacute;gina'>&laquo;&laquo;</a>";
				$links .= "<a href='".$prevlink."/' class='apn_prev' title='P&aacute;gina anterior'>&laquo;</a>";

			}

			for ($x = ($paginaatual - $range); $x < (($paginaatual + $range) + 1); $x++) {
				if (($x > 0) && ($x <= $totalpaginas) && $totalpaginas > 1) {
					if ($x == $paginaatual) {
						$links .= " <span>$x</span> ";
					} else {
						$pagelink = $url.$x;
						$links .= " <a href='".$pagelink."/'>$x</a> ";
					}
				}
			}

			if ($paginaatual != $totalpaginas) {

				$nextpage = $paginaatual + 1;
				$nextlink = $url.$nextpage;
				$lastlink = $url.$totalpaginas;

				$links .= "<a href='".$nextlink."/' class='apn_next' title='Pr&oacute;xima p&aacute;gina'>&raquo;</a>";
				$links .= "<a href='".$lastlink."/' class='apn_next' title='&Uacute;ltima p&aacute;gina'>&raquo;&raquo;</a>";

			}

		$links .= '</div>
				</div>';

	}
	return $links;
}

//Busca as imagens dos produtos para o histórico de pedidos
function historicoImg($img=array(), $counter=0, $title='', $interna=0, $link, $tipo, $codigo='') {

	$config =& $GLOBALS['_tmpl']['config'];

	// set image values
	$width		= $config['image_'.$config['mode'].'_width'];
	$height		= $config['image_'.$config['mode'].'_height'];
	$crop		= $config['image_'.$config['mode'].'_crop'];
	$caption	= empty($img['caption']) ? '' : ' :: '.$img['caption'];
	$title		= empty($title) ? '' : ' title="'.html($title.$caption).'"';

	$thumb_image = get_cached_image(array(
		"target_ext"	=>	$img['f_ext'],
		"image_name"	=>	$img['f_hash'].'.'.$img['f_ext'],
		"max_width"		=>	$width,
		"max_height"	=>	$height,
		"thumb_name"	=>	md5($img['f_hash'].$width.$height.$GLOBALS['phpwcms']["sharpen_level"].$crop.$GLOBALS['phpwcms']['colorspace']),
		'crop_image'	=>	$crop
	));

	if($thumb_image) {

		// now try to build caption and if neccessary add alt to image or set external link for image
		$caption	= getImageCaption($img['caption']);

		// set caption and ALT Image Text for imagelist
		$capt_cur	= html($caption[0]);
		$caption[3] = empty($caption[3]) ? '' : ' title="'.html($caption[3]).'"'; //title
		$caption[1] = html(empty($caption[1]) ? $img['f_name'] : $caption[1]);

		return '<img src="'.PHPWCMS_IMAGES.$thumb_image[0].'" '.$thumb_image[3].' alt="'.$caption[1].'"'.$caption[3].$title.' class="mCS_img_loaded" />';

	}

	return '<img src="include/inc_module/mod_shop/template/ico-sem-foto.png" alt="Imagem não disponível" title="Imagem não disponível">';

}


// =====================================================================================================================
// ================================================= CONTEÚDO EXTERNO ==================================================
// =====================================================================================================================

//Alteração de dados do usuário
if((strpos($content['all'], '{SHOP_DADOS_CLIENTE}') !== false) || (strpos($content['all'], '{SHOP_SENHA_CLIENTE}') !== false)){

	if(isset($_POST['alterar-dados'])){
		$_SESSION['alterar-dados'] = '1';
	}
	include(PHPWCMS_ROOT.'/include/inc_module/mod_shop/inc/editar.usuario.inc.php');
	$content['all'] = str_replace('{SHOP_DADOS_CLIENTE}', $cadastro, $content['all']);
    $content['all'] = str_replace('{SHOP_SENHA_CLIENTE}', $senha, $content['all']);

}

//Histórico de Pedidos
if(strpos($content['all'], '{SHOP_HISTORICO}') !== false){

	ob_start();
	include(PHPWCMS_ROOT.'/include/inc_module/mod_shop/inc/historico.pedidos.inc.php');
	$historico = ob_get_clean(); // gets content, discards buffer
	$content['all'] = str_replace('{SHOP_HISTORICO}', $historico, $content['all']);

}

// Aprovação de usuários
if(strpos($content['all'], '{APROVACAO_USUARIOS}') !== false){

	include(PHPWCMS_ROOT.'/include/inc_module/mod_shop/inc/aprovacao.usuarios.inc.php');
    $content['all'] = str_replace('{APROVACAO_USUARIOS}', $aprovacao, $content['all']);

}

// Tag do formulário de login
$content['all'] = str_replace('{FORM-LOGIN}', 'index.php?aid='.$SHOP['aidClientes'], $content['all']);

?>
