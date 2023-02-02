function sucesso(mensagem, classe, delay){

	$('html').append('<div class="mensagem-alteracao '+classe+'"><span>'+mensagem+'</span></div>');
	$('html').find('div.mensagem-alteracao').fadeIn(400).delay(delay).fadeOut(400);
	setTimeout(function(){
		$('html').find('div.mensagem-alteracao').remove();
	}, 4400);

}

$.abasSimples = function (){

    var abas = 'ul.tabs',
        hash = window.location.hash;

    if(hash){

        var id = hash.replace('#',''),
            conteudo = $('#'+id);

        $('li[data-tab="'+id+'"]').addClass('current');
        $(conteudo).addClass('current');

    } else {

        $(abas + '> li:first-child').addClass('current');
        $('.tab-content:first').addClass('current');

    }

    $(abas+' li').click(function (){

        var url    = window.location.href.replace(window.location.hash,''),
            href   = $(this).attr('data-tab');

        $(abas + ' li').removeAttr('class');
        $(this).addClass('current');
        $('.tab-content').removeClass('current');
        $('#'+href).addClass('current');
        history.pushState(null, null, url+'#'+href);

        // $('html, body').animate({
        //     scrollTop: $('.tab-container').offset().top - 100
        // }, 'slow');

        return false;

    });

};

$().ready(function(e) {

    $.abasSimples();

	// Envio do formulário -----------------------------------------------------
	$('#form-dados').submit(function(a){

        var meta = $("#meta-empresa").val(),
            empresa = $("#nome-empresa").val(),
            analytics = $("#analytics-empresa").val(),
            webmaster = $("#webmaster-empresa").val(),
            check_fone = $("input[name='check_num_telefone\\[\\]']").map(function(r){
                if($(this).is(':checked')){
                    var valor = $(this).val()+r;
                    return valor;
                } else {
                    return 'a'+r;
                }
            }).get(),
            telefone = $("input[name='num_telefone\\[\\]']").map(function(){return $(this).val();}).get(),
            check_whatsapp = $('#whatsapp').is(':checked') ? 1 : 0,
            whatsapp = $("input[name='num_whatsapp\\[\\]']").map(function(){return $(this).val();}).get(),
            msgWhatsapp = $("#msg-whatsapp").val(),
            check_redes = $("input[name='check_redes\\[\\]']").map(function(r){
                if($(this).is(':checked')){
                    var valor = $(this).val()+r;
                    return valor;
                } else {
                    return 'a'+r;
                }
            }).get();
            redes = $("input[name='check_links\\[\\]']").map(function(){return $(this).val();}).get();
            check_emails = $("input[name='check_emails\\[\\]']").map(function(r){
                if($(this).is(':checked')){
                    var valor = $(this).val()+r;
                    return valor;
                } else {
                    return 'a'+r;
                }
            }).get();
            emails             = $("input[name='emails\\[\\]']").map(function(){return $(this).val();}).get();
            id                 = $("input[name='id_form\\[\\]']").map(function(){return $(this).val();}).get();
            formemails         = $("input[name='emails_forms\\[\\]']").map(function(){return $(this).val();}).get();
            endereco           = $("input[name='endereco-empresa\\[\\]'], select[name='endereco-empresa\\[\\]'] ").map(function(){return $(this).val();}).get();
            ativado            = $('#novo-endereco').is(':checked') ? 1 : 0;
            endereco2          = $("input[name='endereco-empresa2\\[\\]'], select[name='endereco-empresa2\\[\\]'] ").map(function(){return $(this).val();}).get();
            mapa1	           = $('#visualizar-mapa1').is(':checked') ? 1 : 0;
            mapa2	           = $('#visualizar-mapa2').is(':checked') ? 1 : 0;
            rodape             = CKEDITOR.instances['rodape-empresa'].getData(),
            campo1             = CKEDITOR.instances['campo-adicional1'].getData(),
            campo2             = CKEDITOR.instances['campo-adicional2'].getData(),
            check_recaptcha    = $('#recaptcha').is(':checked') ? 1 : 2,
            site_recaptcha     = $('#recaptcha-site').val(),
            secret_recaptcha   = $('#recaptcha-secret').val(),
            check_ssl          = $('#forcar-ssl').is(':checked') ? 1 : 0,
            email_from         = $('#email-from').val(),
            email_nome         = $('#email-nome').val(),
            email_host         = $('#email-host').val(),
            email_porta        = $('#email-porta').val(),
            email_usuario      = $('#email-usuario').val(),
            email_senha        = $('#email-senha').val(),
            email_modo         = $('#email-modo').val(),
            email_seguro       = $('#email-seguro').val(),
            email_autenticacao = $('#email-autenticacao').val(),
            check_cookies      = $('#check-cookies').is(':checked') ? 1 : 2,
            politica_cookies   = CKEDITOR.instances['cookies_politica'].getData(),
            msg_cookies        = CKEDITOR.instances['cookies_mensagem'].getData();

        $.post("include/inc_module/mod_dados/salvar.php", {
            empresa: empresa,
            meta: meta,
            analytics: analytics,
            webmaster: webmaster,
            check_fone: check_fone,
            telefone: telefone,
            check_whatsapp: check_whatsapp,
            whatsapp: whatsapp,
            msgWhatsapp: msgWhatsapp,
            check_redes: check_redes.join(","),
            redes: redes.join(","),
            check_emails: check_emails.join(","),
            emails: emails.join(","),
            id: id.join(","),
            formemails: formemails.join(","),
            endereco: endereco.join(","),
            endereco2: endereco2.join(","),
            ativado: ativado,
            mapa1: mapa1,
            mapa2: mapa2,
            rodape: rodape,
            campo1: campo1,
            campo2: campo2,
            'check_recaptcha': check_recaptcha,
            'site_recaptcha': site_recaptcha,
            'secret_recaptcha': secret_recaptcha,
            'check_ssl': check_ssl,
            email_from: email_from,
            email_nome: email_nome,
            email_host: email_host,
            email_porta: email_porta,
            email_usuario: email_usuario,
            email_senha: email_senha,
            email_modo: email_modo,
            email_seguro: email_seguro,
            email_autenticacao: email_autenticacao,
            'check_cookies': check_cookies,
            'politica_cookies': politica_cookies,
            'msg_cookies': msg_cookies
        }, function(data){

            sucesso(data.mensagem, data.classe, data.delay);

        },'json');

		a.preventDefault ? a.preventDefault() : a.returnValue = false;

	});


    /* FUNÇÕES ============================================================== */

	// Mostra / Esconde o campo de whatsapp ------------------------------------
	$('#whatsapp').change(function(){

		if(this.checked){
			$('.box-whatsapp span, #novo-whatsapp').css('display','block');
			$('.box-whatsapp span input').removeAttr('disabled','disabled');
		} else {
			$('.box-whatsapp span, #novo-whatsapp').css('display','none');
			$('.box-whatsapp span input').attr('disabled','disabled');
		}

	})


	// Mostra / Esconde os campos de redes sociais -----------------------------
	$('.box-redes').find('.lista-redes').each(function(){

		var checkbox = $(this).find('input[type=checkbox]');
		var campo 	 = $(this).find('input[type=text]');

		$(checkbox).change(function(){
			if(checkbox.is(':checked')){
				$(campo).css('display','block');
				$(campo).removeAttr('disabled','disabled');
			} else {
				$(campo).css('display','none');
				$(campo).attr('disabled','disabled');
			}
		});

	});


	// Adiciona um novo campo de telefone --------------------------------------
	$('#novo-telefone').click(function(b){

		$('.box-telefone span').append('<label><input type="checkbox" name="check_num_telefone[]" id="check_num_telefone" value="check" /><input type="text" name="num_telefone[]" id="num_telefone" class="foneMask" value="" /></label>');

		b.preventDefault ? b.preventDefault() : b.returnValue = false;

	});


	// Adiciona um novo campo de whatsapp --------------------------------------
	$('#novo-whatsapp').click(function(d){

		$('.box-whatsapp span').append('<label><input type="text" name="num_whatsapp[]" id="num_whatsapp" class="foneMask" value="" /></label>');

		d.preventDefault ? d.preventDefault() : d.returnValue = false;

	});


	// Adiciona um novo campo de E-mail ----------------------------------------
	$('#novo-email').click(function(b){

		$('.lista-emails').append('<label><input type="checkbox" name="check_emails[]" id="check_emails" value="check" /><input type="text" name="emails[]" id="emails" value="" /></label>');

		b.preventDefault ? b.preventDefault() : b.returnValue = false;

	});


	// Adiciona um novo bloco de endereço --------------------------------------
	$('#novo-endereco').click(function(b){

		if($('.segundo-endereco').is(':visible')){

			$('.segundo-endereco').slideUp(100);
			$('#ativar-endereco').removeClass('on');

		} else {

			$('.segundo-endereco').slideDown(100);
			$('#ativar-endereco').addClass('on');

		}

    });


    // Mostra / Esconde o campo de recaptcha ------------------------------------
	$('#recaptcha').change(function(){

		if(this.checked){
			$('.recaptcha-info').css('display','block');
		} else {
			$('.recaptcha-info').css('display','none');
		}

    });


	// Abre o modal de tags ----------------------------------------------------
	$('a.lista-tags').on('click', function(){

		$('.fundo-modal').fadeIn(150);
		$('.modal-wrapper').css('visibility','visible');

	});

	$('.modal-wrapper').on('click', function(e){
		var $target = $(e.target);
		var $parent = $target.parents('div').hasClass('modal-tags');

      	if (!$target.hasClass('modal-tags') && !$target.parents('div').hasClass('modal-tags')) {
        	$('.fundo-modal').fadeOut(150);
			$('.modal-wrapper').css('visibility','hidden');
      	}

	});

	$('#num-empresa, #num-empresa2').numeric();
    $('#cep-empresa, #cep-empresa2').numeric({allowMinus:true});

});