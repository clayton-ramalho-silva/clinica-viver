$().ready(function(e) {
	$('#form').change(function(){
		var valor = $('#form option:selected').attr('id');
		if (valor == 'form-padrao'){
			$('.campos-padrao').css('display','block');
		}
		else {
			$('.campos-padrao').css('display','none');
		}
	});
});