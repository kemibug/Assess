<?php
defined('IN_UF') or exit('Access Denied');

$pageurl = '?m='.$m.'&a='.$a;
$where = ' WHERE `status`=1';
$tbl = "`".DB_PREFIX."group`";

if($_REQUEST['act'] == "add" || ($_REQUEST['act'] == "edit" && $_REQUEST['id'])){
    check_auth($m,$a,"edit",0);

    $page_title = "添加角色";

    if($_REQUEST['id']){
        $page_title = "编辑角色";

        $sql = "SELECT * FROM $tbl WHERE `id`={$_REQUEST['id']}";
        $r = $db->GetRow($sql);
        $arr_power = unserialize($r['power']);
    }

    include(Template($m."_".$a."_modify"));
    exit();
}

if($_POST['act'] == "update"){
    check_auth($m,$a,"edit",0);

    if($_POST['title'] == ""){
        halt_http_referer("请填写角色名称!");
    }

    $_POST['id'] = intval($_POST['id']);
    $_POST['all'] = intval($_POST['all']);

    $power = $_POST['power'];
    $arr_power = array();
    if(is_array($power)){
        foreach($power as $v){
            $arr_power[$v] = 1;
        }
    }

    $info = array();
    $info['title'] = $_POST['title'];
    $info['all'] = $_POST['all'];
    $info['power'] = serialize($arr_power);
    $info['status'] = 1;
    $info['dateline'] = time();

    if($_POST['id'] > 0){
        $sql = get_update_sql($tbl,$info,"`id`='".$_POST[id]."'");
        $db->Execute($sql);

        admin_log('角色修改','bindid',$_POST[id]);
        halt_referer("修改成功~~");
    }
    else{
        $sql = get_insert_sql($tbl,$info);
        $db->Execute($sql);
        $id = $db->Insert_ID();

        admin_log('角色添加','bindid',$id);
        halt_referer("添加成功~~");
    }
}

if($_POST['act'] == "del" && $_POST[id]){
    check_auth($m,$a,"del",1);

    $info = array();
    $info[status] = 0;

    $sql = get_update_sql($tbl,$info,"id='".intval($_POST[id])."'");
    $db->Execute($sql);

    admin_log('角色删除','bindid',intval($_POST[id]));

    echo("true");
    exit();
}

$sql = "SELECT COUNT(*) FROM ".$tbl.$where;
$count = $db->GetOne($sql);

$page = $_GET['pn'] ? (int)$_GET['pn'] : 1;
$limit = $limit ? (int)$limit : 10;
$offset = ($page-1)*$limit;

$page_nav = page($count,$limit,$page,$pageurl);

$sql = "SELECT * FROM ".$tbl.$where." ORDER BY `id` DESC LIMIT {$offset},{$limit}";
$rs = $db->GetAll($sql);

$canadd = intval($p_power[$m."_".$a."_edit"]);

if(is_array($rs)){
    foreach($rs as $k => $r){
        $rs[$k][canedit] = intval($p_power[$m."_".$a."_edit"]);
        $rs[$k][candel] = intval($p_power[$m."_".$a."_del"]);
    }
}

$u = urlencode($pageurl."&pn=".$page);

include(Template($m."_".$a));
?>
