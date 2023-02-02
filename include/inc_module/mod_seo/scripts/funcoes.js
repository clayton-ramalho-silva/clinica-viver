$().ready(function(e) {

    // Menu lateral
    $('.menu-trigger').on('click', function(){

        if($('body').hasClass('menu-active')){
            $('body').removeAttr('class');
        } else {
            $('body').addClass('menu-active');
        }

    });

    // Envio de informações
	$(".accordion form").each(function() {

        var numero = $(this).attr("id");

		$(this).on('submit', function(e){

			var form = $(this).serialize();

                $("#"+numero+" .mensagem").fadeIn(250).text('Salvando...').addClass('salvando').removeClass('salvo');

            $.post("salvar.php", {
                form: form
            }, function(data){

                $("#"+numero+" .mensagem").text(data).removeClass('salvando').addClass('salvo');

                setTimeout(function () {

                    $("#"+numero+" .mensagem").fadeOut(350, (function(){
                        $("#"+numero+" .mensagem").text('').removeClass('salvo');
                    }));

                }, 1000);

            });

           e.preventDefault ? e.preventDefault() : e.returnValue = false;

        });

    });


    $("#select").on('change', function(){
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

        	if ($(this).val() == $current.val() && $(this).attr('class') != $current.attr('class')){

				alert('Esta url j\341 est\341 sendo utilizada.')
                $current.val($current.val()+'-1')

            }

        });

      });

	$('input[type="checkbox"]').each(function(){

        var nome = $(this).attr('id');

        if ($('#'+nome).is(':checked')){
            $('#'+nome).attr('checked');
            $('.'+nome).show();
        } else {
            $('#'+nome).removeAttr('checked');
            $('.'+nome).hide();
        }

		$(this).click(function(){
			var nome = $(this).attr('id')
			if ($('#'+nome).is(':checked')){$('#'+nome).attr('checked');$('.'+nome).show();}else{$('#'+nome).removeAttr('checked');$('.'+nome).hide();}
        });

    });

});