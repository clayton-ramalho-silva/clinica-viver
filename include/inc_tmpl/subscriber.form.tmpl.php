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
?>
<form action="phpwcms.php?do=messages&amp;p=4&amp;s=<?php echo $_userInfo['subscriber_data']['address_id'] ?>&amp;edit=1" method="post" name="editsubscriber" id="editsubscriber">
  

    <div class="dados-sumario">

        <p>
            <b><?php echo $BL['be_profile_label_email'] ?></b>

            <input name="subscribe_email" type="text" id="subscribe_email" class="<?php
//error class
            if (!empty($_userInfo['error']['email']))
                echo ' errorInputText';
            ?>" value="<?php echo html($_userInfo['subscriber_data']['address_email']) ?>" />
        </p>

        <p>
            <b><?php echo $BL['be_cnt_ecardform_name'] ?></b>
            <input name="subscribe_name" type="text" id="subscribe_name" value="<?php echo html($_userInfo['subscriber_data']['address_name']) ?>" size="30" />
        </p>

        <?php
        //echo $BL['be_cnt_subscription'];

        //retrieve available subscriptions
        $_userInfo['select_subscr'] = '';
        $_userInfo['subscr_all'] = 1;
        $_userInfo['subscriptions'] = _dbQuery("SELECT * FROM " . DB_PREPEND . "phpwcms_subscription ORDER BY subscription_name");

        $_userInfo['subscriber_data']['subscriptions'] = unserialize($_userInfo['subscriber_data']['address_subscription']);

        if ($_userInfo['subscriptions']) {

            foreach ($_userInfo['subscriptions'] as $value) {

                $_userInfo['select_subscr'] .= '<label class="botoes"><input type="checkbox" name="subscribe_to[]" id="subscribe_to' . $value['subscription_id'] . '" value="' . $value['subscription_id'] . '"';
                if (is_array($_userInfo['subscriber_data']['subscriptions']) && in_array($value['subscription_id'], $_userInfo['subscriber_data']['subscriptions'])) {

                    $_userInfo['select_subscr'] .= ' checked="checked"';
                    $_userInfo['subscr_all'] = 0;
                }
                $_userInfo['select_subscr'] .= ' />
				' . html($value['subscription_name']) .
                        '</label>
			
			';
            }
        }
        ?>



        <p style="display: none">
            <?php echo $_userInfo['select_subscr'] ?>
            <label class="botoes" for="subscribe_all">
                <input type="checkbox" name="subscribe_all" id="subscribe_all" value="1"<?php is_checked($_userInfo['subscr_all'], 1) ?> />
                <?php echo $BL['be_newsletter_allsubscriptions'] ?></label>
        </p>

        <p style="display: none">
            <?php echo $BL['be_ftptakeover_status'] ?>
            <label class="botoes" for="subscribe_active">
                <input type="checkbox" name="subscribe_active" id="subscribe_active" value="1"<?php is_checked($_userInfo['subscriber_data']['address_verified'], 1) ?> />
                <?php echo $BL['be_cnt_activated'] ?>
            </label>
        </p>
        
        
        <p class="botoes-newsletter fl">
            <input name="submit" type="submit" class="button10" value="<?php echo empty($_userInfo['subscriber_data']['address_id']) ? $BL['be_admin_fcat_button2'] : $BL['be_article_cnt_button1'] ?>" />
            <input name="save" type="submit" class="button10" value="<?php echo $BL['be_article_cnt_button3'] ?>" />
       
            <!--<input name="new" type="button" class="button10" value="<?php echo ucfirst($BL['be_msg_new']) ?>" onclick="location.href = 'phpwcms.php?do=messages&p=4&s=0&edit=1';return false;" />-->
            <input name="close" type="button" class="button10" value="<?php echo $BL['be_admin_struct_close'] ?>" onclick="location.href = 'phpwcms.php?do=messages&p=4';return false;" />
        </p>

        <div class="barra"></div>
        
    </div>

    <table border="0" cellpadding="0" cellspacing="0" summary="" class="dados-sumario" >

<!--	<tr> 
                <td align="right" class="chatlist"><?php echo $BL['be_cnt_last_edited'] ?>:&nbsp;</td>
                <td class="v10"><?php echo html($_userInfo['subscriber_data']['address_tstamp']) ?></td>
        </tr>-->


    </table>
</form>
