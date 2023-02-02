function sucesso(div,mensagem,classe){

	$(div).append('<div class="mensagem-alteracao '+classe+'"><span>'+mensagem+'</span></div>');
	$(div).find('div.mensagem-alteracao').fadeIn(200).delay(1000).fadeOut(200);
	setTimeout(function(){
		$(div).find('div.mensagem-alteracao').remove();
	},4400);

}

$().ready(function(e) {

	// Envio do formulário de Nome de Empresa ----------------------------------
	$('#form-empresa').submit(function(a){

		var meta = $("#meta-empresa").val();
		var empresa = $("#nome-empresa").val();
		var analytics = $("#analytics-empresa").val();
		var webmaster = $("#webmaster-empresa").val();

        $.post("include/inc_module/mod_dados/salvar.php", {empresa:empresa,meta:meta,analytics:analytics,webmaster:webmaster}, function(data){
            sucesso('.box-nome',data.mensagem,data.classe);
        },'json');

		a.preventDefault ? a.preventDefault() : a.returnValue = false;

	});


	// Envio do formulário de Telefones ----------------------------------------
	$('#form-telefone').submit(function(a){

		var check = $("input[name='check_num_telefone\\[\\]']").map(function(r){
			if($(this).is(':checked')){
				var valor = $(this).val()+r;
				return valor;
			} else {
				return 'a'+r;
			}
		}).get();
		var telefone = $("input[name='num_telefone\\[\\]']").map(function(){return $(this).val();}).get();
		var check_whatsapp = $('#whatsapp').is(':checked') ? 1 : 0;
        var whatsapp = $("input[name='num_whatsapp\\[\\]']").map(function(){return $(this).val();}).get();
        var msgWhatsapp = $("#msg-whatsapp").val();
		var classes = $('#classe_fone').is(':checked') ? 1 : 0;

        $.post("include/inc_module/mod_dados/salvar.php", {
            'check':check,
            'telefone':telefone,
            'check_whatsapp':check_whatsapp,
            'whatsapp':whatsapp,
            'msgWhatsapp':msgWhatsapp,
            'classes':classes
        }, function(data){
            sucesso('.box-telefones',data.mensagem,data.classe);
        },'json');

		a.preventDefault ? a.preventDefault() : a.returnValue = false;

	});


	// Envio do formulário de Nome de Redes Sociais ----------------------------
	$('#form-redes').submit(function(a){

		var check = $("input[name='check_redes\\[\\]']").map(function(r){
			if($(this).is(':checked')){
				var valor = $(this).val()+r;
				return valor;
			} else {
				return 'a'+r;
			}
		}).get();
		var redes = $("input[name='check_links\\[\\]']").map(function(){return $(this).val();}).get();

        $.post("include/inc_module/mod_dados/salvar.php", {check:check.join(","),redes:redes.join(",")}, function(data){
            sucesso('.box-redes',data.mensagem,data.classe);
        },'json');

		a.preventDefault ? a.preventDefault() : a.returnValue = false;

	});


	// Envio do formulário de Nome de E-mails ----------------------------------
	$('#form-emails').submit(function(a){

		var check = $("input[name='check_emails\\[\\]']").map(function(r){
			if($(this).is(':checked')){
				var valor = $(this).val()+r;
				return valor;
			} else {
				return 'a'+r;
			}
		}).get();
		var emails = $("input[name='emails\\[\\]']").map(function(){return $(this).val();}).get();

        $.post("include/inc_module/mod_dados/salvar.php", {check:check.join(","),emails:emails.join(",")}, function(data){
            sucesso('.box-emails',data.mensagem,data.classe);
        },'json');

		a.preventDefault ? a.preventDefault() : a.returnValue = false;

	});


	// Envio do formulário de E-mails de Formulários ---------------------------
	$('#form-forms').submit(function(a){

		var id         = $("input[name='id_form\\[\\]']").map(function(){return $(this).val();}).get();
		var formemails = $("input[name='emails_forms\\[\\]']").map(function(){return $(this).val();}).get();

        $.post("include/inc_module/mod_dados/salvar.php", {id:id.join(","),formemails:formemails.join(",")}, function(data){
            sucesso('.box-forms',data.mensagem,data.classe);
        },'json');

		a.preventDefault ? a.preventDefault() : a.returnValue = false;

	});


	// Envio do formulário de Endereço -----------------------------------------
	$('#form-endereco').submit(function(c){

		var meta 	  = $("#meta-empresa").val();
		var endereco  = $("input[name='endereco-empresa\\[\\]'], select[name='endereco-empresa\\[\\]'] ").map(function(){return $(this).val();}).get();
		var ativado   = $('#novo-endereco').is(':checked') ? 1 : 0;
		var endereco2 = $("input[name='endereco-empresa2\\[\\]'], select[name='endereco-empresa2\\[\\]'] ").map(function(){return $(this).val();}).get();
		var mapa1	  = $('#visualizar-mapa1').is(':checked') ? 1 : 0;
		var mapa2	  = $('#visualizar-mapa2').is(':checked') ? 1 : 0;
		var analytics = $("#analytics-empresa").val();
		var webmaster = $("#webmaster-empresa").val();

        $.post("include/inc_module/mod_dados/salvar.php", {endereco:endereco.join(","),endereco2:endereco2.join(","),meta:meta,ativado:ativado,mapa1:mapa1,mapa2:mapa2,analytics:analytics,webmaster:webmaster}, function(data){
            sucesso('.modulo-endereco','As informações foram alteradas com sucesso','sucesso');
        },'json');

		c.preventDefault ? c.preventDefault() : c.returnValue = false;

	});


	// Envio do formulário de Rodapé -------------------------------------------
	$('#form-rodape').submit(function(c){

		var rodape = CKEDITOR.instances['rodape-empresa'].getData();

        $.post("include/inc_module/mod_dados/salvar.php", {rodape:rodape}, function(data){
            sucesso('.box-rodape',data.mensagem,data.classe);
        },'json');

		c.preventDefault ? c.preventDefault() : c.returnValue = false;

	});


	// Envio do formulário de Campo Adicional 1 --------------------------------
	$('#form-campo-adicional1').submit(function(c){

		var campo1 = CKEDITOR.instances['campo-adicional1'].getData();

        $.post("include/inc_module/mod_dados/salvar.php", {campo1:campo1}, function(data){
            sucesso('.box-campo-adicional1',data.mensagem,data.classe);
        },'json');

		c.preventDefault ? c.preventDefault() : c.returnValue = false;

	});


	// Envio do formulário de Campo Adicional 2 --------------------------------
	$('#form-campo-adicional2').submit(function(c){

        var campo2 = CKEDITOR.instances['campo-adicional2'].getData();

        $.post("include/inc_module/mod_dados/salvar.php", {campo2:campo2}, function(data){
            sucesso('.box-campo-adicional2',data.mensagem,data.classe);
        },'json');

		c.preventDefault ? c.preventDefault() : c.returnValue = false;

	});


	// Envio do formulário de Meta ---------------------------------------------
	$('#form-meta').submit(function(c){

		var meta = $("#meta-empresa").val();
		var empresa = $("#nome-empresa").val();
		var analytics = $("#analytics-empresa").val();
		var webmaster = $("#webmaster-empresa").val();

        $.post("include/inc_module/mod_dados/salvar.php", {empresa:empresa,meta:meta,analytics:analytics,webmaster:webmaster}, function(data){
            sucesso('.box-meta','As informações foram alteradas com sucesso','sucesso');
        },'json');

		c.preventDefault ? c.preventDefault() : c.returnValue = false;
	});


	// Envio do formulário de Analytics ----------------------------------------
	$('#form-analytics').submit(function(c){

		var meta = $("#meta-empresa").val();
		var empresa = $("#nome-empresa").val();
		var analytics = $("#analytics-empresa").val();
		var webmaster = $("#webmaster-empresa").val();

        $.post("include/inc_module/mod_dados/salvar.php", {empresa:empresa,meta:meta,analytics:analytics,webmaster:webmaster}, function(data){
            sucesso('.box-analytics','As informações foram alteradas com sucesso','sucesso');
        },'json');

		c.preventDefault ? c.preventDefault() : c.returnValue = false;
	});


	// Envio do formulário de webmaster ----------------------------------------
	$('#form-webmaster').submit(function(c){

		var meta = $("#meta-empresa").val();
		var empresa = $("#nome-empresa").val();
		var analytics = $("#analytics-empresa").val();
		var webmaster = $("#webmaster-empresa").val();

        $.post("include/inc_module/mod_dados/salvar.php", {empresa:empresa,meta:meta,analytics:analytics,webmaster:webmaster}, function(data){
            sucesso('.box-webmaster','As informações foram alteradas com sucesso','sucesso');
        },'json');

		c.preventDefault ? c.preventDefault() : c.returnValue = false;

	});


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


    /* reCAPTCHA */

    // Mostra / Esconde o campo de recaptcha ------------------------------------
	$('#recaptcha').change(function(){

		if(this.checked){
			$('.recaptcha-info').css('display','block');
		} else {
			$('.recaptcha-info').css('display','none');
		}

    });

    // Envio do formulário de recaptcha ----------------------------------------
	$('#form-recaptcha').submit(function(a){

        var check_recaptcha  = $('#recaptcha').is(':checked') ? 1 : 2,
            site_recaptcha   = $('#recaptcha-site').val(),
            secret_recaptcha = $('#recaptcha-secret').val();

        $.post("include/inc_module/mod_dados/salvar.php", {
            'check_recaptcha': check_recaptcha,
            'site_recaptcha': site_recaptcha,
            'secret_recaptcha': secret_recaptcha
        }, function(data){
            sucesso('.box-recaptcha',data.mensagem,data.classe);
        },'json');

		a.preventDefault ? a.preventDefault() : a.returnValue = false;

	});

});