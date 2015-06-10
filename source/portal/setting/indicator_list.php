<?php
defined('IN_UF') or exit('Access Denied');

$pageurl = '?m='.$m.'&a='.$a;
$where = ' WHERE 1';
$tbl = "`".DB_PREFIX."log`";

if($_REQUEST['act'] == 'search'){
    $pageurl .= '&act=search';

    if($_REQUEST['search_path'] == "操作路径"){
        $_REQUEST['search_path'] = "";
    }

    if($_REQUEST['search_object'] == "操作对象"){
        $_REQUEST['search_object'] = "";
    }

    if($_REQUEST['search_name'] == "操作人"){
        $_REQUEST['search_name'] = "";
    }

    if($search_path = $_REQUEST['search_path']){
        $where .= " AND `action`='".$search_path."'";
        $pageurl .= '&search_path='.urlencode($search_path);
    }

    if($search_object = $_REQUEST['search_object']){
        $where .= " AND `bindid`='".$search_object."'";
        $pageurl .= '&search_object='.urlencode($search_object);
    }

    if($search_name = $_REQUEST['search_name']){
        $where .= " AND (`username` LIKE '%".$search_name."%' OR `uid` LIKE '%".$search_name."%')";
        $pageurl .= '&search_name='.urlencode($search_name);
    }

    if($search_btime = $_REQUEST['search_btime']){
        if($search_timecut = @strtotime($search_btime)){
            $where .= " AND `dateline`>='".$search_timecut."'";
            $pageurl .= '&search_btime='.urlencode($search_btime);
        }
    }

    if($search_etime = $_REQUEST['search_etime']){
        if($search_timecut = @strtotime($search_etime)){
            $where .= " AND `dateline`<'".($search_timecut + 86400)."'";
            $pageurl .= '&search_etime='.urlencode($search_etime);
        }
    }
}

$sql = "SELECT COUNT(*) FROM ".$tbl.$where;
$count = $db->GetOne($sql);

$page = $_GET['pn'] ? (int)$_GET['pn'] : 1;
$limit = $limit ? (int)$limit : 10;
$offset = ($page-1)*$limit;

$page_nav = page($count,$limit,$page,$pageurl);

$sql = "SELECT * FROM ".$tbl.$where." ORDER BY `id` DESC LIMIT {$offset},{$limit}";
$rs = $db->GetAll($sql);

include(Template($m."_".$a));
?>
