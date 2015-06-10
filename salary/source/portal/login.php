<?php
defined('IN_UF') or exit('Access Denied');

if($a == 'login'){
    // 此处安全性稍弱，待改进
    $authcode = get_authcode($_GET["authcode"]);

    if(!$authcode){
        halt2('请先登陆OA~~','?m=login');
    }

    list($uid,$username) = explode("$",$authcode);

    if(!$uid || !$username){
        halt2('请先登陆OA~~','?m=login');
    }


    $ntime = time();
    $sql = "SELECT * FROM `".DB_PREFIX."user` WHERE `uid`='{$uid}'";
    if(!$info = $db->GetRow($sql)){
        $info = array();

        $info['uid'] = $uid;
        $info['gid'] = 1;
        $info['username'] = $username;

        // 更新用户信息
        $api_url = P_OA_API."&a=get_userinfo&uid=".$uid;
        $p_userinfo = get_api_content($api_url);

        $info['city'] = get_city_by_dept($p_userinfo['department_all']);

        $info['did'] = $p_userinfo['deptid'];
        $info['dept'] = $p_userinfo['department'];
        $info['deptlist'] = $p_userinfo['department_all'];
        $info['priv'] = $p_userinfo['priv'];
        $info['tixi'] = $p_userinfo['tixi'];
        $info['comp_dept'] = $p_userinfo['comp_dept'];

        $info['status'] = 1;
        $info['lastlogin'] = $ntime;
        $info['dateline'] = $ntime;

        $sql = get_insert_sql("`".DB_PREFIX."user`",$info);
        $db->Execute($sql);
    }else{
        $userinfo = array();

        $userinfo['lastlogin'] = $info['lastlogin'] = $ntime;

        $sql = get_update_sql("`".DB_PREFIX."user`",$userinfo,"uid='".$info[uid]."'");
        $db->Execute($sql);
    }
    
    $_SESSION[DB_PREFIX.'uid'] = $info['uid'];
    $_SESSION[DB_PREFIX.'gid'] = $info['gid'];
    $_SESSION[DB_PREFIX.'username'] = $info['username'];

    if($_GET['login_ref'] != ''){
        redirect('?m=frame&login_ref='.urlencode($_GET['login_ref']));
    }
    else{
        redirect('?m=frame');
    }
}

redirect(P_OA);
?>