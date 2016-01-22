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

$id = findIdByName('企业新闻');
$news = $id ? queryListByCatId($id) : array();
$id = findIdByName('企业公告');
$notice = $id ? queryListByCatId($id) : array();
$smarty->assign('news',$news);
$smarty->assign('notice',$notice);
$smarty->display('our.dwt');

function findIdByName ($cat_name) {
    $sql = "SELECT cat_id FROM `ecs_article_cat` WHERE cat_name = '".$cat_name."'";
    return $GLOBALS['db']->getOne($sql);
}

function queryListByCatId ($cat_id) {
    $sql = 'SELECT a.article_id, a.title, ac.cat_name, a.add_time, a.file_url, a.open_type, ac.cat_id, ac.cat_name, a.content ' .
        ' FROM ' . $GLOBALS['ecs']->table('article') . ' AS a, ' .
        $GLOBALS['ecs']->table('article_cat') . ' AS ac' .
        " WHERE a.is_open = 1 AND a.cat_id = ac.cat_id AND ac.cat_id = $cat_id" .
        ' ORDER BY a.article_type DESC, a.add_time DESC LIMIT 2';
    $res = $GLOBALS['db']->getAll($sql);

    $arr = array();
    foreach ($res AS $idx => $row)
    {
        $arr[$idx]['id']          = $row['article_id'];
        $arr[$idx]['title']       = $row['title'];
        $arr[$idx]['short_title'] = $GLOBALS['_CFG']['article_title_length'] > 0 ?
            sub_str($row['title'], $GLOBALS['_CFG']['article_title_length']) : $row['title'];
        $arr[$idx]['cat_name']    = $row['cat_name'];
        $arr[$idx]['add_time']    = local_date($GLOBALS['_CFG']['date_format'], $row['add_time']);
        $arr[$idx]['url']         = $row['open_type'] != 1 ?
            build_uri('article', array('aid' => $row['article_id']), $row['title']) : trim($row['file_url']);
        $arr[$idx]['cat_url']     = build_uri('article_cat', array('acid' => $row['cat_id']), $row['cat_name']);
        $arr[$idx]['content']     = strip_tags($row['content']);
        $arr[$idx]['file_url']    = $row['file_url'];
    }
    return $arr;
}

?>