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

error_reporting(E_ALL);
ini_set('display_errors', '1');

// ======== Configurações da Página ========

// Altera as classes das colunas caso a opção de "sem preço" esteja ativada
if($preco != 1){$classePreco = '-cp';} else {$classePreco = '-sp';}

$rowsporpagina = 20; // Quantidade de resultados por página 
$row_count = 0; // Zera a contagem da lista
$_controller_link =  shop_url('controller=products'); // Seta os links da página

// Pega o valor da busca do código ou nome do produto
if(isset($_SESSION['busca-produto']) && !empty($_SESSION['busca-produto']) && isset($_SESSION['termo-produto'])){
	$valorBusca = $_SESSION['busca-produto'];
	$inputBusca = htmlspecialchars($_SESSION['termo-produto']);
	$inputClasse = ' filtro-aberto';
	$busca  = '  AND (shopprod_name1 LIKE _utf8 "%'.htmlspecialchars($valorBusca).'%" collate utf8_general_ci ';
	$busca .= 'OR shopprod_ordernumber LIKE _utf8 "%'.htmlspecialchars($valorBusca).'%" collate utf8_general_ci)';
} else {
	$inputBusca = '';
	$inputClasse = '';
	$busca = '';
}

// Lista total de Produtos
$total_prod = _dbCount('SELECT COUNT(shopprod_id) FROM phpwcms_shop_products WHERE shopprod_status != 9');

// =========================================

$_SESSION['list_active']	= empty($_POST['showactive']) ? 0 : 1;
$_SESSION['list_inactive']	= empty($_POST['showinactive']) ? 0 : 1;

$_entry['list_active']		= isset($_SESSION['list_active'])	? $_SESSION['list_active']		: 1;
$_entry['list_inactive']	= isset($_SESSION['list_inactive'])	? $_SESSION['list_inactive']	: 1;

// set correct status query
if($_entry['list_active'] != $_entry['list_inactive']) {

	if(!$_entry['list_active']) {
		$_entry['query'] .= 'shopprod_status=0';
	}
	if(!$_entry['list_inactive']) {
		$_entry['query'] .= 'shopprod_status=1';
	}

} else {
	
	$_entry['query'] .= 'shopprod_status!=9';
}


if(isset($_POST['busca-produto'])){
	
	$_SESSION['busca-produto'] = mysqli_real_escape_string($conexao, remover_acentos_status($_POST['busca-produto']));
	$_SESSION['termo-produto'] = mysqli_real_escape_string($conexao, $_POST['busca-produto']);
	header('Location: '.$modAcao);

} else {

?>

	<div class="tit fl pr filtro-aberto">
    	<i class="bt-filtro"></i>
		<h3><?php echo $BLM['tit_produtos']; ?></h3>
		
        <div class="opcoes-acao acao-produtos fr">
        	<div class="add-acao fl">
                <a href="<?php echo shop_url(array('controller=products', 'edit=0')) ?>" title="<?php echo $BLM['create_new_prod'] ?>">
                    <span><?php echo $BLM['create_new_prod'] ?></span>
                </a>
            </div>
            <div class="filtro-status fl">
                <form action="<?php echo shop_url('controller=products') ?>" method="post" name="paginate" id="paginate"><input type="hidden" name="do_pagination" value="1" />
                	
                    <div class="filtro-ativo fl">
                        <input type="checkbox" name="showactive" id="showactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_active'], 1) ?> />
                        <label for="showactive">
                            <img src="img/famfamfam/package.png" alt="" width="15px" height="15px" />
                        </label>
                    </div>
                    
                    <div class="filtro-inativo">
                        <input type="checkbox" name="showinactive" id="showinactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_inactive'], 1) ?> />
                        <label for="showinactive">
                            <img src="img/famfamfam/package-inativo.png" alt="" width="15px" height="15px" />
                        </label>
                    </div>
                    
                </form>
            </div>
            <div class="total-produtos fl">
        		Total de Produtos: <? echo $total_prod ?>
            </div>
		</div>
        
        <div class="busca-produtos fr">
			<form action="<?php echo $_controller_link; ?>" method="post">
				<span class="pr">
					<i></i>
					<input type="text" name="busca-produto" id="busca-produto" placeholder="Nome do produto" value="<?php echo $inputBusca; ?>" />
                    <select name="buscar-categoria" id="buscar-categoria">
						<option value="">Selecione a categoria</option>
					<?php
                    $sql  = 'SELECT * FROM '.DB_PREPEND."phpwcms_categories WHERE ";
                    $sql .= "cat_type='module_shop' AND cat_status != 9 ORDER BY cat_name ASC";
                    $plugin['data']['subcat'] = _dbQuery($sql);
                    foreach($plugin['data']['subcat'] as $value) {
                                    
                    	echo '<option value="' . $value['cat_id'] . '"';
                    	is_selected($plugin['data']['cat_pid'], $value['cat_id']);
                    	if($value['cat_status'] = 0) {
                        	echo ' style="font-style:italic;"';
                    	}
                    	echo '>' . html($value['cat_name']) . '</option>' . LF;
                                   
                    }
                    ?>
                    </select>
				</span>
				<input type="submit" name="enviar-busca-pedido" id="enviar-busca-pedido" value="BUSCAR" />
			</form>
		</div>
        
	</div>
	      
        
	<div class="tit-colunas colunas-produtos fl">
		<div class="col1<?php echo $classePreco; ?> fl"><?php echo $BLM['th_cod'] ?></div>
		<div class="col2<?php echo $classePreco; ?> fl"><?php echo $BLM['th_product'] ?></div>
		<div class="col3<?php echo $classePreco; ?> fl"><?php echo $BLM['th_cat'] ?></div>
		<?php if($preco != 1){ // Esconde a coluna se o preço estiver escondido ?>
			<div class="col4<?php echo $classePreco; ?> fl"><?php echo $BLM['th_price'] ?></div>
		<?php } ?>
        <div class="col5<?php echo $classePreco; ?> fl"><?php echo $BLM['th_ordem'] ?></div>
	</div>

	
	<?php	

	$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_shop_products WHERE '.$_entry['query'].$busca.' ';

	// Início do paginate
	list($result_paginate, $totalpaginas, $paginaatual, $numerorows) = paginate($sql, $rowsporpagina, $pagina, ' ORDER BY shopprod_ordenacao ASC, shopprod_id DESC LIMIT', $conexao);

	// Checa se existe algum pedido
	if(mysqli_num_rows($result_paginate) > 0){
		
		// Cria a lista de pedidos
		while($row = mysqli_fetch_array($result_paginate)){  
			$categorias = explode(',', $row['shopprod_category']); // Busca as categorias de cada produto
			if($row['shopprod_name2'] == '2'){$classeMulti = ' multi-preco';} else {$classeMulti = '';} // Preços
			
			if($row['shopprod_status'] == '1'){
				$imgAtivo = '';
				$titleAtivo = 'Desativar Produto';
			} else {
				$imgAtivo = '-inativo';
				$titleAtivo = 'Ativar Produto';
			}
			
			?>
					
			<div class="lista-resultado colunas-produtos fl pr">
				<input type="hidden" name="id-produto" id="id-produto" value="<?php echo $row['shopprod_id']; ?>" />
                <input type="hidden" name="status-produto" id="status-produto" value="<?php echo $row['shopprod_status']; ?>" />
				
				<div class="col1<?php echo $classePreco; ?> fl">
						<img class="ico-produto" src="img/famfamfam/package<?php echo $imgAtivo; ?>.png" alt="<?php echo $BLM['shop_product']; ?>" title="<?php echo $titleAtivo; ?>" alt="<?php echo $titleAtivo; ?>" />
                    <a href="<?php echo $_controller_link.'&amp;edit='.$row["shopprod_id"]; ?>" class="db">
						<?php echo html(limite($row['shopprod_ordernumber'], 14)); ?>
					</a>
				</div>

				<div class="nome col2<?php echo $classePreco; ?> fl">
                	<a href="<?php echo $_controller_link.'&amp;edit='.$row["shopprod_id"]; ?>" class="db">
						<?php echo html(limite($row['shopprod_name1'], 39)); ?>
                    </a>
				</div>

				<div class="col3<?php echo $classePreco; ?> fl">
					<?php 
					foreach($categorias as $val){
						$sql1  = 'SELECT cat_name, cat_id FROM phpwcms_categories WHERE "'.$val.'" = cat_id';
						$lista_cat = mysqli_query($conexao, $sql1);
						$cat = mysqli_fetch_array($lista_cat);
						echo '<a href="'.shop_url(array('controller=categories','edit='.$cat['cat_id'])).'" class="db">'.$cat['cat_name'].'</a>';
					}
					?>
				</div>
				
				<?php 
				
				// ========================================================================================
				// OBSERVAÇÃO WEBCIS - Futuramente, fazer com que pegue automaticamente a lista de tamanhos
				// OBSERVAÇÃO WEBCIS - Mudar o nome do campo para checagem (de 'shopprod_name2' para outro) 
				// ========================================================================================
				
				if($preco != 1){ // Esconde a coluna se o preço estiver escondido 
					?>
					<div class="col4<?php echo $classePreco.$classeMulti; ?> fl">
					<?php
                    if($row['shopprod_name2'] == '2'){
						if(!empty($row['shopprod_color'])){
						?>
							<strong>P:</strong> 
                            R$ <?php echo html(number_format(round($row['shopprod_color'], 2), 2, ',', '.')); ?>
                            <br />
                        <?php
						}
						if(!empty($row['shopprod_size'])){
						?>
							<strong>G:</strong>
                            R$ <?php echo html(number_format(round($row['shopprod_size'], 2), 2, ',', '.')); ?>				
                        <?php
                        }
					} else{
						?>
						R$ <?php echo html(number_format(round($row['shopprod_price'], 2), 2, ',', '.')); ?>
                        <?php
					}
					?>
                    </div>
                    <?php
				}
				?>
				
                <div class="col5<?php echo $classePreco; ?> fl">
					<?php echo $row['shopprod_ordenacao'] ?>
				</div>
                
				<button class="menu-lista fr"></button>
				<div class="opcoes-lista<?php echo fundo($rowsporpagina, $row_count); ?>">
					<ul>
						<li>
							<a href="<?php echo $_controller_link.'&amp;edit='.$row["shopprod_id"]; ?>" class="db">
								Editar Produto
							</a>
						</li>
						<li>
							<a href="<?php echo $_controller_link.'&amp;delete='.$row["shopprod_id"]; ?>" onclick="return confirm('Deseja deletar este produto? ATENÇÃO: ESTA AÇÃO É IRREVERSÍVEL');" class="hol-func db">
								Deletar Produto
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
        
		<div class="mensagem-vazio fl">Nenhum produto foi encontrado.</div>
		
		<?php
    }
	
	links_paginate($totalpaginas, $paginaatual, $range, $modAcao);
	
	?>
	</div>
<?php
}

unset($_SESSION['busca-cat']);
unset($_SESSION['termo-cat']);
unset($_SESSION['busca-user']);
unset($_SESSION['termo-user']);
unset($_SESSION['busca-pedido']);

?>