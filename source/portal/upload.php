<?php
defined('IN_UF') or exit('Access Denied');

set_time_limit(0);

if(!isset($_FILES["imgFile"]) || !is_uploaded_file($_FILES["imgFile"]["tmp_name"]) || $_FILES["imgFile"]["error"] != 0){
    json_halt(1,"There was a problem with the upload");
}else{
    require_once $web_root.'source/uploadFile.php';

    $uf = new UploadFile("imgFile");
    $uf->setFileType("jpg|jpeg|gif|png");
    $uf->setMaxSize("2000");
    $uf->setUploadType("ftp");
    $uf->setSaveDir("/tlfjk/");

    $stat = $uf->upload();

    if($stat == "success"){
        $picurl = $uf->getSaveFileURL();
        json_halt(0,$picurl);
    }else{
        json_halt(1,$stat);
        exit();
    }
}
?>
