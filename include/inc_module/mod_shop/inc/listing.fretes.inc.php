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

// Conexão com o banco de dados de CEPS
$sqlCeps = mysqli_connect($user['admin_config_frete_host'],$user['admin_config_frete_user'],$user['admin_config_frete_pass'],$user['admin_config_frete_table']);

//error_reporting(E_ALL);

// ======== Configurações da Página ========
$_controller_link = htmlspecialchars_decode(shop_url('controller=city')); // Seta os links da página

// Pega o valor da busca do código ou nome do cliente
if(isset($_SESSION['busca-cidade']) && !empty($_SESSION['busca-cidade']) && isset($_GET['b'])){
	
	$valorBusca = $_SESSION['busca-cidade'];
	$inputBusca = htmlspecialchars($valorBusca);
	$inputClasse = ' filtro-aberto';
	$busca  = ' AND city_cidade LIKE _utf8 "%'.htmlspecialchars($valorBusca).'%" collate utf8_general_ci ';
	$busca .= 'OR city_estado LIKE _utf8 "%'.htmlspecialchars($valorBusca).'%" collate utf8_general_ci';
	
} else {
	
	$inputBusca = '';
	$inputClasse = '';
	$busca = '';
	
}

// =========================================

$_SESSION['list_active']	= empty($_POST['showactive']) 	? 0 : 1;
$_SESSION['list_inactive']	= empty($_POST['showinactive']) ? 0 : 1;

$_entry['list_active']		= isset($_SESSION['list_active'])	? $_SESSION['list_active']		: 1;
$_entry['list_inactive']	= isset($_SESSION['list_inactive'])	? $_SESSION['list_inactive']	: 1;

// set correct status query
if($_entry['list_active'] != $_entry['list_inactive']) {

	if(!$_entry['list_active']){
		$_entry['query'] .= ' WHERE frete_status = 0';
	}
	
	if(!$_entry['list_inactive']){
		$_entry['query'] .= ' WHERE frete_status = 1';
	}

} else {
	
	$_entry['query'] .= ' WHERE frete_status != 9';
	
}


if(isset($_POST['busca-cidade'])){
	
	// ===== PESQUISA DE CIDADE =====
	$_SESSION['busca-cidade'] = mysqli_real_escape_string($conexao, $_POST['busca-cidade']);
	header('Location: '.$_controller_link.'&b=1');

} elseif(isset($_POST['cadastro-estado']) && isset($_POST['cadastro-cidade'])) {
	
	// ===== CADASTRO DE NOVA CIDADE =====
	$cadastroEstado = mysqli_real_escape_string($conexao, $_POST['cadastro-estado']);
	$cadastroCidade = mysqli_real_escape_string($conexao, $_POST['cadastro-cidade']);
	
	// Checa se a cidade já não está cadastrada
	$sql  = 'SELECT * FROM phpwcms_shop_fretes LEFT JOIN phpwcms_cidades ON cidade_id = frete_cidade WHERE ';
	$sql .= 'city_id_cidade = '.$cadastroCidade.' AND city_estado = "'.$cadastroEstado.'" AND city_status != 9';
	$res = mysqli_query($conexao, $sql);
	
	if(mysqli_num_rows($res) > 0){
		
		$_SESSION['erro-cidades'] = 'Está cidade já está cadastrada';
		header('Location: phpwcms.php?do=modules&module=shop&controller=city');
		
	} else {
		
		$cidade = nomeCidade($conexao, $cadastroCidade);
		
		$sqlInsert  = 'INSERT INTO phpwcms_lista_cidades SET city_cidade = "'.$cidade.'", ';
		$sqlInsert .= 'city_id_cidade = '.$cadastroCidade.', city_estado = "'.$cadastroEstado.'", ';
		$sqlInsert .= 'city_prioridade = 0, city_status = 1';
		$resInsert  = mysqli_query($conexao, $sqlInsert);

		$url = htmlspecialchars_decode(shop_url(array('controller=city', 'edit='.novoIdCidade($conexao))));
		header('Location: '.$url);
		
	}

} else {
	
	$BE['HEADER']['select2.css'] = ' <link href="include/inc_module/mod_shop/template/select2.min.css" rel="stylesheet" type="text/css" />';
	$BE['HEADER']['select2.js'] = ' <script type="text/javascript" src="include/inc_module/mod_shop/template/scripts/select2.min.js"></script>';
	$BE['HEADER']['jquery.mask.new.js'] = ' <script type="text/javascript" src="include/inc_module/mod_shop/template/scripts/jquery.mask.new.js"></script>';
	
	?>
	
	<div class="tit fl pr<?php echo $inputClasse; ?>">
	
		<i class="bt-filtro"></i>
		
		<h3><?php echo $BLM['tit_fretes']; ?></h3>
				
		<div class="opcoes-acao acao-fretes fr">
		
			<div class="add-acao fl">
			
				<form id="form-cadastro-frete" method="post" action="<?php echo shop_url(array('controller=fretes')) ?>">
                	<input type="hidden" name="id-edit" id="id-edit" value="0" />
					<p class="col3">
						<strong>Estado</strong>
						<select name="frete-estado" id="frete-estado">
							<?php echo cadastroEstados($sqlCeps, 'SP'); ?>
						</select>
					</p>
					<p class="col2">
						<strong>Cidade</strong>
						<select name="frete-cidade" id="frete-cidade">
							<?php echo cadastroCidades($sqlCeps, 'SP', '9668'); ?>
						</select>
					</p>
					<p class="col3">
						<strong>Valor</strong>
						<input type="text" name="frete-valor" id="frete-valor" value="" />
					</p>
                    <p class="col3">
						<input type="submit" name="enviar-cadastro-frete" id="enviar-cadastro-frete" value="<?php echo $BLM['frete_criar_novo'] ?>" />
                    </p>
				</form>
				
			</div>
			
            <div class="filtro-status fl">
			
                <form action="<?php echo shop_url('controller=frete') ?>" method="post" name="paginate" id="paginate"><input type="hidden" name="do_pagination" value="1" />
                        
                    <div class="filtro-ativo fl">
                        <input type="checkbox" name="showactive" id="showactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_active'], 1) ?> />
                        <label for="showactive">
                            <img src="img/famfamfam/frete-ativo.png" alt="" width="15px" height="15px" />
                        </label>
                    </div>
                        
                    <div class="filtro-inativo">
                        <input type="checkbox" name="showinactive" id="showinactive" value="1" onclick="this.form.submit();"<?php is_checked(1, $_entry['list_inactive'], 1) ?> />
                        <label for="showinactive">
                            <img src="img/famfamfam/frete-inativo.png" alt="" width="15px" height="15px" />
                        </label>
                    </div>
                    
                </form>
                
            </div>
            
		</div>
	
	<?php
	if(isset($_SESSION['erro-cidades']) && !empty($_SESSION['erro-cidades'])){
		echo '<div class="erro-cidade fl">'.$_SESSION['erro-cidades'].'</div>';
		unset($_SESSION['erro-cidades']);
	}
	?>
	
	<div class="tit-colunas colunas-fretes fl">
		<div class="col1 fl">&nbsp;</div>
		<div class="col2 fl"><?php echo $BLM['th_frete_estado'] ?></div>
		<div class="col3 fl"><?php echo $BLM['th_frete_cidade'] ?></div>
		<div class="col4 fl"><?php echo $BLM['th_frete_valor'] ?></div>
		<div class="col5 fl">&nbsp;</div>
	</div>
	
	<div class="lista-pedidos fl">
	<?php
	
	// ==== Chama as informações dos pedidos ====
	$sql  = "SELECT frete_id, frete_cidade, frete_estado, FRETE_status FROM ".DB_PREPEND."phpwcms_fretes".$_entry['query'].$busca;
	
	// Início do paginate
	list($result_paginate, $totalpaginas, $paginaatual, $numerorows) = paginate($sql, $rowsporpagina, $pagina, 'ORDER BY frete_id DESC LIMIT', $conexao);
	
	// Checa se existe algum pedido
	if(mysqli_num_rows($result_paginate) > 0){
		
		// Cria a lista de pedidos
		while($row = mysqli_fetch_array($result_paginate)){	   
			
			if($row['frete_status'] == '1'){
				$imgAtivo = '';
				$titleAtivo = 'Desativar Frete';
			} else {
				$imgAtivo = '-inativo';
				$titleAtivo = 'Ativar Frete';
			}
			
			?>
					
			<div class="lista-resultado colunas-fretes fl pr">
				<input type="hidden" name="id-frete" id="id-frete" value="<?php echo $row['frete_id']; ?>" />
				<input type="hidden" name="status-frete" id="status-frete" value="<?php echo $row['frete_status']; ?>" />
				
				<div class="col1<?php echo $classePreco; ?> fl">
					<img class="ico-cidade" src="img/famfamfam/ico-regiao<?php echo $imgAtivo; ?>.png" title="<?php echo $titleAtivo; ?>" alt="<?php echo $titleAtivo; ?>" />
					<?php echo htmlspecialchars($row['frete_id']); ?>
				</div>

				<div class="nome col2 fl">
					<?php echo htmlspecialchars($row['frete_estado']); ?>
				</div>
				
				<div class="nome col3 fl">
					<a href="<?php echo $_controller_link.'&amp;edit='.$row["frete_id"]; ?>">
						<?php echo htmlspecialchars($row['frete_cidade']); ?>
					</a>
				</div>
				
				<div class="nome col4 fl">
					<a href="<?php echo $_controller_link.'&amp;edit='.$row["frete_id"]; ?>">
						<?php echo htmlspecialchars($row['frete_cidade']); ?>
					</a>
				</div>
				
				<button class="menu-lista fr"></button>
				<div class="opcoes-lista<?php echo fundo($rowsporpagina, $row_count); ?>">
					<ul>
						<li>
							<a href="javascript:void(0)" class="edit-frete db">
								Editar Frete
							</a>
						</li>
						<li>
							<a href="javascript:void(0)" class="hol-func del-frete db">
								Deletar Frete
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
		
		<div class="mensagem-vazio fl">Nenhum frete foi encontrado.</div>
		
		<?php
	}

	echo links_paginate($totalpaginas, $paginaatual, $range, $_controller_link);
	
	?>
	</div>
    
    <script>
	$(document).ready(function(e) {
        
		$('#bairro-cidade').select2();
		$("#frete-valor").mask('#.##0,00', {reverse: true});
		
    });
	</script>
    
<?php
}

unset($_SESSION['busca-cat']);
unset($_SESSION['termo-cat']);
unset($_SESSION['busca-produto']);
unset($_SESSION['termo-produto']);
unset($_SESSION['busca-user']);
unset($_SESSION['termo-user']);

?>