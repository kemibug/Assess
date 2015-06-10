<?php
defined('IN_UF') or exit('Access Denied');

$pageurl = '?m='.$m.'&a='.$a;
$where = ' WHERE A.`status`=1';
$tbl = "`".DB_PREFIX."indicator`";

if($_REQUEST['act'] == "add" || ($_REQUEST['act'] == "edit" && $_REQUEST['id'])){
    check_auth($m,$a,"edit",1);

    $page_title = "添加量化指标";
    
    $typeid = $_REQUEST['typeid'];
    if($_REQUEST['id']){
        $page_title = "编辑量化指标";

        $sql = "SELECT * FROM $tbl WHERE `id`=".intval($_REQUEST['id']);
        $r = $db->GetRow($sql);
        $typeid = $r['typeid'];
    }

    $arr_indicator_types = array();
    $arr_indicator_types = get_indicator_type_list();

    include(Template($m."_".$a."_modify"));
    exit();
}

if($_POST['act'] == "update"){
    check_auth($m,$a,"edit",1);

    if($_POST['typeid'] == "0" || $_POST['typeid'] == ""){
        halt("请填写量化指标分类~~");
    }

    if($_POST['title'] == ""){
        halt("请填写量化指标名称~~");
    }

    $_POST['id'] = intval($_POST['id']);
    $_POST['typeid'] = intval($_POST['typeid']);
    
    $info = array();

    $info['title'] = $_POST['title'];
    $info['typeid'] = $_POST['typeid'];
    $info['desc'] = $_POST['desc'];
    //$info['datasource'] = $_POST['datasource'];
    $info['dateline'] = time();

    if($_POST['id'] > 0){
        $sql = get_update_sql($tbl,$info,"id=".$_POST['id']);
        $db->Execute($sql);

        admin_log('量化指标修改','bindid',$_POST['id']);
        halt_referer("修改成功~~");
    }else{
        $info['adduid'] = $p_uid;
        $sql = get_insert_sql($tbl,$info);
        $db->Execute($sql);
        $id = $db->Insert_ID();

        admin_log('量化指标添加','bindid',$id);
        halt_referer("添加成功~~");
    }
}

if($_POST['act'] == "del" && $_POST['id']){
    check_auth($m,$a,"del",1);

    $info = array();
    $info['status'] = 0;

    $sql = get_update_sql($tbl,$info,"id=".intval($_POST['id']));
    $db->Execute($sql);

    admin_log('量化指标删除','bindid',intval($_POST['id']));

    echo("true");
    exit();
}

if($_REQUEST['act'] == 'search'){
    $pageurl .= '&act=search';

    if($_REQUEST['search_title'] == "请输入指标名称"){
        $_REQUEST['search_title'] = "";
    }

    if($search_title = $_REQUEST['search_title']){
        $where .= " AND A.`title` like '%".$search_title."%'";
        $pageurl .= '&search_title='.urlencode($search_title);
    }

    if($search_type = intval($_REQUEST['search_type'])){
        $where .= " AND A.`typeid`='".$search_type."'";
        $pageurl .= '&search_type='.$search_type;
    }
}

$arr_indicator_types = array();
$arr_indicator_types = get_indicator_type_list();

$sql = "SELECT COUNT(*) FROM ".$tbl." A".$where;
$count = $db->GetOne($sql);

$page = $_GET['pn'] ? (int)$_GET['pn'] : 1;
$limit = $limit ? (int)$limit : 10;
$offset = ($page-1)*$limit;

$page_nav = page($count,$limit,$page,$pageurl);

$sql = "SELECT A.*, T.`type` FROM ".$tbl." A LEFT JOIN `".DB_PREFIX."indicator_type` T ON A.`typeid`=T.`typeid`".$where." ORDER BY A.`id` ASC LIMIT {$offset},{$limit}";
$rs = $db->GetAll($sql);

$canadd = intval($p_power[$m."_".$a."_edit"]);

if(is_array($rs)){
    foreach($rs as $k => $r){
        $rs[$k]['canedit'] = intval($p_power[$m."_".$a."_edit"]);
        $rs[$k]['candel'] = intval($p_power[$m."_".$a."_del"]);
    }
}

$u = urlencode($pageurl."&pn=".$page);

include(Template($m."_".$a));
?>
