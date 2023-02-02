<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'secret'   => get_chave(),
    'response' => clean_post($_POST['check']),
    'remoteip' => $_SERVER['REMOTE_ADDR']
]);

$resp = json_decode(curl_exec($ch));
curl_close($ch);

echo ($resp->success) ? '1' : '2';



// FUNÇÕES ---------------------------------------------------------------------

// Conexão com o banco de dados
function conexao(){

    include('../../config/phpwcms/conf.inc.php');

    return mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);

}

// Limpa a informação do post
function clean_post($post){

    $conexao = conexao();

    return mysqli_real_escape_string($conexao, $post);

}

// Buscaa chave do recaptcha da tabela de dados
function get_chave(){

    $conexao = conexao();

    $sql = 'SELECT
            dados_recaptcha
            FROM
            phpwcms_dados';
    $res = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($res);

    $recaptcha = json_decode($row['dados_recaptcha'], true);
    $chave     = $recaptcha['secret'];

    return $chave;

}