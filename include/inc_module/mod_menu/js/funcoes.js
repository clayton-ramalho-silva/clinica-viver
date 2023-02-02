// Mensagens do sistema
function systemMsg(msg, type){

    var num    = Math.floor((Math.random() * 100000000) + 10000000);
    var classe = (type === 1) ? 'msg-sucesso'  : 'msg-erro';
    var icon   = (type === 1) ? 'check' : 'times';
    var base   = ($('.sistem-message').length > 0) ? 500 : 0;

    if(($('.sistem-message').length > 0)){
        $('.sistem-message').css('top','-60px');
        setTimeout(function(){
            $('.sistem-message').remove();
        },470);
    }

    setTimeout(function(){
        $('html').append('<div class="msg'+num+' sistem-message '+classe+'"><i class="fas fa-'+icon+'"></i><span>'+msg+'</span></div>');
    },0 + base);
    setTimeout(function(){
        $('.msg'+num+'').css('top','0');
    },150 + base);
    setTimeout(function(){
        $('.msg'+num+'').remove();
    },7000 + base);

}

$(document).ready(function (){

    var updateOutput = function(e){

        var list   = e.length ? e : $(e.target),
            output = list.data('output');

            if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        }

    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1,
        maxDepth: 3
    });

    // activate Nestable for list 2
    $('#nestable2').nestable({
        group: 1,
        maxDepth: 1
    });

    $(".modal").colorbox({
        iframe:true,
        width:"80%",
        height:"80%",
        onClosed:function(){
            window.location.reload(false);
        }
    });

    $('a.bt-atualizar-menu').on('click', function(){

        updateOutput($('#nestable').data('output', $('#paginas-menu')));
        updateOutput($('#nestable2').data('output', $('#paginas-site')));

        setTimeout(function(){

            var pages = $('#paginas-site').val(),
                menu  = $('#paginas-menu').val();

            $.post("include/inc_module/mod_menu/ajax.php", {dataPages:pages, dataMenu:menu}, function(data, status){

                if(data === '11'){
                    systemMsg('Menu atualizado com sucesso',1);
                } else {
                    systemMsg('Não foi possível atualizar o menu. Por favor tente novamente.',2);
                }

            })

        }, 300);

    });

    updateOutput($('#nestable').data('output', $('#paginas-menu')));
    updateOutput($('#nestable2').data('output', $('#paginas-site')));

});