<?php
return array(
	//'配置项'=>'配置值'
    'DEFAULT_MODULE'     => 'Admin',
    'URL_ROUTER_ON'   => true,

     'TMPL_PARSE_STRING' => array(
//         '__UPLOADS__' => __ROOT__ . '/Uploads',
//         '__DEFAULT__'=>__ROOT__.'/Public', //默认显示的图片
//         '__ROOT__'  =>   'http://jingying.vipshangbao.com/',
            '__ROOT__' => "http://".$_SERVER['HTTP_HOST'],
            '__PUBLIC__' => "http://".$_SERVER['HTTP_HOST'] . '/Public',
            '__APP__' => "http://".$_SERVER['HTTP_HOST'],
//         '__APP__'  =>   'http://jingying.vipshangbao.com/index'
     ),
    // 'TMPL_PARSE_STRING' => array(
    //     '__UPLOADS__' => __ROOT__ . '/Uploads',
    //     '__DEFAULT__'=>__ROOT__.'/Public', //默认显示的图片
    //     '__VENDOR__' =>__ROOT__ . '/Public/Vendor',
    // ),
    // 
    //'TAGLIB_PRE_LOAD' => 'c', //加载自定义标签库

//    'APP_SUB_DOMAIN_DEPLOY'   =>    1, // 开启子域名或者IP配置
//    'APP_SUB_DOMAIN_RULES'    =>    array(
//        'admin.nb.com'  => 'Admin',  // admin.domain1.com域名指向Admin模块
//        'api.nb.com'   => 'Api',  // test.domain2.com域名指向Test模块
//        'www.nb.com' =>'Home'
//    ),

    'COOKIE_EXPIRE'=>3600*24*30, //cooike 保存时间1个月
    /* 系统数据加密设置 */
    'UID_KEY' =>'xr%3Ci>[L?u2b}asdmscdosnR0"sXzoR0&AM^UjJe',//uid加密密钥,默认
    'DATA_AUTH_KEY' => 'xr%3Ci>[L?u2b}7;p~ED1hmWN"sXzoR0&AM^UjJe', //默认数据加密KEY
    'URL_KEY' =>'xr%3Ci>[L?u2b}sXzoR0"sXzoR0&AM^UjJe',//默认URL加密密钥
    'URL_MODEL'=>'2',
    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID
    // 添加数据库配置信息
   /*'DB_TYPE' => 'mysql', // 数据库类型
   'DB_HOST' => 'rm-2ze0b8em5wuuc8h59.mysql.rds.aliyuncs.com', // 服务器地址
   'DB_NAME' => 'jingxin', // 数据库名
   'DB_USER' => 'jxkj_jingxinuser', // 用户名
   'DB_PWD' => 'iHBUB7J5POCvdWrY', // 密码
   'DB_PORT' => 3306, // 端口*/

//    'DB_TYPE' => 'mysql', // 数据库类型
//    'DB_HOST' => '115.238.39.252', // 服务器地址
//    'DB_NAME' => 'jingxin_b', // 数据库名
//    'DB_USER' => 'jxkj_test', // 用户名
//    'DB_PWD' => 'Trasin88480580', // 密码
//    'DB_PORT' => 3306, // 端口

//本地环境
      'DB_TYPE' => 'mysql', // 数据库类型
      'DB_HOST' => '127.0.0.1', // 服务器地址
      'DB_NAME' => 'jingxin_dev', // 数据库名
      'DB_USER' => 'root', // 用户名
      'DB_PWD' => '123456', // 密码
      'DB_PORT' => 3306, // 端口

//私有服务器环境
/*    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'jingxin', // 数据库名
    'DB_USER' => 'jingxin', // 用户名
    'DB_PWD' => 'mxFH45FBnCDexLS7', // 密码
    'DB_PORT' => 3306, // 端口*/

    //爱瑞迪服务器
    /*'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'jingxin', // 数据库名
    'DB_USER' => 'root12', // 用户名
    'DB_PWD' => 'liyangheihei', // 密码
    'DB_PORT' => 3306, // 端口*/



    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'jingxin_', //session前缀
    'COOKIE_PREFIX'  => 'jingxin_', // Cookie前缀 避免冲突
    'VAR_SESSION_ID' => 'session_id',	//修复uploadify插件无法传递session_id的bug
    'SESSION_OPTIONS' => array('use_trans_sid'=>1,'use_only_cookies'=>0),

    'USER_AUTH_ON'              =>  true,
    'USER_AUTH_TYPE'=>  1,      // 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY'             =>  'authId',// 用户认证SESSION标记
    'ADMIN_AUTH_KEY'=>  'administrator',
    'USER_AUTH_MODEL'           =>  'User',// 默认验证数据表模型，如果用户表名称不是User的话自己改
    'AUTH_PWD_ENCODER'          =>  'md5',// 用户认证密码加密方式
    'USER_AUTH_GATEWAY'         =>  '/Public/login',// 默认认证网关
    'NOT_AUTH_MODULE'           =>  'Public',// 默认无需认证模块
    'REQUIRE_AUTH_MODULE'       =>  '',// 默认需要认证模块
    'NOT_AUTH_ACTION'           =>  '',// 默认无需认证操作
    'REQUIRE_AUTH_ACTION'       =>  '',// 默认需要认证操作
    'GUEST_AUTH_ON'             =>  false,    // 是否开启游客授权访问
    'GUEST_AUTH_ID'             =>  0,        // 游客的用户ID
    'DB_LIKE_FIELDS'            =>  'title|remark',
    'RBAC_ROLE_TABLE'           =>  'think_role',
    'RBAC_USER_TABLE'           =>  'think_role_user',
    'RBAC_ACCESS_TABLE'         =>  'think_access',
    'RBAC_NODE_TABLE'           =>  'think_node'






);