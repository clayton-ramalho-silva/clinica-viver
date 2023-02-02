<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('config/phpwcms/conf.inc.php');
include(PHPWCMS_ROOT.'/include/inc_module/mod_menu/funcoes.php');
include(PHPWCMS_ROOT.'/include/inc_lib/admin.functions.inc.php');

// Home escondido
$home     = getConfig($conexao, $prepend, 'homeMenu') === '1'     ? ' checked' : '';
$noticias = getConfig($conexao, $prepend, 'noticiasMenu') === '1' ? ' checked' : '';

?>

<link href="include/inc_module/mod_menu/template/css/menu.css" rel="stylesheet" type="text/css"/>
<link href="include/inc_module/mod_menu/template/css/modal.css" rel="stylesheet" type="text/css"/>
<!-- <link href="include/inc_module/mod_menu/template/css/scroll.css" rel="stylesheet" type="text/css"/> -->
<link href="include/inc_css/fontawesome/all.css" rel="stylesheet">

<script type="text/javascript" src="include/inc_module/mod_dados/scripts/jquery-1.11.1.min.js"></script>
<script src="include/inc_module/mod_menu/js/jquery.colorbox.js" type="text/javascript"></script>
<!-- <script src="include/inc_module/mod_menu/js/jquery.mCustomScrollbar.concat.min.js" type="text/javascript"></script> -->

<h1 class="title">Gerenciar Menu do Site</h1>

<span>Arraste os item que deseja listar no menu e depois clique em Salvar</span>

<div class="cf nestable-lists">

    <div class="dd" id="nestable">

        <h2>Páginas no Menu</h2>
        <ol class="dd-list">

            <?php
            include(PHPWCMS_ROOT.'/include/inc_tmpl/article.menulist.tmpl.php');
            ?>

        </ol>
        <input type="hidden" name="paginas-menu" id="paginas-menu">

    </div>

    <div class="dd" id="nestable2">

        <h2>Páginas do Site</h2>

        <?php
        include(PHPWCMS_ROOT.'/include/inc_tmpl/article.pagelist.tmpl.php');
        ?>
        <input type="hidden" name="paginas-site" id="paginas-site">

    </div>

</div>

<div class="links-controle">

    <a class="bt-atualizar-menu">Salvar Alterações</a>

    <p>
        <label><input type="checkbox" name="menu-home" id="menu-home" value="1"<?= $home ?>>Esconder Link Home</label>
    </p>
<!--    <p>
        <label><input type="checkbox" name="menu-noticias" id="menu-noticias" value="1"<?= $noticias ?>>Mostrar Notícias</label>
    </p>-->
</div>

<!--
<div class="tdbottom5">
    <input name="acat_sort_temp" type="hidden" value="10">
    <input name="acat_struct" type="hidden" id="acat_struct" value="0">
    <input name="acat_new" type="hidden" id="acat_new" value="0">
    <input name="acat_id" type="hidden" id="acat_id" value="4">
    <input name="submit" type="submit" class="button10" value="Atualizar">
    &nbsp;
    <input name="donotsubmit" type="button" class="button10" value="Cancelar" onclick="location.href = 'phpwcms.php?do=admin&amp;p=6';">
</div>
-->

<!--<div class="link-exemplo">
    <a target="_blank" href="https://www.jqueryscript.net/demo/Mobile-Compatible-jQuery-Drag-Drop-Plugin-Nestable/">link de exemplo</a>
</div>-->

<script src="include/inc_module/mod_menu/js/jquery.nestable.js" type="text/javascript"></script>
<script src="include/inc_module/mod_menu/js/funcoes.js" type="text/javascript"></script>

<div style="display: none">
    <div id="detalhes-pagina">
        <p><input type="text" placeholder="Link externo"></p>
        <p><input type="checkbox">Sem link</p>
    </div>
</div>