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

session_start();

//error_reporting(E_ALL);
$phpwcms = array();
require_once ('config/phpwcms/conf.inc.php');
$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);

/* !!!!! ******** ATENÇÃO ******** !!!!! */
/* QUANDO ESTIVER TUDO PRONTO, COPIAR ESSES ARQUIVOS PARA A FERRAMENTA E SUBSTITUIR PELOS ORIGINAIS:
 - include/inc_front/content/cnt23.article.inc.php
 - include/inc_tmpl/content/cnt23.inc.php
/* !!!!! ******** ATENÇÃO ******** !!!!! */


// =================================
// ------------ Funções ------------
// =================================
function observacao($campo, $valor){
	if(isset($_GET['cod'])){
		if(!empty($valor)){		
			$campo = '<span><strong>Observação:</strong><br />'.$valor.'</span>';
		} else {
			$campo = '';
		}
   	} else {
   		$campo = '<textarea id="'.$campo.'" name="'.$campo.'">'.$valor.'</textarea>';
	}
	return $campo;
}
		
function obs($valor){
	if(empty($valor)){
		echo $valor;
	} else {
		echo ' - '.$valor;
	}
}
		
function arquivo($valor){
	$arquivo = explode('/', $valor);
	$final = end($arquivo);
	if(empty($final)){
		return false;
	} else {
		echo '<i>Anexo: <a href="'.$valor.'" target="_blank">'.$final.'</a></i>';
	}
}
// ================================
// -------- Fim das Funções -------
// ================================


// ===========================================
// -------- Código HTML Topo e Rodapé --------
// ===========================================

/* ------ Topo da Página ----- */
$topo = '
<link rel="stylesheet" type="text/css" href="template/config/teste/css.css"/>
<link rel="stylesheet" type="text/css" href="template/config/teste/frontend.css"/>
<div class="topo-sistema fl"><div class="topo-auditor"></div></div>
<div class="banner-interna fl"></div>
<div class="corpo-full-interna fl">
	<div class="corpo al">';
		
/* ------ Rodapé da Página ----- */
$rodape = '
	</div>
</div>
<div id="footerBlock">
	<div class="li-rod">
		<div class="li-rod-horario fr ac"></div>
  	</div>
</div>';

// ===========================================
// ------ Fim Código HTML Topo e Rodapé ------
// ===========================================

if(isset($_GET['fid']) && ($fid = intval($_GET['fid']))) {
		
	// ===== Área que mostra o HTML de um questionário específico =====
	if(isset($_GET['cod'])){
		$consulta_form = "SELECT *, DATE_FORMAT(formresult_createdate, '%Y-%m-%d %H:%i:%s') AS formresult_date FROM phpwcms_formresult WHERE formresult_id = '".$_GET['cod']."'";
		$dados = mysqli_query($conexao, $consulta_form);
		$row = mysqli_fetch_array($dados);
		$info = unserialize($row['formresult_content']);
		
		echo $topo;
		?>
			<h3>Questionário - <? echo $info['empresa']; ?></h3>
			Nome do Responsável: <? echo $info['nome'] ?><br />
			E-mail: <? echo $info['email'] ?><br /><br />
			<h4>Respostas do Questionário</h4>
			<div class="box-pergunta fl">
				<b>Pergunta 1</b>
    			<p>
       				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis nisl eros, in consectetur est sodales a. Vivamus faucibus lacinia sapien nec pretium. Maecenas vehicula ligula eget nunc lacinia ultrices. Sed quis dui rhoncus, gravida nulla quis, tincidunt lectus. Curabitur blandit lobortis felis eget lacinia. Curabitur tempor faucibus euismod. Ut iaculis massa non elit fermentum facilisis.
        			<span><strong>Resposta: </strong>
						<? echo $info['perguntaa'];
						   echo obs($info['obs_perguntaa']); ?>
                    </span>
        			<? echo arquivo($info['filea']);
					   echo observacao('obsa', $info['obsa']); ?>
    			</p>
			</div>

				<div class="box-pergunta fl">
					<b>Pergunta 2</b>
    				<p>
       				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis nisl eros, in consectetur est sodales a. Vivamus faucibus lacinia sapien nec pretium. Maecenas vehicula ligula eget nunc lacinia ultrices. Sed quis dui rhoncus, gravida nulla quis, tincidunt lectus. Curabitur blandit lobortis felis eget lacinia. Curabitur tempor faucibus euismod. Ut iaculis massa non elit fermentum facilisis.
        			<span><strong>Resposta: </strong>
						<? echo $info['perguntab'];
						   echo obs($info['obs_perguntab']); ?>
                    </span>
        			<? echo arquivo($info['fileb']);
					   echo observacao('obsb', $info['obsb']); ?>
    			</p>
				</div>

				<div class="box-pergunta fl">
					<b>Pergunta 3</b>
					<p>
       				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis nisl eros, in consectetur est sodales a. Vivamus faucibus lacinia sapien nec pretium. Maecenas vehicula ligula eget nunc lacinia ultrices. Sed quis dui rhoncus, gravida nulla quis, tincidunt lectus. Curabitur blandit lobortis felis eget lacinia. Curabitur tempor faucibus euismod. Ut iaculis massa non elit fermentum facilisis.
        			<span><strong>Resposta: </strong>
						<? echo $info['perguntac'];
						   echo obs($info['obs_perguntac']); ?>
                    </span>
        			<? echo arquivo($info['filec']);
					   echo observacao('obsc', $info['obsc']); ?>
    			</p>
				</div>

				<div class="box-pergunta fl">
					<b>Pergunta 4</b>
    				<p>
       				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis nisl eros, in consectetur est sodales a. Vivamus faucibus lacinia sapien nec pretium. Maecenas vehicula ligula eget nunc lacinia ultrices. Sed quis dui rhoncus, gravida nulla quis, tincidunt lectus. Curabitur blandit lobortis felis eget lacinia. Curabitur tempor faucibus euismod. Ut iaculis massa non elit fermentum facilisis.
        			<span><strong>Resposta: </strong>
						<? echo $info['perguntad'];
						   echo obs($info['obs_perguntad']); ?>
                    </span>
        			<? echo arquivo($info['filed']);
					   echo observacao('obsd', $info['obsd']); ?>
    			</p>
				</div>

				<div class="box-pergunta fl">
					<b>Pergunta 5</b>
    				<p>
       				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis nisl eros, in consectetur est sodales a. Vivamus faucibus lacinia sapien nec pretium. Maecenas vehicula ligula eget nunc lacinia ultrices. Sed quis dui rhoncus, gravida nulla quis, tincidunt lectus. Curabitur blandit lobortis felis eget lacinia. Curabitur tempor faucibus euismod. Ut iaculis massa non elit fermentum facilisis.
        			<span><strong>Resposta: </strong>
						<? echo $info['perguntae'];
						   echo obs($info['obs_perguntae']); ?>
                    </span>
        			<? echo arquivo($info['filee']);
					   echo observacao('obse', $info['obse']); ?>
    			</p>
				</div>

				<div class="box-pergunta fl">
					<b>Pergunta 6</b>
    				<p>
       				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis nisl eros, in consectetur est sodales a. Vivamus faucibus lacinia sapien nec pretium. Maecenas vehicula ligula eget nunc lacinia ultrices. Sed quis dui rhoncus, gravida nulla quis, tincidunt lectus. Curabitur blandit lobortis felis eget lacinia. Curabitur tempor faucibus euismod. Ut iaculis massa non elit fermentum facilisis.
        			<span><strong>Resposta: </strong>
						<? echo $info['perguntaf'];
						   echo obs($info['obs_perguntaf']); ?>
                    </span>
        			<? echo arquivo($info['filef']);
					   echo observacao('obsf', $info['obsf']); ?>
    			</p>
				</div>

				<div class="box-pergunta fl">
					<b>Pergunta 7</b>
    				<p>
       				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis nisl eros, in consectetur est sodales a. Vivamus faucibus lacinia sapien nec pretium. Maecenas vehicula ligula eget nunc lacinia ultrices. Sed quis dui rhoncus, gravida nulla quis, tincidunt lectus. Curabitur blandit lobortis felis eget lacinia. Curabitur tempor faucibus euismod. Ut iaculis massa non elit fermentum facilisis.
        			<span><strong>Resposta: </strong>
						<? echo $info['perguntag'];
						   echo obs($info['obs_perguntag']); ?>
                    </span>
        			<? echo arquivo($info['fileg']);
					   echo observacao('obsg', $info['obsg']); ?>
    			</p>
				</div>

				<div class="box-pergunta fl">
					<b>Pergunta 8</b>
    				<p>
       				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis nisl eros, in consectetur est sodales a. Vivamus faucibus lacinia sapien nec pretium. Maecenas vehicula ligula eget nunc lacinia ultrices. Sed quis dui rhoncus, gravida nulla quis, tincidunt lectus. Curabitur blandit lobortis felis eget lacinia. Curabitur tempor faucibus euismod. Ut iaculis massa non elit fermentum facilisis.
        			<span><strong>Resposta: </strong>
						<? echo $info['perguntah'];
						   echo obs($info['obs_perguntah']); ?>
                    </span>
        			<? echo arquivo($info['fileh']);
					   echo observacao('obsh', $info['obsh']); ?>
    			</p>
				</div>

				<div class="box-pergunta fl">
					<b>Pergunta 9</b>
    				<p>
       				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis nisl eros, in consectetur est sodales a. Vivamus faucibus lacinia sapien nec pretium. Maecenas vehicula ligula eget nunc lacinia ultrices. Sed quis dui rhoncus, gravida nulla quis, tincidunt lectus. Curabitur blandit lobortis felis eget lacinia. Curabitur tempor faucibus euismod. Ut iaculis massa non elit fermentum facilisis.
        			<span><strong>Resposta: </strong>
						<? echo $info['perguntai'];
						   echo obs($info['obs_perguntai']); ?>
                    </span>
        			<? echo arquivo($info['filei']);
					   echo observacao('obsi', $info['obsi']); ?>
    			</p>
				</div>

				<div class="box-pergunta fl">
					<b>Pergunta 10</b>
    				<p>
       				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis nisl eros, in consectetur est sodales a. Vivamus faucibus lacinia sapien nec pretium. Maecenas vehicula ligula eget nunc lacinia ultrices. Sed quis dui rhoncus, gravida nulla quis, tincidunt lectus. Curabitur blandit lobortis felis eget lacinia. Curabitur tempor faucibus euismod. Ut iaculis massa non elit fermentum facilisis.
        			<span><strong>Resposta: </strong>
						<? echo $info['perguntaj'];
						   echo obs($info['obs_perguntaj']); ?>
                    </span>
        			<? echo arquivo($info['filej']);
					   echo observacao('obsj', $info['obsj']); ?>
    			</p>
				</div>
	<?php 
	
	} else {
	?>
    	Questionário não encontrado. Por favor pesquise novamente.
        <a href="export-usuario.php">Voltar</a>
    <?php
	}
} else {
		$meses = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
		$anos = array('2015','2016','2017','2018','2019','2020','2021','2022','2023','2024','2025');
		$codigo = $_POST['busca-codigo'];
		$num_codigo = strlen($codigo);
		$mes = $_POST['busca-mes'];
		$num_mes = strlen($mes);
		$ano = $_POST['busca-ano'];
		$num_ano = strlen($ano);
		echo $topo;
		?>
		
		<p>Pesquise pelo e-mail cadastrado para visualizar os formulários preenchidos.</p>
		<form id="buscar" method="post" action=""> 
			<input type="text" name="busca-codigo" id="busca-codigo" value="<?php echo $codigo; ?>" />
			<select id="busca-mes" name="busca-mes">
				<option value="">Todos os Meses</option>
				<?
				foreach($meses as $value){
					if($value == $mes){$sel = ' selected="selected"';} else {$sel = '';}
					?>
					<option value="<?php echo $value; ?>"<?php echo $sel; ?>><?php echo $value; ?></option>
					<?
                }
				?>
			</select>
			<select id="busca-ano" name="busca-ano">
				<option value="">Todos os Anos</option>
				<?
				foreach($anos as $value){
					if($value == $ano){$sel = ' selected="selected"';} else {$sel = '';}
					?>
					<option value="<?php echo $value; ?>"<?php echo $sel; ?>><?php echo $value; ?></option>
					<?
                }
				?>
			</select>
			<input type="submit" name="enviar-busca" id="enviar-busca" value="Pesquisar" />
		</form>
        
		<?php
		if(isset($_POST['enviar-busca'])){
			$consulta_form = "SELECT * FROM phpwcms_formresult WHERE formresult_content LIKE '%\"email\";s:".$num_codigo.":\"".$codigo."\";%'";
			if(!empty($mes)){
				$consulta_form .=  " AND formresult_content LIKE '%\"mes\";s:".$num_mes.":\"".$mes."\";%'";
			}
			if(!empty($ano)){
				$consulta_form .=  " AND formresult_content LIKE '%\"ano\";s:".$num_ano.":\"".$ano."\";%'";
			}
			$dados = mysqli_query($conexao, $consulta_form);
			
        	while($row = mysqli_fetch_array($dados)){
        	?>
				<div class="lista-questionarios fl">
					<? echo $row['formresult_empresa'].' - '.$row['formresult_mes']; ?>
                	<a href="export-usuario.php?fid=<? echo $row['formresult_pid']; ?>&cod=<? echo $row['formresult_id']; ?>">Editar</a>
            	</div>
			<?
        	}
		}
}

echo $rodape;

?>