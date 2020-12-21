<?php
return [
    'userid' => 1646945885, //需要爬取的微博用户ID
    'pic_downloader_sleep' => 3, //每请求一张图片休眠秒数
    'total' => 361, //总微博条数
    'per' => 20, //接口每页返回20条微博
    //图片保存到一个文件,还是根据每条微博的ID单独新建文件夹保存
    'pic'=> [
        'one_dir' => true,
        'path'=> 'img/' //图片文件夹路径
    ],

    //请求头 里面包含cookie
    'header' => [
        'accept: application/json, text/plain, */*',
        'accept-language: zh-CN,zh;q=0.9',
        'cookie: YOUR COOKIE',
        'referer: https://weibo.com/u/1646945885?tabtype=feed',
        'sec-ch-ua: "Google Chrome";v="87", " Not;A Brand";v="99", "Chromium";v="87"',
        'sec-ch-ua-mobile: ?0',
        'sec-fetch-dest: empty',
        'sec-fetch-mode: cors',
        'sec-fetch-site: same-origin',
        'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36',
        'x-requested-with: XMLHttpRequest',
        'x-xsrf-token: YOUR TOKEN'
    ],

    //数据库配置
    'database' => [
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'pwd' => 'root',
        'dbname' => 'weibo',
        'charset' => 'utf8mb4'
    ],
];
