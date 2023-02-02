$().ready(function() {	
	$("#cad_senha").blur(function(){
		var senha = $(this).val();
		var conf = $("#cad_conf_senha").val();
		if(senha != ''){
			$(this).removeClass('error');
		}
		if(conf != ''){
			if(conf != senha){
				$("#cad_conf_senha").addClass("error");
				$("#cad_conf_senha").addClass("erro-senha");
				$('.senha i').html('Senhas Diferentes').css('color','red');
			} else {
				$("#cad_conf_senha").removeClass("error");
				$("#cad_conf_senha").removeClass("erro-senha");
				$('.senha i').html('Senhas Iguais').css('color','green');
			}
		}
	});
	
	$("#cad_conf_senha").blur(function(){
		var senha = $("#cad_senha").val();
		var conf = $(this).val();
		if(conf != senha){
			$(this).addClass("error");
			$(this).addClass("erro-senha");
			$('.senha i').html('Senhas Diferentes').css('color','red');
		} else {
			if($(senha).val() != ''){
				$(this).removeClass("error");
				$(this).removeClass("erro-senha");
				$('.senha i').html('Senhas Iguais').css('color','green');
			} else {
				$('.senha i').html('');
			}
		}
	})
	
	$("#cad_nova_senha").keyup(function(){
		if($(this).val() != ''){
			$(this).removeClass('error');
		}
	})
	
	/* Configurações de envio do formulário */
	$('#form-atualizar-cadastro').submit(function(p){
		var campos = ["#cad_senha", "#cad_conf_senha", "#cad_nova_senha"];
		$.each(campos, function( index, value ){
            if($(value).val() == "" || $(value).hasClass('error')){
				$(value).removeClass('valid').addClass('error');
				p.preventDefault ? p.preventDefault() : p.returnValue = false;
			} 
        });
		if($('input').hasClass('error')){
			p.preventDefault ? p.preventDefault() : p.returnValue = false;
		}
	})
});