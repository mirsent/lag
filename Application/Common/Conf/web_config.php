<?php
return array(
    'TITLE' => '像游管理系统',

    /*认证相关*/
    'USER_AUTH_KEY' => 'lag', // 用户认证SESSION标记
    'USER_AUTH_GATEWAY' => 'Public/login', // 默认认证网关

    /*状态*/
    'STATUS_N' => 0, // 删除状态
    'STATUS_Y' => 1, // 正常状态
    'STATUS_B' => 2, // 禁用状态

    /*任务状态*/
    'TASK_I' => 1, // 进行中
    'TASK_F' => 2, // 已完成

    /*日志类型*/
    'LOG_P' => 1, // 项目记录
    'LOG_T' => 2, // 任务记录

    'WX_CONFIG' => array(
        'APPID'      => 'wx4af7990f8faed2af',
        'APPSECRET'  => 'bf678846c87c828fe51f008ffd716baa',
        'MCHID'      => '',
        'KEY'        => '',
        'NOTIFY_URL' => '',
        'money'      => 1
    ),

);
