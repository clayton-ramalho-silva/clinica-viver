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

error_reporting(E_ALL);

//error_reporting(E_ALL);
$phpwcms = array();
require_once ('config/phpwcms/conf.inc.php');
require_once ('include/inc_lib/default.inc.php');
require_once ('include/inc_lib/dbcon.inc.php');
require_once ('include/inc_lib/general.inc.php');
checkLogin();
$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);

$consulta_sol = 'SELECT * FROM phpwcms_user WHERE usr_id = "'.$_SESSION["wcs_user_id"].'"';
$sol = mysqli_query($conexao, $consulta_sol);

$checar = "SHOW COLUMNS FROM `phpwcms_formresult` LIKE 'formresult_email'";
$result = mysqli_query($conexao, $checar);
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if(!$exists) {
   $criar1 = 'ALTER TABLE phpwcms_formresult ADD formresult_empresa VARCHAR(255) NOT NULL after formresult_ip';
   $result1 = mysqli_query($conexao, $criar1);
   
   $criar2 = 'ALTER TABLE phpwcms_formresult ADD formresult_email VARCHAR(255) NOT NULL after formresult_empresa';
   $result2 = mysqli_query($conexao, $criar2);
   
   $criar3 = 'ALTER TABLE phpwcms_formresult ADD formresult_mes VARCHAR(255) NOT NULL after formresult_email';
   $result3 = mysqli_query($conexao, $criar3);
   
   $criar4 = 'ALTER TABLE phpwcms_formresult ADD formresult_ano VARCHAR(255) NOT NULL after formresult_mes';
   $result4 = mysqli_query($conexao, $criar4);
} else {
}

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
	if(isset($_GET['q'])){
		$consulta_form = "SELECT *, DATE_FORMAT(formresult_createdate, '%Y-%m-%d %H:%i:%s') AS formresult_date FROM phpwcms_formresult WHERE formresult_pid = ".$fid." AND formresult_id = ".$_GET['q']."";
		$dados = mysqli_query($conexao, $consulta_form);
		$row = mysqli_fetch_array($dados);
		$info = unserialize($row['formresult_content']);
		
		if(isset($_POST['salvar-questionario'])){				
			$valores =  array(
				'auditor_sms_confirmacao_agendamento' => $_POST['auditor_sms_confirmacao_agendamento'],
				'auditor_sms_confirmacao_presenca' => $_POST['auditor_sms_confirmacao_presenca'],
				'auditor_callback' => $_POST['auditor_callback'],
				'auditor_nao_agendar_rx' => $_POST['auditor_nao_agendar_rx'],
				'auditor_contato_ativo_cliente' => $_POST['auditor_contato_ativo_cliente'],
				'auditor_recuperacao_no_show' => $_POST['auditor_recuperacao_no_show'],
				'auditor_pre_autorizacao_exames' => $_POST['auditor_pre_autorizacao_exames'],
				'auditor_script_ocupacao' => $_POST['auditor_script_ocupacao'],
				'auditor_estudo_forecast' => $_POST['auditor_estudo_forecast'],
				'auditor_gestao_vista' => $_POST['auditor_gestao_vista'],
				'auditor_email_agendamento' => $_POST['auditor_email_agendamento'],
				'auditor_pesquisa_satisfacao' => $_POST['auditor_pesquisa_satisfacao'],
				'auditor_agenda_rm' => $_POST['auditor_agenda_rm'],
				'auditor_codigo_barras_processo' => $_POST['auditor_codigo_barras_processo'],
				'auditor_ris' => $_POST['auditor_ris'],
				'auditor_utilizacao_scanner' => $_POST['auditor_utilizacao_scanner'],
				'auditor_impressao_papel' => $_POST['auditor_impressao_papel'],
				'auditor_entrega_imagens' => $_POST['auditor_entrega_imagens'],
				'auditor_impressao_laudo' => $_POST['auditor_impressao_laudo'],
				'auditor_preenchimento_tiss' => $_POST['auditor_preenchimento_tiss'],
				'auditor_envio_faturamento' => $_POST['auditor_envio_faturamento'],
				'auditor_kit_padrao' => $_POST['auditor_kit_padrao'],
				'auditor_sistema_totem' => $_POST['auditor_sistema_totem'],
				'auditor_equipe_dedicada' => $_POST['auditor_equipe_dedicada'],
				'auditor_pre_autorizacao_exame' => $_POST['auditor_pre_autorizacao_exame'],
				'auditor_identificacao_paciente' => $_POST['auditor_identificacao_paciente'],
				'auditor_backup' => $_POST['auditor_backup'],
				'auditor_seguranca' => $_POST['auditor_seguranca'],
				'auditor_prioridade' => $_POST['auditor_prioridade'],
				'auditor_tablets' => $_POST['auditor_tablets'],
				'auditor_epis' => $_POST['auditor_epis'],
				'auditor_norma' => $_POST['auditor_norma'],
				'auditor_ppra' => $_POST['auditor_ppra'],
				'auditor_canais_comunicacao' => $_POST['auditor_canais_comunicacao'],
				'auditor_descricao_cargos' => $_POST['auditor_descricao_cargos'],
				'auditor_avaliacao_desempenho' => $_POST['auditor_avaliacao_desempenho'],
				'auditor_clima' => $_POST['auditor_clima'],
				'auditor_acidente' => $_POST['auditor_acidente'],
				'auditor_treinamentos' => $_POST['auditor_treinamentos'],
				'auditor_documentacao_legal' => $_POST['auditor_documentacao_legal'],
				'auditor_funciomaento_comissoes' => $_POST['auditor_funciomaento_comissoes'],
				'auditor_pgrss' => $_POST['auditor_pgrss'],
				'auditor_acoes' => $_POST['auditor_acoes'],
				'auditor_medicamentos_administrados' => $_POST['auditor_medicamentos_administrados'],
				'auditor_eventos_adversos' => $_POST['auditor_eventos_adversos'],
				'auditor_amostras_enviadas' => $_POST['auditor_amostras_enviadas'],
				'auditor_orientacao' => $_POST['auditor_orientacao'],
				'auditor_preenchimento' => $_POST['auditor_preenchimento'],
				'auditor_conferencia' => $_POST['auditor_conferencia'],
				'auditor_fluxo' => $_POST['auditor_fluxo'],
				'auditor_enxoval' => $_POST['auditor_enxoval'],
				'auditor_suporte_basico' => $_POST['auditor_suporte_basico'],
				'auditor_registro' => $_POST['auditor_registro'],
				'auditor_contigencia' => $_POST['auditor_contigencia'],
				'auditor_inventario' => $_POST['auditor_inventario'],
				'auditor_calibracao' => $_POST['auditor_calibracao'],
				'auditor_cronograma' => $_POST['auditor_cronograma'],
				'auditor_eletrico' => $_POST['auditor_eletrico'],
				'auditor_limpeza' => $_POST['auditor_limpeza'],
				'auditor_padronizacao' => $_POST['auditor_padronizacao'],
				'auditor_infraestrutura' => $_POST['auditor_infraestrutura'],
				'auditor_psicotropicos' => $_POST['auditor_psicotropicos'],
				'auditor_estoque' => $_POST['auditor_estoque']
			);
			$novo = array_merge($info, $valores);
			$update = serialize($novo);
			
			$query = "UPDATE phpwcms_formresult SET formresult_content = '".$update."' WHERE formresult_pid = ".$fid." AND formresult_id = ".$_GET['q']." ";
			$resource = mysqli_query($conexao,$query) or die ();
			
			header("location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."");		
				
			$to = $info['email'];
			$subject = 'Questionário Avaliado';
			
			$message = 'Seu questionário já foi avaliado. Para visualizar o questionário, clique <a href="http://www.spcriacaodesites.com.br/gestores/02/export-usuario.php?fid='.$fid.'&cod='.$row['formresult_id'].'">aqui</a>.';
			
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			mail($to, $subject, $message, $headers);
			

				
		}
		echo $topo;
		?>
        <form action="" method="post" id="comentar-questionario">
		<h1> <? echo $info['unidade']; ?></h1>

            <div class="lista-agendamento">
                <h2>Agendamento</h2>
            	<h3>Confirma&ccedil;&atilde;o</h3>
            	
               <div class="box-pergunta fl">
				<b>SMS de confirma&ccedil;&atilde;o de agendamento (processo de verifica&ccedil;&atilde;o de caixa de entrada)</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['sms_confirmacao_agendamento'];
						   echo obs($info['obs_sms_confirmacao_agendamento']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_sms_confirmacao_agendamento']);
					   echo observacao('auditor_sms_confirmacao_agendamento', $info['auditor_sms_confirmacao_agendamento']); ?>
    			</p>
			</div>
               
               
                   
            <div class="box-pergunta fl">
				<b>SMS de confirmação de presença</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['sms_confirmacao_presenca'];
						   echo obs($info['obs_sms_confirmacao_presenca']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_sms_confirmacao_presenca']);
					   echo observacao('auditor_sms_confirmacao_presenca', $info['auditor_sms_confirmacao_presenca']); ?>
    			</p>
			</div>
            
            <h3>Gest&atilde;o</h3>

               
            <div class="box-pergunta fl">
				<b>Utilização do Call back</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['callback'];
						   echo obs($info['obs_callback']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_callback']);
					   echo observacao('auditor_callback', $info['auditor_callback']); ?>
    			</p>
			</div>
               
             <div class="box-pergunta fl">
				<b>Não Agendar RX</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['nao_agendar_rx'];
						   echo obs($info['obs_nao_agendar_rx']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_nao_agendar_rx']);
					   echo observacao('auditor_nao_agendar_rx', $info['auditor_nao_agendar_rx']); ?>
    			</p>
			</div>
               
            <div class="box-pergunta fl">
				<b>Processo de contato ativo com cliente</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['contato_ativo_cliente'];
						   echo obs($info['obs_contato_ativo_cliente']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_contato_ativo_cliente']);
					   echo observacao('auditor_contato_ativo_cliente', $info['auditor_contato_ativo_cliente']); ?>
    			</p>
			</div>
               
            <div class="box-pergunta fl">
				<b>Processo de recuperação de no-show</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['recuperacao_no_show'];
						   echo obs($info['obs_recuperacao_no_show']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_recuperacao_no_show']);
					   echo observacao('auditor_recuperacao_no_show', $info['auditor_recuperacao_no_show']); ?>
    			</p>
			</div>
               
               
           <div class="box-pergunta fl">
				<b>Processo de pré-autorização de exames</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['pre_autorizacao_exames'];
						   echo obs($info['obs_pre_autorizacao_exames']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_pre_autorizacao_exames']);
					   echo observacao('auditor_pre_autorizacao_exames', $info['auditor_pre_autorizacao_exames']); ?>
    			</p>
			</div>
            <div class="box-pergunta fl">
				<b>Script de ocupação (agendamento ativo)</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['script_ocupacao'];
						   echo obs($info['obs_script_ocupacao']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_script_ocupacao']);
					   echo observacao('auditor_script_ocupacao', $info['auditor_script_ocupacao']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Estudo atualizado de dimensionamento e forecast</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['estudo_forecast'];
						   echo obs($info['obs_estudo_forecast']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_estudo_forecast']);
					   echo observacao('auditor_estudo_forecast', $info['auditor_estudo_forecast']); ?>
    			</p>
			</div>
            <h3>Sistema</h3>
                 <div class="box-pergunta fl">
				<b>Gestão a vista: Painel de horários livres, status de confirmação, metas diárias de agendamento e nível de serviço</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['gestao_vista'];
						   echo obs($info['obs_gestao_vista']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_gestao_vista']);
					   echo observacao('auditor_gestao_vista', $info['auditor_gestao_vista']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Email de confirmação de agendamento com instruções e preparo</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['email_agendamento'];
						   echo obs($info['obs_email_agendamento']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_email_agendamento']);
					   echo observacao('auditor_email_agendamento', $info['auditor_email_agendamento']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Pesquisa de satisfação no fim da ligação</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['pesquisa_satisfacao'];
						   echo obs($info['obs_pesquisa_satisfacao']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_pesquisa_satisfacao']);
					   echo observacao('auditor_pesquisa_satisfacao', $info['auditor_pesquisa_satisfacao']); ?>
    			</p>
			</div>
            
     </div>           
            
            
            
            
            
    <div class="lista-producao">        
            <h2>Produção</h2>
        	<h3>Documentação e Entrega</h3> 
          <div class="box-pergunta fl">
				<b>Utilização de scanner nos processos definidos</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['utilizacao_scanner'];
						   echo obs($info['obs_utilizacao_scanner']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_utilizacao_scanner']);
					   echo observacao('auditor_utilizacao_scanner', $info['auditor_utilizacao_scanner']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Impressão de RM, TC, US e RX em Pape</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['impressao_papel'];
						   echo obs($info['obs_impressao_papel']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_impressao_papel']);
					   echo observacao('auditor_impressao_papel', $info['auditor_impressao_papel']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Entrega de imagens e CD na Hora (RM e TC)</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['entrega_imagens'];
						   echo obs($info['obs_entrega_imagens']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_entrega_imagens']);
					   echo observacao('auditor_entrega_imagens', $info['auditor_entrega_imagens']); ?>
    			</p>
			</div>
            
          <div class="box-pergunta fl">
				<b>Impressão do laudo somente dos pacientes que forem retirar</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['impressao_laudo'];
						   echo obs($info['obs_impressao_laudo']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_impressao_laudo']);
					   echo observacao('auditor_impressao_laudo', $info['auditor_impressao_laudo']); ?>
    			</p>
			</div>
                
                <h3>Faturamento</h3>
                
                
           <div class="box-pergunta fl">
				<b>Preenchimento da TISS na recepção</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['preenchimento_tiss'];
						   echo obs($info['obs_preenchimento_tiss']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_preenchimento_tiss']);
					   echo observacao('auditor_preenchimento_tiss', $info['auditor_preenchimento_tiss']); ?>
    			</p>
			</div>
                
               <div class="box-pergunta fl">
				<b>Envio diário de documentação para o setor de faturamento</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['envio_faturamento'];
						   echo obs($info['obs_envio_faturamento']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_envio_faturamento']);
					   echo observacao('auditor_envio_faturamento', $info['auditor_envio_faturamento']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Kit padrão de material para exames contrastados e cadastrados no sistema</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['kit_padrao'];
						   echo obs($info['obs_kit_padrao']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_kit_padrao']);
					   echo observacao('auditor_kit_padrao', $info['auditor_kit_padrao']); ?>
    			</p>
			</div>
            
            
            <h3>Produção e Atendimento</h3>
                 <div class="box-pergunta fl">
				<b>Sistema de Totem com senha e painel</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['sistema_totem'];
						   echo obs($info['obs_sistema_totem']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_sistema_totem']);
					   echo observacao('auditor_sistema_totem', $info['auditor_sistema_totem']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Equipes dedicadas de atendimento</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['equipe_dedicada'];
						   echo obs($info['obs_equipe_dedicada']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_equipe_dedicada']);
					   echo observacao('auditor_equipe_dedicada', $info['auditor_equipe_dedicada']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>% Pré-autorização de exames / célula de autorização da unidade</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['pre_autorizacao_exame'];
						   echo obs($info['obs_pre_autorizacao_exame']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_pre_autorizacao_exame']);
					   echo observacao('auditor_pre_autorizacao_exame', $info['auditor_pre_autorizacao_exame']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Agenda de RM de 20 min em 20 min</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['agenda_rm'];
						   echo obs($info['obs_agenda_rm']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_agenda_rm']);
					   echo observacao('auditor_agenda_rm', $info['auditor_agenda_rm']); ?>
    			</p>
			</div>
            <h3>Rastreamento</h3>
                 <div class="box-pergunta fl">
				<b>Utilização do leitor de código de barras nos processos definidos</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['codigo_barras_processo'];
						   echo obs($info['obs_codigo_barras_processo']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_barras_processo']);
					   echo observacao('auditor_codigo_barras_processo', $info['auditor_codigo_barras_processo']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Filas de atendimento na área técnica (RIS)</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['ris'];
						   echo obs($info['obs_ris']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_ris']);
					   echo observacao('auditor_ris', $info['auditor_ris']); ?>
    			</p>
			</div>      
        
  </div>          
           
             <div class="lista-qualidade">        
            <h2>Qualidade</h2>
            <h3>Atendimento e Satisfação do cliente</h3>
            
            
            <div class="box-pergunta fl">
				<b>Identificação do paciente/ acompanhantes/ visitantes</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['identificacao_paciente'];
						   echo obs($info['obs_identificacao_paciente']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_identificacao_paciente']);
					   echo observacao('auditor_identificacao_paciente', $info['auditor_identificacao_paciente']); ?>
    			</p>
			</div>
            
            
                 <div class="box-pergunta fl">
				<b>Processo de armazenamento das informações dos pacientes de forma segura (Backup)</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['backup'];
						   echo obs($info['obs_backup']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_backup']);
					   echo observacao('auditor_backup', $info['auditor_backup']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Segurança da Marcação do paciente diabético, renal e preparo do paciente alérgico</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['seguranca'];
						   echo obs($info['obs_seguranca']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_seguranca']);
					   echo observacao('auditor_seguranca', $info['auditor_seguranca']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Realização de atendimento conforme prioridade</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['prioridade'];
						   echo obs($info['obs_prioridade']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_prioridade']);
					   echo observacao('auditor_prioridade', $info['auditor_prioridade']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Pesquisa de satisfação nos tablets</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['tablets'];
						   echo obs($info['obs_tablets']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_tablets']);
					   echo observacao('auditor_tablets', $info['auditor_tablets']); ?>
    			</p>
			</div>
            <h3>Gestão de Pessoas</h3>
                 <div class="box-pergunta fl">
				<b>Controle de vacinação, exames periódicos de funcionário, dosimetria e distribuição de EPIs</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['epis'];
						   echo obs($info['obs_epis']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_epis']);
					   echo observacao('auditor_epis', $info['auditor_epis']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Ergonomia Conforme Norma Regulamentadora 17 – Portaria 3.214/78, regida pela Lei 6.514/77</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['norma'];
						   echo obs($info['obs_norma']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_norma']);
					   echo observacao('auditor_norma', $info['auditor_norma']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Mapas de riscos disponíveis e PPRA e PCMSCO atualizados</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['ppra'];
						   echo obs($info['obs_ppra']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_ppra']);
					   echo observacao('auditor_ppra', $info['auditor_ppra']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Dispõe de canais de Comunicação com o colaborador</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['canais_comunicacao'];
						   echo obs($info['obs_canais_comunicacao']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_canais_comunicacao']);
					   echo observacao('auditor_canais_comunicacao', $info['auditor_canais_comunicacao']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Descrição de cargos</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['descricao_cargos'];
						   echo obs($info['obs_descricao_cargos']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_descricao_cargos']);
					   echo observacao('auditor_descricao_cargos', $info['auditor_descricao_cargos']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Avaliação de desempenho</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['avaliacao_desempenho'];
						   echo obs($info['obs_avaliacao_desempenho']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_avaliacao_desempenho']);
					   echo observacao('auditor_avaliacao_desempenho', $info['auditor_avaliacao_desempenho']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Pesquisa de clima com análise e ações</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['clima'];
						   echo obs($info['obs_clima']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_clima']);
					   echo observacao('auditor_clima', $info['auditor_clima']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Fluxo de Acidente de trabalho</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['acidente'];
						   echo obs($info['obs_acidente']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_acidente']);
					   echo observacao('auditor_acidente', $info['auditor_acidente']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Realização de treinamentos obrigatórios</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['treinamentos'];
						   echo obs($info['obs_treinamentos']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_treinamentos']);
					   echo observacao('auditor_treinamentos', $info['auditor_treinamentos']); ?>
    			</p>
			</div>
            <h3>Documentação Legal-</h3>
                 <div class="box-pergunta fl">
				<b>Controle da documentação legal</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['documentacao_legal'];
						   echo obs($info['obs_documentacao_legal']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_documentacao_legal']);
					   echo observacao('auditor_documentacao_legal', $info['auditor_documentacao_legal']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Funcionamento das comissões obrigatórias (cipa, ciead, perfuro cortante, prontuário, ética médica)</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['funciomaento_comissoes'];
						   echo obs($info['obs_funciomaento_comissoes']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_funciomaento_comissoes']);
					   echo observacao('auditor_funciomaento_comissoes', $info['auditor_funciomaento_comissoes']); ?>
    			</p>
			</div>
            <h3>Gestão Ambiental</h3>
            
            <div class="box-pergunta fl">
				<b>PGRSS aprovado e aplicado</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['pgrss'];
						   echo obs($info['obs_pgrss']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_pgrss']);
					   echo observacao('auditor_pgrss', $info['auditor_pgrss']); ?>
    			</p>
			</div>
            
            <div class="box-pergunta fl">
				<b>Promover ações para redução de recursos naturais renováveis e não renováveis</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['acoes'];
						   echo obs($info['obs_acoes']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_acoes']);
					   echo observacao('auditor_acoes', $info['auditor_acoes']); ?>
    			</p>
			</div>
            
            </div>
           
           
           <div class="lista-seguranca">        
            <h2>Segurança</h2>
            <h3>Assistencial</h3>
            
            
            
                 <div class="box-pergunta fl">
				<b>Medicamentos administrados com prescrição médica e alta medica para sedação</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['medicamentos_administrados'];
						   echo obs($info['obs_medicamentos_administrados']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_medicamentos_administrados']);
					   echo observacao('auditor_medicamentos_administrados', $info['auditor_medicamentos_administrados']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Eventos adversos registrados em busca ativa</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['eventos_adversos'];
						   echo obs($info['obs_eventos_adversos']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_eventos_adversos']);
					   echo observacao('auditor_eventos_adversos', $info['auditor_eventos_adversos']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Amostras enviadas ao laboratório protocoladas</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['amostras_enviadas'];
						   echo obs($info['obs_amostras_enviadas']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_amostras_enviadas']);
					   echo observacao('auditor_amostras_enviadas', $info['auditor_amostras_enviadas']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Orientação sobre os termos de consentimentos, recusa e anuência</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['orientacao'];
						   echo obs($info['obs_orientacao']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_orientacao']);
					   echo observacao('auditor_orientacao', $info['auditor_orientacao']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Preenchimento completo dos registros da assistência</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['preenchimento'];
						   echo obs($info['obs_preenchimento']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_preenchimento']);
					   echo observacao('auditor_preenchimento', $info['auditor_preenchimento']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Conferência dos dados dos procedimento versus paciente antes da realização do exame</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['conferencia'];
						   echo obs($info['obs_conferencia']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_conferencia']);
					   echo observacao('auditor_conferencia', $info['auditor_conferencia']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Fluxo de atendimento as urgências e emergencias</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['fluxo'];
						   echo obs($info['obs_fluxo']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_fluxo']);
					   echo observacao('auditor_fluxo', $info['auditor_fluxo']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Disponibiliza enxoval unitário</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['enxoval'];
						   echo obs($info['obs_enxoval']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_enxoval']);
					   echo observacao('auditor_enxoval', $info['auditor_enxoval']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Dispõe de materiais de suporte básico a vida (Laringoscópio, desfibrilador, glicosímetro, oxímetro, bala de O2, vácuo) e testes diário dos mesmos.</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['suporte_basico'];
						   echo obs($info['obs_suporte_basico']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_suporte_basico']);
					   echo observacao('auditor_suporte_basico', $info['auditor_suporte_basico']); ?>
    			</p>
			</div>
            <h3>Equipamento e Instalações</h3>
                 <div class="box-pergunta fl">
				<b>Registro de Abertura de chamados para manutenção, desde a detecção do problema a comunicação a empresa terceirizada</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['registro'];
						   echo obs($info['obs_registro']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_registro']);
					   echo observacao('auditor_registro', $info['auditor_registro']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Contingência para equipamentos críticos de suporte a vida</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['contigencia'];
						   echo obs($info['obs_contigencia']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_contigencia']);
					   echo observacao('auditor_contigencia', $info['auditor_contigencia']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Inventário dos equipamentos e Manutenção preventiva e corretiva dos mesmos</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['inventario'];
						   echo obs($info['obs_inventario']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_inventario']);
					   echo observacao('auditor_inventario', $info['auditor_inventario']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Registro de manutenção e calibração: Controle de temperatura e umidade dos ambientes, e do nível de Helio e Compressor. Registro de Calibração e teste de constância dos aparelhos de imagem</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['calibracao'];
						   echo obs($info['obs_calibracao']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_calibracao']);
					   echo observacao('auditor_calibracao', $info['auditor_calibracao']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Cronograma executado de manutenção das instalações que contemple (Registros de controle de pragas, análise microbiológica da água , limpeza da caixa d água, manutenção elevador e ar condicionado (manutenção predial e Sinalização das áreas)</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['cronograma'];
						   echo obs($info['obs_cronograma']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_cronograma']);
					   echo observacao('auditor_cronograma', $info['auditor_cronograma']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Sistema Elétrico – Conforme Norma Regulamentadora 10 – Portaria 3.214/78, regida pela Lei 6.514/77</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['eletrico'];
						   echo obs($info['obs_eletrico']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_eletrico']);
					   echo observacao('auditor_eletrico', $info['auditor_eletrico']); ?>
    			</p>
			</div>
            
            <h3>Higienação</h3>
            
                 <div class="box-pergunta fl">
				<b>Limpeza terminal e concorrente das áreas</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['limpeza'];
						   echo obs($info['obs_limpeza']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_limpeza']);
					   echo observacao('auditor_limpeza', $info['auditor_limpeza']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Padronização do processo de diluição de saneantes, incluindo identificação e controle dos mesmos</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['padronizacao'];
						   echo obs($info['obs_padronizacao']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_padronizacao']);
					   echo observacao('auditor_padronizacao', $info['auditor_padronizacao']); ?>
    			</p>
			</div>
            
            <h3>Suprimentos</h3>
                 <div class="box-pergunta fl">
				<b>Infra estrura adequada para armazenamento dos medicamentos</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['infraestrutura'];
						   echo obs($info['obs_infraestrutura']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_infraestrutura']);
					   echo observacao('auditor_infraestrutura', $info['auditor_infraestrutura']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Controle de psicotrópicos e rastreabilidade de medicamentos</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['psicotropicos'];
						   echo obs($info['obs_psicotropicos']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_psicotropicos']);
					   echo observacao('auditor_psicotropicos', $info['auditor_psicotropicos']); ?>
    			</p>
			</div>
            
                 <div class="box-pergunta fl">
				<b>Controle de estoque de mat/med</b>
    			<p>
       				<span><strong>Resposta: </strong>
						<? echo $info['estoque'];
						   echo obs($info['obs_estoque']); ?>
                    </span>
        			<? echo arquivo($info['arquivo_estoque']);
					   echo observacao('auditor_estoque', $info['auditor_estoque']); ?>
    			</p>
			</div>
            
            </div>
          
					<p><input type="submit" name="salvar-questionario" id="salvar-questionario" value=" Salvar Informações" /></p>
			</form>
	<?php 
	
	// ===== Área que mostra a lista dos últimos questionários =====	
	} else {
		$consulta_busca = "SELECT GROUP_CONCAT(DISTINCT formresult_empresa) AS empresa, formresult_id AS id FROM phpwcms_formresult WHERE formresult_id IS NOT NULL";
		$busca = mysqli_query($conexao, $consulta_busca);
		while($rows = mysqli_fetch_assoc($busca)){
			echo $rows['empresa'].'<br />';
		}
		
		$consulta_form = "SELECT *, DATE_FORMAT(formresult_createdate, '%Y-%m-%d %H:%i:%s') AS formresult_date FROM phpwcms_formresult WHERE formresult_pid = ".$fid."";
		$dados = mysqli_query($conexao, $consulta_form);
		echo $topo;
		while($row = mysqli_fetch_array($dados)){
			$info = unserialize($row['formresult_content']);
			?>
            
			<div class="lista-questionarios fl">
				<? echo $info['empresa']; ?>
                <a href="export.php?fid=53&q=<? echo $row['formresult_id']; ?>">Editar</a>
            </div>

			<?php
		}
	}
} else {
		
		if(isset($_POST['busca-empresa'])){
			$codigo = $_POST['busca-empresa'];
		    $num_codigo = strlen($codigo);
			$mes = $_POST['busca-mes'];
			$num_mes = strlen($mes);
			$ano = $_POST['busca-ano'];
			$num_ano = strlen($ano);
			
			$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
			$url = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
			
			header("Location: ".$url.'?c='.$codigo.'&m='.$mes.'&a='.$ano);
		}
		
		$codigo = $_GET['c'];
		$num_codigo = strlen($codigo);
		$mes = $_GET['m'];
		$num_mes = strlen($mes);
		$ano = $_GET['a'];
		$num_ano = strlen($ano);
	
		$consulta_busca = "SELECT GROUP_CONCAT(DISTINCT formresult_empresa) AS empresa FROM phpwcms_formresult WHERE formresult_empresa IS NOT NULL";
		$busca = mysqli_query($conexao, $consulta_busca);
		$rows = mysqli_fetch_assoc($busca);
		$empresas = explode(',',$rows['empresa']);
	
		$meses = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
		$anos = array('2015','2016','2017','2018','2019','2020','2021','2022','2023','2024','2025');
		
		echo $topo;
		?>
		
		<p>Pesquise pelo nome da empresa para visualizar os questionários preenchidos.</p>
		<form id="buscar" method="post" action=""> 
			<select name="busca-empresa" id="busca-empresa">
            <?php
            	foreach($empresas as $value){
				?>
                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>;
				<?php
                }
			?>
            </select>
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
		
		if(isset($_GET['c'])){
			$consulta_form = "SELECT * FROM phpwcms_formresult WHERE formresult_content LIKE '%\"empresa\";s:".$num_codigo.":\"".$codigo."\";%'";
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
                	<a href="export.php?fid=<? echo $row['formresult_pid']; ?>&q=<? echo $row['formresult_id']; ?>">Editar</a>
            	</div>
			<?
        	}
		}
}

echo $rodape;

?>