$().ready(function(e) {
	$(".accordion form").each(function() {
		var numero = $(this).attr("id")
		$(this).submit(function(e){
			$text = $("#"+numero+" #article_alias").val();
			$id = $("#"+numero+" #id").val();
			$artigo = $("#"+numero+" #artigo").val();
			$subtitulo = $("#"+numero+" #subtitulo").val();
			$palavrachave = $("#"+numero+" #palavra-chave").val();
			$titulo = $("#"+numero+" #titulo").val();
			$descricao = $("#"+numero+" #descricao").val();
			$sumario = $("#"+numero+" #sumario").val();
			$.ajax({
				type: "POST",
				cache: false,
				url: "salvar.php",
				data: "text="+$text+"&id="+$id+"&artigo="+$artigo+"&subtitulo="+$subtitulo+"&palavrachave="+$palavrachave+"&titulo="+$titulo+"&descricao="+$descricao+"&sumario="+$sumario,
				success: function(data) {
					$("#"+numero+" .mensagem").text('Salvando...').addClass('salvando').removeClass('salvo');
				},
				complete: function(data) {
					setTimeout(function () {
						$("#"+numero+" .mensagem").fadeOut(1200, (function(){
							$("#"+numero+" .mensagem").text('');
						}));
						$("#"+numero+" .mensagem").fadeIn((function(){
							$("#"+numero+" .mensagem").text('Salvo!').removeClass('salvando').addClass('salvo');
						}));
						});
					}
					
			});
			e.preventDefault();
		});
	});
    $("#select").change(function() {
        location = this.options[this.selectedIndex].value;
    });
	$("form").each(function() {
		var numero = $(this).attr("id")
		$("#"+numero+" #article_alias").blur(function() {
    		var input =  $(this);
			str = input.val().replace();
			str = str.toUpperCase();
        	str = str.toLowerCase();
        	str = str.replace(/[\u00E0\u00E1\u00E2\u00E3\u00E5]/g,"a");
        	str = str.replace(/[\u00E7]/g,"c");
        	str = str.replace(/[\u00E8\u00E9\u00EA\u00EB]/g,"e");
        	str = str.replace(/[\u00EC\u00ED\u00EE\u00EF]/g,"i");
        	str = str.replace(/[\u00F2\u00F3\u00F4\u00F5\u00F8]/g,"o");
        	str = str.replace(/[\u00F9\u00FA\u00FB]/g,"u");
        	str = str.replace(/[\u00FD\u00FF]/g,"y");
        	str = str.replace(/[\u00F1]/g,"n");
        	str = str.replace(/[\u0153\u00F6]/g,"oe");
        	str = str.replace(/[\u00E6\u00E4]/g,"ae");
        	str = str.replace(/[\u00DF]/g,"ss");
        	str = str.replace(/[\u00FC]/g,"ue");
        	str = str.replace(/\s+/g,"-");
        	str = str.replace(/-+\/+-+/g,"-");
        	str = str.replace(/\-+/g,"-");
        	str = str.replace(/\/+/g,"-");
        	str = str.replace(/_+/g,"-");
        	str = str.replace(/^-+|-+$/g, "-");
        	str = str.replace(/^\/+|\/+$/g, "-");
        	str = str.replace(/^-+|-+$/g, "-");
			input.val(str);
		});
	});
	$('input[name^="article_alias"]').blur(function() {
    	var $current = $(this);
    	$('input[name^="article_alias"]').each(function() {
        	if ($(this).val() == $current.val() && $(this).attr('class') != $current.attr('class'))
        	{
				alert('Esta url j\341 est\341 sendo utilizada.')
            	$current.val($current.val()+'-1')
        	}
    	});
  	});
	$('input[type="checkbox"]').each(function(){
		var nome = $(this).attr('id')
		if ($('#'+nome).is(':checked')){$('#'+nome).attr('checked');$('.'+nome).show();}else{$('#'+nome).removeAttr('checked');$('.'+nome).hide();}
		$(this).click(function(){
			var nome = $(this).attr('id')
			if ($('#'+nome).is(':checked')){$('#'+nome).attr('checked');$('.'+nome).show();}else{$('#'+nome).removeAttr('checked');$('.'+nome).hide();}
		});
	});
	(function() {
	var $body = document.body
	, $menu_trigger = $body.getElementsByClassName('menu-trigger')[0];

	if (typeof $menu_trigger !== 'undefined') {
		$menu_trigger.addEventListener('click', function() {
			$body.className = ( $body.className == 'menu-active' )? '' : 'menu-active';
			if (document.body.className == 'menu-active'){
				var margem = $('.content-total').attr('margin-left')
				$('.content-total').text(margem)}
		});
	}

}).call(this);
});