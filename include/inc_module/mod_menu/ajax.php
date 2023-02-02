<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../../../config/phpwcms/conf.inc.php');
include('../../../include/inc_module/mod_menu/funcoes.php');

if(isset($_POST['dataMenu'])){

    // Busca as informações das estruturas
    $info = unserialize(getConfig($conexao, $prepend, 'structure_array_vmode_all'));

    $dados = json_decode($_POST['dataMenu'], true);

    $a = 0;
    $x = 1;
    foreach($dados as $key => $value){

        $info = subMenu($conexao, $prepend, $x, $value['id'], $value['children'], $info);

        $sql = 'UPDATE '.$prepend.'phpwcms_articlecat
                SET 
                acat_menu = 1,
                acat_sort = '.$x.',
                acat_struct = 0,
                acat_hidden = 0
                WHERE acat_id = '.$value['id'];
        $res = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

        if(!$res){

            $a++;

        } else {

            $info[$value['id']]['acat_sort']   = (string)$x;
            $info[$value['id']]['acat_menu']   = '1';
            $info[$value['id']]['acat_struct'] = '0';
            $info[$value['id']]['acat_hidden'] = '0';

            setConfig($conexao, $prepend, 'structure_array_vmode_all', serialize($info));

        }

        $x++;

    }


    echo ($a === 0) ? '1' : '2';

}

if(isset($_POST['dataPages'])){

    // Busca as informações das estruturas
    $info = unserialize(getConfig($conexao, $prepend, 'structure_array_vmode_all'));

    $dados = json_decode($_POST['dataPages'], true);

    $a = 0;
    $x = 300;
    foreach($dados as $key => $value){

        $sql = 'UPDATE '.$prepend.'phpwcms_articlecat
                SET 
                acat_menu = 0,
                acat_sort = '.$x.',
                acat_struct = 0,
                acat_hidden = 1
                WHERE acat_id = '.$value['id'];
        $res = mysqli_query($conexao, $sql);

        if(!$res){

            $a++;

        } else {

            $info[$value['id']]['acat_sort']   = (string)$x;
            $info[$value['id']]['acat_menu']   = '0';
            $info[$value['id']]['acat_struct'] = '0';
            $info[$value['id']]['acat_hidden'] = '1';

            setConfig($conexao, $prepend, 'structure_array_vmode_all', serialize($info));

            $x++;

        }

    }

    echo ($a === 0) ? '1' : '2';

}

if(isset($_POST['homeMenu'])){

    $home = mysqli_real_escape_string($conexao, $_POST['homeMenu']);

    if(getConfig($conexao, $prepend, 'homeMenu')){

        $sql = 'UPDATE '.$prepend.'phpwcms_sysvalue
                SET 
                sysvalue_value = '.$home.'
                WHERE sysvalue_key = "homeMenu"';
        $res = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    } else {

        $sql = 'INSERT INTO '.$prepend.'phpwcms_sysvalue
                SET 
                sysvalue_key = "homeMenu",
                sysvalue_group = "module_menu",
                sysvalue_status = 1,
                sysvalue_vartype = "int",
                sysvalue_value = '.$home;
        $res = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    }

}

if(isset($_POST['noticiasMenu'])){

    $home = mysqli_real_escape_string($conexao, $_POST['noticiasMenu']);

    if(getConfig($conexao, $prepend, 'noticiasMenu')){

        $sql = 'UPDATE '.$prepend.'phpwcms_sysvalue
                SET 
                sysvalue_value = '.$home.'
                WHERE sysvalue_key = "noticiasMenu"';
        echo $sql;
        $res = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    } else {

        $sql = 'INSERT INTO '.$prepend.'phpwcms_sysvalue
                SET 
                sysvalue_key = "noticiasMenu",
                sysvalue_group = "module_menu",
                sysvalue_status = 1,
                sysvalue_vartype = "int",
                sysvalue_value = '.$home;
        $res = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    }

}


// FUNÇÕES -------------------------------------------------------------------

function subMenu($conexao, $prepend, $x, $id, $children, $info, $count=1){

    if($children){

        $z = 1;
        foreach($children as $key => $value){

            $info = subMenu($conexao, $prepend, $x, $value['id'], $value['children'], $info, $z);
   
            $sort = '1'.$x.$z;

            $sql = 'UPDATE '.$prepend.'phpwcms_articlecat
                    SET 
                    acat_menu = 1,
                    acat_sort = '.$sort.',
                    acat_struct = '.$id.'
                    WHERE acat_id = '.$value['id'];
            $res = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

            if($res){

                $info[$value['id']]['acat_sort']   = (string)$sort;
                $info[$value['id']]['acat_menu']   = '1';
                $info[$value['id']]['acat_struct'] = $id;

                $z++;

            }
    
        }

    }

    return $info;

}

// EOF