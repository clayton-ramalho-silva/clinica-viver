<?php
/**
 * phpwcms content management system
 *
 * @author iver Georgi <iver@phpwcms.de>
 * @copyright Copyright (c) 2002-2014, iver Georgi
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


require_once('inc/funcoes.php');


// ------------ Busca as informações no banco de dados ------------
$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);
$db_prepend = ($phpwcms['db_prepend'] != '') ? $phpwcms['db_prepend'].'_' : '';

$sql = 'SELECT *
        FROM '.$db_prepend.'phpwcms_dados';
$res = mysqli_query($conexao, $sql);
$row = mysqli_fetch_array($res);

//-----------------------------------------------------------------


// ------------ Variáveis gerais ------------

$t = 1;
$r = 0;
$w = 0;
$z = 0;

$sep_telefone_top = '';   // Separação entre os telefones do topo
$sep_telefone_rod = '';   // Separação entre os telefones do rodapé
$sep_whatsapp     = '';   // Separação entre os números do whatsapp
$dig_whatsapp     = '55'; // Dígito do país do link do whatsapp
$msg_whatsapp     = urlencode(utf8_encode($row['dados_msg_whatsapp'])); // Mensagem do whatsapp

// ------------------------------------------



// ============================= LISTA DE TELEFONES ============================

if ($row['dados_fone'] != ''){

	$telefones = explode(',', $row['dados_fone']);
	$checkbox  = explode(',', $row['dados_fone_checkbox']);
	$fone = array_combine($checkbox, $telefones);
	$fone = array_filter($fone);
	$tels = array_filter($telefones);
	$qtd_telefones = count($tels);

	$i = 0;
	$tel_topo = array();
	foreach($fone as $key => $value){
		if(preg_match("/a[0-9]+/", $key)) {
    		unset($fone[$key]);
    	} else{
			$tel_topo[] = $value;
		}
	}
	$num_tel_topo = count($tel_topo);

	foreach ($tel_topo as $key => $value){
		$i++;

	    /* ==== Coloquei essa parte na linha abaixo $numero = str_replace( ' ', '', $numero ); ==== */

		$numero = (preg_match("/^0[0-9]+/", $value)) ? $value : '0'.str_replace(array(' ','-','(',')'), '', $value);
		$classe = ($row['dados_classe_fone'] == 1) ? ' class="tel-top'.$i.'"' : '';

		if ($i == $num_tel_topo){
			if($i == 3 && $phpwcms['divFone'] == 1){
				$telefones_topo .= '<div class="fone-dropdown"><a'.$classe.' href="tel:'.$numero.'">'.$value.'</a>';
			} else {
				$telefones_topo .= '<a'.$classe.' href="tel:'.$numero.'">'.$value.'</a>';
			}
		} else {
			if($i == 3 && $phpwcms['divFone'] == 1){
				$telefones_topo .= '<div class="fone-dropdown"><a'.$classe.' href="tel:'.$numero.'">'.$value.'</a>'.$sep_telefone_top;
			} else {
				$telefones_topo .= '<a'.$classe.' href="tel:'.$numero.'">'.$value.'</a>'.$sep_telefone_top;
			}
		}
	}
	/* ==== DIV em vta dos Telefones ==== */
	if ($phpwcms['divFone'] == 1){
		if ($num_tel_topo >= 3){
			$telefones_topo .= '</div>';
		}
	}

	$o = 0;
	foreach($tels as $value){
		if(preg_match("/^0[0-9]+/", $value)){$numero = $value;} else {$numero = '0'.$value; $numero = str_replace(array(' ','-','(',')'), '', $numero );}
		if($row['dados_classe_fone'] == 1){$classe = ' class="tel'.$o.'"';} else {$classe = '';};
		if($value == "") {
    		continue;
    	} else {
			if ($o == $qtd_telefones - 1){
				$arrayFones[] = '<a'.$classe.' href="tel:'.$numero.'">'.$value.'</a>';
				$lista_telefones .= '<a'.$classe.' href="tel:'.$numero.'">'.$value.'</a>';
			} else {
				$arrayFones[] = '<a'.$classe.' href="tel:'.$numero.'">'.$value.'</a>';
				$lista_telefones .= '<a'.$classe.' href="tel:'.$numero.'">'.$value.'</a>'.$sep_telefone_rod;
			}
		}
		$o++;
	}
}

// =======================================================================================================================================



// =============================================================== WHATSAPP ==============================================================

if ($row['dados_whatsapp'] !== ''){

	$whatsapp = explode(',', $row['dados_whatsapp']);

	if($whatsapp[0] === '1'){

		// Limpa e modifica o array de números
		array_shift($whatsapp);
		array_filter($whatsapp);

		// Monta a lista de números cadastrados
		$a = 1;
		foreach($whatsapp as $value){

			if($value === ''){

				continue;

			} else {

				$separacao = ($value === end($whatsapp)) ? '' : $sep_whatsapp;

				$numero = str_replace(array(' ','-','(',')'), '', $value);
				$link = '<a href="https://api.whatsapp.com/send?phone='.$dig_whatsapp.$numero.'&text='.$msg_whatsapp.'" target="_blank">'.$value.'</a>';
				$listaWhatsapp .= $link.$separacao;

				preg_match_all("/{WHATSAPP".$a."}/", $content["all"], $resNum);
				preg_match("/\[WHATSAPP".$a."\](.*?)\[\/WHATSAPP".$a."\]/is", $content["all"], $resTagNum);

				foreach($resTagNum as $itemTag){

					if(!empty($link)){

						$conteudo = str_replace('{WHATSAPP'.$a.'}', $link, $itemTag);
						$content["all"] = str_replace(array('[WHATSAPP'.$a.']','[/WHATSAPP'.$a.']'),'',$content["all"]);

					} else {

						$content["all"] = render_cnt_template($content["all"], 'WHATSAPP'.$a, '');

					}

				}

				foreach($resNum as $item){

					if(!empty($listaWhatsapp)){

						$content["all"] = str_replace('{WHATSAPP'.$a.'}', $link, $content["all"]);

					} else {

						$content["all"] = render_cnt_template($content["all"], 'WHATSAPP'.$a, '');

					}

				}

				//$content["all"] = render_cnt_template($content["all"], '{WHATSAPP'.$a.'}', $link);
				$a++;

			}

		}

	} else {

		$listaWhatsapp = '';

	}

	// Busca a tag e verifica se a tag aparecerá se estiver em branco
	preg_match_all("/{WHATSAPP}/", $content["all"], $resultados);
	preg_match("/\[WHATSAPP\](.*?)\[\/WHATSAPP\]/is", $content["all"], $resultadosTag);

	foreach($resultadosTag as $itemTag){

		if(!empty($listaWhatsapp)){

			$conteudo = str_replace('{WHATSAPP}', $listaWhatsapp,$itemTag);
			$content["all"] = str_replace(array('[WHATSAPP]','[/WHATSAPP]'),'',$content["all"]);

		} else {

			$content["all"] = render_cnt_template($content["all"], 'WHATSAPP', '');

		}

	}

	foreach($resultados as $item){

		if(!empty($listaWhatsapp)){

			$content["all"] = str_replace('{WHATSAPP}', $listaWhatsapp, $content["all"]);

		} else {

			$content["all"] = render_cnt_template($content["all"], 'WHATSAPP', '');

		}

	}

	// Esconde os demais tags de Whatsapp
	preg_match_all("/\[WHATSAPP(.*?)\](.*?)\[\/WHATSAPP(.*?)\]/is", $content["all"], $resTagNumEx);

	foreach($resTagNumEx[1] as $value){

		$content["all"] = render_cnt_template($content["all"], 'WHATSAPP'.$value, '');

	}

}

// =======================================================================================================================================



// ======================================================== LISTA DE REDES SOCIAIS =======================================================

if ($row['dados_redes'] != ''){

	$redes = explode(',', $row['dados_redes']);
	$num_redes = count($redes);
	$check_redes = array_slice($redes, 0, ($num_redes/2));
	$val_redes = array_slice($redes, ($num_redes/2));
	$total_redes = array_combine($check_redes, $val_redes);

	// Classes das redes sociais (i)
	$nomes_redes = array('fab fa-facebook-f','fab fa-skype','fab fa-google','fab fa-linkedin-in',' fab fa-twitter','fab fa-instagram',' fab fa-youtube',' fab fa-pinterest','fab fa-blogger','fas fa-rss');  // icones FONTE

	// Tags individuais para cada rede
	$tags_redes = array('FACEBOOK','SKYPE','GOOGLE','LINKEDIN','TWITTER','INSTAGRAM','YOUTUBE','OUTRO1','OUTRO2','OUTRO3');

	$i = 0;
	foreach ($total_redes as $key => $value){

		$classe = ' class="'.$nomes_redes[$i].'"';
		$i++;
		if(preg_match("/a[0-9]+/", $key)) {

			$arrayRedes[] = '';
    		continue;

    	} else {

			if(empty($value)){

				$arrayRedes[] = '';
    			continue;

			} else {

				if($i == 2){

					$redes_sociais .= '<a href="skype:'.$value.'?call" class="pr" title="Adicione aos contatos: '.$value.'"><i'.$classe.'></i><span>'.$value.'</span></a>';
					$arrayRedes[] = '<a href="skype:'.$value.'?call" class="pr" title="Adicione aos contatos: '.$value.'"><i'.$classe.'></i><span>'.$value.'</span></a>';

				} else {

					if(preg_match("/[|]+/", $value)){
						$part = explode('|', $value);
						$redes_sociais .= '<a href="'.$part['1'].'"'.$classe.' target="_blank" title="Siga-nos: '.$part['1'].'">'.$part['0'].'</a>';
						$arrayRedes[] = '<a href="'.$part['1'].'"'.$classe.' target="_blank" title="Siga-nos: '.$part['1'].'">'.$part['0'].'</a>';
					} else {
						$redes_sociais .= '<a href="'.$value.'" target="_blank" title="Siga-nos: '.$value.'"><i'.$classe.'></i></a>';
						$arrayRedes[] = '<a href="'.$value.'" target="_blank" title="Siga-nos: '.$value.'"><i'.$classe.'></i></a>';
					}

				}
			}

		}

	}

}

// =======================================================================================================================================



// =========================================================== LISTA DE E-MAILS ==========================================================

if ($row['dados_emails'] != ''){
	$separador_email = ' <br> ';  //Separação entre os e-mails

	$emails = explode(',', $row['dados_emails']);
	$num_emails = count($emails);
	$check_emails = array_slice($emails, 0, ($num_emails/2));
	$val_emails = array_slice($emails, ($num_emails/2));
	$dados_emails = array_combine($check_emails, $val_emails);
	$dados_emails = array_filter($dados_emails);

	$mail_rod = array();
	foreach ($dados_emails as $key => $value){
		if(preg_match("/a[0-9]+/", $key)) {
    		unset($dados_emails[$key]);
    	} else {
			$mail_rod[] = $value;
		}
	}

	$i = 0;
	$num_mail_rod = count($mail_rod);
	foreach ($mail_rod as $key => $value){
		$i++;
		if ($i == $num_mail_rod){
			$emails_rodape .= '<a href="mailto:'.$value.'">'.$value.'</a>';
		} else {
			$emails_rodape .= '<a href="mailto:'.$value.'">'.$value.'</a>'.$separador_email;
		}
	}


	foreach($val_emails as $value){
		if($value == "") {
    		continue;
    	} else{
			if ($value === end($val_emails)){
				$lista_emails .= '<a href="mailto:'.$value.'">'.$value.'</a>';
			} else {
				$lista_emails .= '<a href="mailto:'.$value.'">'.$value.'</a>'.$separador_email;
			}
		}
	}
}

// =======================================================================================================================================



// ========================================================= ENDEREÇO DA EMPRESA =========================================================

$tags_endereco = array('RUA','NUMERO','BAIRRO', 'CEP','CIDADE','UF','COMPLEMENTO','RUA-MAPA','BAIRRO-MAPA','CIDADE-MAPA');

$info_endereco = explode(',', $row['dados_endereco']);
$ruaMapa 	= remover_acentos($info_endereco[0]);
$bairroMapa = remover_acentos($info_endereco[2]);
$cidadeMapa = remover_acentos($info_endereco[4]);
$enderecoMapa = $ruaMapa.' '.$info_endereco[1].' '.$bairroMapa.' '.$cidadeMapa.' '.$info_endereco[3];

array_push($info_endereco, $ruaMapa, $bairroMapa, $cidadeMapa);

foreach($tags_endereco as $value){

	preg_match_all("/{".$value."}/", $content["all"], $resultados);
	preg_match("/\[".$value."\](.*?)\[\/".$value."\]/is", $content["all"], $resultadosTag);

	foreach($resultadosTag as $itemTag){

		if(!empty($info_endereco[$w])){

			$conteudo = str_replace('{'.$value.'}', $info_endereco[$w],$itemTag);
			$content["all"] = str_replace(array('['.$value.']','[/'.$value.']'),'',$content["all"]);
			$content["all"] = str_replace($teste,$conteudo,$content["all"]);

		} else {

			$content["all"] = render_cnt_template($content["all"], $value, '');

		}

	}

	foreach($resultados as $item){

		if(!empty($info_endereco[$w])){

			$content["all"] = str_replace('{'.$value.'}', $info_endereco[$w], $content["all"]);

		} else {

			$content["all"] = render_cnt_template($content["all"], $value, '');

		}

	}

	$w++;

}

// Mapa do Endereço
if($row['dados_mapa1'] === '0'){

	if(($info_endereco[0] && $info_endereco[0] !== "") || $row['dados_mapa1'] === '0'){

		$mapa = '<div id="canvas1" class="mapa">
			<iframe id="map_canvas1" width="100%" height="400" frameborder="0" scrling="no" marginheight="0" marginwidth="0" src="https://www.google.com.br/maps?sll=m&amp;q='.$enderecoMapa.'&amp;dg=opt&amp;ie=UTF8&amp;hq=&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
			<form method="get" id="formTracarRota">
				<input type="text" id="rotaOrigem" name="rotaOrigem" placehder="Digite aqui seu endereço"/>
				<input type="submit" value="Tra&ccedil;ar Rota" />
			</form>
		</div>

		[JS]
		<script>
		$().ready(function () {
			$("#formTracarRota").submit(function () {
				var origem = $("#rotaOrigem").val();
				window.open("https://www.google.com.br/maps/dir/"+origem+"/'.$enderecoMapa.'", "_blank");
				return false;
			});
		});
		</script>
		[/JS]';

		$content["all"] = render_cnt_template($content["all"], 'MAPS', $mapa);

	} else {

		$content["all"] = render_cnt_template($content["all"], 'MAPS', '');

	}

} else {

	$content["all"] = render_cnt_template($content["all"], 'MAPS', '');

}

// =======================================================================================================================================


// ===================================================== SEGUNDO ENDEREÇO DA EMPRESA =====================================================

$tags_endereco2 = array('RUA2','NUMERO2','BAIRRO2','UF2','CIDADE2','COMPLEMENTO2', 'CEP2', 'RUA-MAPA2', 'BAIRRO-MAPA2', 'CIDADE-MAPA2');

$info_endereco2 = explode(',', $row['dados_endereco2']);
$ruaMapa2 	 = remover_acentos($info_endereco2[0]);
$bairroMapa2 = remover_acentos($info_endereco2[2]);
$cidadeMapa2 = remover_acentos($info_endereco2[4]);
$enderecoMapa2 = $ruaMapa2.' '.$info_endereco2[1].' '.$bairroMapa2.' '.$cidadeMapa2.' '.$info_endereco2[3];

array_push($info_endereco2, $ruaMapa2, $bairroMapa2, $cidadeMapa2);

foreach($tags_endereco2 as $valor){

	preg_match_all("/{".$valor."}/", $content["all"], $resultados2);
	preg_match("/\[".$valor."\](.*?)\[\/".$valor."\]/is", $content["all"], $resultadosTag2);

	foreach($resultadosTag2 as $itemTag2){

		if($row['dados_segundo_endereco'] !== '1'){

			$content["all"] = render_cnt_template($content["all"], $valor, '');

		} else if(!empty($info_endereco2[$z])){

			$conteudo = str_replace('{'.$valor.'}', $info_endereco2[$z],$itemTag2);
			$content["all"] = str_replace(array('['.$valor.']','[/'.$valor.']'),'',$content["all"]);
			$content["all"] = str_replace($teste,$conteudo,$content["all"]);

		} else {

			$content["all"] = render_cnt_template($content["all"], $valor, '');

		}

	}

	foreach($resultados2 as $item2){

		if(!empty($info_endereco2[$z])){

			$content["all"] = str_replace('{'.$valor.'}', $info_endereco2[$z], $content["all"]);

		} else {

			$content["all"] = render_cnt_template($content["all"], $valor, '');

		}

	}

	$z++;

}

// Mapa do Endereço
if($row['dados_mapa2'] === '0'){

	if($info_endereco2[0] && $info_endereco2[0] !== ""){

		$mapa2 = '<div id="canvas2" class="mapa">
			<iframe id="map_canvas1" width="100%" height="400" frameborder="0" scrling="no" marginheight="0" marginwidth="0" src="https://www.google.com.br/maps?sll=m&amp;q='.$enderecoMapa2.'&amp;dg=opt&amp;ie=UTF8&amp;hq=&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
			<form method="get" id="formTracarRotaSec">
				<input type="text" id="rotaOrigemSec" name="rotaOrigemSec" placehder="Digite aqui seu endereço"/>
				<input type="submit" value="Tra&ccedil;ar Rota" />
			</form>
		</div>

		[JS]
		<script>
		$().ready(function () {
			$("#formTracarRotaSec").submit(function () {
				var origem = $("#rotaOrigemSec").val();
				window.open("https://www.google.com.br/maps/dir/"+origem+"/'.$enderecoMapa2.'", "_blank");
				return false;
			});
		});
		</script>
		[/JS]';

		$content["all"] = render_cnt_template($content["all"], 'MAPS2', $mapa2);

	} else {

		$content["all"] = render_cnt_template($content["all"], 'MAPS2', '');

	}

} else {

	$content["all"] = render_cnt_template($content["all"], 'MAPS2', '');

}

// =======================================================================================================================================



// =======================================================================================================================================
// ============================================================= TAGS GERAIS =============================================================
// =======================================================================================================================================

$content["all"] = render_cnt_template($content["all"], 'NOME-EMPRESA', $row['dados_empresa']);			// Nome da Empresa
$content["all"] = render_cnt_template($content["all"], 'RODAPE', $row['dados_rodape']);				// Campo de rodapé
$content["all"] = render_cnt_template($content["all"], 'EMAILS', $lista_emails);					// E-mails do rodapé
$content["all"] = render_cnt_template($content["all"], 'EMAILS-RODAPE', $emails_rodape);			// E-mails do rodapé
$content["all"] = render_cnt_template($content["all"], 'CAMPO1', $row['dados_campo_adicional1']);	// Campo adicional 1
$content["all"] = render_cnt_template($content["all"], 'CAMPO2', $row['dados_campo_adicional2']);	// Campo adicional 1

// ----- REDES SOCIAIS -----
$content["all"] = render_cnt_template($content["all"], 'REDES-SOCIAIS', $redes_sociais);	// Lista de Redes Sociais
foreach($arrayRedes as $value){
	if(!empty($value)){
		$content["all"] = render_cnt_template($content["all"], $tags_redes[$r], $value);
	} else {
		$content["all"] = render_cnt_template($content["all"], $tags_redes[$r], '');
	}
	$r++;
}

// ----- TELEFONES -----
$content["all"] = render_cnt_template($content["all"], 'TELEFONE', $lista_telefones);		// Telefones
$content["all"] = render_cnt_template($content["all"], 'TELEFONE-TOPO', $telefones_topo);	// Telefones do topo
foreach($arrayFones as $value){
	$content["all"] = render_cnt_template($content["all"], 'TELEFONE'.$t, $value);
	$t++;
}

// Esconde os demais tags de telefone
preg_match_all("/\[TELEFONE(.*?)\](.*?)\[\/TELEFONE(.*?)\]/is", $content["all"], $resTagFonEx);

foreach($resTagFonEx[1] as $value){

	$content["all"] = render_cnt_template($content["all"], 'TELEFONE'.$value, '');

}


// ----- COOKIES -----

// Verifica a tag de Cookies
$cookies = unserialize($row['dados_cookies']);

if($cookies['ativo'] === '1'){

    $content['all'] = render_cnt_template($content['all'], 'COOKIES_POLITICA', $cookies['politica']);
    $content['all'] = render_cnt_template($content['all'], 'COOKIES_MENSAGEM', $cookies['mensagem']);
    $content['all'] = str_replace(array('[COOKIES]', '[/COOKIES]'), '', $content['all']);

} else {

    $content['all'] = render_cnt_template($content['all'], 'COOKIES', '');

}

?>