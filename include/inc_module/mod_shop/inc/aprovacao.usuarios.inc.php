<style>
	.aprovação-associado{width:100%; padding:170px 0 120px; text-align:center; font-size:16px; font-family:fonte;}
	.aprovação-associado strong{font-size:21px; font-weight:normal; line-height:2}
	a.gerenciar-associados{margin:0 auto; display:table; padding:0 19px; height:37px; line-height:38px; background:#225778; font-family:fonte; border-radius:4px; color:#fff; font-size:15px;}
</style>

<?php

if($_GET['cod']){

	// Limpa e decodifica o código informado pela URL
	$decodificado = codificar($_GET['cod'],2);

	if(is_numeric($decodificado)){
		
		$sql  = 'SELECT detail_firstname, detail_lastname, detail_company, detail_fon, detail_login, ';
		$sql .= 'detail_website, detail_title, detail_varchar2, detail_int1, detail_zip, detail_street, ';
		$sql .= 'detail_add, detail_varchar1, detail_city, detail_region, detail_country, detail_aktiv ';
		$sql .= 'FROM phpwcms_userdetail WHERE detail_id = '.$decodificado;
		$res  = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));
		$info = mysqli_fetch_assoc($res);
		
		if($info['detail_aktiv'] === '0'){
			
			$codigo = codificar($decodificado,1);
			
			// Informações para o envio do formulário de aprovação			
			$corpo = _getConfig('shop_pref_email_aprovado');
			$areaCliente = _getConfig('shop_pref_id_cliente');
			$arrayTags = array('{nome}','{razao}','{cnpj}','{telefone}','{email}','{site}','{responsavel}','{categoria}','{unidades}','{cep}','{endereco}','{numero}','{complemento}','{cidade}','{bairro}','{estado}','{LINK_SENHA}');
			$arrayValores = array(
				$info['detail_firstname'],
				$info['detail_lastname'],
				$info['detail_company'],
				$info['detail_fon'],
				$info['detail_login'],
				$info['detail_website'],
				$info['detail_title'],
				$info['detail_varchar2'],
				$info['detail_int1'],
				$info['detail_zip'],
				$info['detail_street'],
				$info['detail_add'],
				$info['detail_varchar1'],
				$info['detail_city'],
				$info['detail_region'],
				$info['detail_country'],
				$phpwcms['site'].'index.php?aid='.$areaCliente
			);
			$corpo = str_replace($arrayTags,$arrayValores,$corpo);
			
			$mail_customer = array(
				'recipient'	=> $info['detail_login'],
				'toName'	=> $info['detail_firstname'],
				'subject'	=> 'Cadastro Aprovado',
				'isHTML'	=> 1,
				'html'		=> $corpo,
				'from'		=> _getConfig('shop_pref_email_from', '_shopPref'),
				'sender'	=> _getConfig('shop_pref_email_from', '_shopPref')
			);

			$order_data_mail_customer = sendEmail($mail_customer);
			
			if(!$order_data_mail_customer) {
			  
			  	
                $aprovacao = '<div class="aprovação-associado fl">
                    <strong>Erro</strong><br />
                    Ocorreu um erro durante a aprovação do associado. Por favor tente novamente mais tarde.
                </div>';
			  
			} else {

				$sqlUpdate = 'UPDATE phpwcms_userdetail SET detail_aktiv = 1 WHERE detail_id = '.$decodificado;
				$resUpdate = mysqli_query($conexao,$sqlUpdate);
    
                $aprovacao = '<div class="aprovação-associado fl">
                   	<strong>Associado aprovado com sucesso.</strong><br />
                   	Um e-mail com as informações já foi enviado para o endereço informado no cadastro.
                </div>';
			  
			}
			
		} else {

			$aprovacao = '<div class="aprovação-associado fl">
            	<strong>Este associado já foi aprovado anteriormente.</strong>
            </div>';
			
		}

	} else {
	
		header('Location: /'); // Redireciona caso o código não for um ID (checagem de segurança)
	
	}
	
} else {

	header('Location: /'); // Rediriciona caso o código não esteja informado

}

?>