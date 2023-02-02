$().ready(function() {	
	$('.metodo-pagamento #pag_cadastro').change(function(){
		if($('.pag_cartao').is(':checked')){
			$('.cad_cartoes').show().removeAttr('disabled','disabled');
		} else {
			$('.cad_cartoes').hide().attr('disabled','disabled');
		}
	});
	
	/* Máscaras de campos */
	$("#cad_nascimento").mask("99/99/9999");
	$("#cad_fone").mask("(99) 9999-9999");
	$("#cad_cel").mask("(99) 99999-9999");
	$("#cad_cep").mask("99999-999");
	$("#cad_cep_ent").mask("99999-999");
	
	/* Limitação de caracteres nos campos */
	$('#cad_num').numeric();
	$('#cad_nome').alphanum();
	
	/* Checagem de CEP 
	$("#cad_cep_ent").blur(function(){
		var cep = $(this).val();
		var n = cep.length;
		if (cep > '09999-999' || n != 9){
			$(this).val('')
			alert('O CEP fornecido não está dentro da nossa área de Atendimento');
		}
	});
	*/
	
	/* Checagem de Login ao clicar fora do campo */
	$('#cad_login').blur(function(){
		var $id = $('#cad_id').val();
		var $altlogin = $(this).val();
		if($altlogin != ''){
			$.ajax({
				type: "POST",
				url: "include/inc_module/mod_shop/inc/checar.cadastro.php",
				data: "id="+$id+"&altlogin="+$altlogin,
				cache: false,
				success: function(data){
					if(data == 'erro'){
						$('.formulario-shop .login i').attr('class',data);
						$('.formulario-shop #cad_login').attr('class','error');
						$('.formulario-shop .login strong').html('Login: <font size="1" color="#c00c00" style="font-style:italic; float:right">Este nome de usuário já está sendo utilizado</font>');
					} else {
						$('.formulario-shop .login i').removeAttr('class');
						$('.formulario-shop #cad_login').attr('class','valid');
						$('.formulario-shop .login strong').html('Login:');
					}
				}
			});
		}
	});
	
	/* ============= Início das configurações de validação do formulário ============= */
	
	/* Validação individual de cada campo ao clicar fora sem adicionar um valor (adicionar ", #ID DO CAMPO") */
	$("#cad_login").blur(function(){
		if ($(this).val() == ""){$(this).removeClass('valid').addClass('error');} else {$(this).removeClass('error').addClass('valid');}
	});
		
	/* Configurações de envio do formulário */
	$('#form-atualizar-cadastro').submit(function(p){
		var campos = ["#cad_login", "#cad_nome"];
		$.each(campos, function( index, value ){
            if($(value).val() == "" || $(value).hasClass('error')){
				$(value).removeClass('valid').addClass('error');
				p.preventDefault ? p.preventDefault() : p.returnValue = false;
			} 
        });
		/*
		if($('input').hasClass('error')){
		} else {
			$.ajax({
				type: "POST",
				url: "include/inc_module/mod_shop/inc/editar.cadastro.php",
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				data: $(this).serialize(),
				cache: false,
				success: function(data){
					function mensagem(){
						$('.mensagem-cadastro').fadeIn('slow');
					}
					if(data == '1'){
						alert('Este nome de usuário já está sendo utilizado.')
					} else {
						$('.mensagem-alteracao').fadeIn(600).delay(8000).fadeOut(600);
					}
				}
			});
		}
		p.preventDefault ? p.preventDefault() : p.returnValue = false;
		*/
	})
});