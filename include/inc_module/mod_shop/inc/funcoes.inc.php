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


// ==============================================================================================================================
// ==================================================== CONFIGURAÇÕES GERAIS ====================================================
// ==============================================================================================================================

$preco = _getConfig('shop_pref_preco');

// Lista de Status
global $listaStatus;
$listaStatus = _getConfig('shop_pref_status');

// Divide a URL da ferramenta para ser utilizada no sistema
$url = explode('&', $_SERVER['REQUEST_URI']);
$urlSite = $url['0'];
$urlMod = '&'.$url['1'];
isset($url['2']) ? $urlAcao = '&'.$url['2'] : $urlAcao = '';
isset($url['3']) ? $urlVar= '&'.$url['3'] : $urlVar = '';

$modBase = $urlSite.$urlMod; // Caminho do módulo
$modAcao =  $urlSite.$urlMod.$urlAcao;
$modInfo =  $urlSite.$urlMod.$urlAcao.$urlVar;

// Dados do paginate
$getPagina = (int)preg_replace("/[^0-9]/", "", $_GET['pg']);
is_int($getPagina) ? $pagina = $getPagina : $pagina = ''; // Checa o número da página do paginate

$range = 3; // Quantidade de páginas a serem mostradas como opções
$rowsporpagina = 15; // Quantidade padrão do paginate (pode variar com a página, MUDAR DO ARQUIVO, NÃO AQUI)




// ==============================================================================================================================
// =========================================================== FUNÇÕES ==========================================================
// ==============================================================================================================================

// -- Limita o texto que irá aparecer --
function limite($texto, $limite){
	if(strlen($texto) <= $limite){
  		echo $texto;
	} else {
		$novo = substr($texto, 0, $limite).'...';
		echo '<span title="'.$texto.'">'.$novo.'</span>';
	}
};


// -- Início da montagem do paginate --
function paginate($query, $rows, $pagina, $ordem, $conexao){
	if(!empty($query)){

		$dados = mysqli_query($conexao, $query);
		$numerorows = mysqli_num_rows($dados);
		$totalpaginas = ceil($numerorows / $rows); // Quantidade total de páginas

		if ($pagina && is_int($pagina)) {$paginaatual = (int)$pagina;} else {$paginaatual = 1;}
		if ($paginaatual > $totalpaginas) {$paginaatual = $totalpaginas;}
		if ($paginaatual < 1) {$paginaatual = 1;}
		$offsete = ($paginaatual - 1) * $rows;

		$resultados = $query.' '.$ordem.' '.$offsete.', '.$rows.'';
		$lista_resultado = mysqli_query($conexao , $resultados);

	} else {

		return false;

	}

	return array($lista_resultado, $totalpaginas, $paginaatual, $numerorows);

};



// -- Cria os links para o paginate --

function links_paginate_shop($totalpaginas, $paginaatual, $range, $url){

	if ($totalpaginas > 1) {

	echo '<div class="paginacao">

			<div class="apn_navi">';

			if ($paginaatual > 1) {

				$prevpage = $paginaatual - 1;



				$prevlink = $url.'&pg='.$prevpage;

				$firstlink = $url.'&pg=1';

				echo "<a href='".$firstlink."' class='apn_prev' title='Primeira p&aacute;gina'>&laquo;&laquo;</a>";

				echo "<a href='".$prevlink."' class='apn_prev' title='P&aacute;gina anterior'>&laquo;</a>";

			}



			for ($x = ($paginaatual - $range); $x < (($paginaatual + $range) + 1); $x++) {

				if (($x > 0) && ($x <= $totalpaginas) && $totalpaginas > 1) {

					if ($x == $paginaatual) {

						echo " <span>$x</span> ";

					} else {

						$pagelink = $url.'&pg='.$x;

						echo " <a href='".$pagelink."'>$x</a> ";

					}

				}

			}



			if ($paginaatual != $totalpaginas) {

				$nextpage = $paginaatual + 1;



				$nextlink = $url.'&pg='.$nextpage;

				$lastlink = $url.'&pg='.$totalpaginas;

				echo "<a href='".$nextlink."' class='apn_next' title='Pr&oacute;xima p&aacute;gina'>&raquo;</a>";

				echo "<a href='".$lastlink."' class='apn_next' title='&Uacute;ltima p&aacute;gina'>&raquo;&raquo;</a>";

		}

	echo '</div>';

	echo '</div><br style="clear:both" />';

	}

}



// Posiciona a div de opções para cima nos últios itens da lista

function fundo($rows, $i){

	$val_fundo = ($rows - 4);

	if($rows > $val_fundo){

		if($i > $val_fundo && $i <= $rows){$fundo = ' fundo';} else {$fundo = '';}

	} else {

		$fundo = ' fundo';

	}

	return $fundo;

}



// Remove os acentos dos nomes do status

function remover_acentos_status($string) {



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





// Busca os status do shop para serem listados

function status($cod){

	global $listaStatus;

	$statusShop = explode('|', $listaStatus);



	$i = 0;

	$x = 0;

	foreach($statusShop as $value){

		$partes = explode(',', $value);

		$val = remover_acentos_status($partes[0]);



		if($i === 0){

			$valor = 'NEW-ORDER';

			$val = 'NEW-ORDER';

		} else {

			$valor = $val;

		}



		if(isset($cod)){

			if($cod === $val){

				$check = ' selected="selected"';

				$x++;

			} else {

				$check = '';

			}

		} else {

			$check = '';

		}



		$resultado .= '<option value="'.$valor.'"'.$check.'>'.$partes[0].'</option>';

		$i++;

	}



	if($x === 0){

		$resultadoTotal = '<option value="" checked="checked">STATUS INDEFINIDO</option><optgroup label="Selecione um novo status">'.$resultado.'</optgroup>';

	} else {

		$resultadoTotal = $resultado;

	}



	return $resultadoTotal;



}



// Busca os status do shop para mostrar na lista de pedidos dos clientes

function statusCliente($cod){

	global $listaStatus;

	$statusShop = explode('|', $listaStatus);



	$i = 0;

	$x = 0;

	foreach($statusShop as $value){

		$partes = explode(',', $value);

		$val = remover_acentos_status($partes[0]);



		if($i === 0){

			$valor = 'NEW-ORDER';

			$val = 'NEW-ORDER';

		} else {

			$valor = $val;

		}



		if(isset($cod)){

			if($cod === $val){

				$resultado = $partes[0];

				$x++;

			} else if($cod === 'CLOSED'){

				$resultado = 'Cancelado';

				$x++;

			}

		} else {

			$check = '';

		}



		$i++;

	}



	if($x === 0){

		$resultadoTotal = 'STATUS INDEFINIDO';

	} else {

		$resultadoTotal = $resultado;

	}



	return $resultadoTotal;



}



// Cria a lista de status de fechamento para separar os pedidos na área dos clientes

function statusPendentes(){

	global $listaStatus;

	$statusShop = explode('|', $listaStatus);



	$i = 0;

	$sql = ' AND (';

	foreach($statusShop as $value){

		$partes = explode(',', $value);

		$val = remover_acentos_status($partes[0]);



		if($i === 0){

			$valor = 'NEW-ORDER';

			$val = 'NEW-ORDER';

		} else {

			$valor = $val;

		}



		if($partes[1] === '2'){

			$sqlArray[] = 'order_status = "'.$val.'"';

		} else {

			continue;

		}



		$i++;



	}

	$sqlList = implode(' OR ', $sqlArray);

	$sql .= $sqlList.')';



	return $sql;



}



// Cria o select de estados e marca o selecionado

function estados($id, $sel, $post=''){

	$estados = array('AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO');

	$resultado = '<select id="'.$id.'" name="'.$id.'">

		<option value="">Selecione</option>';

	foreach ($estados as $uf){

		if(isset($sel) || isset($post)){

			if($sel === $uf || $post === $uf){$check = ' selected="selected"';} else {$check = '';}

		} else {

			$check = '';

		}

		$resultado .= '<option value="'.$uf.'"'.$check.'>'.$uf.'</option>';

	}

	$resultado .= '</select>';

	return $resultado;

}

function cadastroEstados($conexao, $campo){

	$sql = 'SELECT UF FROM uf';
	$res = mysqli_query($conexao, $sql);

	while($uf = mysqli_fetch_array($res)){
		$estados[] = $uf['UF'];
	}

	$listaEstados = '';
	foreach($estados as $value){
		$check = ($value === $campo) ? ' selected="selected"' : '';
		$listaEstados .= '<option value="'.$value.'"'.$check.'>'.$value.'</option>';
	}

	return $listaEstados;

}

function cadastroCidades($conexao, $estado, $cidade){

	$estado = strtolower($estado);

	$sql = 'SELECT cidade, id FROM '.$estado.' GROUP BY cidade';
	$res = mysqli_query($conexao, $sql);

	while($city = mysqli_fetch_array($res)){
		$cidades[] = $city['cidade'];
	}

	foreach($cidades as $value){
		$check = ($key == $cidade) ? ' selected="selected"' : '';
		$listaCidades .= '<option value="'.mb_strtoupper($value).'"'.$check.'>'.$value.'</option>';
	}

	return $listaCidades;

}