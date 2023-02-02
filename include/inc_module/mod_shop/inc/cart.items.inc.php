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

$x = 0;
$y = 1;
$cart_items = array();
$total		= array();
$subtotal	= array('net' => 0, 'vat' => 0, 'gross' => 0, 'weight' => 0);


foreach($cart_data as $item_key => $row) {

	$prod_id = $row['shopprod_id'];

	$row['shopprod_var'] = unserialize($row['shopprod_var']);
	$_prod_list_img = simulation_image_tag($row['shopprod_var']['images'][0], 0, $row['shopprod_name1']);
	if($_prod_list_img != ''){
		$img = '<img src="'.$_prod_list_img.'"  />';
	} else {
		$img = '<span class="shop-article-img img-num-1 img-first"><img class="sem-imagem" src="include/inc_module/mod_shop/template/ico-sem-foto.png" alt="Imagem n&atilde;o dispon&iacute;vel" title="Imagem n&atilde;o dispon&iacute;vel" \></span>';
	}

	$total[$prod_id]['quantity']		= $_SESSION[CART_KEY]['products'][$prod_id];
	$total[$prod_id]['vat']				= (float) $row['shopprod_vat'];
	$total[$prod_id]['vat_decimals']	= dec_num_count($total[$prod_id]['vat']);
	$total[$prod_id]['size']			= $_SESSION[CART_KEY]['size'][$prod_id];
	$total[$prod_id]['color']			= $_SESSION[CART_KEY]['color'][$prod_id];
	$total[$prod_id]['other']			= $_SESSION[CART_KEY]['other'][$prod_id];

	if($total[$prod_id]['vat_decimals'] < $_tmpl['config']['vat_decimals']) {
		$total[$prod_id]['vat_decimals'] = $_tmpl['config']['vat_decimals'];
	}

	if($row['shopprod_netgross'] == 1) {

		// price given is GROSS price, including VAT
		$total[$prod_id]['net']		= $row['shopprod_price'] / (1 + $row['shopprod_vat'] / 100);
		$total[$prod_id]['gross']	= $row['shopprod_price'];

	} else {

		// price given is NET price, excluding VAT
		$total[$prod_id]['net']		= $row['shopprod_price'];
		$total[$prod_id]['gross']	= $row['shopprod_price'] * (1 + $row['shopprod_vat'] / 100);

	}

	$subtotal['net']	+= $total[$prod_id]['quantity'] * $total[$prod_id]['net'];
	$subtotal['vat']	+= $total[$prod_id]['quantity'] * ($total[$prod_id]['gross'] - $total[$prod_id]['net']);
	$subtotal['gross']	+= $total[$prod_id]['quantity'] * $total[$prod_id]['gross'];
	$subtotal['weight']	+= $total[$prod_id]['quantity'] * $row['shopprod_weight'];

	$row['vat']		= number_format($total[$prod_id]['vat'],   $total[$prod_id]['vat_decimals'],   $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']);
	$row['net']		= number_format($total[$prod_id]['net'],   $_tmpl['config']['price_decimals'], $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']);
	$row['gross']	= number_format($total[$prod_id]['gross'], $_tmpl['config']['price_decimals'], $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']);
	$row['weight']	= $row['shopprod_weight'] > 0 ? number_format($row['shopprod_weight'], $_tmpl['config']['weight_decimals'], $_tmpl['config']['dec_point'], $_tmpl['config']['thousands_sep']) : '';

	switch($cart_mode) {

		case 'cart':	$cart_items[$x]  = $_tmpl['cart_entry'];
						break;

		case 'terms':	$cart_items[$x]  = $_tmpl['term_entry'];
						break;

		case 'mail1':	$cart_items[$x]  = trim($_tmpl['mail_item']);

						if(empty($cart_items[$x])) {

							$cart_items[$x]  = 'Qty:   {COUNT}' . LF;
							$cart_items[$x] .= 'Ord#:  {ORDER_NUM}' . LF;
							$cart_items[$x] .= 'Item:  {PRODUCT_TITLE}' . LF;
							$cart_items[$x] .= 'Net:   {PRODUCT_NET_PRICE} {CURRENCY_SYMBOL}' . LF;
							$cart_items[$x] .= 'VAT:   {PRODUCT_VAT} %' . LF;
							$cart_items[$x] .= 'Gross: {PRODUCT_GROSS_PRICE} {CURRENCY_SYMBOL}';

						}

						break;

		case 'mail2':	$cart_items[$x]  = trim($_tmpl['mail_admin_item']);

						if(empty($cart_items[$x])) {

							$cart_items[$x]  = 'Qty:   {COUNT}' . LF;
							$cart_items[$x] .= 'Ord#:  {ORDER_NUM}' . LF;
							$cart_items[$x] .= 'Item:  {PRODUCT_TITLE}' . LF;
							$cart_items[$x] .= 'Net:   {PRODUCT_NET_PRICE} {CURRENCY_SYMBOL}' . LF;
							$cart_items[$x] .= 'VAT:   {PRODUCT_VAT} %' . LF;
							$cart_items[$x] .= 'Gross: {PRODUCT_GROSS_PRICE} {CURRENCY_SYMBOL}';

						}

						break;
	}

	// 
	$subTotal = $total[$prod_id]['quantity'] * $total[$prod_id]['gross'];

	$tamanho = ($total[$prod_id]['size']) 	? $total[$prod_id]['size']	: '';
	$cor = ($total[$prod_id]['color']) 		? $total[$prod_id]['color']	: '';
	$outro = ($total[$prod_id]['other']) 	? $total[$prod_id]['other']	: '';

	// -------------------------

	$cart_items[$x] = str_replace('{PRODUCT_DETAIL_LINK}', shop_rel_url($SHOP['alias'], $GLOBALS['_getVar']['shop_cat'], $prod_id), $cart_items[$x]);

	$cart_items[$x] = render_cnt_template($cart_items[$x], 'PRODUCT_TITLE', 		html($row['shopprod_name1']));
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'PRODUCT_SHORT', 		$row['shopprod_description0']);
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'PRODUCT_NET_PRICE', 	$row['net']);
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'PRODUCT_GROSS_PRICE', 	$row['gross']);
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'PRODUCT_WEIGHT', 		$row['weight']);
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'PRODUCT_VAT', 			$row['vat']);
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'ORDER_NUM', 			html($row['shopprod_ordernumber']));
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'MODEL', 				html($row['shopprod_model']));
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'IMAGE', 				$img);
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'PRODUCT_SUBTOTAL', 		number_format($subTotal,2,',','.'));
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'TAMANHO', $tamanho);
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'COR', $cor);
	$cart_items[$x] = render_cnt_template($cart_items[$x], 'OUTRO', $outro);

	// Esconde as informações de preço se ele estiver desabilitado nas configurações -----------
	if($SHOP['preco'] === '1'){

		$cart_items[$x] = preg_replace('/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/is', '', $cart_items[$x]);
        $cart_items[$x] = str_replace('{CLASSE_PRECO}',' sp', $cart_items[$x]);

	} else {

		$textPreco = preg_match("/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/s", $cart_items[$x], $tp) ? $tp[1] : '';
		$cart_items[$x] = preg_replace('/\[PRECO_PRODUTO\](.*?)\[\/PRECO_PRODUTO\]/is', $textPreco, $cart_items[$x]);
        $cart_items[$x] = str_replace('{CLASSE_PRECO}','', $cart_items[$x]);

	}
	// ------------------------------------------------------------------------------------------------------------

	switch($cart_mode) {

        case 'cart':

			$cart_items[$x] = str_replace('{COUNT}', '<i class="fas fa-plus"></i><input type="text" name="shop_prod_amount['.$prod_id.']" value="'.$total[$prod_id]['quantity'].'" size="3" /><i class="fas fa-minus"></i>', $cart_items[$x]);
			break;

		default:
			$cart_items[$x] = str_replace('{COUNT}', $total[$prod_id]['quantity'], $cart_items[$x]);

	}

	$totalProdutos += $total[$prod_id]['quantity'];

	// Monta as informações do produto para o pagseguro
	$infoPagseguro = array(
		'itemId'.$y.'='.$row['shopprod_ordernumber'],
		'itemDescription'.$y.'='.$row['shopprod_name1'],
		'itemAmount'.$y.'='.number_format($total[$prod_id]['gross'],2,'.',''),
		'itemQuantity'.$y.'='.$total[$prod_id]['quantity'],
		'itemWeight'.$y.'='.$row['shopprod_weight']
	);
	$itemPagseguro[] = implode('&',$infoPagseguro);
	$listaItensPagseguro = implode('&',$itemPagseguro);

	$x++;
	$y++;

}

// set shipping fees
$subtotal['shipping_net']	= 0;
$subtotal['shipping_vat']	= 0;
$subtotal['shipping_gross'] = 0;
$subtotal['shipping_calc']	= false;

foreach( _getConfig( 'shop_pref_shipping', '_shopPref' ) as $item_key => $row ) {

	// do nothing as long shipping fee = 0
	if( $row['net'] == 0 ) {
		continue;
	}

	// lower weight and current shipping fee lower then this
	if( $subtotal['weight'] <= $row['weight'] ) { /* && $subtotal['shipping_net'] <= $row['net'] ) {

		$subtotal['shipping_calc'] = true;

	} elseif( $subtotal['weight'] > $row['weight'] && $subtotal['shipping_net'] < $row['net'] ) { */

		$subtotal['shipping_calc'] = true;

	}

	if( $subtotal['shipping_calc'] ) {

		$subtotal['shipping_net']	= $row['net'];
		$subtotal['shipping_gross']	= $subtotal['shipping_net'] * ( 1 + ($row['vat'] / 100) );
		$subtotal['shipping_vat']	= $subtotal['shipping_gross'] - $subtotal['shipping_net'];

		break;
	}

}


?>