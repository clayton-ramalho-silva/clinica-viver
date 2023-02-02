function goBack() {
    window.history.back();
}

// === CIDADES -- Busca a cidade dependendo do estado (pontos) ===
function buscarCidadesLista(estado, cidade){
	$.ajax({
		type:"POST",
		url:"include/inc_module/mod_shop/ajax.php",
		datatype:"html",
		data:'estadoSel='+estado+'&cidadeSel='+cidade,
		cache:false,
		success: function(data){
			$('#frete-cidade').html(data);
		}
   	});
}

$().ready(function(e) {

    $('#be_main_content').find('div.lista-resultado').each(function() {
        var botao = $(this).find('button');
		var menu = $(this).find('div.opcoes-lista');
		$(botao).click(function(){
			$('.opcoes-lista').removeClass('visivel').hide(200);
			if($(this).hasClass('ativo')){
				$(this).removeClass('ativo');
				$(menu).removeClass('visivel').hide(200);
				$('div.lista-resultado button').removeClass('ativo');
			} else {
				$('div.lista-resultado button').removeClass('ativo');
				$(this).addClass('ativo');
				$(menu).addClass('visivel').show(200);
			}
		});
    });
	
	$('#be_main_content').find('div.lista-holerites').each(function() {
        var botao = $(this).find('button');
		var menu = $(this).find('div.opcoes-lista');
		$(botao).click(function(){
			$('.opcoes-lista').removeClass('visivel').hide(200);
			if($(this).hasClass('ativo')){
				$(this).removeClass('ativo');
				$(menu).removeClass('visivel').hide(200);
				$('div.lista-holerites button').removeClass('ativo');
			} else {
				$('div.lista-holerites button').removeClass('ativo');
				$(this).addClass('ativo');
				$(menu).addClass('visivel').show(200);
			}
		});
    });
	
	$('#be_main_content').find('div.lista-arquivos').each(function() {
        var botao = $(this).find('button');
		var menu = $(this).find('div.opcoes-lista');
		var down = $(this).find('a.bt-download');
		$(botao).click(function(){
			$('.opcoes-lista').removeClass('visivel').hide(200);
			if($(this).hasClass('ativo')){
				$(this).removeClass('ativo');
				$(menu).removeClass('visivel').hide(200);
				$('div.lista-arquivos button').removeClass('ativo');
			} else {
				$('div.lista-arquivos button').removeClass('ativo');
				$(this).addClass('ativo');
				$(menu).addClass('visivel').show(200);
			}
		});
		$(down).click(function(){
			$('.opcoes-lista').removeClass('visivel').hide(200);
			$('div.lista-arquivos button').removeClass('ativo');
		});
    });
	
	$('a.bt-menu').click(function(){
		$('.opcoes-menu').removeClass('visivel').hide(200);
		if($(this).hasClass('ativo')){
			$(this).removeClass('ativo');
			$('div.opcoes-menu').removeClass('visivel').hide(200);
			$('div.menu-topo a.bt-menu').removeClass('ativo');
		} else {
			$('div.menu-topo a.bt-menu').removeClass('ativo');
			$(this).addClass('ativo');
			$('div.opcoes-menu').addClass('visivel').show(200);
		}
	});
	
	
	$('div.lista-pedidos').find('div.lista-resultado').each(function(index, element) {
        var status = $(this).find('#status-pedido');
		var id = $(this).find('#id-pedido').val();
		var div = $(this);
		$(status).change(function(e){
			$id = id;
			$status = $(this).val();
			$.ajax({
				type: "POST",
				cache: false,
				url: "include/inc_module/mod_shop/ajax.php",
				data: "id="+$id+"&status="+$status,
				success: function(data) {
					$(div).css('background','#CAF3DE').css('color','#fff !important');
					setTimeout(function () {$(div).removeAttr('style')}, 2000);
				},
			});
		});
    });
	
	// Mostrar / Escoder Filtros
	$('div.tit').find('i.bt-filtro').click(function(){
		if($('div.tit').hasClass('filtro-aberto')){
			$('div.tit').removeClass('filtro-aberto');
		} else {
			$('div.tit').addClass('filtro-aberto');
		}
	});
	
	/* ===== Página de Produtos ===== */
	
	// Ativar / Desativar produto
	$('div.content-modulo-shop').find('div.colunas-produtos').each(function(){
		var botao = $(this).find('img.ico-produto');
		var inputStatus = $(this).find('#status-produto');
		var id = $(this).find('#id-produto').val();
		var img = $(this).find('.ico-produto');
		$(botao).click(function(){
			var status = $(inputStatus).val();
			if(status == 1){msg = 'desativar';} else {msg = 'ativar';}
			var teste = confirm('Deseja '+msg+' este produto?');
			if(teste){
				$.ajax({
					type: "POST",
					cache: false,
					dataType: "json",
					url: "include/inc_module/mod_shop/ajax.php",
					data: "idAtivo="+id+"&statusAtivo="+status,
					success: function(data) {
						$(botao).attr('src',data['img']);
						$(inputStatus).val(data['status'])
						alert('Status alterado com sucesso')
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
				});
			} else {
				return false;
			}
		})
	})
			
	
	/* ===== Informações do pedido ===== */	
	
	// Tabs de informações do Cliente
	$('div.tabs-dados-clientes i').click(function(){
		var icone = $('div.tabs-dados-clientes i');
		var tab = $('div.tabs-dados-clientes');
		var dados = $('div.content-dados-clientes');
		if (tab.hasClass('abrir')){
   			tab.removeClass('abrir');
			dados.slideUp();
			setTimeout(function(){icone.removeClass('ativo');}, 150);
   		} else {     
    		tab.addClass('abrir');
			dados.slideDown();
			setTimeout(function(){icone.addClass('ativo');}, 150);
   		}
  	});
	
	// Tabs de E-mails
	$('div.lista-tabs-emails').find('div.tabs-emails').each(function(){
		var tab = $(this);
		var botao = tab.find('div.botao-tabs-email');
		var conteudo = tab.find('div.content-tabs-email');
		var icone = tab.find('div.botao-tabs-email i');
		botao.click(function(){
			if (tab.hasClass('abrir-tabs')){
				tab.removeClass('abrir-tabs');
				conteudo.slideUp();
				setTimeout(function(){icone.addClass('ativo');}, 100);
			} else {     
				tab.addClass('abrir-tabs');
				conteudo.slideDown();
				setTimeout(function(){icone.addClass('ativo');}, 100);
			}
		});
  	});
	
	// Altera o status do pedido
	$('div.box-info-pedido #status-pedido').change(function(e){
		$id = $('#id-pedido').val();
		$status = $(this).val();
		$.ajax({
			type: "POST",
			cache: false,
			url: "include/inc_module/mod_shop/ajax.php",
			data: "id="+$id+"&status="+$status,
			success: function(data) {
				$('div.box-info-pedido i').fadeIn(300);
				setTimeout(function () {$('div.box-info-pedido i').addClass('atualizado');}, 1200);
				setTimeout(function () {$('div.box-info-pedido i').fadeOut(300);}, 4000);
				setTimeout(function () {$('div.box-info-pedido i').removeAttr('class');}, 4200);
			},
		});
	});
	
	/* =============== Funções da página de Filtro de Moeda =============== */
	/* Configurações de envio do formulário */
	$('#form-relatorio-moeda').submit(function(z){
		var inicial = $('#inicio').val();
		var final = $('#final').val();
		var div = $('div.relatorio-moedas');
		$.ajax({
			type: "POST",
			url: "include/inc_module/mod_system/ajax.php",
			data: "filtroinicio="+inicial+"&filtrofinal="+final,
			cache: false,
			success: function(data){
				if(div.is(':visible')){
					div.slideUp(400);
					setTimeout(function(){div.html(data);}, 400);
					setTimeout(function(){div.slideDown(400);}, 500);
				} else {
					div.html(data);
					div.slideDown(400);
				}
			}
		});
		z.preventDefault ? z.preventDefault() : z.returnValue = false;
	})
	
	/* =============== Funções da página de Categorias =============== */
	
	// Ativar / Desativar Categoria
	$('div.content-modulo-shop').find('div.colunas-categorias').each(function(){
		var botao = $(this).find('img.ico-categorias');
		var inputStatus = $(this).find('#status-categoria');
		var id = $(this).find('#id-categoria').val();
		var img = $(this).find('.ico-categoria');
		var tipo = $(this).find('#tipo-categoria').val();
		$(botao).click(function(){
			var status = $(inputStatus).val();
			if(status == 1){msg = 'desativar';} else {msg = 'ativar';}
			var teste = confirm('Deseja '+msg+' esta categoria?');
			if(teste){
				$.ajax({
					type: "POST",
					cache: false,
					dataType: "json",
					url: "include/inc_module/mod_shop/ajax.php",
					data: "idCatAtivo="+id+"&statusCatAtivo="+status+"&tipoCatAtivo="+tipo,
					success: function(data) {
						$(botao).attr('src',data['img']);
						$(inputStatus).val(data['status']);
						alert('Status alterado com sucesso');
					},
				});
			} else {
				return false;
			}
		})
	})
	
	/* =============== Funções da página de Usuários =============== */
	
	// Ativar / Desativar Usuários
	$('div.content-modulo-shop').find('.colunas-usuarios').each(function(){
		var botao = $(this).find('img.ico-usuarios');
		var inputStatus = $(this).find('#status-user');
		var id = $(this).find('#id-user').val();
		var img = $(this).find('.ico-usuarios');
		$(botao).click(function(){
			var status = $(inputStatus).val()
			if(status == 1){msg = 'desativar';} else {msg = 'ativar';}
			var teste = confirm('Deseja '+msg+' este usuário?');
			if(teste){
				$.ajax({
					type: "POST",
					cache: false,
					dataType: "json",
					url: "include/inc_module/mod_shop/ajax.php",
					data: "idUserAtivo="+id+"&statusUserAtivo="+status,
					success: function(data) {
						$(botao).attr('src',data['img']);
						$(inputStatus).val(data['status']);
						alert('Status alterado com sucesso');
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
				});
			} else {
				return false;
			}
		});
	});
	
	/* =============== Funções da página de fretes =============== */
	
	// Busca a lista de cidades ao alterar o estado
	$('#frete-estado').change(function(){
		var sel = $(this).val();
		buscarCidadesLista(sel);
	});
	
});