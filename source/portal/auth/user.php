<?php
defined('IN_UF') or exit('Access Denied');

$pageurl = '?m='.$m.'&a='.$a;
$where = ' WHERE U.`status`=1';
$tbl = "`".DB_PREFIX."user`";

if($_POST['act'] == "edit" && $_POST['uid']){
    check_auth($m,$a,"edit",1);
    
    $arr_groups = array();
    $arr_groups = get_group_list();
    
    $_POST['uid'] = iconv("utf-8","gbk//ignore",$_POST['uid']);

    $sql = "SELECT * FROM $tbl WHERE `uid`='".$_POST['uid']."'";
    $r = $db->GetRow($sql);

    include(Template($m."_".$a."_modify"));
    exit();
}

if($_POST['act'] == "update" && $_POST['uid']){
    check_auth($m,$a,"edit",1);

    $_POST['uid'] = iconv("utf-8","gbk//ignore",$_POST['uid']);
    $_POST['gid'] = intval($_POST['gid']);

    if($_POST['gid'] == 0 || $_POST['gid'] == ""){
        halt("请选择角色~~");
    }

    $info = array();
    $info[gid] = $_POST['gid'];

    $sql = get_update_sql($tbl,$info,"uid='".$_POST['uid']."'");
    $db->Execute($sql);

    admin_log('员工修改','bindid',$_POST[uid]);

    echo("true");
    exit();

    include(Template($m."_".$a."_modify"));
    exit();
}

if($_REQUEST['act'] == 'search'){
    $pageurl .= '&act=search';

    if($_REQUEST['search_name'] == "请输入姓名"){
        $_REQUEST['search_name'] = "";
    }

    if($search_name = $_REQUEST['search_name']){
        $where .= " AND (U.`username` like '%".$search_name."%' OR U.`uid` like '%".$search_name."%')";
        $pageurl .= '&search_name='.urlencode($search_name);
    }

    if($search_gid = intval($_REQUEST['search_gid'])){
        $where .= " AND U.`gid`='".$search_gid."'";
        $pageurl .= '&search_gid='.$search_gid;
    }
}

$arr_groups = array();
$arr_groups = get_group_list();

$sql = "SELECT COUNT(*) FROM $tbl U".$where;
$count = $db->GetOne($sql);

$page = $_GET['pn'] ? (int)$_GET['pn'] : 1;
$limit = $limit ? (int)$limit : 10;
$offset = ($page-1)*$limit;

$page_nav = page($count,$limit,$page,$pageurl);

$sql = "SELECT U.*, G.`title` groupname FROM $tbl U LEFT JOIN `".DB_PREFIX."group` G ON U.`gid`=G.`id`".$where." ORDER BY U.`city`, U.`did`, U.`priv` LIMIT {$offset},{$limit}";
$rs = $db->GetAll($sql);

if(is_array($rs)){
    foreach($rs as $k => $r){
        $rs[$k][canedit] = intval($p_power[$m."_".$a."_edit"]);
        $rs[$k][candel] = intval($p_power[$m."_".$a."_del"]);
    }
}

$u = urlencode($pageurl."&pn=".$page);

include(Template($m."_".$a));
?>
