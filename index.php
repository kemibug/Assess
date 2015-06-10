<?php
require_once dirname(__FILE__).'/source/application.php';
require_once dirname(__FILE__).'/source/function_portal.php';
require_once dirname(__FILE__).'/source/portal.class.php';
require_once dirname(__FILE__).'/source/template.php';
$portal = new portal();

if($m == ''){
    redirect(P_OA);
}

$web_root = dirname(__FILE__).'/';

if($m != 'login' && $m != 'api'){
    if(isset($_REQUEST["sidhash"])){
        $authcode = get_authcode($_REQUEST["sidhash"]);
        list($uid,$gid,$username) = explode("$",$authcode);
    
        $_SESSION[DB_PREFIX.'uid']   = $uid;
        $_SESSION[DB_PREFIX.'gid']   = $gid;
        $_SESSION[DB_PREFIX.'username'] = $username;
    }

    if(!$_SESSION[DB_PREFIX.'uid']) redirect('?m=login');
    
    $p_uid = $_SESSION[DB_PREFIX.'uid'];
    $p_gid = $_SESSION[DB_PREFIX.'gid'];
    $p_username = $_SESSION[DB_PREFIX.'username'];

    $sql = "SELECT * FROM `".DB_PREFIX."user` WHERE `uid`='{$p_uid}'";
    $user = $db->GetRow($sql);

    $p_city = $user['city'];
    $p_tixi = $user['tixi'];
    $p_comp_dept = $user['comp_dept'];

    if($p_gid == 0){
        redirect('?m=login',5,'尚未开通系统权限,请联系管理员开通权限!');
    }

    $api_url = P_OA_API."&a=get_userinfo&uid=".$p_uid;
    $p_userinfo = get_api_content($api_url);

    $sql = "SELECT `all`, `power` FROM `".DB_PREFIX."group` WHERE `id`={$p_gid}";
    $info = $db->GetRow($sql);
    $p_power = unserialize($info[power]);
    $p_auth_all = $info[all];
}

if(in_array($m,array('login','channel','frame','top','left','main','help','exit','api','help','upload'))){
    include_once 'source/portal/'.$m.'.php';
}
else{
    if($p_power[$m."_".$a] != 1){
        halt2('无此权限~~','?m=main');
    }

    include_once $portal->display();
}
?>