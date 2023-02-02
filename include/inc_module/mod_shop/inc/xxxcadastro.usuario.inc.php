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

$cadastro = '
{CSS:include/inc_module/mod_shop/template/css/cadastro.shop.css}
{HEAD:include/inc_module/mod_shop/template/scripts/jquery.masked.js}
{HEAD:include/inc_module/mod_shop/template/scripts/jquery.alphanum.js}
{HEAD:include/inc_module/mod_shop/template/scripts/funcoes-cadastro.js}

<div class="cadastro-shop fl">
<div class="mensagem-cadastro"></div>
<div class="content-cadastro-shop fl">
	<div class="tipo-cadastro fl">
		<span>
			<label><input type="radio" name="tipo-cadastro" class="tipo1" value="1" id="tipo-cadastro" checked="checked">Pessoa Física</label>
			<label><input type="radio" name="tipo-cadastro" class="tipo2" value="2" id="tipo-cadastro">Pessoa Jurídica</label>
		</span>	
	</div>
	<form id="form-cadastro-shop" action="">
		<p class="campo2-l login pr"><i></i><strong>Login:</strong><input type="text" name="cad_login" id="cad_login" /></p>
    	<p class="campo2-r"><strong>Senha:</strong><input type="text" name="cad_senha" id="cad_senha" /></p>
		<span class="campos-empresa">
			<h4>Informações da Empresa</h4>
    		<p class="campo2-l"><strong>Empresa:</strong><input type="text" name="cad_empresa" id="cad_empresa" disabled="disabled" /></p>
    		<p class="campo2-r"><strong>Razão Social:</strong><input type="text" name="cad_razao" id="cad_razao" disabled="disabled" /></p>
    		<p class="campo2-l"><strong>Registro Estadual:</strong><input type="text" name="cad_registro" id="cad_registro" disabled="disabled" /></p>
    		<p class="campo2-r"><strong>CNPJ:</strong><input type="text" name="cad_cnpj" id="cad_cnpj" disabled="disabled" /></p>
		</span>
		<h4>Informações Pessoais</h4>
    	<p class="campo2-l"><strong>Nome:</strong><input type="text" name="cad_nome" id="cad_nome" /></p>
    	<p class="campo2-r"><strong>E-mail:</strong><input type="text" name="cad_email" id="cad_email" /></p>
    	<p class="campo3-l"><strong>RG:</strong><input type="text" name="cad_rg" id="cad_rg" /></p>
    	<p class="campo3-m"><strong>CPF:</strong><input type="text" name="cad_cpf" id="cad_cpf" /></p>
    	<p class="campo3-r"><strong>Data de Nascimento:</strong><input type="text" name="cad_nascimento" id="cad_nascimento" /></p>
    	<p class="campo2-l"><strong>Telefone:</strong><input type="text" name="cad_fone" id="cad_fone" /></p>
   		<p class="campo2-r"><strong>Celular:</strong><input type="text" name="cad_cel" id="cad_cel" /></p>
		<h4>Informações de Endereço</h4>
    	<p class="campo2-l"><strong>Endereço:</strong><input type="text" name="cad_endereco" id="cad_endereco" /></p>
    	<p class="campo4-l"><strong>Número:</strong><input type="text" name="cad_num" id="cad_num" /></p>
    	<p class="campo4-r">
        	<strong>UF:</strong>
        	<select name="cad_uf" id="cad_uf">
            	<option value="AC">AC</option>
				<option value="AL">AL</option>
            	<option value="AM">AM</option>
            	<option value="AP">AP</option>
            	<option value="BA">BA</option>
            	<option value="CE">CE</option>
            	<option value="DF">DF</option>
            	<option value="ES">ES</option>
            	<option value="GO">GO</option>
            	<option value="MA">MA</option>
            	<option value="MG">MG</option>
            	<option value="MS">MS</option>
            	<option value="MT">MT</option>
            	<option value="PA">PA</option>
            	<option value="PB">PB</option>
            	<option value="PE">PE</option>
            	<option value="PI">PI</option>
            	<option value="PR">PR</option>
            	<option value="RJ">RJ</option>
            	<option value="RN">RN</option>
            	<option value="RO">RO</option>
            	<option value="RR">RR</option>
            	<option value="RS">RS</option>
            	<option value="SC">SC</option>
            	<option value="SE">SE</option>
            	<option value="SP" selected="selected">SP</option>
            	<option value="TO">TO</option>
            </select>
        </p>
		<p class="campo2-l"><strong>Cidade:</strong><input type="text" name="cad_cidade" id="cad_cidade" /></p>
    	<p class="campo2-r"><strong>Bairro:</strong><input type="text" name="cad_bairro" id="cad_bairro" /></p>
    	<p class="campo2-l"><strong>CEP:</strong><input type="text" name="cad_cep" id="cad_cep" /></p>
    	<p class="campo2-r"><strong>Complemento:</strong><input type="text" name="cad_comp" id="cad_comp" /></p>
    	<p class="campo1"><strong>Observações:</strong><textarea name="cad_obs" id="cad_obs"></textarea></p>
		<p class="campo1"><input type="submit" name="enviar" id="enviar" value="Enviar" /></p>
</form>
</div>
</div>';
?>