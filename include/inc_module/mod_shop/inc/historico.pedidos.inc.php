<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2014, Oliver Georgi
 * @license http://opensource.org/licenses/GPL-2.0 GNU GPL-2
 * @link http://www.phpwcms.de
 *
 * */
// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
    die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------
// ================================================ CONFIGURAÇÕES GERAIS ===============================================
// Conexão com o banco de dados
require_once ('include/inc_lib/dbcon.inc.php');
require_once ('include/inc_lib/general.inc.php');
require_once ('include/inc_module/mod_shop/inc/funcoes.inc.php');
$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);

// Pega o ID do usuário
$num_user = $_SESSION[session_id() . '_userdata']['id'];

// URL para os links do paginate
$url = 'index.php?aid=' . $GLOBALS['content']['article_id'];

// Checa se a opção "Esconder preço" esta ativada
$preco = _getConfig('shop_pref_preco');

// Configurações do paginate
$rows = $SHOP['itensPedidos'];
$pagina = (int) mysqli_real_escape_string($conexao, $_GET['pg']);
$range = 2;

// Muda as classes caso não haja Forma de Pagamento
if ($preco != '1') {
    $col_data = 'col25';
    $col_status = 'col30';
    $col_detalhes = 'col25';
} else {
    $col_data = 'col25';
    $col_status = 'col30';
    $col_detalhes = 'col25';
}



// ============================================== FUNÇÃO DE REFAZER PEDIDO =============================================

if (isset($_POST['shop_prod_info'])) {

    $a = array_chunk($_POST['shop_prod_info'], 4);
    var_dump($_POST['shop_prod_info']);

    foreach ($a as $value) {

        $prod_id = $value[0];
        $prod_action = $value[1];
        $prod_amount = $value[2];
        $prod_valido = $value[3];

        if (isset($prod_action) && $prod_action == 'add' && $prod_valido == '1') {
            $shop_prod_id = intval($prod_id);
            $shop_prod_amount = abs(intval($prod_amount));
            if (empty($shop_prod_id)) {
                break; // leave
            }
            // add product to shopping
            if (isset($_SESSION[CART_KEY]['products'][$shop_prod_id])) {
                $_SESSION[CART_KEY]['products'][$shop_prod_id] += $shop_prod_amount;
            } else {
                $_SESSION[CART_KEY]['products'][$shop_prod_id] = $shop_prod_amount;
            }
        }
    }

    $url = explode('/', $_SERVER['REQUEST_URI']);

    header('Location: aid=3.html?shop_cart=show');
}



// =====================================================================================================================
// =============================================== HISTÓRICO DE PEDIDOS ================================================
// =====================================================================================================================
// Busca os pedidos no banco de dados
$sql = "SELECT order_id, order_number, order_date, order_name, order_firstname,
        order_email, order_net, order_gross, order_payment, order_data,
        order_status, order_user_id, order_pagseguro
        FROM phpwcms_shop_orders
        WHERE order_user_id = " . $num_user;

// Primeira parte do paginate
list($paginate, $totalpaginas, $paginaatual, $numerorows) = paginateShop($sql, $rows, $pagina, ' ORDER BY order_id DESC LIMIT ', $conexao, $GLOBALS['content']["article_id"], $itensHome);
$listaPaginate = mysqli_query($conexao, $paginate);
?>

<style>
    .select-reenviar{display:none}
    .refazer-pedido #shop_cart_add{display:none}
</style>


[JS]js/remodal.js[/JS]
[JS]js/jquery.mCustomScrollbar.concat.min.js[/JS]
[JS]
<script type="text/javascript">
    $(document).ready(function () {

        $('a.reenviar-pedido').on('click', function () {

            var div = $(this).parents('.remodal');
            var sel = $(div).find('.select-reenviar');
            var enviar = $(div).find('#shop_cart_add');

            $(sel).fadeIn(400);
            $(enviar).fadeIn(400);

        });

        $(document).find(".lista-produtos-final").each(function () {

            var check = $(this).find("#select-selecionar");
            var hidden = $(this).find("#select-selecionar-hidden");

            $(check).click(function () {

                if ($(this).is(":checked")) {

                    $(hidden).attr("disabled", "disabled");

                } else {

                    $(hidden).removeAttr("disabled");

                }
            });

        });

    });

    $(document).ready(function () {

        $('.item-historico').click(function () {

            $('.item-historico').removeClass('on');
            $('.content-produto-historico').slideUp('fast');
            if ($(this).next().is(':hidden') == true) {
                $(this).addClass('on');
                $(this).next().slideDown('fast');
            }
        });

        $('.content-produto-historico').hide();
    });

</script>
[/JS]
<div class="topo-historico">
    <h3>Pedidos</h3>

    <span>
        <a href="index.php?aid=7">Meus Pedidos</a>
        <a href="index.php?aid=8">Meu Perfil</a>
    </span>
</div>
<?php
if ($numerorows > 0) {

    while ($row = mysqli_fetch_array($listaPaginate)) {

        $data = date('d/m/Y', strtotime($row['order_date']));
        $info = unserialize($row['order_data']);
        $cartao = (!empty($info['cartao'])) ? '<br />' . $info['cartao'] : '';
        $valPedido = 0;
        $status = statusCliente($row['order_status']);
        ?>




        <div class="item-historico">
            <span><i class="fas fa-angle-down"></i> Pedido: <b><?= $row['order_number'] ?></b></span>
            <span>Valor Total: <b>R$ <?= number_format($valPedido, 2, ',', '.'); ?></b></span>
            <span>Data do Pedido: <b><?= $data ?></b></span>
            <!--
            <h3 title="<?= $status; ?>"><b>Pedido</b> <?= $status; ?></h3>
            <span>nº pedido: <b><?= $row['order_number'] ?></b> data - <b><?= $data ?></b></span>
            <a href="javascript:void(0)" data-remodal-target="modal<?= $row['order_id']; ?>">Detalhes</a>
            -->
        </div>


        <div class="content-produto-historico" data-remodal-id="modal<?= $row['order_id']; ?>">




                            <!--<h3>Detalhes do Pedido <?= $row['order_number'] ?></h3>-->


            <form action="" method="post" id="novo-pedido">

                <!--                <ul class="topo-tabela confirmar-dados">
                                    <li class="lista-produto fl">Produto</li>
                                    <li>Quantidade</li>
                                    <li>Valor Unid.</li>
                                    <li>Total</li>
                                </ul>-->

                <section>

                    <?php
                    foreach ($info['cart'] as $prod) {

                        $x++;

                        $calculo = $prod['shopprod_price'] * $prod['shopprod_quantity'];
                        $valPedido += $calculo;
                        $valPreco = number_format($prod['shopprod_price'], 2, ',', '.');
                        $valTotal = number_format($calculo, 2, ',', '.');
                        $infoImg = unserialize($prod['shopprod_var']);

                        $sepProd = ($prod['shopprod_size'] || $prod['shopprod_color'] || $prod['shopprod_other']) ? '<br>' : '';
                        $sepCor = $prod['shopprod_size'] && $prod['shopprod_color'] ? ' | ' : '';
                        $sepOutro = $prod['shopprod_size'] && $prod['shopprod_other'] ? ' | ' : '';
                        $sepOutro = $prod['shopprod_color'] && $prod['shopprod_other'] ? ' | ' : '';

                        $tamanho = $prod['shopprod_size'] ? 'Tamanho: ' . $prod['shopprod_size'] . '  ' : '';
                        $cor = $prod['shopprod_color'] ? '' . $sepCor . 'Cor: ' . $prod['shopprod_color'] . ' ' : '';
                        $outro = $prod['shopprod_other'] ? '' . $sepOutro . 'Outro: ' . $prod['shopprod_other'] . '' : '';

                        $dadosImagem = array(
                            'f_id' => $infoImg['images'][0]['f_id'],
                            'f_name' => $infoImg['images'][0]['f_name'],
                            'f_hash' => $infoImg['images'][0]['f_hash'],
                            'f_ext' => $infoImg['images'][0]['f_ext'],
                            'caption' => ''
                        );
                        $imagemProd = historicoImg($dadosImagem, 1, $infoImg['images'][0]['f_name'], 165);
                        ?>

                        <div class="item-produto-historico">
                            <figure><?= $imagemProd ?></figure>
                            <span>
                                <p><?= $prod['shopprod_name1']; ?></p>

                                <p class="codigo-item-produto-historico"><?= $prod['shopprod_ordernumber']; ?></p>

                                <p class="preco-item-produto-historico">
                                    Quantidade: <?= $prod['shopprod_quantity'] ?> - R$ <?= $valPreco ?>
                                </p>

                                <p>
                                    <?= $tamanho . $cor . $outro; ?>
                                </p>

                            </span>
                        </div>

                        <!--                        <ul class="lista-produtos-final confirmar-dados fl">
                        
                                                    <li class="fl">
                                                        <div class="select-reenviar">
                                                            <input type="hidden" name="shop_prod_info[]" value="<?= $prod['shopprod_id'] ?>">
                                                            <input type="hidden" name="shop_prod_info[]" value="add">
                                                            <input type="hidden" name="shop_prod_info[]" value="<?= $prod['shopprod_quantity'] ?>">
                                                            <label><input type="checkbox" name="shop_prod_info[]" id="select-selecionar" value="1" /></label>
                                                            <input type="hidden" name="shop_prod_info[]" id="select-selecionar-hidden" value="0" />
                                                        </div>
                        
                                                        <strong class="img-finalizar"><?= $imagemProd ?></strong><?= $prod['shopprod_name1']; ?>
                                                        <span>(Cód.<?= $prod['shopprod_ordernumber']; ?>)</span>
                        <?= $tamanho . $cor . $outro; ?>
                                                    </li>
                                                    <li class="lista-valor">
                                                        <b>Qtd:</b><?= $prod['shopprod_quantity'] ?>
                                                    </li>
                                                    <li class="lista-valor">
                                                        <b>Valor Unid.</b>R$ <?= $valPreco ?>
                                                    </li>
                                                    <li class="lista-valor">
                                                        <b>Total</b>R$ <?= $valTotal ?>
                                                    </li>
                        
                                                </ul>-->

                        <?php
                    }
                    ?>
                </section>

                                                <!--<div class="valor-total-final">Valor Total: <span>R$ <?= number_format($valPedido, 2, ',', '.'); ?></span></div>-->

                <!--                <div class="refazer-pedido fl">
                                    <a class="reenviar-pedido" href="javascript:void(0)">Reenviar Pedido</a>
                                    <input type="submit" name="shop_cart_add" id="shop_cart_add" value="Adicionar ao Carrinho" />
                                </div>-->

            </form>

        </div>

        <?php
    }

    if ($totalpaginas > 1) {
        ?>

        <div class="paginacao">

            <div class="article_paginate_navi fr">

                <div class="cb"></div>
                <div class="ul-paginate">
                    <div class="apn_navi">

                        <?php
                        if ($paginaatual > 1) {
                            $prevpage = $paginaatual - 1;
                            echo "<a class='apn_prev' href='" . $url . "&pg=1' title='Primeira página'>««</a>";
                            echo "<a class='apn_prev' href='" . $url . "&pg=" . $prevpage . "' title='Página anterior'>«</a> ";
                        }

                        for ($x = ($paginaatual - $range); $x < (($paginaatual + $range) + 1); $x++) {
                            if (($x > 0) && ($x <= $totalpaginas)) {
                                echo ($x == $paginaatual) ? "<span>$x</span> " : "<a href='" . $url . "&pg=$x'>$x</a> ";
                            }
                        }

                        if ($paginaatual != $totalpaginas) {
                            $nextpage = $paginaatual + 1;
                            echo "<a class='apn_next' href='" . $url . "&pg=" . $nextpage . "' title='Próxima página'>»</a>";
                            echo "<a class='apn_next' href='" . $url . "&pg=" . $totalpaginas . "' title='Última página'>»»</a>";
                        }
                        ?>

                    </div>
                </div>

            </div>

        </div>
        <?php
    }
} else {
    ?>

    <p class="sem-pedidos">Não há nenhum pedido cadastrado</p>

    <?php
}
?>