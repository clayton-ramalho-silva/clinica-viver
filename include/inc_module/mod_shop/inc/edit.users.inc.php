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
	
	$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'] , $phpwcms['db_table']); 
	$num_user = intval($_GET['edit']);
	
	$consulta_boleto = 'SELECT * FROM phpwcms_userdetail WHERE detail_id="'.$num_user.'"';
	$dados = mysqli_query($conexao, $consulta_boleto);
	$row = mysqli_fetch_array($dados);
	
	if($row['detail_birthday'] == '0000-00-00' || !isset($row['detail_birthday'])){
		$data = '';
	} else {
		$data = date('d/m/Y', strtotime($row['detail_birthday']));
	}
?>
	<script type="text/javascript" src="template/lib/jquery/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="include/inc_module/mod_shop/template/scripts/jquery.alphanum.js"></script>
    <script type="text/javascript" src="include/inc_module/mod_shop/template/scripts/jquery.masked.js"></script>
    <script type="text/javascript" src="include/inc_module/mod_shop/template/scripts/jquery.validate.js"></script>
    <script type="text/javascript">
		$().ready(function(e) {
			
			/* Mostra / Esconde os campos de informações sobre a Empresa */
			$('.tipo-cadastro').change(function(){
				if($('#tipo-cadastro2').is(':checked')){
					$('div.box-empresa').show();
					$('#empresa_user, #razao_user, #registro_user, #cnpj_user').removeAttr('disabled','disabled');
				} else {
					$('div.box-empresa').hide();
					$('#empresa_user, #razao_user, #registro_user, #cnpj_user').attr('disabled','disabled');
				}
			});
			
            /* Máscaras de campos */
			$("#cpf_user").mask("999.999.999-99");
			$("#nascimento_user").mask("99/99/9999");
			$("#fone_user").mask("(99) 9999-9999");
			$("#cel_user").mask("(99) 99999-9999");
			$("#cep_user").mask("99999-999");
			$("#cnpj_user").mask("99.999.999/9999-99");
			$('#numero_user').numeric();
			
			/* Validação dos Campos */
			$("#update_user").validate({
			rules:{
				<?php 
					// Se for o cadastro de um novo usuário, coloca o campo de senha como obrigatório
					echo $num_user === 0 ? 'senha_user:"required",' : '';
				?>
				nome_user:"required",
				cpf_user:"required",
				fone_user:"required",			
				login_user:{required:true, email:true},
				email_user:{required:true, email:true}
				},		
			messages:{
				<?php
					// Se for o cadastro de um novo usuário, coloca o campo de senha como obrigatório
					echo $num_user === 0 ? 'senha_user:"",' : '';
				?>	
				nome_user:"",
				cpf_user:"",
				fone_user:"",		
				login_user:{required:"", email:""},
				email_user:{required:"", email:""}
				}
			});
	 
        });
    </script>
	
    <div class="tit fl pr<?php echo $inputClasse; ?>">
    	<?php if($num_user === 0){	?>
    		<h3><?php echo $BLM['tit_novo_usuario']; ?></h3>
            <div class="tipo-cadastro fr">
    			<p>
            		<strong>Tipo de Cadastro</strong>
                    <label for="tipo-cadastro1">
                        <input type="radio" id="tipo-cadastro1" name="tipo-cadastro" class="cadastro" value="1" checked="checked">
                        Pessoa Física
                    </label>
                    <label>
                        <input type="radio" id="tipo-cadastro2" name="tipo-cadastro" class="cadastro" value="2">
                        Pessoa Jurídica
                    </label>
                </p>
            </div>
        <?php } else { ?>
        	<h3 style="text-transform:uppercase">
				<?php echo $BLM['tit_edit_usuario'].' - '.$row['detail_firstname']; ?>
            </h3>
        <?php } ?>
	</div>
    
    <div class="form-atualizar-usuario fl">
    <form name="update_user" id="update_user" action="" method="post">
    	<? if($row['detail_int1'] !== '1'){ ?>
		<p class="campo1">
        	<strong>Nome do Usuário:</strong>
            <input type="text" name="nome_user" id="nome_user" value="<?php echo ($_POST['nome_user'] ? $_POST['nome_user'] : $row['detail_firstname']); ?>" />
        </p>
        <?php } ?>
        <div class="box-user fl">
        	<h3>Dados de Acesso</h3>
        	<p class="campo2-l pr">
            	<strong>Login:</strong>
                <?php
					// Mensagem de erro caso o login já esteja em uso
                	if(isset($_SESSION['erro-login'])){
						echo '<i class="mensagem-erro">Login já em uso</i>';
						unset($_SESSION['erro-login']);
					} else {
						echo '';
					}
				?>
                <input type="text" name="login_user" id="login_user" value="<?php echo ($_POST['login_user'] ? $_POST['login_user'] : $row['detail_login']); ?>" />
            </p>
        	<p class="campo2-r">
            	<strong>Senha:</strong>
                <input type="password" name="senha_user" id="senha_user" autocomplete="off" value="" />
            </p>
        </div>
        
        <? if($row['detail_int1'] == 2){ ?>
        <div class="box-user fl">
        	<h3>Dados Pessoais</h3>
        	<p class="campo4-l">
            	<strong>RG:</strong>
                <input type="text" name="rg_user" id="rg_user" value="<?php echo ($_POST['rg_user'] ? $_POST['rg_user'] : $row['detail_varchar1']); ?>" />
            </p>
        	<p class="campo4-l">
            	<strong>CPF:</strong>
                <input type="text" name="cpf_user" id="cpf_user" value="<?php echo ($_POST['cpf_user'] ? $_POST['cpf_user'] : $row['detail_varchar2']); ?>" />
            </p>
        	<p class="campo4-l">
            	<strong>Telefone:</strong>
                <input type="text" name="fone_user" id="fone_user" value="<?php echo ($_POST['fone_user'] ? $_POST['fone_user'] : $row['detail_fon']); ?>" />
            </p>
        	<p class="campo4-r">
            	<strong>Celular:</strong>
                <input type="text" name="cel_user" id="cel_user" value="<?php echo ($_POST['cel_user'] ? $_POST['cel_user'] : $row['detail_mobile']); ?>" />
            </p>
        </div>
        <?php } ?>
        
        <? if($row['detail_int1'] == 1){ ?>
            <div class="box-user fl">
                <h3>Dados da Empresa</h3>
                <p class="campo2-l">
                    <strong>Nome Fantasia:</strong>
                    <input type="text" name="empresa_user" id="empresa_user" value="<?php echo ($_POST['empresa_user'] ? $_POST['empresa_user'] : $row['detail_company']); ?>" />
                </p>
                <p class="campo4-l">
                    <strong>CNPJ:</strong>
                    <input type="text" name="cnpj_user" id="cnpj_user" value="<?php echo ($_POST['cnpj_user'] ? $_POST['cnpj_user'] : $row['detail_varchar3']); ?>" />
                </p>
                <p class="campo4-r">
                    <strong>Registro Estadual:</strong>
                    <input type="text" name="registro_user" id="registro_user" value="<?php echo ($_POST['registro_user'] ? $_POST['registro_user'] : $row['detail_text4']); ?>" />
                </p>
                <p class="campo2-l">
                    <strong>Razão Social:</strong>
                    <input type="text" name="razao_user" id="razao_user" value="<?php echo ($_POST['razao_user'] ? $_POST['razao_user'] : $row['detail_text3']); ?>" />
                </p>
                <p class="campo4-l">
                    <strong>Telefone:</strong>
                    <input type="text" name="tel_empresa_user" id="tel_empresa_user" value="<?php echo ($_POST['tel_empresa_user'] ? $_POST['tel_empresa_user'] : $row['detail_varchar4']); ?>" />
                </p>
                <p class="campo4-r">
                    <strong>Celular:</strong>
                    <input type="text" name="cel_empresa_user" id="cel_empresa_user" value="<?php echo ($_POST['cel_empresa_user'] ? $_POST['cel_empresa_user'] : $row['detail_varchar5']); ?>" />
                </p>
                <p class="campo2-l">
                    <strong>Responsável / Contato:</strong>
                    <input type="text" name="responsavel_user" id="responsavel_user" value="<?php echo ($_POST['responsavel_user'] ? $_POST['responsavel_user'] : $row['detail_text5']); ?>" />
                </p>
                <p class="campo2-r">
                    <strong>Site da Empresa:</strong>
                    <input type="text" name="site_user" id="site_user" value="<?php echo ($_POST['site_user'] ? $_POST['site_user'] : $row['detail_text1']); ?>" />
                </p>
            </div>
        <?php } elseif($_GET['edit'] === '0'){ ?>
			<div class="box-user box-empresa fl" style="display:none">
                <h3>Dados da Empresa</h3>
                <p class="campo2-l">
                    <strong>Nome Fantasia:</strong>
                    <input type="text" name="empresa_user" id="empresa_user" value="<?php echo $_POST['empresa_user']; ?>" />
                </p>
                <p class="campo4-l">
                    <strong>CNPJ:</strong>
                    <input type="text" name="cnpj_user" id="cnpj_user" value="<?php echo $_POST['cnpj_user']; ?>" />
                </p>
                <p class="campo4-r">
                    <strong>Registro Estadual:</strong>
                    <input type="text" name="registro_user" id="registro_user" value="<?php echo $_POST['registro_user']; ?>" />
                </p>
                <p class="campo2-l">
                    <strong>Razão Social:</strong>
                    <input type="text" name="razao_user" id="razao_user" value="<?php echo $_POST['razao_user']; ?>" />
                </p>
                <p class="campo4-l">
                    <strong>Telefone:</strong>
                    <input type="text" name="tel_empresa_user" id="tel_empresa_user" value="<?php echo ($_POST['tel_empresa_user'] ? $_POST['tel_empresa_user'] : $row['detail_varchar4']); ?>" />
                </p>
                <p class="campo4-r">
                    <strong>Celular:</strong>
                    <input type="text" name="cel_empresa_user" id="cel_empresa_user" value="<?php echo $_POST['cel_empresa_user']; ?>" />
                </p>
                <p class="campo2-l">
                    <strong>Responsável / Contato:</strong>
                    <input type="text" name="responsavel_user" id="responsavel_user" value="<?php echo $_POST['responsavel_user']; ?>" />
                </p>
                <p class="campo2-r">
                    <strong>Site da Empresa:</strong>
                    <input type="text" name="site_user" id="site_user" value="<?php echo $_POST['site_user']; ?>" />
                </p>
            </div>
		<?php  } ?>
        
        <div class="box-user fl">
        	<h3>Dados de Endereço</h3>
        	<p class="campo2-l">
            	<strong>Endereço:</strong>
                <input type="text" name="endereco_user" id="endereco_user" value="<?php echo ($_POST['endereco_user'] ? $_POST['endereco_user'] : $row['detail_street']); ?>" />
            </p>
       		<p class="campo4-l">
            	<strong>Número:</strong>
                <input type="text" name="numero_user" id="numero_user" value="<?php echo ($_POST['numero_user'] ? $_POST['numero_user'] : $row['detail_add']); ?>" />
            </p>
        	<p class="campo4-r">
            	<strong>UF:</strong>
                <?php echo estados('estado_user', $row["detail_country"], $_POST['estado_user']); ?>
       		</p>
         	<p class="campo2-l">
            	<strong>Cidade:</strong>
                <input type="text" name="cidade_user" id="cidade_user" value="<?php echo ($_POST['cidade_user'] ? $_POST['cidade_user'] : $row['detail_city']); ?>" />
            </p>
         	<p class="campo2-r">
            	<strong>Bairro:</strong>
                <input type="text" name="bairro_user" id="bairro_user" value="<?php echo ($_POST['bairro_user'] ? $_POST['bairro_user'] : $row['detail_region']); ?>" />
            </p>
         	<p class="campo2-l">
            	<strong>CEP:</strong>
                <input type="text" name="cep_user" id="cep_user" value="<?php echo ($_POST['cep_user'] ? $_POST['cep_user'] : $row['detail_zip']); ?>" />
           	</p>
         	<p class="campo2-r">
            	<strong>Complemento:</strong>
                <input type="text" name="comp_user" id="comp_user" value="<?php echo ($_POST['comp_user'] ? $_POST['comp_user'] : $row['detail_text2']); ?>" />
            </p>
        </div>
         
        <p class="campo1 textarea">
         	<strong>Observações:</strong>
            <textarea name="obs_user" id="obs_user" rows="4"><?php echo ($_POST['obs_user'] ? $_POST['obs_user'] : $row['detail_website']); ?></textarea>
        </p>
        
         <div class="status-user fl">
         	<strong>Status do Usuário:</strong>
            <input name="ativo_user" id="ativo_user" type="checkbox" value="" <? if($row['detail_aktiv'] == 1){echo 'checked="checked"';} else {echo '';}  ?> />
            <label for="ativo_user">Ativo</label>
         </div>
         
         <p class="campo1">
         	<span>
            	<input type="submit" name="atualizar" id="atualizar" value="<?php if($_GET['edit'] === '0'){echo 'Cadastrar';} else {echo 'Atualizar';} ?>" />
                <input type="submit" name="voltar" id="voltar" value="Voltar" />
            </span>
        </p>
    </form>
</div>

<?php
	
	if (isset($_POST['voltar'])){
		header("location: phpwcms.php?do=modules&module=shop&controller=users");
	}	
}

?>