<?php
$DB_MASTER_HOST = 'rm-m5e5ujb814xuex9v6.mysql.rds.aliyuncs.com';
$DB_SLAVE_HOST  = 'rm-m5e5ujb814xuex9v6.mysql.rds.aliyuncs.com';
$db_name = 'savor_duo';
$db_user = 'php_admin';
$db_pwd = 'php_admin_api';

//redis缓存配置
$redis['db1']['0']['host'] = '';
$redis['db1']['0']['port'] = '';
$redis['db1']['0']['isMaster'] = '1';
$redis['db1']['1']['host'] = ''; 
$redis['db1']['1']['port'] = '';
$redis['db1']['1']['isMaster'] = '0';

$config_db =  array(
	'DB_DEPLOY_TYPE' => 1, //数据库主从支�?
    'DB_RW_SEPARATE' => true, //读写分离
    'DB_TYPE' => 'mysql',
    'DB_HOST' => "$DB_MASTER_HOST,$DB_SLAVE_HOST",
    'DB_NAME' => $db_name,
    'DB_USER' => $db_user,
    'DB_PWD' => $db_pwd,
    'DB_PORT' => 3306,
    'DB_CHARSET' => 'UTF8',
    'DB_PREFIX' => 'savor_',
    'DB_DEBUG'  =>  TRUE,

 	'REDIS_CONFIG' => $redis,
    
    //OSSS上传配置
	'OSS_ACCESS_ID'   => 'tnDh4AQqRYbV9mq8',
	'OSS_ACCESS_KEY'  => 'sv8aZCKEJhQ0nwKHj8uEnw3ADwcM24',
	'OSS_HOST'    => 'oss-cn-beijing.aliyuncs.com',  //ע�ⲻҪ��ǰ��� http://
	'OSS_BUCKET' => 'redian-development',                     //��Դ�ռ�,��Ͱ
	'OSS_SYNC_CALLBACK_URL'=>'alioss/syncNotify', //�ϴ��첽�ص���ַ
        //end
);
return $config_db;


