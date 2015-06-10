<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-6-8
 * Time: 下午2:11
 *  Describe :  发起考核，填写考核基本信息，考核类型事项信息等
 * Author : wmc
 */

//判断用户改脚本访问权限
function checkUserAuthority(){

}


//根据base_id获取考核相关信息
function getAssessRecordInfo($base_id){
    global $db;

    $record_info = array();
    //获取基础表相关信息
    $base_sql = "select * from assess_base where base_id={$base_id} ";
    $base_info = $db->GetOne($base_sql);
    if($base_info){
        $record_info['base_info'] = $base_info;
    }

    //获取属性类型表相关信息
    $attr_sql = "select * from assess_attr where  base_id={$base_id}";
    $attr_info = $db->GetAll($attr_sql);
    if($attr_info){
        $record_info['attr_info'] = $attr_info;
    }

    return $record_info;
}

$base_id = getgpc('base_id'); //考核表主键
$user_id = '';//当前用户身份Id

if(checkUserAuthority()){
    //ajax表单提交
    if(isset($_REQUEST['formSub'])){

    }else{
        //当$base_id存在时，说明此考核已经存在，属于更新操作，否则属于新建考核
        $record_info = array();
        if($base_id){
            $record_info = getAssessRecordInfo($base_id);
        }
    }


    $attrTypeMaps = array(
        '1'=>'量化指标类',
        '2'=>'工作任务类',
        '3'=>'打分类',
        '4'=>'提成类'
    );
    include(Template($m."_".$a));
}

