<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2013, Oliver Georgi
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
// Conexão com o banco de dados
require_once ('include/inc_lib/default.inc.php');
$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);

// Busca as informações no banco de dados
$sqlDados = 'SELECT dados_classe_fone, dados_segundo_endereco, dados_mapa1,
             dados_mapa2, dados_empresa, dados_fone, dados_fone_checkbox,
             dados_whatsapp, dados_msg_whatsapp, dados_redes, dados_emails,
             dados_endereco, dados_endereco2, dados_rodape, dados_meta,
             dados_analytics, dados_webmaster, dados_campo_adicional1,
             dados_campo_adicional2, dados_recaptcha, dados_cookies
             FROM '.DB_PREPEND.'phpwcms_dados';
$resDados = mysqli_query($conexao, $sqlDados);
$erroSql = (!$resDados) ? mysqli_error($conexao) : '';
$row = mysqli_fetch_array($resDados);

// Configurações gerais
$link = $phpwcms['modules'][$module]['dir'];
$modo = $dataAdmin['admin_config_modo'] ? $dataAdmin['admin_config_modo'] : 0;
$msgErro = '<div class="erro-sql">' . LF
        . '    <strong>ATENÇÃO!</strong><br>' . LF
        . '    Há um problema com a tabela de Dados da Empresa.<br>' . LF
        . '    <b>Erro:</b> ' . $erroSql . LF
        . '</div>';

// Carrega o CSS e os scripts
$BE['HEADER']['dados'] .= '<link href="' . $link . 'template/css/dados.css" rel="stylesheet" type="text/css" />';
$BE['HEADER']['dados'] .= '<script type="text/javascript" src="' . $link . 'scripts/jquery-1.11.1.min.js"></script>';
$BE['HEADER']['dados'] .= '<script type="text/javascript" src="' . $link . 'scripts/jquery.alphanum.js"></script>';
$BE['HEADER']['dados'] .= '<script type="text/javascript" src="' . $link . 'scripts/funcoes.js"></script>';
$BE['HEADER']['dados'] .= '<script type="text/javascript" src="' . $link . 'scripts/jquery.inputmask.bundle.js"></script>';


// ============================ INFORMAÇÕES DA EMPRESA ============================
// Valores de Telefones
$telefones     = explode(',', $row['dados_fone']);
$semTelefones  = array_filter($telefones);
$checkbox      = explode(',', $row['dados_fone_checkbox']);
$fone          = array_combine($checkbox, $telefones);

// Valores de Whatsapp
$whatsapp      = explode(',', $row['dados_whatsapp']);
$sem_whatsapp  = array_filter($whatsapp);
$checkWhatsapp = ($whatsapp[0] === '1') ? ' checked="checked"' : '';
$hideWhatsapp  = ($whatsapp[0] === '1') ? '' : ' style="display:none"';
$listaWhatsapp = $whatsapp;
$msgWhatsapp   = $row['dados_msg_whatsapp'];
array_shift($listaWhatsapp);

//Valores de Redes Sociais
$redes = explode(',', $row['dados_redes']);
$num_redes = count($redes);
$check_redes = array_slice($redes, 0, ($num_redes / 2));
$val_redes = array_slice($redes, ($num_redes / 2));

// Valores de E-mails
$emails = explode(',', $row['dados_emails']);
$num_emails = count($emails);
$check_emails = array_slice($emails, 0, ($num_emails / 2));
$val_emails = array_slice($emails, ($num_emails / 2));
$sem_emails = array_filter($val_emails);
$dados_emails = array_combine($check_emails, $val_emails);

// Valores de Endereço
$endereco = explode(',', $row['dados_endereco']);

// Valores do segundo endereço
$enderecoSeg = explode(',', $row['dados_endereco2']);

// Formulários do site
$sqlForms = 'SELECT article_title, article_id, acontent_form, acontent_id
             FROM '.DB_PREPEND.'phpwcms_articlecontent
             LEFT JOIN '.DB_PREPEND.'phpwcms_article
             ON acontent_aid = article_id
             WHERE acontent_type = 23
             AND acontent_trash = 0
             AND article_deleted = 0';
$resForms = mysqli_query($conexao, $sqlForms);
$numForms = mysqli_num_rows($resForms);

// reCAPTCHA
$recaptcha      = json_decode($row['dados_recaptcha'], true);
$checkRecaptcha = ($recaptcha['ativo'] === '1') ? ' checked="checked"' : '';
$hideRecaptcha  = ($recaptcha['ativo'] === '1') ? '' : ' style="display:none"';
$siteKey        = $recaptcha['site'];
$secretKey      = $recaptcha['secret'];

// Código do Analytics
$codigoAnalytics = str_replace('"', "'", $row['dados_analytics']);

// Cookies
$cookies      = unserialize($row['dados_cookies']);
$checkCookies = ($cookies['ativo'] === '1') ? ' checked="checked"' : '';

// Configuraçõoes de e-mail
$config    = array();
$info_conf = @file_get_contents($_SERVER['DOCUMENT_ROOT'].'/'.$phpwcms['root'].'config/phpwcms/conf.inc.php');
preg_match_all("/phpwcms\['SMTP_FROM_EMAIL'\]   = (.*?);/", $info_conf, $config['from']);
preg_match_all("/phpwcms\['SMTP_FROM_NAME'\]    = (.*?);/", $info_conf, $config['nome']);
preg_match_all("/phpwcms\['SMTP_HOST'\]         = (.*?);/", $info_conf, $config['host']);
preg_match_all("/phpwcms\['SMTP_PORT'\]         = (.*?);/", $info_conf, $config['porta']);
preg_match_all("/phpwcms\['SMTP_MAILER'\]       = (.*?);/", $info_conf, $config['modo']);
preg_match_all("/phpwcms\['SMTP_USER'\]         = (.*?);/", $info_conf, $config['usuario']);
preg_match_all("/phpwcms\['SMTP_PASS'\]         = (.*?);/", $info_conf, $config['senha']);
preg_match_all("/phpwcms\['SMTP_SECURE'\]       = (.*?);/", $info_conf, $config['seguro']);
preg_match_all("/phpwcms\['SMTP_AUTH'\]         = (.*?);/", $info_conf, $config['autenticacao']);

?>

<link href="include/inc_css/fontawesome/all.css" rel="stylesheet">

<h1 class="title">
    Informações da Empresa
    <!--<a class="lista-tags" href="javascript:void(0)">Lista de Tags</a>-->
</h1>

<?= (!$resDados) ? $msgErro : ''; ?>


<div class="tab-container">

    <ul class="tabs">
        <li class="tab-link" data-tab="tab-1">Dados da Empresa</li>
        <li class="tab-link" data-tab="tab-2">Telefones</li>
        <li class="tab-link" data-tab="tab-3">E-mails</li>
        <li class="tab-link" data-tab="tab-4">Redes Sociais</li>
        <li class="tab-link" data-tab="tab-5">Informações Extras</li>
        <li class="tab-link" data-tab="tab-6">reCAPTCHA</li>
        <li class="tab-link" data-tab="tab-7">Avançado</li>
        <li class="tab-link" data-tab="tab-8">Cookies</li>
        <li class="tab-link" data-tab="tab-9">Envio de E-mail</li>
    </ul>

    <form id="form-dados" method="post">

        <!-- PÁGINA 1 ========================================================== -->
        <div id="tab-1" class="tab-content">

            <!-- Nome da Empresa -->
            <div class="box-modulo box-nome">

                <p class="b1">
                    <b>Nome da Empresa</b>
                    <input type="text" name="nome-empresa" id="nome-empresa" value="<?= $row['dados_empresa'] ?>" />
                </p>

            </div>

            <div class="barra"></div>

            <div class="box-modulo modulo-endereco">

                <h2>Endereço da Empresa</h2>

                <p class="b2b">
                    <b>Rua</b>
                    <input type="text" name="endereco-empresa[]" id="rua-empresa" value="<?= $endereco[0] ?>" />
                </p>
                <p class="b4">
                    <b>Número</b>
                    <input type="text" name="endereco-empresa[]" id="num-empresa" value="<?= $endereco[1] ?>" />
                </p>
                <p class="b2b">
                    <b>Bairro</b>
                    <input type="text" name="endereco-empresa[]" id="bairro-empresa" value="<?= $endereco[2] ?>" />
                </p>

                <p class="b4">
                    <b>CEP</b>
                    <input type="text" name="endereco-empresa[]" id="cep-empresa" value="<?= $endereco[3] ?>" />
                </p>

                <p class="b2">
                    <b>Cidade</b>
                    <input type="text" name="endereco-empresa[]" id="cidade-empresa" value="<?= $endereco[4] ?>" />
                </p>

                <p class="b4">
                    <b>Estado</b>
                    <?= estados('endereco-empresa[]', 'uf-empresa', $endereco[5]) ?>
                </p>
                <p class="b4">
                    <b>Complemento</b>
                    <input type="text" name="endereco-empresa[]" id="comp-empresa" value="<?= $endereco[6] ?>" />
                </p>

                <div class="checkbox-mapa" id="ativar-mapa1"<?= ($row['dados_mapa1'] == 1) ? ' class="on"' : ''; ?>>
                    <label for="visualizar-mapa1">
                        <input type="checkbox" name="visualizar-mapa1" id="visualizar-mapa1" value=""<?= ($row['dados_mapa1'] == 1) ? ' checked="checked"' : ''; ?> />Esconder mapa
                    </label>
                </div>

                <div class="barra"></div>

                <div id="ativar-endereco"<?= ($row['dados_segundo_endereco'] == 1) ? ' class="on"' : ''; ?>>
                    <label for="novo-endereco">
                        <input type="checkbox" name="novo-endereco" id="novo-endereco" value=""<?= ($row['dados_segundo_endereco'] == 1) ? ' checked="checked"' : ''; ?> />Segundo Endereço
                    </label>
                </div>

                <div class="box-endereco segundo-endereco fl"<?= ($row['dados_segundo_endereco'] == 1) ? ' style="display:block"' : ''; ?>>

                    <p class="b2b">
                        <b>Rua</b>
                        <input type="text" name="endereco-empresa2[]" id="rua-empresa2" value="<?= $enderecoSeg[0] ?>" />
                    </p>
                    <p class="b4">
                        <b>Número</b>
                        <input type="text" name="endereco-empresa2[]" id="num-empresa2" value="<?= $enderecoSeg[1] ?>" />
                    </p>
                    <p class="b2b">
                        <b>Bairro</b>
                        <input type="text" name="endereco-empresa2[]" id="bairro-empresa2" value="<?= $enderecoSeg[2] ?>" />
                    </p>
                    <p class="b4">
                        <b>CEP</b>
                        <input type="text" name="endereco-empresa2[]" id="cep-empresa2" value="<?= $enderecoSeg[3] ?>" />
                    </p>
                    <p class="b2">
                        <b>Cidade</b>
                        <input type="text" name="endereco-empresa2[]" id="cidade-empresa2" value="<?= $enderecoSeg[4] ?>" />
                    </p>
                    <p class="b4">
                        <b>Estado</b>
                        <?= estados('endereco-empresa2[]', 'uf-empresa2', $enderecoSeg[5]) ?>
                    </p>
                    <p class="b4">
                        <b>Complemento</b>
                        <input type="text" name="endereco-empresa2[]" id="comp-empresa2" value="<?= $enderecoSeg[6] ?>" />
                    </p>

                    <div class="checkbox-mapa" id="ativar-mapa2"<?= ($row['dados_mapa2'] == 1) ? ' class="on"' : ''; ?>>
                        <label for="visualizar-mapa2">
                            <input type="checkbox" name="visualizar-mapa2" id="visualizar-mapa2" value=""<?= ($row['dados_mapa2'] == 1) ? ' checked="checked"' : ''; ?> />Esconder Mapa
                        </label>
                    </div>

                </div>

            </div>

        </div>


        <!-- PÁGINA 2 - TELEFONES E WHATSAPP =================================== -->
        <div id="tab-2" class="tab-content ">

            <!-- Telefones -->
            <div class="box-modulo box-telefones">

                <div class="box-telefone fl">

                    <h2>Telefones</h2>

                    <label><strong>Selecione os telefones principais</strong></label>

                    <p><button id="novo-telefone" name="novo-telefone">Novo Telefone</button></p>

                    <span>
                        <?php
                        if($row['dados_fone'] == '' || empty($semTelefones)){
                        ?>

                            <label>
                                <input type="checkbox" name="check_num_telefone[]" id="check_num_telefone1" value="check" />
                                <input type="text" name="num_telefone[]" id="num_telefone1" class="foneMask" value="" />
                            </label>
                            <label>
                                <input type="checkbox" name="check_num_telefone[]" id="check_num_telefone2" value="check" />
                                <input type="text" name="num_telefone[]" id="num_telefone2" class="foneMask" value="" />
                            </label>

                        <?
                        } else {

                            $i = 0;
                            foreach($fone as $key => $value){

                                $i++;
                                if($value === "") {
                                    continue;
                                } else {
                                    $check = (!preg_match("/a[0-9]+/", $key)) ? ' checked="checked"' : '';
                                    echo '<label>
                                    <input type="checkbox" name="check_num_telefone[]" id="check_num_telefone'.$i.'" value="check"'.$check.' />
                                    <input type="text" name="num_telefone[]" id="num_telefone'.$i.'" class="foneMask" value="'.$value.'" />
                                    </label>';
                                }

                            }

                        }
                        ?>
                    </span>

                </div>

                <div class="box-whatsapp">
                    <h2>WhatsApp</h2>
                    <label for="whatsapp">
                        <input name="whatsapp" id="whatsapp" type="checkbox" value="check"<?= $checkWhatsapp ?> />
                        <strong>Mostrar WhatsApp</strong>
                    </label>
                    <p>
                        <button id="novo-whatsapp" name="novo-whatsapp"<?= $hideWhatsapp ?>>Novo Whatsapp</button>
                    </p>

                    <span<?= $hideWhatsapp ?>>
                        <?php if ($row['dados_whatsapp'] == '' || empty($sem_whatsapp)) { ?>
                            <input type="text" name="num_whatsapp[]" id="num_whatsapp" class="foneMask" value="<?= $whatsapp[1]; ?>" />
                            <?php
                        } else {
                            $g = 0;
                            foreach ($listaWhatsapp as $value) {
                                $g++;
                                if ($value === "") {
                                    continue;
                                } else {
                                    echo '<label>
                            <input type="text" name="num_whatsapp[]" id="num_whatsapp' . $g . '" value="' . $value . '" class="foneMask" />
                        </label>';
                                }
                            }
                        }
                        ?>
                    </span>

                    <span class="msg-whatsapp">
                        <h4>Mensagem do Whatsapp</h4>
                        <input type="text" name="msg-whatsapp" id="msg-whatsapp" value="<?= $msgWhatsapp ?>" maxlength="250">
                    </span>

                </div>

            </div>

        </div>


        <!-- PÁGINA 3 - EMAILS ================================================= -->
        <div id="tab-3" class="tab-content">

            <div class="box-modulo box-emails">

                <h2>E-mails </h2>

                <p><strong>Selecione quais os e-mails principais</strong></p>

                <p><button id="novo-email" name="novo-email">Novo Email</button></p>

                <div class="lista-emails ">

                    <?php
                    if($row['dados_emails'] == '' || empty($sem_emails)){
                    ?>

                        <label>
                            <input type="checkbox" name="check_emails[]" id="check_emails1" value="check" />
                            <input type="text" name="emails[]" id="emails1" value="" />
                        </label>
                        <label>
                            <input type="checkbox" name="check_emails[]" id="check_emails2" value="check" />
                            <input type="text" name="emails[]" id="emails2" value="" />
                        </label>

                    <?php
                    } else {

                        $i = 0;
                        foreach($dados_emails as $key => $value){

                            $i++;
                            if($value == "") {
                                continue;
                            } else {
                                $check = (!preg_match("/a[0-9]+/", $key)) ? ' checked="checked"' : '';
                                echo '<label>
                                <input type="checkbox" name="check_emails[]" id="check_emails'.$i.'" value="check"'.$check.' />
                                <input type="text" name="emails[]" id="emails'.$i.'" value="'.$value.'" />
                                </label>';
                            }
                        }
                    }
                    ?>

                </div>

            </div>

            <div class="barra"></div>

            <div class="box-modulo box-forms">

                <h2>Formulários do Site</h2>
                <p>Para mais destinatários separe os emais com ";"</p>

                <?php
                if($numForms === 0){
                ?>

                    <em>Nenhum formulário encontrado.</em>

                <?php
                } else {

                    while($form = mysqli_fetch_array($resForms)){

                        $infoForm = unserialize($form['acontent_form']);
                        $subject  = $infoForm['subject'] ? ' - '.$infoForm['subject'] : '';

                        ?>
                        <p>
                            <b><a href="phpwcms.php?do=articles&p=2&s=1&aktion=2&id=<?= $form['article_id'] ?>&acid=<?= $form['acontent_id'] ?>" target="_blank"><?= utf8_decode($form['article_title'].$subject) ?></a></b>
                            <input type="hidden" name="id_form[]" id="id_form" value="<?= $form['acontent_id'] ?>" />
                            <input type="text" name="emails_forms[]" id="emails_forms" value="<?= $infoForm['target']; ?>" />
                        </p>
                        <?php
                    }
                }
                ?>

            </div>

        </div>


        <!-- PÁGINA 4 - REDES SOCIAIS ========================================== -->
        <div id="tab-4" class="tab-content">

            <div class="box-modulo box-redes">

                <!-- Facebook -->
                <div class="lista-redes">
                    <label>
                    <?php $check = (preg_match("/a[0-9]+/", $check_redes[0]) || $check_redes[0] == '') ? '' : ' checked="checked"'; ?>
                        <input name="check_redes[]" id="facebook" type="checkbox" class="fl" value="check"<?= $check ?> />
                        <i class="fab fa-facebook-square"></i>
                    </label>
                    <input type="text" name="check_links[]" id="rede-facebook" class="fl" value="<?= $val_redes[0]; ?>"<?= ($val_redes[0] == '' || (preg_match("/a[0-9]+/", $check_redes[0]))) ? ' style="display:none;"' : ''; ?> />
                </div>

                <!-- Skype -->
                <div class="lista-redes rede-right dn">
                    <?php $check = (preg_match("/a[0-9]+/", $check_redes[1]) || $check_redes[1] == '') ? '' : ' checked="checked"'; ?>
                    <input name="check_redes[]" id="skype" type="checkbox" class="fl" value="check" <?= $check ?> />
                    <span class="img-skype"></span>
                    <input type="text" name="check_links[]" id="rede-skype" class="fl" value="<?= $val_redes[1]; ?>"<?= ($val_redes[1] == '' || (preg_match("/a[0-9]+/", $check_redes[1]))) ? ' style="display:none;"' : ''; ?> />
                </div>

                <!-- Google + -->
                <div class="lista-redes dn">
                    <?php $check = (preg_match("/a[0-9]+/", $check_redes[2]) || $check_redes[2] == '') ? '' : ' checked="checked"'; ?>
                    <input name="check_redes[]" id="google" type="checkbox" class="fl" value="check" <?= $check ?> />
                    <span class="img-google"></span>
                    <input type="text" name="check_links[]" id="rede-google" class="fl" value="<?= $val_redes[2]; ?>"<?= ($val_redes[2] == '' || (preg_match("/a[0-9]+/", $check_redes[2]))) ? ' style="display:none;"' : ''; ?> />
                </div>

                <!-- LinkedIn -->
                <div class="lista-redes">
                    <label>
                    <?php $check = (preg_match("/a[0-9]+/", $check_redes[3]) || $check_redes[3] == '') ? '' : ' checked="checked"'; ?>
                        <input name="check_redes[]" id="linkedin" type="checkbox" class="fl" value="check" <?= $check ?> />
                        <i class="fab fa-linkedin"></i>
                    </label>
                    <input type="text" name="check_links[]" id="rede-linkedin" class="fl" value="<?= $val_redes[3]; ?>"<?= ($val_redes[3] == '' || (preg_match("/a[0-9]+/", $check_redes[3]))) ? ' style="display:none;"' : ''; ?> />
                </div>

                <!-- Twitter -->
                <div class="lista-redes">
                    <label>
                    <?php $check = (preg_match("/a[0-9]+/", $check_redes[4]) || $check_redes[4] == '') ? '' : ' checked="checked"'; ?>
                        <input name="check_redes[]" id="twitter" type="checkbox" class="fl" value="check" <?= $check ?> />
                        <i class="fab fa-twitter-square"></i>
                    </label>
                    <input type="text" name="check_links[]" id="rede-twitter" class="fl" value="<?= $val_redes[4]; ?>"<?= ($val_redes[4] == '' || (preg_match("/a[0-9]+/", $check_redes[4]))) ? ' style="display:none;"' : ''; ?> />
                </div>

                <!-- Instagram -->
                <div class="lista-redes">
                    <label>
                    <?php $check = (preg_match("/a[0-9]+/", $check_redes[5]) || $check_redes[5] == '') ? '' : ' checked="checked"'; ?>
                        <input name="check_redes[]" id="instagram" type="checkbox" class="fl" value="check" <?= $check ?> />
                        <i class="fab fa-instagram"></i>
                    </label>
                    <input type="text" name="check_links[]" id="rede-instagram" class="fl" value="<?= $val_redes[5]; ?>"<?= ($val_redes[5] == '' || (preg_match("/a[0-9]+/", $check_redes[5]))) ? ' style="display:none;"' : ''; ?> />
                </div>

                <!-- YouTube -->
                <div class="lista-redes">
                    <label>
                    <?php $check = (preg_match("/a[0-9]+/", $check_redes[6]) || $check_redes[6] == '') ? '' : ' checked="checked"'; ?>
                        <input name="check_redes[]" id="youtube" type="checkbox" class="fl" value="check" <?= $check ?> />
                        <i class="fab fa-youtube"></i>
                    </label>
                    <input type="text" name="check_links[]" id="rede-youtube" class="fl" value="<?= $val_redes[6]; ?>"<?= ($val_redes[6] == '' || (preg_match("/a[0-9]+/", $check_redes[6]))) ? ' style="display:none;"' : ''; ?> />
                </div>

                <!-- Outro (Bloguer) -->
                <div class="lista-redes rede-right dn">
                    <?php $check = (preg_match("/a[0-9]+/", $check_redes[7]) || $check_redes[7] == '') ? '' : ' checked="checked"'; ?>
                    <input name="check_redes[]" id="outro" type="checkbox" class="fl" value="check" <?= $check ?> />
                    <span class="img-picassa"></span>
                    <input type="text" name="check_links[]" id="rede-outro" class="fl" value="<?= $val_redes[7]; ?>"<?= ($val_redes[7] == '' || (preg_match("/a[0-9]+/", $check_redes[7]))) ? ' style="display:none;"' : ''; ?> />
                </div>

                <!-- Outro () -->
                <div class="lista-redes dn">
                    <?php $check = (preg_match("/a[0-9]+/", $check_redes[8]) || $check_redes[8] == '') ? '' : ' checked="checked"'; ?>
                    <input name="check_redes[]" id="outro1" type="checkbox" class="fl" value="check" <?= $check ?> />
                    <span class="img-outro"></span>
                    <input type="text" name="check_links[]" id="rede-outro1" class="fl" value="<?= $val_redes[8]; ?>"<?= ($val_redes[8] == '' || (preg_match("/a[0-9]+/", $check_redes[8]))) ? ' style="display:none;"' : ''; ?> />
                </div>

                <!-- Outro () -->
                <div class="lista-redes rede-right dn">
                    <?php $check = (preg_match("/a[0-9]+/", $check_redes[9]) || $check_redes[9] == '') ? '' : ' checked="checked"'; ?>
                    <input name="check_redes[]" id="outro2" type="checkbox" class="fl" value="check" <?= $check ?> />
                    <span class="img-rss"></span>
                    <input type="text" name="check_links[]" id="rede-outro2" class="fl" value="<?= $val_redes[9]; ?>"<?= ($val_redes[9] == '' || (preg_match("/a[0-9]+/", $check_redes[9]))) ? ' style="display:none;"' : ''; ?> />
                </div>

            </div>

        </div>


        <!-- PÁGINA 5 - INFORMAÇÕES EXTRAS ===================================== -->
        <div id="tab-5" class="tab-content">

            <div class="box-modulo box-rodape">

                <h2>Rodapé do Site</h2>
                <p>
                    <?
                    $wysiwyg_editor = array(
                    'value'		=> $row['dados_rodape'],
                    'field'		=> 'rodape-empresa',
                    'height'	=> '150px',
                    'width'		=> '536px',
                    'rows'		=> '5',
                    'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
                    'lang'		=> 'en'
                    );

                    include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
                    ?>
                </p>

            </div>

            <div class="barra"></div>

            <div class="box-modulo box-campo-adicional1">

                <h2>Campo Adicional 1</h2>
                <p>
                    <?
                    $wysiwyg_editor = array(
                    'value'		=> $row['dados_campo_adicional1'],
                    'field'		=> 'campo-adicional1',
                    'height'	=> '150px',
                    'width'		=> '536px',
                    'rows'		=> '5',
                    'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
                    'lang'		=> 'en'
                    );

                    include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
                    ?>
                </p>

            </div>

            <div class="barra"></div>

            <div class="box-modulo box-campo-adicional2">

                <h2>Campo Adicional 2</h2>
                <p>
                    <?
                    $wysiwyg_editor = array(
                    'value'		=> $row['dados_campo_adicional2'],
                    'field'		=> 'campo-adicional2',
                    'height'	=> '150px',
                    'width'		=> '536px',
                    'rows'		=> '5',
                    'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
                    'lang'		=> 'en'
                    );

                    include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
                    ?>
                </p>

            </div>

        </div>


        <!-- PÁGINA 6 - RECAPTCHA ============================================== -->
        <div id="tab-6" class="tab-content">

            <div class="box-modulo box-recaptcha">

                <h2>reCAPTCHA</h2>
                <p><strong>Habilita / desabilita o campo de recaptcha em todos os formulários do site</strong></p>

                <label for="recaptcha">
                    <input name="recaptcha" id="recaptcha" type="checkbox" value="check"<?= $checkRecaptcha ?> />
                    <strong>Ativar reCAPTCHA</strong>
                </label>

                <div class="recaptcha-info"<?= $hideRecaptcha ?>>

                    <p>
                        <b>Site Key</b>
                        <input type="text" name="recaptcha-site" id="recaptcha-site" value="<?= html_entities($siteKey) ?>" />
                    </p>

                    <p>
                        <b>Secret Key</b>
                        <input type="text" name="recaptcha-secret" id="recaptcha-secret" value="<?= html_entities($secretKey) ?>" />
                    </p>

                </div>

            </div>

        </div>


        <!-- PÁGINA 7 - AVANÇADO ============================================== -->
        <div id="tab-7" class="tab-content">

            <div class="box-modulo box-ssl">

                <label for="forcar-ssl">
                    <input name="forcar-ssl" id="forcar-ssl" type="checkbox" value="check"<?= $checkRecaptcha ?> />
                    <strong>Forçar SSL</strong>
                </label>

            </div>

            <div class="barra"></div>

            <div class="box-modulo box-meta">

                <p>
                    <b>Meta SEO Global</b>
                    <textarea name="meta-empresa" id="meta-empresa" rows="20"><?= html_entities($row['dados_meta']) ?></textarea>
                </p>

            </div>

            <div class="barra"></div>

            <div class="box-modulo box-analytics">

                <p>
                    <b>Código Google Tag Manager (Header)</b>
                    <textarea name="analytics-empresa" id="analytics-empresa" rows="20"><?= html_entities($codigoAnalytics) ?></textarea>
                </p>

            </div>

            <div class="barra"></div>

            <div class="box-modulo box-webmaster">

                <p>
                    <b>Código Google Tag Manager (Body)</b>
                    <textarea name="webmaster-empresa" id="webmaster-empresa"><?= html_entities($row['dados_webmaster']) ?></textarea>
                </p>

            </div>

        </div>

        <!-- PÁGINA 8 - COOKIES ============================================ -->
        <div id="tab-8" class="tab-content">

            <label for="check-cookies">
                <input name="check-cookies" id="check-cookies" type="checkbox" value="check"<?= $checkCookies ?> />
                <strong>Ativar aviso de cookies</strong>
            </label>

            <div class="barra"></div>

            <h2>Política de Privacidade</h2>

            <p>
                <?
                    $wysiwyg_editor = array(
                    'value'		=> $cookies['politica'],
                    'field'		=> 'cookies_politica',
                    'height'	=> '150',
                    'width2'	=> '"100%"',
                    'rows'		=> '5',
                    'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
                    'lang'		=> 'en'
                    );

                    include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
                ?>
            </p>

            <div class="barra"></div>

            <h2>Mensagem de Cookies</h2>

            <p>
                <?
                    $wysiwyg_editor = array(
                    'value'		=> $cookies['mensagem'],
                    'field'		=> 'cookies_mensagem',
                    'height'	=> '150',
                    'width2'	=> '"100%"',
                    'rows'		=> '5',
                    'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
                    'lang'		=> 'en'
                    );

                    include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
                ?>
            </p>

        </div>

        <!-- PÁGINA 9 - ENVIO DE E-MAILS =================================== -->
            <div id="tab-9" class="tab-content">

                <h2>Configurações de envio de e-mail</h2>
                <div class="box-modulo box-config-emails">

                    <p>
                        <b>From (e-mail):</b>
                        <input type="text" name="email-from" id="email-from" value="<?= del_aspas($config['from'][1][0]) ?>" />
                    </p>

                    <p>
                        <b>From (nome):</b>
                        <input type="text" name="email-nome" id="email-nome" value="<?= del_aspas($config['nome'][1][0]) ?>" />
                    </p>

                    <p>
                        <b>Host:</b>
                        <input type="text" name="email-host" id="email-host" value="<?= del_aspas($config['host'][1][0]) ?>" />
                    </p>

                    <p>
                        <b>Porta:</b>
                        <input type="number" min="1" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="email-porta" id="email-porta" value="<?= $config['porta'][1][0] ?>" />
                    </p>

                    <p>
                        <b>Usuário:</b>
                        <input type="text" name="email-usuario" id="email-usuario" value="<?= del_aspas($config['usuario'][1][0]) ?>" />
                    </p>

                    <p>
                        <b>Senha:</b>
                        <input type="text" name="email-senha" id="email-senha" value="<?= del_aspas($config['senha'][1][0]) ?>" />
                    </p>

                    <p>
                        <b>Modo:</b>
                        <select name="email-modo" id="email-modo">
                            <option value="mailer"<?= del_aspas($config['modo'][1][0]) === 'mailer' ? ' selected' : '' ?>>Mailer</option>
                            <option value="smtp"<?= del_aspas($config['modo'][1][0]) === 'smtp' ? ' selected' : '' ?>>SMTP</option>
                        </select>
                    </p>

                    <p>
                        <b>Seguro (SMTP):</b>
                        <select name="email-seguro" id="email-seguro">
                            <option value=""<?= del_aspas($config['seguro'][1][0]) === '' ? ' selected' : '' ?>>Nenhum</option>
                            <option value="ssl"<?= del_aspas($config['seguro'][1][0]) === 'ssl' ? ' selected' : '' ?>>SSL</option>
                            <option value="tsl"<?= del_aspas($config['seguro'][1][0]) === 'tsl' ? ' selected' : '' ?>>TSL</option>
                        </select>
                    </p>

                    <p>
                        <b>Autenticação (SMTP):</b>
                        <select name="email-autenticacao" id="email-autenticacao">
                            <option value="1"<?= $config['autenticacao'][1][0] === '1' ? ' selected' : '' ?>>Sim</option>
                            <option value="0"<?= $config['autenticacao'][1][0] === '0' ? ' selected' : '' ?>>Não</option>
                        </select>
                    </p>

                </div>

                <div class="barra"></div>
                <h2>Configurações Locaweb </h2>

                <p>
                    <strong>From (e-mail): </strong>
                    <span>email@dominiodosite.com.br (o email tem que ter o mesmo dominio do site)</span>
                </p>

                <p>
                    <strong>From (nome): </strong>
                    <span>Nome da Empresa</span>
                </p>

                <p>
                    <strong>Host: </strong>
                    <span>smtp.dominiodosite.com.br</span>
                </p>

                <p>
                    <strong>Porta: </strong>
                    <span>587</span>
                </p>

                <p>
                    <strong>Usuário: </strong>
                    <span>email@dominiodosite.com.br (tem que ser o mesmo que o From (email))</span>
                </p>

                <p>
                    <strong>Senha: </strong>
                    <span>Senha do email</span>
                </p>

                <p>
                    <strong>Modo: </strong>
                    <span>SMTP</span>
                </p>

                <p>
                    <strong>Seguro (SMTP): </strong>
                    <span>Nenhum</span>
                </p>

                <p>
                    <strong>Autenticação (SMTP): </strong>
                    <span>Sim</span>
                </p>

            </div>


        <div class="botao-salvar fl">
            <input type="submit" name="bt-meta-empresa" id="bt-meta-empresa" value="Salvar" />
        </div>

    </form>

</div>


<!-- ======= Modal de Tags ======= -->
<div class="modal-wrapper">

    <div class="modal-tags">

        <h3>LISTA DE TAGS</h3>

        <div class="lista-left">
            <p>
                <strong>EMPRESA</strong>
                <span>Nome da Empresa: <b>{NOME-EMPRESA}</b></span>
            </p>
            <p>
                <strong>TELEFONES</strong>
                <span>Todos os telefones: <b class="copiar">{TELEFONE}</b></span>
                <span>Telefones do Topo: <b>{TELEFONE-TOPO}</b></span>
                <span>Telefone específico: <b>{TELEFONE<i title="substituir pelo número do telefone na lista">[NUMERO]</i>}</b></span>
            </p>
            <p>
                <strong>E-MAILS</strong>
                <span>Todos os e-mails: <b>{EMAILS}</b></span>
                <span>E-mails do topo: <b>{EMAILS-RODAPE}</b></span>
            </p>
            <p>
                <strong>ENDEREÇO DA EMPRESA</strong>
                <span>Rua: <b>{RUA}</b></span>
                <span>Número: <b>{NUMERO}</b></span>
                <span>Bairro: <b>{BAIRRO}</b></span>
                <span>Estado: <b>{UF}</b></span>
                <span>Cidade: <b>{CIDADE}</b></span>
                <span>Complemento: <b>{COMPLEMENTO}</b></span>
                <span>Cep: <b>{CEP}</b></span>
            </p>
            <p>
                <strong>SEGUNDO ENDEREÇO</strong>
                <span>Rua: <b>{RUA2}</b></span>
                <span>Número: <b>{NUMERO2}</b></span>
                <span>Bairro: <b>{BAIRRO2}</b></span>
                <span>Estado: <b>{UF2}</b></span>
                <span>Cidade: <b>{CIDADE2}</b></span>
                <span>Complemento: <b>{COMPLEMENTO2}</b></span>
                <span>Cep: <b>{CEP2}</b></span>
            </p>
            <p>
                <strong>CAMPOS</strong>
                <span>Rodapé: <b>{RODAPE}</b></span>
                <span>Campo Adicional 1: <b>{CAMPO1}</b></span>
                <span>Campo Adicional 2: <b>{CAMPO2}</b></span>
            </p>
        </div>

        <div class="lista-right">
            <p>
                <strong>WHATSAPP</strong>
                <span>Todos os números: <b>{WHATSAPP}</b></span>
                <span>Número específico: <b>{WHATSAPP<i title="substituir pelo número do whatsapp na lista">[NUMERO]</i>}</b></span>
            </p>
            <p>
                <strong>REDES SOCIAIS</strong>
                <span>Todas as redes: <b>{REDES-SOCIAIS}</b></span>
                <span>Facebook: <b>{FACEBOOK}</b></span>
                <span>Skype: <b>{SKYPE}</b></span>
                <span>Google Plus: <b>{GOOGLE}</b></span>
                <span>Likedin: <b>{LINKEDIN}</b></span>
                <span>Twitter: <b>{TWITTER}</b></span>
                <span>Instagram: <b>{INSTAGRAM}</b></span>
                <span>Youtube: <b>{YOUTUBE}</b></span>
                <span>Outro 1: <b>{OUTRO1}</b></span>
                <span>Outro 2: <b>{OUTRO2}</b></span>
                <span>Outro 3: <b>{OUTRO3}</b></span>
            </p>
            <p>
                <strong>ENDEREÇO DA EMPRESA (MAPA)</strong>
                <span>Rua: <b>{RUA-MAPA}</b></span>
                <span>Bairro: <b>{BAIRRO-MAPA}</b></span>
                <span>Cidade: <b>{CIDADE-MAPA}</b></span>
            </p>
            <p>
                <strong>SEGUNDO ENDEREÇO (MAPA)</strong>
                <span>Rua: <b>{RUA-MAPA2}</b></span>
                <span>Bairro: <b>{BAIRRO-MAPA2}</b></span>
                <span>Cidade: <b>{CIDADE-MAPA2}</b></span>
            </p>
            <p>
                <strong>MAPAS</strong>
                <span>Endereço da Empresa: <b>{MAPS}</b></span>
                <span>Segundo endereço: <b>{MAPS2}</b></span>
            </p>
            <p>
                <strong>COOKIES</strong>
                <span>Tag do conteúdo: <b>[COOKIES][/COOKIES]</b></span>
                <span>Política de privacidade: <b>{COOKIES_POLITICA}</b></span>
                <span>Mensagem: <b>{COOKIES_MENSAGEM}</b></span>
            </p>
        </div>

    </div>

</div>

<div class="fundo-modal"></div>
<!-- ======= Modal de Tags ======= -->

<?php


/* FUNÇÕES ================================================================== */

// Busca a lista de estados
function estados($name, $id, $sel) {

    $estados = array(
        'AC',
        'AL',
        'AM',
        'AP',
        'BA',
        'CE',
        'DF',
        'ES',
        'GO',
        'MA',
        'MG',
        'MS',
        'MT',
        'PA',
        'PB',
        'PE',
        'PI',
        'PR',
        'RJ',
        'RN',
        'RO',
        'RR',
        'RS',
        'SC',
        'SE',
        'SP',
        'TO'
    );
    $listaEstados = '';

    foreach ($estados as $uf) {
        $check = (isset($sel)) ? ($sel === $uf) ? ' selected="selected"' : '' : '';
        $listaEstados .= '<option value="' . $uf . '"' . $check . '>' . $uf . '</option>';
    }

    $resultado = '<select name="'.$name.'" id="'.$id.'">'."\n"
               . '    <option value="">Selecione</option>'."\n"
               . '    '.$listaEstados."\n"
               . '</select>';

    return $resultado;

}

// Remove as apas dos dados dos e-mails
function del_aspas($val){

    return str_replace(array("'", '"'), array(''), utf8_decode($val));

}

?>