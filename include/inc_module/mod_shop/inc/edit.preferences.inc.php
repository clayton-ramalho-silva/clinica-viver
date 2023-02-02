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

//ini_set("display_errors", "1");
//error_reporting(E_ALL);

// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------


$BE['HEADER']['jquery-ui.min.js'] = '	<script type="text/javascript" src="'.$phpwcms['modules'][$module]['dir'].'template/scripts/jquery-ui.min.js"></script>';

// ==================== Lista de Cartões Aceitos ====================
foreach($plugin['data']['shop_pref_payment']['accepted_ccard'] as $value){

	if ($value === end($plugin['data']['shop_pref_payment']['accepted_ccard'])){
        $cards .= $value;
	} else {
		$cards .= $value."\n";
    }

}

?>

<script type="text/javascript">
$(function() {

    $( "#sortable" ).sortable({
        placeholder: "ui-sortable-placeholder"
    });

});

check = function(classe){
	var p = $('.'+classe).parents('p')
	var check = $(p).find("#check_status");
	var hidden = $(p).find("#check_status-hidden");

	if($(check).is(":checked")){
		$(hidden).attr("disabled","disabled");
	} else {
		$(hidden).removeAttr("disabled","disabled");
	}
}

deletar = function(x){
	var del = confirm('Deseja apagar este status?');
	if(del){
		$('#sta'+x).remove();
	} else {
		return false;
	}
}

$().ready(function(e) {

	$('a.bt-add-status').click(function(){
		var lenght = $('div.config-status p').length + 1;
		var funcao = "'checks"+lenght+"'";
		$('p.status-mark').before('<p id="sta'+lenght+'"><b title="Clique e arraste para alterar a ordem" class="draggable"></b><input type="checkbox" name="check_status'+lenght+'" id="check_status" class="checks'+lenght+'" value="1" onclick="check('+funcao+')"><input type="hidden" name="check_status'+lenght+'" id="check_status-hidden" value="0"><input type="text" name="lista_status'+lenght+'" id="lista_status'+lenght+'" value=""><i title="Deletar status" onClick="deletar('+lenght+')"></i></p>');
	});

	$('#pref_preco').on('click', function(){

		if($('#pref_preco').is(':checked')){
			$('p.campo-texto-preco').fadeIn(150)
		} else {
			$('p.campo-texto-preco').fadeOut(150)
		}

	});

	$('#pref_preco_logado').on('click', function(){

		if($('#pref_preco_logado').is(':checked')){
			$('p.campo-texto-logado').fadeIn(150)
		} else {
			$('p.campo-texto-logado').fadeOut(150)
		}

	});

	$('#pref_mod_users').on('click', function(){

		if($('#pref_mod_users').is(':checked')){
			$('p.campo-aid-aprovacao').fadeIn(150)
		} else {
			$('p.campo-aid-aprovacao').fadeOut(150)
		}

	});

	$('#pref_compra_logado').on('click', function(){

		if($('#pref_compra_logado').is(':checked')){
			$('p.campo-compra-logado').fadeIn(150)
		} else {
			$('p.campo-compra-logado').fadeOut(150)
		}

	});

	$('#pref_pagseguro').on('click', function(x){

        <?php
        if($user['admin_config_pagseguro'] === 1){
        ?>

		var p = $(this).parents('p.pagseguro')
		if($('#pref_pagseguro').is(':checked')){
			$('div.campo-texto-pagseguro').css('filter', 'alpha(opacity=100)').fadeTo(150,1)
			$(p).addClass('on')
		} else {
			$('div.campo-texto-pagseguro').css('filter', 'alpha(opacity=0)').fadeTo(150,0)
			$(p).removeClass('on')
		}

        <?php
        } else {
        ?>

		alert('A função de Pagseguro não foi contratada para este projeto.')
		x.preventDefault ? x.preventDefault() : x.returnValue = false;

        <?php
        }
        ?>

	});

});
</script>

<form action="<?= shop_url('controller=preferences'); ?>" method="post" class="editform1">

    <? /* ========== Início do Campo: Taxa (Imposto) ==========
    <? if($preco != '1'){ ?>
	<tr>
		<td align="right" class="chatlist tdtop4"><?= $BLM['config_taxas'] ?>:&nbsp;</td>
		<td>
        	<table cellpadding="0" cellspacing="0" border="0" summary="">
				<tr>
					<td><textarea name="pref_vat" id="pref_vat" class="v12 width125 right" rows="3">
						<?php
                        	foreach( $plugin['data']['shop_pref_vat'] as $value ) {
								echo number_format($value, 2, $BLM['dec_point'], $BLM['thousands_sep']) . LF;
							}
						?>
               			 </textarea>
                     </td>
					<td class="chatlist tdtop4">&nbsp;%</td>
				</tr>
			</table>
        </td>
	</tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
    <? } ?>
     ========== Fim do Campo: Taxa (Imposto) ========== */ ?>


    <? /* ========== Início do Campo: Envio ==========
	if($preco != '1'){ ?>
	<tr>
		<td align="right" class="chatlist" valign="top"><?= $BLM['config_envio'] ?>:&nbsp;</td>
		<td>
        	<table cellpadding="0" cellspacing="0" border="0" summary="">
				<tr>
					<td class="chatlist"><?= $BLM['config_unidade_peso'].', '.$BLM['config_peso_max'] ?>&nbsp;</td>
					<td class="chatlist"><?= $BLM['shopprod_net'] ?>&nbsp;</td>
					<td class="chatlist"><?= $BLM['shopprod_vat'] ?> %</td>
				</tr>
				<?php
				for( $x = 0; $x <= 4; $x++ ) {
					echo '
					<tr>
						<td class="tdtop3"><input name="pref_shipping_weight['.$x.']" type="text" class="v12 width100" value="' . html( @number_format($plugin['data']['shop_pref_shipping'][$x]['weight'], 3, $BLM['dec_point'], $BLM['thousands_sep'] ) ) . '" size="10" maxlength="10" />&nbsp;</td>
						<td class="tdtop3"><input name="pref_shipping_net['.$x.']" type="text" class="v12 width100" value="' . html( @number_format($plugin['data']['shop_pref_shipping'][$x]['net'], 3, $BLM['dec_point'], $BLM['thousands_sep'] ) ) . '" size="10" maxlength="10" />&nbsp;</td>
						<td class="tdtop3"><input name="pref_shipping_vat['.$x.']" type="text" class="v12 width100" value="' . html( @number_format($plugin['data']['shop_pref_shipping'][$x]['vat'], 2, $BLM['dec_point'], $BLM['thousands_sep'] ) ) . '" size="10" maxlength="10" /></td>
					</tr>';
				}
				?>
			</table>
        </td>
	</tr>
    <tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
    <? } ?>
    ========== Fim do Campo: Envio ========== */ ?>


	<? /* ========== Início do Campo: Desconto ==========
	if($preco != '1'){ ?>
	<tr>
		<td align="right" class="chatlist tdtop4"><?= $BLM['shopprod_discount'] ?>:&nbsp;</td>
		<td>
        	<table summary="" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><input type="checkbox" name="pref_discount" id="pref_discount" value="1"<?php is_checked('1', $plugin['data']['shop_pref_discount']['discount']) ?> /></td>
					<td>&nbsp;</td>
					<td><input name="pref_discount_percent" type="text" id="pref_discount_percent" class="v12 width60" value="<?= html( @number_format($plugin['data']['shop_pref_discount']['percent'], 2, $BLM['dec_point'], $BLM['thousands_sep'] ) ) ?>" size="10" maxlength="10" /></td>
					<td align="right" class="chatlist">&nbsp;%</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
    <? } ?>
    ========== Fim do Campo: Desconto ========== */ ?>

	<? /* ========== Início do Campo: Campos Adicionais (em desenvolvimento) ==========
	if($user['admin_config_modo'] === 0){ ?>
	<tr>
    	<td align="right" class="chatlist tdtop4"><?= $BLM['shopprod_campos_adicionais'] ?>:&nbsp;</td>
        <td>
        	<table summary="" cellpadding="1" cellspacing="0" border="0">
				<tr>
					<td><label for="pref_terms_campos" style="background:#E7E8EB; float:left"><input type="checkbox" name="pref_terms_campos" id="pref_terms_campos" value="0"<?php is_checked('0', $plugin['data']['shop_pref_terms_format']) ?> />Utilizar campos adicionais</label>&nbsp;</td>
                </tr>
                <tr>
					<td>
                    	<textarea name="pref_campos_add" id="pref_campos_add" class="v12 width375" rows="10"><? echo 'aaa'; ?></textarea>
                    </td>

			</tr>
		</table>
        </td>
    </tr>
    <? } ?>
	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
    ========== Fim do Campo: Campos Adicionais (em desenvolvimento) ========== */ ?>

    <input type="hidden" name="pref_felang" value="<?= htmlspecialchars($plugin['data']['shop_pref_felang']) ?>" />
    <input type="hidden" name="pref_currency" value="<?= html($plugin['data']['shop_pref_currency']) ?>" />
    <input type="hidden" name="pref_unit_weight" value="<?= html($plugin['data']['shop_pref_unit_weight']) ?>" />

    <div class="content-configuracoes fl">

		<?
        // =============================================================================================================
        // ======================================= CONFIGURAÇÕES DO ADMINISTRADOR ======================================
        // =============================================================================================================
        if($user['admin_config_modo'] === 0){

        // -------------------------------------------- VERSÃO ADMINISTRADOR -------------------------------------------
        ?>
        <div class="box-config config-shop fl">

            <h3>Configurações do Administrador</h3>

            <div class="config-shop-left fl">

                <? // === Campo: Pedido (aid) === // ?>
                <p class="col3">
                    <strong><?= $BLM['config_id_shop'] ?>:</strong>
                    <input name="pref_shop_id" type="text" id="pref_shop_id" class="v12 width375" value="<?= html($plugin['data']['shop_pref_id_shop']) ?>" size="30" maxlength="200" />
                </p>

                <? // === Campo: Carrinho (aid) === // ?>
                <p class="col3">
                    <strong><?= $BLM['config_id_cart'] ?>:</strong>
                    <input name="pref_cart_id" type="text" id="pref_cart_id" class="v12 width375" value="<?= html($plugin['data']['shop_pref_id_cart']) ?>" size="30" maxlength="200" />
                </p>

                <? // === Campo: Área do Cliente (aid) === // ?>
                <p class="col3">
                    <strong><?= $BLM['config_id_user'] ?>:</strong>
                    <input name="pref_cliente_id" type="text" id="pref_cliente_id" class="v12 width375" value="<?= html($plugin['data']['shop_pref_id_cliente']) ?>" size="30" maxlength="200" />
                </p>

                 <? // === Campo: Pedidos por página === // ?>
                <p class="col2">
                    <strong><?= $BLM['config_itens_pedidos'] ?>:</strong>
                    <input name="pref_itens_pedidos" type="text" id="pref_itens_pedidos" class="v12 width375" value="<?= html($plugin['data']['shop_pref_itens_pedidos']) ?>" size="30" maxlength="200" />
                </p>

            </div>

            <div class="config-shop-right fr">

            	<? // === Campo: Ativar / desativar quantidade alterável === // ?>
            	<p>
                	<strong><?= $BLM['config_alteravel'] ?>:&nbsp;</strong>
                    <input type="checkbox" name="pref_alteravel" id="pref_alteravel" value="1"<?php is_checked('1', $plugin['data']['shop_pref_alteravel']) ?> />
                    <label><?= $BLM['config_texto_alteravel']; ?></label>
                </p>

                <? // === Campo: Ativar / desativar o submenu sempre aberto === // ?>
                <p>
                	<strong><?= $BLM['config_submenu'] ?>:&nbsp;</strong>
                    <input type="checkbox" name="pref_submenu" id="pref_submenu" value="1"<?php is_checked('1', $plugin['data']['shop_pref_submenu']) ?> />
                    <label><?= $BLM['config_texto_submenu']; ?></label>
                </p>

            </div>

        </div>

        <?php

        } else {

			// -------------------------------------------- VERSÃO USUÁRIO ---------------------------------------------
		?>
        	<input type="hidden" name="pref_shop_id" id="pref_shop_id" value="<?= html($plugin['data']['shop_pref_id_shop']) ?>" />
            <input type="hidden" name="pref_cart_id" id="pref_cart_id" value="<?= html($plugin['data']['shop_pref_id_cart']) ?>" />
            <input type="hidden" name="pref_cliente_id" id="pref_cliente_id" value="<?= html($plugin['data']['shop_pref_id_cliente']) ?>" />
            <input type="hidden" name="pref_aprovacao_id" id="pref_aprovacao_id" value="<?= html($plugin['data']['shop_pref_aprovacao_id']) ?>" />
            <input type="hidden" name="pref_alteravel" id="pref_alteravel" value="<?php is_checked('1', $plugin['data']['shop_pref_alteravel']) ?>" />
            <input type="hidden" name="pref_submenu" id="pref_submenu" value="<?php is_checked('1', $plugin['data']['shop_pref_submenu']) ?>" />


		<?php
		}
        // =================================== FINAL CONFIGURAÇÕES DO ADMINISTRADOR ====================================
        ?>



        <?
        // =============================================================================================================
        // =========================================== CONFIGURAÇÕES GERAIS ============================================
        // =============================================================================================================
        ?>

        <div class="box-config config-shop fl">

        	<h3>Configurações do Shopping</h3>

            <div class="config-shop-left fl">

                <? // === Campo: Itens por página === // ?>
                <p class="col2">
                    <strong><?= $BLM['config_itens_home'] ?>:</strong>
                    <input name="pref_itens_home" type="text" id="pref_itens_home" class="v12 width375" value="<?= html($plugin['data']['shop_pref_itens_home']) ?>" size="30" maxlength="200" />
                </p>

                <? // === Campo: Produtos por página === // ?>
                <p class="col2">
                    <strong><?= $BLM['config_itens_paginate'] ?>:</strong>
                    <input name="pref_itens_paginate" type="text" id="pref_itens_paginate" class="v12 width375" value="<?= html($plugin['data']['shop_pref_itens_paginate']) ?>" size="30" maxlength="200" />
                </p>

                <? // === Campo: Frete Global === // ?>
                <p class="col2"<?= ($user['admin_config_frete'] === 1) ? '' : ' style="display:none"'; ?>>
                    <strong><?= $BLM['config_frete_global'] ?>:</strong>
                    <input name="pref_frete_global" type="text" id="pref_frete_global" class="v12 width375" value="<?= html($plugin['data']['shop_pref_frete_global']) ?>" size="30" maxlength="200" />
                </p>

                <? // === Campo: Aprovação de Cliente (aid) === // ?>
                <p class="campo-aid-aprovacao col2"<?= ($plugin['data']['shop_pref_mod_users'] === '1') ? ' style="display:block"' : ''; ?>>
                    <strong><?= $BLM['config_id_aprovacao']; ?>:</strong>
                    <input name="pref_aprovacao_id" type="text" id="pref_aprovacao_id" class="v12 width375" value="<?= html($plugin['data']['shop_pref_id_aprovacao']) ?>" size="30" maxlength="200" />
                </p>

                <? // === Campo: Utilizar Pagseguro === // ?>
                <p class="pagseguro<?= ($plugin['data']['shop_pref_pagseguro'] === '1' && $user['admin_config_pagseguro'] === 1) ? ' on' : ''; ?>">
                	<strong><?= $BLM['config_pagseguro'] ?>:&nbsp;</strong>
                    <input type="checkbox" name="pref_pagseguro" id="pref_pagseguro" value="1"<?= $user['admin_config_pagseguro'] === 1 ? is_checked('1', $plugin['data']['shop_pref_pagseguro']) : ''; ?> />
                    <label><?= $BLM['config_texto_pagseguro']; ?></label>

                    <?php

					if($plugin['data']['shop_pref_email_pagseguro_sandbox'] && $plugin['data']['shop_pref_token_pagseguro_sandbox'] && $plugin['data']['shop_pref_pagseguro'] === '1'){

						// Verificação dos dados do pagseguro
						$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout/'; // Url do pagseguro para fazer o checkout

						// Monta as informações que serão passadas para o pagseguro
						$fields_string = 'email='.$plugin['data']['shop_pref_email_pagseguro_sandbox'].'&token='.$plugin['data']['shop_pref_token_pagseguro_sandbox'].'&currency=BRL';

						// Cria a conexão com a URL do pagseguro para gerar o token
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$response = curl_exec($ch);

						if($response === 'Unauthorized'){
							echo '<span class="erro-pagseguro">Credenciais de sandbox inválidas, favor verificar o e-mail e token informados</span>';
						}

					}

					if($plugin['data']['shop_pref_email_pagseguro_producao'] && $plugin['data']['shop_pref_token_pagseguro_producao'] && $plugin['data']['shop_pref_pagseguro'] === '1'){

						// Verificação dos dados do pagseguro
						$url = 'https://ws.pagseguro.uol.com.br/v2/checkout/'; // Url do pagseguro para fazer o checkout

						// Monta as informações que serão passadas para o pagseguro
						$fields_string = 'email='.$plugin['data']['shop_pref_email_pagseguro_producao'].'&token='.$plugin['data']['shop_pref_token_pagseguro_producao'].'&currency=BRL';

						// Cria a conexão com a URL do pagseguro para gerar o token
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$response = curl_exec($ch);

						if($response === 'Unauthorized'){
							echo '<span class="erro-pagseguro">Credenciais de produção inválidas, favor verificar o e-mail e token informados</span>';
						}

					}

					?>

                </p>

                <? // === Campo: Dados do pagseguro === // ?>
                <div class="campo-texto-pagseguro"<?= ($plugin['data']['shop_pref_pagseguro'] === '1' && $user['admin_config_pagseguro'] === 1) ? ' style="opacity:1"' : ''; ?>>

                	<? // === Campo: E-mail do Pagseguro (sandbox) === // ?>
                	<p class="col2">
                        <strong><?= $BLM['config_email_pagseguro_sandbox'] ?>:</strong>
                        <input name="pref_email_pagseguro_sandbox" type="text" id="pref_email_pagseguro_sandbox" class="v12 width375" value="<?= html($plugin['data']['shop_pref_email_pagseguro_sandbox']) ?>" size="30" maxlength="200" />
                    </p>

                    <? // === Campo: Token do Pagseguro (sandbox) === // ?>
                    <p class="col2 fr">
                        <strong><?= $BLM['config_token_pagseguro_sandbox'] ?>:</strong>
                        <input name="pref_token_pagseguro_sandbox" type="text" id="pref_token_pagseguro_sandbox" class="v12 width375" value="<?= html($plugin['data']['shop_pref_token_pagseguro_sandbox']) ?>" size="30" maxlength="200" />
                    </p>

                    <? // === Campo: E-mail do Pagseguro (produção) === // ?>
                	<p class="col2">
                        <strong><?= $BLM['config_email_pagseguro_producao'] ?>:</strong>
                        <input name="pref_email_pagseguro_producao" type="text" id="pref_email_pagseguro_producao" class="v12 width375" value="<?= html($plugin['data']['shop_pref_email_pagseguro_producao']) ?>" size="30" maxlength="200" />
                    </p>

                    <? // === Campo: Token do Pagseguro (produção) === // ?>
                    <p class="col2 fr">
                        <strong><?= $BLM['config_token_pagseguro_producao'] ?>:</strong>
                        <input name="pref_token_pagseguro_producao" type="text" id="pref_token_pagseguro_producao" class="v12 width375" value="<?= html($plugin['data']['shop_pref_token_pagseguro_producao']) ?>" size="30" maxlength="200" />
                    </p>

                </div>

            </div>

            <div class="config-shop-right fr">

            	<? // === Campo: Desabilitar página de detalhes === // ?>
                <p>
                	<strong><?= $BLM['config_pagina_detalhes'] ?>:&nbsp;</strong>
                    <input type="checkbox" name="pref_interna" id="pref_interna" value="1"<?php is_checked('1', $plugin['data']['shop_pref_interna']) ?> />
                    <label>Desabilita o link do produto que direciona para a página interna</label>
                </p>

                <? // === Campo: Redirecionar para Carrinho === // ?>
                <p>
                	<strong><?= $BLM['config_redirecionar_cart'] ?>:&nbsp;</strong>
                    <input type="checkbox" name="pref_redirect" id="pref_redirect" value="1"<?php is_checked('1', $plugin['data']['shop_pref_redirect']) ?> />
                    <label>Ao adicionar um produto, o cliente é redirecionado para o carrinho</label>
                </p>

                <? // === Campo: Esconder Preço === // ?>
                <p>
                	<strong><?= $BLM['config_esconder_preco'] ?>:&nbsp;</strong>
                    <input type="checkbox" name="pref_preco" id="pref_preco" value="1"<?php is_checked('1', $plugin['data']['shop_pref_preco']) ?> />
                    <label><?= $BLM['config_esconder_preco_desc']; ?></label>
                </p>

                <? // === Campo: Esconder Preço === // ?>
                <p class="campo-texto-preco"<?= ($plugin['data']['shop_pref_preco'] === '1') ? ' style="display:block"' : ''; ?>>
                	<strong><?= $BLM['config_texto_preco'] ?>:&nbsp;</strong>
                	<textarea name="texto-preco" id="texto-preco"><?= $plugin['data']['shop_pref_texto_preco']; ?></textarea>
                </p>

                <p><? // === Campo: Preço somente para logados === // ?>
                	<strong><?= $BLM['config_preco_logado'] ?>:&nbsp;</strong>
                    <input type="checkbox" name="pref_preco_logado" id="pref_preco_logado" value="1"<?php is_checked('1', $plugin['data']['shop_pref_preco_logado']) ?> />
                    <label><?= $BLM['config_preco_logado_desc']; ?></label>
                </p>
                <p class="campo-texto-logado"<?= ($plugin['data']['shop_pref_preco_logado'] === '1') ? ' style="display:block"' : ''; ?>>
                	<strong><?= $BLM['config_texto_logado'] ?>:&nbsp;</strong>
                	<textarea name="texto-preco-logado" id="texto-preco-logado"><?= $plugin['data']['shop_pref_texto_logado']; ?></textarea>
                </p>

                <p><? // === Campo: Moderação de usuários === // ?>
                	<strong><?= $BLM['config_mod_users'] ?>:&nbsp;</strong>
                    <input type="checkbox" name="pref_mod_users" id="pref_mod_users" value="1"<?php is_checked('1', $plugin['data']['shop_pref_mod_users']) ?> />
                    <label><?= $BLM['config_mod_users_desc']; ?></label>
                </p>

                 <p><? // === Campo: Botão de Compras apenas para usuários logados === // ?>
                	<strong><?= $BLM['config_compra_logado'] ?>:&nbsp;</strong>
                    <input type="checkbox" name="pref_compra_logado" id="pref_compra_logado" value="1"<?php is_checked('1', $plugin['data']['shop_pref_compra_logado']) ?> />
                    <label><?= $BLM['config_compra_logado_desc']; ?></label>
                </p>
                <p class="campo-compra-logado"<?= ($plugin['data']['shop_pref_compra_logado'] === '1') ? ' style="display:block"' : ''; ?>>
                	<strong><?= $BLM['config_texto_compra_logado'] ?>:&nbsp;</strong>
                	<textarea name="texto-compra" id="texto-compra"><?= $plugin['data']['shop_pref_texto_compra']; ?></textarea>
                </p>

            </div>

        </div>
        <?php
		// ======================================== FIM DAS CONFIGURAÇÕES GERAIS =======================================
        ?>


        <div class="overflow fl">
        <div class="box-config config-status fl">
        	<h3>
				<?= $BLM['config_lista_status'] ?>
                <b>(Marque os status de fechamento)</b>
                <span>
                    <i>Status de fechamento são aqueles que marcarão o pedido como finalizado.<br /> Exemplo: Finalizado, Cancelado, Enviado, etc.</i>
                </span>
            </h3>

            <div class="lista-status" id="sortable">

                <? // === Campo: Lista de Status === // ?>
                <?php

                $statusPadrao = array(
                    'Pedido Realizado',
                    'Aguardando Pagamento',
                    'Em Análise',
                    'Aprovado',
                    'Disponível',
                    'Em Disputa',
                    'Devolvida',
                    'Em Devolução',
                    'Em Contestação'
                );

                foreach($statusPadrao as $value){
                ?>

                    <p>
                        <input type="text" name="lista_status" id="lista_status" value="<?= $value ?>" class="status-desabilitado" disabled />
                    </p>

                <?php

                }

                    $i = 1;
                    $listaStatus = explode('|', $plugin['data']['shop_pref_status']);
                    foreach($listaStatus as $value){

                        $partes = explode(',', $value);

                        if($partes[0] === 'Pedido Realizado' || $partes[0] === 'Aguardando Pagamento' || $partes[0] === 'Aprovado' || $partes[0] === 'Cancelado' || $partes[0] === 'Finalizado' || $partes[0] === 'Em Análise' || $partes[0] === 'Disponível' || $partes[0] === 'Em Disputa' || $partes[0] === 'Devolvida' || $partes[0] === 'Em Devolução' || $partes[0] === 'Em Contestação'){

                            continue;

                        } else {

                            $check = ($partes[1] === '1') ? ' checked="checked"' : '';
							$disable = ($partes[1] === '1') ? ' disabled' : '';

                            ?>
                            <p<?= ' id="sta'.$i.'"'; ?>>
                                <b title="Clique e arraste para alterar a ordem" class="draggable"></b>
                                <label><input type="checkbox" name="check_status<?= $i ?>" id="check_status" class="checks<?= $i ?>" value="1" <?= $check; ?> onclick="check('checks<?= $i ?>')" /></label>
                                <input type="hidden" name="check_status<?= $i ?>" id="check_status-hidden" value="2"<?= $disable ?> />
                                <input type="text" name="lista_status<?= $i ?>" id="lista_status<?= $i ?>" value="<?= $partes[0]; ?>" />
                                <i title="Deletar status" onclick="deletar('<?= $i ?>')"></i>
                            </p>
                            <?php
                            $i++;

                        }

                    }

                ?>

            	<p class="status-mark">
                  	<input type="text" name="lista_status" id="lista_status" value="Cancelado" class="status-desabilitado" disabled />
                </p>
                <p>
                  	<input type="text" name="lista_status" id="lista_status" value="Finalizado" class="status-desabilitado" disabled />
                </p>
            	</div>
            </div>
        </div>

        <div class="add-status fl">
        	<a href="javascript:void(0)" class="bt-add-status db">Adicionar Status</a>
        </div>

        <div class="box-config config-emails fl">

            <h3>Configurações de E-mails</h3>

            <? // === Campo: E-mail novo Pedido (para) === // ?>
            <p class="col2">
                <strong><?= $BLM['config_email_para'] ?>:&nbsp;</strong>
                <input name="pref_email_to" type="text" id="pref_email_to" class="v12 width375" value="<?= html(str_replace(';', '; ', $plugin['data']['shop_pref_email_to'])) ?>" />
            </p>

            <? // === Campo: E-mail remetente (De) === // ?>
            <p class="col2 fr">
                <strong><?= $BLM['config_email_de'] ?>:&nbsp;</strong>
                <input name="pref_email_from" type="text" id="pref_email_from" class="v12 width375" value="<?= html($plugin['data']['shop_pref_email_from']) ?>" />
            </p>

            <? // === Campo de E-mail para o Admin  === // ?>
            <p>
                <strong>E-mail do Administrador:</strong>
                <?
                $wysiwyg_editor = array(
                    'value'		=> $plugin['data']['shop_pref_email_admin'],
                    'field'		=> 'email-admin',
                    'height2'	=> '300',
                    'width2'	=> '1028',
                    'rows'		=> '5',
                    'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
                    'lang'		=> 'en'
                );
                include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
                ?>
            </p>

            <? // === Campo de E-mail para o Cliente  === // ?>
            <p>
                <strong>E-mail do Cliente2:</strong>
                <?
                $wysiwyg_editor = array(
                    'value'		=> $plugin['data']['shop_pref_email_cliente'],
                    'field'		=> 'email-cliente',
                    'height2'	=> '300',
                    'width2'	=> '1028',
                    'rows'		=> '5',
                    'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
                    'lang'		=> 'en'
                );
                include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
                ?>
            </p>

            <? // === Campo de E-mail para o Cliente  === // ?>
            <p>
                <strong>E-mail de Cliente Cadastrado:</strong>
                <?
                $wysiwyg_editor = array(
                    'value'		=> $plugin['data']['shop_pref_email_cadastro'],
                    'field'		=> 'email-cadastro',
                    'height2'	=> '300',
                    'width2'	=> '1028',
                    'rows'		=> '5',
                    'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
                    'lang'		=> 'en'
                );
                include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
                ?>
            </p>

            <? // === Campo de E-mail para o Cliente  === // ?>
            <p>
                <strong>E-mail de Cliente Aprovado:</strong>
                <?
                $wysiwyg_editor = array(
                    'value'		=> $plugin['data']['shop_pref_email_aprovado'],
                    'field'		=> 'email-aprovado',
                    'height2'	=> '300',
                    'width2'	=> '1028',
                    'rows'		=> '5',
                    'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
                    'lang'		=> 'en'
                );
                include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
                ?>
            </p>

        </div>

        <div class="box-config config-termos fl">

        	<h3><?= $BLM['shopprod_terms'] ?></h3>

            <? // === Campo: Termos e Condições === // ?>
            <p>
                <span style="background:#E7E8EB">
                    <label for="pref_terms_text">
                        <input type="radio" name="pref_terms_format" id="pref_terms_text" value="0"<?php is_checked('0', $plugin['data']['shop_pref_terms_format']) ?> />
                        <b>TEXTO</b>
                    </label>
                    <label for="pref_terms_html">
                        <input type="radio" name="pref_terms_format" id="pref_terms_html" value="1"<?php is_checked('1', $plugin['data']['shop_pref_terms_format']) ?> />
                        <b>HTML</b>
                    </label>
                </span>
                <textarea name="pref_terms" id="pref_terms" rows="8"><?= $plugin['data']['shop_pref_terms_format'] ? html_entities($plugin['data']['shop_pref_terms']) : html($plugin['data']['shop_pref_terms']); ?></textarea>
            </p>
      	</div>

    </div>

<? // === Botões de Salvar / Limpar  === // ?>
<div class="botoes-acao fr">
	<input name="save" type="submit" class="button10" id="save_button" value="<?= $BLM['config_atualizar'] ?>" />&nbsp;
</div>

</form>

<script>
CKEDITOR.replace( 'pref_email', {
    customConfig: 'include/inc_module/mod_shop/template/ckeditor.config.js'
});
</script>