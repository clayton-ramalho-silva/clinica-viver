$().ready(function() {		$('.btn-cadastro').change(function(){		if($('#tipo-cadastro2').is(':checked')){			setTimeout(function(){$('.campos-empresa').slideDown()},400);			$('.campos-pessoais').slideUp();			$('#cad_empresa, #cad_razao, #cad_registro, #cad_cnpj').removeAttr('disabled','disabled');			$('#cad_nome, #cad_cpf, #cad_rg, #cad_fone, #cad_cel').attr('disabled','disabled');		} else {			$('.campos-empresa').slideUp();			setTimeout(function(){$('.campos-pessoais').slideDown()},400);			$('#cad_empresa, #cad_razao, #cad_registro, #cad_cnpj').attr('disabled','disabled');			$('#cad_nome, #cad_cpf, #cad_rg, #cad_fone, #cad_cel').removeAttr('disabled','disabled');		}	});	/* M�scaras de campos */	$("#cad_cpf").mask("999.999.999-99");	$("#cad_nascimento").mask("99/99/9999");	$("#cad_fone").mask("(99) 9999-9999");	$("#cad_tel_empresa").mask("(99) 9999-9999");	$("#cad_cel").mask("(99) 99999-9999");	$("#cad_cel_empresa").mask("(99) 99999-9999");	$("#cad_cep").mask("99999-999");	$("#cad_cep_pes").mask("99999-999");	$("#cad_cnpj").mask("99.999.999/9999-99");		/* Limita��o de caracteres nos campos */	$('#cad_num').numeric();	$('#cad_num_ent').numeric();	$('#cad_nome').alphanum();	/* Checagem de Login ao clicar fora do campo */		$('#cad_login').blur(function(){		var	emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;		var $login = $(this).val();		if($login == ''){			$(this).addClass('error');		} else if(!emailReg.test($login)){			$(this).addClass('error');		} else {			$.ajax({				type: "POST",				url: "include/inc_module/mod_shop/inc/checar.cadastro.php",				data: "login="+$login,				cache: false,				success: function(data){					if(data == 'valid'){						$('.formulario-shop #cad_login').attr('class','valid');						$('.formulario-shop .login strong').html(' <font size="1" color="#238C00" style="font-style:italic; float:right">Login Dispon�vel</font>');					} else {						$('.formulario-shop #cad_login').attr('class','error');						$('.formulario-shop .login strong').html(' <font size="1" color="#c00c00" style="font-style:italic; float:right">E-mail j� cadastrado</font>');					}				}			});		}	});		$('#cad_login').keyup(function(){		var	emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;		var $login = $(this).val();		if($login == ''){			$(this).removeClass('valid');			$(this).addClass('error');		} else if(!emailReg.test($login)){			$(this).removeClass('valid');			$(this).addClass('error');		}	});		/* ============= In�cio das configura��es de valida��o do formul�rio ============= */				});