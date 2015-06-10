<?php
defined('IN_UF') or exit('Access Denied');

$pageurl = '?m='.$m.'&a='.$a;
$where = ' WHERE `status`=1';
$tbl = "`".DB_PREFIX."indicator_type`";

if($_POST['act'] == "add" || ($_POST['act'] == "edit" && $_POST['id'])){
    check_auth($m,$a,"edit",1);

    $page_title = "添加量化指标分类";

    if($_POST['id']){
        $page_title = "编辑量化指标分类";

        $sql = "SELECT * FROM $tbl WHERE `typeid`=".intval($_POST['id']);
        $r = $db->GetRow($sql);
    }

    include(Template($m."_".$a."_modify"));
    exit();
}

if($_POST['act'] == "update"){
    check_auth($m,$a,"edit",1);

    if($_POST['type'] == ""){
        halt("请填写量化指标分类名称~~");
    }

    $_POST['id'] = intval($_POST['id']);
    $_POST['type'] = iconv("utf-8","gbk//ignore",$_POST['type']);

    $info = array();

    $info['type'] = $_POST['type'];
    $info['dateline'] = time();

    if($_POST['id'] > 0){
        $sql = get_update_sql($tbl,$info,"typeid=".$_POST['id']);
        $db->Execute($sql);

        admin_log('量化指标分类修改','bindid',$_POST['id']);
    }else{
        $sql = get_insert_sql($tbl,$info);
        $db->Execute($sql);
        $id = $db->Insert_ID();

        admin_log('量化指标分类添加','bindid',$id);
    }

    echo("true");
    exit();
}

if($_POST['act'] == "del" && $_POST['id']){
    check_auth($m,$a,"del",1);

    $info = array();
    $info['status'] = 0;

    $sql = get_update_sql($tbl,$info,"typeid=".intval($_POST['id']));
    $db->Execute($sql);

    admin_log('量化指标分类删除','bindid',intval($_POST['id']));

    echo("true");
    exit();
}

$sql = "SELECT COUNT(*) FROM ".$tbl.$where;
$count = $db->GetOne($sql);

$page = $_GET['pn'] ? (int)$_GET['pn'] : 1;
$limit = $limit ? (int)$limit : 10;
$offset = ($page-1)*$limit;

$page_nav = page($count,$limit,$page,$pageurl);

$sql = "SELECT * FROM ".$tbl.$where." ORDER BY `typeid` ASC LIMIT {$offset},{$limit}";
$rs = $db->GetAll($sql);

$canadd = intval($p_power[$m."_".$a."_edit"]);

if(is_array($rs)){
    foreach($rs as $k => $r){
        $rs[$k]['canedit'] = intval($p_power[$m."_".$a."_edit"]);
        $rs[$k]['candel'] = intval($p_power[$m."_".$a."_del"]);
    }
}

include(Template($m."_".$a));
?>
