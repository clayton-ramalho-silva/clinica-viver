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

?>

<script>
accentsTidy = function(s){
	var str = s.toUpperCase();
	str = str.toLowerCase();

	str = str.replace(/[\u00E0\u00E1\u00E2\u00E3\u00E5]/g,'a');
	str = str.replace(/[\u00E7]/g,'c');
	str = str.replace(/[\u00E8\u00E9\u00EA\u00EB]/g,'e');
	str = str.replace(/[\u00EC\u00ED\u00EE\u00EF]/g,'i');
	str = str.replace(/[\u00F2\u00F3\u00F4\u00F5\u00F8]/g,'o');
	str = str.replace(/[\u00F9\u00FA\u00FB]/g,'u');
	str = str.replace(/[\u00FD\u00FF]/g,'y');
	str = str.replace(/[\u00F1]/g,'n');
	str = str.replace(/[\u0153\u00F6]/g,'oe');
	str = str.replace(/[\u00E6\u00E4]/g,'ae');
	str = str.replace(/[\u00DF]/g,'ss');
	str = str.replace(/[\u00FC]/g,'ue');

	str = str.replace(/\s+/g,'-');
	str = str.replace(/-+\/+-+/g,'/');
	str = str.replace('/', '-');
	str = str.replace(/[^a-z0-9_\-]+/g,'');
	str = str.replace(/\-+/g,'-');
	str = str.replace(/\/+/g,'/');
	str = str.replace(/_/g,'-');
	str = str.replace(/_+/g,'-');
	str = str.replace(/^-+|-+$/g, '');
	str = str.replace(/^\/+|\/+$/g, '');
	str = str.replace(/^-+|-+$/g, '');

	return str;
};

$().ready(function(e) {
    
	$('#cat_name').on('input', function(){
	
		var alias = $(this).val();
		$('#cat_alias').val(accentsTidy(alias));	
	
	});
	
});
</script>

<h1 class="title" style="margin-bottom:10px"><?php

	echo $BLM['cat_edit'];
	if($plugin['data']['cat_id'] && empty($plugin['data']['cat_pid']) ) {
		echo ' <span style="font-weight:normal">[ID: ' . $plugin['data']['cat_id'] . ']</span>';
	}

?></h1>

<div class="box-categorias fl">
    <form action="<?php echo shop_url( array('controller=categories', 'edit='.$plugin['data']['cat_id']) ) ?>" method="post">
        <input type="hidden" name="cat_id" value="<?php echo $plugin['data']['cat_id'] ?>" />
        <input type="hidden" name="cat_pasta" value="<?php echo $plugin['data']['cat_pasta'] ?>" />
        
    <?php if(!empty($plugin['data']['cat_createdate'])) { ?>
    <div class="box-categorias-info fl">
		<?php // ==== Data de Alteração e criação ==== ?>
        <strong><?php echo $BLM['cat_data_criacao']  ?>:</strong>
        <?php
        	echo html(date($BL['be_fprivedit_dateformat'], strtotime($plugin['data']['cat_createdate'])));
        ?>
         | <strong><?php echo $BLM['cat_data_alteracao']  ?>:</strong>
        <?php
        	echo html(date($BL['be_fprivedit_dateformat'], $plugin['data']['cat_changedate']));    
        ?>
    </div>
    <?php } ?>
   
    <div class="box-categorias-l fl">
    
		<?php // ========== Nome da Categoria ========== ?>
        <p>
            <strong>
                <?php 
					echo $BLM['cat_nome_categoria'].':';
					if(!empty($plugin['error']['cat_name'])){
						echo '<b>'.$plugin['error']['cat_name'].'</b>';
					}
				?>
                
            </strong>
            <input type="text" name="cat_name" id="cat_name"<?php
                if(!empty($plugin['error']['cat_name'])) echo ' class="errorInputText"';
            ?> value="<?php echo html($plugin['data']['cat_name']) ?>" />
        </p>
        
        <?php // ========== Subcategoria de ========== ?>
        <p>
            <strong>
                <?php echo $BLM['cat_nivel_categoria'] ?>:
            </strong>
            <select name="cat_pid" id="cat_pid">
            <?php
             //if($plugin['data']['cat_pid'] == 0) {
                echo '<option value="0" selected="selected">&nbsp;</option>' . LF;
             //}
             $sql  = 'SELECT * FROM '.DB_PREPEND."phpwcms_categories WHERE ";
             $sql .= "cat_type='module_shop' AND cat_pid=0 AND cat_status != 9 AND ";
             $sql .= "cat_id != " . $plugin['data']['cat_id'].' ORDER BY cat_name ASC';
             $plugin['data']['subcat'] = _dbQuery($sql);
             foreach($plugin['data']['subcat'] as $value) {
                            
                echo '<option value="' . $value['cat_id'] . '"';
                is_selected($plugin['data']['cat_pid'], $value['cat_id']);
                if($value['cat_status'] = 0) {
                    echo ' style="font-style:italic;"';
                }
                echo '>' . html($value['cat_name']) . '</option>' . LF;
                            
             }
            ?>
       		</select>
        </p>
        
        <?php // ==== URl (alias) ==== ?>
        <p>
            <strong>
                <a href="javascript:void(0)" onclick="return set_shop_cat_alias();">
					<?php echo $BLM['cat_url_categoria']; ?>
                </a>:
                <?php
                if(!empty($plugin['error']['cat_alias'])){
					echo '<b>'.$plugin['error']['cat_alias'].'</b>';
				}
				?>
            </strong>
            <input type="text" name="cat_alias" id="cat_alias" value="<?php echo html($plugin['data']['cat_alias']) ?>" onchange="this.value=create_alias_shop(this.value);" />
        </p>

    </div>
    
    <div class="box-categorias-r fl">
    
    	<?php // ========== Título do SEO ========== ?>
        <p>
            <strong>
                <?php echo $BLM['cat_seo_titulo'] ?>:
            </strong>
            <input type="text" name="cat_seo_tit" id="cat_seo_tit" value="<?php echo html($plugin['data']['cat_title']) ?>" />
        </p>
        
        <?php // ========== Descrição do SEO ========== ?>
        <p>
            <strong>
                <?php echo $BLM['cat_seo_descricao'] ?>:
            </strong>
            <textarea name="cat_seo_desc" id="cat_seo_desc"><?php echo html($plugin['data']['cat_description']) ?></textarea>
        </p>
    
    </div>
    
    <?php // ==== Texto de Informação ==== ?>
    <p>
    	<strong>
        	 <?php echo $BLM['cat_texto_informacao'] ?>:
        </strong>
		<?php
        $wysiwyg_editor = array(
            'value'		=> $plugin['data']['cat_info'],
            'field'		=> 'cat_info',
            'height2'	=> '120',
            'width2'	=> '977',
            'rows'		=> '5',
            'editor'	=> $_SESSION["WYSIWYG_EDITOR"],
            'lang'		=> 'en'
        );		
        include(PHPWCMS_ROOT.'/include/inc_lib/wysiwyg.editor.inc.php');
		?>
    </p>
    
    <div class="botoes-acao fr">
    	<?php // ==== Botões de ação ==== ?>
    	<input name="submit" type="submit" class="button10" value="<?php echo empty($plugin['data']['cat_id']) ? $BL['be_admin_fcat_button2'] : $BL['be_article_cnt_button1'] ?>" />
    	<input name="save" type="submit" class="button10" value="<?php echo $BL['be_article_cnt_button3'] ?>" />
    	<input name="close" type="submit" class="button10" value="<?php echo $BL['be_admin_struct_close'] ?>" />
    </div>
    
    <div class="box-categorias-check fr">
            
        <div class="box-categorias-ordem fr">
        <?php // ==== Campo de Ordenação (Sorting) ==== ?>
            <strong><?php echo $BLM['cat_num_ordenacao'] ?>:</strong>
            <input name="cat_sort" type="text" id="cat_sort" class="v10 width50" value="<?php echo empty($plugin['data']['cat_sort']) ? 0 : intval($plugin['data']['cat_sort']) ?>" />
        </div>
        
        <div class="box-categorias-ativo fr">
		<?php // ==== Botão de Status ==== ?>
            <strong><?php echo $BL['be_cnt_activated'] ?>:</strong>
            <input type="checkbox" name="cat_status" id="cat_status" value="1"<?php is_checked($plugin['data']['cat_status'], 1) ?> />
        </div>
        
    </div>
        
    </form>
</div>