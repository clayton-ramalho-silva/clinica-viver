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

$rowsporpagina = 200; // Quantidade de resultados por página 
$row_count = 0; // Zera a contagem da lista
$_controller_link =  shop_url('controller=categories'); // Seta os links da página

// Pega o valor da busca do nome da categoria
if(isset($_SESSION['busca-cat']) && !empty($_SESSION['busca-cat']) && isset($_SESSION['termo-cat'])){
	$valorBusca = $_SESSION['busca-cat'];
	$inputBusca = htmlspecialchars($_SESSION['termo-cat']);
	$inputClasse = ' filtro-aberto';
	$busca  = 'AND C1.cat_name LIKE _utf8 "%'.htmlspecialchars($valorBusca).'%" collate utf8_general_ci ';
} else {
	$inputBusca = '';
	$inputClasse = '';
	$busca = '';
}

// =========================================

$_SESSION['list_active']	= empty($_POST['showactive']) ? 0 : 1;
$_SESSION['list_inactive']	= empty($_POST['showinactive']) ? 0 : 1;

$_entry['list_active']		= isset($_SESSION['list_active'])	? $_SESSION['list_active']		: 1;
$_entry['list_inactive']	= isset($_SESSION['list_inactive'])	? $_SESSION['list_inactive']	: 1;

// set correct status query
if($_entry['list_active'] != $_entry['list_inactive']) {

	if(!$_entry['list_active']) {
		$_entry['query'] .= 'AND C1.cat_status = 0';
	}
	if(!$_entry['list_inactive']) {
		$_entry['query'] .= 'AND C1.cat_status = 1';
	}

} else {
	$_entry['query'] .= 'AND C1.cat_status != 9';
}
$_entry['query'] .= " AND C1.cat_type='module_shop'";



if(isset($_POST['busca-cat'])){
	
	$_SESSION['busca-cat'] = mysqli_real_escape_string($conexao, remover_acentos_status($_POST['busca-cat']));
	$_SESSION['termo-cat'] = mysqli_real_escape_string($conexao, $_POST['busca-cat']);
	header('Location: '.$modAcao);

} else {

?>

<div class="tit fl pr<?php echo $inputClasse; ?>">
    	<i class="bt-filtro"></i>
		<h3><?php echo $BLM['tit_categorias']; ?></h3>
		<div class="busca fr">
			<form action="<?php echo $_controller_link; ?>" method="post">
				<span>
					<i></i>
					<input type="text" name="busca-cat" id="busca-cat" placeholder="PESQUISAR CATEGORIA" value="<?php echo $inputBusca; ?>" />
				</span>
				<input type="submit" name="enviar-busca-pedido" id="enviar-busca-pedido" value="BUSCAR" />
			</form>
		</div>
        
        <div class="opcoes-acao fr">
        	<div class="add-acao fl">
               <a href="<?php echo shop_url(array('controller=categories', 'edit=0')) ?>" title="<?php echo $BLM['cat_criar_nova'] ?>">
                    <span><?php echo $BLM['cat_criar_nova'] ?></span>
                </a>
            </div>
            <div class="filtro-status fl">
                <form action="<?php echo shop_url('controller=categories') ?>" method="post" name="paginate" id="paginate"><input type="hidden" name="do_pagination" value="1" />
                	
                    <div class="filtro-ativo fl">
                        <input type="checkbox" name="showactive" id="showactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_active'], 1) ?> />
                        <label for="showactive">
                            <img src="img/famfamfam/tag_blue.png" alt="" width="15px" height="15px" />
                        </label>
                    </div>
                    
                    <div class="filtro-inativo">
                        <input type="checkbox" name="showinactive" id="showinactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_inactive'], 1) ?> />
                        <label for="showinactive">
                            <img src="img/famfamfam/tag_inativo.png" alt="" width="15px" height="15px" />
                        </label>
                    </div>
                    
                </form>
            </div>
		</div>
        
	</div>

	<div class="tit-colunas colunas-categorias fl">
		<div class="col1 fl"><?php echo $BLM['th_cat_name'] ?></div>
		<div class="col2 fl"><?php echo $BLM['th_cat_alias'] ?></div>
		<div class="col3 fl"><?php echo $BLM['th_cat_ordem'] ?></div>
		<div class="col5 fl">&nbsp;</div>
	</div>
    
	<?php	


	$sql  = 'SELECT C1.cat_id, C1.cat_name, C1.cat_pid, C1.cat_status, C1.cat_alias, C1.cat_sort, ';
	$sql .= "IFNULL(CONCAT(C2.cat_name, ' > ', C1.cat_name), C1.cat_name) AS category ";
	$sql .= 'FROM '.DB_PREPEND.'phpwcms_categories C1 ';
	$sql .= 'LEFT JOIN '.DB_PREPEND.'phpwcms_categories C2 ';
	$sql .= 'ON C1.cat_pid=C2.cat_id ';
	$sql .= "WHERE C1.cat_type='module_shop' ".$_entry['query'].$busca;

	// Início do paginate
	list($result_paginate, $totalpaginas, $paginaatual, $numerorows) = paginate($sql, $rowsporpagina, $pagina, ' ORDER BY category LIMIT', $conexao);

	// Checa se existe algum pedido
	if(mysqli_num_rows($result_paginate) > 0){
		
		// Cria a lista de pedidos
		while($row = mysqli_fetch_array($result_paginate)){  
		
			$msgCat = $row['cat_pid'] ? 'Subcategoria' : 'Categoria';
			$tipoCat = $row['cat_pid'] ? '1' : '0';
			$espacamento = $row['cat_pid'] ? ' style="margin:0 0 0 24px"' : '';

			if($row['cat_status'] == '1'){
				$imgAtivo = $row['cat_pid'] ? 'orange' : 'blue';
				$titleAtivo = 'Desativar '.$msgCat;
			} else {
				$imgAtivo = 'inativo';
				$titleAtivo = 'Ativar '.$msgCat;
			}
			
			?>
					
			<div class="lista-resultado colunas-categorias fl pr">
				<input type="hidden" name="id-categoria" id="id-categoria" value="<?php echo $row['cat_id']; ?>" />
                <input type="hidden" name="status-categoria" id="status-categoria" value="<?php echo $row['cat_status']; ?>" />
                <input type="hidden" name="tipo-categoria" id="tipo-categoria" value="<?php echo $tipoCat; ?>" />
				
				<div class="col1 fl">
					<img class="ico-categorias" src="img/famfamfam/tag_<?php echo $imgAtivo; ?>.png" title="<?php echo $titleAtivo; ?>" alt="<?php echo $titleAtivo; ?>"<?php echo $espacamento; ?> />
                    <a href="<?php echo $_controller_link.'&amp;edit='.$row["cat_id"]; ?>" class="db" title="<?php echo $row['category']; ?>">
						<?php echo html(limite($row['cat_name'], 50)); ?>
					</a>
				</div>
				
                <div class="col2 fl">
					<span title="<?php echo html($row['cat_alias']); ?>">
						<?php echo html(limite($row['cat_alias'], 40)); ?>
                    </span>
				</div>
                
                <div class="col3 fl">
					<?php echo html($row['cat_sort']); ?>
				</div>
                
				<button class="menu-lista fr"></button>
				<div class="opcoes-lista<?php echo fundo($rowsporpagina, $row_count); ?>">
					<ul>
						<li>
							<a href="<?php echo $_controller_link.'&amp;edit='.$row["cat_id"]; ?>" class="db">
								Editar Categoria
							</a>
						</li>
						<li>
							<a href="<?php echo $_controller_link.'&amp;delete='.$row["cat_id"]; ?>" onclick="return confirm('Deseja deletar esta categoria? ATENÇÃO: ESTA AÇÃO É IRREVERSÍVEL');" class="hol-func db">
								Deletar Categoria
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
        
		<div class="mensagem-vazio fl">Nenhuma categoria foi encontrada.</div>
		
		<?php
    }
	
	links_paginate($totalpaginas, $paginaatual, $range, $modAcao);
	
	?>
	</div>
<?php
}

unset($_SESSION['busca-produto']);
unset($_SESSION['termo-produto']);
unset($_SESSION['busca-user']);
unset($_SESSION['termo-user']);
unset($_SESSION['busca-pedido']);

?>