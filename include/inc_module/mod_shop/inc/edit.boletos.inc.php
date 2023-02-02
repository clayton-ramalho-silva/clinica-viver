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

if($action == 'edit') {
	include ($phpwcms['modules'][$module]['path'].'inc/processing.preferences.inc.php');
	
	$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'] , $phpwcms['db_table'] ); 
	$num_boleto = $_GET['edit'];
	
	$consulta_boleto = 'SELECT * FROM phpwcms_shop_boleto WHERE boleto_codigo="'.$num_boleto.'"';
	$dados = mysqli_query($conexao, $consulta_boleto);
	$row = mysqli_fetch_array($dados);
	
	echo '
	<script type="text/javascript" src="template/lib/jquery/jquery-1.9.min.js"></script>
	<script type="text/javascript" src="include/inc_module/mod_shop/template/scripts/jquery-ui-1.10.4.custom.min.js"></script>
	<script type="text/javascript" src="include/inc_module/mod_shop/template/scripts/jquery.colorbox.js"></script>
	<script>
			$(document).ready(function(){
				$(".modal").colorbox({inline:true, width:"502px", height:"280px"});
			});
		</script>
	<link rel="stylesheet" type="text/css" href="include/inc_module/mod_shop/template/css/module.edit.boleto.css" />
	<script>
	$(function() {
		$("#datepicker").datepicker({
			dateFormat: "dd/mm/yy",
   			dayNames: ["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"],
   			dayNamesMin: ["D","S","T","Q","Q","S","S","D"],
   			dayNamesShort: ["Dom","Seg","Ter","Qua","Qui","Sex","Sáb","Dom"],
   			monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
			monthNamesShort: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
   			nextText: "Próximo",
   			prevText: "Anterior"
		});
	});
	</script>
	<h1 class="title">Editar Boleto</h1>
	<form name="update" id="update" action="" method="post">	
		<div class="pedido-info fl"><p class="fl" style="padding:0 !important"><b>Pedido:</b> '.$row['boleto_pedido'].'</p><p class="fl" style="margin:0 0 0 32px; padding:0 !important"><b>Data de Cria&ccedil;&atilde;o:</b> '.date("d/m/Y", strtotime($row["boleto_criacao"])).'</p><p class="fr" style="padding:0 !important"><b class="fl">Status:</b>';
if ($row['boleto_status'] == 1 || $row['boleto_status'] == 0){
	echo '<select name="status" id="status">
  			<option value="1" selected>N&atilde;o Pago</option>
  			<option value="2">Pago</option>
  			<option value="3">Cancelado</option>
		  </select>';
}
if ($row['boleto_status'] == 2){
	echo '<select name="status" id="status">
  			<option value="1">N&atilde;o Pago</option>
  			<option value="2" selected>Pago</option>
  			<option value="3">Cancelado</option>
		  </select>';
}
if ($row['boleto_status'] == 3){
	echo '<select name="status" id="status">
  			<option value="1">N&atilde;o Pago</option>
  			<option value="2">Pago</option>
  			<option value="3" selected>Cancelado</option>
		  </select>';
}
echo '</p></div>
		<p class="col1"><strong>Nome:</strong> <input type="text" name="nome" id ="nome" value="'.$row['boleto_nome'].'" /></p>
		<p class="col1"><strong>E-mail:</strong> <input type="text" name="email" id ="email" value="'.$row['boleto_email'].'" /></p>
		<p class="col1"><strong>Valor:</strong> <input type="text" name="valor" id ="valor" value="'.$row['boleto_valor'].'" /></p>
		<p class="col1"><strong>Data de Vencimento:</strong> <input type="text" name="datepicker" id="datepicker" value="'.date("d/m/Y", strtotime($row["boleto_vencimento"])).'" /></p>
		<p class="col1"><strong>Cidade:</strong> <input type="text" name="cidade" id ="cidade" value="'.$row['boleto_cidade'].'" /></p>
		<p class="col2"><strong>Estado:</strong>
			<select name="estado" id="estado">';
				if($row["boleto_estado"] == 'AC'){echo '<option value="AC" selected>AC</option>';} else {echo '<option value="AC">AC</option>';}
				if($row["boleto_estado"] == 'AL'){echo '<option value="AL" selected>AL</option>';} else {echo '<option value="AL">AL</option>';}
				if($row["boleto_estado"] == 'AM'){echo '<option value="AM" selected>AM</option>';} else {echo '<option value="AM">AM</option>';}
				if($row["boleto_estado"] == 'AP'){echo '<option value="AP" selected>AP</option>';} else {echo '<option value="AP">AP</option>';}
				if($row["boleto_estado"] == 'BA'){echo '<option value="BA" selected>BA</option>';} else {echo '<option value="BA">BA</option>';}
				if($row["boleto_estado"] == 'CE'){echo '<option value="CE" selected>AC</option>';} else {echo '<option value="AC">AC</option>';}
				if($row["boleto_estado"] == 'DF'){echo '<option value="DF" selected>DF</option>';} else {echo '<option value="DF">DF</option>';}
				if($row["boleto_estado"] == 'ES'){echo '<option value="ES" selected>ES</option>';} else {echo '<option value="ES">ES</option>';}
				if($row["boleto_estado"] == 'GO'){echo '<option value="GO" selected>GO</option>';} else {echo '<option value="GO">GO</option>';}
				if($row["boleto_estado"] == 'MA'){echo '<option value="MA" selected>MA</option>';} else {echo '<option value="MA">MA</option>';}
				if($row["boleto_estado"] == 'MG'){echo '<option value="MG" selected>MG</option>';} else {echo '<option value="MG">MG</option>';}
				if($row["boleto_estado"] == 'MS'){echo '<option value="MS" selected>MS</option>';} else {echo '<option value="MS">MS</option>';}
				if($row["boleto_estado"] == 'MT'){echo '<option value="MT" selected>MT</option>';} else {echo '<option value="MT">MT</option>';}
				if($row["boleto_estado"] == 'PA'){echo '<option value="PA" selected>PA</option>';} else {echo '<option value="PA">PA</option>';}
				if($row["boleto_estado"] == 'PB'){echo '<option value="PB" selected>PB</option>';} else {echo '<option value="PB">PB</option>';}
				if($row["boleto_estado"] == 'PE'){echo '<option value="PE" selected>PE</option>';} else {echo '<option value="PE">PE</option>';}
				if($row["boleto_estado"] == 'PI'){echo '<option value="PI" selected>PI</option>';} else {echo '<option value="PI">PI</option>';}
				if($row["boleto_estado"] == 'PR'){echo '<option value="PR" selected>PR</option>';} else {echo '<option value="PR">PR</option>';}
				if($row["boleto_estado"] == 'RJ'){echo '<option value="RJ" selected>RJ</option>';} else {echo '<option value="RJ">RJ</option>';}
				if($row["boleto_estado"] == 'RN'){echo '<option value="RN" selected>RN</option>';} else {echo '<option value="RN">RN</option>';}
				if($row["boleto_estado"] == 'RO'){echo '<option value="RO" selected>RO</option>';} else {echo '<option value="RO">RO</option>';}
				if($row["boleto_estado"] == 'RR'){echo '<option value="RR" selected>RR</option>';} else {echo '<option value="RR">RR</option>';}
				if($row["boleto_estado"] == 'RS'){echo '<option value="RS" selected>RS</option>';} else {echo '<option value="RS">RS</option>';}
				if($row["boleto_estado"] == 'SC'){echo '<option value="SC" selected>SC</option>';} else {echo '<option value="SC">SC</option>';}
				if($row["boleto_estado"] == 'SE'){echo '<option value="SE" selected>SE</option>';} else {echo '<option value="SE">SE</option>';}
				if($row["boleto_estado"] == 'SP'){echo '<option value="SP" selected>SP</option>';} else {echo '<option value="SP">SP</option>';}
				if($row["boleto_estado"] == 'TO'){echo '<option value="TO" selected>TO</option>';} else {echo '<option value="TO">TO</option>';}
		echo '</select></p>
		<p class="col2"><strong>CEP:</strong> <input type="text" name="cep" id ="cep" value="'.$row['boleto_cep'].'" /></p>
		<div class="info fl"><strong>Informa&ccedil;&otilde;es do Pedido</strong><span class="col0"><table width="100%" border="0" cellspacing="1" class="tabela-produtos">
  						<tr class="topo-lista">
    						<td style="width:72%"><strong>Produto</strong></td>
    						<td align="center" style="width:13%"><strong>Quantidade</strong></td>
    						<td align="center" style="width:15%"><strong>Preço</strong></td>
  						</tr>'.$row['boleto_info'].'</table></span></div>
		<p style="padding:0 0 0 110px"><input type="submit" name="atualizar" id="atualizar" value="Atualizar" /> <a target="_blank" href="include/inc_module/mod_shop/boleto/boleto_itau.php?p='.$num_boleto.'">Visualizar Boleto</a> <a class="modal" href="#modal">Enviar Boleto</a> <input type="submit" name="voltar" id="voltar" value="Voltar" /></p>
	</form>';
	
	echo '<div style="display:none">
	<div id="modal">
	<form name="update" id="update" action="" method="post">
		<h3>Adicionar mensagem:</h3>
		<textarea name="mensagem" id="mensagem" rows="5"></textarea>
		<input type="submit" name="enviar" id="enviar" value="Enviar Boleto" />
	</form>	
	</div>
	</div>';

	if (isset($_POST['atualizar'])){
		header("location: http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]."");
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$cidade = $_POST['cidade'];
		$estado = $_POST['estado'];
		$cep = $_POST['cep'];
		$valor = $_POST['valor'];
		$status = $_POST['status'];
		$data_vencimento = $_POST['datepicker'];
			list($dia, $mes, $ano) = explode("/", $data_vencimento);
			$vencimento = "$ano-$mes-$dia";
		
		$query = "UPDATE phpwcms_shop_boleto SET boleto_nome = '$nome', boleto_email = '$email', boleto_cidade = '$cidade', boleto_estado = '$estado', boleto_cep = '$cep', boleto_valor = '$valor', boleto_vencimento = '$vencimento', boleto_processamento = NOW(), boleto_status = '$status' WHERE boleto_codigo = '$num_boleto'";
		$resource = mysql_query($query) or die (mysql_error());
	}
	
	if (isset($_POST['voltar'])){
		header("location: phpwcms.php?do=modules&module=shop&controller=boletos");
	}
	
	if (isset($_POST['enviar'])){
		echo "<script>alert('E-mail enviado com sucesso');</script>";
		$from = $phpwcms['admin_email'];
		$to = $row['boleto_email'];
		$subject = $phpwcms['admin_name']." - Boleto Atualizado";
		$num_boleto = $_GET['edit'];
		if (!empty($_POST['mensagem'])){
			$mensagem = $_POST['mensagem'].'<br /><br />';
		} else {
			$mensagem = '';
		}
		$corpo = $plugin['data']['shop_pref_email'];
		$corpo = str_replace('{nome}',$row['boleto_nome'],$corpo);
		$corpo = str_replace('{mensagem}',$mensagem,$corpo);
		$corpo = str_replace('{link}','<a href="http://'.$_SERVER["HTTP_HOST"].'/clientes/jundiambiental/include/inc_module/mod_shop/boleto/boleto_itau.php?p='.$num_boleto.'">aqui</a>',$corpo);
		$corpo = str_replace('{pedido}',$row['boleto_pedido'],$corpo);
		$corpo = str_replace('{valor}',$row['boleto_valor'],$corpo);
		$corpo = str_replace('{criado}',date("d/m/Y", strtotime($row["boleto_criacao"])),$corpo);
		$corpo = str_replace('{vencimento}',date("d/m/Y", strtotime($row["boleto_vencimento"])),$corpo);
		$headers = "From:" . $from."\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to, $subject, $corpo, $headers);
	}	
	
}
if($action == 'delete') {
	$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table'] ); 
	$num_boleto = $_GET['delete'];
	
	$consulta_boleto = 'DELETE FROM phpwcms_shop_boleto WHERE boleto_codigo="'.$num_boleto.'"';
	$dados = mysqli_query($conexao, $consulta_boleto);
	$row = mysqli_fetch_array($dados);
	
	headerRedirect( shop_url('controller=boletos', '') );
}

?>