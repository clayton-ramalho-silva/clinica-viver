<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2012, Oliver Georgi
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

// ======== Configurações da Página ========

$rowsporpagina = 20; // Quantidade de resultados por página 
$row_count = 0; // Zera a contagem da lista
$_controller_link =  shop_url('controller=users'); // Seta os links da página

// Pega o valor da busca do nome da categoria
if(isset($_SESSION['busca-user']) && !empty($_SESSION['busca-user']) && isset($_SESSION['termo-user'])){
	$valorBusca = $_SESSION['busca-user'];
	$inputBusca = htmlspecialchars($_SESSION['termo-user']);
	$inputClasse = ' filtro-aberto';
	$busca  = 'AND detail_firstname LIKE _utf8 "%'.htmlspecialchars($valorBusca).'%" collate utf8_general_ci ';
	$busca .= 'OR detail_login LIKE _utf8 "%'.htmlspecialchars($valorBusca).'%" collate utf8_general_ci ';
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
		$_entry['query'] .= 'detail_aktiv = 0 ';
	}
	if(!$_entry['list_inactive']) {
		$_entry['query'] .= 'detail_aktiv = 1 ';
	}

} else {
	$_entry['query'] .= 'detail_aktiv != 9 ';
}



if(isset($_POST['busca-user'])){
	
	$_SESSION['busca-user'] = mysqli_real_escape_string($conexao, remover_acentos_status($_POST['busca-user']));
	$_SESSION['termo-user'] = mysqli_real_escape_string($conexao, $_POST['busca-user']);
	header('Location: '.$modAcao);

} else {

?>

<div class="tit fl pr<?php echo $inputClasse; ?>">
    	<i class="bt-filtro"></i>
		<h3><?php echo $BLM['tit_usuarios']; ?></h3>
		<div class="busca fr">
			<form action="<?php echo $_controller_link; ?>" method="post">
				<span>
					<i></i>
					<input type="text" name="busca-user" id="busca-user" placeholder="PESQUISAR USUÁRIO" value="<?php echo $inputBusca; ?>" />
				</span>
				<input type="submit" name="enviar-busca-pedido" id="enviar-busca-pedido" value="BUSCAR" />
			</form>
		</div>
        
        <div class="opcoes-acao fr">
        	<div class="add-acao fl">
               <a href="<?php echo shop_url(array('controller=users', 'edit=0')) ?>" title="<?php echo $BLM['cat_criar_nova'] ?>">
                    <span><?php echo $BLM['user_criar_novo']; ?></span>
                </a>
            </div>
            <div class="filtro-status fl">
                <form action="<?php echo $_controller_link; ?>" method="post" name="paginate" id="paginate"><input type="hidden" name="do_pagination" value="1" />
                	
                    <div class="filtro-ativo fl">
                        <input type="checkbox" name="showactive" id="showactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_active'], 1) ?> />
                        <label for="showactive">
                            <img src="img/famfamfam/icon-user-ativo.png" alt="" width="15px" height="15px" />
                        </label>
                    </div>
                    
                    <div class="filtro-inativo">
                        <input type="checkbox" name="showinactive" id="showinactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_inactive'], 1) ?> />
                        <label for="showinactive">
                            <img src="img/famfamfam/icon-user-inativo.png" alt="" width="15px" height="15px" />
                        </label>
                    </div>
                    
                </form>
            </div>
		</div>
        
	</div>

	<div class="tit-colunas colunas-usuarios fl">
		<div class="col1 fl"><?php echo $BLM['th_user_name'] ?></div>
		<div class="col2 fl"><?php echo $BLM['th_user_login'] ?></div>
		<div class="col3 fl"><?php echo $BLM['th_user_data'] ?></div>
		<div class="col5 fl">&nbsp;</div>
	</div>
    
	<?php	


	$sql  = 'SELECT * FROM phpwcms_userdetail WHERE '.$_entry['query'].$busca;

	// Início do paginate
	list($result_paginate, $totalpaginas, $paginaatual, $numerorows) = paginate($sql, $rowsporpagina, $pagina, ' ORDER BY detail_id DESC LIMIT', $conexao);

	// Checa se existe algum pedido
	if(mysqli_num_rows($result_paginate) > 0){
		
		// Cria a lista de pedidos
		while($row = mysqli_fetch_array($result_paginate)){  
		
			if($row['detail_aktiv'] == '1'){
				$imgAtivo = 'ativo';
				$titleAtivo = 'Desativar '.$msgCat;
			} else {
				$imgAtivo = 'inativo';
				$titleAtivo = 'Ativar '.$msgCat;
			}
			
			if($row['detail_int1'] === '1'){
				$nome = $row['detail_company'];
			} else {
				$nome = $row['detail_firstname'];	
			}
			
			?>
					
			<div class="lista-resultado colunas-usuarios fl pr">
				<input type="hidden" name="id-user" id="id-user" value="<?php echo $row['detail_id']; ?>" />
                <input type="hidden" name="status-user" id="status-user" value="<?php echo $row['detail_aktiv']; ?>" />
				
				<div class="col1 fl">
					<img class="ico-usuarios" src="img/famfamfam/icon-user-<?php echo $imgAtivo; ?>.png" alt="<?php echo $BLM['detail_firstname']; ?>" title="<?php echo $titleAtivo; ?>" alt="<?php echo $titleAtivo; ?>"<?php echo $espacamento; ?> />
                    <a href="<?php echo $_controller_link.'&amp;edit='.$row["detail_id"]; ?>" class="db" title="<?php echo $row['detail_firstname']; ?>">
						<?php echo html(limite($nome, 50)); ?>
					</a>
				</div>
				
                <div class="col2 fl">
					<span title="<?php echo html($row['detail_login']); ?>">
						<?php echo html(limite($row['detail_login'], 40)); ?>
                    </span>
				</div>
                
                <div class="col3 fl">
					<?php echo html(date('d/m/Y', strtotime($row['detail_tstamp']))); ?>
				</div>
                
				<button class="menu-lista fr"></button>
				<div class="opcoes-lista<?php echo fundo($rowsporpagina, $row_count); ?>">
					<ul>
						<li>
							<a href="<?php echo $_controller_link.'&amp;edit='.$row["detail_id"]; ?>" class="db">
								Editar Usuário
							</a>
						</li>
						<li>
							<a href="<?php echo $_controller_link.'&amp;delete='.$row["detail_id"]; ?>" onclick="return confirm('Deseja deletar este usuário? ATENÇÃO: ESTA AÇÃO É IRREVERSÍVEL');" class="hol-func db">
								Deletar Usuário
							</a>
						</li>
                        <li>
							<a href="<?php echo shop_url(array('controller=order', 'ped='.$row["detail_id"].'')); ?>" class="db">
								Visualizar Pedidos
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

unset($_SESSION['busca-cat']);
unset($_SESSION['termo-cat']);
unset($_SESSION['busca-produto']);
unset($_SESSION['termo-produto']);
unset($_SESSION['busca-pedido']);

?>