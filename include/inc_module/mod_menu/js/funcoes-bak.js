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

    var menuUpdate = function (e){

        var list = e.length ? e : $(e.target),
            data = JSON.stringify(list.nestable('serialize'));

        if (window.JSON) {

            $('#paginas-menu').val(data);
            /*
            $.post("include/inc_module/mod_menu/ajax.php", {dataMenu:data}, function(data, status){

                if(data === '1'){
                    systemMsg('Menu atualizado com sucesso',1);
                } else {
                    systemMsg('Não foi possível atualizar o menu. Por favor tente novamente.',2);
                }

            });
            */

        }

    },
    pagesUpdate = function (e){

        var list = e.length ? e : $(e.target),
            data = JSON.stringify(list.nestable('serialize'));

        if (window.JSON) {

            /*
            $.post("include/inc_module/mod_menu/ajax.php", {dataPages:data}, function(data, status){

                if(data === '1'){
                    systemMsg('Menu atualizado com sucesso',1);
                } else {
                    systemMsg('Não foi possível atualizar o menu. Por favor tente novamente.',2);
                }

            })
            */
           $('#paginas-site').val(data);

        }

    },
    updateOutput = function(e){

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
    }).on('change', menuUpdate);

    // activate Nestable for list 2
    $('#nestable2').nestable({
        group: 1,
        maxDepth: 1
    }).on('change', pagesUpdate);

    /*
    $('#nestable-menu').on('click', function (e){
        var target = $(e.target),
            action = target.data('action');

        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });
    */

    $('#menu-home').on('change', function(){

        var data = $(this).is(':checked') ? '1' : '2';

        $.post("include/inc_module/mod_menu/ajax.php", {homeMenu:data}, function(data, status){
            systemMsg('Opção atualizada com sucesso',1);
        });

    });

    $('#menu-noticias').on('change', function(){

        var data = $(this).is(':checked') ? '1' : '2';

        $.post("include/inc_module/mod_menu/ajax.php", {noticiasMenu:data}, function(data, status){
            systemMsg('Opção atualizada com sucesso',1);
        });

    })

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

        setTimeout(() => {

            var pages = $('#paginas-site').val(),
                menu  = $('#paginas-menu').val();

            $.post("include/inc_module/mod_menu/ajax.php", {dataPages:pages, dataMenu:menu}, function(data, status){

                if(data === '11'){
                    systemMsg('Menu atualizado com sucesso',1);
                } else {
                    systemMsg('Não foi possível atualizar o menu. Por favor tente novamente.',2);
                }

            })

        }, 1000);

    });

    updateOutput($('#nestable').data('output', $('#paginas-menu')));
    updateOutput($('#nestable2').data('output', $('#paginas-site')));

});