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

if((!isset($_POST['feReminder']) && isset($_POST['user_login'])) || (!isset($_POST['feReminder']) && isset($_POST['new_login']))) {
	$_loginData['session_key']	= session_id();
	$_loginData['error']		= false;
	$_loginData['login']		= '';
	$_loginData['password']		= '';
	$_loginData['remember']		= 0;
	$_loginData['remind_data']	= '';
		
	$_loginData['felogin_profile_registration']	= 0;
	$_loginData['felogin_profile_manage']		= 0;
	$_loginData['validate_db']['userdetail']	= 1;
	$_loginData['validate_db']['backenduser']	= 0;
	
	// handle Login
	if(isset($_POST['user_login']) || isset($_POST['new_login'])) {
		if(isset($_POST['user_login'])){	
			$_loginData['login']		= slweg($_POST['user_login']);
			$_loginData['password']		= slweg($_POST['user_senha']);
		} elseif(isset($_POST['new_login'])){
			$_loginData['login']		= slweg($_POST['new_login']);
			$_loginData['password']		= slweg($_POST['new_pass']);
		}
		$_loginData['remember']		= empty($_POST['feRemember']) ? 0 : 1;
		
		$_loginData['query_result'] = _checkShopLogin($_loginData['login'], md5($_loginData['password']), $_loginData['validate_db']);
		
		// ok, and now check if we got valid login data
		if($_loginData['query_result'] !== false && is_array($_loginData['query_result']) && count($_loginData['query_result'])) {
			$_SESSION[ $_loginData['session_key'] ]				= $_loginData['login'];
			$_SESSION[ $_loginData['session_key'].'_userdata']	= _getFrontendUserBaseData($_loginData['query_result']);
			
			$url = rel_url(array('shop_cart' => 'show'), array('shop_detail','l'), $_tmpl['config']['cart_url']);
			$url = str_replace('&amp;', '&', $url);
			header('Location: '.$url.'&l=1');
					
			if($_loginData['remember'] && !empty($_loginData['felogin_cookie_expire'])) {
				setcookie('phpwcmsFeLoginRemember', $_loginData['login'].'##-|-##'.md5($_loginData['password']).'##-|-##'.$_loginData['validate_db']['userdetail'].'##-|-##'.$_loginData['validate_db']['backenduser'], time()+$_loginData['felogin_cookie_expire'], '/', getCookieDomain());
			}
		} else {
			$_loginData['error'] = true;
		}
	} 
}

if(isset($_POST['feReminder']) && isset($_POST['feLogin'])) {
	
		$_loginData['remind_data'] = slweg($_POST['feReminder']);
	
		// check if valid email - send login
		if( $_loginData['remind_data'] && is_valid_email($_loginData['remind_data']) ) {
		
			if($_loginData['validate_db']['userdetail']) {
				$sql  = 'SELECT detail_login AS LOGIN, detail_email AS EMAIL FROM '.DB_PREPEND."phpwcms_userdetail WHERE LOWER(detail_email)='";
				$sql .= aporeplace(strtolower($_loginData['remind_data']))."' LIMIT 1";
				$result = _dbQuery($sql);
			}
			
			// hm, seems no user found - OK test against cms users
			if($_loginData['validate_db']['backenduser'] && !isset($result[0])) {
				$sql  = 'SELECT usr_login AS LOGIN, usr_email AS EMAIL FROM '.DB_PREPEND.'phpwcms_user WHERE ';
				$sql .= "LOWER(usr_email)='".aporeplace(strtolower($_loginData['remind_data']))."' LIMIT 1";
				$result = _dbQuery($sql);
			}
			
			if(isset($result[0])) {
				$_loginData['remind_login'] = $result[0];
			}

		// otherwise check login and send password
		} elseif($_loginData['remind_data']) {

			if($_loginData['validate_db']['userdetail']) {
				$sql  = 'SELECT detail_id, detail_login AS LOGIN, detail_email AS EMAIL FROM '.DB_PREPEND."phpwcms_userdetail WHERE ";
				$sql .= "detail_login='".aporeplace($_loginData['remind_data'])."' LIMIT 1";
				$result = _dbQuery($sql);
				
				if(isset($result[0])) {
					$result[0]['PASSWORD'] = generic_string(8);
					_dbUpdate('phpwcms_userdetail', array('detail_password'=>md5($result[0]['PASSWORD'])), 'WHERE detail_id='.$result[0]['detail_id']);
					$_loginData['remind_password'] = $result[0];
				}
			}
			
			// hm, seems no user found - OK test against cms users
			if($_loginData['validate_db']['backenduser'] && !isset($result[0])) {
				$sql  = 'SELECT usr_id, usr_login AS LOGIN, usr_email AS EMAIL FROM '.DB_PREPEND.'phpwcms_user WHERE ';
				$sql .= "usr_login='".aporeplace($_loginData['remind_data'])."' LIMIT 1";
				$result = _dbQuery($sql);
				
				if(isset($result[0])) {
					$result[0]['PASSWORD'] = generic_string(8);
					_dbUpdate('phpwcms_user', array('usr_pass'=>md5($result[0]['PASSWORD'])), 'WHERE usr_id='.$result[0]['usr_id']);
					$_loginData['remind_password'] = $result[0];
				}
			}
		}
	
		if(isset($_loginData['remind_password']) || isset($_loginData['remind_login'])) {
		
			$_loginData['reminder'] = $_loginData['reminder_success'];
		
			$_loginData['LOGIN_URL'] = rel_url(array(), array('profile_manage', 'profile_register', 'profile_reminder') );
		
			$_loginData['reminder_email'] = str_replace('{LOGIN_URL}', PHPWCMS_URL . $_loginData['LOGIN_URL'], $_loginData['reminder_email']);
			
			if(isset($_loginData['remind_password'])) {
			
				$_loginData['reminder_email']	= str_replace('{LOGIN}', $_loginData['remind_password']['LOGIN'], $_loginData['reminder_email']);
				$_loginData['reminder_email']	= str_replace('{PASSWORD}', $_loginData['remind_password']['PASSWORD'], $_loginData['reminder_email']);
				$_loginData['reminder_to']		= $_loginData['remind_password']['EMAIL'];
			
				$_loginData['reminder_email_body'] = returnTagContent( $_loginData['reminder_email'], 'PASSWORD_EMAIL' );
				$_loginData['reminder_email_body'] = $_loginData['reminder_email_body']['tag'];
				
			} else {
			
				$_loginData['reminder_email']	= str_replace('{LOGIN}', $_loginData['remind_login']['LOGIN'], $_loginData['reminder_email']);
				$_loginData['reminder_to']		= $_loginData['remind_login']['EMAIL'];
				
				$_loginData['reminder_email_body'] = returnTagContent( $_loginData['reminder_email'], 'LOGIN_EMAIL' );
				$_loginData['reminder_email_body'] = $_loginData['reminder_email_body']['tag'];
			
			}
		
			$_loginData['reminder_email_subject'] =  returnTagContent( $_loginData['reminder_email'], 'SUBJECT' ) ;
			$_loginData['reminder_email_subject'] =  trim( $_loginData['reminder_email_subject']['tag'] );
			
			@sendEmail( array(	'recipient' => $_loginData['reminder_to'], 
								'subject' => $_loginData['reminder_email_subject'],
								'text' => $_loginData['reminder_email_body'] 
							) );			
		} else {
			$_loginData['error'] = true;
		}
	}
	
	// register profile default
	$_loginData['get_profile_register']	= 'create';
	$_loginData['get_profile_manage']	= 'edit';

	if(_getFeUserLoginStatus()) {
		// proof if "former" redirect URL is known and redirect
		if(!empty($_SESSION['LOGIN_REDIRECT'])) {
			$linkto = $_SESSION['LOGIN_REDIRECT'];
			unset($_SESSION['LOGIN_REDIRECT']);
			//headerRedirect($linkto);
		
		// user is logged in
		} elseif(isset($_POST['feLogin'])) {
			//$url = rel_url(array('shop_cart' => 'show'), array('shop_detail','l'), $_tmpl['config']['cart_url']);
			//$url = str_replace('&amp;', '&', $url);
			header('Location: http://www.webcis.com.br');
		}
		
		// manage account
		if($_loginData['felogin_profile_manage'] && isset($_getVar['profile_manage'])) {
			$_loginData['get_profile_manage'] = strval($_getVar['profile_manage']);
			$_loginData['template']	 = $_loginData['manage'];
		} else {
			$_loginData['template']	= $_loginData['logged_in'];
			$_loginData['template']	= str_replace('{LOGIN}', html_specialchars( $_SESSION[ $_loginData['session_key'] ] ), $_loginData['template']);
		}
	
	// check if user can register and if register form should be displayed
	} elseif($_loginData['felogin_profile_registration'] && isset($_getVar['profile_register'])) {
	
		$_loginData['get_profile_register'] = strval($_getVar['profile_register']);
	
		$_loginData['template'] = $_loginData['register'];	
		
	} elseif(isset($_POST['feReminder']) || isset($_getVar['profile_reminder'])) {
		
		$_loginData['template'] = render_cnt_template($_loginData['reminder'], 'ERROR', ($_loginData['error'] ? 'login/email wrong' : '') );
		$_loginData['template'] = render_cnt_template($_loginData['template'], 'REMINDER', html_specialchars($_loginData['remind_data']) );
	
	} else {
	
		$_loginData['template'] = render_cnt_template($_loginData['template'], 'ERROR', ($_loginData['error'] ? 'login/pass wrong' : '') );
		$_loginData['template'] = render_cnt_template($_loginData['template'], 'LOGIN', html_specialchars($_loginData['login']));
		$_loginData['template'] = render_cnt_template($_loginData['template'], 'PASSWORD', '');
		$_loginData['template'] = render_cnt_template($_loginData['template'], 'REMEMBER', ($_loginData['remember'] ? ' checked="checked"' : '') );
	
	}
	
	// check register profile
	if($_loginData['felogin_profile_registration']) {
		// possible -> set link to form
		$_loginData['uri'] = rel_url( array('profile_register'=>$_loginData['get_profile_register']), array('profile_manage', 'profile_reminder') );
		$_loginData['template'] = render_cnt_template($_loginData['template'], 'REGISTER_PROFILE', $_loginData['uri'] );
	} else {
		// not possible
		$_loginData['template'] = render_cnt_template($_loginData['template'], 'REGISTER_PROFILE', '' );
	}
	
	// check manage profile
	if($_loginData['felogin_profile_manage']) {
		
		if(isset($_GET['profile_manage'])) {
			$_loginData['template'] = render_cnt_template($_loginData['template'], 'MANAGE_PROFILE', '' );
		}
		
		// possible -> set link to form
		$_loginData['uri'] = rel_url(
			array('profile_manage'=>$_loginData['get_profile_manage']),
			array('profile_register', 'profile_reminder'),
			empty($_loginData['felogin_profile_manage_redirect']) ? '' : $_loginData['felogin_profile_manage_redirect']
		);
		$_loginData['template'] = render_cnt_template($_loginData['template'], 'MANAGE_PROFILE', $_loginData['uri'] );

	} else {
		// not possible	
		$_loginData['template'] = render_cnt_template($_loginData['template'], 'MANAGE_PROFILE', '' );
	}
	
	$_loginData['uri'] = rel_url( array('profile_reminder'=>'1'), array('profile_manage', 'profile_register') );
	$_loginData['template'] = render_cnt_template($_loginData['template'], 'REMINDER_FORM', $_loginData['uri'] );
	
	$_loginData['uri'] = rel_url( array(), array('profile_manage', 'profile_register', 'profile_reminder') );
	$CNT_TMP .=  str_replace(array('{FORM_TARGET}', '{LOGIN_URL}'), $_loginData['uri'], $_loginData['template']);

?>