<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$id = findIdByName('佳音服务');
$service_list = $id ? queryListByCatId($id) : array();
$smarty->assign('service_list',$service_list);
$smarty->display('service.dwt');

function findIdByName ($cat_name) {
    $sql = "SELECT cat_id FROM `ecs_article_cat` WHERE cat_name = '".$cat_name."'";
    return $GLOBALS['db']->getOne($sql);
}

function queryListByCatId ($cat_id) {
    $sql = 'SELECT cat_id,cat_name,keywords,cat_desc FROM '.$GLOBALS['ecs']->table('article_cat') .' WHERE parent_id = '.$cat_id;
    $res = $GLOBALS['db']->getAll($sql);
    return $res;
}


?>