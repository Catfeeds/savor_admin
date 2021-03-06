<?php
//系统配置
$config = array(
    //路由配置
    'URL_MODEL'				=>2,
    'URL_CASE_INSENSITIVE'  => true, //url支持大小写
    'MODULE_DENY_LIST'      => array('Common','Runtime'), // 禁止访问的模块列表
    'MODULE_ALLOW_LIST'     => array('Admin'), //模块配置
    'DEFAULT_MODULE'        => 'Admin',
    //session cookie配置
    'SESSION_AUTO_START'    =>  true,    // 是否自动开启Session
    'SESSION_OPTIONS'       =>  array(), // session 配置数组 支持type name id path expire domain 等参数
    'SESSION_TYPE'          =>  '', // session hander类型 默认无需设置 除非扩展了session hander驱动
    'SESSION_PREFIX'        =>  'savor_', // session 前缀
    //数据库配置
    'DB_FIELDS_CACHE' 		=> true,
    'DATA_CACHE_TABLE'      =>'savor_datacache',
    //报错页面配置
    'TMPL_ACTION_ERROR'     => 'Public:prompt', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   => 'Public:prompt', // 默认成功跳转对应的模板文件

    //日志配置
    'LOG_RECORD'            =>  false,   // 默认不记录日志
    'LOG_TYPE'              =>  'File', // 日志记录类型 默认为文件方式
    'LOG_LEVEL'             =>  'EMERG,ALERT,CRIT,ERR',// 允许记录的日志级别
    'LOG_EXCEPTION_RECORD'  =>  false,    // 是否记录异常信息日志
    //缓存目录配置
    'MINIFY_CACHE_PATH'=>APP_PATH.'Runtime/Cache',
    'HTML_FILE_SUFFIX' => '.html',// 默认静态文件后缀
    'HOST_NAME'=>'http://'.$_SERVER['HTTP_HOST'],
    'HTTPS_HOST_NAME'=>'https://'.$_SERVER['HTTP_HOST'],
    'SITE_NAME'=> '寻味后台管理',
    'SHOW_ERROR_MSG' =>  true, //显示错误信息
    'OSS_ADDR_PATH'=>'media/resource/',
	'SECRET_KEY' => 'sw&a-lvd0onr!',//解密接口数据key
	'SHOW_URL_APP_KEY'=>'258257010', //新浪短链接appkey
	'BAIDU_GEO_KEY'=>'q1pQnjOG28z8xsCaoby2oqLTLaPgelyq',

);
if(APP_DEBUG === false){
    $config['TMPL_TRACE_FILE'] = APP_PATH.'Site/View/Public/404.html';   // 页面Trace的模板文件
    $config['TMPL_EXCEPTION_FILE'] = APP_PATH.'Site/View/Public/404.html';// 异常页面的模板文件
}

$config['DEVICE_TYPE'] = array(
    '1'=>'小平台',
    '2'=>'机顶盒',
    '3'=>'android',
    '4'=>'ios',
    '5'=>'餐厅端_android',
    '6'=>'餐厅端_ios',
    '7'=>'运维端_android',
    '8'=>'运维端_ios',
    '9'=>'运维-单机版_android',
    '10'=>'运维-单机版_ios',
);
$config['UPDATE_TYPE'] = array(
    '0'=>'手动更新',
    '1'=>'强制更新',
);
$config['RESOURCE_TYPE'] = array(
    '1'=>'视频',
    '2'=>'图片',
    '3'=>'其他',
);
$config['ADS_TYPE'] = array(
    '1'=>'广告',
    '2'=>'节目',
    '3'=>'宣传片',
);
$config['RESOURCE_TYPEINFO'] = array(
    'mp4'=>1,
    'mov'=>1,
    'jpg'=>2,
    'png'=>2,
    'gif'=>2,
    'jpeg'=>2,
    'bmp'=>2,
);
$config['HOTEL_LEVEL'] = array(
    '3'=>'3A',
    '4'=>'4A',
    '5'=>'5A',
    '6'=>'6A',
);
$config['CONTENT_TYPE'] = array(
    '1'=>'图文',
    '3'=>'视频',
);
$config['HOTEL_STATE'] = array(
    '1'=>'正常',
    '2'=>'冻结',
    '3'=>'报损',
);

$config['HOTEL_KEY'] = array(
    '1'=>'重点',
    '2'=>'非重点',
);

$config['PWDPRE'] = 'SAVOR@&^2017^2030&*^';
$config['NUMPERPAGE'] = array('50','100','200','500');
$config['MANGER_STATUS'] = array(
    '1'=>'启用',
    '2'=>'禁用'
);
$config['MANGER_LEVEL'] = array(
    '0'=>'一级栏目',
    '1'=>'二级栏目',
    '2'=>'三级栏目'
);

$config['MANGER_STATE'] = array(
    '0'=>'未审核',
    '2'=>'审核通过',
    '3'=>'审核不通过',
);
$config['MANGER_KEY'] = array(
    'colum'=>'版本管理节点',
    'cms'=>'程序节点',
    'system'=>'系统节点',
    'send' =>'内容节点',
    'version'=>'版本更新节点',
    'menu' =>'节目节点',
    'ad' =>'广告节点',
    'hotel' =>'酒楼节点',
    'report'=>'报表节点',
    'testreport'=>'测试报表节点',
    'checkaccount'=>'对账系统节点',
    'dailycontent'=>'每日知享节点',

    'newmenu'=>'新节目节点',
    'advdelivery'=>'广告投放节点',
	'option'=>'运维客户端',
    'installoffer'=>'网络设备报价',

);
$config['STATE_REASON'] = array(
    '1'=>'正常',
    '2'=>'倒闭',
    '3'=>'装修',
    '4'=>'淘汰',
    '5'=>'放假',
    '6'=>'易主',
    '7'=>'终止合作',
    '8'=>'问题沟通中',
);
$config['hotel_box_type'] = [
    '1'=>'一代单机版',
    '2'=>'二代网络版',
    '3'=>'二代5G版',
    //U盘更新
    '4'=>'二代单机版',
    '5'=>'三代单机版',
    '6'=>'三代网络版',
];
$config['heart_hotel_box_type'] = array(
    '2'=>'二代网络版',
    '3'=>'二代5G版',
);
$config['source_type'] = array(
    '1'=>'官网',
    '2'=>'客户端二维码',
    '3'=>'客户端分享',
    '4'=>'节目',
    '5'=>'服务员扫码',
);
$config['fee_type'] = array(
    '1'=>'开机费',
    '2'=>'APP推广',
);
$config['NOTICE_STATAE'] = array(
    '1'=>'',
    '2'=>'发送失败(酒楼不存在)',
    '3'=>'发送失败(酒楼费用已经下发)',
    '4'=>'发送失败(对账单联系人电话为空)',
    '5'=>'发送失败(酒楼下发金额为负值)',
    '6'=>'发送失败(EXCEL表中已经存在酒楼)',
    '7'=>'发送失败(酒楼下发金额为空值)',
);
$config['CHECK_STATAE'] = array(
    '0'=>'未读',
    '1'=>'已读',
    '2'=>'已确认',
    '3'=>'已付款',
    '99'=>'未读',
);
$config['MOBILE_TYPE'] = array(
    '1' => array('id'=>1, 't'=>'Iphone 4', 'w'=>'320', 'h'=>'480'),
    '2' => array('id'=>2, 't'=>'Iphone 5', 'w'=>'320', 'h'=>'568'),
    '3' => array('id'=>3, 't'=>'Iphone 6', 'w'=>'375', 'h'=>'667'),
    '4' => array('id'=>4, 't'=>'Iphone 6 Plus', 'w'=>'414', 'h'=>'736'),
    '5' => array('id'=>5, 't'=>'Ipad Mini', 'w'=>'768', 'h'=>'1024'),
    '6' => array('id'=>6, 't'=>'Ipad', 'w'=>'768', 'h'=>'1024'),
    '7' => array('id'=>7, 't'=>'Galaxy S5', 'w'=>'360', 'h'=>'640'),
    '8' => array('id'=>8, 't'=>'Nexus 5X', 'w'=>'411', 'h'=>'731'),
    '9' => array('id'=>9, 't'=>'Nexus 6P', 'w'=>'435', 'h'=>'773'),
    '10' => array('id'=>10, 't'=>'Laptop MDPI', 'w'=>'1280', 'h'=>'800'),
    '11' => array('id'=>11, 't'=>'Laptop HiDPI', 'w'=>'1440', 'h'=>'900'),
);
$config['SMS_CONFIG'] = array(
    'accountsid'=>'6a929755afeded257916ca68518ec1c3',
    'token'     =>'66edd50a46c882a7f4231186c44416d8',
    'appid'     =>'a982fdb55a2441899f2eaa64640477c0',
    'bill_templateid'=>'76285',
    'payment_templateid'=>'78145',
    'vcode_templateid'=>'107496',
    //'notice_templateid'=>'107928',
    'notice_templateid'=>'146776',
);
$config['ACTIVITY_SOURCE_ARR'] = array(
    '1'=>'App',
    '2'=>'App推送',  
    '3'=>'微信客户端',
    '4'=>'微信公众号',
);
$config['SMALL_WARN'] = array(
    '1'=>'未处理',
    '2'=>'已处理',
);

$config['SP_GR_STATE'] = array(
    '0'=>'未发布',
    '1'=>'已发布',
    '2'=>'已删除',
);

$config['WX_DYH_CONFIG'] = array(
    'appid'=>'wxb19f976865ae9404',
    'appsecret'=>'977d15e1ce3c342c123ae6f30bcfeb48',
);
$config['WX_FWH_CONFIG'] = array(
    'appid'=>'wx7036d73746ff1a14',
    'appsecret'=>'64e1aa2f06146f901f013198d92ef1c9',
    'key_ticket'=>'savor_wx_xiaorefu_jsticket',
    'key_token'=>'savor_wx_xiaorefu_token',
);

$config['XIAO_REDIAN_DING'] = array(
    'appid'=>'wxb19f976865ae9404',
    'appsecret'=>'977d15e1ce3c342c123ae6f30bcfeb48',
    'key_ticket'=>'savor_wx_xiaore_jsticket',
    'key_token'=>'savor_wx_xiaore_token',
);


$config['ZHI_XIANG_CONFIG'] = array(
    'appid'=>'wx75025eb1e60df2cf',
    'appsecret'=>'32427ebb0caae2d9e76747fed56e2071',
    'key_ticket'=>'savor_wx_zhixiang_jsticket',
    'key_token'=>'savor_wx_zhixiang_token',
    'cardapi_ticket'=>'savor_wx_zhixiang_cardapiticket',
    'token'=>'savor',
);

$config['UMENT_API_CONFIG'] = array(
     'API_URL'=>'http://msg.umeng.com/api/send',
     'opclient'=>array(
         'AppKey'=>'59acb7f0f29d98425d000cfa',
         'App_Master_Secret'=>'75h0agzaqlibje6t2rtph4uuuocjyfse',
         'ios_AppKey'=>'59b1260a734be41803000022',
         'ios_App_Master_Secret' =>'wgyklqy5uu8dacj9yartpic9xmpkezs4',
     ),
);


$config['UMENBAI_API_CONFIG'] = array(
    'API_URL'=>'http://msg.umeng.com/api/send',
    'opclient'=>array(
        'android_appkey'=>'59acb7f0f29d98425d000cfa',
        'android_master_secret'=>'75h0agzaqlibje6t2rtph4uuuocjyfse',
        'ios_appkey'=>'59b1260a734be41803000022',
        'ios_master_secret' =>'wgyklqy5uu8dacj9yartpic9xmpkezs4',
    ),
);
//推送通知的后续行为必填值
$config['AFTER_APP'] = array(
    0=>"go_app",
    1=>"go_url",
    2=>"go_activity",
    3=>"go_custom",
);

$config['ADV_VIDEO'] = array(
    'name' => array(
        '0' => '酒楼宣传片',
        '1' => '酒楼片源',
    ),
    'num' => '6',
);
$config['ADVE_OCCU'] = array(
    'name' => '广告位',
    'num' => '50',
);
$config['RTBADVE_OCCU'] = array(
    'name' => 'RTB广告位',
    'num' => '18',
);
$config['TOU_STATE'] = array(
    '0'=>'全部',
    '1'=>'未到投放时间',
    '3'=>'投放完毕',
    '4'=>'不可投放',
    '2'=>'投放中',
);
$config['USER_GRP_CONFIG'] = array(
    '0'=>'无',
    '1'=>'运维组',
);

$config['OPTION_USER_ROLE_ARR']  = ARRAY(
     '1'=>'发布者', 
     '2'=>'指派者',
     '3'=>'执行者',
     '4'=>'查看',
     '5'=>'外包',
     '6'=>'巡检员',
);
$config['OPTION_USER_SKILL_ARR'] = array(
    '1'=>'信息检测',
    '8'=>'网络改造',
    '2'=>'安装验收',
    '4'=>'维修',
);


$config['HOTEL_DAMAGE_CONFIG'] = array(
    '1'=>'电源适配器',
    '2'=>'SD卡',
    '3'=>'HDMI线',
    '4'=>'信号源错误',
    '5'=>'5G路由器',
    '6'=>'遥控器',
    '7'=>'红外遥控头',
    '8'=>'机顶盒',
    '9'=>'小平台',
    '10'=>'酒楼WIFI',
    '11'=>'酒楼电视机',
	'12'=>'未开机',
    '13'=>'其它',
);
$config['PUB_ADS_HOTEL_ERROR'] = array(
    '1'=>'剩余广告位不足',
    '2'=>'酒楼冻结',
    '3'=>'酒楼报损',
    '4'=>'包间冻结',
    '5'=>'包间报损',
    '6'=>'机顶盒冻结',
    '7'=>'机顶盒报损',
    '8'=>'包间机顶盒为空',
);
$config['ROOM_TYPE'] = array(
    1=>'包间',
    2=>'大厅',
    3=>'等候区'
);
$config['HEART_LOG_SAVE_DAYS'] = 30;
$config['CONFIG_VOLUME'] = array(
    'system_ad_volume'=>'广告音量',
    'system_pro_screen_volume'=>'投屏音量',
    'system_demand_video_volume'=>'点播音量',
    'system_tv_volume'=>'电视音量'
);
$config['PROGRAM_ADS_CACHE_PRE'] = 'program_ads_';

$config['UPD_STR'] = array(
    1=>array(
        'ename'=>'get_channel',
        'cname'=>'导出电视节目列表',
    ),
    2=>array(
        'ename'=>'update_logo',
        'cname'=>'上传酒楼LOGO',
    ),
    3=>array(
        'ename'=>'set_channel',
        'cname'=>'更新电视节目列表',
    ),
    4=>array(
        'ename'=>'get_log',
        'cname'=>'导出开机率日志',
    ),
    5=>array(
        'ename'=>'get_loged',
        'cname'=>'导出备份开机率日志',
    ),
    6=>array(
        'ename'=>'update_media',
        'cname'=>'更新广告视频',
    ),
    7=>array(
        'ename'=>'update_apk',
        'cname'=>'更新客户端APK',
    ),
);
return $config;
