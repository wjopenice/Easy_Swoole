<?php
return [
    'SERVER_NAME' => "EasySwoole",
    'MAIN_SERVER' => [
        'LISTEN_ADDRESS' => '0.0.0.0',
        'PORT' => 9501,
        'SERVER_TYPE' => EASYSWOOLE_WEB_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER
        'SOCK_TYPE' => SWOOLE_TCP,
        'RUN_MODEL' => SWOOLE_PROCESS,
        'SETTING' => [
            'worker_num' => 8,
            'reload_async' => true,
            'max_wait_time'=>3
        ],
        'TASK'=>[
            'workerNum'=>4,
            'maxRunningNum'=>128,
            'timeout'=>15
        ]
    ],
    'TEMP_DIR' => null,
    'LOG_DIR' => null,
    // 添加 MySQL 及对应的连接池配置
    /*################ MYSQL CONFIG ##################*/
    'MYSQL' => [
        'host'          => '127.0.0.1', // 数据库地址
        'port'          => '3306', // 数据库端口
        'user'          => 'root', // 数据库用户名
        'timeout'       => '5', // 数据库连接超时时间
        'charset'       => 'utf8mb4', // 数据库字符编码
        'password'      => '12345678', // 数据库用户密码
        'database'      => 'cry', // 数据库名
        'POOL_MAX_NUM'  => '20', // 数据库连接池 最大连接池数量
        'POOL_TIME_OUT' => '0.1', // 数据库连接池 超时时间
    ],

    // 添加 Redis 及对应的连接池配置
    /*################ REDIS CONFIG ##################*/
    'REDIS' => [
        'host'          => '127.0.0.1', // Redis地址
        'port'          => '6379', // Redis端口
        'auth'          => '', // Redis密码
        'POOL_MAX_NUM'  => '20', // Redis连接池 最大连接池数量
        'POOL_MIN_NUM'  => '5', // Redis连接池 最小连接池数量
        'POOL_TIME_OUT' => '0.1', // Redis连接池 连接超时时间
    ]

];
