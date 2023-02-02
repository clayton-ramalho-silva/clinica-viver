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

	$numPedido = intval($_GET['show']);
	
	// Altera as classes das colunas caso a opção de "sem preço" esteja ativada
	if($preco != 1){$classePreco = '-cp';} else {$classePreco = '-sp';}
	
	// ===== Funções Gerais ====
	// Dados do pedido
	$queryPedido = "SELECT * FROM phpwcms_shop_orders WHERE order_id = '".$numPedido."' LIMIT 1";
	$resultPedido = mysqli_query($conexao, $queryPedido);
	$ped = mysqli_fetch_array($resultPedido);
	
	// Dados do usuário
	$queryUsuario = "SELECT * FROM phpwcms_userdetail WHERE detail_id = '".$ped['order_user_id']."'";
	$resultUsuario = mysqli_query($conexao, $queryUsuario);
	$user = mysqli_fetch_array($resultUsuario);

	// Formatação da Data do Pedido
	$date = date('d/m/Y', strtotime($ped['order_date']));

	// ===== Decodificação das informações do pedido =====
	$data = unserialize($ped['order_data']);
	
	if($ped['order_user_id'] === '0'){
		
		$nome = $data["address"]["INV_FIRSTNAME"];
		$cpf = $data["address"]["shop_field_4"];
		$email = $data["address"]["EMAIL"];
		$rg = $data["address"]["shop_field_7"];
		
		// Montagem do endereço do cliente
		if(!empty($data["address"]["INV_ADDRESS"])){$rua = $data["address"]["INV_ADDRESS"];} else {$rua = '';}
		if(!empty($data["address"]["INV_REGION"])){$regiao = ' - '.$data["address"]["INV_REGION"];} else {$regiao = '';}
		if(!empty($data["address"]["INV_CITY"])){$cidade = $data["address"]["INV_CITY"];} else {$cidade = '';}
		if(!empty($data["address"]["shop_field_1"])){$estado = ' / '.$data["address"]["shop_field_1"];} else {$estado = '';}
		
		$endereço = $rua.$numero.$regiao;
		$info_cidade = $cidade.$estado;
		$cep = $data["address"]["INV_ZIP"];
		
		// Telefones
		if(!empty($data["address"]["PHONE"])){$telefone = $data["address"]["PHONE"];} else {$telefone = '';}
		if(!empty($data["address"]["shop_field_5"])){$celular = $data["address"]["shop_field_5"];} else {$celular = '';}
		
		// Nascimento
		$info_data = date('d/m/Y', strtotime($data["address"]["shop_field_13"]));
		
	} else {
		
		// Checa o tipo de usuário para alterar as informações mostradas
		$tipo = $user['detail_int1'];
		
		// Informações do cliente
		$nome = ($tipo === '1') ? $user['detail_company'] : $user['detail_firstname'];
		$cpf = $user['detail_varchar2'];
		$email = $user['detail_login'];
		$rg = $user['detail_varchar1'];
		
		// Informações da Empresa
		$cnpj = $user['detail_varchar3'];
		$razao = $user['detail_text3'];
		$ie = $user['detail_text4'];
		$contato = $user['detail_text5'];
		$site = $user['detail_text1'];
		
		// Montagem do endereço do cliente
		$rua 	= (!empty($user['detail_street'])) 	? $user['detail_street'] 		: '';
		$numero = (!empty($user['detail_add']))		? ', '.$user['detail_add'] 		: '';
		$regiao = (!empty($user['detail_region']))	? ' - '.$user['detail_region'] 	: '';
		$cidade = (!empty($user['detail_city']))	? $user['detail_city'] 			: '';
		$estado = (!empty($user['detail_country']))	? ' / '.$user['detail_country'] : '';
		
		$endereço = $rua.$numero.$regiao;
		$info_cidade = $cidade.$estado;
		$cep = $user['detail_zip'];
		
		// Telefones
		$telefone 	= ($tipo === '1') ? $user['detail_varchar4'] : $user['detail_fon'];
		$celular 	= ($tipo === '1') ? $user['detail_varchar5'] : $user['detail_mobile'];
		
		// Nascimento
		$info_data 	= date('d/m/Y', strtotime($user['detail_birthday']));	
			
	}
	
	// Informações do pedido0
	$pedido = '';
	foreach($data['cart'] as $pedInfo){
			
		$numero = strlen($pedInfo['shopprod_price']);
		$valor 	= number_format($pedInfo['shopprod_price'], $numero, ',', '.');
		
		$sepProd	= ($pedInfo['shopprod_size'] || $pedInfo['shopprod_color'] || $pedInfo['shopprod_other']) ? '<br>' : '';
		$sepCor 	= $pedInfo['shopprod_size'] && $pedInfo['shopprod_color'] 	? ' | ' : '';
		$sepOutro 	= $pedInfo['shopprod_size'] && $pedInfo['shopprod_other'] 	? ' | ' : '';
		$sepOutro 	= $pedInfo['shopprod_color'] && $pedInfo['shopprod_other'] 	? ' | ' : '';
				
		$tamanho	= $pedInfo['shopprod_size']		?	'Tamanho: '.$pedInfo['shopprod_size'] 	: '';
		$cor		= $pedInfo['shopprod_color']	?	$sepCor.'Cor: '.$pedInfo['shopprod_color'] 		: '';
		$outro		= $pedInfo['shopprod_other']	?	$sepOutro.'Outro: '.$pedInfo['shopprod_other'] 	: '';
			
		//$valor = number_format($pedInfo['shopprod_price'], 4, ',', '.');
		$calculo = $pedInfo['shopprod_price'] * $pedInfo['shopprod_quantity'];
		$valorTotal += ($pedInfo['shopprod_price'] * $pedInfo['shopprod_quantity']);
		$total = number_format(($pedInfo['shopprod_price'] * $pedInfo['shopprod_quantity']) + $iof, 2, ',', '.');
	
		$i++;
	
		$pedido .= '<div class="dados-pedido fl">';
		$pedido .= '<div class="produto-col1'.$classePreco.' fl">'.$pedInfo['shopprod_name1'].$sepProd.'<strong>'.$tamanho.$cor.$outro.'</strong></div>';
		$pedido .= '<div class="produto-col2'.$classePreco.' fl">'.$pedInfo['shopprod_ordernumber'].'</div>';
		$pedido .= '<div class="produto-col3'.$classePreco.' fl">'.$pedInfo['shopprod_quantity'].'</div>';
		if($preco != 1){ // Esconde a coluna se o preço estiver escondido
		$pedido .= '<div class="produto-col4'.$classePreco.' fl">R$ '.number_format($pedInfo['shopprod_price'], 2, ',', '.').'</div>';
		}
		$pedido .= '</div>';
	
	}
	
	// ====== Fim da decodificação das informações ======
			
	?>
        
    <div class="tit fl<?php echo $inputClasse; ?>">
		<h3><?php echo $BLM['tit_info_pedidos']; ?></h3>
	</div>
    
	<div class="box-info-pedido fl">
    	<h3>PEDIDO <b><?php echo $ped['order_number']; ?></b></h3>
        <input type="hidden" name="id-pedido" id="id-pedido" value="<?php echo $numPedido; ?>" />
		<p><strong>DATA:</strong> <?php echo $date; ?></p>
        <div class="status-pedido fl pr">
        	<i></i>
            <h5>STATUS DO PEDIDO</h5>
           	<select id="status-pedido" name="status-pedido">
				<?php echo status($ped['order_status']); ?>
            </select>
        </div>
	</div>
    
    <div class="box-info-cliente fl pr">
    	<?php if($tipo === '1'){ ?>
    	<h4>INFORMAÇÕES DA EMPRESA</h4>
        <div class="tabs-dados-clientes fl">
            <span><?php echo $nome.' | CNPJ: '.$cnpj; ?></span>
            <p><strong>E-mail:</strong>  <?php echo $email; ?></p>
            <p><strong>Telefone:</strong>  <?php echo $telefone; ?></p>
            <p><strong>Celular:</strong>  <?php echo $celular; ?></p>
            <p><strong>Razão:</strong>  <?php echo $razao; ?></p>
            <i></i>
        </div>
        <div class="content-dados-clientes fl">
        	<p><strong>Inscrição:</strong>  <?php echo $ie; ?></p>
            <p><strong>Responsável:</strong>  <?php echo $contato; ?></p>
            <p><strong>Endereço:</strong>  <?php echo $endereço; ?></p>
            <p><strong>Cidade:</strong>  <?php echo $info_cidade; ?></p>
            <p><strong>CEP:</strong>  <?php echo $cep; ?></p>
            <p><strong>Site:</strong>  <?php echo $site; ?></p>
        </div>
        <?php } else { ?>
        <h4>INFORMAÇÕES DO CLIENTE</h4>
        <div class="tabs-dados-clientes fl">
            <span><?php echo $nome.' | CPF: '.$cpf; ?></span>
            <p><strong>E-mail:</strong>  <?php echo $email; ?></p>
            <p><strong>Telefone:</strong>  <?php echo $telefone; ?></p>
            <p><strong>Celular:</strong>  <?php echo $celular; ?></p>
            <p><strong>RG:</strong>  <?php echo $rg; ?></p>
            <i></i>
        </div>
        <div class="content-dados-clientes fl">
            <p><strong>Endereço:</strong>  <?php echo $endereço; ?></p>
            <p><strong>Cidade:</strong>  <?php echo $info_cidade; ?></p>
            <p><strong>CEP:</strong>  <?php echo $cep; ?></p>
        </div>
        <?php } ?>
	</div>
    
    <div class="box-info-produtos fl">
    	<h4>INFORMAÇÕES DO PEDIDO</h4>
        
		<div class="colunas colunas-dados-pedido fl">
        	<div class="produto-col1<?php echo $classePreco; ?> fl">Produto</div>
            <div class="produto-col2<?php echo $classePreco; ?> fl">Código</div>
            <div class="produto-col3<?php echo $classePreco; ?> fl">Quantidade</div>
            <?php if($preco != 1){ // Esconde a coluna se o preço estiver escondido ?>
            <div class="produto-col4<?php echo $classePreco; ?> fl">Valor</div>
            <?php } ?>
        </div>
        
    	<?php
        	echo $pedido;
		?>
        <?php if($preco != 1){ // Esconde a coluna se o preço estiver escondido ?>
        <div class="total-info-produtos fl">
        	Valor Total: <b>R$ <?php echo number_format($valorTotal, 2, ',', '.'); ?></b>
        </div>
        <?php } ?>
</div>
    
<div class="lista-tabs-emails fl">

    <div class="tabs-emails fl">
        <div class="botao-tabs-email pr fl">
        	<i></i>
            E-mail enviado para o Cliente
        </div>
        <div class="content-tabs-email fl">
			<?php echo $data['mail_customer']; ?>
        </div>
    </div>
        
    <div class="tabs-emails fl">
        <div class="botao-tabs-email pr fl">
        	<i></i>
            E-mail enviado para o Administrador
        </div>
        <div class="content-tabs-email fl">
			<?php echo $data['mail_self']; ?>
        </div>
    </div>
    
</div>
    
<div class="botoes-finalizar fl">
	<input type="button" class="button10" style="margin-top:5px;" value="<?php echo $BL['be_func_struct_close'] ?>" onclick="document.location.href='<?php echo shop_url('controller=order') ?>'" />
</div>