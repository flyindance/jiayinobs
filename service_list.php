<?php

/**
 * ECSHOP 文章内容
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: article.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$cat_id = $_REQUEST['cat_id'] ? intval($_REQUEST['cat_id']) : 0;
$parent = findSerById($cat_id);
$children = queryListByCatId($cat_id);
$id = $_REQUEST['id'] ? intval($_REQUEST['id']) : ($children ? $children[0]['cat_id'] : 0);
$content = findSerById($id);
$smarty->assign('parent',$parent);
$smarty->assign('children',$children);
$smarty->assign('content',$content);
$smarty->display('service_list.dwt');


function findSerById($cat_id) {
    $sql = "SELECT cat_id,cat_name,keywords,cat_desc FROM ecs_article_cat WHERE cat_id = ".$cat_id;
    return $GLOBALS['db']->getRow($sql);
}

function queryListByCatId ($cat_id) {
    $sql = "SELECT cat_id,cat_name,keywords,cat_desc FROM ecs_article_cat WHERE parent_id = ".$cat_id;
    $res = $GLOBALS['db']->getAll($sql);
    return $res;
}

?>