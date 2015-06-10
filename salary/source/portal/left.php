<?php
defined('IN_UF') or exit('Access Denied');

if($p_userinfo[photourl] == ""){
    $p_userinfo[photourl] = $p_imgpath."img01.jpg";
    $photourl = '<img src="'.$p_userinfo[photourl].'" />';
}
else{
    // 此处需缓存 memcache
    if($info = getimagesize($p_userinfo[photourl])){
        $width = $info[0];
        $height = $info[1];

        $int_width = 150;
        $int_height = 180;

        if($width >= $int_width || $height >= $int_height){
            if($height/$width > $int_width/$int_height){
                $photourl = '<img src="'.$p_userinfo[photourl].'" height="'.$int_height.'" />';
            }
            else{
                $photourl = '<img src="'.$p_userinfo[photourl].'" width="'.$int_width.'" />';
            }
        }
        else{
            $photourl = '<img src="'.$p_userinfo[photourl].'" />';
        }
    }
    else{
        $photourl = '<img src="'.$p_userinfo[photourl].'" width="78" />';
    }
}

if( $user['parttime'] ) {
	$changepass = '<a href="index.php?m=changepass" target="mainFrame">修改密码</a>';
}

include(Template("left"));
?>
