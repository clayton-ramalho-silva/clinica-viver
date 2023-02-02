<?php

require_once ('../../../config/phpwcms/conf.inc.php');
$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']); 

// PEDIDOS - Atualiza o status do pedido diretamente do select
if (isset($_POST['status'])) {
	$pedidoID = mysqli_real_escape_string($conexao, $_POST['id']);
	$pedidoStatus = mysqli_real_escape_string($conexao, $_POST['status']);
	
	$query  = 'UPDATE phpwcms_shop_orders SET ';
	$query .= 'order_status = "'.$pedidoStatus.'" ';
	$query .= 'WHERE order_id = "'.$pedidoID.'"';
	$resource = mysqli_query($conexao, $query) or die (mysql_error());
}

// PRODUTOS - Ativa ou Desativa os produtos
if (isset($_POST['idAtivo']) && isset($_POST['statusAtivo'])) {
	$produtoID = (int)mysqli_real_escape_string($conexao, $_POST['idAtivo']);
	$produtoStatus = (int)mysqli_real_escape_string($conexao, $_POST['statusAtivo']);
	
	if(is_int($produtoID) && is_int($produtoStatus)){
		
		if($produtoStatus == 1){
			$status = '0';
			$img = 'img/famfamfam/package-inativo.png';
		} else {
			$status = '1';
			$img = 'img/famfamfam/package.png';
		}
		
		$query  = 'UPDATE phpwcms_shop_products SET ';
		$query .= 'shopprod_status = '.$status.' ';
		$query .= 'WHERE shopprod_id = "'.$produtoID.'"';
		$resource = mysqli_query($conexao, $query) or die (mysql_error());
		
		$info = array(
					'img' 		=> $img,
					'status'	=> $status
				);
		
		echo json_encode($info);
		
	}
}

// CATEGORIAS - Ativa ou Desativa as categorias
if (isset($_POST['idCatAtivo']) && isset($_POST['statusCatAtivo']) && isset($_POST['tipoCatAtivo'])) {
	$categoriaID = (int)mysqli_real_escape_string($conexao, $_POST['idCatAtivo']);
	$categoriaStatus = (int)mysqli_real_escape_string($conexao, $_POST['statusCatAtivo']);
	$categoriaTipo = (int)mysqli_real_escape_string($conexao, $_POST['tipoCatAtivo']);
	
	if(is_int($categoriaID) && is_int($categoriaStatus)){
		
		if($categoriaStatus == 1){
			$status = '0';
			$img = 'img/famfamfam/tag_inativo.png';
		} else {
			$status = '1';
			if($categoriaTipo === 1){
				$img = 'img/famfamfam/tag_orange.png';
			} else {
				$img = 'img/famfamfam/tag_blue.png';
			}
		}
		
		$query  = 'UPDATE phpwcms_categories SET ';
		$query .= 'cat_status = "'.$status.'" ';
		$query .= 'WHERE cat_id = "'.$categoriaID.'"';
		$resource = mysqli_query($conexao, $query) or die (mysql_error());
		
		$info = array(
					'img' 		=> $img,
					'status'	=> $status
				);
		
		echo json_encode($info);
		
	}
}

// USUÁRIOS - Ativa ou Desativa aos usuários
if (isset($_POST['idUserAtivo']) && isset($_POST['statusUserAtivo'])) {
	$usuarioID = (int)mysqli_real_escape_string($conexao, $_POST['idUserAtivo']);
	$usuarioStatus = (int)mysqli_real_escape_string($conexao, $_POST['statusUserAtivo']);
	
	if(is_int($usuarioID) && is_int($usuarioStatus)){
		
		if($usuarioStatus == 1){
			$status = '0';
			$img = 'img/famfamfam/icon-user-inativo.png';
		} else {
			$status = '1';
			$img = 'img/famfamfam/icon-user-ativo.png';
		}
		
		$query  = 'UPDATE phpwcms_userdetail SET ';
		$query .= 'detail_aktiv = "'.$status.'" ';
		$query .= 'WHERE detail_id = "'.$usuarioID.'"';
		$resource = mysqli_query($conexao, $query) or die (mysql_error());
		
		$info = array(
					'img' 		=> $img,
					'status'	=> $status
				);
		
		echo json_encode($info);
		
	}
}





if (isset($_POST['nomeUser'])) {
	$nomeUser = mysqli_real_escape_string($conexao, utf8_decode($_POST['nomeUser']));
	
	if(!empty($nomeUser) || $nomeUser != ''){		
		$query  = 'SELECT DISTINCT detail_firstname, detail_id, detail_varchar2 FROM phpwcms_userdetail WHERE ';
		$query .= 'detail_firstname COLLATE latin1_general_ci LIKE "%'.$nomeUser.'%" OR ';
		$query .= 'detail_varchar2 LIKE "%'.$nomeUser.'%" OR ';
		$query .= 'REPLACE(detail_varchar2, ".", "") LIKE "%'.$nomeUser.'%" OR ';
		$query .= 'REPLACE(REPLACE(detail_varchar2, ".", ""), "-", "") LIKE "%'.$nomeUser.'%" ';
		$query .= 'GROUP BY detail_firstname ';
		$query .= 'ORDER BY LOWER(detail_firstname) ASC';
		$resource = mysqli_query($conexao, $query) or die (mysql_error());
	
		
		while($data = mysqli_fetch_array($resource)){
			$nomes[$data['detail_id']] .= $data['detail_firstname'];
		}	

		if(mysqli_num_rows($resource) > 0){
			foreach($nomes as $key => $value){
				echo '<li><a href="javascript:void(0)" onClick="escolher(\''.$value.'\', \''.$key.'\')">'.$value.'</a></li>';
			}
		} else {
			echo '<li><i>Nenhum resultado encontrado.</i></li>';
		}

	} else {
		echo '';
	}
}

// ORÇAMENTOS - Busca as informações do cliente na tela de seleção de usuário cadastrado
if (isset($_POST['infoID'])) {
	$infoID = mysqli_real_escape_string($conexao, $_POST['infoID']);
	
	if(!empty($infoID) || $infoID != ''){		
		$query  = 'SELECT * FROM phpwcms_userdetail WHERE ';
		$query .= 'detail_id = '.$infoID.'';
		$resource = mysqli_query($conexao, $query) or die (mysql_error());
		$dados = mysqli_fetch_array($resource);
	
		if(mysqli_num_rows($resource) > 0){
			echo '
				<h4>RESULTADO - DADOS DO CLIENTE</h4>
				<div class="dados-cliente fl">
					<span>'.$dados['detail_firstname'].' | CPF: '.$dados['detail_varchar2'].'</span><br />
					<p><strong>E-mail:</strong> '.$dados['detail_login'].'</p><br />
					<p><strong>Telefone:</strong> '.$dados['detail_fon'].'</p><br />
					<p><strong>Celular:</strong> '.$dados['detail_mobile'].'</p><br />
					<p><strong>Endereço:</strong> '.$dados['detail_varchar4'].', '.$dados['detail_int2'].' - '.$dados['detail_varchar5'].'</p><br />
					<p><strong>Bairro:</strong> '.$dados['detail_signature'].'</p>
				</div>
			';
		} else {
			echo '<li><i>Nenhuma informação encontrada.</i></li>';
		}

	} else {
		echo '';
	}
}

// ORÇAMENTOS - Altera as informações do cliente na página de montagem de orçamentos
if(isset($_POST['detail_firstname'])){
	
	$editQuery = 'UPDATE phpwcms_userdetail SET ';
	foreach($_POST as $key => $value){
		if($key == 'detail_id'){
			continue;
		} else if($key == 'detail_birthday'){
			$data = explode('/', $value);
			$value = $data[2].'-'.$data[1].'-'.$data[0];
			
			$editQuery .= $key.' = "'.utf8_decode($value).'", ';
		} else {
			if($value == end($_POST)){
				$editQuery .= $key.' = "'.utf8_decode($value).'" ';
			} else {
				$editQuery .= $key.' = "'.utf8_decode($value).'", ';
			}
		}
	}
	$editQuery .= 'WHERE detail_id = '.$_POST['detail_id'];
	$editResult = mysqli_query($conexao, $editQuery);
	
}

// ORÇAMENTOS - Altera a lista de moedas de acordo com o tipo
if(isset($_POST['tipo'])){
	
	$tipo = mysqli_real_escape_string($conexao, $_POST['tipo']);
	
	if(!empty($tipo)){	
		$moedaQuery  = 'SELECT * FROM phpwcms_shop_products WHERE ';
		$moedaQuery .= 'shopprod_category = '.$tipo.' ';
		$moedaQuery .= 'AND shopprod_status = 1 ';
		$moedaQuery .= 'ORDER BY shopprod_color ASC';
		$moedaResult = mysqli_query($conexao, $moedaQuery);
		
		if(mysqli_num_rows($moedaResult) > 0){
			echo '<option value="">Selecione</option>';
			while($row = mysqli_fetch_array($moedaResult)){
				echo '<option value="'.$row['shopprod_id'].'">'.$row['shopprod_name1'].'</option>';
			}
		}
	} else {
		echo '<option value="">Selecione um tipo ao lado</option>';
	}
	
}

// ORÇAMENTOS - Busca o valor da taxa da moeda
if(isset($_POST['val_moeda'])){
	
	$moeda = mysqli_real_escape_string($conexao, $_POST['val_moeda']);	
	
	$moedaQuery  = 'SELECT * FROM phpwcms_shop_products WHERE ';
	$moedaQuery .= 'shopprod_id = '.$moeda.'';
	$moedaResult = mysqli_query($conexao, $moedaQuery);
	$valMoeda = mysqli_fetch_array($moedaResult);
	
	$valor = number_format($valMoeda['shopprod_price'], 4, ',', '.');
	$total = number_format($valMoeda['shopprod_price'] * $valMoeda['shopprod_name2'], 2, ',', '.');
	
	$data = array(
		'valor' 	=> $valor,
		'minimo'	=> $valMoeda['shopprod_name2'],
		'multiplo'	=> $valMoeda['shopprod_description2'],
		'categoria'	=> $valMoeda['shopprod_category'],
		'total'		=> $total
	);
	
	// Valor final para ser interpretado pelo javascript(SEMPRE json_encode)
	echo json_encode($data); 
	
}

// ORÇAMENTOS - Busca o valor da taxa da moeda
if(isset($_POST['idCampo'])){
	
	$idCampo = mysqli_real_escape_string($conexao, $_POST['idCampo']);
	
	echo '
		<input type="hidden" name="prod-categoria" class="prod-categoria" />
        <input type="hidden" name="val-multiplo" class="val-multiplo" />
        <input type="hidden" name="val-minimo" class="val-minimo" />
		<p class="campo-orc-tipo fl">
       		<strong>Tipo:</strong>
           	<select name="orc-tipo-moeda-'.$idCampo.'" id="orc-tipo-moeda">
               	<option value="">Selecione</option>
                <option value="1">Moeda</option>
                <option value="2">Cartão</option>
            </select>
		</p>
		<p class="campo-orc-moeda">
			<strong>Moeda:</strong>
			<select name="orc-moeda-'.$idCampo.'" id="orc-moeda">
               	<option value="">Selecione um tipo ao lado</option>
            </select>
		</p>
		<p class="campo-orc-valor">
			<strong>Quantidade:</strong>
			<input type="text" name="qtd-orc-'.$idCampo.'" id="qtd-orc" />
		</p>
		<p class="campo-orc-taxa">
			<strong>Taxa:</strong>
            <input type="text" name="taxa-orc-'.$idCampo.'" id="taxa-orc" />
		</p>
		<p class="campo-orc-total">
          	<strong>Total:</strong>
            <input type="text" name="total-orc-'.$idCampo.'" id="total-orc" readonly="" />
		</p>';

}

/* RELATÓRIO DE MOEDAS */
if(isset($_POST['filtroinicio'])){
	
function moeda($qtd){
	if(!empty($qtd)){
		$valor = $qtd;
	} else {
		$valor = '0';
	} 
	return $valor;
}

$moedas_sql  = 'SELECT shopprod_id, shopprod_name1 FROM phpwcms_shop_products ';
$moedas_sql .= 'WHERE shopprod_status = "1" ';
$moedas_sql .= 'ORDER BY shopprod_size DESC';
$moedas_result = mysqli_query($conexao, $moedas_sql);

$sql_status  = 'SELECT order_status FROM phpwcms_shop_orders ';
$sql_status .= 'WHERE order_status != "CLOSED" ';
$sql_status .= 'AND order_status != "PAYED-SENT" ';
$sql_status .= 'GROUP BY order_status';
$sql_result = mysqli_query($conexao, $sql_status);
while($status = mysqli_fetch_array($sql_result)){
	$listaStatus[] = $status['order_status'];
}
$moeda = array();
foreach($listaStatus as $value){
	$tipo_sql  = 'SELECT order_id, order_date, order_data, order_status FROM phpwcms_shop_orders ';
	$tipo_sql .= 'WHERE order_status = "'.$value.'" ';
	$tipo_sql .= 'AND DATE(order_date) BETWEEN "'.$_POST['filtroinicio'].'" AND "'.$_POST['filtrofinal'].'"';
	$tipo_result = mysqli_query($conexao, $tipo_sql);
		
	while($sql = mysqli_fetch_array($tipo_result)){
		$cart = unserialize($sql['order_data']);
		$a = $value;
		$idMoeda = 0;
		foreach($cart['cart'] as $values){
			if(is_array($values)){
				$idMoeda = $values['shopprod_id'];
				$valor = str_replace(',', '.', $values['shopprod_quantity']);
				$moeda[$a][$idMoeda] += $valor;
			} else {
				$orcamento = explode('|', $values);
				$idMoeda = $orcamento[0];
				if(!empty($idMoeda)){
					$valor = str_replace(',', '.', $orcamento[1]);
					$moeda[$a][$idMoeda] += $valor;
				} else {
					continue;
				}
			}	
		}			
	}
}

echo '<table width="100%" border="0" cellspacing="1" cellpadding="8">
    <tr class="relatorio-tit">
        <td width="18%">Moeda</td>
        <td align="center" width="9%">Total</td>
        <td align="center" width="9%">Pago</td>
        <td align="center" width="9%">Pedido Realizado</td>
        <td align="center" width="8%">Boletado</td>
        <td align="center" width="9%">Documentação Entregue</td>
        <td align="center" width="9%">Comprovante Recebido</td>
        <td align="center" width="11%">Validação do Pagamento</td>
        <td align="center" width="9%">Entrega Agendada</td>
        <td align="center" width="9%">Pedido Finalizado</td>
    </tr>';

while($itens = mysqli_fetch_array($moedas_result)){
    $total = $moeda['NEW-ORDER'][$itens['shopprod_id']] + $moeda['7'][$itens['shopprod_id']] + $moeda['1'][$itens['shopprod_id']] + $moeda['2'][$itens['shopprod_id']] + $moeda['3'][$itens['shopprod_id']] + $moeda['4'][$itens['shopprod_id']] + $moeda['5'][$itens['shopprod_id']];
    $pago = $moeda['2'][$itens['shopprod_id']] + $moeda['3'][$itens['shopprod_id']] + $moeda['4'][$itens['shopprod_id']] + $moeda['5'][$itens['shopprod_id']];

echo '<tr>
        <td><strong>'.$itens['shopprod_name1'].'</strong></td>
        <td align="center">'.$total.'</td>
        <td align="center">'.$pago.'</td>
        <td align="center">'.moeda($moeda['NEW-ORDER'][$itens['shopprod_id']]).'</td>
        <td align="center">'.moeda($moeda[7][$itens['shopprod_id']]).'</td>
        <td align="center">'.moeda($moeda[1][$itens['shopprod_id']]).'</td>
        <td align="center">'.moeda($moeda[2][$itens['shopprod_id']]).'</td>
        <td align="center">'.moeda($moeda[3][$itens['shopprod_id']]).'</td>
        <td align="center">'.moeda($moeda[4][$itens['shopprod_id']]).'</td>
        <td align="center">'.moeda($moeda[5][$itens['shopprod_id']]).'</td>
    </tr>';
	}
echo '</table>';

}

/* ===== CADASTRO DE FRETES ===== */

// Busca a lista de cidades de acordo com o estado selecionado
if(isset($_POST['estadoSel'])){
	
	if($_POST['estadoSel'] !== 'Selecione'){
		
		$estadoSel = mysqli_real_escape_string($conexao, $_POST['estadoSel']);
		$cidadeSel = mysqli_real_escape_string($conexao, $_POST['cidadeSel']);
		
		$estado = strtolower($estadoSel);
		
		// Busca as informações da tabela de CEPS
	
		$sql = 'SELECT cidade, id FROM '.$estado.' GROUP BY cidade ORDER BY cidade ASC';
		$res = mysqli_query($conexao, $sql);
				
		while($city = mysqli_fetch_array($res)){
			$cidades[] = $city['cidade'];
		}
		
		var_dump($cidades);
				
		foreach($cidades as $value){
			$check = ($key == $cidade) ? ' selected="selected"' : '';
			$listaCidades .= '<option value="'.mb_strtoupper($value).'"'.$check.'>'.$value.'</option>';
		}
		
		echo utf8_encode($listaCidades);

	} else {

		echo '<option>Selecione um estado</option>';

	}
	
}


/* ===== PAGSEGURO ===== */

// Atualiza as informações do pedido após o pagamento via pegaseguro
if($_POST['updateOrder'] && $_POST['updateCode']){
	
	$pedido = mysqli_real_escape_string($conexao,$_POST['updateOrder']);
	$codigo = mysqli_real_escape_string($conexao,$_POST['updateCode']);
	
	$sql = 'UPDATE phpwcms_shop_orders SET order_pagseguro = "'.$codigo.'" WHERE order_number = "'.$pedido.'"';
	$res = mysqli_query($conexao,$sql);
	
	if($res){
		echo 'foi';
	} else {
		echo 'nao foi';
	}
	

}

?>