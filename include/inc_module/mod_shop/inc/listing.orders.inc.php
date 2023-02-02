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
//error_reporting(E_ALL);
// ======== Configurações da Página ========

// Altera as classes das colunas caso a opção de "sem preço" esteja ativada
if($preco != 1){$classePreco = '-cp';} else {$classePreco = '-sp';}

$rowsporpagina = 20; // Quantidade de resultados por página 
$row_count = 0; // Zera a contagem da lista
$id = $_GET['ped'];
$BLM['shopprod_payby_INVOICE'] = $BLM['shopprod_payby_onbill'];
$_controller_link =  shop_url('controller=orders'); // Seta os links da página

// Pega o valor da busca do código ou nome do cliente
if(isset($_SESSION['busca-pedido']) && !empty($_SESSION['busca-pedido'])){
	$valorBusca = $_SESSION['busca-pedido'];
	$inputBusca = htmlspecialchars($valorBusca);
	$inputClasse = ' filtro-aberto';
	$busca  = ' AND order_number LIKE _utf8 "%'.htmlspecialchars($valorBusca).'%" collate utf8_general_ci ';
	$busca .= 'OR order_firstname LIKE _utf8 "%'.htmlspecialchars($valorBusca).'%" collate utf8_general_ci';
} else {
	$inputBusca = '';
	$inputClasse = '';
	$busca = '';
}

// =========================================

if(isset($_POST['buscar-pedido'])){
	
	$_SESSION['busca-pedido'] = mysqli_real_escape_string($conexao, $_POST['buscar-pedido']);
	header('Location: '.$modAcao);

} else {
	
	?>
	
	<div class="tit fl<?php echo $inputClasse; ?>">
		<h3><?php echo $BLM['tit_pedidos']; ?></h3>
		<div class="busca-pedidos fr">
			<form action="<?php echo $_controller_link; ?>" method="post">
				<span>
					<i></i>
					<input type="text" name="buscar-pedido" id="buscar-pedido" placeholder="CÓDIGO DO PEDIDO" value="<?php echo $inputBusca; ?>" />
				</span>
				<input type="submit" name="enviar-busca-pedido" id="enviar-busca-pedido" value="BUSCAR" />
			</form>
		</div>
	</div>
	
	
	<div class="tit-colunas colunas-pedidos fl">
		<div class="col1<?php echo $classePreco; ?> fl"><?php echo $BLM['th_order'] ?></div>
		<div class="col2<?php echo $classePreco; ?> fl"><?php echo $BLM['th_date'] ?></div>
		<div class="col3<?php echo $classePreco; ?> fl"><?php echo $BLM['th_customer'] ?></div>
		<?php if($preco != 1){ // Esconde a coluna se o preço estiver escondido ?>
			<div class="col4<?php echo $classePreco; ?> fl"><?php echo $BLM['th_net'] ?></div>
		<?php } ?>
		<div class="col5<?php echo $classePreco; ?> fl">Status</div>
		<div class="col6<?php echo $classePreco; ?> fl">&nbsp;</div>
	</div>
	
	<div class="lista-pedidos fl">
	<?php
	
	// ==== Chama as informações dos pedidos ====
	$sql  = "SELECT *, DATE_FORMAT(order_date,'%e/%m/%y') AS order_fdate ";
	$sql .= "FROM ".DB_PREPEND."phpwcms_shop_orders WHERE ";
	if(isset($id)){
		$sql .= 'order_user_id = "'.$id.'" AND ';
	}
	$sql .= "order_status != 'CLOSED'".$busca;
	
	// Início do paginate
	list($result_paginate, $totalpaginas, $paginaatual, $numerorows) = paginate($sql, $rowsporpagina, $pagina, 'ORDER BY order_id DESC LIMIT', $conexao);
	
	// Checa se existe algum pedido
	if(mysqli_num_rows($result_paginate) > 0){
		
		// Cria a lista de pedidos
		while($row = mysqli_fetch_array($result_paginate)){       
			?>
					
			<div class="lista-resultado colunas-pedidos fl pr">
				<input type="hidden" name="id-pedido" id="id-pedido" value="<?php echo $row['order_id']; ?>" />
				
				<div class="col1<?php echo $classePreco; ?> fl">
					<a href="<?php echo $_controller_link.'&amp;show='.$row["order_id"]; ?>" class="db">
						<img src="img/famfamfam/cart_go.gif" alt="'.$BLM['shop_order'].'" border="0" />
						<?php echo html($row['order_number']); ?>
					</a>
				</div>
				
				<div class="col2<?php echo $classePreco; ?> fl">
					<?php echo html($row['order_fdate']); ?>
				</div>
				
				<div class="nome col3<?php echo $classePreco; ?> fl">
					<a href="phpwcms.php?do=modules&module=shop&controller=users&amp;edit=<? echo $row["order_user_id"]; ?>">
						<?php echo html($row['order_firstname']); ?>
					</a>
				</div>
				
				<?php if($preco != 1){ // Esconde a coluna se o preço estiver escondido ?>
					<div class="col4<?php echo $classePreco; ?> fl">
						<b>R$ <?php echo html(number_format(round($row['order_gross'], 2) , 2, ',', '.')); ?></b>
					</div>
				<?php } ?>
				 
				<div class="nome col5<?php echo $classePreco; ?> fl">
					<select id="status-pedido" name="status-pedido">
						<?php echo status($row['order_status']); ?>
					</select>
				</div>
				
				<button class="menu-lista fr"></button>
				<div class="opcoes-lista<?php echo fundo($rowsporpagina, $row_count); ?>">
					<ul>
						<li>
							<a href="<?php echo $_controller_link.'&amp;show='.$row["order_id"]; ?>" class="db">
								Detalhes do Pedido
							</a>
						</li>
						<li>
							<a href="<?php echo $_controller_link.'&amp;delete='.$row["order_id"]; ?>" onclick="return confirm('Deseja deletar este pedido? ATENÇÃO: ESTA AÇÃO É IRREVERSÍVEL');" class="hol-func db">
								Deletar Pedido
							</a>
						</li>
					</ul>
				</div>
			</div>
				
			<?php 
			$row_count++;
		} 
	} else {
		?>
        
		<div class="mensagem-vazio fl">Nenhum pedido foi encontrado.</div>
		
		<?php
    }
	
	links_paginate($totalpaginas, $paginaatual, $range, $modAcao);
	
	?>
	</div>
<?php
}

unset($_SESSION['busca-cat']);
unset($_SESSION['termo-cat']);
unset($_SESSION['busca-produto']);
unset($_SESSION['termo-produto']);
unset($_SESSION['busca-user']);
unset($_SESSION['termo-user']);

?>