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

$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'] , $phpwcms['db_table'] ); 
$consulta_boleto = 'SELECT * FROM phpwcms_shop_boleto WHERE boleto_id IS NOT NULL ';
$dados = mysqli_query($conexao, $consulta_boleto);
$row = mysqli_fetch_array($dados);

$_controller_link =  shop_url('controller=boletos');
$tipo_filtro = $_GET['f'];
$plugin['row_count'] = 0;

$paginate = "SELECT COUNT(*) FROM phpwcms_shop_boleto";
if (isset($_GET['f'])){
	switch($tipo_filtro) {
	case 0:$paginate .= ""; break;
	case 1:$paginate .= " WHERE boleto_status='1'"; break;
	case 2:$paginate .= " WHERE boleto_status='2'"; break;
	case 3:$paginate .= " WHERE boleto_status='3'"; break;
	}
} else {
	$paginate .= " WHERE boleto_id IS NOT NULL";
}

$resultado = mysqli_query($conexao,$paginate);
$r = mysqli_fetch_row($resultado);
$numerorows = $r[0];

// number of rows to show per page
$rowsporpagina = 20;
// find out total pages
$totalpaginas = ceil($numerorows / $rowsporpagina);

if ($_GET['pg'] && is_numeric($_GET['pg'])) {
   // cast var as int
   $paginaatual = (int) $_GET['pg'];
} else {
   // default page num
   $paginaatual = 1;
} // end if

// if current page is greater than total pages...
if ($paginaatual > $totalpaginas) {
   // set current page to last page
   $paginaatual = $totalpaginas;
} // end if
// if current page is less than first page...
if ($paginaatual < 1) {
   // set current page to first page
   $paginaatual = 1;
} // end if

// the offset of the list, based on current page 
$offsete = ($paginaatual - 1) * $rowsporpagina;

// get the info from the db 
$paginate = "SELECT * FROM phpwcms_shop_boleto";
if (isset($_GET['f'])){
	switch($tipo_filtro) {
	case 0:$paginate .= ""; break;
	case 1:$paginate .= " WHERE boleto_status='1'"; break;
	case 2:$paginate .= " WHERE boleto_status='2'"; break;
	case 3:$paginate .= " WHERE boleto_status='3'"; break;
	}
} else {
	$paginate .= " WHERE boleto_id IS NOT NULL";
}
$paginate .= " ORDER BY boleto_id DESC LIMIT $offsete, $rowsporpagina";
$resultado = mysqli_query($conexao,$paginate);

$uri_parts = explode('&', $_SERVER['REQUEST_URI'], 2);
$pagina = $_GET['pg'];
if (isset($_GET['pg'])){
	$location = 'location = "phpwcms.php?do=modules&module=shop&controller=boletos&f="+this.options[this.selectedIndex].value+"&pg='.$pagina.'";';
} else {
	$location = 'location = "phpwcms.php?do=modules&module=shop&controller=boletos&f="+this.options[this.selectedIndex].value';
}
if (isset($_GET['f']) && isset($_GET['pg'])){
	$location = 'location = "phpwcms.php?do=modules&module=shop&controller=boletos&f="+this.options[this.selectedIndex].value+"&pg='.$pagina.'";';
}
$script_filtro = '
	<script type="text/javascript">
	$().ready(function(e) {
		$("#selecione").change(function() {
			'.$location.'
		}); 
	});
	</script>';

?>
<script type="text/javascript" src="template/lib/jquery/jquery-1.9.min.js"></script>
<? echo ''.$script_filtro.''; ?>
<style>
.pago{width:13px; height:10px; background:url(img/backend/ico-status-boleto.png) no-repeat 0 -13px; display:block}
.pendente{width:13px; height:10px; background:url(img/backend/ico-status-boleto.png) no-repeat -1px 0; display:block}
#tabela-boletos strong{font-size:10px}
tr{ line-height:15px}
</style>

<table width="100%" border="0" cellspacing="1" cellpadding="3" id="tabela-boletos">
  <tr bgcolor="#DAE6D2">
    <td width="11%"><strong>&nbsp;Nº Pedido</strong></td>
    <td width="41%"><strong>&nbsp;Nome</strong></td>
    <td width="15%" align="center"><strong>Data do Pedido</strong></td>
    <td width="13%" align="center"><strong>Vencimento</strong></td>
    <td width="11%" align="center"><strong>Status</strong></td>
    <td width="9%" align="center"><strong>Editar</strong></td>
  </tr>
<? while ($row = mysqli_fetch_array($resultado)) {
	if ($row['boleto_status'] == 1){
		$status = 'pago';
	} else {
		$status = 'pendente';
	}
	$data =  date("d/m/Y", strtotime($row["boleto_criacao"]));
	$vencimento =  date("d/m/Y", strtotime($row["boleto_vencimento"]));
	echo '<tr'.( ($plugin['row_count'] % 2) ? ' bgcolor="#F3F5F8"' : '' ).' onmouseover="this.bgColor=\'#C8E494\';" onmouseout="this.bgColor=\''.( ($plugin['row_count'] % 2) ? '#F3F5F8' : '' ).'\';">
			<td>'.$row["boleto_pedido"].'</td>
    		<td>'.$row["boleto_nome"].'</td>
    		<td align="center">'.$data.'</td>
			<td align="center">'.$vencimento.'</td>
    		<td align="center">';
			if ($row['boleto_status'] == 0){echo 'Não Pago';}
			if ($row['boleto_status'] == 1){echo 'Não Pago';}
			if ($row['boleto_status'] == 2){echo 'Pago';}
			if ($row['boleto_status'] == 3){echo 'Cancelado';}
	  echo '</td>
    		<td><a href="'.$_controller_link.'&amp;edit='.$row["boleto_codigo"].'"><img border="0" alt="" src="img/button/edit_22x13.gif"></a> <a onclick="return confirm("Apagar este boleto?");" href="'.$_controller_link.'&amp;delete='.$row["boleto_codigo"].'"><img border="0" alt="" src="img/button/del_13x13_1.gif"></a></td>
 		</tr>';
		$plugin['row_count']++;
} ?>
<?

/******  build the pagination links ******/
// range of num links to show
$range = 2;

// if not on page 1, don't show back links
echo '<div class="ul-paginate">';
// if not on page 1, don't show back links
$getval = $_GET['f'];
$filtro = utf8_decode('
	<select name="selecione" id="selecione" class="fr">
		<option value="0" selected="selected">Filtrar por status</option>
       	<option value="1">N&atilde;o Pago</option>
       	<option value="2">Pago</option>
       	<option value="3">Cancelado</option>
	</select>');
if ($getval == '1'){
$filtro = utf8_decode('
	<select name="selecione" id="selecione" class="fr">
		<option value="0">Filtrar por status</option>
       	<option value="1" selected="selected">N&atilde;o Pago</option>
       	<option value="2">Pago</option>
       	<option value="3">Cancelado</option>
	</select>');
}
if ($getval == '2'){
$filtro = utf8_decode('
	<select name="selecione" id="selecione" class="fr">
		<option value="0">Filtrar por status</option>
       	<option value="1">N&atilde;o Pago</option>
       	<option value="2" selected="selected">Pago</option>
       	<option value="3">Cancelado</option>
	</select>');
}
if ($getval == '3'){
$filtro = utf8_decode('
	<select name="selecione" id="selecione" class="fr">
		<option value="0">Filtrar por status</option>
       	<option value="1">N&atilde;o Pago</option>
       	<option value="2">Pago</option>
       	<option value="3" selected="selected">Cancelado</option>
	</select>');
}
	echo $filtro;
		
if ($paginaatual > 1) {
   // show << link to go back to page 1
   //echo " <div class='apn_prev'><a href='phpwcms.php?do=modules&module=shop&controller=boletos&pg=1' title='Primeira página'><img src='images/pg-first.png' width='9' height='11'></a></a></div> ";
   // get previous page num
   $prevpage = $paginaatual - 1;
   // show < link to go back to 1 page
   $prevpage = $paginaatual - 1;
   		// show < link to go back to 1 page
		$num_filtro = '&f='.$_GET['f'];
		if (isset($_GET['f'])){
   			$prevlink = "".$_SERVER['REQUEST_URI'].$num_filtro."&module=shop&controller=boletos&pg=$prevpage";
		} else {
			$prevlink = "".$_SERVER['REQUEST_URI']."&module=shop&controller=boletos&pg=$prevpage";
		}
		if (isset($_GET['pg'])){
			$prevlink = "".$uri_parts[0]."&module=shop&controller=boletos&pg=$prevpage";
		} else {
			$prevlink = "".$_SERVER['REQUEST_URI']."&module=shop&controller=boletos&pg=$prevpage";
		}
		if (isset($_GET['f']) && isset($_GET['pg'])){
			$prevlink = "".$uri_parts[0].$num_filtro."&module=shop&controller=boletos&pg=$prevpage";
		} else {$prevlink = 'bbbbbbbb';}
		
		echo "<div class='apn_prev'><a href='".$prevlink."' title='P&aacute;gina anterior'>&laquo;</a></div> ";
} // end if 

// loop to show links to range of pages around current page
echo "<div class='apn_navi fl' style='float:left'>";
for ($x = ($paginaatual - $range); $x < (($paginaatual + $range) + 1); $x++) {
   		// if it's a valid page number...
   		if (($x > 0) && ($x <= $totalpaginas)) {
      		// if we're on current page...
      		if ($x == $paginaatual) {
         		// 'highlight' it but don't make a link
         		echo " <span>$x</span> ";
      			// if not current page...
      		} else {
        		// make it a link
				$num_filtro = '&f='.$_GET['f'];
				if (isset($_GET['f'])){
   					$pagelink = "".$_SERVER['REQUEST_URI'].$num_filtro."&module=shop&controller=boletos&pg=$x";
				} else {
					$pagelink = "".$_SERVER['REQUEST_URI']."&module=shop&controller=boletos&pg=$x";
				}
				if (isset($_GET['pg'])){
					$pagelink = "".$uri_parts[0]."&module=shop&controller=boletos&pg=$x";
				} else {
					$pagelink = "".$_SERVER['REQUEST_URI']."&module=shop&controller=boletos&pg=$x";
				}
				if (isset($_GET['f']) && isset($_GET['pg'])){
					$pagelink = "".$uri_parts[0].$num_filtro."&module=shop&controller=boletos&pg=$x";
				}
        		echo " <a href='".$pagelink."'>$x</a> ";
      		} // end else
		} // end if 
	} // end forecho '</div>';
	echo '</div>';
                 
// if not on last page, show forward and last page links        
if ($paginaatual != $totalpaginas) {
   // get next page
   $nextpage = $paginaatual + 1;
    // echo forward link for next page 
   $num_filtro = '&f='.$_GET['f'];
		if (isset($_GET['f'])){
   			$nextlink = "".$_SERVER['REQUEST_URI'].$num_filtro."&module=shop&controller=boletos&pg=$nextpage";
		} else {
			$nextlink = "".$_SERVER['REQUEST_URI']."&module=shop&controller=boletos&pg=$nextpage";
		}
		if (isset($_GET['pg'])){
			$nextlink = "".$uri_parts[0]."&module=shop&controller=boletos&pg=$nextpage";
		} else {
			$nextlink = "".$_SERVER['REQUEST_URI']."&module=shop&controller=boletos&pg=$nextpage";
		}
		if (isset($_GET['f']) && isset($_GET['pg'])){
			$nextlink = "".$uri_parts[0].$num_filtro."&&module=shop&controller=boletospg=$nextpage";
		}
		
		$info_paginate .= " <div class='apn_next'><a href='".$nextlink."' title='Pr&oacute;xima p&aacute;gina'>&raquo;</a></div> ";
   // echo forward link for lastpage
   //echo " <div class='apn_next'><a href='phpwcms.php?do=modules&module=shop&controller=boletos&pg=$totalpaginas' title='Última página'><img src='images/pg-last.png' width='9' height='11' /></a></div> ";
} // end if
echo '</div><br style="clear:both" />';

/************************ FIM DO PAGINATE ************************/
?>
</table>
