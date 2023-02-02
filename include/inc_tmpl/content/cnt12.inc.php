<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <oliver@phpwcms.de>
 * @copyright Copyright (c) 2002-2014, Oliver Georgi
 * @license http://opensource.org/licenses/GPL-2.0 GNU GPL-2
 * @link http://www.phpwcms.de
 *
 **/

// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------


//newsletter subscription
?>

<!--<tr>
  <td align="right" valign="top" class="chatlist"><img src="img/leer.gif" alt="" width="1" height="13" /><?php echo $BL['be_cnt_subscription'] ?>:&nbsp;</td>
  <td valign="top"><?php

	$content["newsletter"]['left']	= array();
	$content["newsletter"]['right']	= array();
	
	// default = all subscriptions
	$content["newsletter"]['right'][0] = $BL['be_newsletter_allsubscriptions'];
	
	// retrieve all available subscriptions first
	$result = _dbQuery("SELECT * FROM ".DB_PREPEND."phpwcms_subscription ORDER BY subscription_name");
	foreach($result as $row) {
		$content["newsletter"]['right'][ $row["subscription_id"] ] = html($row["subscription_name"]);
	}
	
	if(isset($content["newsletter"]["subscription"]) && is_array($content["newsletter"]["subscription"])) {
		foreach($content["newsletter"]["subscription"] as $row => $result) {
			if(isset($content["newsletter"]['right'][ $row ])) {
				$content["newsletter"]['left'][ $row ] = $content["newsletter"]['right'][ $row ];
				unset($content["newsletter"]['right'][ $row ]);
			}
		}
	}

	echo createOptionTransferSelectList(	'cnewsletter_subscription', 
											$content["newsletter"]['left'], 
											$content["newsletter"]['right'], 
											array('class'=>'optionTransfer', 'formname'=>'articlecontent', 'rows'=>7));

	?></td>
  <td>&nbsp;</td>
</tr>-->


<tr class="cnt-newsletter">
    <td colspan="2">
                    <div class="espacamento"></div>

        <h2>Dados para envio</h2>
<!--        <p>
            <b><?php echo $BL['be_cnt_labelemail'] ?></b>
            <input name="cnewsletter_label_email" type="text" id="cnewsletter_label_email" value="<?php echo  isset($content["newsletter"]["label_email"]) ? $content["newsletter"]["label_email"] : '' ?>" size="20" maxlength="100">
        </p>
        -->
<!--        <p>
            <b> <?php 
		
		echo $BL['be_cnt_tablealign'];
		if(!isset($content["newsletter"]["pos"])) $content["newsletter"]["pos"] = 0;
		
		?>
            </b>
               <select name="cnewsletter_pos" class="f10" id="cnewsletter_pos">
		  <option value="0" <?php is_selected(0, $content["newsletter"]["pos"]) ?>><?php echo $BL['be_cnt_default'] ?></option>
		  <option value="1" <?php is_selected(1, $content["newsletter"]["pos"]) ?>><?php echo $BL['be_cnt_left'] ?></option>
		  <option value="2" <?php is_selected(2, $content["newsletter"]["pos"]) ?>><?php echo $BL['be_cnt_center'] ?></option>
		</select> 
        </p>-->
<!--        <p>
            <b><?php echo $BL['be_cnt_labelname'] ?></b>
            <input name="cnewsletter_label_name" type="text" id="cnewsletter_label_name" value="<?php echo  isset($content["newsletter"]["label_name"]) ? $content["newsletter"]["label_name"] : '' ?>" size="20" maxlength="100">
        </p>-->
        
<!--        <p>
            <b><?php echo $BL['be_cnt_buttontext'] ?></b>
            <input name="cnewsletter_button_text" type="text" id="cnewsletter_button_text" value="<?php echo  isset($content["newsletter"]["button_text"]) ? $content["newsletter"]["button_text"] : '' ?>" size="40" maxlength="50">
        </p>-->
        
<!--        <p>
            <b><?php echo $BL['be_cnt_labelsubsc'] ?></b>
            <input name="cnewsletter_label_subscriptions" type="text" id="cnewsletter_label_subscriptions" value="<?php echo  isset($content["newsletter"]["label_subscriptions"]) ? $content["newsletter"]["label_subscriptions"] : '' ?>" size="20" maxlength="100">
        </p>-->
        
<!--        <p>
            <b><?php echo $BL['be_cnt_allsubsc'] ?> </b>
            <input name="cnewsletter_all_subscriptions" type="text" id="cnewsletter_all_subscriptions" value="<?php echo  isset($content["newsletter"]["all_subscriptions"]) ? $content["newsletter"]["all_subscriptions"] : '' ?>" size="40" maxlength="50">
        </p>-->
        
<!--        <p>
            <b><?php echo $BL['be_cnt_infotext'] ?></b>
            <textarea name="cnewsletter_text" rows="8" id="cnewsletter_text"><?php echo  isset($content["newsletter"]["text"]) ? $content["newsletter"]["text"] : '' ?></textarea>
        </p>-->
        
        <p>
            <h3><?php echo $BL['be_cnt_successtext'] ?></h3>
            <div class="espacamento"></div>
            <textarea name="cnewsletter_success_text" rows="5" id="cnewsletter_success_text"><?php echo  isset($content["newsletter"]["success_text"]) ? $content["newsletter"]["success_text"] : 'Obrigado, seu e-mail foi cadastrado com sucesso em nossos sistemas.' ?></textarea>
        </p>
        
<!--        <p>
            <b>URL 1</b>
            <input name="cnewsletter_url1" type="text" id="cnewsletter_url1" value="<?php echo isset($content["newsletter"]["url1"]) ? html($content["newsletter"]["url1"]) : '' ?>" size="20" />
        </p>-->
        
<!--        <p>
            <b>URL 2</b>
            <input name="cnewsletter_url2" type="text" id="cnewsletter_url2" value="<?php echo isset($content["newsletter"]["url2"]) ? html($content["newsletter"]["url2"]) : '' ?>" size="20" />
            
        </p>-->
        
        <p>
            {NEWSLETTER_NAME}, {NEWSLETTER_EMAIL}, {NEWSLETTER_VERIFY}, {NEWSLETTER_DELETE}, {IP}, {DATE:m/d/Y}, [SUBJECT][/SUBJECT]
        </p>
        
        <p>
            <h3><?php echo $BL['be_cnt_regmail'] ?></h3>
            <div class="espacamento"></div>
            <textarea name="cnewsletter_reg_text" rows="5" wrap="OFF" id="cnewsletter_reg_text"><?php echo  isset($content["newsletter"]["reg_text"]) ? $content["newsletter"]["reg_text"] : '[SUBJECT]{EMPRESA}[/SUBJECT]

Olá {NEWSLETTER_NAME}, você se inscreveu em nosso site para receber novidades por e-mail.
Seu e-mail: {NEWSLETTER_EMAIL}

Para confirmar o seu cadastro clique no link abaixo.
{NEWSLETTER_VERIFY}

Para apagar seu cadastro a partir de nossa base de dados clique no link abaixo:
{NEWSLETTER_DELETE}


Atenciosamente 
{EMPRESA}
' ?></textarea>
            
            
        </p>
       
        <p>
            <h3><?php echo $BL['be_cnt_logoffmail'] ?></h3>
            <div class="espacamento"></div>
            <textarea name="cnewsletter_logoff_text" rows="5" wrap="OFF"  id="cnewsletter_logoff_text"><?php echo  isset($content["newsletter"]["logoff_text"]) ? $content["newsletter"]["logoff_text"] : '' ?></textarea>
        </p>
        
        <p>
            <h3><?php echo $BL['be_cnt_changemail'] ?></h3>
            <div class="espacamento"></div>
            <textarea name="cnewsletter_change_text" rows="5" wrap="OFF" class="code" id="cnewsletter_change_text" ><?php echo  isset($content["newsletter"]["change_text"]) ? $content["newsletter"]["change_text"] : '' ?></textarea>
        </p>
        
    </td>
</tr>

