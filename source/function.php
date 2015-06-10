<?php
defined('IN_UF') or exit('Access Denied');

function epre($array){
    echo("<pre>");
    print_r($array);
    echo("</pre>");
}

function json_halt($result,$msg){
    header('Content-type: text/html; charset=UTF-8');

    $arr = array();
    $arr[error] = $result;

    if($result == 1){
        $arr[message] = iconv("gbk","utf-8//ignore",$msg);
    }
    else{
        $arr[url] = $msg;
    }

    echo(json_encode($arr));
    exit;
}

function halt($error){
    echo is_array($error)?$error['message']:$error;
    exit;
}

function halt2($msg='',$url='',$parent=0){
    $output = '';

    $output .= '<script type="text/javascript">';
    $output .= $msg?'alert("'.$msg.'");':'';

    if($parent){
        for($i=0;$i<$parent;$i++){
            $output .= 'parent.';
        }
    }

    $output .= $url?'document.location.href="'.$url.'";':'';
    $output .= '</script>';
    echo $output;
    exit;
}

function halt_http_referer($msg=''){
    global $m,$a;

    $referer = $_SERVER[HTTP_REFERER] ? $_SERVER[HTTP_REFERER] : "index.php?m=".$m."&a=".$a;
    halt2($msg,$referer);
}

function halt_referer($msg=''){
    global $m,$a;

    $referer = $_SERVER[HTTP_REFERER] ? $_SERVER[HTTP_REFERER] : "index.php?m=".$m."&a=".$a;
    $referer = $_POST[referer] ? $_POST[referer] : $referer;
    halt2($msg,$referer);
}

function redirect($url,$time=0,$msg=''){
    $url = str_replace(array("\n","\r"),'',$url);
    if(empty($msg)) $msg = "系统将在{$time}秒之后自动跳转到{$url}！";

    if(!headers_sent()){
        if(!$time){
            header('Location: '.$url);
        }else{
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
    }else{
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if($time)
            $str .= $msg;
        echo $str;
    }
    exit;
}

function csubstr($str,$start,$len){
    $strlen = strlen($str); 
    $clen = 0;

    for($i = 0;$i < $strlen; $i++,$clen++){
        if($clen >= $start + $len){
            break;
        }

        if(ord(substr($str,$i,1)) > 0xa0){
            if($clen >= $start){
                $tmpstr .= substr($str,$i,2);
            }

            $i++;
        }
        else{
            if($clen >= $start){
                $tmpstr .= substr($str,$i,1);
            }
        }
    }

    return $tmpstr; 
}

function write_file($file,$source,$do='w'){
    if($fp = fopen($file,$do)){
        if(flock($fp,LOCK_EX)){
            $fileSource = fwrite($fp,$source);
            flock($fp,LOCK_UN);
        }else{
            die("无法锁定文件，该文件系统可能是NFS或FAT！");
        }
        fclose($fp);
        return $fileSource;
    }else{
        return false;
    }
}

function page($count=0,$limit=0,$page=1,$pageurl='',$anchor=''){
    $pages  = $count?ceil($count/$limit):1;
    $output = '';

    $output .= '<span>共'.$count.'条 <em class="c-yel">'.$page.'</em>/'.$pages.'</span>';

    if($pages>1){
        if($page > 1){
            $output .= '<a href="'.$pageurl.'&pn=1'.$anchor.'">首页</a>';
            $output .= '<a href="'.$pageurl.'&pn='.($page>1?$page-1:$page).$anchor.'">上一页</a>';
        }

        if($page < $pages){
            $output .= '<a href="'.$pageurl.'&pn='.($page<$pages?$page+1:$page).$anchor.'">下一页</a>';
            $output .= '<a href="'.$pageurl.'&pn='.$pages.$anchor.'">末页</a>';
        }

        $output .= '<input type="text" class="width30" id="page_inp" value="'.($page<$pages?$page+1:$page).'" />&nbsp;';
        $output .= '<input type="button" name="跳转" class="tiaoz" onclick="window.location=\''.$pageurl.'&pn=\'+document.getElementById(\'page_inp\').value+\''.$anchor.'\'" />';
    }
    return $output;
}

function get_insert_sql($table,$arrFields){
    for($i=1;$i<=count($arrFields);$i++){ 
        if($i == 1){
            $ss1 = "`".key($arrFields)."`"; 
            $ss2 = "'".($arrFields[key($arrFields)])."'"; 
        }
        else{
            $ss1.= ", `".key($arrFields)."`";
            $ss2.= ", '".($arrFields[key($arrFields)])."'";
        }

        next($arrFields);
    }

    $sql = "INSERT INTO $table ($ss1) VALUES ($ss2)";
    return $sql;
}

function get_update_sql($table,$arrFields,$where=false){
    for($i=1;$i<=count($arrFields);$i++){ 
        if($i == 1) $ss = "`".key($arrFields)."`='".($arrFields[key($arrFields)])."' ";
        else $ss.= ",`".key($arrFields)."`='".($arrFields[key($arrFields)])."' ";

        next($arrFields) ;
    }

    if($where) $sql = "UPDATE $table SET $ss WHERE $where";
    else $sql = "UPDATE $table SET $ss";

    return $sql;
}

function get_client_ip(){
    $cip = $_SERVER["REMOTE_ADDR"];
    if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $tip = split(",",$_SERVER["HTTP_X_FORWARDED_FOR"]);
        $cip = $tip[0];
    }

    return $cip;
}

function remote_file_exists($url_file){
    // 检测输入
    $url_file = trim($url_file);
    if(empty($url_file)){
        return false;
    }

    $url_arr = parse_url($url_file);
    if(!is_array($url_arr) || empty($url_arr)){
        return false;
    }

    // 获取请求数据 
    $host = $url_arr['host'];
    $path = $url_arr['path'] ."?".$url_arr['query'];
    $port = isset($url_arr['port']) ?$url_arr['port'] : "80";

    // 连接服务器 
    $fp = @fsockopen($host, $port, $err_no, $err_str,30);
    if(!$fp){
        return false;
    }

    // 构造请求协议 
    $request_str = "GET ".$path."HTTP/1.1\r\n";
    $request_str .= "Host:".$host."\r\n";
    $request_str .= "Connection:Close\r\n\r\n";

    // 发送请求 
    fwrite($fp,$request_str);
    $first_header = fgets($fp, 1024);
    fclose($fp);

    // 判断文件是否存在 
    if(trim($first_header) == ""){
        return false;
    }

    if(!preg_match("/200/", $first_header)){ 
        return false; 
    }

    return true; 
}

function get_authcode($string,$operation="DECODE",$key="",$expiry=0) {
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
    $ckey_length=4;
    
    // 密匙
    $key=md5($key?$key:"house365");
    
    // 密匙a会参与加解密
    $keya=md5(substr($key,0,16));

    // 密匙b会用来做数据完整性验证
    $keyb=md5(substr($key,16,16));

    // 密匙c用于变化生成的密文
    $keyc=$ckey_length?($operation=="DECODE"?substr($string,0,$ckey_length):substr(md5(microtime()),-$ckey_length)):"";

    // 参与运算的密匙
    $cryptkey=$keya.md5($keya.$keyc);
    $key_length=strlen($cryptkey);

    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
    $string=$operation=="DECODE"?base64_decode(substr($string,$ckey_length)):sprintf("%010d",$expiry?$expiry+time():0).substr(md5($string.$keyb),0,16).$string;
    $string_length=strlen($string);
    $result="";
    $box=range(0,255);
    $rndkey=array();

    // 产生密匙簿
    for($i=0;$i<=255;$i++) {
        $rndkey[$i]=ord($cryptkey[$i%$key_length]);
    }

    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
    for($j=$i=0;$i<256;$i++){
        $j=($j+$box[$i]+$rndkey[$i])%256;
        $tmp=$box[$i];
        $box[$i]=$box[$j];
        $box[$j]=$tmp;
    }

    // 核心加解密部分
    for($a=$j=$i=0;$i<$string_length;$i++) {
        $a=($a+1)%256;
        $j=($j+$box[$a])%256;
        $tmp=$box[$a];
        $box[$a]=$box[$j];
        $box[$j]=$tmp;

        // 从密匙簿得出密匙进行异或，再转成字符
        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
    }

    if($operation=="DECODE") {
        // substr($result,0,10)==0 验证数据有效性
        // substr($result,0,10)-time()>0 验证数据有效性
        // substr($result,10,16)==substr(md5(substr($result,26).$keyb),0,16) 验证数据完整性
        // 验证数据有效性，请看未加密明文的格式
        if((substr($result,0,10)==0||substr($result,0,10)-time()>0) && substr($result,10,16)==substr(md5(substr($result,26).$keyb),0,16)){
            return substr($result,26);
        } else {
            return "";
        }
    } else {
        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
        return $keyc.str_replace("=","",base64_encode($result));
    }
}
?>