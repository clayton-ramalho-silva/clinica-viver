$.abasSimples = function ()
	{
    	var abas = 'p#abas';
    	var conteudos = 'ul#conteudos';
    	$(conteudos + '> li').hide();
    	$(conteudos + '> li:first-child').show();
    	$(abas + ' a').click(function()
    {
    	$(abas + ' a').removeClass('selected');
    	$(this).addClass('selected');
    	$(conteudos + '> li').hide();
    	$(conteudos +  ' ' + $(this).attr('href')).show();
    	return false;
    }); 
};
$(document).ready(function(){$.abasSimples();});
