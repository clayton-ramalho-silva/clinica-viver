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
// email contact form

$field_counter = 0;
initMootools();
$BE['HEADER']['contentpart.js'] = getJavaScriptSourceLink('include/inc_js/contentpart.js');
$BE['HEADER']['custom_js'] = '<script type="text/javascript">
<!--
function initMathSpam() {
	$("cform_field_value_0").value = "+ = ' .
        $BL['be_cnt_field']['summing'] .
        '\n- = ' .
        $BL['be_cnt_field']['subtract'] .
        '\n* = ' .
        $BL['be_cnt_field']['multiply'] .
        '\n: = ' .
        $BL['be_cnt_field']['divide'] .
        '\ncalc = ' .
        $BL['be_cnt_field']['calculation'] .
        '";
}
function setFieldValue(el) {
	if(el.options[el.selectedIndex].value == "mathspam") {
		initMathSpam();
	}
}
//-->
</script>';

$BL['be_cnt_field'] = array_merge(array(
    "text" => 'text (single-line)',
    "codigo" => 'Codigo',
    "email" => 'email',
    "textarea" => 'text (multi-line)',
    "hidden" => 'hidden',
    "password" => 'password',
    "select" => 'select menu',
    "list" => 'list menu',
    "checkbox" => 'checkbox',
    "checkboxcopy" => 'checkbox (email copy on/off)',
    "radio" => 'radio button',
    "upload" => 'file',
    "submit" => 'send button',
    "reset" => 'reset button',
    "break" => 'break', "breaktext" => 'break text',
    "special" => 'text (spezial)',
    "captchaimg" => 'captcha image',
    "captcha" => 'captcha code',
    'newsletter' => 'newsletter',
    'selectemail' => 'select email menu',
    'country' => 'select country menu',
    'mathspam' => 'math spam protect',
    'summing' => 'summing',
    'subtract' => 'subtract',
    'divide' => 'divide', 'multiply' => 'multiply',
    'calculation' => 'calculation:',
    'formtracking_off' => 'disable form tracking',
    'checktofrom' => 'email of recipient must be different from sender',
    'recaptcha' => 'reCAPTCHA',
    'recaptcha_signapikey' => 'Sign up for a reCAPTCHA API key'),
        $BL['be_cnt_field']
);

if (empty($content['form']) || !is_array($content['form']))
    $content['form'] = array();

$content['form'] = array_merge(array(
    'subject' => '',
    'startup' => '',
    'startup_html' => 0,
    'targettype' => 'email',
    'class' => '',
    'target' => '',
    "copyto" => '',
    "sendcopy" => 0,
    "onsuccess_redirect" => 0,
    "onsuccess" => '',
    "onerror_redirect" => 0,
    "onerror" => '',
    "template_format" => 0,
    "template" => '',
    "template_format_copy" => 0,
    "template_copy" => '',
    'template_equal' => 1,
    "customform" => '',
    'sender' => '',
    'sendertype' => 'email',
    'sendername' => '',
    'sendernametype' => 'custom',
    'cc' => '',
    'subjectselect' => '',
    'savedb' => 0,
    'saveprofile' => 0,
    'verifyemail' => '',
    'formtracking_off' => 0,
    'checktofrom' => 0,
    'function_to' => '',
    'function_cc' => '',
    'anchor_off' => 0,
    'ssl' => 0), $content['form']);

$content['profile_fields'] = array(
    "title" => $BL['be_profile_label_title'],
    "firstname" => $BL['be_profile_label_firstname'],
    "lastname" => $BL['be_profile_label_name'],
    "company" => $BL['be_profile_label_company'],
    "street" => $BL['be_profile_label_street'],
    "add" => $BL['be_profile_label_add'],
    "city" => $BL['be_profile_label_city'],
    "zip" => $BL['be_profile_label_zip'],
    "region" => $BL['be_profile_label_state'],
    "country" => $BL['be_profile_label_country'],
    "fon" => $BL['be_profile_label_phone'],
    "fax" => $BL['be_profile_label_fax'],
    "mobile" => $BL['be_profile_label_cellphone'],
    "signature" => $BL['be_profile_label_signature'],
    'notes' => $BL['be_profile_label_notes'],
    "prof" => $BL['be_profile_label_profession'],
    "newsletter" => $BL['be_profile_label_newsletter'],
    "website" => $BL['be_profile_label_website'],
    'gender' => $BL['be_profile_label_gender'],
    'birthday' => $BL['be_profile_label_birthday'],
    "varchar1" => $BL['be_cnt_field']['text'] . ' 1',
    "varchar2" => $BL['be_cnt_field']['text'] . ' 2',
    "varchar3" => $BL['be_cnt_field']['text'] . ' 3',
    "varchar4" => $BL['be_cnt_field']['text'] . ' 4',
    "varchar5" => $BL['be_cnt_field']['text'] . ' 5',
    "text1" => $BL['be_cnt_field']['textarea'] . ' 1',
    "text2" => $BL['be_cnt_field']['textarea'] . ' 2',
    "text3" => $BL['be_cnt_field']['textarea'] . ' 3'
);

$content['profile_fields_varchar'] = array(
    "title" => $BL['be_profile_label_title'],
    "firstname" => $BL['be_profile_label_firstname'],
    "lastname" => $BL['be_profile_label_name'],
    "company" => $BL['be_profile_label_company'],
    "street" => $BL['be_profile_label_street'],
    "add" => $BL['be_profile_label_add'],
    "city" => $BL['be_profile_label_city'],
    "zip" => $BL['be_profile_label_zip'],
    "region" => $BL['be_profile_label_state'],
    "country" => $BL['be_profile_label_country'],
    "fon" => $BL['be_profile_label_phone'],
    "fax" => $BL['be_profile_label_fax'],
    "mobile" => $BL['be_profile_label_cellphone'],
    "email" => $BL['be_profile_label_email'],
    "password" => $BL['be_cnt_field']['password'],
    "signature" => $BL['be_profile_label_signature'],
    "prof" => $BL['be_profile_label_profession'],
    "website" => $BL['be_profile_label_website'],
    'gender' => $BL['be_profile_label_gender'],
    "varchar1" => $BL['be_cnt_field']['text'] . ' 1',
    "varchar2" => $BL['be_cnt_field']['text'] . ' 2',
    "varchar3" => $BL['be_cnt_field']['text'] . ' 3',
    "varchar4" => $BL['be_cnt_field']['text'] . ' 4',
    "varchar5" => $BL['be_cnt_field']['text'] . ' 5'
);
$content['profile_fields_longtext'] = array(
    'notes' => $BL['be_profile_label_notes'],
    "text1" => $BL['be_cnt_field']['textarea'] . ' 1',
    "text2" => $BL['be_cnt_field']['textarea'] . ' 2',
    "text3" => $BL['be_cnt_field']['textarea'] . ' 3'
);


$for_select = '';
$for_select_2 = '';

// always disable switching content part for form - too complex settings and better to safe the user for himself
initMootools();
$BE['BODY_CLOSE'][] = '<script type="text/javascript">document.getElementById("target_ctype").disabled = true;</script>';
?>
<tr><td colspan="2"><input type="hidden" name="target_ctype" value="23" /></td></tr>

<tr>
    <td colspan="2">
        <div class="barra"></div>

        <h2>Informações de Envio</h2>



        <p style="display: none">
            <b><?php echo $BL['be_msg_subject'] ?></b>
            <select name="cform_subjectselect">

                <option value=""><?php echo $BL['be_msg_subject'] ?></option>
                <?php
                $cc_listing = '';
                $recipient_option = '';
                $sender_option = '';
                $sendername_option = '';
                $subject_option = '';

                if (isset($content['form']["fields"]) && is_array($content['form']["fields"]) && count($content['form']["fields"])) {
                    foreach ($content['form']["fields"] as $key => $value) {

                        $for_copy = false;
                        $for_sendername = false;
                        $for_email = false;
                        $for_placeholder = true;
                        $for_subject = false;
                        $for_newsletter = false;
                        $for_name = html($content['form']["fields"][$key]['name']);

                        switch ($content['form']["fields"][$key]['type']) {

                            case 'text': $for_copy = true;
                                $for_sendername = true;
                                $for_subject = true;
                                break;

                            case 'email': $for_copy = true;
                                $for_email = true;
                                $for_sendername = true;
                                break;

                            case 'selectemail': $for_copy = true;
                                $for_email = true;
                                break;

                            case 'hidden': $for_copy = true;
                                $for_subject = true;
                                break;

                            case 'newsletter': $for_newsletter = true;
                                break;

                            case 'select':
                            case 'list': $for_subject = true;
                                break;
                        }

                        if ($for_subject) {

                            $subject_option .= '	<option value="formfield_' . $for_name . '"';
                            $subject_option .= is_selected($content['form']['subjectselect'], 'formfield_' . $content['form']['fields'][$key]['name'], 0, 0);
                            $subject_option .= '>' . $BL['be_cnt_guestbook_form'] . ': ' . $for_name . '</option>' . LF;
                        }

                        if ($for_copy) {

                            $cc_listing .= '	<option value="' . $for_name . '"';
                            $cc_listing .= is_selected($content['form']["copyto"], $content['form']['fields'][$key]['name'], 0, 0);
                            $cc_listing .= '>' . $for_name . '</option>' . LF;

                            if ($for_email) {

                                $recipient_option .= '	<option value="emailfield_' . $for_name . '"';
                                $recipient_option .= is_selected($content['form']['targettype'], 'emailfield_' . $content['form']['fields'][$key]['name'], 0, 0);
                                $recipient_option .= '>' . $BL['be_cnt_guestbook_form'] . ': ' . $for_name . '</option>' . LF;

                                $sender_option .= '	<option value="emailfield_' . $for_name . '"';
                                $sender_option .= is_selected($content['form']['sendertype'], 'emailfield_' . $content['form']['fields'][$key]['name'], 0, 0);
                                $sender_option .= '>' . $BL['be_cnt_guestbook_form'] . ': ' . $for_name . '</option>' . LF;
                            }

                            if ($for_sendername) {

                                $sendername_option .= '	<option value="formfield_' . $for_name . '"';
                                $sendername_option .= is_selected($content['form']['sendernametype'], 'formfield_' . $content['form']['fields'][$key]['name'], 0, 0);
                                $sendername_option .= '>' . $BL['be_cnt_guestbook_form'] . ': ' . $for_name . '</option>' . LF;
                            }
                        }


                        // parallel building of the placeholder tag menu for the template
                        switch ($content['form']["fields"][$key]['type']) {

                            case 'submit': $for_placeholder = false;
                                break;

                            case 'reset': $for_placeholder = false;
                                break;

                            case 'break': $for_placeholder = false;
                                break;

                            case 'breaktext': $for_placeholder = false;
                                break;
                        }

                        $for_select_2 .= '<option value="';
                        $for_tempselect = '';
                        if ($for_placeholder) {

                            $for_select .= '<option value="{' . $for_name . '}">';
                            if (!empty($content['form']["fields"][$key]['label'])) {
                                $for_select .= html($content['form']["fields"][$key]['label']) . ' ';
                                $for_tempselect .= html($content['form']["fields"][$key]['label']) . ' ';
                            }
                            $for_select .= '{' . $for_name . "}</option>\n";

                            $for_select_2 .= '{ERROR:' . $for_name . '}{LABEL:' . $for_name . '}';
                        }
                        $for_select_2 .= '{' . $for_name . '}">' . $for_tempselect . '{' . $for_name . "}</option>\n";
                    }
                }

                echo $subject_option;
                ?>
            </select>


        </p>


        <p>
            <b>Texto do Assunto</b>
            <input name="cform_subject" type="text" id="cform_subject" value="<?php echo html($content['form']["subject"]) ?>" size="40" />
        </p>

        <div class="grid-4">
            <p>
                <b><?php echo $BL['be_cnt_recipient'] ?></b>
                <select name="cform_targettype" >
                    <?php
                    echo '	<option value="email"' . is_selected('email', $content['form']['targettype'], 0, 0) . '>' . $BL['be_profile_label_email'] . '</option>' . LF;
                    echo $recipient_option;
                    ?>

                </select>
            </p>
            <p class="campo-2b">
                <b>E-mail que Recebe</b>
                <input name="cform_target" type="text" id="cform_target" value="<?php echo html($content['form']["target"]) ?>" size="40" />
            </p>
        </div>


        <div class="grid-4">

            <p>
                <b><?php echo $BL['be_newsletter_fromemail'] ?></b>
                <select name="cform_sendertype">
                    <?php
                    echo '	<option value="email"' . is_selected('email', $content['form']['sendertype'], 0, 0) . '>' . $BL['be_profile_label_email'] . '</option>' . LF;
                    echo '	<option value="system"' . is_selected('system', $content['form']['sendertype'], 0, 0) . '>' . $BL['be_cnt_sysadmin_system'] . ': ' . html($phpwcms['SMTP_FROM_EMAIL']) . '</option>' . LF;

                    echo $sender_option;
                    ?>
                </select>
            </p>

            <p class="campo-2b">
                <b>Email que Envia</b>
                <input name="cform_sender" type="text" id="cform_sender" value="<?php echo html($content['form']['sender']) ?>" size="40" />
            </p>
        </div>
        <div class="grid-4">

            <p>
                <b><?php echo $BL['be_newsletter_fromname'] ?></b>
                <select name="cform_sendernametype">
                    <?php
                    echo '	<option value="custom"' . is_selected('custom', $content['form']['sendernametype'], 0, 0) . '>' . $BL['be_cnt_ecardform_name'] . '</option>' . LF;
                    echo '	<option value="system"' . is_selected('system', $content['form']['sendernametype'], 0, 0) . '>' . $BL['be_cnt_sysadmin_system'] . ': ' . html($phpwcms['SMTP_FROM_NAME']) . '</option>' . LF;

                    echo $sendername_option;
                    ?>
                </select>
            </p>

            <p class="campo-2b">
                <b>Nome de quem Envia</b>
                <input name="cform_sendername" type="text" id="cform_sendername" value="<?php echo html($content['form']['sendername']) ?>" size="40" />
            </p>
        </div>


        <p>
            <label class="botoes">
                <input type="checkbox" name="cform_sendcopy" value="1"<?php echo is_checked('1', $content['form']["sendcopy"], 0, 0) ?> title="send copy to selected field" /> 
                <!-- <?php echo $BL['be_cnt_send_copy_to'] ?> -->
                Enviar cópia para
            </label>
        </p>

        <div class="grid-4">
            <p>
                <b>Campo para Cópia</b>
                <select name="cform_copyto">
                    <?php echo $cc_listing; ?>
                </select>
            </p>
            <p class="campo-2b">
                <b>Email para Cópia</b>
                <input name="cform_cc" type="text" id="cform_cc" value="<?php echo html($content['form']['cc']) ?>" size="40" />
            </p>

        </div>

        <div class="barra"></div>
        <h2>Segurança</h2>
        <p>
            <label class="botoes" for="cform_checktofrom"><input type="checkbox" name="cform_checktofrom" id="cform_checktofrom" value="1" <?php is_checked(1, $content['form']['checktofrom']) ?> /> <?php echo $BL['be_cnt_field']['checktofrom'] ?></label>
        </p>

        <p>
            <label class="botoes" for="cform_ssl">
                <input type="checkbox" name="cform_ssl" id="cform_ssl" value="1" <?php is_checked(1, $content['form']['ssl']) ?> />
                <?php echo $BL['form_force_ssl'] ?>
            </label>
        </p>

        <div class="barra"></div>

        <h2><?php echo $BL['be_cnt_database'] ?></h2>


        <p class="espacar-campo">
            <label class="botoes" for="cform_savedb">
                <input type="checkbox" name="cform_savedb" id="cform_savedb" value="1" <?php echo is_checked(1, $content['form']["savedb"], 0, 0) ?> /> 
                <!-- <?php echo $BL['be_cnt_formsave_in_db'] ?> -->
                Salvar Envios
            </label>

            <label class="botoes" for="cform_saveprofile"><input type="checkbox" name="cform_saveprofile" id="cform_saveprofile" value="1" <?php echo is_checked(1, $content['form']["saveprofile"], 0, 0) ?> onchange="this.form.submit();" /> <?php echo $BL['be_cnt_formsave_profile'] ?></label>

            <label class="botoes" for="cform_tracking_off"><input type="checkbox" name="cform_tracking_off" id="cform_tracking_off" value="1" <?php echo is_checked(1, $content['form']["formtracking_off"], 0, 0) ?> /> <?php echo $BL['be_cnt_field']['formtracking_off'] ?></label>
        </p>

        <p>
            <?php
// check form entries
            if ($content["id"]) {

                $entries = _dbQuery('SELECT COUNT(*) FROM ' . DB_PREPEND . 'phpwcms_formresult WHERE formresult_pid=' . $content['id'], 'COUNT');

                // yepp - available - link to export script
                if ($entries > 0) {

                    echo '';
                    echo "<button onclick=\"window.open('include/inc_act/act_export.php?action=exportformresult&amp;fid=";
                    echo $content['id'] . "', 'Zweitfenster');\" class=\"button10\">";
                    echo '<i class="fas fa-download"></i>&nbsp;';
                    echo 'Baixar Dados Enviados (' . $entries . ')</button>';
                }
            }
            ?>

        </p>


        <div class="barra"></div>

        <h3>Texto Padrão</h3>

        <p class="espacar-campo">
            <label class="botoes" for="cform_startup_html0"><input type="radio" name="cform_startup_html" id="cform_startup_html0" value="0"<?php echo is_checked('0', $content['form']["startup_html"], 0, 0) ?> title="Text" /> Text</label>
            <label class="botoes" for="cform_startup_html1"><input type="radio" name="cform_startup_html" id="cform_startup_html1" value="1"<?php echo is_checked('1', $content['form']["startup_html"], 0, 0) ?> title="HTML" /> HTML</label>
        </p>
        <p>
            <textarea class="textarea-form" name="cform_startup" id="cform_startup" rows="5"><?php echo html($content['form']["startup"]) ?></textarea>
        </p>

        <div class="barra"></div>

        <h3>Formulário Enviado com Sucesso</h3>
        <p class="espacar-campo">
            <label class="botoes" for="cform_onsuccess_redirect0"><input type="radio" name="cform_onsuccess_redirect" id="cform_onsuccess_redirect0" value="0"<?php echo is_checked('0', $content['form']["onsuccess_redirect"], 0, 0) ?> title="redirect on success" /> Text</label>

            <label class="botoes" for="cform_onsuccess_redirect2"><input type="radio" name="cform_onsuccess_redirect" id="cform_onsuccess_redirect2" value="2"<?php echo is_checked('2', $content['form']["onsuccess_redirect"], 0, 0) ?> title="redirect on success" /> HTML</label>

            <label class="botoes" for="cform_onsuccess_redirect1">
                <input type="radio" name="cform_onsuccess_redirect" id="cform_onsuccess_redirect1" value="1"<?php echo is_checked('1', $content['form']["onsuccess_redirect"], 0, 0) ?> title="redirect on success" />
                Redirect
            </label>

        </p>

<!--        <p>
            <b>Tags Disponíveis</b>
            <?php
            if ($for_select != '') {
                echo '<select name="successInfo" id="successInfo"" ';
                echo 'onChange="insertAtCursorPos(document.articlecontent.cform_onsuccess, ';
                echo 'document.articlecontent.successInfo.options[document.articlecontent.successInfo.selectedIndex].value);">';
                echo $for_select;
                echo '<option value="{REMOTE_IP}">{REMOTE_IP}</option>' . LF;
                echo '</select>';
                echo '<a class="botoes" ';
                echo 'onclick="insertAtCursorPos(document.articlecontent.cform_onsuccess, ';
                echo 'document.articlecontent.successInfo.options[document.articlecontent.successInfo.selectedIndex].value);"  > <i class="fas fa-chevron-right"></i> </a>';
            }
            ?>
        </p>-->

        <p>
            <textarea class="textarea-form" name="cform_onsuccess" id="cform_onsuccess" rows="3"><?php echo html($content['form']["onsuccess"]) ?></textarea>
        </p>

        <div class="barra"></div>
        <h3>Erro ao Enviar</h3>

        <p class="espacar-campo">
            <label class="botoes" for="cform_onerror_redirect0">
                <input type="radio" name="cform_onerror_redirect" id="cform_onerror_redirect0" value="0"<?php echo is_checked('0', $content['form']["onerror_redirect"], 0, 0) ?> title="redirect on success" />
                Text
            </label>

            <label class="botoes" for="cform_onerror_redirect2">
                <input type="radio" name="cform_onerror_redirect" id="cform_onerror_redirect2" value="2"<?php echo is_checked('2', $content['form']["onerror_redirect"], 0, 0) ?> title="redirect on success" />
                HTML
            </label>

            <label class="botoes" for="cform_onerror_redirect1">
                <input type="radio" name="cform_onerror_redirect" id="cform_onerror_redirect1" value="1"<?php echo is_checked('1', $content['form']["onerror_redirect"], 0, 0) ?> title="redirect on success" />
                Redirect
            </label>
        </p>

        <p>
            <textarea class="textarea-form" name="cform_onerror" rows="3"><?php echo html($content['form']["onerror"]) ?></textarea>
        </p>

        <p style="display: none">
        <?php echo $BL['be_cnt_reference_basis'] ?>
        </p>

        <?php
        if (!isset($content['form']["labelpos"])) {
            $content['form']["labelpos"] = 3;
            // 0 = default = in front of form field
            // 1 = above form field
            // 2 = Custom
            // 3 = modern DIV based
        }
        ?>

      <p style="display: none">
            <label class="botoes" for="cform_labelpos3">
                <input type="radio" name="cform_labelpos" id="cform_labelpos3" value="3"<?php echo is_checked(3, $content['form']["labelpos"], 0, 1) ?> /> 
                < DIV Field >
            </label>
      
            <label class="botoes" for="cform_labelpos0">
                <input type="radio" name="cform_labelpos" id="cform_labelpos0" value="0"<?php echo is_checked(0, $content['form']["labelpos"], 0, 1) ?> />
                <img src="img/symbole/label_0.gif" width="70" height="22" alt="" />
            </label>
       
            <label class="botoes" for="cform_labelpos1">
                <input type="radio" name="cform_labelpos" id="cform_labelpos1" value="1"<?php echo is_checked(1, $content['form']["labelpos"], 0, 1) ?> />
                <img src="img/symbole/label_1.gif" width="60" height="22" alt="" />
            </label>    
       
            <label class="botoes" for="cform_labelpos2">
                <input type="radio" name="cform_labelpos" id="cform_labelpos2" value="2"<?php echo is_checked(2, $content['form']["labelpos"], 0, 1) ?> />
                <img src="img/symbole/label_2.gif" width="60" height="22" alt="" />
            </label>
        </p>

        <!--<div class="barra"></div>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_form_class'] ?></b>
            <input type="text" name="cform_class" value="<?php echo (isset($content['form']["class"]) ? html($content['form']["class"]) : '') ?>" />
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_label_wrap'] ?></b>
            <input type="text" name="cform_label_wrap" value="<?php echo (isset($content['form']["label_wrap"]) ? html($content['form']["label_wrap"]) : '|') ?>" />
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_req_mark'] ?></b>
            <input type="text" name="cform_reqmark" value="<?php echo (isset($content['form']["cform_reqmark"]) ? html($content['form']["cform_reqmark"]) : '*') ?>" />
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_error_class'] ?></b>
            <input type="text" name="cform_error_class" value="<?php echo (isset($content['form']["error_class"]) ? html($content['form']["error_class"]) : '') ?>" />
        </p>-->

<!--        <p>
            <b><?php echo $BL['be_cnt_function_validate'] ?></b>
            <input type="text" name="cform_function_validate" value="<?php echo (isset($content['form']["cform_function_validate"]) ? html($content['form']["cform_function_validate"]) : '') ?>" />
        </p>-->

        <p>
            <label class="botoes" for="cform_anchor_off">
                <input type="checkbox" name="cform_anchor_off" id="cform_anchor_off" value="1"<?php is_checked(1, $content['form']["anchor_off"]) ?> />
                <?php echo $BL['be_article_cnt_anchor'] ?> <?php echo $BL['be_off'] ?>
            </label>
        </p>
        <div class="barra"></div>

<!--        <p>
        <?php echo $BL['be_cnt_type'] ?>
        <?php echo $BL['be_newsletter_name'] ?>
        <?php echo $BL['be_cnt_label'] ?>
            &nbsp;S/C:
            &nbsp;M/R:
            <img src="img/article/fill_in_here.gif" alt="<?php echo $BL['be_cnt_needed'] ?>" title="<?php echo $BL['be_cnt_needed'] ?>" border="0" />
            <img src="img/button/trash_13x13_1.gif" alt="<?php echo $BL['be_cnt_delete'] ?>" title="<?php echo $BL['be_cnt_delete'] ?>" border="0" />
        </p>-->

    </td>
</tr>


<tr><td colspan="2">

        <h2>Campos do Formulário</h2>

        <!--<table summary="" cellpadding="0" cellspacing="1" border="0">-->
<!--            <tr><td colspan="8"><img src="img/leer.gif" alt="" width="1" height="3" /></td></tr>
            <tr bgcolor="#DAE4ED"><td colspan="8"><img src="img/leer.gif" alt="" width="1" height="1" /></td></tr>-->
<!--            <tr bgcolor="#E6ECF2">
                <td style="width:30px">&nbsp;</td>
                <td class="chatlist" style="padding: 1px">&nbsp;:</td>
                <td class="chatlist" style="padding: 1px">&nbsp;:</td>
                <td class="chatlist" style="padding: 1px">&nbsp;:</td>
                <td class="chatlist" title="size/columns" style="padding: 1px"></td>
                <td class="chatlist" title="maxlength/rows" style="padding: 1px"></td>
                <td align="center" style="padding: 1px"></td>
                <td align="center" style="padding: 1px"></td>
            </tr>-->


        <?php
        if (isset($content['form']["fields"]) && is_array($content['form']["fields"]) && count($content['form']["fields"])) {

            $field_counter = 1;
            $field_max = count($content['form']["fields"]);
            $field_js = array('showAll' => array(), 'hideAll' => array(), 'varcharFields' => array(), 'longtextFields' => array());

            foreach ($content['form']["fields"] as $key => $value) {

                $field_bg = ($field_counter % 2) ? '' : ' bgcolor="#F3F5F8"';
                $field_row4 = '';

                // generate javascript code part 1
                $field_js['showAll'][$key] = '	showHide_CntFormfieldRow(\'formRow_' . $field_counter . '\', \'block\'';
                $field_js['hideAll'][$key] = '	showHide_CntFormfieldRow(\'formRow_' . $field_counter . '\', \'none\'';
                echo '<div class="controle-posicoes"><span>';


//                    echo '<div' . $field_bg . ' id="formRow_' . $field_counter . '_1">';
//                    echo '<table summary="" cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td valign="top">';
//                    echo '<img src="img/leer.gif" width="3" height="17" alt="" />';
                if ($field_counter != 1) {
                    echo '<a class="botoes" href="#" onclick="document.articlecontent.cform_order_' . $field_counter . '.value=\'';
                    echo ($field_counter - 1) . '\';document.articlecontent.cform_order_' . ($field_counter - 1);
                    echo '.value=\'' . $field_counter . '\';document.articlecontent.submit();return false;">';
                    echo '<i class="fas fa-chevron-up"></i> Subir';
                    echo '</a>';
                } else {
                    echo '<a class="botoes bt-off"><i class="fas fa-chevron-up"></i> Subir</a>';
                }
//                    echo '<img src="img/leer.gif" width="1" height="1" alt="" />';
                if ($field_max != $field_counter) {
                    echo '<a class="botoes" href="#" onclick="document.articlecontent.cform_order_' . $field_counter . '.value=\'';
                    echo ($field_counter + 1) . '\';document.articlecontent.cform_order_' . ($field_counter + 1);
                    echo '.value=\'' . $field_counter . '\';document.articlecontent.submit();return false;">';
                    echo '<i class="fas fa-chevron-down"></i> Descer';
                    echo '</a>';
                } else {
                    echo '<a class="botoes bt-off"><i class="fas fa-chevron-down"></i> Descer</a>';
                }
                echo '<input type="hidden" name="cform_order[' . $field_counter . ']" id="cform_order_' . $field_counter . '" value="' . $field_counter . '">';
                echo '<a name="field_value_' . $field_counter . '"></a>';
//                echo '' . $BL['be_cnt_value'] . ':&nbsp;';
//                    echo "</div>";
                // Show "sign up for reCAPCHA API key"
                if ($content['form']["fields"][$key]['type'] == 'recaptcha') {
                    include_once (PHPWCMS_ROOT . '/include/inc_ext/recaptchalib.php');
                    echo '<a href="' . recaptcha_get_signup_url($phpwcms['parse_url']['host'], 'phpwcms') . '" target="_blank">' . $BL['be_cnt_field']['recaptcha_signapikey'] . '</a>';
                }

                echo '<a class="botoes"><i class="fas fa-times"></i> Excluir</a>';

                echo "</span></div>\n";
                echo '<div class="bloco-card card-form">' . LF;
                echo '<span  id="formRow_' . $field_counter . '">';
                echo '<a href="#" onclick="return showHide_CntFormfieldRow(\'formRow_' . $field_counter . '\', \'none\'';

                // some field specific checks and settings
                switch ($content['form']["fields"][$key]['type']) {

                    case 'newsletter':  // default hide/show
                        echo ', 5';

                        //$field_row4 = '<tr' . $field_bg . ' id="formRow_' . $field_counter . '_5">' . LF;
                        $field_row4 = '<div' . $field_bg . ' id="formRow_' . $field_counter . '_5">' . LF;
                        //$field_row4 .= '<td colspan="2" class="chatlist" align="right" valign="top">';
                        $field_row4 .= $BL['be_cnt_bid_verifyemail'] . ':&nbsp;' . LF;
                        // $field_row4 .= $BL['be_cnt_bid_verifyemail'] . ':&nbsp;</td>' . LF;
                        $field_row4 .= '<textarea name="cform_field_verifyemail" ';
                        //$field_row4 .= '<td colspan="6"><textarea name="cform_field_verifyemail" ';
                        $field_row4 .= 'id="cform_field_verifyemail" rows="5" wrap="off">';
                        $field_row4 .= html($content['form']['verifyemail']) . '</textarea>';
                        $field_row4 .= LF . '</div>' . LF;

                        $field_js['showAll'][$key] .= ', 5';
                        $field_js['hideAll'][$key] .= ', 5';

                        break;

                    case 'text':
                    case 'codigo':
                    case 'special':
                    case 'email':
                    case 'password':
                    case 'hidden':
                    case 'select':
                    case 'selectemail':
                    case 'country':
                    case 'radio':   // default hide/show
                        if ($content['form']["saveprofile"]) {
                            echo ', 5';

                            $field_row4 = '<div id="formRow_' . $field_counter . '_5">' . LF;
                            $field_row4 .= '' . $BL['be_cnt_store_in'] . '' . LF;
                            $field_row4 .= '<span id="cform_field_profile_' . $field_counter . '_td">';

                            if (!empty($content['form']["fields"][$key]['profile']) && isset($content['profile_fields_varchar'][$content['form']["fields"][$key]['profile']])) {

                                $field_js['varcharFields'][$field_counter] = '<"+"option value=\"' . $content['form']["fields"][$key]['profile'] . '\" selected=\"selected\">';
                                $field_js['varcharFields'][$field_counter] .= $content['profile_fields_varchar'][$content['form']["fields"][$key]['profile']] . '<"+"/option>';
                                unset($content['profile_fields_varchar'][$content['form']["fields"][$key]['profile']]);
                            } else {

                                $field_js['varcharFields'][$field_counter] = '';
                            }

                            $field_row4 .= '</span>' . LF . '</div>' . LF;

                            $field_js['showAll'][$key] .= ', 5';
                            $field_js['hideAll'][$key] .= ', 5';
                        }
                        break;


                    case 'textarea':
                    case 'checkbox':
                    case 'checkboxcopy':
                    case 'list':   // default hide/show
                        if ($content['form']["saveprofile"]) {
                            echo ', 5';

                            $field_row4 = '<div' . $field_bg . ' id="formRow_' . $field_counter . '_5">' . LF;
                            $field_row4 .= '' . $BL['be_cnt_store_in'] . '' . LF;
                            $field_row4 .= '<span id="cform_field_profile_' . $field_counter . '_td">';

                            if (!empty($content['form']["fields"][$key]['profile']) && isset($content['profile_fields_longtext'][$content['form']["fields"][$key]['profile']])) {

                                $field_js['longtextFields'][$field_counter] = '<"+"option value=\"' . $content['form']["fields"][$key]['profile'] . '\" selected=\"selected\">';
                                $field_js['longtextFields'][$field_counter] .= $content['profile_fields_longtext'][$content['form']["fields"][$key]['profile']] . '<"+"/option>';
                                unset($content['profile_fields_longtext'][$content['form']["fields"][$key]['profile']]);
                            } else {

                                $field_js['longtextFields'][$field_counter] = '';
                            }

                            $field_row4 .= '</span>' . LF . '</div>' . LF;

                            $field_js['showAll'][$key] .= ', 5';
                            $field_js['hideAll'][$key] .= ', 5';
                        }
                        break;


                    case 'mathspam':
                    case 'recaptcha': $_ini_values = $content['form']["fields"][$key]['value'];
                        $content['form']["fields"][$key]['value'] = '';

                        foreach ($_ini_values as $item_key => $item) {

                            $content['form']["fields"][$key]['value'] .= $item_key . ' = ' . $item . LF;
                        }

                        $content['form']["fields"][$key]['value'] = trim($content['form']["fields"][$key]['value']);

                        unset($_ini_values);

                        break;
                }

                echo ')">  </a>';
//                    echo '</span>' . LF . '<div class="grid-6">';
                echo '</span>' . LF . '';
                echo '<div class="grid-3">';
                echo '<p><b>Tipo de Campo</b><select name="cform_field_type[' . $field_counter . ']">' . LF;
                echo '<option value="text"' . is_selected('text', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['text'] . '</option>' . LF;
                echo '<option value="codigo"' . is_selected('codigo', $content['form']["fields"][$key]['type'], 0, 0) . '>Codigo</option>' . LF;
                echo '<option value="textarea"' . is_selected('textarea', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['textarea'] . '</option>' . LF;
                echo '<option value="special"' . is_selected('special', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['special'] . '</option>' . LF;
                echo '<option value="hidden"' . is_selected('hidden', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['hidden'] . '</option>' . LF;
                echo '<option value="password"' . is_selected('password', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['password'] . '</option>' . LF;
                echo '<option value="email"' . is_selected('email', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['email'] . '</option>' . LF;
                echo '<option value="selectemail"' . is_selected('selectemail', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['selectemail'] . '</option>' . LF;
                echo '<option value="select"' . is_selected('select', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['select'] . '</option>' . LF;
                echo '<option value="country"' . is_selected('country', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['country'] . '</option>' . LF;
                echo '<option value="list"' . is_selected('list', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['list'] . '</option>' . LF;
                echo '<option value="newsletter"' . is_selected('newsletter', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['newsletter'] . '</option>' . LF;
                echo '<option value="checkbox"' . is_selected('checkbox', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['checkbox'] . '</option>' . LF;
                echo '<option value="checkboxcopy"' . is_selected('checkboxcopy', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['checkboxcopy'] . '</option>' . LF;
                echo '<option value="radio"' . is_selected('radio', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['radio'] . '</option>' . LF;
                echo '<option value="upload"' . is_selected('upload', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['upload'] . '</option>' . LF;
                echo '<option value="recaptcha"' . is_selected('recaptcha', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['recaptcha'] . '</option>' . LF;
                echo '<option value="captcha"' . is_selected('captcha', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['captcha'] . '</option>' . LF;
                echo '<option value="captchaimg"' . is_selected('captchaimg', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['captchaimg'] . '</option>' . LF;
                echo '<option value="mathspam"' . is_selected('mathspam', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['mathspam'] . '</option>' . LF;
                echo '<option value="submit"' . is_selected('submit', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['submit'] . '</option>' . LF;
                echo '<option value="reset"' . is_selected('reset', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['reset'] . '</option>' . LF;
                echo '<option value="break"' . is_selected('break', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['break'] . '</option>' . LF;
                echo '<option value="breaktext"' . is_selected('breaktext', $content['form']["fields"][$key]['type'], 0, 0) . '>' . $BL['be_cnt_field']['breaktext'] . '</option>' . LF;
                echo '</select></p>';

                echo '<p><b>Nome do Campo</b><input type="text" name="cform_field_name[' . $field_counter . ']"  value="';
                echo html($content['form']["fields"][$key]['name']) . '"></p>' . LF;
//                    echo '<p><b>Label</b><input type="text" name="cform_field_label[' . $field_counter . ']"  value="';
//                    echo html($content['form']["fields"][$key]['label']) . '"></p>' . LF;
//                    echo '<p><b>S/C</b><input type="text" name="cform_field_size[' . $field_counter . ']"  value="';
//                    echo html($content['form']["fields"][$key]['size']) . '"title="SIZE for Text/COLUMNS for Textarea"></p>' . LF;
//                    echo '<p><b>M/R</b><input type="text" name="cform_field_max[' . $field_counter . ']"  value="';
//                    echo html($content['form']["fields"][$key]['max']) . '" title="MAXLENGTH for Text/ROWS for Textarea and List"></p>' . LF;
                echo '<p><label class="botoes"><input type="checkbox" name="cform_field_required[' . $field_counter . ']"';
                echo is_checked('1', $content['form']["fields"][$key]['required'], 0, 0) . ' value="1" title="' . $BL['be_cnt_mark_as_req'] . '"> Obrigatório</label></p>' . LF;
//                echo '<p><label class="botoes"><input type="checkbox" name="cform_field_delete[' . $field_counter . ']" value="1" title="' . $BL['be_cnt_mark_as_del'] . '"> Excluir</label></p>';
                echo '</div>';
//                    echo "\n</div>\n";

                echo '<div class="barra"></div>';

                echo '<h3>Valores</h3><p><textarea class="valores-form" name="cform_field_value[' . $field_counter . ']" ';
                echo 'id="cform_field_value_' . $field_counter . '" rows="5">';
                echo html($content['form']["fields"][$key]['value']) . '</textarea></p>';

//                    echo '</td>';
//                    echo '<p><a class="botoes" href="#field_value_' . $field_counter . '" ';
//                    echo "onclick=\"contractField('cform_field_value_" . $field_counter . "', 'V')\">";
//                    echo '<i class="far fa-minus-square"></i></a>';
//                    echo '<a class="botoes" href="#field_value_' . $field_counter . '" ';
//                    echo "onclick=\"growField('cform_field_value_" . $field_counter . "', 'V')\">";
//                    echo '<i class="far fa-plus-square"></i></a>';
//                    echo '</p>';
                echo '' . LF;

                echo '<p id="formRow_' . $field_counter . '_2">';
                echo '<b>' . $BL['be_newsletter_placeholder'] . '</b>';
                echo '<input type="text" name="cform_field_placeholder[' . $field_counter . ']" value="';
                echo empty($content['form']["fields"][$key]['placeholder']) ? '' : html($content['form']["fields"][$key]['placeholder']);
                echo '" ">' . LF . '</p>' . LF;

//                    echo '<p' . $field_bg . ' id="formRow_' . $field_counter . '_3">';
//                    echo '<b>' . $BL['be_cnt_error_text'] . '</b>';
//                    echo '<input type="text" name="cform_field_error[' . $field_counter . ']" value="';
//                    echo html($content['form']["fields"][$key]['error']) . '" ';
//                    if ($content['form']["fields"][$key]['type'] == 'upload') {
//                        echo ' title="{MAXLENGTH}, {FILESIZE}, {FILENAME}, {FILEEXT}"';
//                    }
//                    echo '>' . LF . '</p>' . LF;
//                    echo '<p' . $field_bg . ' id="formRow_' . $field_counter . '_4">';
//                    echo '<b>' . $BL['be_cnt_css_class'] . '</b>';
//                    echo '<input type="text" name="cform_field_class[' . $field_counter . ']" value="';
//                    echo html($content['form']["fields"][$key]['class']) . '">' . LF;
//                    echo '</p><p><b>
//			 ' . $BL['be_cnt_css_style'] . '</b>
//			 <input type="text" name="cform_field_style[' . $field_counter . ']" value="';
//                    echo html($content['form']["fields"][$key]['style']) . '" >';
//                    echo "\n</p>\n";
                echo '</div><div class="espacamento"></div><div class="espacamento"></div>';

                // if field row 4
                echo $field_row4;

//                    echo '<tr bgcolor="#DAE4ED"><td colspan="8"><img src="img/leer.gif" width="1" height="1" alt="" /></td></tr>';
                // generate javascript code part 2
                $field_js['showAll'][$key] .= ');';
                $field_js['hideAll'][$key] .= ');';

                $field_counter++;
            }
        }
        ?>
<!--            <tr>

        <td colspan="8">-->
        <div class="bloco-card card-form">
            <div class="grid-3">
                <p>
                    <b>Tipo do Campo</b>
                    <select name="cform_field_type[0]" onchange="setFieldValue(this);">
                        <option value="text"><?php echo $BL['be_cnt_field']['text'] ?></option>
                        <option value="textarea"><?php echo $BL['be_cnt_field']['textarea'] ?></option>
                        <option value="special"><?php echo $BL['be_cnt_field']['special'] ?></option>
                        <option value="hidden"><?php echo $BL['be_cnt_field']['hidden'] ?></option>
                        <option value="password"><?php echo $BL['be_cnt_field']['password'] ?></option>
                        <option value="email"><?php echo $BL['be_cnt_field']['email'] ?></option>
                        <option value="selectemail"><?php echo $BL['be_cnt_field']['selectemail'] ?></option>
                        <option value="select"><?php echo $BL['be_cnt_field']['select'] ?></option>
                        <option value="country"><?php echo $BL['be_cnt_field']['country'] ?></option>
                        <option value="list"><?php echo $BL['be_cnt_field']['list'] ?></option>
                        <?php if (empty($for_newsletter)): ?>
                            <option value="newsletter"><?php echo $BL['be_cnt_field']['newsletter'] ?></option>
                        <?php endif; ?>
                        <option value="checkbox"><?php echo $BL['be_cnt_field']['checkbox'] ?></option>
                        <option value="checkboxcopy"><?php echo $BL['be_cnt_field']['checkboxcopy'] ?></option>
                        <option value="radio"><?php echo $BL['be_cnt_field']['radio'] ?></option>
                        <option value="upload"><?php echo $BL['be_cnt_field']['upload'] ?></option>
                        <?php if (!defined('RECAPTCHA_API_SERVER')): ?>
                            <option value="recaptcha"><?php echo $BL['be_cnt_field']['recaptcha'] ?></option>
                        <?php endif; ?>
                        <option value="captcha"><?php echo $BL['be_cnt_field']['captcha'] ?></option>
                        <option value="captchaimg"><?php echo $BL['be_cnt_field']['captchaimg'] ?></option>
                        <option value="mathspam"><?php echo $BL['be_cnt_field']['mathspam'] ?></option>
                        <option value="submit"><?php echo $BL['be_cnt_field']['submit'] ?></option>
                        <option value="reset"><?php echo $BL['be_cnt_field']['reset'] ?></option>
                        <option value="break"><?php echo $BL['be_cnt_field']['break'] ?></option>
                        <option value="breaktext"><?php echo $BL['be_cnt_field']['breaktext'] ?></option>
                    </select>
                </p>

                <p>
                    <b>Nome do Campo</b>
                    <input type="text" name="cform_field_name[0]" />
                </p>

<!--                        <p>
    <b>Label</b>
    <input type="text" name="cform_field_label[0]" />
</p>-->
<!--                        <p>
    <b>S/C</b>
    <input type="text" name="cform_field_size[0]" title="SIZE for Text/COLUMNS for Textarea" />
</p>-->
<!--                        <p>
    <b>M/R</b>
    <input type="text" name="cform_field_max[0]" title="MAXLENGTH for Text/ROWS for Textarea and List" />
</p>-->

                <p>
                    <label class="botoes"><input type="checkbox" name="cform_field_required[0]" value="1" title="mark as required field" /> Obrigatório </label>
                </p>
                <input type="hidden" name="cform_order[0]" value="<?php echo $field_counter ?>" />
            </div>
            <div class="barra"></div>

            <a name="field_value_0" id="field_value_0"></a>
            <h3><?php echo $BL['be_cnt_value'] ?></h3>
            <p>
                <textarea name="cform_field_value[0]" id="cform_field_value_0" rows="5" ></textarea>

<!--<a href="#field_value_0" onclick="contractField('cform_field_value_0', 'V')"><img src="img/button/minus_11x11.gif" border="0" alt="-" width="11" height="11" /></a>-->
<!--<a href="#field_value_0" onclick="growField('cform_field_value_0', 'V')"><img src="img/button/add_13x13.gif" border="0" alt="+" width="13" height="13" /></a>-->
            </p>

            <p>
                <b><?php echo $BL['be_newsletter_placeholder'] ?></b>
                <input type="text" name="cform_field_placeholder[0]" />
            </p>

<!--                        <p>
    <b><?php echo $BL['be_cnt_error_text'] ?></b>
    <input type="text" name="cform_field_error[0]" />
</p>-->

<!--                        <p>
    <b><?php echo $BL['be_cnt_css_class'] ?></b>
    <input type="text" name="cform_field_class[0]" />
</p>-->

<!--                        <p>
    <b><?php echo $BL['be_cnt_css_style'] ?></b>
    <input type="text" name="cform_field_style[0]" />
</p>-->

            <p>
                <input class="button10" type="submit" value="<?php echo $BL['be_article_cnt_button1'] ?>" class="v09" />
            </p>
        </div>





        <?php
        if (!empty($field_counter) && $field_counter > 1) {

            echo '<script type="text/javascript">' . LF;

            echo 'function hideAllFormFields() {' . LF;
            echo implode(LF, $field_js['hideAll']);
            echo LF . '}' . LF;

            echo 'function showAllFormFields() {' . LF;
            echo implode(LF, $field_js['showAll']);
            echo LF . '}' . LF . LF;

            echo 'hideAllFormFields();' . LF . LF;


            // set options lists
            if ($content['form']["saveprofile"]) {

                $field_js['options'] = '';
                foreach ($content['profile_fields_varchar'] as $fieldKey => $fieldValue) {
                    $field_js['options'] .= '<"+"option value=\"' . $fieldKey . '\">' . $fieldValue . '<"+"/option>';
                }

                foreach ($field_js['varcharFields'] as $tdID => $tdIDvalue) {

                    $field_value = 'document.getElementById("cform_field_profile_' . $tdID . '_td").innerHTML = "';
                    $field_value .= '<"+"select name=\"cform_field_profile[' . $tdID . ']\" id=\"cform_field_profile_' . $tdID . '\" class=\"v10\">';
                    $field_value .= '<"+"option value=\"\">-<"+"/option>';
                    $field_value .= $tdIDvalue;
                    $field_value .= $field_js['options'];
                    $field_value .= '<"+"/select>";' . LF;

                    echo $field_value;
                }

                $field_js['options'] = '';
                foreach ($content['profile_fields_longtext'] as $fieldKey => $fieldValue) {
                    $field_js['options'] .= '<"+"option value=\"' . $fieldKey . '\">' . $fieldValue . '<"+"/option>';
                }

                foreach ($field_js['longtextFields'] as $tdID => $tdIDvalue) {

                    $field_value = 'document.getElementById("cform_field_profile_' . $tdID . '_td").innerHTML = "';
                    $field_value .= '<"+"select name=\"cform_field_profile[' . $tdID . ']\" id=\"cform_field_profile_' . $tdID . '\" class=\"v10\">';
                    $field_value .= '<"+"option value=\"\">-<"+"/option>';
                    $field_value .= $tdIDvalue;
                    $field_value .= $field_js['options'];
                    $field_value .= '<"+"/select>";' . LF;

                    echo $field_value;
                }
            }

            echo LF . '</script>';
        }
        ?></td>
</tr>


<tr><td class="chatlist" colspan="2">
        <a name="anchor_template" id="anchor_template"></a>
        <div class="barra"></div>
        <!--<h2><?php echo $BL['be_cnt_recipient'] . ' - ' . $BL['be_admin_struct_template'] ?></h2>-->
        <h2>Email de Reposta </h2>

        <p class="espacar-campo">
            <label class="botoes" for="cform_template_text">
                <input type="radio" name="cform_template_format" id="cform_template_text" value="0"<?php is_checked('0', $content['form']["template_format"]) ?> onchange="this.form.submit();" />
                TEXTO
            </label>

            <label class="botoes" for="cform_template_html">
                <input type="radio" name="cform_template_format" id="cform_template_html" value="1"<?php is_checked('1', $content['form']["template_format"]) ?> onchange="this.form.submit();" />
                HTML
            </label>
        </p>

        <div class="espacamento"></div>

<!--        <p>  
            <b>Tags Disponíveis</b>
        <?php
        if (!$content['form']["template_format"] && $for_select != '') {
            echo '<select name="ph" id="ph" ';
            echo 'onChange="insertAtCursorPos(document.articlecontent.cform_template, ';
            echo 'document.articlecontent.ph.options[document.articlecontent.ph.selectedIndex].value);">';
            echo $for_select;
            echo '<option value="{FORM_URL}">{FORM_URL}</option>' . LF;
            echo '<option value="{REMOTE_IP}">{REMOTE_IP}</option>' . LF;
            echo '<option value="{DATE:y/m/d H:i:s}">{DATE:y/m/d H:i:s}</option>' . LF;
            echo '</select>';
            echo '<a class="botoes" ';
            echo 'onclick="insertAtCursorPos(document.articlecontent.cform_template, ';
            echo 'document.articlecontent.ph.options[document.articlecontent.ph.selectedIndex].value);"  alt="" /><i class="fas fa-chevron-right"></i></a>';
        }
        ?>
        </p>-->

    </td>
</tr>


<tr>
    <td colspan="2"><?php
        if ($content['form']["template_format"]) {
            $wysiwyg_editor = array(
                'value' => $content['form']["template"],
                'field' => 'cform_template',
                'height' => '350px',
                'width' => '536px',
                'rows' => '15',
                'editor' => $_SESSION["WYSIWYG_EDITOR"],
                'lang' => 'en'
            );
            include(PHPWCMS_ROOT . '/include/inc_lib/wysiwyg.editor.inc.php');
        } else {

            echo '<p><textarea class="textarea-form" name="cform_template" id="cform_template" rows="5 ';
            echo 'onselect="setCursorPos(this);" onclick="setCursorPos(this);" onkeyup="setCursorPos(this);">';
            echo html($content['form']["template"]) . '</textarea></p>';
            ?>
            <div style="text-align:right;padding:2px;padding-right:5px;">
                <a href="#anchor_template" onclick="contractField('cform_template', 'V')"><img src="img/button/minus_11x11.gif" border="0" alt="-" width="11" height="11" /></a><a href="#anchor_template" onclick="growField('cform_template', 'V')"><img src="img/button/add_13x13.gif" border="0" alt="+" width="13" height="13" /></a>
            </div>
            <?php
        }
        ?>

<!--        <p>
    <b><?php echo $BL['php_function'] ?></b>
    <input name="cform_function_to" type="text" id="cform_function_to" class="v11 width200" value="<?php echo html($content['form']['function_to']) ?>" size="40" />
</p>-->

        <div class="barra"></div>

        <a name="anchor_template_copy" id="anchor_template_copy"></a>
        <!-- <?php echo $BL['be_cnt_send_copy_to'] . ' - ' . $BL['be_admin_struct_template'] ?> -->

        <h2>Email de Copia</h2>
        <div class="espacamento"></div>
        <p>
            <label class="botoes" for="cform_template_equal">
                <input type="checkbox" name="cform_template_equal" id="cform_template_equal" value="1"<?php is_checked(1, $content['form']["template_equal"]) ?> onchange="showhidecopy()" />
                <!--&nbsp;= <?php echo $BL['be_cnt_recipient'] . ' - ' . $BL['be_admin_struct_template'] ?>&nbsp;&nbsp;-->
                Email de Cópia igual ao Email de Resposta
            </label>
        </p>

        <div class="barra"></div>

        <script type="text/javascript">
<!--

            function showhidecopy() {

                var tcopy = $('cform_template_equal').checked;

                if (tcopy) {

                    $('copytemplate1').setStyle('display', 'none');
                    $('copytemplate2').setStyle('display', 'none');
                    $('copytemplate3').setStyle('display', 'none');

                } else {

                    $('copytemplate1').setStyle('display', '');
                    $('copytemplate2').setStyle('display', '');
                    $('copytemplate3').setStyle('display', '');

                }

            }

            window.addEvent('domready', function () {

                showhidecopy();

            });

//-->
</script> </td>
</tr>
<tr id="copytemplate1">
        <td colspan="2"  class="tdtop3">
            
            <p class="espacar-campo">
                <label class="botoes" for="cform_template_text_copy">
                    <input type="radio" name="cform_template_format_copy" id="cform_template_text_copy" value="0"<?php is_checked(0, $content['form']["template_format_copy"]) ?>  onchange="this.form.submit();" />
                    TEXTO
                </label>
                
                <label class="botoes" for="cform_template_html_copy">
                    <input type="radio" name="cform_template_format_copy" id="cform_template_html_copy" value="1"<?php is_checked(1, $content['form']["template_format_copy"]) ?> onchange="this.form.submit();" />
                    HTML
                </label>
            </p>
            
<!--            <p>
                <b>Tags Disponíveis</b>
                <?php
                    if (!$content['form']["template_format_copy"] && $for_select != '') {
                        echo '<select name="phc" id="phc" ';
                        echo 'onchange="insertAtCursorPos(document.articlecontent.cform_template_copy, ';
                        echo 'document.articlecontent.phc.options[document.articlecontent.phc.selectedIndex].value);">';
                        echo $for_select;
                        echo '<option value="{FORM_URL}">{FORM_URL}</option>' . LF;
                        echo '<option value="{REMOTE_IP}">{REMOTE_IP}</option>' . LF;
                        echo '<option value="{DATE:y/m/d H:i:s}">{DATE:y/m/d H:i:s}</option>' . LF;
                        echo '</select>';
                        echo '<a class="botoes"';
                        echo 'onclick="insertAtCursorPos(document.articlecontent.cform_template_copy, ';
                        echo 'document.articlecontent.phc.options[document.articlecontent.phc.selectedIndex].value);" /><i class="fas fa-chevron-right"></i></a>';
                    }
                    ?>
            </p>-->
            
           
           </td>
    </tr>

    <tr id="copytemplate2">
        <td colspan="2">
        
        </td>
    </tr>

    <tr id="copytemplate3">
        <td colspan="2">
            <p>
            <?php
            if ($content['form']["template_format_copy"]) {
                $wysiwyg_editor = array(
                    'value' => $content['form']["template_copy"],
                    'field' => 'cform_template_copy',
                    'height' => '350',
                    'width' => '536px',
                    'rows' => '15',
                    'editor' => $_SESSION["WYSIWYG_EDITOR"],
                    'lang' => 'en'
                );
                include(PHPWCMS_ROOT . '/include/inc_lib/wysiwyg.editor.inc.php');
            } else {

                echo '<textarea class="textarea-form" name="cform_template_copy" id="cform_template_copy" ';
                echo 'onselect="setCursorPos(this);" onclick="setCursorPos(this);" onkeyup="setCursorPos(this);">';
                echo html($content['form']["template_copy"]) . '</textarea>';
                ?>
<!--                <div style="text-align:right;padding:2px;padding-right:5px;">
                    <a href="#anchor_template_copy" onclick="contractField('cform_template_copy', 'V')"><img src="img/button/minus_11x11.gif" border="0" alt="-" width="11" height="11" /></a><a href="#anchor_template_copy" onclick="growField('cform_template_copy', 'V')"><img src="img/button/add_13x13.gif" border="0" alt="+" width="13" height="13" /></a>
                </div>-->
                <?php
            }
            ?>
            </p>
        </td>
    </tr>


<!--    <tr>

        <td colspan="2">
            <p>
                <b><?php echo $BL['php_function'] ?></b>
                <input name="cform_function_cc" type="text" id="cform_function_cc" class="v11 width200" value="<?php echo html($content['form']['function_cc']) ?>" size="40" />
            </p>
        </td>
    </tr>-->


    <tr>
        <td  colspan="2" >
            <a name="anchor_customform" id="anchor_customform"></a>
                <!-- <?php echo $BL['be_admin_struct_template'] ?> -->
                <h2>Código HTML do Formulário</h2>
                <div class="espacamento"></div>
<!--                <p>   <b>Tags Disponíveis</b>       
     
    <?php
    if ($for_select_2 != '') {
        echo '';
        echo '<select name="ph1" id="ph1" ';
        echo 'onChange="insertAtCursorPos(document.articlecontent.cform_customform, ';
        echo 'document.articlecontent.ph1.options[document.articlecontent.ph1.selectedIndex].value);">';
        echo $for_select_2 . '</select>';
        echo '<a class="botoes"  ';
        echo 'onclick="insertAtCursorPos(document.articlecontent.cform_customform, ';
        echo 'document.articlecontent.ph1.options[document.articlecontent.ph1.selectedIndex].value);" /><i class="fas fa-chevron-right"></i></a>';
        echo '';
    }
    ?>
                </p>-->

                <textarea class="textarea-form" name="cform_customform" id="cform_customform" rows="5" onselect="setCursorPos(this);" onclick="setCursorPos(this);" onkeyup="setCursorPos(this);"><?php echo html($content['form']["customform"]) ?></textarea>
         
                <!--<a href="#anchor_customform" onclick="contractField('cform_customform', 'V')"><img src="img/button/minus_11x11.gif" border="0" alt="-" width="11" height="11" /></a><a href="#anchor_customform" onclick="growField('cform_customform', 'V')"><img src="img/button/add_13x13.gif" border="0" alt="+" width="13" height="13" /></a>-->
        </td>
    </tr>

