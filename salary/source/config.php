<?php
defined('IN_UF') or exit('Access Denied');

define('DB_PREFIX','sa_');          // 数据库表前缀

define('P_OA','http://oa.house365.com/');
$p_oa = P_OA;

define('P_SYSTITLE','365绩效考核系统');
define('P_SYSPATH','http://221.231.141.162/salary/');
define('P_STATICPATH',P_SYSPATH.'static/');
define('P_IMGPATH',P_STATICPATH.'images/');
define('P_CSSPATH',P_STATICPATH.'css/');
define('P_JSPATH',P_STATICPATH.'js/');

$p_systitle = P_SYSTITLE;
$p_syspath = P_SYSPATH;
$p_staticpath = P_STATICPATH;
$p_imgpath = P_IMGPATH;
$p_csspath = P_CSSPATH;
$p_jspath = P_JSPATH;

define("P_TEMPPREFIX","tp_");
define("P_TEMPLATE",$web_root."template");
define("P_SHTML",$web_root."shtml");

define("P_OA_API",P_OA."api/api_el.php?k=".md5("el_key"));

$cfg = array(
    'DB_TYPE' => 'mysql',       // 数据库类型
    'DB_HOST' => '172.17.1.13', // 服务器地址
    'DB_NAME' => 'salary',          // 数据库名
    'DB_USER' => 'root',        // 用户名
    'DB_PWD'  => 'idontcare',   // 密码
    'DB_PORT' => '3306'         // 端口
);

$cfg['POWER'] = array(
    'setting' => array(
        'name' => "考核设置",
        'detail' => array('indicator_type' => '量化指标分类','indicator_list' => '量化指标管理'),
        'indicator_type' => array('edit' => '编辑','del' => '删除'),
        'indicator_list' => array('edit' => '编辑','del' => '删除'),
    ),
    'assessment' => array(
        'name' => "考核管理",
        'detail' => array('list'=>'考核管理'),
        'list' => array('edit' => '编辑'),
    ),
    'myassessment' => array(
        'name' => "我的考核",
        'detail' => array('byme' => '待我考核','my' => '我的考核'),
        'addmem' => array('edit' => '编辑'),
    ),
    'report' => array(
        'name' => "报表统计",
        'detail' => array('report' => '绩效报表'),
        'report' => array('edit' => '编辑'),
    ),
    'auth' => array(
        'name' => "权限管理",
        'detail' => array('group' => '角色管理','user' => '用户管理'),
        'group' => array('edit' => '编辑','del' => '删除'),
        'user' => array('edit' => '编辑','del' => '删除'),
    ),
    'log' => array(
        'name' => "日志管理",
        'detail' => array('list' => '日志列表'),
        'list' => array(),
    ),
);

$cfg['audit_status'] = array(
    '1' => '未审核',
    '2' => '已审核',
);

$cfg['yesno_status'] = array(
    '1' => '是',
    '2' => '否',
);

$cfg['city'] = array(
    "集团",
    '南京',
    '苏州',
    '昆山',
    '无锡',
    '常州',
    '合肥',
    '芜湖',
    '杭州',
    '西安',
    '重庆',
    '沈阳',
    '蚌埠',
    '滁州',
    '马鞍山',
    '阜阳',
    '武汉',
    '哈尔滨',
    '长春',
    '天津',
    '昆明',
    '石家庄',
);

$cfg['city'] = array(
    '1' => '南京',
    '2' => '苏州',
    '3' => '昆山',
    '4' => '无锡',
    '5' => '常州',
    '6' => '合肥',
    '7' => '芜湖',
    '8' => '杭州',
    '9' => '西安',
    '10' => '重庆',
    '11' => '沈阳',
    '101' => '蚌埠',
    '102' => '滁州',
    '103' => '马鞍山',
    '104' => '阜阳',
    '105' => '武汉',
    '106' => '哈尔滨',
    '107' => '长春',
    '108' => '天津',
    '109' => '昆明',
    '110' => '石家庄',
);

$cfg['tixi'] = array(
    "1" => array(
        "title" => "总部职能",
        "deptlist" => array(
            "1" => "董事会办公室",
            "3" => "审计部",
            "6" => "人力资源管理中心",
            "5" => "研发中心",
            "16" => "第一移动互联网中心",
            "17" => "第二移动互联网中心",
            "12" => "投资部",
            "7" => "财务管理中心",
            "8" => "行政管理中心",
            "14" => "品牌部",
            "9" => "365学院",
            "13" => "创新产业研究院",
            "4" => "移动互联网中心",
            "18" => "数据中心",
        ),
     ),
    "9" => array(
        "title" => "房产事业部",
        "deptlist" => array(
            "1" => "事业部本部",
            "2" => "南京大区",
            "6" => "合肥大区",
            "3" => "苏州公司",
            "4" => "芜湖公司",
            "5" => "无锡公司",
            "8" => "常州公司",
            "7" => "杭州公司",
            "9" => "昆山公司",
            "10" => "西安公司",
            "11" => "重庆公司",
            "12" => "沈阳公司",
            "21" => "石家庄公司",
            "22" => "哈尔滨公司",
            "23" => "武汉公司",
            "24" => "长春公司",
            "25" => "天津公司",
            "26" => "昆明公司",
        ),
        "childdept" => array(
            "2" => array(
                "1" => "新房公司",
                "2" => "二手房公司",
                "3" => "家居公司",
                "4" => "装修惠公司",
            ),
            "6" => array(
                "1" => "新房公司",
                "2" => "二手房公司",
                "3" => "肥肥公司",
            ),
         ),
     ),
     "10" => array(
        "title" => "小区宝公司",
        "deptlist" => array(
            "1" => "南京公司",
            "2" => "合肥公司",
            "3" => "芜湖公司",
        ),
     ),
     "12" => array(
        "title" => "装修宝公司",
        "deptlist" => array(
            "99" => "装修宝总部",
            "1" => "苏州公司",
            "2" => "无锡公司",
            "3" => "合肥公司",
            "4" => "常州公司",
            "5" => "杭州公司",
            "6" => "西安公司",
        ),
     ),
     "8" => array(
        "title" => "安家贷公司",
        "deptlist" => array(
            "1" => "安家贷公司",
        ),
     ),
    "11" => array(
        "title" => "房产战略发展部",
        "deptlist" => array(
            "1" => "房产战略发展部",
        ),
     ),
    "6" => array(
        "title" => "网尚研究机构",
        "deptlist" => array(
            "1" => "网尚研究机构",
        ),
     ),
    "2" => array(
        "title" => "新房事业部",
        "deptlist" => array(
            "1" => "事业部本部",
            "2" => "南京公司",
            "3" => "苏州公司",
            "4" => "芜湖公司",
            "5" => "无锡公司",
            "6" => "合肥公司",
            "7" => "杭州公司",
            "8" => "常州公司",
            "9" => "昆山公司",
            "10" => "西安公司",
            "11" => "重庆公司",
            "12" => "沈阳公司",
        ),
     ),
    "3" => array(
        "title" => "家居事业部",
        "deptlist" => array(
            "1" => "事业部本部",
            "2" => "南京公司",
            "3" => "苏州公司",
            "4" => "芜湖公司",
            "5" => "无锡公司",
            "6" => "合肥公司",
            "7" => "杭州公司",
            "8" => "常州公司",
            "9" => "昆山公司",
            "10" => "西安公司",
            "11" => "重庆公司",
            "12" => "沈阳公司",
        ),
     ),
    "4" => array(
        "title" => "二手房事业部",
        "deptlist" => array(
            "1" => "事业部本部",
            "2" => "南京公司",
            "3" => "苏州公司",
            "4" => "芜湖公司",
            "5" => "无锡公司",
            "6" => "合肥公司",
            "7" => "杭州公司",
            "8" => "常州公司",
            "9" => "昆山公司",
            "10" => "西安公司",
            "11" => "重庆公司",
            "12" => "沈阳公司",
        ),
     ),
    "5" => array(
        "title" => "生活业务",
        "deptlist" => array(
            "1" => "合肥热线",
            "2" => "南京公司",
            "3" => "芜湖公司",
        ),
     ),
    "7" => array(
        "title" => "其他",
        "deptlist" => array(
            "1" => "巨鑫测绘",
            "2" => "网景公司",
        ),
     ),
);
?>