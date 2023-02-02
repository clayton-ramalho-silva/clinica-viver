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


if($action == 'edit') {


	$plugin['data']['cat_id']	= intval($_GET['edit']);

	if( isset($_POST['cat_id']) ) {
	
		// check if form should be closed only -> and back to listing mode
		if( isset($_POST['close']) ) {
			headerRedirect( shop_url('controller=categories', '') );
		}
	
		$plugin['data']['cat_changedate']	= time();
		$plugin['data']['cat_name']			= clean_slweg($_POST['cat_name']);
		$plugin['data']['cat_info']			= slweg($_POST['cat_info']);
		$plugin['data']['cat_status']		= empty($_POST['cat_status']) ? 0 : 1;
		$plugin['data']['cat_pid']			= intval($_POST['cat_pid']);
		$plugin['data']['cat_alias']		= clean_slweg($_POST['cat_alias']);
		$plugin['data']['cat_sort']			= intval($_POST['cat_sort']);
		$plugin['data']['cat_seo_tit']		= clean_slweg($_POST['cat_seo_tit']);
		$plugin['data']['cat_seo_desc']		= clean_slweg($_POST['cat_seo_desc']);
		$plugin['data']['cat_pasta']		= intval($_POST['cat_pasta']);
		
		// Confere se o nome não está em branco ou se já está sendo utilizado
		if(!$plugin['data']['cat_name']) {
			$plugin['error']['cat_name'] = $BLM['cat_sem_nome'];
		}
		/*
		 else {	
			$sql  = 'SELECT COUNT(cat_id) FROM '.DB_PREPEND.'phpwcms_categories WHERE ';
			$sql .= "cat_type='module_shop' AND cat_status != 9 AND cat_name LIKE '". aporeplace($plugin['data']['cat_name']) ."'";
			$sql .= $plugin['data']['cat_id'] ? ' AND cat_id != ' . $plugin['data']['cat_id'] : '';
			if( _dbQuery($sql, 'COUNT') ) {
				$plugin['error']['cat_name'] = $BLM['cat_nome_duplicado'];
			}
		}
		*/
		
		// Confere se o alias não está em branco ou se já está sendo utilizado
		if(!$plugin['data']['cat_alias']) {
			
			$plugin['error']['cat_alias'] = $BLM['cat_sem_alias'];
		
		} else {	
			
			$plugin['data']['cat_alias'] = checkUrl($conexao, $plugin['data']['cat_alias'], $plugin['data']['cat_id']);
			
			/*
			$sql  = 'SELECT cat_id FROM '.DB_PREPEND.'phpwcms_categories WHERE ';
			$sql .= 'cat_type="module_shop" AND cat_status != 9 AND cat_alias LIKE ';
			$sql .= '"'. aporeplace($plugin['data']['cat_alias']) .'"';
			$sql .= $plugin['data']['cat_id'] ? ' AND cat_id != ' . $plugin['data']['cat_id'] : '';
			
			$res  = mysqli_query($conexao,$sql);
			$num  = mysqli_num_rows($res);
			echo $num;
			
			if($num > 0){
				$partesAlias = explode('-',$plugin['data']['cat_alias']);
				var_dump($partesAlias);				
			}
			
			
			if( _dbQuery($sql, 'COUNT') ) {
				$plugin['error']['cat_alias'] = $BLM['cat_alias_duplicado'];
			}
			*/

		}
		
		if( empty($plugin['error'] )) {
			
			if($plugin['data']['cat_pid']){
					
				$sqlPasta = 'SELECT cat_pasta FROM phpwcms_categories WHERE cat_id = '.$plugin['data']['cat_pid'];
				$resPasta = mysqli_query($conexao,$sqlPasta);
				$pasta = mysqli_fetch_assoc($resPasta);
				
				$pastaAcima = $pasta['cat_pasta'] ? $pasta['cat_pasta'] : '5';
				
			} else {
				
				$pastaAcima = '5';
			
			}
		
			// Update
			if( $plugin['data']['cat_id'] ) {
				
				$sqlFolder  = 'UPDATE '.DB_PREPEND.'phpwcms_file SET ';
				$sqlFolder .= "f_pid = '".$pastaAcima."', ";
				$sqlFolder .= "f_tstamp = NOW(), ";
				$sqlFolder .= "f_name = '".aporeplace($plugin['data']['cat_name'])."' ";
				$sqlFolder .= "WHERE f_id = ".$plugin['data']['cat_pasta'];
				$resFolder  = mysqli_query($conexao, $sqlFolder) or die(mysqli_error($conexao));
				$pasta = mysqli_insert_id($conexao);
				
				$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_categories SET ';
				$sql .= "cat_changedate = '".aporeplace( date('Y-m-d H:i:s', $plugin['data']['cat_changedate']) )."', ";
				$sql .= "cat_pid = ".$plugin['data']['cat_pid'].", ";
				$sql .= "cat_status = ".$plugin['data']['cat_status'].", ";
				$sql .= "cat_name = '".aporeplace($plugin['data']['cat_name'])."', ";
				$sql .= "cat_info = '".aporeplace($plugin['data']['cat_info'])."', ";
				$sql .= "cat_alias = '".$plugin['data']['cat_alias']."', ";
				$sql .= "cat_sort = ".$plugin['data']['cat_sort'].", ";
				$sql .= "cat_title = '".aporeplace($plugin['data']['cat_seo_tit'])."', ";
				$sql .= "cat_description = '".aporeplace($plugin['data']['cat_seo_desc'])."' ";
				$sql .= "WHERE cat_type='module_shop' AND cat_id = " . $plugin['data']['cat_id'];
				
				_dbQuery($sql, 'UPDATE');
			
			// INSERT
			} else {
				
				$sqlFolder  = 'INSERT INTO '.DB_PREPEND.'phpwcms_file (';
				$sqlFolder .= 'f_pid, f_uid, f_kid, f_aktiv, f_public, f_tstamp, f_name, f_created, f_size ';
				$sqlFolder .= ') VALUES (';
				$sqlFolder .= "'".$pastaAcima."', ";
				$sqlFolder .= "'1', ";
				$sqlFolder .= "'0', ";
				$sqlFolder .= "'1', ";
				$sqlFolder .= "'1', ";
				$sqlFolder .= "NOW(), ";
				$sqlFolder .= "'".aporeplace($plugin['data']['cat_name'])."', ";
				$sqlFolder .= "NOW(), ";
				$sqlFolder .= "0";
				$sqlFolder .= ')';
				$resFolder  = mysqli_query($conexao, $sqlFolder) or die(mysqli_error($conexao));
				$pasta = mysqli_insert_id($conexao);


				$sql  = 'INSERT INTO '.DB_PREPEND.'phpwcms_categories (';
				$sql .= 'cat_type, cat_pid, cat_createdate, cat_changedate, cat_status, cat_name, cat_pasta, cat_info, cat_alias, cat_sort, cat_title, cat_description';
				$sql .= ') VALUES (';
				$sql .= "'module_shop', ";
				$sql .= $plugin['data']['cat_pid'].', ';
				$sql .= "'".aporeplace( date('Y-m-d H:i:s', $plugin['data']['cat_changedate']) )."', ";			
				$sql .= "'".aporeplace( date('Y-m-d H:i:s', $plugin['data']['cat_changedate']) )."', ";
				$sql .= $plugin['data']['cat_status'].", ";
				$sql .= "'".aporeplace($plugin['data']['cat_name'])."', ";
				$sql .= "'".$pasta."', ";
				$sql .= "'".aporeplace($plugin['data']['cat_info'])."',";
				$sql .= "'".aporeplace($plugin['data']['cat_alias'])."', ";
				$sql .= $plugin['data']['cat_sort'].", ";
				$sql .= "'".aporeplace($plugin['data']['cat_seo_tit'])."', ";
				$sql .= "'".aporeplace($plugin['data']['cat_seo_desc'])."'";
				$sql .= ')';
				$res  = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
				
				//$result = _dbQuery($sql, 'INSERT');
				
				//if( !empty($result['INSERT_ID']) ) {
					$plugin['data']['cat_id']	= mysqli_insert_id($conexao);
				//}
			
			}
		
			// save and back to listing mode
			if( isset($_POST['save']) ) {
				headerRedirect( shop_url('controller=categories', '') );
			} else {
				headerRedirect( shop_url( array('controller=categories', 'edit='.$plugin['data']['cat_id']), '') );
			}
			
		}


	} elseif( $plugin['data']['cat_id'] == 0 ) {
	
		$plugin['data']['cat_id']			= 0;
		$plugin['data']['cat_pid']			= 0;	
		$plugin['data']['cat_changedate']	= time();
		$plugin['data']['cat_name']			= '';
		$plugin['data']['cat_info']			= '';
		$plugin['data']['cat_status']		= 1;
		$plugin['data']['cat_alias']		= '';	
		$plugin['data']['cat_sort']			= 0;
		$plugin['data']['cat_seo_tit']		= '';
		$plugin['data']['cat_seo_desc']		= '';	
	
	} else {

		$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_categories WHERE ';
		$sql .= "cat_type='module_shop' AND cat_id = " . $plugin['data']['cat_id'] . ' LIMIT 1';

		$plugin['data'] = _dbQuery($sql);
		
		if( isset($plugin['data'][0]) ) {
			$plugin['data'] = $plugin['data'][0];

			$plugin['data']['cat_changedate'] = strtotime($plugin['data']['cat_changedate']);
			
		} else {
			headerRedirect( shop_url('controller=categories', '') );
		}

	}

} elseif($action == 'status') {

	list($plugin['data']['cat_id'], $plugin['data']['cat_status']) = explode( '-', $_GET['status'] );
	
	$plugin['data']['cat_id']		= intval($plugin['data']['cat_id']);
	$plugin['data']['cat_status']	= empty($plugin['data']['cat_status']) ? 1 : 0;

	$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_categories SET ';
	$sql .= "cat_status = ".$plugin['data']['cat_status']." ";
	$sql .= "WHERE cat_type='module_shop' AND cat_id = " . $plugin['data']['cat_id'];
	
	_dbQuery($sql, 'UPDATE');

	headerRedirect( shop_url('controller=categories', '') );

} elseif($action == 'delete') {

	$plugin['data']['cat_id']		= intval($_GET['delete']);

	$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_categories SET ';
	$sql .= "cat_status = 9 ";
	$sql .= "WHERE cat_type='module_shop' AND ";
	$sql .= "(cat_id = " . $plugin['data']['cat_id'] . " OR cat_pid = " . $plugin['data']['cat_id'] . ")";
	
	_dbQuery($sql, 'UPDATE');

	headerRedirect( shop_url('controller=categories', '') );

}

//$plugin['data']['cat_alias']
//$plugin['data']['cat_id']

function checkUrl($conexao,$alias,$id){
	
	$sql  = 'SELECT cat_id FROM '.DB_PREPEND.'phpwcms_categories WHERE ';
	$sql .= 'cat_type="module_shop" AND cat_status != 9 AND cat_alias LIKE ';
	$sql .= '"'. aporeplace($alias) .'" AND cat_id != '.$id;
	$res  = mysqli_query($conexao,$sql);
	$num  = mysqli_num_rows($res);
	
	if($num > 0){
		
		$partesAlias = explode('-',$alias);
		$ultimo = end($partesAlias);
		
		if(is_numeric($ultimo)){

			$novoNumero = (int)$ultimo + 1;
			$novoAlias = str_replace('-'.$ultimo, '-'.$novoNumero, $alias);
			
			$alias = checkUrl($conexao,$novoAlias,$id);
		
		} else {

			$alias = $alias.'-'.$num;
		
		}
				
	} else {
	
		$alias = $alias;
	
	}
	
	return $alias;

}


?>