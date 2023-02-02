<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers�o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est� dispon�vel sob a Licen�a GPL dispon�vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc� deve ter recebido uma c�pia da GNU Public License junto com     |
// | esse pacote; se n�o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora��es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo�o Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordena��o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Ita�: Glauber Portella                        |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DIN�MICOS DO SEU CLIENTE PARA A GERA��O DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formul�rio c/ POST, GET ou de BD (MySql,Postgre,etc)	//
include '../../../../config/phpwcms/conf.inc.php';
$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']); 

$pedido = $_GET['p'];
$consulta_dados = "SELECT * FROM phpwcms_shop_boleto WHERE boleto_codigo = '".$pedido."'";
$dados = mysqli_query($conexao, $consulta_dados);
$info = mysqli_fetch_array($dados);

// DADOS DO BOLETO PARA O SEU CLIENTE
//$dias_de_prazo_para_pagamento = 5;
//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$taxa_boleto = 0;
$valor_cobrado = $info['boleto_valor']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(".", "",$valor_cobrado);
$valor_cobrado = str_replace(",", ".",$valor_cobrado);

$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '.');

$dadosboleto["nosso_numero"] = '00010231';  // Nosso numero - REGRA: M�ximo de 8 caracteres!
$dadosboleto["numero_documento"] = ''.$info['boleto_pedido'].'';	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = date("d/m/Y", strtotime($info['boleto_vencimento'])); // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "".$info['boleto_nome']."";
$dadosboleto["endereco1"] = ''.$info['boleto_cidade'].' - '.$info['boleto_estado'].' -  CEP: '.$info['boleto_cep'].'';
$dadosboleto["endereco2"] = '';

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Nonononono";
$dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa banc�ria - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% ap�s o vencimento";
$dadosboleto["instrucoes2"] = "- Receber at� 10 dias ap�s o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de d�vidas entre em contato conosco: xxxx@xxxx.com.br";
$dadosboleto["instrucoes4"] = "- Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

//$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "N�O";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";

// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //

// DADOS DA SUA CONTA - ITA�
$dadosboleto["agencia"] = "0360"; // Num da agencia, sem digito
$dadosboleto["conta"] = "65246";	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "5"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - ITA�
$dadosboleto["carteira"] = "175";  // C�digo da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

// SEUS DADOS
$dadosboleto["identificacao"] = "Nome Empresa";
$dadosboleto["cpf_cnpj"] = "00.000.000/0000-0";
$dadosboleto["endereco"] = "Coloque o endere�o da sua empresa aqui";
$dadosboleto["cidade_uf"] = "Cidade / Estado";
$dadosboleto["cedente"] = "Nome Cedente";

// N�O ALTERAR!
include("include/funcoes_itau.php"); 
include("include/layout_itau.php");
?>
