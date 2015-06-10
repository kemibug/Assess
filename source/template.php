<?
function Template($tplname,$template="",$shtml="",$fix="",$tm=0){
    global $var_template,$var_shtml;

    $web_temp = $template ? $template : P_TEMPLATE;
    $web_tempfix = $fix ? $fix : P_TEMPPREFIX;
    $web_sh = $shtml ? $shtml : P_SHTML;

    if($tm==0){
        $web_temp.=$var_template;
        $web_sh.=$var_shtml;
    }

    $tplname = $web_tempfix.$tplname;
    $tplname = $web_temp.'/'.$tplname;
    $tplname.=".html";
    $tplname = Pcv($tplname);

    if(file_exists($tplname))
        return getTplName($tplname,$web_sh);
}

function getTplName($tplname,$web_sh){

    $cache_name = str_replace(array('template/','/'),array('','_'),$tplname);
    $cache_name = Pcv($cache_name);
    $cache_name = $web_sh."/".$cache_name;


    if(file_exists($cache_name) || filemtime($tplname)>filemtime($cache_name)){
        $file_str = readover($tplname);
        $s = array(
        "{@","@}",
        "<!--#","#-->",
        );
        $e = array(
        "\nEOT;\necho ",";print <<<EOT\n",
        "\nEOT;\n","print <<<EOT\n",
        );
        if(function_exists('str_ireplace'))    $file_str = str_ireplace($s,$e,$file_str);
        else $file_str = str_replace($s,$e,$file_str);
        
        $file = "<?php\n";        
        $file .= "print <<<EOT\n$file_str\nEOT;\n?>";
        $file = preg_replace("/print \<\<\<EOT[\n\r]*EOT;/s","",$file);
        writeover($cache_name,$file);
    }

    return $cache_name;
}

function readover($filename,$method="rb"){
    strpos($filename,'..')!==false && exit('Forbidden');
    if($handle=@fopen($filename,$method)){
        flock($handle,LOCK_SH);
        $filedata=fread($handle,filesize($filename));
        fclose($handle);
    }
    return $filedata;
}

function writeover($filename,$data,$method="rb+",$iflock=1,$check=1,$chmod=1){
    $check && strpos($filename,'..')!==false && exit('Forbidden');
    touch($filename);
    $handle=fopen($filename,$method);
    $iflock && flock($handle,LOCK_EX);
    if(@fwrite($handle,$data)=== FALSE){
        fclose($handle);
        return false;
    }
    if($method=="rb+") ftruncate($handle,strlen($data));
    fclose($handle);
    $chmod && @chmod($filename,0777);
    return true;
}

function Pcv($filename,$ifcheck=1){
    strpos($filename,'http://')!==false && exit('Forbidden');
    
    $ifcheck && strpos($filename,'..')!==false && exit('Forbidden');
    return $filename;
}
?>