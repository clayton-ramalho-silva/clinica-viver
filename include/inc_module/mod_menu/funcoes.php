<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$conexao = mysqli_connect($phpwcms['db_host'], $phpwcms['db_user'], $phpwcms['db_pass'], $phpwcms['db_table']);
$prepend = ($phpwcms['db_prepend']) ? $phpwcms['db_prepend'].'_' : '';

// Busca as informações das configurações
function getConfig($conexao, $prepend, $val){

    $sql = 'SELECT sysvalue_value
            FROM '.$prepend.'phpwcms_sysvalue
            WHERE sysvalue_key = "'.$val.'"';
    $res = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($res);

    return $row['sysvalue_value'];

}

function setConfig($conexao, $prepend, $key, $val){

    $sql = "UPDATE ".$prepend."phpwcms_sysvalue
            SET
            sysvalue_value = '".$val."'
            WHERE sysvalue_key = '".$key."'";
    $res = mysqli_query($conexao, $sql);

}

// EOF